<?php
class Room extends Controller
{
    private $RoomModel;
    private $CategoryModel;
    private $ImageModel;
    private $BookingModel;
    private $AmenityModel;

    private $pagination;
    private $per_page = 3;
    private $Categorys;
    private $Beds;

    public function __construct()
    {
        $this->RoomModel = $this->model('RoomModel');
        $this->CategoryModel = $this->model('CategoryModel');
        $this->ImageModel = $this->model('ImageModel');
        $this->BookingModel = $this->model('BookingModel');
        $this->AmenityModel = $this->model('AmenityModel');

        if (!empty(Session::get('rooms'))) {
            $rooms = Session::get('rooms');
            $this->pagination = new Pagination($rooms, $this->per_page);
        } else {
            $rooms = $this->RoomModel->getRooms();
            if ($rooms) {
                $this->pagination = new Pagination($rooms, $this->per_page);
                Session::set('rooms', $rooms, 1800);
            }
        }

        $this->Categorys = $this->CategoryModel->getCategorys();
        $this->Beds = $this->AmenityModel->getBeds();
    }

    public function index()
    {
        Session::delete('category');
        Session::delete('rangePrice');
        Session::delete('filterBed');

        $rooms = $this->RoomModel->getRooms();
        if ($rooms) {
            $this->pagination = new Pagination($rooms, $this->per_page);
            Session::set('rooms', $rooms, 1800);

            $Rooms = $this->pagination->getItemsbyCurrentPage(1);

            $pag = [
                'total_pages' => $this->pagination->getTotalPages(),
                'current_page' => $this->pagination->getcurrentPage()
            ];
        } else {
            $Rooms = null;
            $pag = null;
        }


        //gọi và show dữ liệu ra view
        $this->view('user', 'room.php', [
            'rooms' => $this->getInforRoomMore($Rooms),
            'categorys' => $this->Categorys,
            'beds' => $this->Beds,
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

            $adult = !empty(Session::get('adult')) ? Session::get('adult') : '';
            $child = !empty(Session::get('child')) ? Session::get('child') : '';

            $rooms = $this->RoomModel->searchRooms($adult, $child);

            if ($rooms) {
                $this->pagination = new Pagination($rooms, $this->per_page);
                Session::set('rooms', $rooms, 1800);

                $Rooms = $this->pagination->getItemsbyCurrentPage(1);
                $pag = [
                    'total_pages' => $this->pagination->getTotalPages(),
                    'current_page' => $this->pagination->getcurrentPage()
                ];
            } else {
                $Rooms = null;
                $pag = null;
            }

            $this->view('user', 'room.php', [
                'rooms' => $this->getInforRoomMore($Rooms),
                'categorys' => $this->Categorys,
                'beds' => $this->Beds,
                'pagination' => $pag
            ]);
        }

        if (isset($_POST['search'])) {
            $checkin = $_POST["checkin"];
            $checkout = $_POST["checkout"];
            $adult = $_POST["adult"];
            $child = $_POST["child"];

            $rooms = $this->RoomModel->searchRooms($adult, $child);
            if ($rooms) {
                $this->pagination = new Pagination($rooms, $this->per_page);
                Session::set('rooms', $rooms, 1800);

                $Rooms = $this->pagination->getItemsbyCurrentPage(1);
                $pag = [
                    'total_pages' => $this->pagination->getTotalPages(),
                    'current_page' => $this->pagination->getcurrentPage()
                ];
            } else {
                $Rooms = null;
                $pag = null;
            }

            $this->view('user', 'room.php', [
                'rooms' => $this->getInforRoomMore($Rooms),
                'categorys' => $this->Categorys,
                'beds' => $this->Beds,
                'pagination' => $pag
            ]);
        } else {
            header('location:' . URLROOT . '/room');
        }
    }

    public function roomFilter()
    {
        $rooms = Session::get('rooms');

        $category = Session::get('category');
        $rangePrice = Session::get('rangePrice');
        $filterBed = Session::get('filterBed');

        if ($category && $rooms) {
            $roomTmp = null;
            foreach ($rooms as $item) {
                if ($item['id_danhmuc'] == $category) {
                    $roomTmp[] = $item;
                }
            }
            $rooms = $roomTmp;
        }

        if ($rangePrice && $rooms) {
            $roomTmp = null;
            $min = $rangePrice['min'];
            $max = $rangePrice['max'];
            foreach ($rooms as $key => $item) {
                $promotion = $this->RoomModel->getPromotionRoom($item['idphong']);
                $rooms[$key]['price'] = !empty($promotion) ? intval($item['giaphong']) - (intval($item['giaphong']) * intval($promotion) * 0.01) : $item['giaphong'];
            }
            foreach ($rooms as $item) {
                if ($item['price'] >= $min && $item['price'] <= $max) {
                    $roomTmp[] = $item;
                }
            }
            $rooms = $roomTmp;
        }

        if ($filterBed && $rooms) {
            $roomTmp = null;
            $Arr_idphong = null;
            foreach ($filterBed as $bed) {
                $tmp =  $this->RoomModel->getRoomsByBed($bed['id'], $bed['quantity']);
                if (!empty($tmp)) {
                    $Arr_idphong[] = $tmp;
                }
            }
            if ($Arr_idphong) {
                for ($i = 0; $i < count($Arr_idphong[0]); $i++) {
                    foreach ($rooms as $item) {
                        if ($Arr_idphong[0][$i]['id_phong'] == $item['idphong']) {
                            $roomTmp[] = $item;
                        }
                    }
                }
            }
            $rooms = $roomTmp;
        }

        if ($rooms) {
            $this->pagination = new Pagination($rooms, $this->per_page);
            $Rooms = $this->pagination->getItemsbyCurrentPage(1);
            $pag = [
                'total_pages' => $this->pagination->getTotalPages(),
                'current_page' => $this->pagination->getcurrentPage()
            ];
        } else {
            $Rooms = null;
            $pag = null;
        }

        $response = [
            'rooms' => $this->getInforRoomMore($Rooms),
            'pagination' => $pag,
            'view' => 'room/page'
        ];

        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function filterBed()
    {
        if ($this->isAjaxRequest()) {

            $beds = json_decode($_GET['beds'], true);
            if ($beds) {
                Session::set('filterBed', $beds, 1800);
            } else {
                Session::delete('filterBed');
            }
            $this->roomFilter();

            exit;
        } else {
            header('location:' . URLROOT . '/room');
        }
    }

    public function rangePrice()
    {
        if ($this->isAjaxRequest()) {

            $rangePrice['min'] = $_GET['minPrice'];
            $rangePrice['max'] = $_GET['maxPrice'];

            Session::set('rangePrice', $rangePrice, 1800);
            $this->roomFilter();
            exit;
        } else {
            header('location:' . URLROOT . '/room');
        }
    }

    public function category($iddanhmuc = null)
    {
        if ($this->isAjaxRequest()) {

            if ($iddanhmuc == 'all') {
                Session::delete('category');
            } else {
                Session::set('category', $iddanhmuc, 1800);
            }
            $this->roomFilter();
            exit;
        } else {
            if (!empty($iddanhmuc) && filter_var($iddanhmuc, FILTER_VALIDATE_INT)) {

                $Rooms = null;
                $rooms = Session::get('rooms');
                foreach ($rooms as $item) {
                    if ($item['id_danhmuc'] == $iddanhmuc) {
                        $Rooms[] = $item;
                    }
                }

                $this->view('user', 'room.php', [
                    'rooms' => $this->getInforRoomMore($Rooms),
                    'categorys' => $this->Categorys,
                    'beds' => $this->Beds,
                ]);
            } else {
                header('location:' . URLROOT . '/room');
            }
        }
    }

    public function sortRooms()
    {
        if ($this->isAjaxRequest()) {
            $sortBy = $_GET['sortBy'];
            $rooms = Session::get('rooms');

            if ($sortBy == 'rating') {
                foreach ($rooms as $key => $item) {
                    $rating = $this->RoomModel->getRatingRoom($item['idphong']);
                    $rooms[$key]['rating'] = round($rating, 1);
                }
                usort($rooms, function ($a, $b) {
                    return $b['rating'] - $a['rating'];
                });
            }

            if ($sortBy == 'low_to_high') {
                foreach ($rooms as $key => $item) {
                    $promotion = $this->RoomModel->getPromotionRoom($item['idphong']);
                    $rooms[$key]['price'] = !empty($promotion) ? intval($item['giaphong']) - (intval($item['giaphong']) * intval($promotion) * 0.01) : $item['giaphong'];
                }
                usort($rooms, function ($a, $b) {
                    return $a['price'] - $b['price'];
                });
            }

            if ($sortBy == 'high_to_low') {
                foreach ($rooms as $key => $item) {
                    $promotion = $this->RoomModel->getPromotionRoom($item['idphong']);
                    $rooms[$key]['price'] = !empty($promotion) ? intval($item['giaphong']) - (intval($item['giaphong']) * intval($promotion) * 0.01) : $item['giaphong'];
                }
                usort($rooms, function ($a, $b) {
                    return $b['price'] - $a['price'];
                });
            }

            $this->pagination = new Pagination($rooms, $this->per_page);
            $rooms = Session::set('rooms', $rooms, 1800);
            $Rooms = $this->pagination->getItemsbyCurrentPage(1);

            $response = [
                'rooms' => $this->getInforRoomMore($Rooms)
            ];

            // Trả về dữ liệu dưới dạng JSON
            header('Content-Type: application/json');
            echo json_encode($response);
            exit;
        } else {
            header('location:' . URLROOT . '/room');
        }
    }

    public function page($current_page = 1)
    {
        if ($this->isAjaxRequest()) {
            $Rooms = $this->pagination->getItemsbyCurrentPage($current_page);
            $response = [
                'rooms' => $this->getInforRoomMore($Rooms),
                'pagination' => [
                    'total_pages' => $this->pagination->getTotalPages(),
                    'current_page' => $this->pagination->getcurrentPage()
                ],
                'view' => 'room/page'
            ];

            // Trả về dữ liệu dưới dạng JSON
            header('Content-Type: application/json');
            echo json_encode($response);
            exit;
        } else {
            if (!empty($current_page) && filter_var($current_page, FILTER_VALIDATE_INT)) {

                $Rooms = $this->pagination->getItemsbyCurrentPage($current_page);
                $pag = [
                    'total_pages' => $this->pagination->getTotalPages(),
                    'current_page' => $this->pagination->getcurrentPage()
                ];

                $this->view('user', 'room.php', [
                    'rooms' => $this->getInforRoomMore($Rooms),
                    'categorys' => $this->Categorys,
                    'beds' => $this->Beds,
                    'pagination' => $pag
                ]);
            } else {
                header('location:' . URLROOT . '/room');
            }
        }
    }


    public function getInforRoomMore($Rooms)
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

                $checkin = Session::get('checkin');
                $checkout = Session::get('checkout');
                if (!empty($checkin) && !empty($checkout)) {
                    $quantityRoom = $this->RoomModel->emptyRoom($checkin,  $checkout, $room['idphong']);
                } else {
                    $quantityRoom = $this->RoomModel->getQuantityRoom($room['idphong']);
                }

                $Rooms[$key]['soluongphongtrong'] = $quantityRoom;

                $paymentMethod = $this->RoomModel->findPaymentMethod($room['idphong']);
                if ($paymentMethod) {
                    $Rooms[$key]['loaihinhtt'] = implode(" & ", array_column($paymentMethod, 'loaihinhthanhtoan'));
                }
            }
            $Rooms[0]['max'] = max(array_column(Session::get('rooms'), 'giaphong'));
        }
        return $Rooms ?? null;
    }

    public function ratingP($current_page = 1)
    {
        if ($this->isAjaxRequest()) {
            $ratingUser = Session::get('ratingUser');
            if (!empty($ratingUser)) {
                $this->pagination = new Pagination($ratingUser, $this->per_page);
                $rating = $this->pagination->getItemsbyCurrentPage($current_page);
                $pag = [
                    'total_pages' => $this->pagination->getTotalPages(),
                    'current_page' => $this->pagination->getcurrentPage()
                ];
            } else {
                $rating = null;
                $pag = null;
            }

            $response = [
                'ratingUser' => $rating,
                'pagination' => $pag,
                'view' => 'room/ratingP'
            ];

            // Trả về dữ liệu dưới dạng JSON
            header('Content-Type: application/json');
            echo json_encode($response);
            exit;
        } else {
            // header('location:' . URLROOT . '/room');
            $ratingUser = Session::get('ratingUser');
            var_dump($ratingUser);
            return;
        }
    }

    public function detailroom($idphong = null)
    {
        if (!empty($idphong) && filter_var($idphong, FILTER_VALIDATE_INT)) {

            $room = $this->RoomModel->findRoomById($idphong);

            if ($room) {
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
                        $ratingUser[$key]['chitietdanhgia'] = $this->RoomModel->getRatingUserByAmenity($idphong, $item['id_taikhoan'], $item['iddanhgia']);
                    }
                    $this->pagination = new Pagination($ratingUser, $this->per_page);
                    Session::set('ratingUser', $ratingUser, 1800);
                    $rating = $this->pagination->getItemsbyCurrentPage(1);
                    $pag = [
                        'total_pages' => $this->pagination->getTotalPages(),
                        'current_page' => $this->pagination->getcurrentPage()
                    ];
                } else {
                    $rating = null;
                    $pag = null;
                }

                $this->view('user', 'detailroom.php', [
                    'room' => $this->getInforRoomMore($room),
                    'roomImgs' => $roomImgs,
                    'amenities' => $amenities,
                    'roomMore' => $this->getInforRoomMore($roomMore),
                    'detailRating' => $detailRating,
                    'ratingUser' => $rating,
                    'pagination' => $pag
                ]);
            } else {
                header('location:' . URLROOT . '/room');
            }
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
