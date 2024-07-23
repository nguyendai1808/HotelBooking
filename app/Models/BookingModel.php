<?php
class BookingModel
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

    public function createBooking($ngayden = null, $ngaydi = null, $soluongdat = null, $tonggia = null, $trangthai = null, $id_phong = null, $id_dondat = null, $id_taikhoan = null)
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
        if (!empty($trangthai)) {
            $first .= ",trangthaidat";
            $last .= ",'$trangthai'";
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


    public function getInfoExportInvoice($iddondat)
    {
        $sql = "SELECT thoigiandat, trangthaidon, datphong.ngayden, ngaydi, soluongdat, tonggia, phong.tenphong FROM dondat 
        JOIN datphong ON dondat.iddondat = datphong.id_dondat
        JOIN phong ON datphong.id_phong = phong.idphong
        WHERE dondat.iddondat = '$iddondat' AND datphong.trangthaidat = 'Hoàn tất'";
        $result = $this->db->select($sql);
        return $result;
    }

    public function getInvoiceBookingById($iddondat)
    {
        $sql = "SELECT * FROM datphong join dondat on datphong.id_dondat = dondat.iddondat
        WHERE dondat.iddondat = '$iddondat'";
        $result = $this->db->select($sql);
        return $result;
    }


    public function updateCancelBooking($iddatphong, $soluonghuy, $iddondat, $id_phong)
    {
        $sql = "SELECT * FROM datphong WHERE iddatphong = '$iddatphong'";
        $datphong = $this->db->select($sql);
        $soluongdat = $datphong[0]['soluongdat'];

        if (intval($soluongdat) == $soluonghuy) {
            $sql = "SELECT iddatphong, soluongdat FROM datphong where id_dondat = '$iddondat' and id_phong = '$id_phong' and trangthaidat = 'Đã hủy'";
            $iddatphong2 = $this->db->selectFirstColumnValue($sql, 'iddatphong');

            if ($iddatphong2) {
                $soluongdat2 = $this->db->selectFirstColumnValue($sql, 'soluongdat');
                $sql = "UPDATE datphong SET soluongdat = soluongdat + $soluonghuy, tonggia = (tonggia + (tonggia / $soluongdat2) * $soluonghuy)
                WHERE iddatphong = '$iddatphong2'";
                if ($this->db->execute($sql)) {
                    $sql = "DELETE FROM datphong WHERE iddatphong = $iddatphong";
                    return $this->db->execute($sql);
                }
            } else {
                $sql = "UPDATE datphong SET trangthaidat = 'Đã hủy' WHERE iddatphong = '$iddatphong'";
                return $this->db->execute($sql);
            }
        } else {
            $sql = "UPDATE datphong SET soluongdat = soluongdat - $soluonghuy, tonggia = (tonggia - (tonggia / $soluongdat) * $soluonghuy) 
            WHERE iddatphong = '$iddatphong'";
            if ($this->db->execute($sql)) {

                $sql = "SELECT iddatphong, soluongdat FROM datphong where id_dondat = '$iddondat' and id_phong = '$id_phong' and trangthaidat = 'Đã hủy'";
                $iddatphong2 = $this->db->selectFirstColumnValue($sql, 'iddatphong');

                if ($iddatphong2) {
                    $soluongdat2 = $this->db->selectFirstColumnValue($sql, 'soluongdat');
                    $sql = "UPDATE datphong SET soluongdat = soluongdat + $soluonghuy, tonggia = (tonggia + (tonggia / $soluongdat2) * $soluonghuy)
                    WHERE iddatphong = '$iddatphong2'";
                    return $this->db->execute($sql);
                } else {
                    foreach ($datphong as $item) {
                        $ngayden = $item['ngayden'];
                        $ngaydi = $item['ngaydi'];
                        $id_phong = $item['id_phong'];
                        $id_dondat = $item['id_dondat'];
                        $id_taikhoan = $item['id_taikhoan'] ?? 'NULL';
                        $tonggia = intval($item['tonggia']);
                        $tonggiahuy = ($tonggia / $soluongdat) * intval($soluonghuy);
                        $sql = "INSERT INTO datphong(ngayden, ngaydi, soluongdat, tonggia, trangthaidat, id_phong, id_dondat, id_taikhoan) 
                        VALUES ('$ngayden','$ngaydi','$soluonghuy','$tonggiahuy','Đã hủy','$id_phong','$id_dondat', $id_taikhoan)";
                    }
                    return $this->db->execute($sql);
                }
            } else {
                return false;
            }
        }
    }


    public function getEmailCustommerByInvoice($iddondat)
    {
        $sql = "SELECT email FROM khachhang join thanhtoan on khachhang.idkhachhang = thanhtoan.id_khachhang
        WHERE id_dondat = '$iddondat'";
        $result = $this->db->selectFirstColumnValue($sql, 'email');
        return $result;
    }


    public function updateCancelInvoiceRoom($iddondat, $iddatphong, $trangthaidon, $soluonghuy)
    {
        $soluonghuy = intval($soluonghuy);
        // Lấy id khách hàng
        $sql = "SELECT id_khachhang FROM thanhtoan WHERE id_dondat = '$iddondat'";
        $idkhachhang = $this->db->selectFirstColumnValue($sql, 'id_khachhang');

        // Lấy giá phòng hủy
        $sql = "SELECT (tonggia / soluongdat) as giaphong FROM datphong WHERE iddatphong = '$iddatphong'";
        $giaphong = $this->db->selectFirstColumnValue($sql, 'giaphong');

        if ($idkhachhang && $giaphong) {

            $sql = "SELECT id_phong FROM datphong WHERE iddatphong = '$iddatphong'";
            $id_phong = $this->db->selectFirstColumnValue($sql, 'id_phong');

            //update đặt phòng
            $update = $this->updateCancelBooking($iddatphong, $soluonghuy, $iddondat, $id_phong);

            if ($trangthaidon == 'Đã thanh toán') {
                $sotienphaitra = intval($giaphong) * 0.75 * $soluonghuy;
            } else {
                $sotienphaitra = intval($giaphong) * 0.25 * $soluonghuy;
            }
            $ngaythanhtoan = date('Y-m-d H:i:s');

            // Trả lại cho khách hàng số tiền khi hủy
            $sql = "INSERT INTO thanhtoan (ngaythanhtoan, sotienthanhtoan, kieuthanhtoan, id_dondat, id_khachhang) 
                VALUES ('$ngaythanhtoan', '-$sotienphaitra', 'Thanh toán qua VnPay', '$iddondat', '$idkhachhang')";
            $pay = $this->db->execute($sql);

            if ($pay && $update) {
                $sql = "SELECT iddatphong FROM datphong WHERE id_dondat = '$iddondat' AND trangthaidat != 'Đã hủy'";
                $count = $this->db->rowCount($sql);

                if ($trangthaidon == 'Đã thanh toán') {
                    $tongsotien = intval($giaphong) * $soluonghuy;
                    $tienboithuong = intval($giaphong) * $soluonghuy * 0.25;
                    $sql = "UPDATE dondat SET tongsotien = tongsotien - $tongsotien + $tienboithuong";
                } else {
                    $tongsotien = intval($giaphong) * $soluonghuy;
                    $tienboithuong = intval($giaphong) * $soluonghuy * 0.25;
                    $sotiencoc = intval($giaphong) * 0.5 * $soluonghuy;
                    $conthieu = $tongsotien - $sotiencoc;
                    $sql = "UPDATE dondat SET tongsotien = tongsotien - $tongsotien + $tienboithuong, sotiencoc = sotiencoc - $sotiencoc, sotienconthieu = sotienconthieu - $conthieu";
                }

                if ($count > 0) {
                    $sql .= " WHERE iddondat = '$iddondat'";
                } else {
                    $sql .= ", trangthaidon = 'Đã hủy' WHERE iddondat = '$iddondat'";
                }

                $result = $this->db->execute($sql);
                if ($result) {
                    return true;
                }
            }
        }
        return false;
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

        $sql = "UPDATE datphong SET ";
        if (!empty($ngayden)) {
            $sql .= "ngayden = '$ngayden',";
        }
        if (!empty($ngaydi)) {
            $sql .= "ngaydi = '$ngaydi',";
        }
        $sql .= "soluongdat='$soluongdat', tonggia='$tonggia' WHERE iddatphong = '$iddatphong'";

        $result = $this->db->execute($sql);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function updateIdInvoice($iddatphong, $id_dondat, $trangthai)
    {
        $sql = "UPDATE datphong SET id_dondat = '$id_dondat', trangthaidat = '$trangthai' WHERE iddatphong = '$iddatphong'";
        $result = $this->db->execute($sql);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }


    public function updateCartNumberByIdRoom($soluongdat, $tonggia, $idphong, $idtaikhoan)
    {
        $sql = "UPDATE datphong SET soluongdat = $soluongdat + soluongdat, tonggia = $tonggia + tonggia 
        WHERE id_dondat is null and trangthaidat = 'Giỏ hàng' and id_taikhoan = $idtaikhoan && id_phong = $idphong";
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
        $sql = "SELECT * FROM datphong WHERE id_taikhoan = $idtaikhoan and id_dondat is null and trangthaidat = 'Giỏ hàng'";
        $result = $this->db->rowCount($sql);
        return $result;
    }

    public function checkCartNumberByIdRoom($idtaikhoan, $ngayden, $ngaydi, $idphong)
    {
        $sql = "SELECT * FROM datphong WHERE id_taikhoan = $idtaikhoan and id_dondat is null 
        and trangthaidat = 'Giỏ hàng' and id_phong = $idphong ";
        if (!empty($ngayden)) {
            $sql .= " and ngayden = '$ngayden' ";
        }
        if (!empty($ngaydi)) {
            $sql .= " and ngaydi = '$ngaydi' ";
        }
        $result = $this->db->rowCount($sql);
        return $result;
    }

    public function updateTotalPrice($iddatphong, $idphong)
    {

        $sql = "SELECT khuyenmai.khuyenmai FROM khuyenmai join chitietkhuyenmai on khuyenmai.idkhuyenmai = chitietkhuyenmai.id_khuyenmai 
        where chitietkhuyenmai.id_phong = '$idphong' AND CURDATE() BETWEEN khuyenmai.ngaybatdau AND khuyenmai.ngayketthuc";
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


    //lấy các phòng thêm giỏ hàng
    public function getBookingInCart($idtaikhoan)
    {
        $sql = "SELECT * FROM datphong where id_taikhoan = $idtaikhoan and id_dondat is null and trangthaidat = 'Giỏ hàng'";
        $result = $this->db->select($sql);
        return $result;
    }

    //kiểm tra người dùng đã đánh giá phòng hay chưa
    public function checkRatingRoom($idtaikhoan, $idphong)
    {
        $sql = "SELECT * FROM datphong join taikhoan on datphong.id_taikhoan = taikhoan.idtaikhoan
        join danggia on taikhoan.idtaikhoan = danhgia.id_taikhoan
        where datphon.id_phong = danhgia.id_phong = '$idphong' and taikhoan.idtaikhoan = '$idtaikhoan'";
        $result = $this->db->select($sql);
        return $result;
    }


    //lịch sử đặt
    public function getBookingHistoryByStatus($idtaikhoan, $status = null)
    {
        if (!empty($status)) {
            $arr = explode(", ", $status);

            if (count($arr) > 1) {
                $sql = "SELECT * FROM dondat JOIN datphong ON dondat.iddondat = datphong.id_dondat WHERE (";
                $dem = 0;
                foreach ($arr as $i) {
                    $sql .= "datphong.trangthaidat = '" . trim($i) . "'";
                    $dem++;
                    if (count($arr) > $dem) {
                        $sql .= " OR ";
                    }
                }
                $sql .= ") AND datphong.id_taikhoan = '$idtaikhoan' ORDER BY thoigiandat DESC";
            } else {
                $sql = "SELECT * FROM dondat JOIN datphong ON dondat.iddondat = datphong.id_dondat 
                WHERE datphong.trangthaidat = '$status' AND datphong.id_taikhoan = '$idtaikhoan' ORDER BY thoigiandat DESC";
            }
        } else {
            $sql = "SELECT * FROM dondat JOIN datphong ON dondat.iddondat = datphong.id_dondat 
            WHERE datphong.id_taikhoan = '$idtaikhoan' ORDER BY thoigiandat DESC";
        }
        $result = $this->db->select($sql);
        return $result;
    }


    public function getBookingInvoiceByStatus($iddondat, $status = null)
    {
        if (!empty($status)) {
            $arr = explode(", ", $status);

            if (count($arr) > 1) {
                $sql = "SELECT * FROM dondat JOIN datphong ON dondat.iddondat = datphong.id_dondat WHERE (";
                $dem = 0;
                foreach ($arr as $i) {
                    $sql .= "datphong.trangthaidat = '" . trim($i) . "'";
                    $dem++;
                    if (count($arr) > $dem) {
                        $sql .= " OR ";
                    }
                }
                $sql .= ") AND dondat.iddondat = '$iddondat' ORDER BY thoigiandat DESC";
            } else {
                $sql = "SELECT * FROM dondat JOIN datphong ON dondat.iddondat = datphong.id_dondat 
                WHERE datphong.trangthaidat = '$status' AND dondat.iddondat = '$iddondat' ORDER BY thoigiandat DESC";
            }
        } else {
            $sql = "SELECT * FROM dondat JOIN datphong ON dondat.iddondat = datphong.id_dondat 
            WHERE dondat.iddondat = '$iddondat' ORDER BY thoigiandat DESC";
        }
        $result = $this->db->select($sql);
        return $result;
    }

    //------------------------------------------thêm 1 đơn đặt------------------------------------------
    public function createInvoice($iddondat, $trangthaidon, $tongsotien, $sotiencoc, $sotienconthieu, $thoigiandat)
    {
        $sql = "INSERT INTO dondat(iddondat, trangthaidon, tongsotien, sotiencoc, sotienconthieu, thoigiandat) 
        VALUES ('$iddondat','$trangthaidon','$tongsotien','$sotiencoc','$sotienconthieu', '$thoigiandat')";
        $result = $this->db->execute($sql);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }


    //-----------------------------------------------admin---------------------------------------------------//

    public function countBookingsInvoice()
    {
        $sql = "SELECT COUNT(*) as count FROM dondat join thanhtoan on dondat.iddondat = thanhtoan.id_dondat 
        where dondat.thoigiandat = thanhtoan.ngaythanhtoan";
        $result = $this->db->selectFirstColumnValue($sql, 'count');
        return $result;
    }

    public function getBookingsInvoiceByPage($per_page, $offset)
    {
        $sql = "SELECT * FROM dondat join thanhtoan on dondat.iddondat = thanhtoan.id_dondat 
        where dondat.thoigiandat = thanhtoan.ngaythanhtoan ORDER BY dondat.thoigiandat DESC
        LIMIT $per_page OFFSET $offset";
        $result = $this->db->select($sql);
        return $result;
    }


    public function cancelInvoice($iddondat)
    {
        $sql = "UPDATE dondat set trangthaidon = 'Đã hủy', tongsotien = sotiencoc, sotiencoc = 0, sotienconthieu = 0 WHERE iddondat = '$iddondat'";
        $kq1 = $this->db->execute($sql);
        if ($kq1) {
            $sql = "UPDATE datphong set trangthaidat = 'Đã hủy' WHERE id_dondat = '$iddondat'";
            $kq2 =  $this->db->execute($sql);
            if ($kq2) {
                return true;
            }
        }
        return false;
    }

    public function paymentBooking($iddondat)
    {
        $sql = "UPDATE dondat set trangthaidon = 'Đã thanh toán', sotiencoc = 0, sotienconthieu = 0 WHERE iddondat = '$iddondat'";
        $kq1 = $this->db->execute($sql);
        if ($kq1) {
            $sql = "UPDATE datphong set trangthaidat = 'Đã thanh toán' WHERE id_dondat = '$iddondat' and trangthaidat != 'Đã hủy'";
            $kq2 =  $this->db->execute($sql);
            if ($kq2) {
                return true;
            }
        }
        return false;
    }

    public function completedInvoice($iddondat)
    {
        $sql = "UPDATE dondat set trangthaidon = 'Hoàn tất' WHERE iddondat = '$iddondat'";
        $kq1 = $this->db->execute($sql);
        if ($kq1) {
            $sql = "UPDATE datphong set trangthaidat = 'Hoàn tất' WHERE id_dondat = '$iddondat' and trangthaidat != 'Đã hủy'";
            $kq2 =  $this->db->execute($sql);
            if ($kq2) {
                return true;
            }
        }
        return false;
    }

    public function getCheckoutMaxBooking($id)
    {
        $sql = "SELECT MAX(ngaydi) as MAX FROM datphong where id_dondat = $id";
        $result = $this->db->selectFirstColumnValue($sql, "MAX");
        return $result;
    }


    public function getBookingsById($id)
    {
        $sql = "SELECT * FROM dondat join datphong on dondat.iddondat = datphong.id_dondat
        join phong on phong.idphong = datphong.id_phong where dondat.iddondat = '$id'";
        $result = $this->db->select($sql);
        return $result;
    }

    //thực tế tháng này
    public function actualTotalRevenue()
    {
        $sql = "SELECT SUM(sotienthanhtoan) AS tongsotien FROM thanhtoan join dondat on thanhtoan.id_dondat = dondat.iddondat
        WHERE  MONTH(ngaythanhtoan) = MONTH(CURRENT_DATE()) AND YEAR(ngaythanhtoan) = YEAR(CURRENT_DATE())
        AND dondat.trangthaidon = 'Hoàn tất'";
        $result = $this->db->selectFirstColumnValue($sql, 'tongsotien');
        return $result ?? 0;
    }

    //dự tính tháng này
    public function estimatedTotalRevenue()
    {
        $sql = "SELECT SUM(tongsotien) AS tongsotien FROM dondat
        WHERE MONTH(thoigiandat) = MONTH(CURRENT_DATE()) AND YEAR(thoigiandat) = YEAR(CURRENT_DATE())
        AND trangthaidon != 'Đã hủy'";
        $result = $this->db->selectFirstColumnValue($sql, 'tongsotien');
        return $result ?? 0;
    }

    //khoản trừ đơn hủy đặt tháng này
    public function deductibleRevenue()
    {
        $sql = "SELECT SUM(tongsotien) AS tongsotien FROM dondat
        WHERE  MONTH(thoigiandat) = MONTH(CURRENT_DATE()) AND YEAR(thoigiandat) = YEAR(CURRENT_DATE())
        AND trangthaidon = 'Đã hủy'";
        $result = $this->db->selectFirstColumnValue($sql, 'tongsotien');
        return $result ?? 0;
    }

    //đếm số đơn theo tháng
    public function countNumberBooking($month)
    {
        $sql = "SELECT COUNT(iddondat) AS sodon
        FROM dondat WHERE MONTH(thoigiandat) = '$month' AND YEAR(thoigiandat) = YEAR(CURRENT_DATE())";
        $result = $this->db->selectFirstColumnValue($sql, 'sodon');
        return $result ?? 0;
    }

    //đếm tổng số tiền theo tháng
    public function countTotalAmountBooking($month)
    {
        $sql = "SELECT SUM(sotienthanhtoan) AS tongsotien FROM thanhtoan join dondat on thanhtoan.id_dondat = dondat.iddondat
        WHERE  MONTH(ngaythanhtoan) = '$month' AND YEAR(ngaythanhtoan) = YEAR(CURRENT_DATE())
        AND dondat.trangthaidon = 'Hoàn tất'";
        $result = $this->db->selectFirstColumnValue($sql, 'tongsotien');
        return $result ?? 0;
    }

    //đếm số đơn theo trạng thái
    public function countNumberBookingByStatus($status)
    {
        $sql = "SELECT Count(iddondat) AS sodon From dondat
        WHERE  MONTH(thoigiandat) = MONTH(CURRENT_DATE()) AND YEAR(thoigiandat) = YEAR(CURRENT_DATE())
        AND trangthaidon = '$status'";
        $result = $this->db->selectFirstColumnValue($sql, 'sodon');
        return $result ?? 0;
    }


    public function getBookingExport($start, $end, $status)
    {
        $sql = "SELECT iddondat, hoten, email, sdt, thoigiandat, tongsotien, sotiencoc, sotienconthieu, trangthaidon 
        FROM dondat join thanhtoan on dondat.iddondat = thanhtoan.id_dondat 
        join khachhang on khachhang.idkhachhang = thanhtoan.id_khachhang
        where dondat.thoigiandat = thanhtoan.ngaythanhtoan and dondat.trangthaidon = '$status'
        and (dondat.thoigiandat BETWEEN '$start' AND '$end')
        ORDER BY dondat.thoigiandat";
        $result = $this->db->select($sql);
        return $result;
    }
}
