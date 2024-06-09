<?php
class Room extends Controller
{
    private $RoomModel;
    public function __construct()
    {
        //gọi model User
        $this->RoomModel = $this->model('RoomModel');
    }



    public function index()
    {

        $rooms = $this->RoomModel->getRooms();

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
            $Rooms[$key]['loaihinhtt'] = implode(" & ", array_column($paymentMethod, 'loaihinhthanhtoan'));

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
                header('location:' . URLROOT . '/admin/room');
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
                header('location:' . URLROOT . '/admin/room');
            }
        } else {
            header('location:' . URLROOT . '/admin/room');
        }
    }

    public function create()
    {
        // if (isset($_POST['create'])) {

        //     $result = $this->RoomModel->createroom($_POST['name']);
        //     if ($result) {
        //         header('location:' . URLROOT . '/admin/room');
        //     }
        // }

        $this->view('admin', 'room/create.php');
    }


    public function update($idphong = null)
    {
        if (!empty($idphong) && filter_var($idphong, FILTER_VALIDATE_INT)) {

            // if (isset($_POST['update'])) {
            //     $update = $this->roomModel->updateroom($idphong, $_POST['name']);
            //     if ($update) {
            //         header('location:' . URLROOT . '/admin/room');
            //     } else {
            //         echo '<script>alert("lỗi")</script>';
            //         exit();
            //     }
            // }

            // $findCate = $this->roomModel->findroomById($idphong);
            $this->view('admin', 'room/update.php', [
                // 'findCate' => $findCate
            ]);
        } else {
            header('location:' . URLROOT . '/admin/room');
        }
    }

    public function delete($idphong = null)
    {
        if (!empty($idphong) && filter_var($idphong, FILTER_VALIDATE_INT)) {
            $delete = $this->RoomModel->deleteRoom($idphong);
            if ($delete) {
                header('location:' . URLROOT . '/admin/room');
            } else {
                echo '<script>alert("lỗi")</script>';
                exit();
            }
        } else {
            header('location:' . URLROOT . '/admin/room');
        }
    }
}
