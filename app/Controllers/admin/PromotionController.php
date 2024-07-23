<?php
class Promotion extends Controller
{
    private $PromotionModel;
    private $RoomModel;

    public function __construct()
    {
        $this->PromotionModel = $this->model('PromotionModel');
        $this->RoomModel = $this->model('RoomModel');
    }

    public function index()
    {
        $promotions  = $this->PromotionModel->getPromotions();

        $this->view('admin', 'promotion/promotion.php', [
            'promotions' => $promotions
        ]);
    }

    public function getInfoRoomMore($Rooms)
    {
        if ($Rooms) {
            foreach ($Rooms as $key => $room) {
                $mainImg = $this->RoomModel->getMainImageRoom($room['idphong']);
                $Rooms[$key]['anhphong'] = $mainImg;

                $nameBed = $this->RoomModel->getNameBed($room['idphong']);
                $Rooms[$key]['tengiuong'] = $nameBed;
            }
        }
        return $Rooms;
    }

    public function detail($idkhuyenmai)
    {
        if (!empty($idkhuyenmai) && filter_var($idkhuyenmai, FILTER_VALIDATE_INT)) {

            $rooms = $this->PromotionModel->getRoomPromotionById($idkhuyenmai);
            $time = $this->PromotionModel->findPromotionById($idkhuyenmai);

            $this->view('admin', 'promotion/detail.php', [
                'rooms' => $this->getInfoRoomMore($rooms),
                'idkhuyenmai' => $idkhuyenmai,
                'time' => $time
            ]);
        } else {
            header('location:' . URLROOT . '/admin/promotion');
        }
    }

    public function create()
    {
        if (isset($_POST['create'])) {

            $result = $this->PromotionModel->createPromotion($_POST["promotion"], $_POST["desc"], $_POST["dateStart"], $_POST["dateEnd"]);
            if ($result) {
                echo "<script> alert('Thêm thành công');
                        window.location.href = '" . URLROOT . "/admin/promotion';
                    </script>";
                exit();
            } else {
                echo '<script>alert("Lỗi")</script>';
                exit();
            }
        }
        $this->view('admin', 'promotion/create.php');
    }


    public function update($idkhuyenmai = null)
    {
        if (!empty($idkhuyenmai) && filter_var($idkhuyenmai, FILTER_VALIDATE_INT)) {

            if (isset($_POST['update'])) {
                $update = $this->PromotionModel->updatePromotion($idkhuyenmai, $_POST["promotion"], $_POST["desc"], $_POST["dateStart"], $_POST["dateEnd"]);
                if ($update) {
                    echo "<script> alert('Cập nhật thành công');
                        window.location.href = '" . URLROOT . "/admin/promotion';
                    </script>";
                    exit();
                } else {
                    echo '<script>alert("Lỗi")</script>';
                    exit();
                }
            }

            $promotion = $this->PromotionModel->findPromotionById($idkhuyenmai);
            $this->view('admin', 'promotion/update.php', [
                'promotion' => $promotion
            ]);
        } else {
            header('location:' . URLROOT . '/admin/promotion');
        }
    }

    public function delete()
    {
        if (isset($_POST['delete'])) {
            $delete = $this->PromotionModel->deletePromotion($_POST['delete']);
            if ($delete) {
                echo "<script> alert('Xóa thành công');
                        window.location.href = '" . URLROOT . "/admin/promotion';
                    </script>";
                exit();
            } else {
                echo '<script>alert("Lỗi")</script>';
                exit();
            }
        } else {
            header('location:' . URLROOT . '/admin/promotion');
        }
    }

    public function createRoom($idkhuyenmai = null)
    {
        if (!empty($idkhuyenmai) && filter_var($idkhuyenmai, FILTER_VALIDATE_INT)) {

            if (isset($_POST['createRoom'])) {
                $result = $this->PromotionModel->createPromotionCT($_POST['idphong'], $_POST['idkhuyenmai']);
                if ($result) {
                    echo "<script> alert('Thêm thành công'); 
                        window.location.href = '" . URLROOT . "/admin/promotion/detail/$idkhuyenmai';
                    </script>";
                    exit();
                } else {
                    echo '<script>alert("Lỗi")</script>';
                    exit();
                }
            }

            $rooms = $this->PromotionModel->getRoomNoPromotion($idkhuyenmai);
            $this->view('admin', 'promotion/create_room.php', [
                'rooms' => $rooms,
                'idkhuyenmai' => $idkhuyenmai
            ]);
        } else {
            header('location:' . URLROOT . '/admin/promotion');
        }
    }

    public function deleteRoom($idkhuyenmai)
    {
        if (!empty($idkhuyenmai) && filter_var($idkhuyenmai, FILTER_VALIDATE_INT)) {
            if (isset($_POST['deleteRoom'])) {
                $idphong = $_POST['deleteRoom'];
                $delete = $this->PromotionModel->deletePromotionCT($idphong, $idkhuyenmai);
                if ($delete) {
                    echo "<script> alert('Xóa thành công');
                        window.location.href = '" . URLROOT . "/admin/promotion/detail/$idkhuyenmai';
                    </script>";
                    exit();
                } else {
                    echo '<script>alert("Lỗi")</script>';
                    exit();
                }
            }
        } else {
            header('location:' . URLROOT . '/admin/promotion');
        }
    }
}
