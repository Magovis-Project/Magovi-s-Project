<?php

header('Content-Type: application/json');
require_once '../Modelo/CategoriaModel.php';

class CategoriaControlador
{
    private $categoriasModel;

    public function __construct()
    {
        $this->categoriasModel = new CategoriaModel();
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
                        $this->createCategoria($input);
                        break;

                    case 'getAll':
                        $this->getAllCategorias();
                        break;

                    case 'getById':
                        if (isset($input['id_categoria'])) {
                            $this->getCategoriaById($input['id_categoria']);
                        } else {
                            echo json_encode(['error' => true, 'message' => 'ID de categoría no proporcionado.']);
                        }
                        break;

                    case 'update':
                        if (isset($input['id_categoria'])) {
                            $this->updateCategoria($input);
                        } else {
                            echo json_encode(['error' => true, 'message' => 'ID de categoría no proporcionado.']);
                        }
                        break;

                    case 'delete':
                        if (isset($input['id_categoria'])) {
                            $this->deleteCategoria($input['id_categoria']);
                        } else {
                            echo json_encode(['error' => true, 'message' => 'ID de categoría no proporcionado.']);
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

    public function createCategoria($data)
    {
        try {
            $this->categoriasModel->createCategoria($data['nombre']);
            echo json_encode(['success' => true, 'message' => 'Categoría creada exitosamente.']);
        } catch (PDOException $e) {
            echo json_encode(['error' => true, 'message' => $e->getMessage()]);
        }
    }

    public function getAllCategorias()
    {
        try {
            $categorias = $this->categoriasModel->getAllCategorias();
            echo json_encode($categorias);
        } catch (PDOException $e) {
            echo json_encode(['error' => true, 'message' => $e->getMessage()]);
        }
    }

    public function getCategoriaById($id_categoria)
    {
        try {
            $categoria = $this->categoriasModel->getCategoriaById($id_categoria);
            echo json_encode($categoria);
        } catch (PDOException $e) {
            echo json_encode(['error' => true, 'message' => $e->getMessage()]);
        }
    }

    public function updateCategoria($data)
    {
        try {
            $this->categoriasModel->updateCategoria($data['id_categoria'], $data['nombre']);
            echo json_encode(['success' => true, 'message' => 'Categoría actualizada exitosamente.']);
        } catch (PDOException $e) {
            echo json_encode(['error' => true, 'message' => $e->getMessage()]);
        }
    }

    public function deleteCategoria($id_categoria)
    {
        try {
            $this->categoriasModel->deleteCategoria($id_categoria);
            echo json_encode(['success' => true, 'message' => 'Categoría eliminada exitosamente.']);
        } catch (PDOException $e) {
            echo json_encode(['error' => true, 'message' => $e->getMessage()]);
        }
    }
}

$controlador = new CategoriaControlador();
$controlador->processRequest();
