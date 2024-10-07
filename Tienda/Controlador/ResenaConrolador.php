<?php
require_once 'ResenaModel.php';

class ReseñaControlador
{
    private $reseñaModel;

    public function __construct()
    {
        $this->reseñaModel = new ReseñaModel();
    }

    public function getReseñasJSON()
    {
        try {
            $reseñas = $this->reseñaModel->getReseñas();
            header('Content-Type: application/json');
            echo json_encode($reseñas);
        } catch (PDOException $e) {
            echo json_encode(['error' => true, 'mensaje' => $e->getMessage()]);
        }
    }

    public function createReseña($id_usuario, $id_articulo, $comentario, $calificacion)
    {
        try {
            $this->reseñaModel->createReseña($id_usuario, $id_articulo, $comentario, $calificacion);
            echo json_encode(['success' => true, 'message' => 'Reseña creada exitosamente']);
        } catch (PDOException $e) {
            echo json_encode(['error' => true, 'message' => $e->getMessage()]);
        }
    }

    public function updateReseña($id_usuario, $id_articulo, $comentario, $calificacion)
    {
        try {
            $this->reseñaModel->updateReseña($id_usuario, $id_articulo, $comentario, $calificacion);
            echo json_encode(['success' => true, 'message' => 'Reseña actualizada correctamente']);
        } catch (PDOException $e) {
            echo json_encode(['error' => true, 'message' => $e->getMessage()]);
        }
    }

    public function deleteReseña($id_usuario, $id_articulo)
    {
        try {
            $this->reseñaModel->deleteReseña($id_usuario, $id_articulo);
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
}
