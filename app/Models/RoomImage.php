<?php
class RoomImage
{
    private $db;
    public function __construct()
    {
        $this->db = new Database();
    }

    public function getRoomImage()
    {
        $sql = "SELECT * FROM anhphong";
        $result = $this->db->select($sql);
        return $result;
    }

    // public function createRoomImage($name)
    // {
    //     $sql = "INSERT INTO danhmuc VALUES (null,'$name')";
    //     $result = $this->db->execute($sql);
    //     if ($result) {
    //         return true;
    //     } else {
    //         return false;
    //     }
    // }

    public function findRoomImageById($id)
    {
        $sql = "SELECT * FROM anhphong WHERE id_phong = '$id'";
        $result = $this->db->select($sql);
        return $result;
    }

    // public function updateRoomImage($id, $name)
    // {
    //     $sql = "UPDATE danhmuc SET tendanhmuc = '$name' WHERE iddanhmuc = '$id'";
    //     $result = $this->db->execute($sql);
    //     if ($result) {
    //         return true;
    //     } else {
    //         return false;
    //     }
    // }

    public function deleteRoomImage($id)
    {
        $sql = "DELETE FROM anhphong WHERE idanhphong = '$id'";
        $result = $this->db->execute($sql);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }
}
