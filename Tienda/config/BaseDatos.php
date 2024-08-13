<?php
$servername = "localhost"; // Puede ser "127.0.0.1" o la IP del servidor MySQL
$username = "root";
$password = "root";
$dbname = "MyDrops_BD";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
echo "Conexión exitosa";
?>