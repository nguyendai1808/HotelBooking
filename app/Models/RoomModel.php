<?php
class RoomModel
{
    private $db;
    public function __construct()
    {
        $this->db = new Database();
    }

    public function getRooms($LIMIT = null)
    {
        if (empty($LIMIT)) {
            $sql = "SELECT * FROM phong order by tenphong";
        } else {
            $sql = "SELECT * FROM phong order by tenphong LIMIT $LIMIT";
        }
        $result = $this->db->select($sql);
        return $result;
    }


    public function searchRooms($checkin, $checkout, $adult, $child)
    {
        $sql = "SELECT phong.* FROM phong WHERE idphong NOT IN (
            SELECT id_phong FROM datphong join dondat on datphong.id_dondat = dondat.iddondat
                WHERE ('$checkin' BETWEEN ngayden AND ngaydi)
                OR ('$checkout' BETWEEN ngayden AND ngaydi)
                OR (ngayden BETWEEN '$checkin' AND '$checkout')
                OR (ngaydi BETWEEN '$checkin' AND '$checkout')
            )";

        if (!empty($adult)) {
            $sql .= " and (nguoilon = $adult or nguoilon = $adult + 1)";
            if (empty($child)) {
                $sql .= " and (trenho is null or trenho = 0)";
            }
        }

        if (!empty($child)) {
            $sql .= " and (trenho = $child or trenho = $child + 1)";
        }

        $sql .= " GROUP BY idphong ORDER BY tenphong";

        $result = $this->db->select($sql);
        return $result;
    }


    public function emptyRoom($checkin, $checkout, $idphong)
    {
        $sql = "SELECT COUNT(*) as sophongban FROM datphong WHERE datphong.id_phong = '$idphong' AND (
            ('$checkin' BETWEEN ngayden AND ngaydi)
            OR ('$checkout' BETWEEN ngayden AND ngaydi)
            OR (ngayden BETWEEN '$checkin' AND '$checkout')
            OR (ngaydi BETWEEN '$checkin' AND '$checkout')
        )";
        $sophongban = $this->db->selectFirstColumnValue($sql, 'sophongban');
        $sophongban = !empty($sophongban) ? intval($sophongban) : 0;

        $soluongphong = $this->getQuantityRoom($idphong);
        $soluongphong = !empty($soluongphong) ? intval($soluongphong) : 0;

        return ($soluongphong - $sophongban);
    }


    public function getQuantityRoom($idphong)
    {
        $sql = "SELECT soluong FROM chitietbaotri 
        JOIN baotriphong ON chitietbaotri.id_baotri = baotriphong.idbaotri
        WHERE chitietbaotri.id_phong = '$idphong' 
        AND CURDATE() BETWEEN thoigianbatdau AND thoigianketthuc";
        $sophongbaotri = $this->db->selectFirstColumnValue($sql, 'soluong');
        $sophongbaotri = !empty($sophongbaotri) ? intval($sophongbaotri) : 0;

        $sql = "SELECT soluong FROM phong WHERE idphong = '$idphong'";
        $sophong = $this->db->selectFirstColumnValue($sql, 'soluong');
        $sophong = !empty($sophong) ? intval($sophong) : 0;

        return ($sophong - $sophongbaotri);
    }



    public function getScoreByAmenity($idphong)
    {
        $sql = "SELECT (SUM(chitietdanhgia.sodiem) / COUNT(*)) as sodiem, tieuchidanhgia.tentieuchi FROM danhgia 
        join chitietdanhgia on danhgia.iddanhgia = chitietdanhgia.id_danhgia
        join tieuchidanhgia on chitietdanhgia.id_tieuchi = tieuchidanhgia.idtieuchi
        where danhgia.id_phong = '$idphong' and danhgia.trangthai != 'Ẩn' GROUP BY tieuchidanhgia.idtieuchi";

        $result = $this->db->select($sql);
        return $result;
    }


    public function getUserRating($idphong)
    {
        $sql = "SELECT ho, ten, anh, noidung, thoigian, id_taikhoan FROM danhgia JOIN taikhoan on danhgia.id_taikhoan = taikhoan.idtaikhoan 
        WHERE danhgia.id_phong = '$idphong' and danhgia.trangthai != 'Ẩn'";
        $result = $this->db->select($sql);
        return $result;
    }

    public function getRatingUserByAmenity($idphong, $idtaikhoan)
    {
        $sql = "SELECT (SUM(chitietdanhgia.sodiem) / COUNT(*)) as sodiem, tieuchidanhgia.tentieuchi 
        FROM danhgia join chitietdanhgia on danhgia.iddanhgia = chitietdanhgia.id_danhgia 
        join tieuchidanhgia on chitietdanhgia.id_tieuchi = tieuchidanhgia.idtieuchi 
        where danhgia.id_phong = '$idphong' and danhgia.trangthai != 'Ẩn' AND danhgia.id_taikhoan = '$idtaikhoan' 
        GROUP BY tieuchidanhgia.idtieuchi;";

        $result = $this->db->select($sql);
        return $result;
    }

    public function getRatingRoom2($idphong)
    {
        $sql = "SELECT (SUM(tongdiem) / COUNT(*)) as tongdiem, COUNT(*) as sodanhgia FROM danhgia 
        where id_phong = '$idphong' and danhgia.trangthai != 'Ẩn'";
        $result = $this->db->select($sql);
        return $result;
    }

    public function getDescRoom($id)
    {
        $sql = "SELECT danhmuc.mota FROM phong join danhmuc on phong.id_danhmuc = danhmuc.iddanhmuc
        where phong.idphong = $id";
        $result = $this->db->selectFirstColumnValue($sql, "mota");
        return $result;
    }

    public function getNameBed($id)
    {
        $sql = "SELECT soluong, tengiuong FROM giuong join chitietgiuong on giuong.idgiuong = chitietgiuong.id_giuong 
        where chitietgiuong.id_phong = $id";
        $result = $this->db->select($sql);
        $namebed = null;
        if (!empty($result)) {
            foreach ($result as $item) {
                $namebed[] = $item['soluong'] . ' ' . $item['tengiuong'];
            }
        }
        return implode(", ", $namebed) ?? null;
    }

    public function getquantityBed($id)
    {
        $sql = "SELECT soluong FROM giuong join chitietgiuong on giuong.idgiuong = chitietgiuong.id_giuong 
        where chitietgiuong.id_phong = $id";
        $result = $this->db->select($sql);
        $bed = null;
        if (!empty($result)) {
            foreach ($result as $item) {
                $bed += intval($item['soluong']);
            }
        }
        return $bed;
    }

    public function getPromotionRoom($id)
    {
        $sql = "SELECT khuyenmai.khuyenmai FROM khuyenmai join chitietkhuyenmai on khuyenmai.idkhuyenmai = chitietkhuyenmai.id_khuyenmai 
        where chitietkhuyenmai.id_phong = '$id' AND CURDATE() BETWEEN khuyenmai.ngaybatdau AND khuyenmai.ngayketthuc";
        $result = $this->db->selectFirstColumnValue($sql, "khuyenmai");
        return $result;
    }

    public function getRatingRoom($id)
    {
        $sql = "SELECT (SUM(tongdiem) / COUNT(*)) as tongdiem FROM danhgia WHERE id_phong = '$id' and danhgia.trangthai != 'Ẩn'";
        $result = $this->db->selectFirstColumnValue($sql, 'tongdiem');
        return $result ?? null;
    }

    public function getMainImageRoom($id)
    {
        $sql = "SELECT duongdan, tenanh FROM anhphong WHERE id_phong = $id AND tenanh LIKE '%main%'";
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

    public function findPaymentMethod($id)
    {
        $sql = "SELECT loaihinhthanhtoan FROM loaihinhtt join chitietloaihinhtt on loaihinhtt.idloaihinhtt = chitietloaihinhtt.id_loaihinhtt
        WHERE chitietloaihinhtt.id_phong = '$id'";
        $result = $this->db->select($sql);
        return $result;
    }

    public function getAmenitiesByRoom($idphong)
    {
        $sql = "SELECT * FROM tiennghi join chitiettiennghi on tiennghi.idtiennghi =  chitiettiennghi.id_tiennghi
        WHERE chitiettiennghi.id_phong = '$idphong'";
        $result = $this->db->select($sql);
        return $result;
    }

    public function getRoomMaintenance($idphong)
    {
        $sql = "SELECT soluong FROM baotriphong join chitietbaotri on baotriphong.idbaotri = chitietbaotri.id_baotri 
        where DATE(thoigianketthuc) >= CURDATE() and chitietbaotri.id_phong = '$idphong'";
        $result = $this->db->selectFirstColumnValue($sql, 'soluong');
        return $result ?? 0;
    }

    // public function getRoomInBooked($idtaikhoan, $idphong)
    // {
    //     $sql = "SELECT * FROM phong join datphong on phong.idphong = datphong.id_phong
    //     where phong.idphong = $idphong and datphong.id_taikhoan = $idtaikhoan";
    //     $result = $this->db->select($sql);
    //     return $result;
    // }

    public function findRoomById($idphong)
    {
        $sql = "SELECT * FROM phong WHERE idphong = '$idphong'";
        $result = $this->db->select($sql);
        return $result;
    }


    // public function createRoom($name)
    // {
    //     $sql = "INSERT INTO danhmuc VALUES (null,'$name')";
    //     $result = $this->db->execute($sql);
    //     if ($result) {
    //         return true;
    //     } else {
    //         return false;
    //     }
    // }



    // public function updateRoom($id, $name)
    // {
    //     $sql = "UPDATE danhmuc SET tendanhmuc = '$name' WHERE iddanhmuc = '$id'";
    //     $result = $this->db->execute($sql);
    //     if ($result) {
    //         return true;
    //     } else {
    //         return false;
    //     }
    // }

    public function deleteRoom($id)
    {
        $sql = "DELETE FROM phong WHERE idphong = '$id'";
        $result = $this->db->execute($sql);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function getRoomsByCategory($num = null, $iddanhmuc)
    {
        if (!empty($num)) {
            $sql = "SELECT * FROM phong where id_danhmuc = $iddanhmuc LIMIT $num";
        } else {
            $sql = "SELECT * FROM phong where id_danhmuc = $iddanhmuc";
        }
        $result = $this->db->select($sql);
        return $result;
    }

    public function getRoomsBySale($num = null)
    {
        if (!empty($num)) {
            $sql = "SELECT phong.* FROM phong join chitietkhuyenmai on phong.idphong = chitietkhuyenmai.id_phong
            join khuyenmai on chitietkhuyenmai.id_khuyenmai = khuyenmai.idkhuyenmai
            where phong.trangthai = 'Hoạt động' and DATE(khuyenmai.ngayketthuc) >= CURDATE() ORDER BY khuyenmai.khuyenmai DESC LIMIT $num";
        } else {
            $sql = "SELECT phong.* FROM phong join chitietkhuyenmai on phong.idphong = chitietkhuyenmai.id_phong
            join khuyenmai on chitietkhuyenmai.id_khuyenmai = khuyenmai.idkhuyenmai
            where phong.trangthai = 'Hoạt động' and DATE(khuyenmai.ngayketthuc) >= CURDATE() ORDER BY khuyenmai.khuyenmai DESC";
        }
        $result = $this->db->select($sql);
        return $result;
    }

    public function getRoomsHot($num = null)
    {
        if (!empty($num)) {
            $sql = "SELECT phong.*, COUNT(datphong.id_phong) AS tongsodon 
            FROM phong JOIN datphong ON phong.idphong = datphong.id_phong
            WHERE datphong.id_dondat IS NOT NULL GROUP BY phong.idphong ORDER BY tongsodon DESC LIMIT $num";
        } else {
            $sql = "SELECT phong.*, COUNT(datphong.id_phong) AS tongsodon 
            FROM phong JOIN datphong ON phong.idphong = datphong.id_phong
            WHERE datphong.id_dondat IS NOT NULL GROUP BY phong.idphong ORDER BY tongsodon DESC";
        }
        $result = $this->db->select($sql);
        return $result;
    }




    //-----------------------------------------------Admin----------------------------------------------//


    public function updateStatusRoom($status, $idphong)
    {
        $sql = "UPDATE phong SET trangthai = '$status' WHERE idphong = '$idphong'";
        $result = $this->db->execute($sql);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }
}
