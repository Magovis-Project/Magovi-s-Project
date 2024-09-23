<?php
require_once("ConexionModel.php");
$conn = ConexionModelo::getInstance()->getDatabaseInstance();
try {
    $consulta = $conn->prepare("SELECT * FROM usuario;");
    $consulta->execute();
    $resultados = $consulta->fetchAll();
    var_dump($resultados);
} catch (PDOException $e) {
    $error = $e->getMessage();
    echo $error;
}
?>