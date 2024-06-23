<?php
class ImageModel
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


    public function findRoomImageById($id)
    {
        $sql = "SELECT CONCAT(duongdan, '/', tenanh) as anh, idanhphong FROM anhphong WHERE id_phong = '$id' ORDER BY idanhphong";
        $result = $this->db->select($sql);
        return $result;
    }

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
