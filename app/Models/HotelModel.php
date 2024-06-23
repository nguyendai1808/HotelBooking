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
        $sql = "SELECT * FROM khachsan where idkhachsan = '1'";
        $result = $this->db->select($sql);
        return $result;
    }

    public function updateHotel($name, $email, $address, $phone, $info, $desc, $video)
    {
        $sql = "UPDATE khachsan SET tenkhachsan='$name',email='$email',diachi='$address',sdt='$phone',thongtin='$info',mota='$desc',video='$video' where idkhachsan = '1'";
        $result = $this->db->execute($sql);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }


    public function getMainImageHotel()
    {
        $sql = "SELECT * FROM anhks WHERE id_khachsan = '1' ORDER BY idanhks LIMIT 1";
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

    public function getVideoHotel()
    {
        $sql = "SELECT video FROM khachsan WHERE idkhachsan = '1'";
        $result = $this->db->selectFirstColumnValue($sql, 'video');
        return $result;
    }

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
            $sql = "SELECT CONCAT(duongdan, '/', tenanh) as anh, idanhks FROM anhks WHERE id_khachsan = '1' ORDER BY idanhks LIMIT $num";
        } else {
            $sql = "SELECT CONCAT(duongdan, '/', tenanh) as anh, idanhks FROM anhks WHERE id_khachsan = '1' ORDER BY idanhks";
        }
        $result = $this->db->select($sql);
        return $result;
    }


    public function deleteImage($id)
    {
        $sql = "DELETE From anhks where idanhks = '$id'";
        $result = $this->db->execute($sql);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }


    public function getMaxIdImageHotel()
    {
        $sql = "SELECT MAX(idanhks) as max FROM anhks";
        $result = $this->db->selectFirstColumnValue($sql, 'max');
        return $result;
    }


    public function saveImage($name, $link)
    {
        $maxId = $this->getMaxIdImageHotel();
        $maxId = intval($maxId) + 1;
        $sql = "INSERT INTO anhks(idanhks, tenanh, duongdan, id_khachsan) VALUES ('$maxId' ,'$name','$link','1')";
        $result = $this->db->execute($sql);
        if ($result) {
            return $maxId;
        } else {
            return null;
        }
    }
}
