<?php
require_once 'conexionModelo.php';

class EnvioModel
{
    private $conn;

    public function __construct()
    {
        $this->conn = conexionModelo::getInstance()->getDatabaseInstance();
    }

    public function getEnvios()
    {
        $consulta = $this->conn->prepare("SELECT * FROM Envio;");
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createEnvio($id_compra, $id_repartidor, $direccion, $estado)
    {
        $consulta = $this->conn->prepare("INSERT INTO Envio (Id_Compra, Id_Repartidor, Direccion, Estado)
                                          VALUES (:id_compra, :id_repartidor, :direccion, :estado)");
        $consulta->bindParam(':id_compra', $id_compra);
        $consulta->bindParam(':id_repartidor', $id_repartidor);
        $consulta->bindParam(':direccion', $direccion);
        $consulta->bindParam(':estado', $estado);
        $consulta->execute();
    }

    public function updateEnvio($id_envio, $id_repartidor, $direccion, $estado)
    {
        $consulta = $this->conn->prepare("UPDATE Envio SET Id_Repartidor = :id_repartidor, Direccion = :direccion, Estado = :estado 
                                          WHERE Id_Envio = :id_envio");
        $consulta->bindParam(':id_envio', $id_envio);
        $consulta->bindParam(':id_repartidor', $id_repartidor);
        $consulta->bindParam(':direccion', $direccion);
        $consulta->bindParam(':estado', $estado);
        $consulta->execute();
    }

    public function deleteEnvio($id_envio)
    {
        $consulta = $this->conn->prepare("DELETE FROM Envio WHERE Id_Envio = :id_envio");
        $consulta->bindParam(':id_envio', $id_envio);
        $consulta->execute();
    }

    public function getEnvioById($id_envio)
    {
        $consulta = $this->conn->prepare("SELECT * FROM Envio WHERE Id_Envio = :id_envio");
        $consulta->bindParam(':id_envio', $id_envio);
        $consulta->execute();
        return $consulta->fetch(PDO::FETCH_ASSOC);
    }
}
