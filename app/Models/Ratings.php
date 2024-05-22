<?php
class Ratings
{
    private $db;
    public function __construct()
    {
        $this->db = new Database();
    }

    public function getRating()
    {
        $sql = "SELECT * FROM danhgia";
        $result = $this->db->select($sql);
        return $result;
    }

    // public function createRating($name, $mail, $add)
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

    public function findRatingById($id)
    {
        $sql = "SELECT * FROM danhgia WHERE iddanhgia = '$id'";
        $result = $this->db->select($sql);
        return $result;
    }

    // public function updateRating($id, $name, $mail, $add)
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

    public function deleteRating($id)
    {
        $sql = "DELETE FROM danhgia WHERE iddanhgia = '$id'";
        $result = $this->db->execute($sql);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }
}
