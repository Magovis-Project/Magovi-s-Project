<?php
require_once 'ResenaModel.php';

class ResenaControlador
{
    private $resenaModel;

    public function __construct()
    {
        $this->resenaModel = new ResenaModel();
    }

    // Obtener todas las reseñas
    public function getResenasJSON()
    {
        try {
            $resenas = $this->resenaModel->obtenerResenas();
            header('Content-Type: application/json');
            echo json_encode($resenas);
        } catch (PDOException $e) {
            $error = ['error' => true, 'mensaje' => $e->getMessage()];
            echo json_encode($error);
        }
    }

    // Crear una nueva reseña
    public function createResena($id_usuario, $id_articulo, $calificacion, $comentario)
    {
        try {
            $this->resenaModel->crearResena($id_usuario, $id_articulo, $calificacion, $comentario);
            echo json_encode(['mensaje' => 'Reseña creada exitosamente.']);
        } catch (PDOException $e) {
            $error = ['error' => true, 'mensaje' => $e->getMessage()];
            echo json_encode($error);
        }
    }

    // Buscar una reseña por ID de usuario y ID de artículo
    public function buscarResena($id_usuario, $id_articulo)
    {
        try {
            $resena = $this->resenaModel->buscarResena($id_usuario, $id_articulo);
            echo json_encode($resena ?: ['mensaje' => 'Reseña no encontrada.']);
        } catch (PDOException $e) {
            $error = ['error' => true, 'mensaje' => $e->getMessage()];
            echo json_encode($error);
        }
    }

    // Actualizar una reseña
    public function updateResena($id_usuario, $id_articulo, $calificacion, $comentario)
    {
        try {
            $this->resenaModel->actualizarResena($id_usuario, $id_articulo, $calificacion, $comentario);
            echo json_encode(['mensaje' => 'Reseña actualizada exitosamente.']);
        } catch (PDOException $e) {
            $error = ['error' => true, 'mensaje' => $e->getMessage()];
            echo json_encode($error);
        }
    }

    // Eliminar una reseña
    public function deleteResena($id_usuario, $id_articulo)
    {
        try {
            $this->resenaModel->eliminarResena($id_usuario, $id_articulo);
            echo json_encode(['mensaje' => 'Reseña eliminada exitosamente.']);
        } catch (PDOException $e) {
            $error = ['error' => true, 'mensaje' => $e->getMessage()];
            echo json_encode($error);
        }
    }
}
?>
