<?php
// conexion.php
$host = "localhost";
$dbname = "registroinfoteca"; 
$username = "root";
$password = "";

// Crear conexión
$conn = new mysqli($host, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
} else {
    //echo "Conexión exitosa a la base de datos";
}
?>
