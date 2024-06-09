<?php
class OffersModel
{
    private $db;
    public function __construct()
    {
        $this->db = new Database();
    }

    public function getPromotions()
    {
        $sql = "SELECT * FROM khuyenmai where DATE(ngayketthuc) >= CURDATE()";
        $result = $this->db->select($sql);
        return $result;
    }

    public function createPromotion($khuyenmai, $mota, $ngaybatdau, $ngayketthuc)
    {
        $sql = "INSERT INTO khuyenmai (khuyenmai, mota, ngaybatdau, ngayketthuc) VALUES ('$khuyenmai','$mota','$ngaybatdau','$ngayketthuc')";
        $result = $this->db->execute($sql);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function findPromotionById($id)
    {
        $sql = "SELECT * FROM khuyenmai WHERE idkhuyenmai = '$id'";
        $result = $this->db->select($sql);
        return $result;
    }

    public function updatePromotion($idkhuyemai, $khuyenmai, $mota, $ngaybatdau, $ngayketthuc)
    {
        $sql = "UPDATE khuyenmai SET khuyenmai = '$khuyenmai', mota = '$mota', ngaybatdau = '$ngaybatdau', ngayketthuc = '$ngayketthuc'
        Where idkhuyenmai = '$idkhuyemai'";
        $result = $this->db->execute($sql);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function deletePromotion($id)
    {
        $sql = "DELETE FROM khuyenmai WHERE idkhuyenmai = '$id'";
        $result = $this->db->execute($sql);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function getPayTypes()
    {
        $sql = "SELECT * FROM loaihinhtt";
        $result = $this->db->select($sql);
        return $result;
    }

    public function createPaytype($name)
    {
        $sql = "INSERT INTO loaihinhtt (loaihinhthanhtoan) VALUES ('$name')";
        $result = $this->db->execute($sql);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function findPayTypeById($id)
    {
        $sql = "SELECT * FROM loaihinhtt WHERE idloaihinhtt = '$id'";
        $result = $this->db->select($sql);
        return $result;
    }

    public function updatePayType($idloaihinhtt, $nameNew)
    {
        $sql = "UPDATE loaihinhtt SET loaihinhthanhtoan = '$nameNew' Where idloaihinhtt = '$idloaihinhtt'";
        $result = $this->db->execute($sql);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function deletePaytype($id)
    {
        $sql = "DELETE FROM loaihinhtt WHERE idloaihinhtt = '$id'";
        $result = $this->db->execute($sql);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }
}
