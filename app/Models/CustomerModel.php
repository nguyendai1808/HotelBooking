<?php
class CustomerModel
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getCustomers()
    {
        $sql = "SELECT * FROM khachhang GROUP BY email";
        $result = $this->db->select($sql);
        return $result;
    }

    public function countCustomerInvoice()
    {
        $sql = "SELECT COUNT(*) as count FROM ( 
        SELECT email FROM khachhang 
        JOIN thanhtoan ON khachhang.idkhachhang = thanhtoan.id_khachhang GROUP BY email 
        ) as countCustomerInvoice";
        $result = $this->db->selectFirstColumnValue($sql, 'count');
        return $result;
    }

    public function getCustomerInvoiceByPage($per_page, $offset)
    {
        $sql = "SELECT *, COUNT(id_dondat) as sodon, SUM(sotienthanhtoan) as tongtien FROM khachhang 
        join thanhtoan on khachhang.idkhachhang = thanhtoan.id_khachhang GROUP BY email
        LIMIT $per_page OFFSET $offset";
        $result = $this->db->select($sql);
        return $result;
    }

    public function createCustomer($fullname, $email, $phone, $address)
    {
        $sql = "INSERT INTO khachhang (hoten, email, sdt, diachi) VALUES ('$fullname','$email','$phone', '$address')";

        $result = $this->db->execute($sql);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function getInvoiceCustomerById($id)
    {
        $sql = "SELECT * FROM thanhtoan join dondat on thanhtoan.id_dondat = dondat.iddondat WHERE thanhtoan.id_khachhang = '$id' ORDER BY dondat.thoigiandat DESC";
        $result = $this->db->select($sql);
        return $result;
    }


    public function findCustomerById($id)
    {
        $sql = "SELECT * FROM khachhang WHERE idkhachhang = '$id'";
        $result = $this->db->select($sql);
        return $result;
    }

    public function getNameCustomer($id)
    {
        $sql = "SELECT * FROM khachhang WHERE idkhachhang = '$id'";
        $result = $this->db->selectFirstColumnValue($sql, "hoten");
        return $result;
    }


    public function getIdCustomer($fullname, $email, $phone, $address)
    {
        $sql = "SELECT idkhachhang FROM khachhang WHERE hoten LIKE '%$fullname%' and email = '$email' and sdt = '$phone' and diachi LIKE '%$address%'";
        $result = $this->db->selectFirstColumnValue($sql, 'idkhachhang');
        return $result;
    }


    public function deleteCustomer($id)
    {
        $sql = "DELETE FROM khachhang WHERE idkhachhang = '$id'";
        $result = $this->db->execute($sql);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }
}
