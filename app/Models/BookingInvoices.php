<?php
class BookingInvoices
{
    private $db;
    public function __construct()
    {
        $this->db = new Database();
    }

    public function getBookingInvoices()
    {
        $sql = "SELECT * FROM dondat";
        $result = $this->db->select($sql);
        return $result;
    }

    public function createBookingInvoice($iddondat, $trangthaidon, $tongsotien, $sotiencoc, $sotienconthieu, $thoigiandat)
    {
        $sql = "INSERT INTO `dondat`(`iddondat`, `trangthaidon`, `tongsotien`, `sotiencoc`, `sotienconthieu`, `thoigiandat`) VALUES ($iddondat,'$trangthaidon','$tongsotien','$sotiencoc','$sotienconthieu', '$thoigiandat')";
        $result = $this->db->execute($sql);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    // public function findCategoryById($id)
    // {
    //     $sql = "SELECT * FROM danhmuc WHERE iddanhmuc = '$id'";
    //     $result = $this->db->select($sql);
    //     return $result;
    // }

    // public function updateCategory($id, $name)
    // {
    //     $sql = "UPDATE danhmuc SET tendanhmuc = '$name' WHERE iddanhmuc = '$id'";
    //     $result = $this->db->execute($sql);
    //     if ($result) {
    //         return true;
    //     } else {
    //         return false;
    //     }
    // }

    // public function deleteCategory($id)
    // {
    //     $sql = "DELETE FROM danhmuc WHERE iddanhmuc = '$id'";
    //     $result = $this->db->execute($sql);
    //     if ($result) {
    //         return true;
    //     } else {
    //         return false;
    //     }
    // }

    // public function checkQuantityCart($email)
    // {
    //     $sql = "SELECT * FROM taikhoan WHERE email= '$email'";
    //     $result = $this->db->rowCount($sql);
    //     return $result;
    // }

    // public function getNextIdBookingInvoice()
    // {
    //     $sql = "SELECT MAX(iddondat) AS max_id FROM dondat";
    //     $result = $this->db->selectFirstColumnValue($sql, 'max_id');
    //     return $result ?? 1;
    // }
}
