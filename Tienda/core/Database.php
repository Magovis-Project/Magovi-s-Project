<?php

class Database
{
    private $conn;

    public function __construct()
    {
        $config = include(__DIR__ . '/../config/database.php');
        $this->conn = new mysqli($config['host'], $config['username'], $config['password'], $config['database']);

        if ($this->conn->connect_error) {
            die("Conexión fallida: " . $this->conn->connect_error);
        }
    }

    public function query($sql)
    {
        return $this->conn->query($sql);
    }

    public function escape_string($value)
    {
        return $this->conn->real_escape_string($value);
    }

    public function close()
    {
        $this->conn->close();
    }
}
?>
