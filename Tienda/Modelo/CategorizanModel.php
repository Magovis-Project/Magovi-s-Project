<?php
require_once 'ConexionModel.php';

class CategorizanModel
{
    private $conn;

    public function __construct()
    {
        $this->conn = conexionModelo::getInstance()->getDatabaseInstance();
    }

    public function addCategorizacion($id_articulo, $id_categoria)
    {
        $consulta = $this->conn->prepare("INSERT INTO Categorizan (Id_Articulo, Id_Categoria) VALUES (:id_articulo, :id_categoria)");
        $consulta->bindParam(':id_articulo', $id_articulo);
        $consulta->bindParam(':id_categoria', $id_categoria);
        $consulta->execute();
    }

    public function getCategoriasByArticulo($id_articulo)
    {
        $consulta = $this->conn->prepare("SELECT Id_Categoria FROM Categorizan WHERE Id_Articulo = :id_articulo");
        $consulta->bindParam(':id_articulo', $id_articulo);
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getArticulosByCategoria($nombre_categoria)
{
    $consulta = $this->conn->prepare("
        SELECT a.Id_Articulos, a.Nombre, a.Precio, a.Cantidad, a.Descripcion, a.Valoracion, a.Actividad
        FROM Articulos a
        JOIN Categorizan c ON a.Id_Articulos = c.Id_Articulo
        JOIN Categorias cat ON c.Id_Categoria = cat.ID_Categoria
        WHERE cat.Nombre = :nombre_categoria
    ");
    $consulta->bindParam(':nombre_categoria', $nombre_categoria);
    $consulta->execute();
    return $consulta->fetchAll(PDO::FETCH_ASSOC);
}


    public function deleteCategorizacion($id_articulo, $id_categoria)
    {
        $consulta = $this->conn->prepare("DELETE FROM Categorizan WHERE Id_Articulo = :id_articulo AND Id_Categoria = :id_categoria");
        $consulta->bindParam(':id_articulo', $id_articulo);
        $consulta->bindParam(':id_categoria', $id_categoria);
        $consulta->execute();
    }
}
?>
