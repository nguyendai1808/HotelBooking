<?php
class Database
{
    private $host = DB_HOST;
    private $user = DB_USER;
    private $pass = DB_PASS;
    private $name = DB_NAME;
    private $conn;

    public function __construct()
    {
        $this->conn = new mysqli($this->host, $this->user, $this->pass, $this->name);
    }

    //lấy dữ liệu
    public function select($sql)
    {
        $data = null;
        $result = $this->conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            return $data;
        } else {
            return null;
        }
    }

    // thêm sửa xóa
    public function execute($sql)
    {
        $result = $this->conn->query($sql);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    // đếm số hàng
    public function rowCount($sql)
    {
        $result = $this->conn->query($sql);
        if ($result) {
            return $result->num_rows;
        } else {
            return null;
        }
    }

    //lấy dữ liệu theo tên cột
    public function selectFirstColumnValue($sql, $columnName)
    {
        $result = $this->conn->query($sql);
        if ($result) {
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $data = $row[$columnName];
                    return $data;
                }
            }
        }
        return null;
    }

    //lấy dữ liệu theo tên cột
    public function selectColumnValues($sql, $columnName)
    {
        $data = null;
        $result = $this->conn->query($sql);
        if ($result) {
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $data[] = $row[$columnName];
                }
            }
        }
        return $data;
    }
}
