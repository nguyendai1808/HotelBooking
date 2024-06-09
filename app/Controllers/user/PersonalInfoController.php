<?php
class PersonalInfo extends Controller
{
    private $BookingModel;
    private $RoomModel;
    private $AccountModel;

    public function __construct()
    {
        $this->AccountModel = $this->model('AccountModel');
        $this->BookingModel = $this->model('BookingModel');
        $this->RoomModel = $this->model('RoomModel');
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

    public function booked()
    {
        $idtaikhoan = Session::get('user_id');
        $booked = $this->BookingModel->getBookingHistoryByStatus($idtaikhoan, 'Hoàn tất');

        if ($booked) {
            foreach ($booked as $key => $item) {

                $Room =  $this->RoomModel->findRoomById($item['id_phong']);

                foreach ($Room as $room) {

                    $nameBed = $this->RoomModel->getNameBed($room['idphong']);
                    $booked[$key]['tengiuong'] = $nameBed;

                    $promotion = $this->RoomModel->getPromotionRoom($room['idphong']);
                    $booked[$key]['khuyenmai'] = $promotion;

                    $mainImg = $this->RoomModel->getMainImageRoom($room['idphong']);
                    $booked[$key]['anhphong'] = $mainImg;

                    $paymentMethod = $this->RoomModel->findPaymentMethod($room['idphong']);
                    $booked[$key]['loaihinhtt'] = implode(" & ", array_column($paymentMethod, 'loaihinhthanhtoan'));

                    $booked[$key]['tenphong'] = $room['tenphong'];
                    $booked[$key]['giaphong'] = $room['giaphong'];
                }

                if (empty($item['ngayden']) || empty($item['ngaydi'])) {
                    $soNgay = 0;
                } else {
                    $ngaydentmp = new DateTime($item['ngayden']);
                    $ngayditmp = new DateTime($item['ngaydi']);
                    $soNgay = intval($ngayditmp->diff($ngaydentmp)->format('%a'));
                }
                $booked[$key]['songay'] = $soNgay;
            }
        } else {
            $booked = null;
        }

        if ($this->isAjaxRequest()) {
            ob_start();
            extract(['list_booking' => $booked]);
            require_once APPROOT . '/views/user/pages/list_booking.php';
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
            'page' => 'list_booking.php',
            'list_booking' => $booked
        ]);
    }
}
