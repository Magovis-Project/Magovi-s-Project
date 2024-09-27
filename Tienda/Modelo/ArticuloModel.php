<?php
class ArticuloModel
{
    private $conn;

    public function __construct()
    {
        $this->conn = conexionModelo::getInstance()->getDatabaseInstance();
    }

    public function obtenerArticulos()
    {
        $consulta = $this->conn->prepare("SELECT * FROM articulos;");
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_ASSOC);
    }

    public function crearArticulo($nombre, $precio, $cantidad, $tipo, $id_empresa)
    {
        $consulta = $this->conn->prepare("INSERT INTO articulos (nombre, precio, cantidad, tipo, id_empresa) VALUES (?, ?, ?, ?, ?);");
        $consulta->bindParam(1, $nombre);
        $consulta->bindParam(2, $precio);
        $consulta->bindParam(3, $cantidad);
        $consulta->bindParam(4, $tipo);
        $consulta->bindParam(5, $id_empresa);
        return $consulta->execute();
    }

    public function buscarArticuloPorId($id_articulo)
    {
        $consulta = $this->conn->prepare("SELECT * FROM articulos WHERE id_articulo = ?;");
        $consulta->bindParam(1, $id_articulo);
        $consulta->execute();
        return $consulta->fetch(PDO::FETCH_ASSOC);
    }

    public function actualizarArticulo($id_articulo, $nombre, $precio, $cantidad, $tipo)
    {
        $consulta = $this->conn->prepare("UPDATE articulos SET nombre = ?, precio = ?, cantidad = ?, tipo = ? WHERE id_articulo = ?;");
        $consulta->bindParam(1, $nombre);
        $consulta->bindParam(2, $precio);
        $consulta->bindParam(3, $cantidad);
        $consulta->bindParam(4, $tipo);
        $consulta->bindParam(5, $id_articulo);
        return $consulta->execute();
    }

    public function eliminarArticulo($id_articulo)
    {
        $consulta = $this->conn->prepare("DELETE FROM articulos WHERE id_articulo = ?;");
        $consulta->bindParam(1, $id_articulo);
        return $consulta->execute();
    }
}
?>
