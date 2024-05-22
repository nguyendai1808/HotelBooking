<?php
class Accounts
{
    private $db;
    public function __construct()
    {
        $this->db = new Database();
    }

    public function getAccount()
    {
        $sql = "SELECT * FROM taikhoan";
        $result = $this->db->select($sql);
        return $result ?? null;
    }

    public function createAccount($Surname, $name, $email, $pass, $accountType = 1)
    {
        $sql = "INSERT INTO taikhoan (ho, ten, email, matkhau, loaitk) VALUES ('$Surname','$name','$email','$pass','$accountType')";

        $result = $this->db->execute($sql);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function findAccountById($id)
    {
        $sql = "SELECT * FROM taikhoan WHERE idtaikhoan = '$id'";
        $result = $this->db->select($sql);
        return $result ?? null;
    }

    public function findAccountByEmail($email)
    {
        $sql = "SELECT * FROM taikhoan WHERE email = '$email'";
        $result = $this->db->select($sql);
        return $result ?? null;
    }

    public function getIdAccountByEmail($email)
    {
        $sql = "SELECT * FROM taikhoan WHERE email = '$email'";
        $result = $this->db->selectFirstColumnValue($sql, 'idtaikhoan');
        return $result ?? null;
    }


    //kiểm tra tài khoản đăng nhập
    public function checkAccount($email, $pass)
    {
        $sql = "SELECT * FROM taikhoan WHERE email= '$email' && matkhau= '$pass'";
        $result = $this->db->selectFirstColumnValue($sql, "loaitk");
        return $result ?? null;
    }

    //kiểm tra email đăng ký
    public function checkEmail($email)
    {
        $sql = "SELECT * FROM taikhoan WHERE email= '$email'";
        $result = $this->db->rowCount($sql);
        return $result ?? null;
    }


    // public function updateAccount($id, $name, $mail, $add)
    // {
    //     $sql = "UPDATE taikhoan SET name = '$name',
    //                                 email = '$mail',
    //                                 address = '$add'
    //                             WHERE id = '$id'";
    //     $result = $this->db->execute($sql);
    //     if ($result) {
    //         return true;
    //     } else {
    //         return false;
    //     }
    // }

    public function deleteAccount($id)
    {
        $sql = "DELETE FROM taikhoan WHERE idtaikhoan = '$id'";
        $result = $this->db->execute($sql);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }
}
