<?php

class EmpresaModel
{
    private $conn;

    public function __construct()
    {
        $this->conn = conexionModelo::getInstance()->getDatabaseInstance();
    }

    public function getEmpresaById($id_empresa)
    {
        $consulta = $this->conn->prepare("SELECT * FROM empresa WHERE id_empresa = :id_empresa");
        $consulta->bindParam(":id_empresa", $id_empresa);
        $consulta->execute();
        return $consulta->fetch(PDO::FETCH_ASSOC);
    }

    public function getEmpresas()
    {
        $consulta = $this->conn->prepare("SELECT * FROM empresa;");
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createEmpresa($nombre, $direccion, $email, $hashedPassword, $RUT)
    {
        $consulta = $this->conn->prepare("INSERT INTO empresa (nombre_empresa, direccion_empresa, email_empresa, password_empresa, RUT) 
                                          VALUES (:nombre, :direccion, :email, :password, :RUT)");
        $consulta->bindParam(":nombre", $nombre);
        $consulta->bindParam(":direccion", $direccion);
        $consulta->bindParam(":email", $email);
        $consulta->bindParam(":password", $hashedPassword);
        $consulta->bindParam(":RUT", $RUT);
        $consulta->execute();
    }

    public function updateEmpresa($id_empresa, $nombre, $direccion, $email, $hashedPassword, $RUT)
    {
        $consulta = $this->conn->prepare("UPDATE empresa SET nombre_empresa = :nombre, direccion_empresa = :direccion, 
                                          email_empresa = :email, password_empresa = IFNULL(:password, password_empresa), 
                                          RUT = :RUT WHERE id_empresa = :id_empresa");
        $consulta->bindParam(":id_empresa", $id_empresa);
        $consulta->bindParam(":nombre", $nombre);
        $consulta->bindParam(":direccion", $direccion);
        $consulta->bindParam(":email", $email);
        $consulta->bindParam(":password", $hashedPassword);
        $consulta->bindParam(":RUT", $RUT);
        $consulta->execute();
    }

    public function deleteEmpresa($id_empresa)
    {
        $consulta = $this->conn->prepare("DELETE FROM empresa WHERE id_empresa = :id_empresa");
        $consulta->bindParam(":id_empresa", $id_empresa);
        $consulta->execute();
    }
}
