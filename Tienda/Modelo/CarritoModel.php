<?php
class CarritoModel
{
    private $conn;

    public function __construct()
    {
        // Obtener la conexión a la base de datos utilizando la clase de conexión
        $this->conn = conexionModelo::getInstance()->getDatabaseInstance();
    }

    // Obtener todos los carritos
    public function obtenerCarritos()
    {
        $consulta = $this->conn->prepare("SELECT * FROM carrito;");
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_ASSOC);
    }

    // Crear un nuevo carrito
    public function crearCarrito($id_usuario, $estado_carrito)
    {
        $consulta = $this->conn->prepare("INSERT INTO carrito (id_usuario, estado_carrito) VALUES (?, ?);");
        $consulta->bindParam(1, $id_usuario);
        $consulta->bindParam(2, $estado_carrito);
        return $consulta->execute();
    }

    // Buscar un carrito por su ID
    public function buscarCarritoPorId($id_carrito)
    {
        $consulta = $this->conn->prepare("SELECT * FROM carrito WHERE id_carrito = ?;");
        $consulta->bindParam(1, $id_carrito);
        $consulta->execute();
        return $consulta->fetch(PDO::FETCH_ASSOC);
    }

    // Actualizar el estado de un carrito
    public function actualizarCarrito($id_carrito, $estado_carrito)
    {
        $consulta = $this->conn->prepare("UPDATE carrito SET estado_carrito = ? WHERE id_carrito = ?;");
        $consulta->bindParam(1, $estado_carrito);
        $consulta->bindParam(2, $id_carrito);
        return $consulta->execute();
    }

    // Eliminar un carrito por su ID
    public function eliminarCarrito($id_carrito)
    {
        $consulta = $this->conn->prepare("DELETE FROM carrito WHERE id_carrito = ?;");
        $consulta->bindParam(1, $id_carrito);
        return $consulta->execute();
    }
}
?>
