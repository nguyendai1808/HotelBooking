<?php
class Cart extends Controller
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
        $idtaikhoan = Session::get('user_id');
        $cartNumber = $this->BookingModel->checkCartNumber($idtaikhoan);
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
                    if ($paymentMethod) {
                        $CartItem[$key]['loaihinhtt'] = implode(" & ", array_column($paymentMethod, 'loaihinhthanhtoan'));
                    }

                    $CartItem[$key]['tenphong'] = $room['tenphong'];
                    $CartItem[$key]['giaphong'] = $room['giaphong'];
                }

                if (empty($item['ngayden']) || empty($item['ngaydi'])) {
                    $soNgay = 0;
                    $quantityRoom = $this->RoomModel->getQuantityRoom($item['id_phong']);
                } else {
                    $ngaydentmp = new DateTime($item['ngayden']);
                    $ngayditmp = new DateTime($item['ngaydi']);
                    $soNgay = intval($ngayditmp->diff($ngaydentmp)->format('%a'));

                    $quantityRoom = $this->RoomModel->emptyRoom($item['ngayden'],  $item['ngaydi'], $item['id_phong']);
                }
                $CartItem[$key]['songay'] = $soNgay;
                $CartItem[$key]['sophongtrong'] = $quantityRoom;
            }
        }
        //gọi và show dữ liệu ra view
        $this->view('user', 'cart.php', [
            'cartNumber' => $cartNumber ?? null,
            'cartItem' => $CartItem ?? null
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
        header('location:' . URLROOT . '/cart');
    }

    public function deleteCart()
    {
        if (isset($_POST['delete'])) {
            $this->BookingModel->deleteBooking($_POST['delete']);
        }
        header('location:' . URLROOT . '/cart');
    }
}
