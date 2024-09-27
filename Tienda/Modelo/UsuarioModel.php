<?php
class UsuarioModel
{
    private $conn;

    public function __construct()
    {
        $this->conn = conexionModelo::getInstance()->getDatabaseInstance();
    }

    public function getUsuarios()
    {
        $consulta = $this->conn->prepare("SELECT * FROM usuario;");
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createUsuario($nombre, $apellido, $direccion, $foto, $email, $password, $telefono)
    {
        $consulta = $this->conn->prepare("INSERT INTO usuario (nombre, apellido, direccion, foto, email, password, telefono) 
                                          VALUES (:nombre, :apellido, :direccion, :foto, :email, :password, :telefono)");
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $consulta->bindParam(':nombre', $nombre);
        $consulta->bindParam(':apellido', $apellido);
        $consulta->bindParam(':direccion', $direccion);
        $consulta->bindParam(':foto', $foto);
        $consulta->bindParam(':email', $email);
        $consulta->bindParam(':password', $hashedPassword);
        $consulta->bindParam(':telefono', $telefono);
        $consulta->execute();
    }

    public function updateUsuario($id_usuario, $nombre, $apellido, $direccion, $foto, $email, $telefono)
    {
        $consulta = $this->conn->prepare("UPDATE usuario SET nombre = :nombre, apellido = :apellido, direccion = :direccion, 
                                          foto = :foto, email = :email, telefono = :telefono WHERE id_usuario = :id_usuario");
        $consulta->bindParam(':id_usuario', $id_usuario);
        $consulta->bindParam(':nombre', $nombre);
        $consulta->bindParam(':apellido', $apellido);
        $consulta->bindParam(':direccion', $direccion);
        $consulta->bindParam(':foto', $foto);
        $consulta->bindParam(':email', $email);
        $consulta->bindParam(':telefono', $telefono);
        $consulta->execute();
    }

    public function deleteUsuario($id_usuario)
    {
        $consulta = $this->conn->prepare("DELETE FROM usuario WHERE id_usuario = :id_usuario");
        $consulta->bindParam(':id_usuario', $id_usuario);
        $consulta->execute();
    }

    public function getUsuarioById($id_usuario)
    {
        $consulta = $this->conn->prepare("SELECT * FROM usuario WHERE id_usuario = :id_usuario");
        $consulta->bindParam(':id_usuario', $id_usuario);
        $consulta->execute();
        return $consulta->fetch(PDO::FETCH_ASSOC);
    }
}
?>
