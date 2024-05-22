<?php
class Hotel
{
    private $db;
    public function __construct()
    {
        $this->db = new Database();
    }

    public function getHotel()
    {
        $sql = "SELECT * FROM khachsan";
        $result = $this->db->select($sql);
        return $result;
    }

    public function getMainImageHotel($id)
    {
        $sql = "SELECT * FROM anhks WHERE id_khachsan = $id AND tenanh LIKE '%main%'";
        $result = $this->db->select($sql);

        if ($result) {
            foreach ($result as $row) {
                $img = $row['duongdan'] . '/' . $row['tenanh'];
            }
            return $img;
        } else {
            return null;
        }
    }

    // public function createHotel($name, $mail, $add)
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

    // public function findHotelById($id)
    // {
    //     $sql = "SELECT * FROM taikhoan WHERE idtaikhoan = '$id'";
    //     $result = $this->db->select($sql);
    //     return $result;
    // }

    // public function updateHotel($id, $name, $mail, $add)
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



    // public function deleteHotel($id)
    // {
    //     $sql = "DELETE FROM taikhoan WHERE id = '$id'";
    //     $result = $this->db->execute($sql);
    //     if ($result) {
    //         return true;
    //     } else {
    //         return false;
    //     }
    // }


    // public function getLogoHotel()
    // {
    //     $sql = "SELECT * FROM khachsan";
    //     $result = $this->db->select($sql);
    //     return $result;
    // }
}
