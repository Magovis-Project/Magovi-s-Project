<?php
require_once '../Modelo/EnvioModel.php';

class EnvioControlador
{
    private $envioModel;

    public function __construct()
    {
        $this->envioModel = new EnvioModel();
    }

    public function getEnviosJSON()
    {
        try {
            $envios = $this->envioModel->getEnvios();
            header('Content-Type: application/json');
            echo json_encode($envios);
        } catch (PDOException $e) {
            echo json_encode(['error' => true, 'mensaje' => $e->getMessage()]);
        }
    }

    public function createEnvio($id_compra, $id_repartidor, $direccion, $estado)
    {
        try {
            $this->envioModel->createEnvio($id_compra, $id_repartidor, $direccion, $estado);
            echo json_encode(['success' => true, 'message' => 'Envío creado exitosamente']);
        } catch (PDOException $e) {
            echo json_encode(['error' => true, 'message' => $e->getMessage()]);
        }
    }

    public function updateEnvio($id_envio, $id_repartidor, $direccion, $estado)
    {
        try {
            $this->envioModel->updateEnvio($id_envio, $id_repartidor, $direccion, $estado);
            echo json_encode(['success' => true, 'message' => 'Envío actualizado correctamente']);
        } catch (PDOException $e) {
            echo json_encode(['error' => true, 'message' => $e->getMessage()]);
        }
    }

    public function deleteEnvio($id_envio)
    {
        try {
            $this->envioModel->deleteEnvio($id_envio);
            echo json_encode(['success' => true, 'message' => 'Envío eliminado correctamente']);
        } catch (PDOException $e) {
            echo json_encode(['error' => true, 'message' => $e->getMessage()]);
        }
    }

    public function getEnvioById($id_envio)
    {
        try {
            $envio = $this->envioModel->getEnvioById($id_envio);
            echo json_encode($envio);
        } catch (PDOException $e) {
            echo json_encode(['error' => true, 'message' => $e->getMessage()]);
        }
    }
}
