<?php
class Invoice extends Controller
{
    private $BookingModel;
    private $RoomModel;

    public function __construct()
    {
        $this->BookingModel = $this->model('BookingModel');
        $this->RoomModel = $this->model('RoomModel');
    }

    public function index()
    {
        if (isset($_POST['invoice'])) {
            session_unset();
            Session::set('iddondat', $_POST['invoice'], 900);
        }
        if (isset($_POST['detail'])) {
            Session::set('iddondat', $_POST['detail'], 900);
        }
        header('location:' . URLROOT . '/invoice/all');
    }

    public function all()
    {
        $iddondat = Session::get('iddondat');
        if ($iddondat) {
            $invoice = $this->BookingModel->getBookingInvoiceByStatus($iddondat);
            if ($this->isAjaxRequest()) {
                ob_start();
                extract(['list_booking' => $this->getInforBooking($invoice)]);
                require_once APPROOT . '/views/user/pages/list_booking.php';
                $page = ob_get_clean();

                $response = [
                    'page' => $page
                ];

                // Trả về dữ liệu dưới dạng JSON
                header('Content-Type: application/json');
                echo json_encode($response);
                exit;
            } else {
                $this->view('user', 'invoice.php', [
                    'page' => 'list_booking.php',
                    'list_booking' => $this->getInforBooking($invoice)
                ]);
            }
        }
        header('location:' . URLROOT . '/home');
    }

    public function checkoutLounge()
    {
        $iddondat = Session::get('iddondat');
        if ($iddondat) {
            $booking = $this->BookingModel->getBookingInvoiceByStatus($iddondat, 'Đã cọc tiền');
            if ($this->isAjaxRequest()) {
                ob_start();
                extract(['list_booking' => $this->getInforBooking($booking)]);
                require_once APPROOT . '/views/user/pages/list_booking.php';
                $page = ob_get_clean();

                $response = [
                    'page' => $page
                ];

                // Trả về dữ liệu dưới dạng JSON
                header('Content-Type: application/json');
                echo json_encode($response);
                exit;
            } else {

                $this->view('user', 'invoice.php', [
                    'page' => 'list_booking.php',
                    'list_booking' => $this->getInforBooking($booking)
                ]);
            }
        }
        header('location:' . URLROOT . '/home');
    }

    public function paidBooking()
    {
        $iddondat = Session::get('iddondat');
        if ($iddondat) {
            $booking = $this->BookingModel->getBookingInvoiceByStatus($iddondat, 'Đã thanh toán');
            if ($this->isAjaxRequest()) {
                ob_start();
                extract(['list_booking' => $this->getInforBooking($booking)]);
                require_once APPROOT . '/views/user/pages/list_booking.php';
                $page = ob_get_clean();

                $response = [
                    'page' => $page
                ];

                // Trả về dữ liệu dưới dạng JSON
                header('Content-Type: application/json');
                echo json_encode($response);
                exit;
            } else {

                $this->view('user', 'invoice.php', [
                    'page' => 'list_booking.php',
                    'list_booking' => $this->getInforBooking($booking)
                ]);
            }
        }
        header('location:' . URLROOT . '/home');
    }

    public function booked()
    {
        $iddondat = Session::get('iddondat');
        if ($iddondat) {
            $booking = $this->BookingModel->getBookingInvoiceByStatus($iddondat, 'Hoàn tất');

            if ($this->isAjaxRequest()) {
                ob_start();
                extract(['list_booking' => $this->getInforBooking($booking)]);
                require_once APPROOT . '/views/user/pages/list_booking.php';
                $page = ob_get_clean();

                $response = [
                    'page' => $page
                ];

                // Trả về dữ liệu dưới dạng JSON
                header('Content-Type: application/json');
                echo json_encode($response);
                exit;
            } else {

                $this->view('user', 'invoice.php', [
                    'page' => 'list_booking.php',
                    'list_booking' => $this->getInforBooking($booking)
                ]);
            }
        }
        header('location:' . URLROOT . '/home');
    }

    public function canceledBooking()
    {
        $iddondat = Session::get('iddondat');
        if ($iddondat) {
            $booking = $this->BookingModel->getBookingInvoiceByStatus($iddondat, 'Đã Hủy');

            if ($this->isAjaxRequest()) {
                ob_start();
                extract(['list_booking' => $this->getInforBooking($booking)]);
                require_once APPROOT . '/views/user/pages/list_booking.php';
                $page = ob_get_clean();

                $response = [
                    'page' => $page
                ];

                // Trả về dữ liệu dưới dạng JSON
                header('Content-Type: application/json');
                echo json_encode($response);
                exit;
            } else {

                $this->view('user', 'invoice.php', [
                    'page' => 'list_booking.php',
                    'list_booking' => $this->getInforBooking($booking)
                ]);
            }
        }
        header('location:' . URLROOT . '/home');
    }


    public function getInforBooking($invoice)
    {
        if ($invoice) {
            foreach ($invoice as $key => $item) {

                $Room =  $this->RoomModel->findRoomById($item['id_phong']);

                foreach ($Room as $room) {

                    $nameBed = $this->RoomModel->getNameBed($room['idphong']);
                    $invoice[$key]['tengiuong'] = $nameBed;

                    $promotion = $this->RoomModel->getPromotionRoom($room['idphong']);
                    $invoice[$key]['khuyenmai'] = $promotion;

                    $mainImg = $this->RoomModel->getMainImageRoom($room['idphong']);
                    $invoice[$key]['anhphong'] = $mainImg;

                    $paymentMethod = $this->RoomModel->findPaymentMethod($room['idphong']);
                    $invoice[$key]['loaihinhtt'] = implode(" & ", array_column($paymentMethod, 'loaihinhthanhtoan'));

                    $invoice[$key]['tenphong'] = $room['tenphong'];
                    $invoice[$key]['giaphong'] = $room['giaphong'];
                }

                if (empty($item['ngayden']) || empty($item['ngaydi'])) {
                    $soNgay = 0;
                } else {
                    $ngaydentmp = new DateTime($item['ngayden']);
                    $ngayditmp = new DateTime($item['ngaydi']);
                    $soNgay = intval($ngayditmp->diff($ngaydentmp)->format('%a'));
                }
                $invoice[$key]['songay'] = $soNgay;
                $invoice[$key]['invoice'] = 'invoice';
            }
        } else {
            $invoice = null;
        }

        return $invoice;
    }


    public function cancelRoom()
    {
        if (isset($_POST['cancel'])) {
            if ($this->BookingModel->updateCancelInvoiceRoom($_POST['iddondat'], $_POST['iddatphong'], $_POST['trangthaidon'], $_POST['soluonghuy'])) {
                $booking = $this->BookingModel->getInvoiceBookingById($_POST['iddondat']);
                $email = $this->BookingModel->getEmailCustommerByInvoice($_POST['iddondat']);
                $mail = new Mail();
                if ($mail->sendMailCancelRoom($email, 'Thông báo hủy đặt phòng!', $this->getInforBooking($booking))) {
                    echo "<script> alert('Hủy phòng thành công!');
                    window.location.href = '" . URLROOT . "/invoice/all';
                    </script>";
                    exit();
                }
            } else {
                echo "<script> alert('Lỗi');
                window.location.href = '" . URLROOT . "/invoice/all';
                </script>";
                exit();
            }
        }
        header('location:' . URLROOT . '/invoice/all');
    }
}
