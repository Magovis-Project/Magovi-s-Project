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
            $input = json_decode(file_get_contents('php://input'), true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                echo json_encode(['error' => true, 'message' => 'Error en la decodificación JSON: ' . json_last_error_msg()]);
                return;
            }

            if (isset($input['action'])) {
                switch ($input['action']) {
                    case 'create':
                        $this->createUsuario(
                            $input['password'], $input['direccion'], $input['apellido'], 
                            $input['nombre'], $input['email'], $input['telefono'], 
                            $input['cedula']
                        );
                        break;

                    case 'update':
                        $this->updateUsuario(
                            $input['id_usuario'], $input['password'], $input['direccion'], 
                            $input['apellido'], $input['nombre'], $input['email'], 
                            $input['telefono'], $input['cedula'], $input['foto'], 
                            $input['actividad']
                        );
                        break;
                    
                    case 'login':
                        $this->checkLogin($input['email'], $input['password']);
                        break;

                    case 'delete':
                        $this->deleteUsuario($input['id_usuario']);
                        break;

                    case 'get':
                        $this->getUsuariosJSON();
                        break;

                    case 'getById':
                        if (isset($input['id_usuario'])) {
                            $this->getUsuarioById($input['id_usuario']);
                        } else {
                            echo json_encode(['error' => true, 'message' => 'ID de usuario no encontrado.']);
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
            $usuarios = $this->usuarioModel->getUsuarios();
            echo json_encode($usuarios);
        
    }

    public function createUsuario($password, $direccion, $apellido, $nombre, $email, $telefono, $cedula)
    {
        $validacion = $this->validarDatos($password, $direccion, $apellido, $nombre, $email, $telefono, $cedula);
        if ($validacion !== true) {
            echo json_encode(['error' => true, 'message' => $validacion]);
            return;
        }
            $this->usuarioModel->createUsuario($password, $direccion, $apellido, $nombre, $email, $telefono, $cedula);
            echo json_encode(['success' => true, 'message' => 'Usuario creado exitosamente']);
       
    }

    public function updateUsuario($id_usuario, $password = null, $direccion = null, $apellido = null, $nombre = null, $email = null, $telefono = null, $cedula = null, $foto = null, $actividad = null)
{
    // Filtra los valores que no están vacíos para pasar solo los que se desean actualizar
    $fieldsToUpdate = array_filter([
        'password' => $password,
        'direccion' => $direccion,
        'apellido' => $apellido,
        'nombre' => $nombre,
        'email' => $email,
        'telefono' => $telefono,
        'cedula' => $cedula,
        'foto' => $foto,
        'actividad' => $actividad,
    ], function ($value) {
        return !is_null($value);
    });

    // Si no hay campos para actualizar, retorna un mensaje
    if (empty($fieldsToUpdate)) {
        echo json_encode(['error' => true, 'message' => 'No hay campos para actualizar']);
        return;
    }

    try {
        // Llama al modelo con los campos específicos a actualizar
        $this->usuarioModel->updateUsuario($id_usuario, $fieldsToUpdate);
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

            $usuario = $this->usuarioModel->getUsuarioById($id_usuario);
            echo json_encode($usuario);
       
    }

    public function checkLogin($email, $password)
    {
        try {
            $usuario = $this->usuarioModel->checkLogin($email, $password);
            if ($usuario) {
                echo json_encode(['success' => true, 'message' => 'Login exitoso', 'usuario' => $usuario]);
            } else {
                echo json_encode(['error' => true, 'message' => 'Credenciales inválidas']);
            }
        } catch (PDOException $e) {
            echo json_encode(['error' => true, 'message' => $e->getMessage()]);
        }
    }
    private function validarDatos($password, $direccion, $apellido, $nombre, $email, $telefono, $cedula)
{

    $mensaje = "";

    if (empty($nombre) || empty($apellido) || empty($direccion) || empty($email) || empty($telefono) || empty($cedula)) {
        $mensaje .= "Todos los campos son obligatorios.<br>";
    }

    if ($email && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $mensaje .= "El correo electrónico no es válido.<br>";
    }

    if ($telefono && !preg_match('/^\d{9}$/', $telefono)) {
        $mensaje .= "El número de teléfono debe tener exactamente 9 dígitos.<br>";
    }

    if ($password && (strlen($password) < 8 || !preg_match('/[A-Z]/', $password) || !preg_match('/[a-z]/', $password) || !preg_match('/\d/', $password))) {
        $mensaje .= "La contraseña debe tener al menos 8 caracteres, incluyendo una mayúscula, una minúscula y un número.<br>";
    }

    if ($cedula && (!preg_match('/^\d+$/', $cedula) || strlen($cedula) < 7)) {
        $mensaje .= "La cédula debe tener al menos 7 dígitos y solo contener números.<br>";
    }

    return empty($mensaje) ? true : $mensaje;
}
}




$controlador = new UsuariosControlador();
$controlador->processRequest();
