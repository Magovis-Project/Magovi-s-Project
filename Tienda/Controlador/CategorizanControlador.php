<?php

header('Content-Type: application/json');
require_once '../Modelo/CategorizanModel.php';

class CategorizanControlador
{
    private $categorizanModel;

    public function __construct()
    {
        $this->categorizanModel = new CategorizanModel();
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
                    case 'add':
                        $this->addCategorizacion($input);
                        break;

                    case 'getCategoriasByArticulo':
                        if (isset($input['id_articulo'])) {
                            $this->getCategoriasByArticulo($input['id_articulo']);
                        } else {
                            echo json_encode(['error' => true, 'message' => 'ID de artículo no proporcionado.']);
                        }
                        break;

                    case 'getArticulosByCategoria':
                        if (isset($input['id_categoria'])) {
                            $this->getArticulosByCategoria($input['id_categoria']);
                        } else {
                            echo json_encode(['error' => true, 'message' => 'ID de categoría no proporcionado.']);
                        }
                        break;

                    case 'delete':
                        if (isset($input['id_articulo']) && isset($input['id_categoria'])) {
                            $this->deleteCategorizacion($input['id_articulo'], $input['id_categoria']);
                        } else {
                            echo json_encode(['error' => true, 'message' => 'ID de artículo o categoría no proporcionado.']);
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

    private function addCategorizacion($data)
    {
        try {
            $this->categorizanModel->addCategorizacion($data['id_articulo'], $data['id_categoria']);
            echo json_encode(['success' => true, 'message' => 'Categorización agregada exitosamente.']);
        } catch (PDOException $e) {
            echo json_encode(['error' => true, 'message' => $e->getMessage()]);
        }
    }

    private function getCategoriasByArticulo($id_articulo)
    {
        try {
            $categorias = $this->categorizanModel->getCategoriasByArticulo($id_articulo);
            echo json_encode($categorias);
        } catch (PDOException $e) {
            echo json_encode(['error' => true, 'message' => $e->getMessage()]);
        }
    }

    public function getArticulosByCategoria($nombre_categoria)
{
    try {
        $articulos = $this->categorizanModel->getArticulosByCategoria($nombre_categoria);
        echo json_encode($articulos);
    } catch (PDOException $e) {
        echo json_encode(['error' => true, 'message' => $e->getMessage()]);
    }
}


    private function deleteCategorizacion($id_articulo, $id_categoria)
    {
        try {
            $this->categorizanModel->deleteCategorizacion($id_articulo, $id_categoria);
            echo json_encode(['success' => true, 'message' => 'Categorización eliminada exitosamente.']);
        } catch (PDOException $e) {
            echo json_encode(['error' => true, 'message' => $e->getMessage()]);
        }
    }
}

$controlador = new CategorizanControlador();
$controlador->processRequest();
?>
