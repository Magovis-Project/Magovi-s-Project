<?php
require_once 'ConexionModel.php';

class VioModel
{
    private $conn;

    public function __construct()
    {
        $this->conn = conexionModelo::getInstance()->getDatabaseInstance();
    }

    public function getVios()
    {
        $consulta = $this->conn->prepare("SELECT * FROM Vio;");
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createVio($id_usuario, $id_articulo)
    {
        $consulta = $this->conn->prepare("INSERT INTO Vio (Id_Usuario, Id_Articulo) 
                                          VALUES (:id_usuario, :id_articulo)");
        $consulta->bindParam(':id_usuario', $id_usuario);
        $consulta->bindParam(':id_articulo', $id_articulo);
        $consulta->execute();
    }

    public function deleteVio($id_usuario, $id_articulo)
    {
        $consulta = $this->conn->prepare("DELETE FROM Vio WHERE Id_Usuario = :id_usuario AND Id_Articulo = :id_articulo");
        $consulta->bindParam(':id_usuario', $id_usuario);
        $consulta->bindParam(':id_articulo', $id_articulo);
        $consulta->execute();
    }

    public function getVioByIds($id_usuario, $id_articulo)
    {
        $consulta = $this->conn->prepare("SELECT * FROM Vio WHERE Id_Usuario = :id_usuario AND Id_Articulo = :id_articulo");
        $consulta->bindParam(':id_usuario', $id_usuario);
        $consulta->bindParam(':id_articulo', $id_articulo);
        $consulta->execute();
        return $consulta->fetch(PDO::FETCH_ASSOC);
    }

    public function getArticulosVistosByUsuario($id_usuario)
{
    $consulta = $this->conn->prepare("
        SELECT a.* FROM Vio v
        JOIN Articulos a ON v.Id_Articulo = a.Id_Articulo
        WHERE v.Id_Usuario = :id_usuario
    ");
    $consulta->bindParam(':id_usuario', $id_usuario);
    $consulta->execute();
    return $consulta->fetchAll(PDO::FETCH_ASSOC);
}



}
