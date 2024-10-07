<?php
require_once 'UsuariosModel.php';

class UsuariosControlador
{
    private $usuariosModel;

    public function __construct()
    {
        $this->usuariosModel = new UsuariosModel();
    }

    public function getUsuariosJSON()
    {
        try {
            $usuarios = $this->usuariosModel->getUsuarios();
            header('Content-Type: application/json');
            echo json_encode($usuarios);
        } catch (PDOException $e) {
            echo json_encode(['error' => true, 'mensaje' => $e->getMessage()]);
        }
    }

    public function createUsuario($password, $direccion, $apellido, $nombre, $email, $telefono, $cedula, $foto)
    {
        try {
            $this->usuariosModel->createUsuario($password, $direccion, $apellido, $nombre, $email, $telefono, $cedula, $foto);
            echo json_encode(['success' => true, 'message' => 'Usuario creado exitosamente']);
        } catch (PDOException $e) {
            echo json_encode(['error' => true, 'message' => $e->getMessage()]);
        }
    }

    public function updateUsuario($id_usuario, $password, $direccion, $apellido, $nombre, $email, $telefono, $cedula, $foto)
    {
        try {
            $this->usuariosModel->updateUsuario($id_usuario, $password, $direccion, $apellido, $nombre, $email, $telefono, $cedula, $foto);
            echo json_encode(['success' => true, 'message' => 'Usuario actualizado correctamente']);
        } catch (PDOException $e) {
            echo json_encode(['error' => true, 'message' => $e->getMessage()]);
        }
    }

    public function deleteUsuario($id_usuario)
    {
        try {
            $this->usuariosModel->deleteUsuario($id_usuario);
            echo json_encode(['success' => true, 'message' => 'Usuario eliminado correctamente']);
        } catch (PDOException $e) {
            echo json_encode(['error' => true, 'message' => $e->getMessage()]);
        }
    }

    public function getUsuarioById($id_usuario)
    {
        try {
            $usuario = $this->usuariosModel->getUsuarioById($id_usuario);
            echo json_encode($usuario);
        } catch (PDOException $e) {
            echo json_encode(['error' => true, 'message' => $e->getMessage()]);
        }
    }
}
