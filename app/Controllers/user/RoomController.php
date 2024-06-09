<?php
class Room extends Controller
{
    private $RoomModel;
    private $CategoryModel;
    private $ImageModel;
    private $BookingModel;

    private $pagination;

    private $Categorys;
    private $Rooms;

    public function __construct()
    {
        $this->RoomModel = $this->model('RoomModel');
        $this->CategoryModel = $this->model('CategoryModel');
        $this->ImageModel = $this->model('ImageModel');
        $this->BookingModel = $this->model('BookingModel');

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


    public function search()
    {
        if (isset($_POST['change-date'])) {
            $checkin = isset($_POST['arrival']) ? $_POST['arrival'] : '';
            $checkout = isset($_POST['departure']) ? $_POST['departure'] : '';

            Session::set('checkin', $checkin);
            Session::set('checkout', $checkout);

            $rooms = $this->RoomModel->searchRooms($checkin, $checkout, '', '');

            $this->view('user', 'room.php', [
                'rooms' => $this->getRoomMore($rooms),
                'categorys' => $this->Categorys,
                // 'pagination' => $pag
            ]);
        }

        if (isset($_POST['search'])) {
            $checkin = $_POST["checkin"];
            $checkout = $_POST["checkout"];
            $adult = $_POST["adult"];
            $child = $_POST["child"];

            // $per_page = 3;
            $rooms = $this->RoomModel->searchRooms($checkin, $checkout, $adult, $child);
            // $this->pagination = new Pagination($rooms, $per_page);

            // $this->Rooms = $this->pagination->getItemsbyCurrentPage(1);
            // $pag = [
            //     'total_pages' => $this->pagination->getTotalPages(),
            //     'current_page' => $this->pagination->getcurrentPage()
            // ];

            $this->view('user', 'room.php', [
                'rooms' => $this->getRoomMore($rooms),
                'categorys' => $this->Categorys,
                // 'pagination' => $pag
            ]);
        } else {
            header('location:' . URLROOT . '/room');
        }
    }


    public function category($iddanhmuc = null)
    {
        if (!empty($iddanhmuc) && filter_var($iddanhmuc, FILTER_VALIDATE_INT)) {

            $rooms = $this->RoomModel->getRoomsByCategory(null, $iddanhmuc);
            $this->view('user', 'room.php', [
                'rooms' => $this->getRoomMore($rooms),
                'categorys' => $this->Categorys
            ]);
        } else {
            header('location:' . URLROOT . '/room');
        }
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
            if (!empty($current_page) && filter_var($current_page, FILTER_VALIDATE_INT)) {
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
            } else {
                header('location:' . URLROOT . '/room');
            }
        }
    }


    public function getRoomMore($Rooms)
    {
        if (!empty($Rooms)) {
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

                $desc = $this->RoomModel->getDescRoom($room['idphong']);
                $Rooms[$key]['mota'] = $desc;

                $paymentMethod = $this->RoomModel->findPaymentMethod($room['idphong']);
                $Rooms[$key]['loaihinhtt'] = implode(" & ", array_column($paymentMethod, 'loaihinhthanhtoan'));
            }
        }
        return $Rooms ?? null;
    }

    public function detailroom($idphong = null)
    {
        if (!empty($idphong) && filter_var($idphong, FILTER_VALIDATE_INT)) {
            $room = $this->RoomModel->findRoomById($idphong);

            foreach ($room as $item) {
                $roomMore = $this->RoomModel->getRoomsByCategory(3, $item['id_danhmuc']);
            }

            $amenities = $this->RoomModel->getAmenitiesByRoom($idphong);

            $roomImgs = $this->ImageModel->findRoomImageById($idphong);


            $detailRating = $this->RoomModel->getRatingRoom2($idphong);

            if ($detailRating) {
                foreach ($detailRating as $key => $item) {
                    $detailRating[$key]['diemtheotieuchi'] = $this->RoomModel->getScoreByAmenity($idphong);
                }
            }

            $ratingUser = $this->RoomModel->getUserRating($idphong);

            if ($ratingUser) {
                foreach ($ratingUser as $key => $item) {
                    $ratingUser[$key]['chitietdanhgia'] = $this->RoomModel->getRatingUserByAmenity($idphong, $item['id_taikhoan']);
                }
            }

            $this->view('user', 'detailroom.php', [
                'room' => $this->getRoomMore($room),
                'roomImgs' => $roomImgs,
                'amenities' => $amenities,
                'roomMore' => $this->getRoomMore($roomMore),
                'detailRating' => $detailRating,
                'ratingUser' => $ratingUser
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

                $cartNumber = $this->BookingModel->checkCartNumberByIdRoom($idtaikhoan, $ngayden, $ngaydi, $idphong);
                if ($cartNumber > 0) {
                    $update = $this->BookingModel->updateCartNumberByIdRoom($soluongdat, $tonggia, $idphong, $idtaikhoan);
                } else {
                    $update  = $this->BookingModel->createBooking($ngayden, $ngaydi, $soluongdat, $tonggia, 'Giỏ hàng', $idphong, null, $idtaikhoan);
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
