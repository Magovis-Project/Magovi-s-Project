<?php
require_once '../Modelo/RepartidorModel.php';

class RepartidorControlador
{
    private $repartidorModel;

    public function __construct()
    {
        $this->repartidorModel = new RepartidorModel();
    }

    public function getRepartidoresJSON()
    {
        try {
            $repartidores = $this->repartidorModel->getRepartidores();
            header('Content-Type: application/json');
            echo json_encode($repartidores);
        } catch (PDOException $e) {
            echo json_encode(['error' => true, 'mensaje' => $e->getMessage()]);
        }
    }

    public function createRepartidor($nombre, $telefono)
    {
        try {
            $this->repartidorModel->createRepartidor($nombre, $telefono);
            echo json_encode(['success' => true, 'message' => 'Repartidor creado exitosamente']);
        } catch (PDOException $e) {
            echo json_encode(['error' => true, 'message' => $e->getMessage()]);
        }
    }

    public function updateRepartidor($id_repartidor, $nombre, $telefono)
    {
        try {
            $this->repartidorModel->updateRepartidor($id_repartidor, $nombre, $telefono);
            echo json_encode(['success' => true, 'message' => 'Repartidor actualizado correctamente']);
        } catch (PDOException $e) {
            echo json_encode(['error' => true, 'message' => $e->getMessage()]);
        }
    }

    public function deleteRepartidor($id_repartidor)
    {
        try {
            $this->repartidorModel->deleteRepartidor($id_repartidor);
            echo json_encode(['success' => true, 'message' => 'Repartidor eliminado correctamente']);
        } catch (PDOException $e) {
            echo json_encode(['error' => true, 'message' => $e->getMessage()]);
        }
    }

    public function getRepartidorById($id_repartidor)
    {
        try {
            $repartidor = $this->repartidorModel->getRepartidorById($id_repartidor);
            echo json_encode($repartidor);
        } catch (PDOException $e) {
            echo json_encode(['error' => true, 'message' => $e->getMessage()]);
        }
    }
}
