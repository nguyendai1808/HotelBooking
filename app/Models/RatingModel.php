<?php
class RatingModel
{
    private $db;
    public function __construct()
    {
        $this->db = new Database();
    }

    public function getRatings()
    {
        $sql = "SELECT danhgia.*, taikhoan.ho, taikhoan.ten, taikhoan.anh 
        FROM danhgia join taikhoan on danhgia.id_taikhoan = taikhoan.idtaikhoan";
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

    public function updateRating($iddanhgia, $status)
    {
        $sql = "UPDATE danhgia set trangthai = '$status' where iddanhgia = '$iddanhgia'";
        $result = $this->db->execute($sql);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

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

    public function displayCommentsWebsite($num = null)
    {
        if (!empty($num)) {
            $sql = "SELECT * FROM danhgia WHERE trangthai = 'Website' GROUP BY id_taikhoan ORDER BY tongdiem DESC LIMIT $num";
        } else {
            $sql = "SELECT * FROM danhgia WHERE trangthai = 'Website' GROUP BY id_taikhoan ORDER BY tongdiem DESC";
        }
        $result = $this->db->select($sql);
        return $result;
    }

    public function getRatingHotel()
    {
        $sql = "SELECT (SUM(chitietdanhgia.sodiem) / COUNT(*)) as sodiem, tieuchidanhgia.tentieuchi 
        FROM danhgia join chitietdanhgia on danhgia.iddanhgia = chitietdanhgia.id_danhgia 
        join tieuchidanhgia on chitietdanhgia.id_tieuchi = tieuchidanhgia.idtieuchi 
        where danhgia.trangthai != 'Ẩn'
        GROUP BY tieuchidanhgia.idtieuchi;";
        $result = $this->db->select($sql);
        return $result;
    }


    public function getTotalRatingHotel()
    {
        $sql = "SELECT (SUM(tongdiem) / COUNT(*)) as tongdiem, COUNT(*) as sodanhgia FROM danhgia 
        where danhgia.trangthai != 'Ẩn'";
        $result = $this->db->select($sql);
        return $result;
    }
}
