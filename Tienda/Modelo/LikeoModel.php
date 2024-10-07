<?php
require_once 'conexionModelo.php';

class LikeoModel
{
    private $conn;

    public function __construct()
    {
        $this->conn = conexionModelo::getInstance()->getDatabaseInstance();
    }

    public function getLikes()
    {
        $consulta = $this->conn->prepare("SELECT * FROM Likeo;");
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createLike($id_usuario, $id_articulo)
    {
        $consulta = $this->conn->prepare("INSERT INTO Likeo (Id_Usuario, Id_Articulo) 
                                          VALUES (:id_usuario, :id_articulo)");
        $consulta->bindParam(':id_usuario', $id_usuario);
        $consulta->bindParam(':id_articulo', $id_articulo);
        $consulta->execute();
    }

    public function deleteLike($id_usuario, $id_articulo)
    {
        $consulta = $this->conn->prepare("DELETE FROM Likeo WHERE Id_Usuario = :id_usuario AND Id_Articulo = :id_articulo");
        $consulta->bindParam(':id_usuario', $id_usuario);
        $consulta->bindParam(':id_articulo', $id_articulo);
        $consulta->execute();
    }

    public function getLikeByIds($id_usuario, $id_articulo)
    {
        $consulta = $this->conn->prepare("SELECT * FROM Likeo WHERE Id_Usuario = :id_usuario AND Id_Articulo = :id_articulo");
        $consulta->bindParam(':id_usuario', $id_usuario);
        $consulta->bindParam(':id_articulo', $id_articulo);
        $consulta->execute();
        return $consulta->fetch(PDO::FETCH_ASSOC);
    }
}
