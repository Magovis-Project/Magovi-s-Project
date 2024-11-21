<?php
require_once 'ConexionModel.php';

class ReseñaModel
{
    private $conn;

    public function __construct()
    {
        $this->conn = conexionModelo::getInstance()->getDatabaseInstance();
    }

    // Obtener todas las reseñas
    public function getReseñas()
    {
        $consulta = $this->conn->prepare("SELECT * FROM Reseña;");
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getReseñasByArticulo($id_articulo)
{
    $consulta = $this->conn->prepare("
        SELECT Reseña.*, Usuarios.Nombre, Usuarios.Apellido 
        FROM Reseña 
        JOIN Usuarios ON Reseña.Id_Usuario = Usuarios.Id_Usuario
        WHERE Reseña.Id_Articulos = :id_articulo;
    ");
    $consulta->bindParam(':id_articulo', $id_articulo, PDO::PARAM_INT);
    $consulta->execute();
    return $consulta->fetchAll(PDO::FETCH_ASSOC);
}


    // Crear una nueva reseña
    public function createReseña($id_usuario, $id_articulo, $comentario, $calificacion)
    {
        $consulta = $this->conn->prepare("INSERT INTO Reseña (Id_Usuario, Id_Articulos, Comentario, Rating)
                                          VALUES (:id_usuario, :id_articulo, :comentario, :calificacion)");
        $consulta->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
        $consulta->bindParam(':id_articulo', $id_articulo, PDO::PARAM_INT);
        $consulta->bindParam(':comentario', $comentario, PDO::PARAM_STR);
        $consulta->bindParam(':calificacion', $calificacion, PDO::PARAM_STR);
        $consulta->execute();
    }

    // Actualizar una reseña existente
    public function updateReseña($id_usuario, $id_articulo, $comentario, $calificacion)
    {
        $consulta = $this->conn->prepare("UPDATE Reseña SET Comentario = :comentario, Rating = :calificacion
                                          WHERE Id_Usuario = :id_usuario AND Id_Articulos = :id_articulo");
        $consulta->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
        $consulta->bindParam(':id_articulo', $id_articulo, PDO::PARAM_INT);
        $consulta->bindParam(':comentario', $comentario, PDO::PARAM_STR);
        $consulta->bindParam(':calificacion', $calificacion, PDO::PARAM_STR);
        $consulta->execute();
    }

    // Eliminar una reseña
    public function deleteReseña($id_usuario, $id_articulo)
    {
        $consulta = $this->conn->prepare("DELETE FROM Reseña WHERE Id_Usuario = :id_usuario AND Id_Articulos = :id_articulo");
        $consulta->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
        $consulta->bindParam(':id_articulo', $id_articulo, PDO::PARAM_INT);
        $consulta->execute();
    }

    // Obtener una reseña específica por usuario y artículo
    public function getReseñaByIds($id_usuario, $id_articulo)
    {
        $consulta = $this->conn->prepare("SELECT * FROM Reseña WHERE Id_Usuario = :id_usuario AND Id_Articulos = :id_articulo");
        $consulta->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
        $consulta->bindParam(':id_articulo', $id_articulo, PDO::PARAM_INT);
        $consulta->execute();
        return $consulta->fetch(PDO::FETCH_ASSOC);
    }
}
