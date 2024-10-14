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

    public function createEmpresa($nombre, $direccion, $telefono, $email, $logo, $RUT)
    {
        // Validación de datos
        $validacion = $this->validarDatos($nombre, $direccion, $telefono, $email, $RUT);
        
        if ($validacion['error']) {
            echo json_encode($validacion);
            return;
        }

        try {
            $this->empresaModel->createEmpresa($nombre, $direccion, $telefono, $email, $logo, $RUT);
            echo json_encode(['success' => true, 'message' => 'Empresa creada exitosamente']);
        } catch (PDOException $e) {
            echo json_encode(['error' => true, 'message' => $e->getMessage()]);
        }
    }

    public function updateEmpresa($id_empresa, $nombre, $direccion, $telefono, $email, $logo, $RUT)
    {
        // Validación de datos
        $validacion = $this->validarDatos($nombre, $direccion, $telefono, $email, $RUT);
        
        if ($validacion['error']) {
            echo json_encode($validacion);
            return;
        }

        try {
            $this->empresaModel->updateEmpresa($id_empresa, $nombre, $direccion, $telefono, $email, $logo, $RUT);
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

    private function validarDatos($nombre, $direccion, $telefono, $email, $RUT)
    {
        $errores = [];

        // Validación de campos vacíos
        if (empty($nombre)) {
            $errores[] = 'El nombre no puede estar vacío.';
        }
        if (empty($direccion)) {
            $errores[] = 'La dirección no puede estar vacía.';
        }
        if (empty($telefono)) {
            $errores[] = 'El teléfono no puede estar vacío.';
        }
        if (empty($email)) {
            $errores[] = 'El correo electrónico no puede estar vacío.';
        }
        if (empty($RUT)) {
            $errores[] = 'El RUT no puede estar vacío.';
        }

        // Validación de longitud de teléfono (suponiendo que debería tener 9 dígitos)
        if (strlen($telefono) !== 9) {
            $errores[] = 'El teléfono debe tener 9 dígitos.';
        }

        // Validación de correo electrónico
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errores[] = 'El correo electrónico no es válido.';
        }

        // Validación del RUT
        if (!$this->empresaModel->validarRUT($RUT)) {
            $errores[] = 'El RUT no es válido.';
        }

        // Retornar errores si los hay
        if (!empty($errores)) {
            return ['error' => true, 'mensajes' => $errores];
        }

        return ['error' => false];
    }
}
