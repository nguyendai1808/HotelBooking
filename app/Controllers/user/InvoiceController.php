<?php
class Invoice extends Controller
{
    private $BookingModel;
    private $RoomModel;
    private $RatingModel;
    private $AccountModel;

    public function __construct()
    {
        $this->BookingModel = $this->model('BookingModel');
        $this->RoomModel = $this->model('RoomModel');
        $this->RatingModel = $this->model('RatingModel');
        $this->AccountModel = $this->model('AccountModel');
    }

    public function index()
    {
        if (isset($_POST['invoice'])) {
            $account = $this->AccountModel->getIdAccountByEmail($_POST['email']);
            if ($account == Session::get('user_id')) {
                Session::set('user_id', $account);
            } else {
                session_unset();
            }
            Session::set('iddondat', $_POST['invoice'], 1800);
        }

        if (isset($_POST['detail'])) {
            Session::set('iddondat', $_POST['detail'], 1800);
        }

        if (Session::get('iddondat')) {
            header('location:' . URLROOT . '/invoice/all');
        } else {
            header('location:' . URLROOT . '/room');
        }
    }

    public function all()
    {
        $iddondat = Session::get('iddondat');
        if ($iddondat) {
            $invoice = $this->BookingModel->getBookingInvoiceByStatus($iddondat);
            $rating = $this->RatingModel->getCriteria();
            if ($this->isAjaxRequest()) {
                ob_start();
                extract([
                    'list_booking' => $this->getInfoBooking($invoice),
                    'rating' => $rating
                ]);
                require_once APPROOT . '/views/user/pages/list_booking.php';
                require_once APPROOT . '/views/user/pages/rating.php';
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
                    'list_booking' => $this->getInfoBooking($invoice),
                    'rating' => $rating
                ]);
            }
        } else {
            header('location:' . URLROOT . '/invoice');
        }
    }

    public function checkoutLounge()
    {
        $iddondat = Session::get('iddondat');
        if ($iddondat) {
            $booking = $this->BookingModel->getBookingInvoiceByStatus($iddondat, 'Đã cọc tiền');
            if ($this->isAjaxRequest()) {
                ob_start();
                extract(['list_booking' => $this->getInfoBooking($booking)]);
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
                    'list_booking' => $this->getInfoBooking($booking)
                ]);
            }
        } else {
            header('location:' . URLROOT . '/invoice');
        }
    }

    public function paidBooking()
    {
        $iddondat = Session::get('iddondat');
        if ($iddondat) {
            $booking = $this->BookingModel->getBookingInvoiceByStatus($iddondat, 'Đã thanh toán');
            if ($this->isAjaxRequest()) {
                ob_start();
                extract(['list_booking' => $this->getInfoBooking($booking)]);
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
                    'list_booking' => $this->getInfoBooking($booking)
                ]);
            }
        } else {
            header('location:' . URLROOT . '/invoice');
        }
    }

    public function booked()
    {
        $iddondat = Session::get('iddondat');
        if ($iddondat) {
            $booking = $this->BookingModel->getBookingInvoiceByStatus($iddondat, 'Hoàn tất, Đã đánh giá');
            $rating = $this->RatingModel->getCriteria();
            if ($this->isAjaxRequest()) {
                ob_start();
                extract([
                    'list_booking' => $this->getInfoBooking($booking),
                    'rating' => $rating
                ]);
                require_once APPROOT . '/views/user/pages/list_booking.php';
                require_once APPROOT . '/views/user/pages/rating.php';
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
                    'list_booking' => $this->getInfoBooking($booking),
                    'rating' => $rating
                ]);
            }
        } else {
            header('location:' . URLROOT . '/invoice');
        }
    }

    public function canceledBooking()
    {
        $iddondat = Session::get('iddondat');
        if ($iddondat) {
            $booking = $this->BookingModel->getBookingInvoiceByStatus($iddondat, 'Đã hủy');
            if ($this->isAjaxRequest()) {
                ob_start();
                extract(['list_booking' => $this->getInfoBooking($booking)]);
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
                    'list_booking' => $this->getInfoBooking($booking)
                ]);
            }
        } else {
            header('location:' . URLROOT . '/invoice');
        }
    }

    public function getInfoBooking($invoice)
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
                    if ($paymentMethod) {
                        $invoice[$key]['loaihinhtt'] = implode(" & ", array_column($paymentMethod, 'loaihinhthanhtoan'));
                    }

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
}
