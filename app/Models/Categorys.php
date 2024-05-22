<?php
class Categorys
{
    private $db;
    public function __construct()
    {
        $this->db = new Database();
    }

    public function getCategorys()
    {
        $sql = "SELECT * FROM danhmuc";
        $result = $this->db->select($sql);
        return $result;
    }

    public function createCategory($name)
    {
        $sql = "INSERT INTO danhmuc VALUES (null,'$name')";
        $result = $this->db->execute($sql);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function findCategoryById($id)
    {
        $sql = "SELECT * FROM danhmuc WHERE iddanhmuc = '$id'";
        $result = $this->db->select($sql);
        return $result;
    }

    public function updateCategory($id, $name)
    {
        $sql = "UPDATE danhmuc SET tendanhmuc = '$name' WHERE iddanhmuc = '$id'";
        $result = $this->db->execute($sql);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function deleteCategory($id)
    {
        $sql = "DELETE FROM danhmuc WHERE iddanhmuc = '$id'";
        $result = $this->db->execute($sql);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function getNumberRoom($id)
    {
        $sql = "SELECT * FROM phong where id_danhmuc = $id";
        $result = $this->db->rowCount($sql);
        return $result;
    }
}
