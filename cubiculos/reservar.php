<?php
// Conexión a la base de datos
$conexion = new mysqli("localhost", "root", "", "login_register");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Verificar si el formulario fue enviado
if (isset($_POST['numero_casillero']) && isset($_POST['nombre']) && isset($_FILES['credencial']) && isset($_POST['hora_entrada']) && isset($_POST['hora_salida'])) {
    $numero_casillero = $_POST['numero_casillero'];
    $nombre = $_POST['nombre'];
    $hora_entrada = $_POST['hora_entrada'];
    $hora_salida = $_POST['hora_salida'];

    // Manejo de la imagen de la credencial
    $credencial = $_FILES['credencial'];
    $credencial_nombre = $credencial['name'];
    $credencial_tmp = $credencial['tmp_name'];
    $credencial_error = $credencial['error'];

    // Verificar si hubo un error en la subida del archivo
    if ($credencial_error === UPLOAD_ERR_OK) {
        // Definir la ruta donde se guardará la imagen
        $ruta_destino = "uploads/" . basename($credencial_nombre);

        // Mover el archivo subido a la carpeta de destino
        if (move_uploaded_file($credencial_tmp, $ruta_destino)) {
            // Actualizar el estado del casillero a "ocupado" y registrar los detalles de la reservación
            $sql = "UPDATE casilleros 
                    SET estado = 'Ocupado', fecha_reservacion = CURDATE(), usuario = '$nombre', credencial_imagen = '$ruta_destino', hora_entrada = '$hora_entrada', hora_salida = '$hora_salida' 
                    WHERE numero_casillero = $numero_casillero";
            
            if ($conexion->query($sql) === TRUE) {
                echo "Cubiculo reservado exitosamente a nombre de $nombre. <a href='index.php'>Volver</a>";
            } else {
                echo "Error al reservar: " . $conexion->error;
            }
        } else {
            echo "Error al mover el archivo a la carpeta de destino.";
        }
    } else {
        echo "Error en la subida del archivo: " . $credencial_error;
    }
} else {
    echo "Faltan datos para la reservación. <a href='index.php'>Volver</a>";
}

// Cerrar la conexión
$conexion->close();
?>
