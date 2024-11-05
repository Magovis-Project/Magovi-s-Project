<?php
require_once '../Modelo/LikeoModel.php';

class LikeoControlador
{
    private $likeoModel;

    public function __construct()
    {
        $this->likeoModel = new LikeoModel();
    }

    public function getLikesJSON()
    {
        try {
            $likes = $this->likeoModel->getLikes();
            header('Content-Type: application/json');
            echo json_encode($likes);
        } catch (PDOException $e) {
            echo json_encode(['error' => true, 'mensaje' => $e->getMessage()]);
        }
    }

    public function createLike($id_usuario, $id_articulo)
    {
        try {
            $this->likeoModel->createLike($id_usuario, $id_articulo);
            echo json_encode(['success' => true, 'message' => 'Like registrado exitosamente']);
        } catch (PDOException $e) {
            echo json_encode(['error' => true, 'message' => $e->getMessage()]);
        }
    }

    public function deleteLike($id_usuario, $id_articulo)
    {
        try {
            $this->likeoModel->deleteLike($id_usuario, $id_articulo);
            echo json_encode(['success' => true, 'message' => 'Like eliminado correctamente']);
        } catch (PDOException $e) {
            echo json_encode(['error' => true, 'message' => $e->getMessage()]);
        }
    }

    public function getLikeByIds($id_usuario, $id_articulo)
    {
        try {
            $like = $this->likeoModel->getLikeByIds($id_usuario, $id_articulo);
            echo json_encode($like);
        } catch (PDOException $e) {
            echo json_encode(['error' => true, 'message' => $e->getMessage()]);
        }
    }
}
