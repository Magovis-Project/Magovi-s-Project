<?php
require_once 'ConexionModel.php';

class RepartidorModel
{
    private $conn;

    public function __construct()
    {
        $this->conn = conexionModelo::getInstance()->getDatabaseInstance();
    }

    public function getRepartidores()
    {
        $consulta = $this->conn->prepare("SELECT * FROM Repartidor;");
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createRepartidor($nombre, $telefono)
    {
        $consulta = $this->conn->prepare("INSERT INTO Repartidor (Nombre, Telefono) 
                                          VALUES (:nombre, :telefono)");
        $consulta->bindParam(':nombre', $nombre);
        $consulta->bindParam(':telefono', $telefono);
        $consulta->execute();
    }

    public function updateRepartidor($id_repartidor, $nombre, $telefono)
    {
        $consulta = $this->conn->prepare("UPDATE Repartidor SET Nombre = :nombre, Telefono = :telefono 
                                          WHERE Id_Repartidor = :id_repartidor");
        $consulta->bindParam(':id_repartidor', $id_repartidor);
        $consulta->bindParam(':nombre', $nombre);
        $consulta->bindParam(':telefono', $telefono);
        $consulta->execute();
    }

    public function deleteRepartidor($id_repartidor)
    {
        $consulta = $this->conn->prepare("DELETE FROM Repartidor WHERE Id_Repartidor = :id_repartidor");
        $consulta->bindParam(':id_repartidor', $id_repartidor);
        $consulta->execute();
    }

    public function getRepartidorById($id_repartidor)
    {
        $consulta = $this->conn->prepare("SELECT * FROM Repartidor WHERE Id_Repartidor = :id_repartidor");
        $consulta->bindParam(':id_repartidor', $id_repartidor);
        $consulta->execute();
        return $consulta->fetch(PDO::FETCH_ASSOC);
    }
}
