<?php
require_once '../Modelo/CarritoModel.php';

class CarritoControlador
{
    private $carritoModel;

    public function __construct()
    {
        $this->carritoModel = new CarritoModel();
    }

    public function getCarritoJSON()
    {
        try {
            $carrito = $this->carritoModel->getCarrito();
            header('Content-Type: application/json');
            echo json_encode($carrito);
        } catch (PDOException $e) {
            echo json_encode(['error' => true, 'mensaje' => $e->getMessage()]);
        }
    }

    public function createCarrito($id_usuario, $cantidad)
    {
        try {
            $this->carritoModel->createCarrito($id_usuario, $cantidad);
            echo json_encode(['success' => true, 'message' => 'Carrito creado exitosamente']);
        } catch (PDOException $e) {
            echo json_encode(['error' => true, 'message' => $e->getMessage()]);
        }
    }

    public function updateCarrito($id_usuario, $cantidad)
    {
        try {
            $this->carritoModel->updateCarrito($id_usuario, $cantidad);
            echo json_encode(['success' => true, 'message' => 'Carrito actualizado correctamente']);
        } catch (PDOException $e) {
            echo json_encode(['error' => true, 'message' => $e->getMessage()]);
        }
    }

    public function deleteCarrito($id_usuario)
    {
        try {
            $this->carritoModel->deleteCarrito($id_usuario);
            echo json_encode(['success' => true, 'message' => 'Carrito eliminado correctamente']);
        } catch (PDOException $e) {
            echo json_encode(['error' => true, 'message' => $e->getMessage()]);
        }
    }

    public function getCarritoById($id_usuario)
    {
        try {
            $carrito = $this->carritoModel->getCarritoById($id_usuario);
            echo json_encode($carrito);
        } catch (PDOException $e) {
            echo json_encode(['error' => true, 'message' => $e->getMessage()]);
        }
    }
}
