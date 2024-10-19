<?php
require_once 'ConexionModel.php';

class ReseñaModel
{
    private $conn;

    public function __construct()
    {
        $this->conn = conexionModelo::getInstance()->getDatabaseInstance();
    }

    public function getReseñas()
    {
        $consulta = $this->conn->prepare("SELECT * FROM Reseña;");
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createReseña($id_usuario, $id_articulo, $comentario, $calificacion)
    {
        $consulta = $this->conn->prepare("INSERT INTO Reseña (Id_Usuario, Id_Articulo, Comentario, Calificacion)
                                          VALUES (:id_usuario, :id_articulo, :comentario, :calificacion)");
        $consulta->bindParam(':id_usuario', $id_usuario);
        $consulta->bindParam(':id_articulo', $id_articulo);
        $consulta->bindParam(':comentario', $comentario);
        $consulta->bindParam(':calificacion', $calificacion);
        $consulta->execute();
    }

    public function updateReseña($id_usuario, $id_articulo, $comentario, $calificacion)
    {
        $consulta = $this->conn->prepare("UPDATE Reseña SET Comentario = :comentario, Calificacion = :calificacion
                                          WHERE Id_Usuario = :id_usuario AND Id_Articulo = :id_articulo");
        $consulta->bindParam(':id_usuario', $id_usuario);
        $consulta->bindParam(':id_articulo', $id_articulo);
        $consulta->bindParam(':comentario', $comentario);
        $consulta->bindParam(':calificacion', $calificacion);
        $consulta->execute();
    }

    public function deleteReseña($id_usuario, $id_articulo)
    {
        $consulta = $this->conn->prepare("DELETE FROM Reseña WHERE Id_Usuario = :id_usuario AND Id_Articulo = :id_articulo");
        $consulta->bindParam(':id_usuario', $id_usuario);
        $consulta->bindParam(':id_articulo', $id_articulo);
        $consulta->execute();
    }

    public function getReseñaByIds($id_usuario, $id_articulo)
    {
        $consulta = $this->conn->prepare("SELECT * FROM Reseña WHERE Id_Usuario = :id_usuario AND Id_Articulo = :id_articulo");
        $consulta->bindParam(':id_usuario', $id_usuario);
        $consulta->bindParam(':id_articulo', $id_articulo);
        $consulta->execute();
        return $consulta->fetch(PDO::FETCH_ASSOC);
    }
}
