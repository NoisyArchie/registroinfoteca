<?php
session_start();
$conexion = new mysqli("localhost", "root", "", "registroinfoteca");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

if (!isset($_SESSION['sesionActual']) && empty($_SESSION['sesionActual'])) {
    header('Location: /registroinfoteca/login/login.html');
    exit();
}

// Actualizar el estado de los cubiculos
$sql_update = "UPDATE cubiculos 
               SET estado = 'Disponible', usuario = NULL,credencial_imagen = NULL, hora_entrada = NULL, hora_salida = NULL, fecha_reservacion = NULL 
               WHERE estado = 'Ocupado' AND hora_salida < CURTIME()";

$conexion->query($sql_update);

// Obtener los cubiculos
$sql_select = "SELECT * FROM cubiculos";
$result = $conexion->query($sql_select);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de cubiculos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            padding: 20px;
            text-align: center;
        }
        h1 {
            font-size: 2.5em;
            margin-bottom: 20px;
        }
        table {
            margin: 0 auto;
            width: 80%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            font-size: 1.2em;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .reservar {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
        }
        .reservar:hover {
            background-color: #218838;
        }
        #activar-sonido {
            background-color: #ff9800;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-size: 1.2em;
            cursor: pointer;
            margin-top: 20px;
        }
        #activar-sonido:hover {
            background-color: #e68900;
        }
    </style>
</head>
<body>
    <h1>Lista de cubiculos</h1>
    <table>
        <thead>
            <tr>
                <th>Número de cubiculo</th>
                <th>Estado</th>
                <th>Hora de Salida</th>
                <th>Estado</th>
                <th>Tamaño</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['numero_cubiculo']; ?></td>
                    <td><?php echo $row['estado']; ?></td>
                    <td data-hora-salida="<?php echo $row['hora_salida']; ?>">
                        <?php echo $row['hora_salida']; ?>
                    </td>
                    <td>
                        <?php if ($row['estado'] == 'Disponible'): ?>
                            <a class="reservar" href="reservacionCubiculos.php?numero_cubiculo=<?php echo $row['numero_cubiculo']; ?>">Reservar</a>
                        <?php else: ?>
                            <span>No disponible</span>
                        <?php endif; ?>
                    </td>
                    <td><?php echo $row['tipo_cubiculo']; ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <!-- Botón para permitir el sonido (necesario para navegadores) -->
    <button id="activar-sonido" onclick="permitirSonido()">Activar Sonido</button>

    <!-- Cargar el sonido de alerta -->
    <audio id="alerta-sonido" src="assets/cubiculos/alerta.mp3" preload="auto"></audio>

    <script>
        let sonidoPermitido = false;

        function permitirSonido() {
            sonidoPermitido = true;
            alert("Sonido activado. Se reproducirá la alerta cuando falte 1 minuto, manten la pestana abierta para escucharlo.");
        }

        // Función para convertir la hora en formato HH:mm:ss a un objeto Date
        function convertirHora(horaStr) {
            const hoy = new Date();
            const [horas, minutos, segundos] = horaStr.split(':').map(Number);
            return new Date(hoy.getFullYear(), hoy.getMonth(), hoy.getDate(), horas, minutos, segundos || 0);
        }

        // Diccionario para almacenar qué cubiculos ya han mostrado la alerta
        let alertasMostradas = {};

        // Recorremos las filas para buscar la hora de salida
        function verificarcubiculos() {
            document.querySelectorAll('td[data-hora-salida]').forEach(function(td) {
                const horaSalida = convertirHora(td.getAttribute('data-hora-salida'));
                const ahora = new Date();
                const unMinutoAntes = new Date(horaSalida.getTime() - 1 * 60 * 1000); // 1 minuto antes
                const numeroCubiculo = td.parentElement.children[0].innerText;

                // Si falta 1 minuto para la hora de salida y no se ha mostrado alerta
                if (ahora >= unMinutoAntes && ahora < horaSalida && sonidoPermitido && !alertasMostradas[numeroCubiculo]) {
                    const audio = document.getElementById('alerta-sonido');
                    audio.play();
                    alertasMostradas[numeroCubiculo] = true; // Marcar que ya se mostró la alerta
                }
            });
        }

        // Para verificar el estado cada 5 segundos
        setInterval(verificarcubiculos, 5000); // Cada 10 segundos se revisa la hora de salida
    </script>
</body>
</html>

<?php
// Cerrar la conexión
$conexion->close();
?>
