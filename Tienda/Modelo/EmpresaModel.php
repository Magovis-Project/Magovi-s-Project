<?php 
require_once 'ConexionModel.php';

class EmpresaModel
{
    private $conn;

    public function __construct()
    {
        $this->conn = conexionModelo::getInstance()->getDatabaseInstance();
    }

    public function createEmpresa($nombre, $direccion, $telefono, $email, $foto_url, $rut, $password)
    {
        // Hashear la contraseña antes de guardarla
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        
        $consulta = $this->conn->prepare(
            "INSERT INTO Empresa (Nombre, Direccion, Telefono, Email, foto_url, rut, password) 
             VALUES (:nombre, :direccion, :telefono, :email, :foto_url, :rut, :password)"
        );
        $consulta->bindParam(':nombre', $nombre);
        $consulta->bindParam(':direccion', $direccion);
        $consulta->bindParam(':telefono', $telefono);
        $consulta->bindParam(':email', $email);
        $consulta->bindParam(':foto_url', $foto_url);
        $consulta->bindParam(':rut', $rut);
        $consulta->bindParam(':password', $hashedPassword); // Usar la contraseña hasheada
        $consulta->execute();
    }

    public function loginEmpresa($email, $password)
    {
        $consulta = $this->conn->prepare("SELECT * FROM Empresa WHERE Email = :email LIMIT 1");
        $consulta->bindParam(':email', $email);
        $consulta->execute();

        $empresa = $consulta->fetch(PDO::FETCH_ASSOC);

        if ($empresa && password_verify($password, $empresa['Password'])) {
            return $empresa;
        } else {
            return false;
        }
    }
    public function getEmpresaByEmail($email)
    {
        $consulta = $this->conn->prepare("SELECT * FROM Empresa WHERE Email = :email LIMIT 1");
        $consulta->bindParam(':email', $email);
        $consulta->execute();
        
        return $consulta->fetch(PDO::FETCH_ASSOC); // Retorna los datos de la empresa
    }

    public function getAllEmpresas()
    {
        $consulta = $this->conn->prepare("SELECT ID_Empresa, Nombre, Direccion, RUT, Email, Telefono, Valoracion FROM Empresa");
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateEmpresa($id_empresa, $nombre, $direccion, $telefono, $email, $foto_url, $rut, $password)
    {
        // Hashear la contraseña antes de actualizar
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $consulta = $this->conn->prepare(
            "UPDATE Empresa 
             SET Nombre = :nombre, Direccion = :direccion, Telefono = :telefono, 
                 Email = :email, foto_url = :foto_url, rut = :rut, password = :password
             WHERE Id_Empresa = :id_empresa"
        );
        $consulta->bindParam(':id_empresa', $id_empresa);
        $consulta->bindParam(':nombre', $nombre);
        $consulta->bindParam(':direccion', $direccion);
        $consulta->bindParam(':telefono', $telefono);
        $consulta->bindParam(':email', $email);
        $consulta->bindParam(':foto_url', $foto_url);
        $consulta->bindParam(':rut', $rut);
        $consulta->bindParam(':password', $hashedPassword); // Usar la contraseña hasheada
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
    $consulta = $this->conn->prepare(
        "SELECT * FROM Empresa WHERE Id_Empresa = :id_empresa");
    $consulta->bindParam(':id_empresa', $id_empresa);
    $consulta->execute();
    return $consulta->fetch(PDO::FETCH_ASSOC);
}



    // Método para validar el RUT
    public function validarRUT($rut)
    {
        $rut = str_replace(['.', '-'], '', $rut); // Eliminar puntos y guiones
        if (strlen($rut) == 12) {
            return true;
        } else {
            return false;
        }
    }
}
