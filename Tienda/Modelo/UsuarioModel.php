<?php
require_once 'ConexionModel.php';

class UsuarioModel
{
    private $conn;

    public function __construct()
    {
        $this->conn = conexionModelo::getInstance()->getDatabaseInstance();
    }

    // Obtener todos los usuarios
    public function getUsuarios()
    {
        $prepare = $this->conn->prepare(
            "SELECT Id_Usuario, Direccion, Apellido, Nombre, Email, Telefono, Cedula, Fecha_Creacion, Actividad 
             FROM Usuarios"
        );
        $prepare->execute();
        return $prepare->fetchAll(PDO::FETCH_ASSOC);
    }

    // Crear un nuevo usuario
    public function createUsuario($password, $direccion, $apellido, $nombre, $email, $telefono, $cedula)
    {
        // Verificar unicidad de email y cédula
        if ($this->usuarioExiste($email, $cedula)) {
            throw new Exception("El correo electrónico o la cédula ya están registrados.");
        }

        $consulta = $this->conn->prepare(
            "INSERT INTO Usuarios (Password, Direccion, Apellido, Nombre, Email, Telefono, Cedula, Foto) 
             VALUES (:password, :direccion, :apellido, :nombre, :email, :telefono, :cedula, :foto)"
        );

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

    // Actualizar un usuario existente
    public function updateUsuario($id_usuario, $password, $direccion, $apellido, $nombre, $email, $telefono, $cedula, $foto, $actividad)
    {
        // Verificar unicidad de email y cédula
        if ($this->usuarioExiste($email, $cedula, $id_usuario)) {
            throw new Exception("El correo electrónico o la cédula ya están registrados.");
        }

        $sql = "UPDATE Usuarios SET 
                    Direccion = :direccion, 
                    Apellido = :apellido, 
                    Nombre = :nombre, 
                    Email = :email, 
                    Telefono = :telefono, 
                    Cedula = :cedula, 
                    Foto = :foto, 
                    Actividad = :actividad" .
                ($password ? ", Password = :password" : "") . 
                " WHERE Id_Usuario = :id_usuario";

        $consulta = $this->conn->prepare($sql);

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
        $consulta->bindParam(':actividad', $actividad);

        $consulta->execute();
    }

    // Eliminar un usuario
    public function deleteUsuario($id_usuario)
    {
        $consulta = $this->conn->prepare("DELETE FROM Usuarios WHERE Id_Usuario = :id_usuario");
        $consulta->bindParam(':id_usuario', $id_usuario);
        $consulta->execute();
    }

    // Obtener un usuario por ID
    public function getUsuarioById($id_usuario)
    {
        $consulta = $this->conn->prepare(
            "SELECT Id_Usuario, Direccion, Apellido, Nombre, Email, Telefono, Cedula, Fecha_Creacion, Foto, Actividad 
             FROM Usuarios WHERE Id_Usuario = :id_usuario"
        );
        $consulta->bindParam(':id_usuario', $id_usuario);
        $consulta->execute();
        return $consulta->fetch(PDO::FETCH_ASSOC);
    }

    // Verificar si un usuario ya existe por email o cédula
    private function usuarioExiste($email, $cedula, $id_usuario = null)
    {
        $sql = "SELECT COUNT(*) FROM Usuarios WHERE (Email = :email OR Cedula = :cedula)" .
               ($id_usuario ? " AND Id_Usuario != :id_usuario" : "");

        $consulta = $this->conn->prepare($sql);
        $consulta->bindParam(':email', $email);
        $consulta->bindParam(':cedula', $cedula);

        if ($id_usuario) {
            $consulta->bindParam(':id_usuario', $id_usuario);
        }

        $consulta->execute();
        return $consulta->fetchColumn() > 0;
    }

    // Verificar si el email y la contraseña coinciden con un usuario existente
    public function checkLogin($email, $password)
    {
        $consulta = $this->conn->prepare(
            "SELECT Id_Usuario, Direccion, Apellido, Nombre, Email, Telefono, Cedula, Fecha_Creacion, Actividad, Password 
             FROM Usuarios 
             WHERE Email = :email"
        );
        $consulta->bindParam(':email', $email);
        $consulta->execute();
        $result = $consulta->fetch(PDO::FETCH_ASSOC);
    
        if ($result && password_verify($password, $result['Password'])) {
            // Eliminar el campo Password del resultado antes de devolverlo
            unset($result['Password']);
            return $result;  // Retorna los datos del usuario autenticado
        }
    
        return false;  // Usuario no autenticado
    }
    


}
