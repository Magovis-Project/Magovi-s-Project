<?php
require_once 'conexionModelo.php';

class ComponeModel
{
    private $conn;

    public function __construct()
    {
        $this->conn = conexionModelo::getInstance()->getDatabaseInstance();
    }

    public function getCompones()
    {
        $consulta = $this->conn->prepare("SELECT * FROM Compone;");
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createCompone($id_compra, $id_articulo, $cantidad)
    {
        $consulta = $this->conn->prepare("INSERT INTO Compone (Id_Compra, Id_Articulo, Cantidad) 
                                          VALUES (:id_compra, :id_articulo, :cantidad)");
        $consulta->bindParam(':id_compra', $id_compra);
        $consulta->bindParam(':id_articulo', $id_articulo);
        $consulta->bindParam(':cantidad', $cantidad);
        $consulta->execute();
    }

    public function updateCompone($id_compra, $id_articulo, $cantidad)
    {
        $consulta = $this->conn->prepare("UPDATE Compone SET Cantidad = :cantidad 
                                          WHERE Id_Compra = :id_compra AND Id_Articulo = :id_articulo");
        $consulta->bindParam(':id_compra', $id_compra);
        $consulta->bindParam(':id_articulo', $id_articulo);
        $consulta->bindParam(':cantidad', $cantidad);
        $consulta->execute();
    }

    public function deleteCompone($id_compra, $id_articulo)
    {
        $consulta = $this->conn->prepare("DELETE FROM Compone WHERE Id_Compra = :id_compra AND Id_Articulo = :id_articulo");
        $consulta->bindParam(':id_compra', $id_compra);
        $consulta->bindParam(':id_articulo', $id_articulo);
        $consulta->execute();
    }

    public function getComponeByIds($id_compra, $id_articulo)
    {
        $consulta = $this->conn->prepare("SELECT * FROM Compone WHERE Id_Compra = :id_compra AND Id_Articulo = :id_articulo");
        $consulta->bindParam(':id_compra', $id_compra);
        $consulta->bindParam(':id_articulo', $id_articulo);
        $consulta->execute();
        return $consulta->fetch(PDO::FETCH_ASSOC);
    }
}
