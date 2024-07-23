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

    public function getRatingByPage($per_page, $offset)
    {
        $sql = "SELECT danhgia.*, taikhoan.ho, taikhoan.ten, taikhoan.anh 
        FROM danhgia join taikhoan on danhgia.id_taikhoan = taikhoan.idtaikhoan
        LIMIT $per_page OFFSET $offset";
        $result = $this->db->select($sql);
        return $result;
    }

    public function countUserRating($idphong)
    {
        $sql = "SELECT COUNT(*) AS count FROM danhgia
        JOIN taikhoan on danhgia.id_taikhoan = taikhoan.idtaikhoan 
        WHERE danhgia.id_phong = '$idphong'";
        $result = $this->db->selectFirstColumnValue($sql, 'count');
        return $result;
    }

    public function getUserRatingByPage($idphong, $per_page, $offset)
    {
        $sql = "SELECT ho, ten, anh, noidung, thoigian, id_taikhoan, iddanhgia FROM danhgia 
        JOIN taikhoan on danhgia.id_taikhoan = taikhoan.idtaikhoan
        WHERE danhgia.id_phong = '$idphong' 
        ORDER BY danhgia.thoigian DESC, danhgia.tongdiem DESC, danhgia.iddanhgia DESC
        LIMIT $per_page OFFSET $offset";
        $result = $this->db->select($sql);
        return $result;
    }

    public function getRatingUserByAmenity($idphong, $idtaikhoan, $iddanhgia)
    {
        $sql = "SELECT chitietdanhgia.sodiem, tieuchidanhgia.tentieuchi
        FROM danhgia JOIN chitietdanhgia ON danhgia.iddanhgia = chitietdanhgia.id_danhgia
        JOIN tieuchidanhgia ON chitietdanhgia.id_tieuchi = tieuchidanhgia.idtieuchi
        WHERE danhgia.iddanhgia = '$iddanhgia'
        AND danhgia.id_phong = '$idphong'
        AND danhgia.id_taikhoan = '$idtaikhoan'";
        $result = $this->db->select($sql);
        return $result;
    }

    public function getCriteria()
    {
        $sql = "SELECT * FROM tieuchidanhgia ORDER BY idtieuchi";
        $result = $this->db->select($sql);
        return $result;
    }

    public function createRating($content, $tongdiem, $idtaikhoan, $idphong)
    {
        $sql = "INSERT INTO danhgia (noidung, thoigian, tongdiem, trangthai, id_taikhoan, id_phong) 
        VALUES ('$content', CURDATE(), '$tongdiem', 'Hiển thị', '$idtaikhoan', '$idphong')";
        $result = $this->db->execute($sql);
        return $result;
    }

    public function updateStatusBooking($iddatphong)
    {
        $sql = "UPDATE datphong set trangthaidat = 'Đã đánh giá' where iddatphong = '$iddatphong'";
        $result = $this->db->execute($sql);
        return $result;
    }

    public function updateScoreAccount($idtaikhoan)
    {
        $sql = "UPDATE taikhoan set diemtichluy = diemtichluy + 100 where idtaikhoan = '$idtaikhoan'";
        $result = $this->db->execute($sql);
        return $result;
    }

    public function createDetailRating($idtieuchi, $iddanhgia, $score)
    {
        $sql = "INSERT INTO chitietdanhgia(id_tieuchi, id_danhgia, sodiem) 
        VALUES ('$idtieuchi','$iddanhgia','$score')";
        $result = $this->db->execute($sql);
        return $result;
    }

    public function findRatingById($id)
    {
        $sql = "SELECT * FROM danhgia WHERE iddanhgia = '$id'";
        $result = $this->db->select($sql);
        return $result;
    }

    public function getRatingByIdUserRoom($idtaikhoan, $idphong)
    {
        $sql = "SELECT iddanhgia FROM danhgia WHERE id_taikhoan = '$idtaikhoan' and id_phong = '$idphong' ORDER BY thoigian DESC, iddanhgia DESC LIMIT 1";
        $result = $this->db->selectFirstColumnValue($sql, 'iddanhgia');
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
        GROUP BY tieuchidanhgia.idtieuchi;";
        $result = $this->db->select($sql);
        return $result;
    }


    public function getTotalRatingHotel()
    {
        $sql = "SELECT (SUM(tongdiem) / COUNT(*)) as tongdiem, COUNT(*) as sodanhgia FROM danhgia";
        $result = $this->db->select($sql);
        return $result;
    }
}
