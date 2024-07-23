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
        return $result;
    }

    public function countAccountUser()
    {
        $sql = "SELECT COUNT(*) as count FROM taikhoan where loaitk != 'admin'";
        $result = $this->db->selectFirstColumnValue($sql, 'count');
        return $result;
    }

    public function getAccountUserByPage($per_page, $offset)
    {
        $sql = "SELECT * FROM taikhoan where loaitk != 'admin'
        LIMIT $per_page OFFSET $offset";
        $result = $this->db->select($sql);
        return $result;
    }

    public function getAccountImageById($idtaikhoan)
    {
        $sql = "SELECT anh FROM taikhoan where idtaikhoan = '$idtaikhoan'";
        $result = $this->db->selectFirstColumnValue($sql, 'anh');
        return $result;
    }

    public function createAccount2($Surname, $name, $email, $phone, $pass, $accountType)
    {
        $password = password_hash($pass, PASSWORD_DEFAULT);
        $sql = "INSERT INTO taikhoan (ho, ten, email, sdt, matkhau, trangthai, loaitk, ngaytao) VALUES ('$Surname','$name','$email','$phone','$password', 'Hoạt động', '$accountType', NOW())";
        $result = $this->db->execute($sql);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function createAccount($Surname, $name, $email, $pass, $accountType = 'user')
    {
        $password = password_hash($pass, PASSWORD_DEFAULT);
        $sql = "INSERT INTO taikhoan (ho, ten, email, matkhau, trangthai, loaitk, ngaytao) VALUES ('$Surname','$name','$email','$password', 'Hoạt động', '$accountType', NOW())";
        $result = $this->db->execute($sql);
        if ($result) {
            $idkhachhang = $this->getIdCustomerByEmail($email);
            $idtaikhoan = $this->getIdAccountByEmail($email);
            if ($idkhachhang && $idtaikhoan) {
                $list_id =  $this->getListIdInvoice($idkhachhang);
                foreach ($list_id as $id) {
                    $this->updateIdInvoice($id, $idtaikhoan);
                }
            }
            return true;
        } else {
            return false;
        }
    }

    public function getIdCustomerByEmail($email)
    {
        $sql = "SELECT idkhachhang FROM khachhang where email = '$email'";
        $result = $this->db->selectFirstColumnValue($sql, 'idkhachhang');
        return $result;
    }

    public function getListIdInvoice($idkhachhang)
    {
        $sql = "SELECT id_dondat FROM thanhtoan where id_khachhang = '$idkhachhang' GROUP BY id_dondat";
        $result = $this->db->selectColumnValues($sql, 'id_dondat');
        return $result;
    }

    public function updateIdInvoice($idondat, $idtaikhoan)
    {
        $sql = "UPDATE datphong set id_taikhoan = '$idtaikhoan' where id_dondat = '$idondat' and (id_taikhoan is null or id_taikhoan = '')";
        $result = $this->db->execute($sql);
        return $result;
    }

    public function findAccountById($id)
    {
        $sql = "SELECT * FROM taikhoan WHERE idtaikhoan = '$id'";
        $result = $this->db->select($sql);
        return $result;
    }

    public function findAccountByEmail($email)
    {
        $sql = "SELECT * FROM taikhoan WHERE email = '$email'";
        $result = $this->db->select($sql);
        return $result;
    }

    public function getIdAccountByEmail($email)
    {
        $sql = "SELECT idtaikhoan FROM taikhoan WHERE email = '$email'";
        $result = $this->db->selectFirstColumnValue($sql, 'idtaikhoan');
        return $result;
    }

    //kiểm tra tài khoản đăng nhập
    public function checkAccount($email, $pass)
    {
        $sql = "SELECT matkhau FROM taikhoan WHERE email= '$email'";
        $password = $this->db->selectFirstColumnValue($sql, "matkhau");
        if (password_verify($pass, $password)) {
            $sql = "SELECT trangthai FROM taikhoan WHERE email= '$email'";
            $result = $this->db->selectFirstColumnValue($sql, "trangthai");
            return $result;
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
            return $result;
        } else {
            return null;
        }
    }

    //kiểm tra email đăng ký
    public function checkEmail($email)
    {
        $sql = "SELECT * FROM taikhoan WHERE email= '$email'";
        $result = $this->db->rowCount($sql);
        return $result;
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
