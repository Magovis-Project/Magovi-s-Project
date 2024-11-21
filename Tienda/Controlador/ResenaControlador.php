<?php
header('Content-Type: application/json');
require_once '../Modelo/ResenaModel.php';

class ReseñaControlador
{
    private $reseñaModel;

    public function __construct()
    {
        $this->reseñaModel = new ReseñaModel();
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
                    case 'getReseñas':
                        $this->getReseñasJSON();
                        break;

                    case 'getReseñasByArticulo':
                        if (isset($input['id_articulo'])) {
                            $this->getReseñasByArticulo($input['id_articulo']);
                        } else {
                            echo json_encode(['error' => true, 'message' => 'ID de artículo no proporcionado.']);
                        }
                        break;

                    case 'createReseña':
                        if (isset($input['id_usuario'], $input['id_articulo'], $input['comentario'], $input['calificacion'])) {
                            $this->createReseña($input);
                        } else {
                            echo json_encode(['error' => true, 'message' => 'Faltan datos para crear la reseña']);
                        }
                        break;

                    case 'updateReseña':
                        if (isset($input['id_usuario'], $input['id_articulo'], $input['comentario'], $input['calificacion'])) {
                            $this->updateReseña($input);
                        } else {
                            echo json_encode(['error' => true, 'message' => 'Faltan datos para actualizar la reseña']);
                        }
                        break;

                    case 'deleteReseña':
                        if (isset($input['id_usuario'], $input['id_articulo'])) {
                            $this->deleteReseña($input);
                        } else {
                            echo json_encode(['error' => true, 'message' => 'Faltan datos para eliminar la reseña']);
                        }
                        break;

                    case 'getReseñaByIds':
                        if (isset($input['id_usuario'], $input['id_articulo'])) {
                            $this->getReseñaByIds($input['id_usuario'], $input['id_articulo']);
                        } else {
                            echo json_encode(['error' => true, 'message' => 'Faltan datos para obtener la reseña']);
                        }
                        break;

                    default:
                        echo json_encode(['error' => true, 'message' => 'Acción no válida']);
                        break;
                }
            } else {
                echo json_encode(['error' => true, 'message' => 'Acción no especificada']);
            }
        } else {
            echo json_encode(['error' => true, 'message' => 'Método no permitido']);
        }
    }

    public function getReseñasJSON()
    {
        try {
            $reseñas = $this->reseñaModel->getReseñas();
            echo json_encode($reseñas);
        } catch (PDOException $e) {
            echo json_encode(['error' => true, 'message' => $e->getMessage()]);
        }
    }

    public function createReseña($data)
    {
        try {
            $this->reseñaModel->createReseña($data['id_usuario'], $data['id_articulo'], $data['comentario'], $data['calificacion']);
            echo json_encode(['success' => true, 'message' => 'Reseña creada exitosamente']);
        } catch (PDOException $e) {
            echo json_encode(['error' => true, 'message' => $e->getMessage()]);
        }
    }

    public function updateReseña($data)
    {
        try {
            $this->reseñaModel->updateReseña($data['id_usuario'], $data['id_articulo'], $data['comentario'], $data['calificacion']);
            echo json_encode(['success' => true, 'message' => 'Reseña actualizada correctamente']);
        } catch (PDOException $e) {
            echo json_encode(['error' => true, 'message' => $e->getMessage()]);
        }
    }

    public function deleteReseña($data)
    {
        try {
            $this->reseñaModel->deleteReseña($data['id_usuario'], $data['id_articulo']);
            echo json_encode(['success' => true, 'message' => 'Reseña eliminada correctamente']);
        } catch (PDOException $e) {
            echo json_encode(['error' => true, 'message' => $e->getMessage()]);
        }
    }

    public function getReseñaByIds($id_usuario, $id_articulo)
    {
        try {
            $reseña = $this->reseñaModel->getReseñaByIds($id_usuario, $id_articulo);
            echo json_encode($reseña);
        } catch (PDOException $e) {
            echo json_encode(['error' => true, 'message' => $e->getMessage()]);
        }
    }

    public function getReseñasByArticulo($id_articulo)
    {
        try {
            $reseñas = $this->reseñaModel->getReseñasByArticulo($id_articulo);
            echo json_encode($reseñas);
        } catch (PDOException $e) {
            echo json_encode(['error' => true, 'message' => $e->getMessage()]);
        }
    }
}

$controlador = new ReseñaControlador();
$controlador->processRequest();
