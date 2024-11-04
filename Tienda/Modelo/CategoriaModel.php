<?php
require_once 'ConexionModel.php';

class CategoriaModel
{
    private $conn;

    public function __construct()
    {
        $this->conn = conexionModelo::getInstance()->getDatabaseInstance();
    }

    public function createCategoria($nombre)
    {
        $consulta = $this->conn->prepare("INSERT INTO Categorias (Nombre) VALUES (:nombre)");
        $consulta->bindParam(':nombre', $nombre);
        $consulta->execute();
    }

    public function getAllCategorias()
    {
        $consulta = $this->conn->prepare("SELECT ID_Categoria, Nombre FROM Categorias");
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCategoriaById($id_categoria)
    {
        $consulta = $this->conn->prepare("SELECT ID_Categoria, Nombre FROM Categorias WHERE ID_Categoria = :id_categoria");
        $consulta->bindParam(':id_categoria', $id_categoria);
        $consulta->execute();
        return $consulta->fetch(PDO::FETCH_ASSOC);
    }

    public function updateCategoria($id_categoria, $nombre)
    {
        $consulta = $this->conn->prepare("UPDATE Categorias SET Nombre = :nombre WHERE ID_Categoria = :id_categoria");
        $consulta->bindParam(':id_categoria', $id_categoria);
        $consulta->bindParam(':nombre', $nombre);
        $consulta->execute();
    }

    public function deleteCategoria($id_categoria)
    {
        $consulta = $this->conn->prepare("DELETE FROM Categorias WHERE ID_Categoria = :id_categoria");
        $consulta->bindParam(':id_categoria', $id_categoria);
        $consulta->execute();
    }
}
