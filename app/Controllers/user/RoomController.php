<?php
class Room extends Controller
{
    private $RoomModel;
    private $CategoryModel;
    private $RoomImgModel;
    private $BookingModel;

    private $pagination;

    private $Categorys;
    private $Rooms;


    public function __construct()
    {
        $this->RoomModel = $this->model('Rooms');
        $this->CategoryModel = $this->model('Categorys');
        $this->RoomImgModel = $this->model('RoomImage');
        $this->BookingModel = $this->model('Bookings');

        $this->Categorys = $this->CategoryModel->getCategorys();

        $per_page = 3;
        $rooms = $this->RoomModel->getRooms();
        $this->pagination = new Pagination($rooms, $per_page);

        $this->Rooms = $this->pagination->getItemsbyCurrentPage(1);
    }

    public function index()
    {
        $pag = [
            'total_pages' => $this->pagination->getTotalPages(),
            'current_page' => $this->pagination->getcurrentPage()
        ];

        //gọi và show dữ liệu ra view
        $this->view('user', 'room.php', [
            'rooms' => $this->getRoomMore($this->Rooms),
            'categorys' => $this->Categorys,
            'pagination' => $pag
        ]);
    }


    public function page($current_page = 1)
    {
        if ($this->isAjaxRequest()) {
            // Xử lý yêu cầu AJAX

            $this->Rooms = $this->pagination->getItemsbyCurrentPage($current_page);
            $response = [
                'rooms' => $this->getRoomMore($this->Rooms),
                'pagination' => [
                    'total_pages' => $this->pagination->getTotalPages(),
                    'current_page' => $this->pagination->getcurrentPage()
                ],
                'view' => 'room'
            ];

            // Trả về dữ liệu dưới dạng JSON
            header('Content-Type: application/json');
            echo json_encode($response);
            exit;
        } else {

            $this->Rooms = $this->pagination->getItemsbyCurrentPage($current_page);
            $pag = [
                'total_pages' => $this->pagination->getTotalPages(),
                'current_page' => $this->pagination->getcurrentPage()
            ];

            $this->view('user', 'room.php', [
                'rooms' => $this->getRoomMore($this->Rooms),
                'categorys' => $this->Categorys,
                'pagination' => $pag
            ]);
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

            $quantityBed = $this->RoomModel->getquantityBed($room['idphong']);
            $Rooms[$key]['sogiuong'] = $quantityBed;

            $rating = $this->RoomModel->getRatingRoom($room['idphong']);
            $Rooms[$key]['danhgia'] = $rating;

            $paymentMethod = $this->RoomModel->findPaymentMethod($room['idphong']);
            $Rooms[$key]['loaihinhtt'] = implode(" & ", array_column($paymentMethod, 'loaihinhthanhtoan'));
        }
        return $Rooms;
    }

    public function detailroom($idphong = null)
    {
        if (!empty($idphong) && filter_var($idphong, FILTER_VALIDATE_INT)) {
            $room = $this->RoomModel->findRoomById($idphong);

            $roomMore = $this->RoomModel->getRooms(5);

            $amenities = $this->RoomModel->getAmenitiesByRoom($idphong);

            $roomImgs = $this->RoomImgModel->findRoomImageById($idphong);

            $this->view('user', 'detailroom.php', [
                'room' => $this->getRoomMore($room),
                'roomImgs' => $roomImgs,
                'amenities' => $amenities,
                'roomMore' => $this->getRoomMore($roomMore),
            ]);
        } else {
            header('location:' . URLROOT . '/room');
        }
    }

    public function addcart()
    {
        if (isset($_POST['addcart'])) {
            $idphong = $_POST['idphong'];

            if (!empty(Session::get('user_id'))) {

                $idtaikhoan = Session::get('user_id');
                $ngayden = Session::get('checkin');
                $ngaydi = Session::get('checkout');

                if ($ngayden && $ngaydi) {
                    $ngaydentmp = new DateTime($ngayden);
                    $ngayditmp = new DateTime($ngaydi);
                    $songay = intval($ngayditmp->diff($ngaydentmp)->format('%a'));
                } else {
                    $songay = 0;
                }

                $soluongdat = $_POST['soluongdat'];
                $tonggia = intval($_POST['giaphong']) * intval($soluongdat) * $songay;

                $cartNumber = $this->BookingModel->checkCartNumberByIdRoom($idtaikhoan, $idphong);
                if ($cartNumber > 0) {
                    $update = $this->BookingModel->updateCartNumberByIdRoom($ngayden, $ngaydi, $soluongdat, $tonggia, $idphong, $idtaikhoan);
                } else {
                    $update  = $this->BookingModel->createBooking($ngayden, $ngaydi, $soluongdat, $tonggia, $idphong, null, $idtaikhoan);
                }

                if ($update) {
                    echo "<script> alert('Thêm thành công');
                        window.location.href = '" . URLROOT . "/room/detailroom/" . $idphong . "';
                    </script>";
                    exit();
                } else {
                    echo "<script> alert('Lỗi');
                        window.location.href = '" . URLROOT . "/room/detailroom/" . $idphong . "';
                    </script>";
                    exit();
                }
            } else {
                echo "<script> alert('Đăng nhập để đặt phòng hoặc đặt phòng ngay không cần đăng nhập');
                    window.location.href = '" . URLROOT . "/room/detailroom/" . $idphong . "';
                </script>";
                exit();
            }
        } else {
            header('location:' . URLROOT . '/room');
        }
    }
}
