<?php
class CategoryModel
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

    public function createCategory($name, $desc)
    {
        $sql = "INSERT INTO danhmuc VALUES (null,'$name','$desc')";
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

    public function updateCategory($id, $name, $desc)
    {
        $sql = "UPDATE danhmuc SET tendanhmuc = '$name', mota = '$desc' WHERE iddanhmuc = '$id'";
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
}
