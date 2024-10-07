<?php
require_once 'EmpresaModel.php';

class EmpresaControlador
{
    private $empresaModel;

    public function __construct()
    {
        $this->empresaModel = new EmpresaModel();
    }

    public function getEmpresasJSON()
    {
        try {
            $empresas = $this->empresaModel->getEmpresas();
            header('Content-Type: application/json');
            echo json_encode($empresas);
        } catch (PDOException $e) {
            echo json_encode(['error' => true, 'mensaje' => $e->getMessage()]);
        }
    }

    public function createEmpresa($nombre, $direccion, $telefono, $email, $logo, $cedula_juridica)
    {
        try {
            $this->empresaModel->createEmpresa($nombre, $direccion, $telefono, $email, $logo, $cedula_juridica);
            echo json_encode(['success' => true, 'message' => 'Empresa creada exitosamente']);
        } catch (PDOException $e) {
            echo json_encode(['error' => true, 'message' => $e->getMessage()]);
        }
    }

    public function updateEmpresa($id_empresa, $nombre, $direccion, $telefono, $email, $logo, $cedula_juridica)
    {
        try {
            $this->empresaModel->updateEmpresa($id_empresa, $nombre, $direccion, $telefono, $email, $logo, $cedula_juridica);
            echo json_encode(['success' => true, 'message' => 'Empresa actualizada correctamente']);
        } catch (PDOException $e) {
            echo json_encode(['error' => true, 'message' => $e->getMessage()]);
        }
    }

    public function deleteEmpresa($id_empresa)
    {
        try {
            $this->empresaModel->deleteEmpresa($id_empresa);
            echo json_encode(['success' => true, 'message' => 'Empresa eliminada correctamente']);
        } catch (PDOException $e) {
            echo json_encode(['error' => true, 'message' => $e->getMessage()]);
        }
    }

    public function getEmpresaById($id_empresa)
    {
        try {
            $empresa = $this->empresaModel->getEmpresaById($id_empresa);
            echo json_encode($empresa);
        } catch (PDOException $e) {
            echo json_encode(['error' => true, 'message' => $e->getMessage()]);
        }
    }
}
