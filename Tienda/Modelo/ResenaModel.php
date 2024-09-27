<?php
class ResenaModel
{
    private $conn;

    public function __construct()
    {
        $this->conn = conexionModelo::getInstance()->getDatabaseInstance();
    }

    // Obtener todas las reseñas
    public function obtenerResenas()
    {
        $consulta = $this->conn->prepare("SELECT * FROM reseña;");
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_ASSOC);
    }

    // Crear una nueva reseña
    public function crearResena($id_usuario, $id_articulo, $calificacion, $comentario)
    {
        $consulta = $this->conn->prepare("INSERT INTO reseña (id_usuario, id_articulo, calificacion, comentario) VALUES (?, ?, ?, ?);");
        $consulta->bindParam(1, $id_usuario);
        $consulta->bindParam(2, $id_articulo);
        $consulta->bindParam(3, $calificacion);
        $consulta->bindParam(4, $comentario);
        return $consulta->execute();
    }

    // Buscar una reseña específica
    public function buscarResena($id_usuario, $id_articulo)
    {
        $consulta = $this->conn->prepare("SELECT * FROM reseña WHERE id_usuario = ? AND id_articulo = ?;");
        $consulta->bindParam(1, $id_usuario);
        $consulta->bindParam(2, $id_articulo);
        $consulta->execute();
        return $consulta->fetch(PDO::FETCH_ASSOC);
    }

    // Actualizar una reseña
    public function actualizarResena($id_usuario, $id_articulo, $calificacion, $comentario)
    {
        $consulta = $this->conn->prepare("UPDATE reseña SET calificacion = ?, comentario = ? WHERE id_usuario = ? AND id_articulo = ?;");
        $consulta->bindParam(1, $calificacion);
        $consulta->bindParam(2, $comentario);
        $consulta->bindParam(3, $id_usuario);
        $consulta->bindParam(4, $id_articulo);
        return $consulta->execute();
    }

    // Eliminar una reseña
    public function eliminarResena($id_usuario, $id_articulo)
    {
        $consulta = $this->conn->prepare("DELETE FROM reseña WHERE id_usuario = ? AND id_articulo = ?;");
        $consulta->bindParam(1, $id_usuario);
        $consulta->bindParam(2, $id_articulo);
        return $consulta->execute();
    }
}
?>
