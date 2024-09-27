<?php
require_once 'CompraModel.php';

class CompraControlador
{
    private $compraModel;

    public function __construct()
    {
        $this->compraModel = new CompraModel();
    }

    // Obtener todas las compras en formato JSON
    public function getComprasJSON()
    {
        try {
            $compras = $this->compraModel->obtenerCompras();
            header('Content-Type: application/json');
            echo json_encode($compras);
        } catch (PDOException $e) {
            $error = ['error' => true, 'mensaje' => $e->getMessage()];
            echo json_encode($error);
        }
    }

    // Crear una nueva compra
    public function createCompra($id_usuario, $id_articulo)
    {
        try {
            $this->compraModel->crearCompra($id_usuario, $id_articulo);
            echo json_encode(['mensaje' => 'Compra creada exitosamente.']);
        } catch (PDOException $e) {
            $error = ['error' => true, 'mensaje' => $e->getMessage()];
            echo json_encode($error);
        }
    }

    // Buscar una compra por el ID del usuario y el ID del artículo
    public function buscarCompra($id_usuario, $id_articulo)
    {
        try {
            $compra = $this->compraModel->buscarCompra($id_usuario, $id_articulo);
            echo json_encode($compra ?: ['mensaje' => 'Compra no encontrada.']);
        } catch (PDOException $e) {
            $error = ['error' => true, 'mensaje' => $e->getMessage()];
            echo json_encode($error);
        }
    }

    // Actualizar una compra (si es necesario, según tu lógica)
    public function updateCompra($id_usuario, $id_articulo, $nuevoIdArticulo)
    {
        try {
            $this->compraModel->actualizarCompra($id_usuario, $id_articulo, $nuevoIdArticulo);
            echo json_encode(['mensaje' => 'Compra actualizada exitosamente.']);
        } catch (PDOException $e) {
            $error = ['error' => true, 'mensaje' => $e->getMessage()];
            echo json_encode($error);
        }
    }

    // Eliminar una compra
    public function deleteCompra($id_usuario, $id_articulo)
    {
        try {
            $this->compraModel->eliminarCompra($id_usuario, $id_articulo);
            echo json_encode(['mensaje' => 'Compra eliminada exitosamente.']);
        } catch (PDOException $e) {
            $error = ['error' => true, 'mensaje' => $e->getMessage()];
            echo json_encode($error);
        }
    }
}
?>
