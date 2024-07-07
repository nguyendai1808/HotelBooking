<?php
class Offers extends Controller
{
    private $OffersModel;
    private $RoomModel;

    public function __construct()
    {
        //gọi model User
        $this->OffersModel = $this->model('OffersModel');
        $this->RoomModel = $this->model('RoomModel');
    }

    public function index()
    {
        $promotions  = $this->OffersModel->getPromotions();
        $paytypes  = $this->OffersModel->getPayTypes();

        $this->view('admin', 'offers/offers.php', [
            'promotions' => $promotions,
            'paytypes' => $paytypes
        ]);
    }


    public function detailPromotion($idkhuyenmai)
    {
        if (!empty($idkhuyenmai) && filter_var($idkhuyenmai, FILTER_VALIDATE_INT)) {

            $rooms =  $this->OffersModel->getRoomPromotionById($idkhuyenmai);
            $time = $this->OffersModel->findPromotionById($idkhuyenmai);

            $this->view('admin', 'offers/detailPromotion.php', [
                'rooms' => $this->getInforRoomMore($rooms),
                'idkhuyenmai' => $idkhuyenmai,
                'time' => $time
            ]);
        } else {
            header('location:' . URLROOT . '/admin/offers');
        }
    }

    public function getInforRoomMore($Rooms)
    {
        if ($Rooms) {
            foreach ($Rooms as $key => $room) {
                $mainImg = $this->RoomModel->getMainImageRoom($room['idphong']);
                $Rooms[$key]['anhphong'] = $mainImg;

                $nameBed = $this->RoomModel->getNameBed($room['idphong']);
                $Rooms[$key]['tengiuong'] = $nameBed;
            }
        } else {
            $Rooms = null;
        }
        return $Rooms;
    }


    public function createPromotionRoom($idkhuyenmai = null)
    {
        $rooms = $this->OffersModel->getRoomNoPromotion($idkhuyenmai);

        if (isset($_POST['createPromotionRoom'])) {
            $result = $this->OffersModel->createPromotionCT($_POST['idphong'], $_POST['idkhuyenmai']);
            if ($result) {
                echo "<script> alert('Thêm thành công'); </script>";
                $this->detailPromotion($idkhuyenmai);
            } else {
                echo '<script>alert("lỗi")</script>';
                exit();
            }
        }

        $this->view('admin', 'offers/createPromotionRoom.php', [
            'rooms' => $rooms,
            'idkhuyenmai' => $idkhuyenmai
        ]);
    }

    public function deletePromotionRoom($idphong, $idkhuyenmai)
    {
        $delete = $this->OffersModel->deletePromotionCT($idphong, $idkhuyenmai);
        if ($delete) {
            echo "<script> alert('Xóa thành công'); </script>";
            $this->detailPromotion($idkhuyenmai);
        } else {
            echo '<script>alert("lỗi")</script>';
            exit();
        }
        header('location:' . URLROOT . '/admin/offers');
    }

    public function createPromotion()
    {
        if (isset($_POST['createPromotion'])) {
            $promotion = $_POST["promotion"];
            $desc = $_POST["desc"];
            $dateStart = $_POST["dateStart"];
            $dateEnd = $_POST["dateEnd"];

            $result = $this->OffersModel->createPromotion($promotion, $desc, $dateStart, $dateEnd);
            if ($result) {
                echo "<script> alert('Thêm thành công');
                        window.location.href = '" . URLROOT . "/admin/offers';
                    </script>";
                exit();
            } else {
                echo '<script>alert("lỗi")</script>';
                exit();
            }
        }
        $this->view('admin', 'offers/createPromotion.php');
    }


    public function updatePromotion($idkhuyenmai = null)
    {
        if (!empty($idkhuyenmai) && filter_var($idkhuyenmai, FILTER_VALIDATE_INT)) {

            if (isset($_POST['updatePromotion'])) {
                $promotion = $_POST["promotion"];
                $desc = $_POST["desc"];
                $dateStart = $_POST["dateStart"];
                $dateEnd = $_POST["dateEnd"];

                $update = $this->OffersModel->updatePromotion($idkhuyenmai, $promotion, $desc, $dateStart, $dateEnd);
                if ($update) {
                    echo "<script> alert('Cập nhật thành công');
                        window.location.href = '" . URLROOT . "/admin/offers';
                    </script>";
                    exit();
                } else {
                    echo '<script>alert("lỗi")</script>';
                    exit();
                }
            }

            $promotion = $this->OffersModel->findPromotionById($idkhuyenmai);
            $this->view('admin', 'offers/updatePromotion.php', [
                'promotion' => $promotion
            ]);
        } else {
            header('location:' . URLROOT . '/admin/offers');
        }
    }

    public function deletePromotion($idkhuyenmai = null)
    {
        if (!empty($idkhuyenmai) && filter_var($idkhuyenmai, FILTER_VALIDATE_INT)) {
            $delete = $this->OffersModel->deletePromotion($idkhuyenmai);
            if ($delete) {
                echo "<script> alert('Xóa thành công');
                        window.location.href = '" . URLROOT . "/admin/offers';
                    </script>";
                exit();
            } else {
                echo '<script>alert("lỗi")</script>';
                exit();
            }
        } else {
            header('location:' . URLROOT . '/admin/offers');
        }
    }


    //loại hình thanh toán
    public function createPayType()
    {
        if (isset($_POST['createPayType'])) {
            $name = $_POST["namePayType"];
            $result = $this->OffersModel->createPaytype($name);
            if ($result) {
                echo "<script> alert('Thêm thành công');
                        window.location.href = '" . URLROOT . "/admin/offers';
                    </script>";
                exit();
            } else {
                echo '<script>alert("lỗi")</script>';
                exit();
            }
        }
        $this->view('admin', 'offers/createPayType.php');
    }


    public function updatePayType($idloaihinhtt = null)
    {
        if (!empty($idloaihinhtt) && filter_var($idloaihinhtt, FILTER_VALIDATE_INT)) {

            if (isset($_POST['updatePayType'])) {
                $name = $_POST["namePayType"];

                $update = $this->OffersModel->updatePayType($idloaihinhtt, $name);
                if ($update) {
                    echo "<script> alert('cập nhật thành công');
                        window.location.href = '" . URLROOT . "/admin/offers';
                    </script>";
                    exit();
                } else {
                    echo '<script>alert("lỗi")</script>';
                    exit();
                }
            }

            $payType = $this->OffersModel->findPayTypeById($idloaihinhtt);
            $this->view('admin', 'offers/updatePayType.php', [
                'payType' => $payType
            ]);
        } else {
            header('location:' . URLROOT . '/admin/offers');
        }
    }

    public function deletePayType($idloaihinhtt = null)
    {
        if (!empty($idloaihinhtt) && filter_var($idloaihinhtt, FILTER_VALIDATE_INT)) {
            $delete = $this->OffersModel->deletePayType($idloaihinhtt);
            if ($delete) {
                echo "<script> alert('Xóa thành công');
                        window.location.href = '" . URLROOT . "/admin/offers';
                    </script>";
                exit();
            } else {
                echo '<script>alert("lỗi")</script>';
                exit();
            }
        } else {
            header('location:' . URLROOT . '/admin/offers');
        }
    }
}
