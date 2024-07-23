<?php
class ServiceModel
{
    private $db;
    
    public function __construct()
    {
        $this->db = new Database();
    }

    public function getServices($LIMIT = null)
    {
        if (empty($LIMIT)) {
            $sql = "SELECT * FROM dichvu order by tendichvu";
        } else {
            $sql = "SELECT * FROM dichvu order by tendichvu LIMIT $LIMIT";
        }
        $result = $this->db->select($sql);
        return $result;
    }

    public function getServiceImageById($id)
    {
        $sql = "SELECT icon FROM dichvu WHERE iddichvu = '$id'";
        $result = $this->db->selectFirstColumnValue($sql, 'icon');
        return $result;
    }

    public function createServices($name, $desc, $icon)
    {
        $sql = "INSERT INTO dichvu (tendichvu, mota, icon, id_khachsan) VALUES ('$name','$desc','$icon', 1)";
        $result = $this->db->execute($sql);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function findServiceById($id)
    {
        $sql = "SELECT * FROM dichvu WHERE iddichvu = '$id'";
        $result = $this->db->select($sql);
        return $result;
    }

    public function updateServices($iddichvu, $name, $desc, $icon)
    {
        if (empty($icon)) {
            $sql = "UPDATE dichvu SET tendichvu = '$name', mota = '$desc' Where iddichvu = $iddichvu";
        } else {
            $sql = "UPDATE dichvu SET tendichvu = '$name', mota = '$desc', icon = '$icon' Where iddichvu = $iddichvu";
        }
        $result = $this->db->execute($sql);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function deleteService($id)
    {
        $sql = "DELETE FROM dichvu WHERE iddichvu = '$id'";
        $result = $this->db->execute($sql);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    //loại hình thanh toán
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
