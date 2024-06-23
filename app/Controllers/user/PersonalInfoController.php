<?php
class PersonalInfo extends Controller
{
    private $BookingModel;
    private $RoomModel;
    private $AccountModel;
    private $RatingModel;

    private $pagination;
    private $per_page = 3;

    public function __construct()
    {
        $this->AccountModel = $this->model('AccountModel');
        $this->BookingModel = $this->model('BookingModel');
        $this->RoomModel = $this->model('RoomModel');
        $this->RatingModel = $this->model('RatingModel');

        if (!empty(Session::get('history'))) {
            $history = Session::get('history');
            $this->pagination = new Pagination($history, $this->per_page);
        } else {
            $idtaikhoan = Session::get('user_id');
            $history = $this->BookingModel->getBookingHistoryByStatus($idtaikhoan);
            if ($history) {
                $this->pagination = new Pagination($history, $this->per_page);
                Session::set('history', $history, 1800);
            }
        }
    }

    public function index()
    {
        header('location:' . URLROOT . '/personalinfo/account');
    }

    public function account()
    {
        if (isset($_POST['save'])) {
            if ($this->AccountModel->updateAccount($_POST['save'], $_POST['surname'], $_POST['name'], $_POST['phone'], $_FILES['image']['name'], $_POST['address'])) {

                if (!empty($_FILES['image'])) {
                    $image = $_FILES['image']['name'];
                    $tmp_img = $_FILES['image']['tmp_name'];
                    $dir_img =  PUBLIC_PATH . '/user/images/avatars/';
                    move_uploaded_file($tmp_img, $dir_img . $image);
                }
                echo '<script>alert("Lưu thành công");</script>';
            } else {
                echo '<script>alert("Lưu thất bại");</script>';
            }
        }
        $account = $this->AccountModel->findAccountById(Session::get('user_id'));
        if ($this->isAjaxRequest()) {
            ob_start();
            extract(['account' => $account]);
            require_once APPROOT . '/views/user/pages/account_infor.php';
            $page = ob_get_clean();

            $response = [
                'page' => $page
            ];

            // Trả về dữ liệu dưới dạng JSON
            header('Content-Type: application/json');
            echo json_encode($response);
            exit;
        }
        $this->view('user', 'personal_infor.php', [
            'page' => 'account_infor.php',
            'account' => $account
        ]);
    }

    public function password()
    {
        if (isset($_POST['changPass'])) {
            if ($this->AccountModel->checkAccount($_POST['email'], $_POST['passOld'])) {
                if ($this->AccountModel->changePass($_POST['email'], $_POST['passNew'])) {
                    echo '<script>alert("Cập nhật thành công");</script>';
                } else {
                    echo '<script>alert("Cập nhật thất bại");</script>';
                }
            } else {
                echo '<script>alert("Mật khẩu không đúng");</script>';
            }
        }
        $account = $this->AccountModel->findAccountById(Session::get('user_id'));
        if ($this->isAjaxRequest()) {
            ob_start();
            extract(['account' => $account]);
            require_once APPROOT . '/views/user/pages/change_pass.php';
            $page = ob_get_clean();

            $response = [
                'page' => $page
            ];

            // Trả về dữ liệu dưới dạng JSON
            header('Content-Type: application/json');
            echo json_encode($response);
            exit;
        }
        $this->view('user', 'personal_infor.php', [
            'page' => 'change_pass.php',
            'account' => $account
        ]);
    }

    public function page($current_page = 1)
    {
        $criteria = $this->RatingModel->getCriteria();
        if ($this->isAjaxRequest()) {
            $list_booking = $this->pagination->getItemsbyCurrentPage($current_page);
            $response = [
                'bookings' => $this->getInforBooking($list_booking),
                'criteria' => $criteria,
                'pagination' => [
                    'total_pages' => $this->pagination->getTotalPages(),
                    'current_page' => $this->pagination->getcurrentPage()
                ],
                'view' => 'personalinfo/page'
            ];

            // Trả về dữ liệu dưới dạng JSON
            header('Content-Type: application/json');
            echo json_encode($response);
            exit;
        } else {
            if (!empty($current_page) && filter_var($current_page, FILTER_VALIDATE_INT)) {
                $list_booking = $this->pagination->getItemsbyCurrentPage($current_page);
                $pag = [
                    'total_pages' => $this->pagination->getTotalPages(),
                    'current_page' => $this->pagination->getcurrentPage(),
                    'view' => 'personalinfo'
                ];

                $this->view('user', 'personal_infor.php', [
                    'page' => 'list_booking.php',
                    'list_booking' => $this->getInforBooking($list_booking),
                    'criteria' => $criteria,
                    'pagination' => $pag
                ]);
            } else {
                header('location:' . URLROOT . '/personal_infor/booked');
            }
        }
    }


    public function booked()
    {
        $idtaikhoan = Session::get('user_id');
        $booking = $this->BookingModel->getBookingHistoryByStatus($idtaikhoan, 'Hoàn tất, Đã đánh giá');
        if ($booking) {
            $this->pagination = new Pagination($booking, $this->per_page);
            Session::set('history', $booking, 1800);
            $list_booking = $this->pagination->getItemsbyCurrentPage(1);

            $pag = [
                'total_pages' => $this->pagination->getTotalPages(),
                'current_page' => $this->pagination->getcurrentPage(),
                'view' => 'personalinfo'
            ];
            $criteria = $this->RatingModel->getCriteria();
        } else {
            $list_booking = null;
            $pag = null;
            $criteria = null;
        }

        if ($this->isAjaxRequest()) {

            ob_start();
            extract([
                'list_booking' => $this->getInforBooking($list_booking),
                'criteria' => $criteria,
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
            $this->view('user', 'personal_infor.php', [
                'page' => 'list_booking.php',
                'list_booking' => $this->getInforBooking($list_booking),
                'criteria' => $criteria,
                'pagination' => $pag
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
                    if($paymentMethod){
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
}
