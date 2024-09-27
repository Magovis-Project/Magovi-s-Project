<?php
require_once 'RepartidorModel.php';

class RepartidorControlador
{
    private $repartidorModel;

    public function __construct()
    {
        $this->repartidorModel = new RepartidorModel();
    }

    // Obtener todos los repartidores en formato JSON
    public function getRepartidoresJSON()
    {
        try {
            $repartidores = $this->repartidorModel->obtenerRepartidores();
            header('Content-Type: application/json');
            echo json_encode($repartidores);
        } catch (PDOException $e) {
            $error = ['error' => true, 'mensaje' => $e->getMessage()];
            echo json_encode($error);
        }
    }

    // Crear un nuevo repartidor
    public function createRepartidor($id_carrito, $empresa_matriz)
    {
        try {
            $this->repartidorModel->crearRepartidor($id_carrito, $empresa_matriz);
            echo json_encode(['mensaje' => 'Repartidor creado exitosamente.']);
        } catch (PDOException $e) {
            $error = ['error' => true, 'mensaje' => $e->getMessage()];
            echo json_encode($error);
        }
    }

    // Buscar un repartidor por su ID
    public function buscarRepartidorPorId($id_repartidor)
    {
        try {
            $repartidor = $this->repartidorModel->buscarRepartidorPorId($id_repartidor);
            echo json_encode($repartidor ?: ['mensaje' => 'Repartidor no encontrado.']);
        } catch (PDOException $e) {
            $error = ['error' => true, 'mensaje' => $e->getMessage()];
            echo json_encode($error);
        }
    }

    // Actualizar un repartidor
    public function updateRepartidor($id_repartidor, $id_carrito, $empresa_matriz)
    {
        try {
            $this->repartidorModel->actualizarRepartidor($id_repartidor, $id_carrito, $empresa_matriz);
            echo json_encode(['mensaje' => 'Repartidor actualizado exitosamente.']);
        } catch (PDOException $e) {
            $error = ['error' => true, 'mensaje' => $e->getMessage()];
            echo json_encode($error);
        }
    }

    // Eliminar un repartidor
    public function deleteRepartidor($id_repartidor)
    {
        try {
            $this->repartidorModel->eliminarRepartidor($id_repartidor);
            echo json_encode(['mensaje' => 'Repartidor eliminado exitosamente.']);
        } catch (PDOException $e) {
            $error = ['error' => true, 'mensaje' => $e->getMessage()];
            echo json_encode($error);
        }
    }
}
?>
