<?php
class Room extends Controller
{
    private $RoomModel;
    private $ImageModel;
    private $CategoryModel;
    private $AmenityModel;
    private $OffersModel;

    public function __construct()
    {
        //gọi model User
        $this->RoomModel = $this->model('RoomModel');
        $this->ImageModel = $this->model('ImageModel');
        $this->CategoryModel = $this->model('CategoryModel');
        $this->AmenityModel = $this->model('AmenityModel');
        $this->OffersModel = $this->model('OffersModel');
    }


    public function index()
    {

        $rooms = $this->RoomModel->getRoomsAdmin();

        //view - page
        $this->view('admin', 'room/room.php', [
            'rooms' => $this->getRoomMore($rooms)
        ]);
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
            if ($paymentMethod) {
                $Rooms[$key]['loaihinhtt'] = implode(" & ", array_column($paymentMethod, 'loaihinhthanhtoan'));
            }


            $quantityRoom = intval($Rooms[$key]['soluong']);
            $roomNumber = $this->RoomModel->getRoomMaintenance($room['idphong']);
            $Rooms[$key]['soluong'] = !empty($roomNumber) ? $quantityRoom - intval($roomNumber) : $quantityRoom;
        }
        return $Rooms;
    }

    public function pause($idphong)
    {
        if (!empty($idphong) && filter_var($idphong, FILTER_VALIDATE_INT)) {

            $result = $this->RoomModel->updateStatusRoom('Tạm dừng', $idphong);
            if ($result) {
                echo "<script> alert('cập nhật trạng thái: Tạm dừng');
                        window.location.href = '" . URLROOT . "/admin/room';
                    </script>";
                exit();
            }
        } else {
            header('location:' . URLROOT . '/admin/room');
        }
    }

    public function continue($idphong)
    {
        if (!empty($idphong) && filter_var($idphong, FILTER_VALIDATE_INT)) {

            $result = $this->RoomModel->updateStatusRoom('Hoạt động', $idphong);
            if ($result) {
                echo "<script> alert('cập nhật trạng thái: Hoạt động');
                        window.location.href = '" . URLROOT . "/admin/room';
                    </script>";
                exit();
            }
        } else {
            header('location:' . URLROOT . '/admin/room');
        }
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $idphong = $this->RoomModel->getMaxIdRoom();
            $room = $this->RoomModel->createroom($idphong, $_POST['tenphong'], $_POST['kichthuoc'], $_POST['nguoilon'], $_POST['trenho'], $_POST['giaphong'], $_POST['soluong'], $_POST['id_danhmuc']);
            if ($room) {

                $giuong = isset($_POST['giuong']) ? $_POST['giuong'] : '';
                $loaihinhtt = isset($_POST['loaihinhtt']) ? $_POST['loaihinhtt'] : '';
                $tiengnhi = isset($_POST['tiengnhi']) ? $_POST['tiengnhi'] : '';

                $giuongArray = [];
                if (!empty($giuong)) {
                    $giuongItems = explode(',', $giuong);
                    foreach ($giuongItems as $item) {
                        list($id, $quantity) = explode(':', $item);
                        $giuongArray[] = ['id' => $id, 'quantity' => $quantity];
                    }
                }

                $loaihinhttArray = !empty($loaihinhtt) ? explode(',', $loaihinhtt) : [];
                $tiengnhiArray = !empty($tiengnhi) ? explode(',', $tiengnhi) : [];

                if ($giuongArray) {
                    foreach ($giuongArray as $item) {
                        $this->RoomModel->addBedByRoom($item['id'], $idphong, $item['quantity']);
                    }
                }

                if ($loaihinhttArray) {
                    for ($i = 0; $i < count($loaihinhttArray); $i++) {
                        $this->RoomModel->addPayTypeByRoom($loaihinhttArray[$i], $idphong);
                    }
                }

                if ($tiengnhiArray) {
                    for ($i = 0; $i < count($tiengnhiArray); $i++) {
                        $this->RoomModel->addAmenityByRoom($tiengnhiArray[$i], $idphong);
                    }
                }

                if ($_FILES['images']) {
                    $uploadDir = PUBLIC_PATH . '/user/images/rooms/newroom/';

                    foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
                        $file_name = $_FILES['images']['name'][$key];
                        $file_tmp = $_FILES['images']['tmp_name'][$key];

                        // Lấy phần mở rộng của tệp
                        $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);

                        // Tạo tên tệp mới với đuôi _idphong
                        $new_file_name = uniqid() . "_$idphong" . '.' . $file_ext;

                        if (move_uploaded_file($file_tmp, $uploadDir . $new_file_name)) {
                            $imageId = $this->RoomModel->saveImage($new_file_name, 'images/rooms/newroom', $idphong);
                            $response['images'][] = ['id' => $imageId, 'url' => USER_PATH . '/images/rooms/newroom/' . $new_file_name];
                        }
                    }
                }

                echo "<script> alert('Thêm phòng thành công');
                        window.location.href = '" . URLROOT . "/admin/room';
                    </script>";
                exit();
            } else {
                echo "<script> alert('Lỗi');</script>";
                exit();
            }
        }

        $beds = $this->AmenityModel->getBeds();
        $amenitys = $this->AmenityModel->getAmenities();
        $payTypes = $this->OffersModel->getPayTypes();
        $categorys = $this->CategoryModel->getCategorys();

        $this->view('admin', 'room/create.php', [
            'beds' => $beds,
            'amenitys' => $amenitys,
            'payTypes' => $payTypes,
            'categorys' => $categorys
        ]);
    }


    public function update($idphong = null)
    {
        if (!empty($idphong) && filter_var($idphong, FILTER_VALIDATE_INT)) {

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                $update = $this->RoomModel->updateRoom($idphong, $_POST['tenphong'], $_POST['kichthuoc'], $_POST['nguoilon'], $_POST['trenho'], $_POST['giaphong'], $_POST['soluong'], $_POST['id_danhmuc']);
                if ($update) {
                    $giuong = isset($_POST['giuong']) ? $_POST['giuong'] : '';
                    $loaihinhtt = isset($_POST['loaihinhtt']) ? $_POST['loaihinhtt'] : '';
                    $tiengnhi = isset($_POST['tiengnhi']) ? $_POST['tiengnhi'] : '';

                    $giuongArray = [];
                    if (!empty($giuong)) {
                        $giuongItems = explode(',', $giuong);
                        foreach ($giuongItems as $item) {
                            list($id, $quantity) = explode(':', $item);
                            $giuongArray[] = ['id' => $id, 'quantity' => $quantity];
                        }
                    }


                    $loaihinhttArray = !empty($loaihinhtt) ? explode(',', $loaihinhtt) : [];
                    $tiengnhiArray = !empty($tiengnhi) ? explode(',', $tiengnhi) : [];

                    if ($giuongArray) {
                        if ($this->RoomModel->deleteBedsByRoom($idphong)) {
                            foreach ($giuongArray as $item) {
                                $this->RoomModel->addBedByRoom($item['id'], $idphong, $item['quantity']);
                            }
                        }
                    }

                    if ($loaihinhttArray) {
                        if ($this->RoomModel->deletePayTypeByRoom($idphong)) {
                            for ($i = 0; $i < count($loaihinhttArray); $i++) {
                                $this->RoomModel->addPayTypeByRoom($loaihinhttArray[$i], $idphong);
                            }
                        }
                    }

                    if ($tiengnhiArray) {
                        if ($this->RoomModel->deleteAmenitiesByRoom($idphong)) {
                            for ($i = 0; $i < count($tiengnhiArray); $i++) {
                                $this->RoomModel->addAmenityByRoom($tiengnhiArray[$i], $idphong);
                            }
                        }
                    }

                    echo "<script> alert('Cập nhật phòng thành công');
                        window.location.href = '" . URLROOT . "/admin/room';
                    </script>";
                    exit();
                } else {
                    echo '<script>alert("lỗi")</script>';
                    exit();
                }
            }

            $room = $this->RoomModel->findRoomById($idphong);

            foreach ($room as $key => $item) {
                $images = $this->ImageModel->findRoomImageById($item['idphong']);
                $room[$key]['anhphong'] = $images;

                $beds = $this->RoomModel->getBedByIdRoom($item['idphong']);
                $room[$key]['giuong'] = $beds;

                $payType = $this->RoomModel->getPayTypeByIdRoom($item['idphong']);
                $room[$key]['loaihinhtt'] = $payType;

                $amenities = $this->RoomModel->getAmenitiesByIdRoom($item['idphong']);
                $room[$key]['tiennghi'] = $amenities;
            }

            $beds = $this->AmenityModel->getBeds();
            $amenitys = $this->AmenityModel->getAmenities();
            $payTypes = $this->OffersModel->getPayTypes();
            $categorys = $this->CategoryModel->getCategorys();

            $this->view('admin', 'room/update.php', [
                'room' => $room,
                'beds' => $beds,
                'amenitys' => $amenitys,
                'payTypes' => $payTypes,
                'categorys' => $categorys
            ]);
        } else {
            header('location:' . URLROOT . '/admin/room');
        }
    }

    public function uploadImages()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_FILES['images'])) {
            $response = ['status' => 'error', 'images' => []];
            $uploadDir = PUBLIC_PATH . '/user/images/rooms/newroom/';

            $idphong = $_POST['idphong'];

            foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
                $file_name = $_FILES['images']['name'][$key];
                $file_tmp = $_FILES['images']['tmp_name'][$key];

                // Lấy phần mở rộng của tệp
                $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);

                // Tạo tên tệp mới với đuôi _idphong
                $new_file_name = uniqid() . "_$idphong" . '.' . $file_ext;

                if (move_uploaded_file($file_tmp, $uploadDir . $new_file_name)) {
                    $imageId = $this->RoomModel->saveImage($new_file_name, 'images/rooms/newroom', $idphong);
                    $response['images'][] = ['id' => $imageId, 'url' => USER_PATH . '/images/rooms/newroom/' . $new_file_name];
                }
            }

            if (!empty($response['images'])) {
                $response['status'] = 'success';
            }

            header('Content-Type: application/json');
            echo json_encode($response);
        } else {
            header('location:' . URLROOT . '/admin/room');
        }
    }


    public function deleteImg()
    {
        if (isset($_POST['id'])) {
            $delete =  $this->RoomModel->deleteImage($_POST['id']);
            if ($delete) {
                echo 'success';
            } else {
                echo 'error';
            }
            return;
        } else {
            header('location:' . URLROOT . '/admin/room');
        }
    }

    public function delete($idphong = null)
    {
        if (!empty($idphong) && filter_var($idphong, FILTER_VALIDATE_INT)) {
            $delete = $this->RoomModel->deleteRoom($idphong);
            if ($delete) {
                echo "<script> alert('Xóa thành công');
                        window.location.href = '" . URLROOT . "/admin/room';
                    </script>";
                exit();
            } else {
                echo '<script>alert("lỗi")</script>';
                exit();
            }
        } else {
            header('location:' . URLROOT . '/admin/room');
        }
    }
}
