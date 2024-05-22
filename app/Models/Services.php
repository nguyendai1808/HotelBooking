<?php
class Services
{
    private $db;
    public function __construct()
    {
        $this->db = new Database();
    }

    public function getServices($LIMIT = null)
    {
        if (empty($LIMIT)) {
            $sql = "SELECT * FROM dichvu order by tendichvu";
        } else {
            $sql = "SELECT * FROM dichvu order by tendichvu LIMIT $LIMIT";
        }
        $result = $this->db->select($sql);
        return $result;
    }


    // public function createServices($name, $mail, $add)
    // {
    //     $sql = "INSERT INTO taikhoan (name,email,address)
    //             VALUES ('$name','$mail','$add')";
    //     $result = $this->db->execute($sql);
    //     if ($result) {
    //         return true;
    //     } else {
    //         return false;
    //     }
    // }

    public function findServiceById($id)
    {
        $sql = "SELECT * FROM dichvu WHERE iddichvu = '$id'";
        $result = $this->db->select($sql);
        return $result;
    }

    // public function updateServices($id, $name, $mail, $add)
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

    public function deleteService($id)
    {
        $sql = "DELETE FROM dichvu WHERE iddichvu = '$id'";
        $result = $this->db->execute($sql);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }
}
