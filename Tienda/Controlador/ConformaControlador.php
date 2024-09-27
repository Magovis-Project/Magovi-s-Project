<?php
require_once 'ConformaModel.php';

class ConformaControlador
{
    private $conformaModel;

    public function __construct()
    {
        $this->conformaModel = new ConformaModel();
    }

    // Obtener todos los registros de "conforma"
    public function getConformaJSON()
    {
        try {
            $conformas = $this->conformaModel->obtenerConforma();
            header('Content-Type: application/json');
            echo json_encode($conformas);
        } catch (PDOException $e) {
            $error = ['error' => true, 'mensaje' => $e->getMessage()];
            echo json_encode($error);
        }
    }

    // Crear un nuevo registro en "conforma"
    public function createConforma($id_usuario, $id_articulo, $id_carrito)
    {
        try {
            $this->conformaModel->crearConforma($id_usuario, $id_articulo, $id_carrito);
            echo json_encode(['mensaje' => 'Registro en Conforma creado exitosamente.']);
        } catch (PDOException $e) {
            $error = ['error' => true, 'mensaje' => $e->getMessage()];
            echo json_encode($error);
        }
    }

    // Buscar un registro por ID de usuario, ID de artículo e ID de carrito
    public function buscarConforma($id_usuario, $id_articulo, $id_carrito)
    {
        try {
            $conforma = $this->conformaModel->buscarConforma($id_usuario, $id_articulo, $id_carrito);
            echo json_encode($conforma ?: ['mensaje' => 'Registro no encontrado.']);
        } catch (PDOException $e) {
            $error = ['error' => true, 'mensaje' => $e->getMessage()];
            echo json_encode($error);
        }
    }

    // Actualizar un registro en "conforma"
    public function updateConforma($id_usuario, $id_articulo, $id_carrito)
    {
        try {
            $this->conformaModel->actualizarConforma($id_usuario, $id_articulo, $id_carrito);
            echo json_encode(['mensaje' => 'Registro actualizado exitosamente.']);
        } catch (PDOException $e) {
            $error = ['error' => true, 'mensaje' => $e->getMessage()];
            echo json_encode($error);
        }
    }

    // Eliminar un registro en "conforma"
    public function deleteConforma($id_usuario, $id_articulo, $id_carrito)
    {
        try {
            $this->conformaModel->eliminarConforma($id_usuario, $id_articulo, $id_carrito);
            echo json_encode(['mensaje' => 'Registro eliminado exitosamente.']);
        } catch (PDOException $e) {
            $error = ['error' => true, 'mensaje' => $e->getMessage()];
            echo json_encode($error);
        }
    }
}
?>
