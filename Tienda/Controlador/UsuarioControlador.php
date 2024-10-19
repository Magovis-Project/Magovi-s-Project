<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');

if (file_exists("../Modelo/UsuarioModel.php")) {
    require_once("../Modelo/UsuarioModel.php");
} else {
    echo json_encode(['error' => true, 'message' => 'Modelo no encontrado.']);
    exit;
}

class UsuariosControlador
{
    private $usuarioModel;

    public function __construct()
    {
        $this->usuarioModel = new UsuarioModel();
    }

    public function processRequest()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Leer el cuerpo de la solicitud JSON
            $input = json_decode(file_get_contents('php://input'), true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                echo json_encode(['error' => true, 'message' => 'Error en la decodificación JSON: ' . json_last_error_msg()]);
                return;
            }

            if (isset($input['action'])) {
                switch ($input['action']) {
                    case 'create':
                        $this->createUsuario(
                            $input['password'],
                            $input['direccion'],
                            $input['apellido'],
                            $input['nombre'],
                            $input['email'],
                            $input['telefono'],
                            $input['cedula'],
                            $input['foto']
                        );
                        break;

                    case 'update':
                        $this->updateUsuario(
                            $input['id_usuario'],
                            $input['password'],
                            $input['direccion'],
                            $input['apellido'],
                            $input['nombre'],
                            $input['email'],
                            $input['telefono'],
                            $input['cedula'],
                            $input['foto']
                        );
                        break;

                    case 'delete':
                        $this->deleteUsuario($input['id_usuario']);
                        break;

                    case 'get':
                        $this->getUsuariosJSON(); // Si quieres obtener todos los usuarios
                        break;

                    case 'getById':
                        if (isset($input['id_usuario'])) {
                            $this->getUsuarioById($input['id_usuario']);
                        } else {
                            echo json_encode(['error' => true, 'message' => 'ID de usuario no especificado.']);
                        }
                        break;

                    default:
                        echo json_encode(['error' => true, 'message' => 'Acción no válida.']);
                        break;
                }
            } else {
                echo json_encode(['error' => true, 'message' => 'Acción no especificada.']);
            }
        } else {
            echo json_encode(['error' => true, 'message' => 'Método no permitido.']);
        }
    }

    public function getUsuariosJSON()
{
    try {
        $usuarios = $this->usuarioModel->getUsuarios();
        header('Content-Type: application/json');
        echo json_encode($usuarios);
    } catch (PDOException $e) {
        // Imprimir detalles del error
        echo json_encode(['error' => true, 'mensaje' => $e->getMessage()]);
        error_log($e->getMessage()); // Registra el error en el log de PHP
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
            $this->usuarioModel->createUsuario($password, $direccion, $apellido, $nombre, $email, $telefono, $cedula, $foto);
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
            $this->usuarioModel->updateUsuario($id_usuario, $password, $direccion, $apellido, $nombre, $email, $telefono, $cedula, $foto);
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

$controlador = new UsuariosControlador(); 
$controlador->processRequest();
