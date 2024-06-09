<?php
class ServiceModel
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


    public function createServices($name, $desc, $icon)
    {
        $sql = "INSERT INTO dichvu (tendichvu, mota, icon, id_khachsan) VALUES ('$name','$desc','$icon', 1)";
        $result = $this->db->execute($sql);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function findServiceById($id)
    {
        $sql = "SELECT * FROM dichvu WHERE iddichvu = '$id'";
        $result = $this->db->select($sql);
        return $result;
    }

    public function updateServices($iddichvu, $name, $desc, $icon)
    {
        $sql = "UPDATE dichvu SET tendichvu = '$name', mota = '$desc', icon = '$icon' Where iddichvu = $iddichvu";
        $result = $this->db->execute($sql);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

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
