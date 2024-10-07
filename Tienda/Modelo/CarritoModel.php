<?php
require_once 'conexionModelo.php';

class CarritoModel
{
    private $conn;

    public function __construct()
    {
        $this->conn = conexionModelo::getInstance()->getDatabaseInstance();
    }

    public function getCarrito()
    {
        $consulta = $this->conn->prepare("SELECT * FROM Carrito;");
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createCarrito($id_usuario, $cantidad)
    {
        $consulta = $this->conn->prepare("INSERT INTO Carrito (Id_Usuario, Cantidad)
                                          VALUES (:id_usuario, :cantidad)");
        $consulta->bindParam(':id_usuario', $id_usuario);
        $consulta->bindParam(':cantidad', $cantidad);
        $consulta->execute();
    }

    public function updateCarrito($id_usuario, $cantidad)
    {
        $consulta = $this->conn->prepare("UPDATE Carrito SET Cantidad = :cantidad WHERE Id_Usuario = :id_usuario");
        $consulta->bindParam(':id_usuario', $id_usuario);
        $consulta->bindParam(':cantidad', $cantidad);
        $consulta->execute();
    }

    public function deleteCarrito($id_usuario)
    {
        $consulta = $this->conn->prepare("DELETE FROM Carrito WHERE Id_Usuario = :id_usuario");
        $consulta->bindParam(':id_usuario', $id_usuario);
        $consulta->execute();
    }

    public function getCarritoById($id_usuario)
    {
        $consulta = $this->conn->prepare("SELECT * FROM Carrito WHERE Id_Usuario = :id_usuario");
        $consulta->bindParam(':id_usuario', $id_usuario);
        $consulta->execute();
        return $consulta->fetch(PDO::FETCH_ASSOC);
    }
}
