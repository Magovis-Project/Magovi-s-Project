<?php
class ConformaModel
{
    private $conn;

    public function __construct()
    {
        $this->conn = conexionModelo::getInstance()->getDatabaseInstance();
    }

    // Obtener todos los registros de "conforma"
    public function obtenerConforma()
    {
        $consulta = $this->conn->prepare("SELECT * FROM conforma;");
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_ASSOC);
    }

    // Crear un nuevo registro en "conforma"
    public function crearConforma($id_usuario, $id_articulo, $id_carrito)
    {
        $consulta = $this->conn->prepare("INSERT INTO conforma (id_usuario, id_articulo, id_carrito) VALUES (?, ?, ?);");
        $consulta->bindParam(1, $id_usuario);
        $consulta->bindParam(2, $id_articulo);
        $consulta->bindParam(3, $id_carrito);
        return $consulta->execute();
    }

    // Buscar un registro específico en "conforma"
    public function buscarConforma($id_usuario, $id_articulo, $id_carrito)
    {
        $consulta = $this->conn->prepare("SELECT * FROM conforma WHERE id_usuario = ? AND id_articulo = ? AND id_carrito = ?;");
        $consulta->bindParam(1, $id_usuario);
        $consulta->bindParam(2, $id_articulo);
        $consulta->bindParam(3, $id_carrito);
        $consulta->execute();
        return $consulta->fetch(PDO::FETCH_ASSOC);
    }

    // Actualizar un registro en "conforma"
    public function actualizarConforma($id_usuario, $id_articulo, $id_carrito)
    {
        $consulta = $this->conn->prepare("UPDATE conforma SET id_usuario = ?, id_articulo = ?, id_carrito = ? WHERE id_usuario = ? AND id_articulo = ? AND id_carrito = ?;");
        $consulta->bindParam(1, $id_usuario);
        $consulta->bindParam(2, $id_articulo);
        $consulta->bindParam(3, $id_carrito);
        return $consulta->execute();
    }

    // Eliminar un registro de "conforma"
    public function eliminarConforma($id_usuario, $id_articulo, $id_carrito)
    {
        $consulta = $this->conn->prepare("DELETE FROM conforma WHERE id_usuario = ? AND id_articulo = ? AND id_carrito = ?;");
        $consulta->bindParam(1, $id_usuario);
        $consulta->bindParam(2, $id_articulo);
        $consulta->bindParam(3, $id_carrito);
        return $consulta->execute();
    }
}
?>
