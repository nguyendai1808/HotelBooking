<?php
class Customers
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

    public function createCustomer($fullname, $email, $phone)
    {
        $sql = "INSERT INTO khachhang (hoten, email, sdt) VALUES ('$fullname','$email','$phone')";

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

    public function findCustomer($fullname, $email, $phone)
    {
        $sql = "SELECT idkhachhang FROM khachhang WHERE hoten = '$fullname' and email = '$email' and sdt = '$phone'";
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
