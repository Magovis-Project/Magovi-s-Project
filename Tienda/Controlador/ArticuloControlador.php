<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');
require_once '../Modelo/ArticulosModel.php';

class ArticuloControlador
{
    private $articulosModel;

    public function __construct()
    {
        $this->articulosModel = new ArticulosModel();
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
                        $this->createArticulo(
                            $input['id_empresa'],
                            $input['nombre'],
                            $input['precio'],
                            $input['cantidad'],
                            $input['tipo'],
                            $input['valoracion'],
                            $input['actividad']
                        );
                        break;

                    case 'getAll':
                        $this->getAllArticulos();
                        break;

                    case 'getById':
                        if (isset($input['id_articulo'])) {
                            $this->getArticuloById($input['id_articulo']); 
                        } else {
                            echo json_encode(['error' => true, 'message' => 'ID de artículo no proporcionado.']);
                        }
                        break;

                    case 'update':
                        if (isset($input['id_articulo'])) {
                            $this->updateArticulo(
                                $input['id_articulo'],
                                $input['id_empresa'],
                                $input['nombre'],
                                $input['precio'],
                                $input['cantidad'],
                                $input['tipo'],
                                $input['valoracion'],
                                $input['actividad']
                            );
                        } else {
                            echo json_encode(['error' => true, 'message' => 'ID de artículo no proporcionado.']);
                        }
                        break;

                    case 'delete':
                        if (isset($input['id_articulo'])) {
                            $this->deleteArticulo($input['id_articulo']);
                        } else {
                            echo json_encode(['error' => true, 'message' => 'ID de artículo no proporcionado.']);
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

    public function createArticulo($id_empresa, $nombre, $precio, $cantidad, $tipo, $valoracion, $actividad)
    {
        try {
            $this->articulosModel->createArticulo($id_empresa, $nombre, $precio, $cantidad, $tipo, $valoracion, $actividad);
            echo json_encode(['success' => true, 'message' => 'Artículo creado exitosamente.']);
        } catch (PDOException $e) {
            echo json_encode(['error' => true, 'message' => $e->getMessage()]);
        }
    }

    public function getAllArticulos()
    {
        try {
            $articulos = $this->articulosModel->getAllArticulos();
            echo json_encode($articulos);
        } catch (PDOException $e) {
            echo json_encode(['error' => true, 'message' => $e->getMessage()]);
        }
    }

    public function getArticuloById($id_articulo)
    {
        try {
            $articulo = $this->articulosModel->getArticuloById($id_articulo);
            echo json_encode($articulo);
        } catch (PDOException $e) {
            echo json_encode(['error' => true, 'message' => $e->getMessage()]);
        }
    }

    public function updateArticulo($id_articulo, $id_empresa, $nombre, $precio, $cantidad, $tipo, $valoracion, $actividad)
    {
        try {
            $this->articulosModel->updateArticulo($id_articulo, $id_empresa, $nombre, $precio, $cantidad, $tipo, $valoracion, $actividad);
            echo json_encode(['success' => true, 'message' => 'Artículo actualizado exitosamente.']);
        } catch (PDOException $e) {
            echo json_encode(['error' => true, 'message' => $e->getMessage()]);
        }
    }

    public function deleteArticulo($id_articulo)
    {
        try {
            $this->articulosModel->deleteArticulo($id_articulo);
            echo json_encode(['success' => true, 'message' => 'Artículo eliminado exitosamente.']);
        } catch (PDOException $e) {
            echo json_encode(['error' => true, 'message' => $e->getMessage()]);
        }
    }
}

$controlador = new ArticuloControlador();
$controlador->processRequest();
