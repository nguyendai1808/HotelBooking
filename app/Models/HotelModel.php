<?php
class HotelModel
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

    public function getMainImageHotel()
    {
        $sql = "SELECT * FROM anhks WHERE id_khachsan = '1' AND tenanh LIKE '%main%'";
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


    public function getNumberRoom()
    {
        $sql = "SELECT SUM(soluong) as sophong FROM phong";
        $result = $this->db->selectFirstColumnValue($sql, 'sophong');
        return $result;
    }

    public function getNumberService()
    {
        $sql = "SELECT iddichvu FROM dichvu";
        $result = $this->db->rowCount($sql);
        return $result;
    }

    public function getNumberRating()
    {
        $sql = "SELECT iddanhgia FROM danhgia";
        $result = $this->db->rowCount($sql);
        return $result;
    }

    public function getScoreRating()
    {
        $sql = "SELECT (SUM(tongdiem) / COUNT(*)) as tongdiem FROM danhgia";
        $result = $this->db->selectFirstColumnValue($sql, 'tongdiem');
        return $result;
    }


    public function getImagesHotel($num = null)
    {
        if (!empty($num)) {
            $sql = "SELECT CONCAT(duongdan, '/', tenanh) as anh FROM anhks WHERE id_khachsan = '1' LIMIT $num";
        } else {
            $sql = "SELECT CONCAT(duongdan, '/', tenanh) as anh FROM anhks WHERE id_khachsan = '1'";
        }
        $result = $this->db->select($sql);
        return $result;
    }
}
