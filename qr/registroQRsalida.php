<?php
session_start();
include("C:\\xampp\\htdocs\\registroinfoteca\\php\\conexion_be.php");

if (!$conn) {
    die("Error de conexión: " . mysqli_connect_error());
}

// Verificar que haya una sesión activa
if (!isset($_SESSION['sesionActual']) || empty($_SESSION['sesionActual'])) {
    echo "No tienes una sesión activa";
    header('Location: /registroinfoteca/login/login.html');
    exit;
}

// Manejo de errores detallados de MySQL
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

if (!isset($_SESSION['qrID'])) {
    $usuario_id = $_SESSION['usuarioID'];

    // Consulta para verificar si hay una entrada sin salida registrada
    $query = "SELECT id FROM qr_adentro WHERE usuario_id = $usuario_id AND salida IS NULL ORDER BY entrada DESC LIMIT 1";
    $resultado = mysqli_query($conn, $query);

    if ($resultado && mysqli_num_rows($resultado) > 0) {
        // Restaurar la ID de QR en la sesión si hay un registro sin salida
        $fila = mysqli_fetch_assoc($resultado);
        $_SESSION['qrID'] = $fila['id'];
        echo "QR sin salida encontrada y restaurada con ID: " . $_SESSION['qrID'];
    } else {
        echo "No hay registros pendientes de salida para este usuario.";
    }
}

if (isset($_POST['mensajeDecodificado']) && isset($_POST['usuario'])) {
    $usuario_id = $_SESSION['usuarioID'];

    if (filter_var($usuario_id, FILTER_VALIDATE_INT) !== false) {
        if (isset($_SESSION['qrID']) && !empty($_SESSION['qrID'])) {
            $qr_ID = $_SESSION['qrID'];

            // Actualizar la salida en la tabla qr_adentro
            $sql1 = "UPDATE qr_adentro SET salida = CURRENT_TIMESTAMP() WHERE id = '$qr_ID' AND usuario_id = '$usuario_id'";

            // Actualizar el estado del locker
            $sql2 = "UPDATE lockers SET ocupado = 0, usuario_id = NULL, fecha_reserva = NULL WHERE usuario_id = '$usuario_id'";

            // Ejecutar ambas consultas por separado
            if (mysqli_query($conn, $sql1) && mysqli_query($conn, $sql2)) {
                echo "Salida registrada correctamente.";
                unset($_SESSION['qrID']);
            } else {
                echo "Error al registrar la salida: " . mysqli_error($conn);
            }
        } else {
            echo "No se ha restaurado ninguna sesión de QR para este usuario.";
        }
    } else {
        echo "ID de usuario inválido.";
    }
} else {
    echo "No se ha escaneado ningún código QR o no se ha proporcionado el ID de usuario.";
}
?>
