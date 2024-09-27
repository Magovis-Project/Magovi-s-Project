<?php

require_once 'modelos/EmpresaModel.php';

class EmpresaControlador
{
    private $empresaModel;

    public function __construct()
    {
        $this->empresaModel = new EmpresaModel();
    }

    public function getEmpresaById($id_empresa)
    {
        $empresa = $this->empresaModel->getEmpresaById($id_empresa);
        if ($empresa) {
            header("Content-Type: application/json");
            echo json_encode($empresa);
        } else {
            echo json_encode(["error" => true, "mensaje" => "Empresa no encontrada"]);
        }
    }

    public function getEmpresasJSON()
    {
        $empresas = $this->empresaModel->getEmpresas();
        header("Content-Type: application/json");
        echo json_encode($empresas);
    }

    public function createEmpresa($nombre, $direccion, $email, $password, $RUT)
    {
        // Hash de la contraseña
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $this->empresaModel->createEmpresa($nombre, $direccion, $email, $hashedPassword, $RUT);
        echo json_encode(["mensaje" => "Empresa creada con éxito"]);
    }

    public function updateEmpresa($id_empresa, $nombre, $direccion, $email, $password, $RUT)
    {
        $hashedPassword = !empty($password) ? password_hash($password, PASSWORD_BCRYPT) : null;
        $this->empresaModel->updateEmpresa($id_empresa, $nombre, $direccion, $email, $hashedPassword, $RUT);
        echo json_encode(["mensaje" => "Empresa actualizada con éxito"]);
    }

    public function deleteEmpresa($id_empresa)
    {
        $this->empresaModel->deleteEmpresa($id_empresa);
        echo json_encode(["mensaje" => "Empresa eliminada con éxito"]);
    }
}
