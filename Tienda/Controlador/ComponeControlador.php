<?php
require_once 'ComponeModel.php';

class ComponeControlador
{
    private $componeModel;

    public function __construct()
    {
        $this->componeModel = new ComponeModel();
    }

    public function getComponesJSON()
    {
        try {
            $Compones = $this->componeModel->getCompones();
            header('Content-Type: application/json');
            echo json_encode($Compones);
        } catch (PDOException $e) {
            echo json_encode(['error' => true, 'mensaje' => $e->getMessage()]);
        }
    }

    public function createCompone($id_compra, $id_articulo, $cantidad)
    {
        try {
            $this->componeModel->createCompone($id_compra, $id_articulo, $cantidad);
            echo json_encode(['success' => true, 'message' => 'Compone registrado exitosamente']);
        } catch (PDOException $e) {
            echo json_encode(['error' => true, 'message' => $e->getMessage()]);
        }
    }

    public function updateCompone($id_compra, $id_articulo, $cantidad)
    {
        try {
            $this->componeModel->updateCompone($id_compra, $id_articulo, $cantidad);
            echo json_encode(['success' => true, 'message' => 'Compone actualizado correctamente']);
        } catch (PDOException $e) {
            echo json_encode(['error' => true, 'message' => $e->getMessage()]);
        }
    }

    public function deleteCompone($id_compra, $id_articulo)
    {
        try {
            $this->componeModel->deleteCompone($id_compra, $id_articulo);
            echo json_encode(['success' => true, 'message' => 'Compone eliminado correctamente']);
        } catch (PDOException $e) {
            echo json_encode(['error' => true, 'message' => $e->getMessage()]);
        }
    }

    public function getComponeByIds($id_compra, $id_articulo)
    {
        try {
            $Compone = $this->componeModel->getComponeByIds($id_compra, $id_articulo);
            echo json_encode($Compone);
        } catch (PDOException $e) {
            echo json_encode(['error' => true, 'message' => $e->getMessage()]);
        }
    }
}
