<?php
class History extends Controller
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
        header('location:' . URLROOT . '/history/all');
    }

    public function all()
    {
        $idtaikhoan = Session::get('user_id');
        $history = $this->BookingModel->getBookingHistoryByStatus($idtaikhoan);

        if ($this->isAjaxRequest()) {
            ob_start();
            extract(['list_booking' => $this->getInforBooking($history)]);
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
            $this->view('user', 'history.php', [
                'page' => 'list_booking.php',
                'list_booking' => $this->getInforBooking($history)
            ]);
        }
    }

    public function checkoutLounge()
    {
        $idtaikhoan = Session::get('user_id');
        $booking = $this->BookingModel->getBookingHistoryByStatus($idtaikhoan, 'Đã cọc tiền');

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

            $this->view('user', 'history.php', [
                'page' => 'list_booking.php',
                'list_booking' => $this->getInforBooking($booking)
            ]);
        }
    }

    public function paidBooking()
    {
        $idtaikhoan = Session::get('user_id');
        $booking = $this->BookingModel->getBookingHistoryByStatus($idtaikhoan, 'Đã thanh toán');

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

            $this->view('user', 'history.php', [
                'page' => 'list_booking.php',
                'list_booking' => $this->getInforBooking($booking)
            ]);
        }
    }

    public function booked()
    {
        $idtaikhoan = Session::get('user_id');
        $booking = $this->BookingModel->getBookingHistoryByStatus($idtaikhoan, 'Hoàn tất');

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

            $this->view('user', 'history.php', [
                'page' => 'list_booking.php',
                'list_booking' => $this->getInforBooking($booking)
            ]);
        }
    }


    public function canceledBooking()
    {
        $idtaikhoan = Session::get('user_id');
        $booking = $this->BookingModel->getBookingHistoryByStatus($idtaikhoan, 'Đã Hủy');

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

            $this->view('user', 'history.php', [
                'page' => 'list_booking.php',
                'list_booking' => $this->getInforBooking($booking)
            ]);
        }
    }


    public function getInforBooking($history)
    {
        if ($history) {
            foreach ($history as $key => $item) {

                $Room =  $this->RoomModel->findRoomById($item['id_phong']);

                foreach ($Room as $room) {

                    $nameBed = $this->RoomModel->getNameBed($room['idphong']);
                    $history[$key]['tengiuong'] = $nameBed;

                    $promotion = $this->RoomModel->getPromotionRoom($room['idphong']);
                    $history[$key]['khuyenmai'] = $promotion;

                    $mainImg = $this->RoomModel->getMainImageRoom($room['idphong']);
                    $history[$key]['anhphong'] = $mainImg;

                    $paymentMethod = $this->RoomModel->findPaymentMethod($room['idphong']);
                    $history[$key]['loaihinhtt'] = implode(" & ", array_column($paymentMethod, 'loaihinhthanhtoan'));

                    $history[$key]['tenphong'] = $room['tenphong'];
                    $history[$key]['giaphong'] = $room['giaphong'];
                }

                if (empty($item['ngayden']) || empty($item['ngaydi'])) {
                    $soNgay = 0;
                } else {
                    $ngaydentmp = new DateTime($item['ngayden']);
                    $ngayditmp = new DateTime($item['ngaydi']);
                    $soNgay = intval($ngayditmp->diff($ngaydentmp)->format('%a'));
                }
                $history[$key]['songay'] = $soNgay;
            }
        } else {
            $history = null;
        }

        return $history;
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
                    window.location.href = '" . URLROOT . "/history/all';
                    </script>";
                    exit();
                }
            } else {
                echo "<script> alert('Lỗi');
                window.location.href = '" . URLROOT . "/history/all';
                </script>";
                exit();
            }
        }
        header('location:' . URLROOT . '/history/all');
    }
}
