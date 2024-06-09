<?php
class Offers extends Controller
{
    private $OffersModel;

    public function __construct()
    {
        //gọi model User
        $this->OffersModel = $this->model('OffersModel');
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

    public function createPromotion()
    {
        if (isset($_POST['createPromotion'])) {
            $promotion = $_POST["promotion"];
            $desc = $_POST["desc"];
            $dateStart = $_POST["dateStart"];
            $dateEnd = $_POST["dateEnd"];

            $result = $this->OffersModel->createPromotion($promotion, $desc, $dateStart, $dateEnd);
            if ($result) {
                header('location:' . URLROOT . '/admin/offers');
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
                    header('location:' . URLROOT . '/admin/offers');
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
                header('location:' . URLROOT . '/admin/offers');
            } else {
                echo '<script>alert("lỗi")</script>';
                exit();
            }
        } else {
            header('location:' . URLROOT . '/admin/offers');
        }
    }

    public function createPayType()
    {
        if (isset($_POST['createPayType'])) {
            $name = $_POST["namePayType"];
            $result = $this->OffersModel->createPaytype($name);
            if ($result) {
                header('location:' . URLROOT . '/admin/offers');
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
                    header('location:' . URLROOT . '/admin/offers');
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
                header('location:' . URLROOT . '/admin/offers');
            } else {
                echo '<script>alert("lỗi")</script>';
                exit();
            }
        } else {
            header('location:' . URLROOT . '/admin/offers');
        }
    }
}
