<?php
class UsuarioController
{
    private $conn;

    public function __construct()
    {
        $this->conn = ConexionModel::getInstance()->getDatabaseInstance();
    }

    public function getUsuariosJSON()
    {
        try {
            $consulta = $this->conn->prepare("SELECT * FROM usuario;");
            $consulta->execute();
            $usuarios = $consulta->fetchAll(PDO::FETCH_ASSOC);

            // Devolver los datos como JSON
            header('Content-Type: application/json');
            echo json_encode($usuarios);
        } catch (PDOException $e) {
            $error = [
                'error' => true,
                'mensaje' => $e->getMessage()
            ];
            echo json_encode($error);
        }
    }
    public function createUsuario($nombre, $apellido, $direccion, $foto, $email, $password, $telefono)
{
    try {
        $consulta = $this->conn->prepare("INSERT INTO usuario (nombre, apellido, direccion, foto, email, password, telefono) 
                                          VALUES (:nombre, :apellido, :direccion, :foto, :email, :password, :telefono)");
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT); // Encriptar password
        $consulta->bindParam(':nombre', $nombre);
        $consulta->bindParam(':apellido', $apellido);
        $consulta->bindParam(':direccion', $direccion);
        $consulta->bindParam(':foto', $foto);
        $consulta->bindParam(':email', $email);
        $consulta->bindParam(':password', $hashedPassword); 
        $consulta->bindParam(':telefono', $telefono);
        $consulta->execute();
        echo json_encode(['success' => true, 'message' => 'Usuario creado exitosamente']);
    } catch (PDOException $e) {
        echo json_encode(['error' => true, 'message' => $e->getMessage()]);
    }
}

public function updateUsuario($id_usuario, $nombre, $apellido, $direccion, $foto, $email, $telefono)
{
    try {
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
        echo json_encode(['success' => true, 'message' => 'Usuario actualizado correctamente']);
    } catch (PDOException $e) {
        echo json_encode(['error' => true, 'message' => $e->getMessage()]);
    }
}

public function deleteUsuario($id_usuario)
{
    try {
        $consulta = $this->conn->prepare("DELETE FROM usuario WHERE id_usuario = :id_usuario");
        $consulta->bindParam(':id_usuario', $id_usuario);
        $consulta->execute();
        echo json_encode(['success' => true, 'message' => 'Usuario eliminado correctamente']);
    } catch (PDOException $e) {
        echo json_encode(['error' => true, 'message' => $e->getMessage()]);
    }
}

public function getUsuarioById($id_usuario)
{
    try {
        $consulta = $this->conn->prepare("SELECT * FROM usuario WHERE id_usuario = :id_usuario");
        $consulta->bindParam(':id_usuario', $id_usuario);
        $consulta->execute();
        $usuario = $consulta->fetch(PDO::FETCH_ASSOC);
        echo json_encode($usuario);
    } catch (PDOException $e) {
        echo json_encode(['error' => true, 'message' => $e->getMessage()]);
    }
}
}


// Verifica si se ha solicitado la acción
if (isset($_GET['action'])) {
    $controller = new UsuarioController();
    
    switch ($_GET['action']) {
        case 'createUsuario':
            $controller->createUsuario($_POST['nombre'], $_POST['apellido'], $_POST['direccion'], $_POST['foto'], $_POST['email'], $_POST['password'], $_POST['telefono']);
            break;
        case 'updateUsuario':
            $controller->updateUsuario($_POST['id_usuario'], $_POST['nombre'], $_POST['apellido'], $_POST['direccion'], $_POST['foto'], $_POST['email'], $_POST['telefono']);
            break;
        case 'deleteUsuario':
            $controller->deleteUsuario($_POST['id_usuario']);
            break;
        case 'getUsuarioById':
            $controller->getUsuarioById($_GET['id_usuario']);
            break;
        case 'getUsuariosJSON':
            $controller->getUsuariosJSON();
            break;
    }
}


