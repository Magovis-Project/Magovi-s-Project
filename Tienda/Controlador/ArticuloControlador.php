<?php
class ArticuloController
{
    private $conn;

    public function __construct()
    {
        $this->conn = ConexionModel::getInstance()->getDatabaseInstance();
    }

    // Obtener todos los artículos
    public function getArticulosJSON()
    {
        try {
            $consulta = $this->conn->prepare("SELECT * FROM articulos;");
            $consulta->execute();
            $articulos = $consulta->fetchAll(PDO::FETCH_ASSOC);

            // Devolver los datos como JSON
            header('Content-Type: application/json');
            echo json_encode($articulos);
        } catch (PDOException $e) {
            $error = [
                'error' => true,
                'mensaje' => $e->getMessage()
            ];
            echo json_encode($error);
        }
    }

    // Crear un nuevo artículo
    public function createArticulo($nombre, $precio, $cantidad, $tipo, $id_empresa)
    {
        try {
            $consulta = $this->conn->prepare("INSERT INTO articulos (nombre, precio, cantidad, tipo, id_empresa) VALUES (?, ?, ?, ?, ?);");
            $consulta->bindParam(1, $nombre);
            $consulta->bindParam(2, $precio);
            $consulta->bindParam(3, $cantidad);
            $consulta->bindParam(4, $tipo);
            $consulta->bindParam(5, $id_empresa);
            $consulta->execute();

            echo json_encode(['mensaje' => 'Artículo creado exitosamente.']);
        } catch (PDOException $e) {
            $error = [
                'error' => true,
                'mensaje' => $e->getMessage()
            ];
            echo json_encode($error);
        }
    }

    // Buscar artículo por ID
    public function buscarArticuloPorId($id_articulo)
    {
        try {
            $consulta = $this->conn->prepare("SELECT * FROM articulos WHERE id_articulo = ?;");
            $consulta->bindParam(1, $id_articulo);
            $consulta->execute();
            $articulo = $consulta->fetch(PDO::FETCH_ASSOC);

            if ($articulo) {
                echo json_encode($articulo);
            } else {
                echo json_encode(['mensaje' => 'Artículo no encontrado.']);
            }
        } catch (PDOException $e) {
            $error = [
                'error' => true,
                'mensaje' => $e->getMessage()
            ];
            echo json_encode($error);
        }
    }

    // Actualizar un artículo
    public function updateArticulo($id_articulo, $nombre, $precio, $cantidad, $tipo)
    {
        try {
            $consulta = $this->conn->prepare("UPDATE articulos SET nombre = ?, precio = ?, cantidad = ?, tipo = ? WHERE id_articulo = ?;");
            $consulta->bindParam(1, $nombre);
            $consulta->bindParam(2, $precio);
            $consulta->bindParam(3, $cantidad);
            $consulta->bindParam(4, $tipo);
            $consulta->bindParam(5, $id_articulo);
            $consulta->execute();

            echo json_encode(['mensaje' => 'Artículo actualizado exitosamente.']);
        } catch (PDOException $e) {
            $error = [
                'error' => true,
                'mensaje' => $e->getMessage()
            ];
            echo json_encode($error);
        }
    }

    // Eliminar un artículo
    public function deleteArticulo($id_articulo)
    {
        try {
            $consulta = $this->conn->prepare("DELETE FROM articulos WHERE id_articulo = ?;");
            $consulta->bindParam(1, $id_articulo);
            $consulta->execute();

            echo json_encode(['mensaje' => 'Artículo eliminado exitosamente.']);
        } catch (PDOException $e) {
            $error = [
                'error' => true,
                'mensaje' => $e->getMessage()
            ];
            echo json_encode($error);
        }
    }
}
