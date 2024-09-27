<?php
class UsuarioControlador
{
    private $usuarioModel;

    public function __construct()
    {
        $this->usuarioModel = new UsuarioModel();
    }

    public function getUsuariosJSON()
    {
        try {
            $usuarios = $this->usuarioModel->getUsuarios();
            header('Content-Type: application/json');
            echo json_encode($usuarios);
        } catch (PDOException $e) {
            echo json_encode(['error' => true, 'mensaje' => $e->getMessage()]);
        }
    }

    public function createUsuario($nombre, $apellido, $direccion, $foto, $email, $password, $telefono)
    {
        try {
            $this->usuarioModel->createUsuario($nombre, $apellido, $direccion, $foto, $email, $password, $telefono);
            echo json_encode(['success' => true, 'message' => 'Usuario creado exitosamente']);
        } catch (PDOException $e) {
            echo json_encode(['error' => true, 'message' => $e->getMessage()]);
        }
    }

    public function updateUsuario($id_usuario, $nombre, $apellido, $direccion, $foto, $email, $telefono)
    {
        try {
            $this->usuarioModel->updateUsuario($id_usuario, $nombre, $apellido, $direccion, $foto, $email, $telefono);
            echo json_encode(['success' => true, 'message' => 'Usuario actualizado correctamente']);
        } catch (PDOException $e) {
            echo json_encode(['error' => true, 'message' => $e->getMessage()]);
        }
    }

    public function deleteUsuario($id_usuario)
    {
        try {
            $this->usuarioModel->deleteUsuario($id_usuario);
            echo json_encode(['success' => true, 'message' => 'Usuario eliminado correctamente']);
        } catch (PDOException $e) {
            echo json_encode(['error' => true, 'message' => $e->getMessage()]);
        }
    }

    public function getUsuarioById($id_usuario)
    {
        try {
            $usuario = $this->usuarioModel->getUsuarioById($id_usuario);
            echo json_encode($usuario);
        } catch (PDOException $e) {
            echo json_encode(['error' => true, 'message' => $e->getMessage()]);
        }
    }
}
?>
