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
        $validacion = $this->validarDatos($password, $direccion, $apellido, $nombre, $email, $telefono, $cedula);
        if ($validacion !== true) {
            echo json_encode(['error' => true, 'message' => $validacion]);
            return;
        }

        try {
            $this->usuariosModel->createUsuario($password, $direccion, $apellido, $nombre, $email, $telefono, $cedula, $foto);
            echo json_encode(['success' => true, 'message' => 'Usuario creado exitosamente']);
        } catch (PDOException $e) {
            echo json_encode(['error' => true, 'message' => $e->getMessage()]);
        }
    }

    public function updateUsuario($id_usuario, $password, $direccion, $apellido, $nombre, $email, $telefono, $cedula, $foto)
    {
        $validacion = $this->validarDatos($password, $direccion, $apellido, $nombre, $email, $telefono, $cedula);
        if ($validacion !== true) {
            echo json_encode(['error' => true, 'message' => $validacion]);
            return;
        }

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

    // Método para validar los datos del usuario
    private function validarDatos($password, $direccion, $apellido, $nombre, $email, $telefono, $cedula)
    {
        $mensaje = "";

        // Validaciones de campos vacíos
        if (empty($nombre) || empty($apellido) || empty($direccion) || empty($email) || empty($telefono) || empty($cedula)) {
            return "Todos los campos son obligatorios.";
        }

        // Validación de correo electrónico
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $mensaje .= "El correo electrónico no es válido.<br>";
        }

        // Validación de número de teléfono
        if (!preg_match('/^\d{9}$/', $telefono)) {
            $mensaje .= "El número de teléfono debe tener exactamente 9 dígitos.<br>";
        }

        // Validación de contraseña
        if (strlen($password) < 8 || !preg_match('/[A-Z]/', $password) || !preg_match('/[a-z]/', $password) || !preg_match('/\d/', $password)) {
            $mensaje .= "La contraseña debe tener al menos 8 caracteres, incluyendo al menos una mayúscula, una minúscula y un número.<br>";
        }

        // Validación de cédula
        if (empty($cedula) || !preg_match('/^\d+$/', $cedula) || strlen($cedula) < 7) {
            $mensaje .= "La cédula debe tener al menos 7 dígitos y solo puede contener números.<br>";
        }

        // Si hay mensajes de error, los retornamos
        return empty($mensaje) ? true : $mensaje;
    }
}
 