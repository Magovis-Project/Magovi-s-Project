<?php
class RepartidorModel
{
    private $conn;

    public function __construct()
    {
        $this->conn = conexionModelo::getInstance()->getDatabaseInstance();
    }

    // Obtener todos los repartidores
    public function obtenerRepartidores()
    {
        $consulta = $this->conn->prepare("SELECT * FROM repartidor;");
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_ASSOC);
    }

    // Crear un nuevo repartidor
    public function crearRepartidor($id_carrito, $empresa_matriz)
    {
        $consulta = $this->conn->prepare("INSERT INTO repartidor (id_carrito, empresa_matriz) VALUES (?, ?);");
        $consulta->bindParam(1, $id_carrito);
        $consulta->bindParam(2, $empresa_matriz);
        return $consulta->execute();
    }

    // Buscar repartidor por ID
    public function buscarRepartidorPorId($id_repartidor)
    {
        $consulta = $this->conn->prepare("SELECT * FROM repartidor WHERE id_repartidor = ?;");
        $consulta->bindParam(1, $id_repartidor);
        $consulta->execute();
        return $consulta->fetch(PDO::FETCH_ASSOC);
    }

    // Actualizar repartidor
    public function actualizarRepartidor($id_repartidor, $id_carrito, $empresa_matriz)
    {
        $consulta = $this->conn->prepare("UPDATE repartidor SET id_carrito = ?, empresa_matriz = ? WHERE id_repartidor = ?;");
        $consulta->bindParam(1, $id_carrito);
        $consulta->bindParam(2, $empresa_matriz);
        $consulta->bindParam(3, $id_repartidor);
        return $consulta->execute();
    }

    // Eliminar repartidor
    public function eliminarRepartidor($id_repartidor)
    {
        $consulta = $this->conn->prepare("DELETE FROM repartidor WHERE id_repartidor = ?;");
        $consulta->bindParam(1, $id_repartidor);
        return $consulta->execute();
    }
}
?>
