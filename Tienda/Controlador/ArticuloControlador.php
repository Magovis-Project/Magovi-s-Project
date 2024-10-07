<?php
require_once 'ArticulosModel.php';

class ArticulosControlador
{
    private $articulosModel;

    public function __construct()
    {
        $this->articulosModel = new ArticulosModel();
    }

    public function getArticulosJSON()
    {
        try {
            $articulos = $this->articulosModel->getArticulos();
            header('Content-Type: application/json');
            echo json_encode($articulos);
        } catch (PDOException $e) {
            echo json_encode(['error' => true, 'mensaje' => $e->getMessage()]);
        }
    }

    public function createArticulo($id_empresa, $nombre, $precio, $cantidad, $tipo)
    {
        try {
            $this->articulosModel->createArticulo($id_empresa, $nombre, $precio, $cantidad, $tipo);
            echo json_encode(['success' => true, 'message' => 'Artículo creado exitosamente']);
        } catch (PDOException $e) {
            echo json_encode(['error' => true, 'message' => $e->getMessage()]);
        }
    }

    public function updateArticulo($id_articulo, $id_empresa, $nombre, $precio, $cantidad, $tipo)
    {
        try {
            $this->articulosModel->updateArticulo($id_articulo, $id_empresa, $nombre, $precio, $cantidad, $tipo);
            echo json_encode(['success' => true, 'message' => 'Artículo actualizado correctamente']);
        } catch (PDOException $e) {
            echo json_encode(['error' => true, 'message' => $e->getMessage()]);
        }
    }

    public function deleteArticulo($id_articulo)
    {
        try {
            $this->articulosModel->deleteArticulo($id_articulo);
            echo json_encode(['success' => true, 'message' => 'Artículo eliminado correctamente']);
        } catch (PDOException $e) {
            echo json_encode(['error' => true, 'message' => $e->getMessage()]);
        }
    }

    public function getArticuloById($id_articulo)
    {
        try {
            $articulo = $this->articulosModel->getArticuloById($id_articulo);
            echo json_encode($articulo);
        } catch (PDOException $e) {
            echo json_encode(['error' => true, 'message' => $e->getMessage()]);
        }
    }
}
