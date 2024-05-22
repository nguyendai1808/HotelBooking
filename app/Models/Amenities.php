<?php
class Amenities
{
    private $db;
    public function __construct()
    {
        $this->db = new Database();
    }

    public function getAmenities()
    {
        $sql = "SELECT * FROM tiennghi";
        $result = $this->db->select($sql);
        return $result;
    }

    // public function createAmenities($name)
    // {
    //     $sql = "INSERT INTO danhmuc VALUES (null,'$name')";
    //     $result = $this->db->execute($sql);
    //     if ($result) {
    //         return true;
    //     } else {
    //         return false;
    //     }
    // }


    // public function updateAmenities($id, $name)
    // {
    //     $sql = "UPDATE danhmuc SET tendanhmuc = '$name' WHERE iddanhmuc = '$id'";
    //     $result = $this->db->execute($sql);
    //     if ($result) {
    //         return true;
    //     } else {
    //         return false;
    //     }
    // }

    // public function deleteAmenities($id)
    // {
    //     $sql = "DELETE FROM danhmuc WHERE iddanhmuc = '$id'";
    //     $result = $this->db->execute($sql);
    //     if ($result) {
    //         return true;
    //     } else {
    //         return false;
    //     }
    // }

}
