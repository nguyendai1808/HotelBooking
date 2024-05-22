<?php
class Rooms
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


    public function getNameBed($id)
    {
        $sql = "SELECT * FROM giuong where id_phong = $id";
        $result = $this->db->select($sql);
        $namebed = null;
        if (!empty($result)) {
            foreach ($result as $item) {
                $namebed[] = $item['soluong'] . ' ' . $item['tengiuong'];
            }
            
        }
        return implode(", ", $namebed);
    }

    public function getquantityBed($id)
    {
        $sql = "SELECT soluong FROM giuong where id_phong = $id";
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
        $sql = "SELECT khuyenmai.khuyenmai FROM phong join khuyenmai on phong.idphong = khuyenmai.id_phong 
            WHERE idphong = '$id' AND CURDATE() BETWEEN khuyenmai.ngaybatdau AND khuyenmai.ngayketthuc";
        $result = $this->db->selectFirstColumnValue($sql, "khuyenmai");
        return $result;
    }

    public function getRatingRoom($id)
    {
        $sql = "SELECT * FROM danhgia WHERE id_phong = '$id'";
        $result = $this->db->select($sql);

        if ($result) {
            $sum = 0;
            foreach ($result as $row) {
                $sum += $row['diemsachse'] + $row['diemtiennghi'] + $row['diemdichvu'] + $row['d'] + $row['diemchatluong'];
            }
            return round(($sum / 4), 2);
        } else {
            return null;
        }
    }

    public function getMainImageRoom($id)
    {
        $sql = "SELECT * FROM anhphong WHERE id_phong = $id AND tenanh LIKE '%main%'";
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
        $sql = "SELECT * FROM loaihinhtt WHERE id_phong = '$id'";
        $result = $this->db->select($sql);
        return $result;
    }

    public function getAmenitiesByRoom($idphong)
    {
        $sql = "SELECT * FROM tiennghi WHERE id_phong = '$idphong'";
        $result = $this->db->select($sql);
        return $result;
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

    // public function deleteRoom($id)
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
