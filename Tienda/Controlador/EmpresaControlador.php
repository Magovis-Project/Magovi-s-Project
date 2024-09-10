<?php
class EmpresaController
{
    private $conn;

    public function __construct()
    {
        $this->conn = ConexionModel::getInstance()->getDatabaseInstance();
    }

    // Buscar una empresa por su ID
    public function getEmpresaById($id_empresa)
    {
        try {
            $consulta = $this->conn->prepare("SELECT * FROM empresa WHERE id_empresa = :id_empresa");
            $consulta->bindParam( ":id_empresa ", $id_empresa);
            $consulta->execute();
            $empresa = $consulta->fetch(PDO::FETCH_ASSOC);

            if ($empresa) {
                header( "Content-Type: application/json ");
                echo json_encode($empresa);
            } else {
                echo json_encode([ "error " => true,  "mensaje " =>  "Empresa no encontrada "]);
            }
        } catch (PDOException $e) {
            $error = [
                 "error " => true,
                 "mensaje " => $e->getMessage()
            ];
            echo json_encode($error);
        }
    }

    // Obtener todas las empresas en formato JSON
    public function getEmpresasJSON()
    {
        try {
            $consulta = $this->conn->prepare("SELECT * FROM empresa;");
            $consulta->execute();
            $empresas = $consulta->fetchAll(PDO::FETCH_ASSOC);

            header( "Content-Type: application/json ");
            echo json_encode($empresas);
        } catch (PDOException $e) {
            $error = [
                 "error " => true,
                 "mensaje " => $e->getMessage()
            ];
            echo json_encode($error);
        }
    }

    // Crear una nueva empresa
    public function createEmpresa($nombre, $direccion, $email, $password, $RUT)
    {
        try {
            // Hash de la contraseña
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

            $consulta = $this->conn->prepare("INSERT INTO empresa (nombre_empresa, direccion_empresa, email_empresa, password_empresa, RUT) VALUES (:nombre, :direccion, :email, :password, :RUT)");
            $consulta->bindParam( ":nombre ", $nombre);
            $consulta->bindParam( ":direccion ", $direccion);
            $consulta->bindParam( ":email ", $email);
            $consulta->bindParam( ":password ", $hashedPassword);
            $consulta->bindParam( ":RUT ", $RUT);
            $consulta->execute();

            echo json_encode([ "mensaje " =>  "Empresa creada con éxito "]);
        } catch (PDOException $e) {
            echo json_encode([ "error " => true,  "mensaje " => $e->getMessage()]);
        }
    }

    // Actualizar una empresa existente
    public function updateEmpresa($id_empresa, $nombre, $direccion, $email, $password, $RUT)
    {
        try {
            // Si la contraseña no es null, hashearla
            $hashedPassword = !empty($password) ? password_hash($password, PASSWORD_BCRYPT) : null;

            $consulta = $this->conn->prepare("UPDATE empresa SET nombre_empresa = :nombre, direccion_empresa = :direccion, email_empresa = :email, password_empresa = IFNULL(:password, password_empresa), RUT = :RUT WHERE id_empresa = :id_empresa");
            $consulta->bindParam( ":id_empresa ", $id_empresa);
            $consulta->bindParam( ":nombre ", $nombre);
            $consulta->bindParam( ":direccion ", $direccion);
            $consulta->bindParam( ":email ", $email);
            $consulta->bindParam( ":password ", $hashedPassword);
            $consulta->bindParam( ":RUT ", $RUT);
            $consulta->execute();

            echo json_encode([ "mensaje " =>  "Empresa actualizada con éxito "]);
        } catch (PDOException $e) {
            echo json_encode([ "error " => true,  "mensaje " => $e->getMessage()]);
        }
    }

    // Eliminar una empresa
    public function deleteEmpresa($id_empresa)
    {
        try {
            $consulta = $this->conn->prepare("DELETE FROM empresa WHERE id_empresa = :id_empresa");
            $consulta->bindParam( ":id_empresa ", $id_empresa);
            $consulta->execute();

            echo json_encode([ "mensaje " =>  "Empresa eliminada con éxito "]);
        } catch (PDOException $e) {
            echo json_encode([ "error " => true,  "mensaje " => $e->getMessage()]);
        }
    }
}

// Verifica si se ha solicitado la acción
if (isset($_GET["action"])) {
    $controller = new ArticuloController();

    switch ($_GET["action"]) {
        case "getArticulosJSON":
            $controller->getArticulosJSON();
            break;

        case "getArticuloByID":
            if (isset($_GET["id_articulo"])) {
                $controller->buscarArticuloPorId($_GET["id_articulo"]);
            } else {
                echo json_encode(["error" => true, "mensaje" => "ID de artículo no proporcionado"]);
            }
            break;

        case "createArticulo":
            if (isset($_POST["nombre"], $_POST["precio"], $_POST["cantidad"], $_POST["tipo"], $_POST["id_empresa"])) {
                $controller->createArticulo($_POST["nombre"], $_POST["precio"], $_POST["cantidad"], $_POST["tipo"], $_POST["id_empresa"]);
            } else {
                echo json_encode(["error" => true, "mensaje" => "Faltan datos para crear el artículo"]);
            }
            break;

        case "updateArticulo":
            if (isset($_POST["id_articulo"], $_POST["nombre"], $_POST["precio"], $_POST["cantidad"], $_POST["tipo"])) {
                $controller->updateArticulo($_POST["id_articulo"], $_POST["nombre"], $_POST["precio"], $_POST["cantidad"], $_POST["tipo"]);
            } else {
                echo json_encode(["error" => true, "mensaje" => "Faltan datos para actualizar el artículo"]);
            }
            break;

        case "deleteArticulo":
            if (isset($_POST["id_articulo"])) {
                $controller->deleteArticulo($_POST["id_articulo"]);
            } else {
                echo json_encode(["error" => true, "mensaje" => "ID de artículo no proporcionado"]);
            }
            break;

        default:
            echo json_encode(["error" => true, "mensaje" => "Acción no válida"]);
            break;
    }
}
?>