<?php
class History extends Controller
{
    private $BookingModel;
    private $RoomModel;
    private $RatingModel;
    private $pagination;
    private $per_page = 3;

    public function __construct()
    {
        $this->BookingModel = $this->model('BookingModel');
        $this->RoomModel = $this->model('RoomModel');
        $this->RatingModel = $this->model('RatingModel');

        if (Session::get('history')) {
            $totalItems = count(Session::get('history'));
            $this->pagination = new Pagination($totalItems, $this->per_page);
        } else {
            $idtaikhoan = Session::get('user_id');
            $history = $this->BookingModel->getBookingHistoryByStatus($idtaikhoan);
            if ($history) {
                $totalItems = count($history);
                $this->pagination = new Pagination($totalItems, $this->per_page);
                Session::set('history', $history, 1800);
            }
        }
    }

    public function index()
    {
        header('location:' . URLROOT . '/history/all');
    }

    public function all()
    {
        $idtaikhoan = Session::get('user_id');
        $history = $this->BookingModel->getBookingHistoryByStatus($idtaikhoan);

        if ($history) {
            $totalItems = count($history);
            $this->pagination = new Pagination($totalItems, $this->per_page);
            Session::set('history', $history, 1800);
            $list_booking = $this->pagination->getItemsbyCurrentPage($history, 1);
            $pag = [
                'total_pages' => $this->pagination->getTotalPages(),
                'current_page' => $this->pagination->getcurrentPage(),
                'view' => 'history'
            ];
            $rating = $this->RatingModel->getCriteria();
        } else {
            $list_booking = null;
            $pag = null;
            $rating = null;
        }

        if ($this->isAjaxRequest()) {
            ob_start();
            extract([
                'list_booking' => $this->getInfoBooking($list_booking),
                'rating' => $rating,
                'pagination' => $pag
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
            $this->view('user', 'history.php', [
                'list_booking' => $this->getInfoBooking($list_booking),
                'rating' => $rating,
                'pagination' => $pag
            ]);
        }
    }

    public function checkoutLounge()
    {
        $idtaikhoan = Session::get('user_id');
        $booking = $this->BookingModel->getBookingHistoryByStatus($idtaikhoan, 'Đã cọc tiền');

        if ($booking) {
            $totalItems = count($booking);
            $this->pagination = new Pagination($totalItems, $this->per_page);
            Session::set('history', $booking, 1800);
            $list_booking = $this->pagination->getItemsbyCurrentPage($booking, 1);

            $pag = [
                'total_pages' => $this->pagination->getTotalPages(),
                'current_page' => $this->pagination->getcurrentPage(),
                'view' => 'history'
            ];
        } else {
            $list_booking = null;
            $pag = null;
        }

        if ($this->isAjaxRequest()) {
            ob_start();
            extract([
                'list_booking' => $this->getInfoBooking($list_booking),
                'pagination' => $pag
            ]);
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
                'list_booking' => $this->getInfoBooking($list_booking),
                'pagination' => $pag
            ]);
        }
    }

    public function paidBooking()
    {
        $idtaikhoan = Session::get('user_id');
        $booking = $this->BookingModel->getBookingHistoryByStatus($idtaikhoan, 'Đã thanh toán');

        if ($booking) {
            $totalItems = count($booking);
            $this->pagination = new Pagination($totalItems, $this->per_page);
            Session::set('history', $booking, 1800);
            $list_booking = $this->pagination->getItemsbyCurrentPage($booking, 1);

            $pag = [
                'total_pages' => $this->pagination->getTotalPages(),
                'current_page' => $this->pagination->getcurrentPage(),
                'view' => 'history'
            ];
        } else {
            $list_booking = null;
            $pag = null;
        }

        if ($this->isAjaxRequest()) {
            ob_start();
            extract([
                'list_booking' => $this->getInfoBooking($list_booking),
                'pagination' => $pag
            ]);
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
                'list_booking' => $this->getInfoBooking($list_booking),
                'pagination' => $pag
            ]);
        }
    }

    public function booked()
    {
        $idtaikhoan = Session::get('user_id');
        $booking = $this->BookingModel->getBookingHistoryByStatus($idtaikhoan, 'Hoàn tất, Đã đánh giá');

        if ($booking) {
            $totalItems = count($booking);
            $this->pagination = new Pagination($totalItems, $this->per_page);
            Session::set('history', $booking, 1800);
            $list_booking = $this->pagination->getItemsbyCurrentPage($booking, 1);

            $pag = [
                'total_pages' => $this->pagination->getTotalPages(),
                'current_page' => $this->pagination->getcurrentPage(),
                'view' => 'history'
            ];
            $rating = $this->RatingModel->getCriteria();
        } else {
            $list_booking = null;
            $pag = null;
            $rating = null;
        }

        if ($this->isAjaxRequest()) {
            ob_start();
            extract([
                'list_booking' => $this->getInfoBooking($list_booking),
                'rating' => $rating,
                'pagination' => $pag
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
            $this->view('user', 'history.php', [
                'list_booking' => $this->getInfoBooking($list_booking),
                'rating' => $rating,
                'pagination' => $pag
            ]);
        }
    }


    public function canceledBooking()
    {
        $idtaikhoan = Session::get('user_id');
        $booking = $this->BookingModel->getBookingHistoryByStatus($idtaikhoan, 'Đã Hủy');

        if ($booking) {
            $totalItems = count($booking);
            $this->pagination = new Pagination($totalItems, $this->per_page);
            Session::set('history', $booking, 1800);
            $list_booking = $this->pagination->getItemsbyCurrentPage($booking, 1);

            $pag = [
                'total_pages' => $this->pagination->getTotalPages(),
                'current_page' => $this->pagination->getcurrentPage(),
                'view' => 'history'
            ];
        } else {
            $list_booking = null;
            $pag = null;
        }

        if ($this->isAjaxRequest()) {
            ob_start();
            extract([
                'list_booking' => $this->getInfoBooking($list_booking),
                'pagination' => $pag
            ]);
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
                'list_booking' => $this->getInfoBooking($list_booking),
                'pagination' => $pag
            ]);
        }
    }

    public function page($current_page = 1)
    {
        $rating = $this->RatingModel->getCriteria();
        $history = Session::get('history');

        if ($this->isAjaxRequest()) {

            $list_booking = $this->pagination->getItemsbyCurrentPage($history, $current_page);
            $response = [
                'bookings' => $this->getInfoBooking($list_booking),
                'pagination' => [
                    'total_pages' => $this->pagination->getTotalPages(),
                    'current_page' => $this->pagination->getcurrentPage()
                ],
                'view' => 'history/page'
            ];

            // Trả về dữ liệu dưới dạng JSON
            header('Content-Type: application/json');
            echo json_encode($response);
            exit;
        } else {
            if (!empty($current_page) && filter_var($current_page, FILTER_VALIDATE_INT)) {

                $list_booking = $this->pagination->getItemsbyCurrentPage($history, $current_page);
                $pag = [
                    'total_pages' => $this->pagination->getTotalPages(),
                    'current_page' => $this->pagination->getcurrentPage(),
                    'view' => 'history'
                ];

                $this->view('user', 'history.php', [
                    'list_booking' => $this->getInfoBooking($list_booking),
                    'rating' => $rating,
                    'pagination' => $pag
                ]);
            } else {
                header('location:' . URLROOT . '/history/all');
            }
        }
    }

    public function getInfoBooking($history)
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
                    if ($paymentMethod) {
                        $history[$key]['loaihinhtt'] = implode(" & ", array_column($paymentMethod, 'loaihinhthanhtoan'));
                    }

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
                if ($mail->sendMailCancelRoom($email, 'Thông báo hủy đặt phòng!', $this->getInfoBooking($booking))) {
                    echo "<script> alert('Hủy phòng thành công!');
                        window.history.back();
                    </script>";
                    exit();
                }
            } else {
                echo "<script> alert('Lỗi'); </script>";
                exit();
            }
        }
        header('location:' . URLROOT . '/history/all');
    }

    public function rating()
    {
        if (isset($_POST['rating'])) {
            if (!empty($_POST['criteria'])) {
                $tongdiem = 0;
                foreach ($_POST['criteria'] as $idtieuchi => $value) {
                    $tongdiem += $value;
                }
                $tongdiem = $tongdiem / count($_POST['criteria']);

                if ($this->RatingModel->createRating($_POST['content'], $tongdiem, $_POST['idtaikhoan'], $_POST['idphong'])) {
                    $iddanhgia =  $this->RatingModel->getRatingByIdUserRoom($_POST['idtaikhoan'], $_POST['idphong']);
                    foreach ($_POST['criteria'] as $idtieuchi => $value) {
                        $this->RatingModel->createDetailRating($idtieuchi, $iddanhgia, $value);
                    }
                    $this->RatingModel->updateStatusBooking($_POST['iddatphong']);
                    $this->RatingModel->updateScoreAccount($_POST['idtaikhoan']);
                    echo "<script> alert('Đánh giá thành công');
                        window.history.back();
                    </script>";
                    exit();
                }
            }
            echo "<script> alert('Lỗi');</script>";
            exit();
        } else {
            header('location:' . URLROOT . '/history/all');
        }
    }
}
