<?php
require_once 'CarritoModel.php';

class CarritoControlador
{
    private $carritoModel;

    public function __construct()
    {
        // Inicializa el modelo de carrito
        $this->carritoModel = new CarritoModel();
    }

    // Obtener todos los carritos en formato JSON
    public function getCarritosJSON()
    {
        try {
            $carritos = $this->carritoModel->obtenerCarritos();
            header('Content-Type: application/json');
            echo json_encode($carritos);
        } catch (PDOException $e) {
            $error = ['error' => true, 'mensaje' => $e->getMessage()];
            echo json_encode($error);
        }
    }

    // Crear un nuevo carrito
    public function createCarrito($id_usuario, $estado_carrito)
    {
        try {
            $this->carritoModel->crearCarrito($id_usuario, $estado_carrito);
            echo json_encode(['mensaje' => 'Carrito creado exitosamente.']);
        } catch (PDOException $e) {
            $error = ['error' => true, 'mensaje' => $e->getMessage()];
            echo json_encode($error);
        }
    }

    // Buscar un carrito por su ID
    public function buscarCarritoPorId($id_carrito)
    {
        try {
            $carrito = $this->carritoModel->buscarCarritoPorId($id_carrito);
            echo json_encode($carrito ?: ['mensaje' => 'Carrito no encontrado.']);
        } catch (PDOException $e) {
            $error = ['error' => true, 'mensaje' => $e->getMessage()];
            echo json_encode($error);
        }
    }

    // Actualizar el estado de un carrito
    public function updateCarrito($id_carrito, $estado_carrito)
    {
        try {
            $this->carritoModel->actualizarCarrito($id_carrito, $estado_carrito);
            echo json_encode(['mensaje' => 'Carrito actualizado exitosamente.']);
        } catch (PDOException $e) {
            $error = ['error' => true, 'mensaje' => $e->getMessage()];
            echo json_encode($error);
        }
    }

    // Eliminar un carrito por su ID
    public function deleteCarrito($id_carrito)
    {
        try {
            $this->carritoModel->eliminarCarrito($id_carrito);
            echo json_encode(['mensaje' => 'Carrito eliminado exitosamente.']);
        } catch (PDOException $e) {
            $error = ['error' => true, 'mensaje' => $e->getMessage()];
            echo json_encode($error);
        }
    }
}
?>
