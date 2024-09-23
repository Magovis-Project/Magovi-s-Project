<?php

require_once(__DIR__ . '/../../core/Database.php');

class UserModel
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getUsers()
    {
        $sql = "SELECT id, nombre, email FROM usuarios";
        $result = $this->db->query($sql);
        
        $users = [];
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $users[] = $row;
            }
        }
        return $users;
    }

    public function __destruct()
    {
        $this->db->close();
    }
}
?>
