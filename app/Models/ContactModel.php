<?php
class ContactModel
{
    private $db;
    public function __construct()
    {
        $this->db = new Database();
    }

    public function getContacts()
    {
        $sql = "SELECT * FROM lienhe";
        $result = $this->db->select($sql);
        return $result ?? null;
    }

    public function createContact($fullname, $email, $subject, $mess)
    {
        $sql = "INSERT INTO lienhe (hoten, email, chude, noidung, trangthai , id_khachsan) VALUES ('$fullname','$email','$subject', '$mess','Chờ phản hồi', 1)";
        $result = $this->db->execute($sql);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function updadeContact($idlienhe)
    {
        $sql = "UPDATE lienhe set trangthai = 'Đã phản hồi' where idlienhe = '$idlienhe'";
        $result = $this->db->execute($sql);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function findContactById($id)
    {
        $sql = "SELECT * FROM lienhe WHERE idlienhe = '$id'";
        $result = $this->db->select($sql);
        return $result ?? null;
    }

    public function deleteContact($id)
    {
        $sql = "DELETE FROM lienhe WHERE idlienhe = '$id'";
        $result = $this->db->execute($sql);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }
}
