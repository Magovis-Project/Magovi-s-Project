<?php
require_once 'conexionModelo.php';

class ArticulosModel
{
    private $conn;

    public function __construct()
    {
        $this->conn = conexionModelo::getInstance()->getDatabaseInstance();
    }

    public function getArticulos()
    {
        $consulta = $this->conn->prepare("SELECT * FROM Articulos;");
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createArticulo($id_empresa, $nombre, $precio, $cantidad, $tipo)
    {
        $consulta = $this->conn->prepare("INSERT INTO Articulos (ID_Empresa, Nombre, Precio, Cantidad, Tipo)
                                          VALUES (:id_empresa, :nombre, :precio, :cantidad, :tipo)");
        $consulta->bindParam(':id_empresa', $id_empresa);
        $consulta->bindParam(':nombre', $nombre);
        $consulta->bindParam(':precio', $precio);
        $consulta->bindParam(':cantidad', $cantidad);
        $consulta->bindParam(':tipo', $tipo);
        $consulta->execute();
    }

    public function updateArticulo($id_articulo, $id_empresa, $nombre, $precio, $cantidad, $tipo)
    {
        $consulta = $this->conn->prepare("UPDATE Articulos SET ID_Empresa = :id_empresa, Nombre = :nombre, Precio = :precio,
                                          Cantidad = :cantidad, Tipo = :tipo WHERE Id_Articulos = :id_articulo");
        $consulta->bindParam(':id_articulo', $id_articulo);
        $consulta->bindParam(':id_empresa', $id_empresa);
        $consulta->bindParam(':nombre', $nombre);
        $consulta->bindParam(':precio', $precio);
        $consulta->bindParam(':cantidad', $cantidad);
        $consulta->bindParam(':tipo', $tipo);
        $consulta->execute();
    }

    public function deleteArticulo($id_articulo)
    {
        $consulta = $this->conn->prepare("DELETE FROM Articulos WHERE Id_Articulos = :id_articulo");
        $consulta->bindParam(':id_articulo', $id_articulo);
        $consulta->execute();
    }

    public function getArticuloById($id_articulo)
    {
        $consulta = $this->conn->prepare("SELECT * FROM Articulos WHERE Id_Articulos = :id_articulo");
        $consulta->bindParam(':id_articulo', $id_articulo);
        $consulta->execute();
        return $consulta->fetch(PDO::FETCH_ASSOC);
    }
}
