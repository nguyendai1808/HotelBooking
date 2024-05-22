<?php
class Bookings
{
    private $db;
    public function __construct()
    {
        $this->db = new Database();
    }

    public function getBookings()
    {
        $sql = "SELECT * FROM datphong";
        $result = $this->db->select($sql);
        return $result;
    }

    public function createBooking($ngayden = null, $ngaydi = null, $soluongdat = null, $tonggia = null, $id_phong = null, $id_dondat = null, $id_taikhoan = null)
    {

        $first = "INSERT INTO datphong (iddatphong";
        $last = "VALUES (null";

        if (!empty($ngayden)) {
            $first .= ",ngayden";
            $last .= ",'$ngayden'";
        }
        if (!empty($ngaydi)) {
            $first .= ",ngaydi";
            $last .= ",'$ngaydi'";
        }
        if (!empty($soluongdat)) {
            $first .= ",soluongdat";
            $last .= ",'$soluongdat'";
        }
        if (!empty($tonggia)) {
            $first .= ",tonggia";
            $last .= ",'$tonggia'";
        }
        if (!empty($id_phong)) {
            $first .= ",id_phong";
            $last .= ",'$id_phong'";
        }
        if (!empty($id_dondat)) {
            $first .= ",id_dondat";
            $last .= ",'$id_dondat'";
        }

        if (!empty($id_taikhoan)) {
            $first .= ",id_taikhoan";
            $last .= ",'$id_taikhoan'";
        }

        $first .= ")";
        $last .= ")";
        $sql = $first . ' ' . $last;

        $result = $this->db->execute($sql);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function findBookingById($iddatphong)
    {
        $sql = "SELECT * FROM datphong WHERE iddatphong = '$iddatphong'";
        $result = $this->db->select($sql);
        return $result;
    }

    public function findBooking($fullname, $email, $phone)
    {
        $sql = "SELECT idkhachhang FROM khachhang WHERE hoten LIKE '%$fullname%' and email = '$email' and sdt = '$phone')";
        $result = $this->db->selectFirstColumnValue($sql, 'idkhachhang');
        return $result ?? null;
    }


    public function updateBooking($iddatphong, $ngayden, $ngaydi, $soluongdat, $tonggia)
    {
        $sql = "UPDATE datphong SET ngayden='$ngayden', ngaydi='$ngaydi', soluongdat='$soluongdat', tonggia='$tonggia' WHERE iddatphong = '$iddatphong'";
        $result = $this->db->execute($sql);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function updateIdBooking($iddatphong, $id_dondat)
    {
        $sql = "UPDATE datphong SET id_dondat = '$id_dondat' WHERE iddatphong = '$iddatphong'";
        $result = $this->db->execute($sql);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }


    public function updateCartNumberByIdRoom($ngayden = null, $ngaydi = null, $soluongdat, $tonggia, $idphong, $idtaikhoan)
    {
        $sql = "UPDATE datphong SET ";

        if (!empty($ngayden)) {
            $sql .= "ngayden = '$ngayden', ";
        }
        if (!empty($ngaydi)) {
            $sql .= "ngaydi = '$ngaydi', ";
        }
        $sql .= "soluongdat = $soluongdat + soluongdat, tonggia = $tonggia + tonggia WHERE id_dondat is null && id_taikhoan = $idtaikhoan && id_phong = $idphong";

        $result = $this->db->execute($sql);
        return $result;
    }

    public function deleteBooking($iddatphong)
    {
        $sql = "DELETE FROM datphong WHERE iddatphong = '$iddatphong'";
        $result = $this->db->execute($sql);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function checkCartNumber($idtaikhoan)
    {
        $sql = "SELECT * FROM datphong WHERE id_taikhoan = $idtaikhoan and id_dondat is null";
        $result = $this->db->rowCount($sql);
        return $result;
    }

    public function checkCartNumberByIdRoom($idtaikhoan, $idphong)
    {
        $sql = "SELECT * FROM datphong WHERE id_taikhoan = $idtaikhoan and id_dondat is null && id_phong = $idphong";
        $result = $this->db->rowCount($sql);
        return $result;
    }

    public function updateTotalPrice($iddatphong, $idphong)
    {

        $sql = "SELECT khuyenmai.khuyenmai FROM phong join khuyenmai on phong.idphong = khuyenmai.id_phong 
            WHERE idphong = '$idphong' AND CURDATE() BETWEEN khuyenmai.ngaybatdau AND khuyenmai.ngayketthuc";
        $promotion =  $this->db->selectFirstColumnValue($sql, 'khuyenmai');

        $sql = "SELECT giaphong FROM phong where idphong = $idphong";
        $price =  $this->db->selectFirstColumnValue($sql, 'giaphong');

        $finalPrice = !empty($promotion) ? ($price - (($promotion / 100) * $price)) : $price;

        $sql = "SELECT * FROM datphong WHERE iddatphong = '$iddatphong'";
        $booking =  $this->db->select($sql);

        $toltalPrice = 0;
        foreach ($booking as $item) {
            if (empty($item['ngayden']) || empty($item['ngaydi'])) {
                $toltalPrice = 0;
            } else {
                $ngaydentmp = new DateTime($item['ngayden']);
                $ngayditmp = new DateTime($item['ngaydi']);
                $soNgay = intval($ngayditmp->diff($ngaydentmp)->format('%a'));
                $toltalPrice = $soNgay * intval($finalPrice) * intval($item['soluongdat']);
            }
        }

        $sql = "UPDATE datphong SET tonggia = $toltalPrice WHERE iddatphong = '$iddatphong'";
        $this->db->execute($sql);
    }



    public function getBookingInCart($idtaikhoan)
    {
        $sql = "SELECT * FROM datphong where id_taikhoan = $idtaikhoan and id_dondat is null";
        $result = $this->db->select($sql);
        return $result;
    }

    public function getBookedRoom($idtaikhoan)
    {
        $sql = "SELECT * FROM dondat JOIN datphong ON dondat.iddondat = datphong.id_dondat 
        WHERE trangthaidon = 'Thanh toán hoàn tất' AND datphong.id_taikhoan = '$idtaikhoan' ORDER BY thoigiandat DESC";
        $result = $this->db->select($sql);
        return $result;
    }

}
