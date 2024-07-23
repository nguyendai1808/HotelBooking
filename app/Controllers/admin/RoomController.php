<?php
class Room extends Controller
{
    private $RoomModel;
    private $ImageModel;
    private $CategoryModel;
    private $AmenityModel;
    private $ServiceModel;

    public function __construct()
    {
        $this->RoomModel = $this->model('RoomModel');
        $this->ImageModel = $this->model('ImageModel');
        $this->CategoryModel = $this->model('CategoryModel');
        $this->AmenityModel = $this->model('AmenityModel');
        $this->ServiceModel = $this->model('ServiceModel');
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

    public function action()
    {
        if (isset($_POST['pause'])) {
            $result = $this->RoomModel->updateStatusRoom('Tạm dừng', $_POST['pause']);
            if ($result) {
                echo "<script> alert('Cập nhật trạng thái: Tạm dừng');
                        window.location.href = '" . URLROOT . "/admin/room';
                    </script>";
                exit();
            } else {
                echo '<script>alert("Lỗi")</script>';
                exit();
            }
        }

        if (isset($_POST['continue'])) {
            $result = $this->RoomModel->updateStatusRoom('Hoạt động', $_POST['continue']);
            if ($result) {
                echo "<script> alert('Cập nhật trạng thái: Hoạt động');
                        window.location.href = '" . URLROOT . "/admin/room';
                    </script>";
                exit();
            } else {
                echo '<script>alert("Lỗi")</script>';
                exit();
            }
        }

        if (isset($_POST['delete'])) {
            $delete = $this->RoomModel->deleteRoom($_POST['delete']);
            if ($delete) {
                echo "<script> alert('Xóa thành công');
                        window.location.href = '" . URLROOT . "/admin/room';
                    </script>";
                exit();
            } else {
                echo '<script>alert("Lỗi")</script>';
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

                if (!empty($_FILES['images'])) {
                    $uploadDir = PUBLIC_PATH . '/user/images/rooms/';

                    foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
                        $file_name = $_FILES['images']['name'][$key];
                        $file_tmp = $_FILES['images']['tmp_name'][$key];

                        $iddanhmuc = $this->RoomModel->getIdCategoryById($idphong);
                        $timestamp = time();
                        $file_extension = pathinfo($file_name, PATHINFO_EXTENSION);
                        $new_file_name = 'room_img_' . $iddanhmuc . '_' . $idphong . '_' . $timestamp . '_' . $key . '.' . $file_extension;

                        if (move_uploaded_file($file_tmp, $uploadDir . $new_file_name)) {
                            $imageId = intval($this->RoomModel->getMaxIdImageRoom()) + 1;
                            $this->RoomModel->saveImage($imageId, $new_file_name, 'images/rooms', $idphong);
                            $response['images'][] = ['id' => $imageId, 'url' => USER_PATH . '/images/rooms/' . $new_file_name];
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
        $payTypes = $this->ServiceModel->getPayTypes();
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
                    echo '<script>alert("Lỗi")</script>';
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
            $payTypes = $this->ServiceModel->getPayTypes();
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

            $idphong = $_POST['idphong'];
            $uploadDir = PUBLIC_PATH . '/user/images/rooms/';

            foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
                $file_name = $_FILES['images']['name'][$key];
                $file_tmp = $_FILES['images']['tmp_name'][$key];

                $iddanhmuc = $this->RoomModel->getIdCategoryById($idphong);
                $timestamp = time();
                $file_extension = pathinfo($file_name, PATHINFO_EXTENSION);
                $new_file_name = 'room_img_' . $iddanhmuc . '_' . $idphong . '_' . $timestamp . '_' . $key . '.' . $file_extension;

                if (move_uploaded_file($file_tmp, $uploadDir . $new_file_name)) {
                    $imageId = intval($this->RoomModel->getMaxIdImageRoom()) + 1;
                    $this->RoomModel->saveImage($imageId, $new_file_name, 'images/rooms', $idphong);
                    $response['images'][] = ['id' => $imageId, 'url' => USER_PATH . '/images/rooms/' . $new_file_name];
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
            $dir_img = PUBLIC_PATH . '/user/images/rooms/';
            $old_image = $this->RoomModel->getRoomImageById($_POST['id']);

            $delete =  $this->RoomModel->deleteImage($_POST['id']);
            if ($delete) {
                if ($old_image && file_exists($dir_img . $old_image)) {
                    unlink($dir_img . $old_image);
                }
                echo 'success';
            } else {
                echo 'error';
            }
            return;
        } else {
            header('location:' . URLROOT . '/admin/room');
        }
    }
}
