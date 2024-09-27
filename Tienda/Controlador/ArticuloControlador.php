<?php
require_once 'ArticuloModel.php';

class ArticuloControlador
{
    private $articuloModel;

    public function __construct()
    {
        $this->articuloModel = new ArticuloModel();
    }

    public function getArticulosJSON()
    {
        try {
            $articulos = $this->articuloModel->obtenerArticulos();
            header('Content-Type: application/json');
            echo json_encode($articulos);
        } catch (PDOException $e) {
            $error = ['error' => true, 'mensaje' => $e->getMessage()];
            echo json_encode($error);
        }
    }

    public function createArticulo($nombre, $precio, $cantidad, $tipo, $id_empresa)
    {
        try {
            $this->articuloModel->crearArticulo($nombre, $precio, $cantidad, $tipo, $id_empresa);
            echo json_encode(['mensaje' => 'Artículo creado exitosamente.']);
        } catch (PDOException $e) {
            $error = ['error' => true, 'mensaje' => $e->getMessage()];
            echo json_encode($error);
        }
    }

    public function buscarArticuloPorId($id_articulo)
    {
        try {
            $articulo = $this->articuloModel->buscarArticuloPorId($id_articulo);
            echo json_encode($articulo ?: ['mensaje' => 'Artículo no encontrado.']);
        } catch (PDOException $e) {
            $error = ['error' => true, 'mensaje' => $e->getMessage()];
            echo json_encode($error);
        }
    }

    public function updateArticulo($id_articulo, $nombre, $precio, $cantidad, $tipo)
    {
        try {
            $this->articuloModel->actualizarArticulo($id_articulo, $nombre, $precio, $cantidad, $tipo);
            echo json_encode(['mensaje' => 'Artículo actualizado exitosamente.']);
        } catch (PDOException $e) {
            $error = ['error' => true, 'mensaje' => $e->getMessage()];
            echo json_encode($error);
        }
    }

    public function deleteArticulo($id_articulo)
    {
        try {
            $this->articuloModel->eliminarArticulo($id_articulo);
            echo json_encode(['mensaje' => 'Artículo eliminado exitosamente.']);
        } catch (PDOException $e) {
            $error = ['error' => true, 'mensaje' => $e->getMessage()];
            echo json_encode($error);
        }
    }
}
?>
