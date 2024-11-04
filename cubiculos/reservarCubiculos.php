<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservación de Cubículo</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .message-container {
            background-color: #ffffff;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 90%;
            max-width: 400px;
            text-align: center;
        }
        .success {
            color: #28a745;
        }
        .error {
            color: #dc3545;
        }
        .link {
            display: inline-block;
            margin-top: 10px;
            text-decoration: none;
            color: #007bff;
            font-weight: bold;
        }
        .link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="message-container">
        <?php 
        // Conexión a la base de datos
        $conexion = new mysqli("localhost", "root", "", "registroinfoteca");

        if ($conexion->connect_error) {
            die("<p class='error'>Error de conexión: " . $conexion->connect_error . "</p>");
        }

        // Verificar si el formulario fue enviado
        if (isset($_POST['numero_cubiculo']) && isset($_POST['nombre']) && isset($_FILES['credencial']) && isset($_POST['hora_entrada']) && isset($_POST['hora_salida'])) {
            $numero_cubiculo = $_POST['numero_cubiculo'];
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
                $ruta_destino = "credenciales_cubiculos/" . basename($credencial_nombre);

                // Mover el archivo subido a la carpeta de destino
                if (move_uploaded_file($credencial_tmp, $ruta_destino)) {
                    $sql = "UPDATE cubiculos 
                            SET estado = 'Ocupado', fecha_reservacion = CURDATE(), usuario = '$nombre', credencial_imagen = '$ruta_destino', hora_entrada = '$hora_entrada', hora_salida = '$hora_salida' 
                            WHERE numero_cubiculo = $numero_cubiculo";
                            
// Verificación de horario permitido
$hora_inicio_permitida = "08:00";
$hora_fin_permitida = "21:00";

// Comprobar que la hora de entrada y salida están dentro del horario permitido
if ($hora_entrada < $hora_inicio_permitida || $hora_salida > $hora_fin_permitida) {
    echo "<p class='error'>El servicio de reservación solo está disponible de 8:00 AM a 9:00 PM. Por favor, seleccione una hora dentro de este horario.</p>";
    echo "<a href='reservacionCubiculos.php?numero_cubiculo=$numero_cubiculo' class='link'>Volver</a>";
    exit(); // Salir sin guardar la reservación
}

                    if ($conexion->query($sql) === TRUE) {
                        echo "<p class='success'>Cubículo reservado exitosamente a nombre de $nombre.</p>";
                        echo "<a href='cubiculos.php' class='link'>Volver</a>";
                    } else {
                        echo "<p class='error'>Error al reservar: " . $conexion->error . "</p>";
                    }
                } else {
                    echo "<p class='error'>Error al mover el archivo a la carpeta de destino.</p>";
                }
            } else {
                echo "<p class='error'>Error en la subida del archivo: " . $credencial_error . "</p>";
            }
        } else {
            echo "<p class='error'>Faltan datos para la reservación.</p>";
            echo "<a href='cubiculos.php' class='link'>Volver</a>";
        }

        // Cerrar la conexión
        $conexion->close();
        ?>
    </div>
</body>
</html>
