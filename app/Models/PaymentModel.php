<?php
class PaymentModel
{
    private $db;
    public function __construct()
    {
        $this->db = new Database();
    }

    public function getPayments()
    {
        $sql = "SELECT * FROM thanhtoan";
        $result = $this->db->select($sql);
        return $result;
    }

    public function createPayment($ngay, $sotien, $kieutt, $id_dondat, $id_khachhang)
    {
        $sql = "INSERT INTO thanhtoan (ngaythanhtoan, sotienthanhtoan, kieuthanhtoan, id_dondat, id_khachhang) VALUES ('$ngay','$sotien','$kieutt','$id_dondat', '$id_khachhang')";
        $result = $this->db->execute($sql);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function findPaymentById($id)
    {
        $sql = "SELECT * FROM thanhtoan WHERE idthanhtoan = '$id'";
        $result = $this->db->select($sql);
        return $result;
    }



    public function deletePayment($id)
    {
        $sql = "DELETE FROM thanhtoan WHERE idthanhtoan = '$id'";
        $result = $this->db->execute($sql);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

}
