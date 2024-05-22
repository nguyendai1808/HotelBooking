<?php
class Cart extends Controller
{
    private $BookingModel;
    private $RoomModel;


    public function __construct()
    {
        //gọi model
        $this->BookingModel = $this->model('Bookings');
        $this->RoomModel = $this->model('Rooms');
    }

    public function index()
    {
        $CartItem = null;
        $cartNumber = null;

        if (!empty(Session::get('user_id'))) {
            $idtaikhoan = Session::get('user_id');
            $cartNumber = $this->BookingModel->checkCartNumber($idtaikhoan);
        } else {
            echo '<script>alert("vui lòng đăng nhập!")</script>';
            $this->view('user', 'login.php');
        }

        if (!empty($cartNumber) && $cartNumber > 0) {

            $CartItem = $this->BookingModel->getBookingInCart($idtaikhoan);

            foreach ($CartItem as $key => $item) {

                //cập nhật lại tổng giá khi có hoặc hết khuyến mãi
                $this->BookingModel->updateTotalPrice($item['iddatphong'], $item['id_phong']);

                $Room =  $this->RoomModel->findRoomById($item['id_phong']);

                foreach ($Room as $room) {

                    $nameBed = $this->RoomModel->getNameBed($room['idphong']);
                    $CartItem[$key]['tengiuong'] = $nameBed;

                    $promotion = $this->RoomModel->getPromotionRoom($room['idphong']);
                    $CartItem[$key]['khuyenmai'] = $promotion;

                    $mainImg = $this->RoomModel->getMainImageRoom($room['idphong']);
                    $CartItem[$key]['anhphong'] = $mainImg;

                    $paymentMethod = $this->RoomModel->findPaymentMethod($room['idphong']);
                    $CartItem[$key]['loaihinhtt'] = implode(" & ", array_column($paymentMethod, 'loaihinhthanhtoan'));

                    $CartItem[$key]['tenphong'] = $room['tenphong'];
                    $CartItem[$key]['giaphong'] = $room['giaphong'];
                }

                if (empty($item['ngayden']) || empty($item['ngaydi'])) {
                    $soNgay = 0;
                } else {
                    $ngaydentmp = new DateTime($item['ngayden']);
                    $ngayditmp = new DateTime($item['ngaydi']);
                    $soNgay = intval($ngayditmp->diff($ngaydentmp)->format('%a'));
                }
                $CartItem[$key]['songay'] = $soNgay;
            }
        }
        //gọi và show dữ liệu ra view
        $this->view('user', 'cart.php', [
            'cartNumber' => $cartNumber,
            'cartItem' => $CartItem

        ]);
    }

    public function updateCart()
    {
        if ($this->isAjaxRequest()) {

            $iddatphong = $_POST['iddatphong'];
            $ngayden = $_POST['ngayden'];
            $ngaydi = $_POST['ngaydi'];
            $soluongdat = $_POST['soluongdat'];
            $tonggia = $_POST['tonggia'];

            // Xử lý yêu cầu AJAX
            if ($this->BookingModel->updateBooking($iddatphong, $ngayden, $ngaydi, $soluongdat, $tonggia)) {
                $response = [
                    'iddatphong' => $iddatphong,
                    'ngayden' => $ngayden,
                    'ngaydi' => $ngaydi,
                    'soluongdat' => $soluongdat,
                    'tonggia' => $tonggia
                ];
                header('Content-Type: application/json');
                echo json_encode($response);
                exit;
            }
            exit;
        }
        exit;
    }

    public function deleteCart($iddatphong)
    {
        if ($this->BookingModel->deleteBooking($iddatphong)) {

            $this->index();
        }
    }
}
