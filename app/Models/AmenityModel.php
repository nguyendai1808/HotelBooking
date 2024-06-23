<?php
class AmenityModel
{
    private $db;
    public function __construct()
    {
        $this->db = new Database();
    }

    public function getAmenities()
    {
        $sql = "SELECT * FROM tiennghi";
        $result = $this->db->select($sql);
        return $result;
    }

    public function createAmenity($name, $icon)
    {
        $sql = "INSERT INTO tiennghi (tentiennghi, icon) VALUES ('$name','$icon')";
        $result = $this->db->execute($sql);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function findAmenityById($id)
    {
        $sql = "SELECT * FROM tiennghi WHERE idtiennghi = '$id'";
        $result = $this->db->select($sql);
        return $result;
    }

    public function updateAmenity($idtiennghi, $nameNew, $iconNew)
    {
        if (empty($iconNew)) {
            $sql = "UPDATE tiennghi SET tentiennghi = '$nameNew' Where idtiennghi = '$idtiennghi'";
        } else {
            $sql = "UPDATE tiennghi SET tentiennghi = '$nameNew', icon = '$iconNew' Where idtiennghi = '$idtiennghi'";
        }

        $result = $this->db->execute($sql);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function deleteAmenity($id)
    {
        $sql = "DELETE FROM tiennghi WHERE idtiennghi = '$id'";
        $result = $this->db->execute($sql);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function getBeds()
    {
        $sql = "SELECT * FROM giuong";
        $result = $this->db->select($sql);
        return $result;
    }

    public function createBed($name)
    {
        $sql = "INSERT INTO giuong (tengiuong) VALUES ('$name')";
        $result = $this->db->execute($sql);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function findBedById($id)
    {
        $sql = "SELECT * FROM giuong WHERE idgiuong = '$id'";
        $result = $this->db->select($sql);
        return $result;
    }

    public function updateBed($idgiuong, $nameNew)
    {
        $sql = "UPDATE giuong SET tengiuong = '$nameNew' Where idgiuong = '$idgiuong'";
        $result = $this->db->execute($sql);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function deleteBed($id)
    {
        $sql = "DELETE FROM giuong WHERE idgiuong = '$id'";
        $result = $this->db->execute($sql);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }
}
