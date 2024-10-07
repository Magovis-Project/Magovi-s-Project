<?php
require_once 'conexionModelo.php';

class EmpresaModel
{
    private $conn;

    public function __construct()
    {
        $this->conn = conexionModelo::getInstance()->getDatabaseInstance();
    }

    public function getEmpresas()
    {
        $consulta = $this->conn->prepare("SELECT * FROM Empresa;");
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createEmpresa($nombre, $direccion, $telefono, $email, $logo, $cedula_juridica)
    {
        $consulta = $this->conn->prepare("INSERT INTO Empresa (Nombre, Direccion, Telefono, Email, Logo, Cedula_Juridica)
                                          VALUES (:nombre, :direccion, :telefono, :email, :logo, :cedula_juridica)");
        $consulta->bindParam(':nombre', $nombre);
        $consulta->bindParam(':direccion', $direccion);
        $consulta->bindParam(':telefono', $telefono);
        $consulta->bindParam(':email', $email);
        $consulta->bindParam(':logo', $logo);
        $consulta->bindParam(':cedula_juridica', $cedula_juridica);
        $consulta->execute();
    }

    public function updateEmpresa($id_empresa, $nombre, $direccion, $telefono, $email, $logo, $cedula_juridica)
    {
        $consulta = $this->conn->prepare("UPDATE Empresa SET Nombre = :nombre, Direccion = :direccion, Telefono = :telefono,
                                          Email = :email, Logo = :logo, Cedula_Juridica = :cedula_juridica
                                          WHERE Id_Empresa = :id_empresa");
        $consulta->bindParam(':id_empresa', $id_empresa);
        $consulta->bindParam(':nombre', $nombre);
        $consulta->bindParam(':direccion', $direccion);
        $consulta->bindParam(':telefono', $telefono);
        $consulta->bindParam(':email', $email);
        $consulta->bindParam(':logo', $logo);
        $consulta->bindParam(':cedula_juridica', $cedula_juridica);
        $consulta->execute();
    }

    public function deleteEmpresa($id_empresa)
    {
        $consulta = $this->conn->prepare("DELETE FROM Empresa WHERE Id_Empresa = :id_empresa");
        $consulta->bindParam(':id_empresa', $id_empresa);
        $consulta->execute();
    }

    public function getEmpresaById($id_empresa)
    {
        $consulta = $this->conn->prepare("SELECT * FROM Empresa WHERE Id_Empresa = :id_empresa");
        $consulta->bindParam(':id_empresa', $id_empresa);
        $consulta->execute();
        return $consulta->fetch(PDO::FETCH_ASSOC);
    }
}
