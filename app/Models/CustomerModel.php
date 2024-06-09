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
        $sql = "SELECT * FROM khachhang";
        $result = $this->db->select($sql);
        return $result ?? null;
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

    public function findCustomerById($id)
    {
        $sql = "SELECT * FROM khachhang WHERE idkhachhang = '$id'";
        $result = $this->db->select($sql);
        return $result ?? null;
    }

    public function getNameCustomer($id)
    {
        $sql = "SELECT * FROM khachhang WHERE idkhachhang = '$id'";
        $result = $this->db->selectFirstColumnValue($sql, "hoten");
        return $result;
    }


    public function findCustomer($fullname, $email, $phone, $address)
    {
        $sql = "SELECT idkhachhang FROM khachhang WHERE hoten LIKE '%$fullname%' and email = '$email' and sdt = '$phone' and diachi LIKE '%$address%'";
        $result = $this->db->selectFirstColumnValue($sql, 'idkhachhang');
        return $result ?? null;
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
