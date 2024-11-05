<?php
header('Content-Type: application/json');
require_once '../Modelo/VioModel.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class VioControlador
{
    private $vioModel;

    public function __construct()
    {
        $this->vioModel = new VioModel();
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
                case 'getAllByUsuario':
                    if (isset($input['id_usuario'])) {
                        $this->getViosByUsuario($input['id_usuario']);
                    } else {
                        echo json_encode(['error' => true, 'message' => 'ID de usuario no proporcionado.']);
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


    public function getViosByUsuario($id_usuario)
    {
        try {
            $articulos = $this->vioModel->getArticulosVistosByUsuario($id_usuario);
            echo json_encode($articulos);
        } catch (PDOException $e) {
            echo json_encode(['error' => true, 'message' => $e->getMessage()]);
        }
    }

    public function getViosJSON()
    {
        try {
            $vios = $this->vioModel->getVios();
            echo json_encode($vios);
        } catch (PDOException $e) {
            echo json_encode(['error' => true, 'mensaje' => $e->getMessage()]);
        }
    }

    public function createVio($id_usuario, $id_articulo)
    {
        try {
            $this->vioModel->createVio($id_usuario, $id_articulo);
            echo json_encode(['success' => true, 'message' => 'Registro de vista creado exitosamente']);
        } catch (PDOException $e) {
            echo json_encode(['error' => true, 'message' => $e->getMessage()]);
        }
    }

    public function deleteVio($id_usuario, $id_articulo)
    {
        try {
            $this->vioModel->deleteVio($id_usuario, $id_articulo);
            echo json_encode(['success' => true, 'message' => 'Registro de vista eliminado correctamente']);
        } catch (PDOException $e) {
            echo json_encode(['error' => true, 'message' => $e->getMessage()]);
        }
    }

    public function getVioByIds($id_usuario, $id_articulo)
    {
        try {
            $vio = $this->vioModel->getVioByIds($id_usuario, $id_articulo);
            echo json_encode($vio);
        } catch (PDOException $e) {
            echo json_encode(['error' => true, 'message' => $e->getMessage()]);
        }
    }
}

