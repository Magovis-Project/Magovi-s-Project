<?php
class UsuarioController
{
    private $conn;

    public function __construct()
    {
        $this->conn = ConexionModel::getInstance()->getDatabaseInstance();
    }

    public function getUsuariosJSON()
    {
        try {
            $consulta = $this->conn->prepare("SELECT * FROM usuario;");
            $consulta->execute();
            $usuarios = $consulta->fetchAll(PDO::FETCH_ASSOC);

            // Devolver los datos como JSON
            header('Content-Type: application/json');
            echo json_encode($usuarios);
        } catch (PDOException $e) {
            $error = [
                'error' => true,
                'mensaje' => $e->getMessage()
            ];
            echo json_encode($error);
        }
    }
}

// Verifica si se ha solicitado la acción
if (isset($_GET['action']) && $_GET['action'] == 'getUsuariosJSON') {
    $controller = new UsuarioController();
    $controller->getUsuariosJSON();
}

