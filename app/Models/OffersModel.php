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
        $sql = "SELECT * FROM khuyenmai ORDER BY ngayketthuc Desc";
        $result = $this->db->select($sql);
        return $result;
    }

    public function getPromotionsCH()
    {
        $sql = "SELECT * FROM khuyenmai where DATE(khuyenmai.ngayketthuc) >= CURDATE() ORDER BY ngayketthuc Desc";
        $result = $this->db->select($sql);
        return $result;
    }

    public function getRoomNoPromotion($idkhuyemai)
    {
        $sql = "SELECT * FROM phong WHERE idphong NOT IN (
                SELECT idphong FROM phong 
                JOIN chitietkhuyenmai ON phong.idphong = chitietkhuyenmai.id_phong 
                WHERE chitietkhuyenmai.id_khuyenmai = '$idkhuyemai'
            );";
        $result = $this->db->select($sql);
        return $result;
    }

    public function createPromotionCT($idphong, $idkhuyenmai)
    {
        $sql = "INSERT INTO chitietkhuyenmai(id_phong, id_khuyenmai) VALUES ('$idphong','$idkhuyenmai')";
        $result = $this->db->execute($sql);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function deletePromotionCT($idphong, $idkhuyenmai)
    {
        $sql = "DELETE FROM chitietkhuyenmai WHERE id_phong = '$idphong' and id_khuyenmai = '$idkhuyenmai'";
        $result = $this->db->execute($sql);
        if ($result) {
            return true;
        } else {
            return false;
        }
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



    public function getPromotionRoom($idphong, $idkhuyemai)
    {
        $sql = "SELECT khuyenmai.khuyenmai FROM khuyenmai join chitietkhuyenmai on khuyenmai.idkhuyenmai = chitietkhuyenmai.id_khuyenmai
        WHERE chitietkhuyenmai.id_phong = '1' and chitietkhuyenmai.id_khuyenmai = '1'";
        $result = $this->db->selectFirstColumnValue($sql, 'khuyenmai');
        return $result;
    }


    public function getRoomPromotionById($id)
    {
        $sql = "SELECT phong.* FROM phong join chitietkhuyenmai on phong.idphong = chitietkhuyenmai.id_phong
        WHERE chitietkhuyenmai.id_khuyenmai = '$id'";
        $result = $this->db->select($sql);
        return $result;
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
