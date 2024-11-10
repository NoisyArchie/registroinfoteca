<?php
session_start();
include("C:\\xampp\\htdocs\\registroinfoteca\\php\\conexion_be.php");

if (!isset($_SESSION['sesionActual']) && empty($_SESSION['sesionActual'])) {
    header('Location: /registroinfoteca/login/login.html');
    exit();
}

if (!isset($_SESSION['qrID'])) {
    $usuario_id = $_SESSION['usuarioID'];
    $query = "SELECT id FROM qr_adentro WHERE usuario_id = $usuario_id AND salida IS NULL ORDER BY entrada DESC LIMIT 1";
    $resultado = mysqli_query($conn, $query);

    if ($resultado && mysqli_num_rows($resultado) > 0) {
        $fila = mysqli_fetch_assoc($resultado);
        $_SESSION['qrID'] = $fila['id'];
        echo "QR sin salida encontrada y restaurada con ID: " . $_SESSION['qrID'];
    } else {
        echo "No hay registros pendientes de salida para este usuario.";
        header('Location: /registroinfoteca/qr/escannerQR.php');
    }
}

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $needLocker = $_POST['needLocker'] ?? 'no';

    if ($needLocker === 'si') {
        $usuario_id = $_SESSION['usuarioID'];
        
        // Verificar si el usuario ya tiene un locker asignado
        $check_sql = "SELECT numero_locker FROM lockers WHERE usuario_id = $usuario_id";
        $check_result = $conn->query($check_sql);

        if ($check_result->num_rows > 0) {
            // El usuario ya tiene un locker asignado
            $row = $check_result->fetch_assoc();
            $numero_locker = $row['numero_locker'];
            $message = "Tu locker es el número: $numero_locker";
        } else {
            // Asignar un nuevo locker al usuario si no tiene uno
            $sql = "SELECT numero_locker FROM lockers WHERE ocupado = 0 ORDER BY numero_locker ASC LIMIT 1";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $numero_locker = $row['numero_locker'];

                $update_sql = "UPDATE lockers SET ocupado = 1, usuario_id = $usuario_id, fecha_reserva = CURRENT_TIMESTAMP() WHERE numero_locker = $numero_locker";
                
                if ($conn->query($update_sql) === TRUE) {
                    $message = "Tu locker es el número $numero_locker";
                } else {
                    $message = "Error al actualizar el estado del locker.";
                }
            } else {
                $message = "No hay lockers disponibles.";
            }
        }
    } else {
        $message = "No se necesita un locker.";
        header('Location: /registroinfoteca/pagina_principal.php');
        exit();
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Reservación de Lockers</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Paytone+One&family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css" />
    <link rel="stylesheet" href="/registroinfoteca/assets/css/styles_Lockers.css" />
    <script>
        function hideButtons() {
            document.getElementById('buttonSi').style.display = 'none';
            document.getElementById('buttonNo').style.display = 'none';
        }

        function redirectToHome() {
            setTimeout(function() {
                alert("Se le redirigirá a la página principal.");
                window.location.href = "/registroinfoteca/pagina_principal.php";
            }, 2000); // Espera de 2 segundos antes de redirigir
        }
    </script>
</head>
<body>
    <div class="form-container">
        <form method="post" onsubmit="hideButtons()">
            <label>¿Vas a requerir de un locker?</label><br />
            <box-icon type="solid" name="key"></box-icon>
            <button type="submit" name="needLocker" value="si" id="buttonSi">Sí</button>
            <button type="submit" name="needLocker" value="no" id="buttonNo">No</button>
        </form>

        <?php if ($message): ?>
            <div id="result"><?= $message ?></div>
            <script>
                <?php if ($needLocker === 'si'): ?>
                    redirectToHome();
                <?php endif; ?>
            </script>
        <?php endif; ?>
    </div>
</body>
</html>
