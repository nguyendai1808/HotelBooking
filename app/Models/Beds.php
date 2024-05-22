<?php
class Beds
{
    private $db;
    public function __construct()
    {
        $this->db = new Database();
    }

    public function getBed()
    {
        $sql = "SELECT * FROM giuong";
        $result = $this->db->select($sql);
        return $result;
    }

    public function createBed($name, $quantity, $idphong)
    {
        $sql = "INSERT INTO giuong VALUES (null,'$name','$quantity', '$idphong')";
        $result = $this->db->execute($sql);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function findBedById($id)
    {
        $sql = "SELECT * FROM giuong WHERE idgiuong = '$id'";
        $result = $this->db->select($sql);
        return $result;
    }

    public function updateBed($id, $name, $quantity)
    {
        $sql = "UPDATE giuong SET tengiuong = '$name', soluong = '$quantity' WHERE idgiuong = '$id'";
        $result = $this->db->execute($sql);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function deleteBed($id)
    {
        $sql = "DELETE FROM giuong WHERE idgiuong = '$id'";
        $result = $this->db->execute($sql);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }
}
