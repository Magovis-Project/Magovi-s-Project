<?php
require_once 'ConexionModel.php';


class UsuarioModel
{
    private $conn;

    public function __construct()
    {
        $this->conn = conexionModelo::getInstance()->getDatabaseInstance();
    }

    public function getUsuarios()
{
    $prepare = $this->conn->prepare("SELECT Id_Usuario, Direccion, Apellido, Nombre, Email, Telefono, Cedula, Fecha_Creacion FROM Usuarios");
    $prepare->execute();
    return $prepare->fetchAll(PDO::FETCH_ASSOC);
}


    public function createUsuario($password, $direccion, $apellido, $nombre, $email, $telefono, $cedula, $foto)
    {
        // Verificar unicidad de email y cedula
        if ($this->usuarioExiste($email, $cedula)) {
            throw new Exception("El correo electrónico o la cédula ya están registrados.");
        }

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
        // Verificar unicidad de email y cedula
        if ($this->usuarioExiste($email, $cedula, $id_usuario)) {
            throw new Exception("El correo electrónico o la cédula ya están registrados.");
        }

        $consulta = $this->conn->prepare("UPDATE Usuarios SET 
                                          Direccion = :direccion, 
                                          Apellido = :apellido, 
                                          Nombre = :nombre, 
                                          Email = :email, 
                                          Telefono = :telefono, 
                                          Cedula = :cedula, 
                                          Foto = :foto" .
                                          ($password ? ", Password = :password" : "") . 
                                          " WHERE Id_Usuario = :id_usuario");

        // Solo hashear la contraseña si se proporciona
        if ($password) {
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $consulta->bindParam(':password', $hashedPassword);
        }
        
        $consulta->bindParam(':id_usuario', $id_usuario);
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

    private function usuarioExiste($email, $cedula, $id_usuario = null)
    {
        $consulta = $this->conn->prepare("SELECT COUNT(*) FROM Usuarios WHERE (Email = :email OR Cedula = :cedula)" . 
                                           ($id_usuario ? " AND Id_Usuario != :id_usuario" : ""));
        $consulta->bindParam(':email', $email);
        $consulta->bindParam(':cedula', $cedula);
        if ($id_usuario) {
            $consulta->bindParam(':id_usuario', $id_usuario);
        }
        $consulta->execute();
        return $consulta->fetchColumn() > 0;
    }
}
