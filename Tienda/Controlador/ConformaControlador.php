<?php
require_once '../Modelo/ConformaModel.php';

class ConformaControlador
{
    private $conformaModel;

    public function __construct()
    {
        $this->conformaModel = new ConformaModel();
    }

    public function getConformaJSON()
    {
        try {
            $conforma = $this->conformaModel->getConforma();
            header('Content-Type: application/json');
            echo json_encode($conforma);
        } catch (PDOException $e) {
            echo json_encode(['error' => true, 'mensaje' => $e->getMessage()]);
        }
    }

    public function createConforma($id_usuario, $id_articulo)
    {
        try {
            $this->conformaModel->createConforma($id_usuario, $id_articulo);
            echo json_encode(['success' => true, 'message' => 'Relación conforma creada exitosamente']);
        } catch (PDOException $e) {
            echo json_encode(['error' => true, 'message' => $e->getMessage()]);
        }
    }

    public function deleteConforma($id_usuario, $id_articulo)
    {
        try {
            $this->conformaModel->deleteConforma($id_usuario, $id_articulo);
            echo json_encode(['success' => true, 'message' => 'Relación conforma eliminada correctamente']);
        } catch (PDOException $e) {
            echo json_encode(['error' => true, 'message' => $e->getMessage()]);
        }
    }

    public function getConformaByIds($id_usuario, $id_articulo)
    {
        try {
            $conforma = $this->conformaModel->getConformaByIds($id_usuario, $id_articulo);
            echo json_encode($conforma);
        } catch (PDOException $e) {
            echo json_encode(['error' => true, 'message' => $e->getMessage()]);
        }
    }
}
