<?php
class AccountModel
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

    public function createAccount($Surname, $name, $email, $pass, $accountType = 'user', $date)
    {
        $password = password_hash($pass, PASSWORD_DEFAULT);
        $sql = "INSERT INTO taikhoan (ho, ten, email, matkhau, trangthai, loaitk, ngaytao) VALUES ('$Surname','$name','$email','$password', 'Hoạt động', '$accountType', '$date')";

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
        $sql = "SELECT matkhau FROM taikhoan WHERE email= '$email'";
        $password = $this->db->selectFirstColumnValue($sql, "matkhau");
        if (password_verify($pass, $password)) {
            $sql = "SELECT trangthai FROM taikhoan WHERE email= '$email'";
            $result = $this->db->selectFirstColumnValue($sql, "trangthai");
            return $result ?? null;
        } else {
            return null;
        }
    }


    public function checkAccountAdmin($email, $pass)
    {
        $sql = "SELECT matkhau FROM taikhoan WHERE email= '$email'";
        $password = $this->db->selectFirstColumnValue($sql, "matkhau");
        if (password_verify($pass, $password)) {
            $sql = "SELECT loaitk FROM taikhoan WHERE email= '$email'";
            $result = $this->db->selectFirstColumnValue($sql, "loaitk");
            return $result ?? null;
        } else {
            return null;
        }
    }

    //kiểm tra email đăng ký
    public function checkEmail($email)
    {
        $sql = "SELECT * FROM taikhoan WHERE email= '$email'";
        $result = $this->db->rowCount($sql);
        return $result ?? null;
    }

    public function updateAccount($idtaikhoan, $ho, $ten, $sdt, $anh, $diachi)
    {
        $sql = "UPDATE taikhoan SET ho = '$ho', ten = '$ten', sdt = '$sdt', anh = '$anh', diachi = '$diachi' where idtaikhoan = '$idtaikhoan'";
        $result = $this->db->execute($sql);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }


    public function changePass($email, $pass)
    {
        $password = password_hash($pass, PASSWORD_DEFAULT);
        $sql = "UPDATE taikhoan SET matkhau = '$password' WHERE email = '$email'";
        $result = $this->db->execute($sql);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }


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


    public function lockAccount($id)
    {
        $sql = "UPDATE taikhoan SET trangthai = 'Khóa' WHERE idtaikhoan = '$id'";
        $result = $this->db->execute($sql);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function unLockAccount($id)
    {
        $sql = "UPDATE taikhoan SET trangthai = 'Hoạt động' WHERE idtaikhoan = '$id'";
        $result = $this->db->execute($sql);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }
}
