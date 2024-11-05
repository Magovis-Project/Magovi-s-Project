<?php
require_once 'ConexionModel.php';

class VentasModel
{
    private $conn;

    public function __construct()
    {
        $this->conn = conexionModelo::getInstance()->getDatabaseInstance();
    }

    public function createVenta($id_usuario, $total, $detalles)
    {
        try {
            $this->conn->beginTransaction();

            // Insertar la venta
            $consultaVenta = $this->conn->prepare("INSERT INTO Ventas (Id_Usuario, Total) VALUES (:id_usuario, :total)");
            $consultaVenta->bindParam(':id_usuario', $id_usuario);
            $consultaVenta->bindParam(':total', $total);
            $consultaVenta->execute();
            $idVenta = $this->conn->lastInsertId();

            // Insertar detalles de venta
            $consultaDetalle = $this->conn->prepare("INSERT INTO Detalle_Venta (Id_Venta, Id_Articulo, Cantidad, Precio) 
                                                     VALUES (:id_venta, :id_articulo, :cantidad, :precio)");

            foreach ($detalles as $detalle) {
                $consultaDetalle->bindParam(':id_venta', $idVenta);
                $consultaDetalle->bindParam(':id_articulo', $detalle['id_articulo']);
                $consultaDetalle->bindParam(':cantidad', $detalle['cantidad']);
                $consultaDetalle->bindParam(':precio', $detalle['precio']);
                $consultaDetalle->execute();
            }

            $this->conn->commit();
            return $idVenta;

        } catch (PDOException $e) {
            $this->conn->rollBack();
            throw $e;
        }
    }

    public function getAllVentas()
    {
        $consulta = $this->conn->prepare("SELECT v.Id_Venta, v.Fecha, v.Total, u.Nombre AS Cliente 
                                          FROM Ventas v
                                          JOIN Usuarios u ON v.Id_Usuario = u.Id_Usuario");
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getVentaById($id_venta)
    {
        // Obtener la venta
        $consultaVenta = $this->conn->prepare("SELECT v.Id_Venta, v.Fecha, v.Total, u.Nombre AS Cliente
                                               FROM Ventas v
                                               JOIN Usuarios u ON v.Id_Usuario = u.Id_Usuario
                                               WHERE v.Id_Venta = :id_venta");
        $consultaVenta->bindParam(':id_venta', $id_venta);
        $consultaVenta->execute();
        $venta = $consultaVenta->fetch(PDO::FETCH_ASSOC);

        // Obtener los detalles de la venta
        $consultaDetalles = $this->conn->prepare("SELECT d.Id_Articulo, d.Cantidad, d.Precio, a.Nombre AS NombreArticulo 
                                                  FROM Detalle_Venta d
                                                  JOIN Articulos a ON d.Id_Articulo = a.Id_Articulos
                                                  WHERE d.Id_Venta = :id_venta");
        $consultaDetalles->bindParam(':id_venta', $id_venta);
        $consultaDetalles->execute();
        $detalles = $consultaDetalles->fetchAll(PDO::FETCH_ASSOC);

        $venta['detalles'] = $detalles;
        return $venta;
    }

    public function getAllVentasByEmpresa($id_empresa)
{
    $consulta = $this->conn->prepare("
        SELECT v.Id_Venta, v.Fecha, v.Total, u.Nombre AS Cliente, a.Nombre AS NombreArticulo 
        FROM Ventas v
        JOIN Detalle_Venta d ON v.Id_Venta = d.Id_Venta
        JOIN Articulos a ON d.Id_Articulo = a.Id_Articulos
        JOIN Usuarios u ON v.Id_Usuario = u.Id_Usuario
        WHERE a.ID_Empresa = :id_empresa
    ");
    $consulta->bindParam(':id_empresa', $id_empresa);
    $consulta->execute();
    return $consulta->fetchAll(PDO::FETCH_ASSOC);
}



}
