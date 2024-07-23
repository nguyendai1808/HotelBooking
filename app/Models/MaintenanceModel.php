<?php
class MaintenanceModel
{
    private $db;
    
    public function __construct()
    {
        $this->db = new Database();
    }

    public function getMaintenances()
    {
        $sql = "SELECT * FROM baotriphong ORDER BY thoigianketthuc DESC";
        $result = $this->db->select($sql);
        return $result;
    }

    public function getRoomMaintenance($idphong, $idbaotri)
    {
        $sql = "SELECT phong.*, chitietbaotri.soluong as soluongbaotri FROM phong join chitietbaotri on phong.idphong = chitietbaotri.id_phong 
        WHERE chitietbaotri.id_baotri = '$idbaotri' and chitietbaotri.id_phong = '$idphong'";
        $result = $this->db->select($sql);
        return $result;
    }

    public function getRoomNoMaintenance($idbaotri)
    {
        $sql = "SELECT *  FROM phong WHERE idphong NOT IN (
                SELECT idphong FROM phong 
                JOIN chitietbaotri ON phong.idphong = chitietbaotri.id_phong 
                WHERE chitietbaotri.id_baotri = '$idbaotri'
            );";
        $result = $this->db->select($sql);
        return $result;
    }

    public function createMaintenance($name, $start, $end, $desc)
    {
        $sql = "INSERT INTO baotriphong(tenbaotri, thoigianbatdau, thoigianketthuc, mota) VALUES ('$name','$start','$end','$desc')";
        $result = $this->db->execute($sql);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }



    public function updateMaintenanceROom($idphong, $idbaotri, $soluong)
    {
        $sql = "UPDATE chitietbaotri set soluong = '$soluong' where id_phong = '$idphong' and id_baotri = '$idbaotri'";
        $result = $this->db->execute($sql);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }



    public function createMaintenanceCT($idphong, $idbaotri, $soluong)
    {
        $sql = "INSERT INTO chitietbaotri(id_phong, id_baotri, soluong) VALUES ('$idphong','$idbaotri','$soluong')";
        $result = $this->db->execute($sql);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function findMaintenanceById($id)
    {
        $sql = "SELECT * FROM baotriphong WHERE idbaotri = '$id'";
        $result = $this->db->select($sql);
        return $result;
    }

    public function updateMaintenance($idbaotri, $name, $start, $end, $desc)
    {
        $sql = "UPDATE baotriphong SET tenbaotri = '$name', thoigianbatdau = '$start', thoigianketthuc = '$end', mota = '$desc' Where idbaotri = '$idbaotri'";
        $result = $this->db->execute($sql);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function deleteMaintenance($id)
    {
        $sql = "DELETE FROM baotriphong WHERE idbaotri = '$id'";
        $result = $this->db->execute($sql);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function deleteMaintenanceCT($idphong, $idbaotri)
    {
        $sql = "DELETE FROM chitietbaotri WHERE id_phong = '$idphong' and id_baotri = '$idbaotri'";
        $result = $this->db->execute($sql);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function getRoomMaintenanceById($id)
    {
        $sql = "SELECT *, chitietbaotri.soluong as soluongbaotri FROM phong join chitietbaotri on phong.idphong = chitietbaotri.id_phong 
        WHERE chitietbaotri.id_baotri = '$id'";
        $result = $this->db->select($sql);
        return $result;
    }


    
}
