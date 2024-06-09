<?php
class Payment extends Controller
{
    private $AccountModel;
    private $RoomModel;
    private $BookingModel;
    private $CustomerModel;
    private $PaymentModel;

    public function __construct()
    {
        $this->AccountModel = $this->model('AccountModel');
        $this->RoomModel = $this->model('RoomModel');
        $this->BookingModel = $this->model('BookingModel');
        $this->CustomerModel = $this->model('CustomerModel');
        $this->PaymentModel = $this->model('PaymentModel');
    }

    public function index()
    {
        if (isset($_POST['change-date'])) {
            $checkin = isset($_POST['arrival']) ? $_POST['arrival'] : '';
            $checkout = isset($_POST['departure']) ? $_POST['departure'] : '';

            Session::set('checkin', $checkin);
            Session::set('checkout', $checkout);

            $idphong = $_POST['idphong'];
            $soluongdat = 1;

            $ngaydentmp = new DateTime($checkin);
            $ngayditmp = new DateTime($checkout);
            $songay = intval($ngayditmp->diff($ngaydentmp)->format('%a'));

            $Booking = $this->RoomModel->findRoomById($idphong);
            $giaphong = $Booking[0]['giaphong'];
            $tonggia = $songay * intval($giaphong) * $soluongdat;

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
        }

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
        }

        if (isset($_POST['iddatphong'])) {

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
                'phone' => isset($_POST['phone']) ? $_POST['phone'] : '',
                'address' => isset($_POST['address']) ? $_POST['address'] : ''
            ];

            Session::set('customer', $customer);
        } else {
            header('location:' . URLROOT . '/room');
        }
    }

    public function resultPayment()
    {
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            $vnp_ResponseCode = $_GET['vnp_ResponseCode'];
            if ($vnp_ResponseCode == '00') {

                $customer = Session::get('customer') ?? [];
                $booking = Session::get('booking') ?? [];

                if (count($customer) > 0 && count($booking) > 0) {
                    $iddondat = $_GET['vnp_TxnRef'];
                    $sotien = intval($_GET['vnp_Amount']) / 100;

                    $mail = new Mail();
                    if ($mail->sendMailBooking($customer['email'], 'HotelBooking xin chào!', $customer, $booking, $iddondat, $sotien)) {

                        $idkhachhang =  $this->CustomerModel->findCustomer($customer['fullname'], $customer['email'], $customer['phone'], $customer['address']);
                        if (empty($idkhachhang)) {
                            $this->CustomerModel->createCustomer($customer['fullname'], $customer['email'], $customer['phone'], $customer['address']);
                            $idkhachhang =  $this->CustomerModel->findCustomer($customer['fullname'], $customer['email'], $customer['phone'], $customer['address']);
                        }

                        $idtaikhoan = Session::get('user_id') ?? null;
                        $tongsotien = 0;
                        foreach ($booking as $item) {
                            $tongsotien += intval($item['tonggia']);
                        }

                        if (($tongsotien - $sotien) > 0) {
                            $trangthaidon = 'Đã cọc tiền';
                            $sotiencoc = $sotien;
                            $sotienconthieu = ($tongsotien - $sotien);
                        } else {
                            $trangthaidon = 'Đã thanh toán';
                            $sotiencoc = 0;
                            $sotienconthieu = 0;
                        }
                        $thoigiandat =  date("Y-m-d H:i:s");
                        $this->BookingModel->createInvoice($iddondat, $trangthaidon, $tongsotien, $sotiencoc, $sotienconthieu, $thoigiandat);

                        foreach ($booking as $item) {
                            if (isset($item['iddatphong'])) {
                                $this->BookingModel->updateIdInvoice($item['iddatphong'], $iddondat, $trangthaidon);
                            } else {
                                $this->BookingModel->createBooking($item['ngayden'], $item['ngaydi'], $item['soluongdat'],  $item['tonggia'], $trangthaidon, $item['idphong'], $iddondat, $idtaikhoan);
                            }
                        }
                        $kieuthantoan = "Thanh toán qua VNPAY";
                        $this->PaymentModel->createPayment($thoigiandat, $sotien, $kieuthantoan, $iddondat, $idkhachhang);

                        $this->view('user', 'payment_success.php');
                    } else {
                        echo "<script> alert('Giao dịch thất bại');
                        window.location.href = '" . URLROOT . "/room';
                        </script>";
                        exit;
                    };
                } else {
                    echo "<script> alert('Giao dịch thất bại');
                        window.location.href = '" . URLROOT . "/room';
                        </script>";
                    exit;
                };
            } else {
                echo "<script> alert('Giao dịch thất bại');
                    window.location.href = '" . URLROOT . "/room';
                </script>";
            }
        } else {
            header('location:' . URLROOT . '/room');
        }
        Session::delete('customer');
        Session::delete('booking');
    }
}
