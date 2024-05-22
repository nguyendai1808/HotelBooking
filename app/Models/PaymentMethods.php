<?php
class PaymentMethods
{
    private $db;
    public function __construct()
    {
        $this->db = new Database();
    }

    // public function getCategory()
    // {
    //     $sql = "SELECT * FROM danhmuc";
    //     $result = $this->db->select($sql);
    //     return $result;
    // }

    // public function createCategory($name)
    // {
    //     $sql = "INSERT INTO danhmuc VALUES (null,'$name')";
    //     $result = $this->db->execute($sql);
    //     if ($result) {
    //         return true;
    //     } else {
    //         return false;
    //     }
    // }


    // public function updateCategory($id, $name)
    // {
    //     $sql = "UPDATE danhmuc SET tendanhmuc = '$name' WHERE iddanhmuc = '$id'";
    //     $result = $this->db->execute($sql);
    //     if ($result) {
    //         return true;
    //     } else {
    //         return false;
    //     }
    // }

    // public function deleteCategory($id)
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
