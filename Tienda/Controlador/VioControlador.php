<?php
require_once 'VioModel.php';

class VioControlador
{
    private $vioModel;

    public function __construct()
    {
        $this->vioModel = new VioModel();
    }

    public function getViosJSON()
    {
        try {
            $vios = $this->vioModel->getVios();
            header('Content-Type: application/json');
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
