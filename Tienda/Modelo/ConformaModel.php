<?php
require_once 'ConexionModel.php';

class ConformaModel
{
    private $conn;

    public function __construct()
    {
        $this->conn = conexionModelo::getInstance()->getDatabaseInstance();
    }

    public function getConforma()
    {
        $consulta = $this->conn->prepare("SELECT * FROM Conforma;");
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createConforma($id_usuario, $id_articulo)
    {
        $consulta = $this->conn->prepare("INSERT INTO Conforma (Id_Usuario, ID_Articulo)
                                          VALUES (:id_usuario, :id_articulo)");
        $consulta->bindParam(':id_usuario', $id_usuario);
        $consulta->bindParam(':id_articulo', $id_articulo);
        $consulta->execute();
    }

    public function deleteConforma($id_usuario, $id_articulo)
    {
        $consulta = $this->conn->prepare("DELETE FROM Conforma WHERE Id_Usuario = :id_usuario AND ID_Articulo = :id_articulo");
        $consulta->bindParam(':id_usuario', $id_usuario);
        $consulta->bindParam(':id_articulo', $id_articulo);
        $consulta->execute();
    }

    public function getConformaByIds($id_usuario, $id_articulo)
    {
        $consulta = $this->conn->prepare("SELECT * FROM Conforma WHERE Id_Usuario = :id_usuario AND ID_Articulo = :id_articulo");
        $consulta->bindParam(':id_usuario', $id_usuario);
        $consulta->bindParam(':id_articulo', $id_articulo);
        $consulta->execute();
        return $consulta->fetch(PDO::FETCH_ASSOC);
    }
}
