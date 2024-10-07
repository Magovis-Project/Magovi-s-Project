<?php
require_once 'conexionModelo.php';

class UsuariosModel
{
    private $conn;

    public function __construct()
    {
        $this->conn = conexionModelo::getInstance()->getDatabaseInstance();
    }

    public function getUsuarios()
    {
        $consulta = $this->conn->prepare("SELECT * FROM Usuarios;");
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createUsuario($password, $direccion, $apellido, $nombre, $email, $telefono, $cedula, $foto)
    {
        $consulta = $this->conn->prepare("INSERT INTO Usuarios (Password, Direccion, Apellido, Nombre, Email, Telefono, Cedula, Foto) 
                                          VALUES (:password, :direccion, :apellido, :nombre, :email, :telefono, :cedula, :foto)");
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $consulta->bindParam(':password', $hashedPassword);
        $consulta->bindParam(':direccion', $direccion);
        $consulta->bindParam(':apellido', $apellido);
        $consulta->bindParam(':nombre', $nombre);
        $consulta->bindParam(':email', $email);
        $consulta->bindParam(':telefono', $telefono);
        $consulta->bindParam(':cedula', $cedula);
        $consulta->bindParam(':foto', $foto);
        $consulta->execute();
    }

    public function updateUsuario($id_usuario, $password, $direccion, $apellido, $nombre, $email, $telefono, $cedula, $foto)
    {
        $consulta = $this->conn->prepare("UPDATE Usuarios SET Password = :password, Direccion = :direccion, Apellido = :apellido, 
                                          Nombre = :nombre, Email = :email, Telefono = :telefono, Cedula = :cedula, Foto = :foto
                                          WHERE Id_Usuario = :id_usuario");
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $consulta->bindParam(':id_usuario', $id_usuario);
        $consulta->bindParam(':password', $hashedPassword);
        $consulta->bindParam(':direccion', $direccion);
        $consulta->bindParam(':apellido', $apellido);
        $consulta->bindParam(':nombre', $nombre);
        $consulta->bindParam(':email', $email);
        $consulta->bindParam(':telefono', $telefono);
        $consulta->bindParam(':cedula', $cedula);
        $consulta->bindParam(':foto', $foto);
        $consulta->execute();
    }

    public function deleteUsuario($id_usuario)
    {
        $consulta = $this->conn->prepare("DELETE FROM Usuarios WHERE Id_Usuario = :id_usuario");
        $consulta->bindParam(':id_usuario', $id_usuario);
        $consulta->execute();
    }

    public function getUsuarioById($id_usuario)
    {
        $consulta = $this->conn->prepare("SELECT * FROM Usuarios WHERE Id_Usuario = :id_usuario");
        $consulta->bindParam(':id_usuario', $id_usuario);
        $consulta->execute();
        return $consulta->fetch(PDO::FETCH_ASSOC);
    }
}
