<?php
session_start();
include("C:\\xampp\\htdocs\\registroinfoteca\\php\\conexion_be.php");

if (!$conn) {
    die("Error de conexión: " . mysqli_connect_error());
}

if (!isset($_SESSION['sesionActual']) || empty($_SESSION['sesionActual'])) {
    echo "No tienes una sesión activa";
    header('Location:/registroinfoteca/login/login.html');
    exit();
}

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
        if (!isset($_SESSION['qrID'])) {
            // Insertar nueva entrada si no hay QR pendiente de salida
            $sql = "INSERT INTO qr_adentro (usuario_id, entrada) VALUES ('$usuario_id', CURRENT_TIMESTAMP())";
            if (mysqli_query($conn, $sql)) {
                $_SESSION['qrID'] = $conn->insert_id;
                echo "Código QR guardado correctamente con ID: " . $_SESSION['qrID'];
            } else {
                echo "Error al guardar el código QR: " . mysqli_error($conn);
            }
        } else {
            echo "Ya tienes un código QR pendiente de salida.";
        }
    } else {
        echo "ID de usuario inválido.";
    }
} else {
    echo "No se ha escaneado ningún código QR o no se ha proporcionado el ID de usuario.";
}
?>
