<?php
class PersonalInfo extends Controller
{
    private $BookingModel;
    private $RoomModel;
    private $AccountModel;

    public function __construct()
    {
        $this->AccountModel = $this->model('Accounts');
        $this->BookingModel = $this->model('Bookings');
        $this->RoomModel = $this->model('Rooms');
    }

    public function index()
    {
        header('location:' . URLROOT . '/personalinfo/account');
    }

    public function account()
    {
        $account = null;
        if (!empty(Session::get('user_id'))) {
            $account = $this->AccountModel->findAccountById(Session::get('user_id'));
        }

        if ($this->isAjaxRequest()) {
            ob_start();
            require_once APPROOT . '/views/user/pages/account_infor.php';
            $display = ob_get_clean();

            $response = [
                'display' => $display,
                'account' => $account
            ];

            // Trả về dữ liệu dưới dạng JSON
            header('Content-Type: application/json');
            echo json_encode($response);
            exit;
        } else {

            $this->view('user', 'personal_infor.php', [
                'display' => 'account_infor.php',
                'account' => $account
            ]);
        }
    }



    public function password()
    {
        $account = null;
        if (!empty(Session::get('user_id'))) {
            $account = $this->AccountModel->findAccountById(Session::get('user_id'));
        }

        if ($this->isAjaxRequest()) {
            ob_start();
            require_once APPROOT . '/views/user/pages/change_pass.php';
            $display = ob_get_clean();

            $response = [
                'display' => $display,
                'account' => $account,
            ];

            // Trả về dữ liệu dưới dạng JSON
            header('Content-Type: application/json');
            echo json_encode($response);
            exit;
        } else {

            $this->view('user', 'personal_infor.php', [
                'display' => 'change_pass.php',
                'account' => $account
            ]);
        }
    }

    public function booked()
    {

        $booked = null;
        if (!empty(Session::get('user_id'))) {
            $idtaikhoan = Session::get('user_id');
        } else {
            echo '<script>alert("vui lòng đăng nhập!")</script>';
            $this->view('user', 'login.php');
            exit();
        }

        $booked = $this->BookingModel->getBookedRoom($idtaikhoan);

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
        }

        if ($this->isAjaxRequest()) {
            ob_start();
            require_once APPROOT . '/views/user/pages/list_booked.php';
            $display = ob_get_clean();

            $response = [
                'display' => $display,
                'booked' => $booked
            ];

            // Trả về dữ liệu dưới dạng JSON
            header('Content-Type: application/json');
            echo json_encode($response);
            exit;
        } else {

            $this->view('user', 'personal_infor.php', [
                'display' => 'list_booked.php',
                'booked' => $booked
            ]);
        }
    }
}
