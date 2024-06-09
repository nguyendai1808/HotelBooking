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
        $sql = "SELECT * FROM baotriphong where DATE(thoigianketthuc) >= CURDATE()";
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

    public function getRoomMaintenanceById($id)
    {
        $sql = "SELECT *, chitietbaotri.soluong as soluongbaotri FROM phong join chitietbaotri on phong.idphong = chitietbaotri.id_phong 
        WHERE chitietbaotri.id_baotri = '$id'";
        $result = $this->db->select($sql);
        return $result;
    }
    
}
