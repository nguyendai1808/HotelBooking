<?php
class Promotions
{
    private $db;
    public function __construct()
    {
        $this->db = new Database();
    }

    public function getPromotion()
    {
        $sql = "SELECT * FROM khuyenmai";
        $result = $this->db->select($sql);
        return $result;
    }

    // public function createPromotion($name, $mail, $add)
    // {
    //     $sql = "INSERT INTO taikhoan (name,email,address)
    //             VALUES ('$name','$mail','$add')";
    //     $result = $this->db->execute($sql);
    //     if ($result) {
    //         return true;
    //     } else {
    //         return false;
    //     }
    // }

    public function findPromotionById($id)
    {
        $sql = "SELECT * FROM khuyenmai WHERE idkhuyenmai = '$id'";
        $result = $this->db->select($sql);
        return $result;
    }

    // public function updatePromotion($id, $name, $mail, $add)
    // {
    //     $sql = "UPDATE taikhoan SET name = '$name',
    //                                 email = '$mail',
    //                                 address = '$add'
    //                             WHERE id = '$id'";
    //     $result = $this->db->execute($sql);
    //     if ($result) {
    //         return true;
    //     } else {
    //         return false;
    //     }
    // }

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

    
}
