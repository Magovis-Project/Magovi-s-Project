<?php
require_once '../Modelo/EmpresaModel.php';

class EmpresaControlador
{
    private $empresaModel;

    public function __construct()
    {
        $this->empresaModel = new EmpresaModel();
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
                        $this->createEmpresa(
                            $input['nombre'],
                            $input['direccion'],
                            $input['telefono'],
                            $input['email'],
                            $input['RUT'],
                            $input['password']
                        );
                        break;

                    case 'login':
                        $this->iniciarSesion($input['email'], $input['password']);
                        break;

                        case 'getAllEmpresas':
                            $this->getAllEmpresas();
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

    public function iniciarSesion($email, $password)
    {
        try {
            $empresa = $this->empresaModel->getEmpresaByEmail($email);

            if ($empresa && password_verify($password, $empresa['password'])) {
                echo json_encode(['success' => true, 'message' => 'Inicio de sesión exitoso.', 'empresa' => $empresa]);
            } else {
                echo json_encode(['error' => true, 'message' => 'Email o contraseña incorrectos.']);
            }
        } catch (PDOException $e) {
            echo json_encode(['error' => true, 'message' => $e->getMessage()]);
        }
    }

    public function getAllEmpresas()
    {
        try {
            $empresas = $this->empresaModel->getAllEmpresas();  // Llama al modelo para obtener los datos
            header('Content-Type: application/json');
            echo json_encode($empresas);
        } catch (PDOException $e) {
            echo json_encode(['error' => true, 'message' => $e->getMessage()]);
        }
    }

    public function createEmpresa($nombre, $direccion, $telefono, $email, $RUT, $password)
    {
        $validacion = $this->validarDatos($nombre, $direccion, $telefono, $email, $RUT, $password);
        if ($validacion !== true) {
            echo json_encode(['error' => true, 'message' => $validacion]);
            return;
        }

        try {
            $this->empresaModel->createEmpresa($nombre, $direccion, $telefono, $email, foto_url: null, rut: $RUT, password: $password);
            echo json_encode(['success' => true, 'message' => 'Empresa creada exitosamente']);
        } catch (PDOException $e) {
            echo json_encode(['error' => true, 'message' => $e->getMessage()]);
        }
    }

    private function validarDatos($nombre, $direccion, $telefono, $email, $RUT, $password)
    {
        $mensaje = "";

        if (empty($nombre) || empty($direccion) || empty($telefono) || empty($email) || empty($RUT) || empty($password)) {
            return "Todos los campos son obligatorios.";
        }

        if (strlen($telefono) !== 9) {
            $mensaje .= "El teléfono debe tener exactamente 9 dígitos.<br>";
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $mensaje .= "El correo electrónico no es válido.<br>";
        }

        if (!$this->empresaModel->validarRUT($RUT)) {
            $mensaje .= "El RUT no es válido.<br>";
        }

        return empty($mensaje) ? true : $mensaje;
    }
}

$controlador = new EmpresaControlador();
$controlador->processRequest();
