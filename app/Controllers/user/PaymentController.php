<?php
class Payment extends Controller
{
    private $AccountModel;
    private $RoomModel;
    private $BookingModel;
    private $BookingInvoiceModel;
    private $CustomerModel;
    private $PaymentModel;

    public function __construct()
    {
        $this->AccountModel = $this->model('Accounts');
        $this->RoomModel = $this->model('Rooms');
        $this->BookingModel = $this->model('Bookings');
        $this->BookingInvoiceModel = $this->model('BookingInvoices');
        $this->CustomerModel = $this->model('Customers');
        $this->PaymentModel = $this->model('Payments');
    }

    public function index()
    {
        if (isset($_POST['booknow'])) {

            $idphong = intval($_POST['idphong']);
            $giaphong = intval($_POST['giaphong']);
            $soluongdat = isset($_POST['soluongdat']) ? intval($_POST['soluongdat']) : 1;

            $checkin = Session::get('checkin');
            $checkout = Session::get('checkout');

            $ngaydentmp = new DateTime($checkin);
            $ngayditmp = new DateTime($checkout);
            $songay = intval($ngayditmp->diff($ngaydentmp)->format('%a'));

            $tonggia = $songay * $giaphong * $soluongdat;

            $Booking = $this->RoomModel->findRoomById($idphong);

            if (!empty($Booking) && is_array($Booking)) {
                $Booking[0]['ngayden'] = $checkin;
                $Booking[0]['ngaydi'] = $checkout;
                $Booking[0]['soluongdat'] = $soluongdat;
                $Booking[0]['songay'] = $songay;
                $Booking[0]['tonggia'] = $tonggia;
            }

            $account = null;
            if (!empty(Session::get('user_id'))) {
                $account = $this->AccountModel->findAccountById(Session::get('user_id'));
            }

            $this->view('user', 'payment.php', [
                'account' => $account,
                'booking' => $this->getRoomMore($Booking)
            ]);
        } elseif (isset($_POST['iddatphong'])) {

            $ArrayId = $_POST['iddatphong'];
            $Booking = [];

            foreach ($ArrayId as $iddatphong) {
                $booking = $this->BookingModel->findBookingById($iddatphong);

                foreach ($booking as $item) {
                    $ngaydentmp = new DateTime($item['ngayden']);
                    $ngayditmp = new DateTime($item['ngaydi']);
                    $songay = intval($ngayditmp->diff($ngaydentmp)->format('%a'));

                    $Booking[] = [
                        'iddatphong' => $item['iddatphong'],
                        'ngayden' => $item['ngayden'],
                        'ngaydi' => $item['ngaydi'],
                        'soluongdat' => $item['soluongdat'],
                        'songay' => $songay,
                        'tonggia' => $item['tonggia'],
                        'id_phong' => $item['id_phong']
                    ];
                }
            }

            for ($i = 0; $i < count($Booking); $i++) {

                $Room = $this->RoomModel->findRoomById($Booking[$i]['id_phong']);
                if (!empty($Room[0]) && is_array($Room[0])) {
                    $Booking[$i]['idphong'] = $Room[0]['idphong'];
                    $Booking[$i]['tenphong'] = $Room[0]['tenphong'];
                    $Booking[$i]['giaphong'] = $Room[0]['giaphong'];
                }
            }

            $account = null;
            if (!empty(Session::get('user_id'))) {
                $account = $this->AccountModel->findAccountById(Session::get('user_id'));
            }

            $this->view('user', 'payment.php', [
                'account' => $account,
                'booking' => $this->getRoomMore($Booking)
            ]);
        } else {

            header('location:' . URLROOT . '/room');
        }
    }

    public function getRoomMore($Rooms)
    {
        foreach ($Rooms as $key => $room) {
            $promotion = $this->RoomModel->getPromotionRoom($room['idphong']);
            $Rooms[$key]['khuyenmai'] = $promotion;

            $mainImg = $this->RoomModel->getMainImageRoom($room['idphong']);
            $Rooms[$key]['anhphong'] = $mainImg;

            $nameBed = $this->RoomModel->getNameBed($room['idphong']);
            $Rooms[$key]['tengiuong'] = $nameBed;

            $paymentMethod = $this->RoomModel->findPaymentMethod($room['idphong']);
            $Rooms[$key]['loaihinhtt'] = implode(" & ", array_column($paymentMethod, 'loaihinhthanhtoan'));
        }
        return $Rooms;
    }

    public function paynow()
    {
        if (isset($_POST['paynow'])) {

            $customer = Session::get('customer') ?? [];
            if (count($customer) > 0) {

                $payment = new PaymentVnpay;
                $order_id = time();
                $payment_method = $_POST['paynow'];
                $order_price = $_POST['tongsotien'];

                $booking =  $_POST['booking'];;
                Session::set('booking', json_decode($booking, true));

                $payment->vnpay_payment($order_id, $order_price, $payment_method);
            }
        } else {
            header('location:' . URLROOT . '/room');
        }
    }

    public function bookroom()
    {
        if (isset($_POST['bookroom'])) {

            $customer = Session::get('customer') ?? [];
            if (count($customer) > 0) {

                $payment = new PaymentVnpay;
                $order_id = time();
                $payment_method = $_POST['bookroom'];
                $order_price = $_POST['sotiendatphong'];

                $booking =  $_POST['booking'];;
                Session::set('booking', json_decode($booking, true));

                $payment->vnpay_payment($order_id, $order_price, $payment_method);
            }
        } else {
            header('location:' . URLROOT . '/room');
        }
    }

    public function saveCustomer()
    {

        if ($this->isAjaxRequest()) {
            $customer = [
                'fullname' => isset($_POST['fullname']) ? $_POST['fullname'] : '',
                'email' => isset($_POST['email']) ? $_POST['email'] : '',
                'phone' => isset($_POST['phone']) ? $_POST['phone'] : ''
            ];

            Session::set('customer', $customer);
        }
    }

    public function resultPayment()
    {
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            if (isset($_GET['vnp_ResponseCode'])) {
                $vnp_ResponseCode = $_GET['vnp_ResponseCode'];
                if ($vnp_ResponseCode == '00') {

                    $customer = Session::get('customer') ?? [];
                    if (count($customer) > 0) {

                        $idkhachhang =  $this->CustomerModel->findCustomer($customer['fullname'], $customer['email'], $customer['phone']);
                        if (empty($idkhachhang)) {
                            $this->CustomerModel->createCustomer($customer['fullname'], $customer['email'], $customer['phone']);
                            $idkhachhang =  $this->CustomerModel->findCustomer($customer['fullname'], $customer['email'], $customer['phone']);
                        }
                        
                        $booking = Session::get('booking') ?? [];
                        if (count($booking) > 0) {
                            $iddondat = $_GET['vnp_TxnRef'];
                            $sotien = intval($_GET['vnp_Amount']) / 100;
                            $idtaikhoan = Session::get('user_id') ?? null;
                            $tongsotien = 0;

                            foreach ($booking as $item) {
                                $tongsotien += intval($item['tonggia']);
                            }

                            if (($tongsotien - $sotien) > 0) {
                                $trangthaidon = 'Đã cọc tiền phòng';
                                $sotiencoc = $sotien;
                                $sotienconthieu = ($tongsotien - $sotien);
                            } else {
                                $trangthaidon = 'Thanh toán hoàn tất';
                                $sotiencoc = 0;
                                $sotienconthieu = 0;
                            }
                            $thoigiandat =  date("Y-m-d H:i:s");
                            $this->BookingInvoiceModel->createBookingInvoice($iddondat, $trangthaidon, $tongsotien, $sotiencoc, $sotienconthieu, $thoigiandat);
                                
                            foreach ($booking as $item) {
                                if (isset($item['iddatphong'])) {
                                    $this->BookingModel->updateIdBooking($item['iddatphong'], $iddondat);
                                } else {
                                    $this->BookingModel->createBooking($item['ngayden'], $item['ngaydi'], $item['soluongdat'],  $item['tonggia'],  $item['idphong'], $iddondat, $idtaikhoan);
                                }
                            }
                            $kieuthantoan = "Thanh toán qua VNPAY";
                            $this->PaymentModel->createPayment($thoigiandat, $sotien, $kieuthantoan, $iddondat, $idkhachhang);

                            $this->view('user', 'payment_success.php');
                        }
                    }
                } else {
                    echo "<script> alert('Giao dịch thất bại');
                        window.location.href = '" . URLROOT . "/room';
                    </script>";
                }
            } else {
                echo "<script> alert('Giao dịch thất bại');
                    window.location.href = '" . URLROOT . "/room';
                </script>";
            }

            Session::delete('customer');
            Session::delete('booking');
        } else {
            header('location:' . URLROOT . '/room');
        }
    }
}
