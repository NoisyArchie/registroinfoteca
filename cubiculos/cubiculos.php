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
    <title>Cubículos - Infoteca</title>
    <link rel="stylesheet" href="/registroinfoteca/assets/css/styles_Cubiculos.css">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Paytone+One&family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
</head>

<body>
    <!--header-->
    <div id="main-content">
        <header>
            <a href="#" class="logo">Infoteca</a>
            <div class="bx bx-menu" id="menu-icon"></div>
            <ul class="navbar">
                <li><a href="/registroinfoteca/pagina_principal.php">Inicio</a></li>
                <li><a href="/registroinfoteca/afluencia/afluencia.php">Afluencia</a></li>
                <li><a href="/registroinfoteca/eventos/eventos.php">Eventos</a></li>
                <li><a href="/registroinfoteca/cubiculos/cubiculos.php">Cubículos</a></li>
                <li>
                    <?php
                    if (isset($_SESSION['usuarioID']) && !empty($_SESSION['usuarioID'])) {
                        ?>
                        <a href="/registroinfoteca/login/cerrar_sesion.php">Cerrar Sesión</a>
                    </li>
                    <?php
                    } else {
                        ?>
                    <a href="/registroinfoteca/login/login.html">Iniciar Sesión</a></li>
                    <?php
                    }
                    ?>
            </ul>
        </header>


        <!--ENCABEZADO-->
        <section class="cubiculos" id="cubiculos">
            <div class="cubiculos-text">
                <h1>
                    Cubículos
                </h1>
            </div>
        </section>

        <!--INICIO-->
        <section class="cuerpo" id="cuerpo">
            <div class="cuerpo-text">
                <h2>¡A estudiar!</h2>
                <p>En nuestros cubículos encontrarás un ambiente cómodo y silencioso, perfecto para concentrarte y dar
                    lo mejor de ti. Estudia solo o en compañía de tus amigos y disfruta de un lugar diseñado para tu
                    comodidad y enfoque. <br> ¡Reserva ahora y aprovecha tu tiempo al máximo!<br><br></p>
                <h3><i class='bx bx-time-five'></i> Horario: 8am - 9pm </h3>
            </div>
        </section>
        <section>
            <h1>Lista de cubiculos</h1>
            <!-- Botón para permitir el sonido (necesario para navegadores) -->
            <button id="activar-sonido" onclick="permitirSonido()" class="tooltip">
                <i class="fas fa-bell"></i> </button>
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
                                    <a class="reservar"
                                        href="reservacionCubiculos.php?numero_cubiculo=<?php echo $row['numero_cubiculo']; ?>">Reservar</a>
                                <?php else: ?>
                                    <span>No disponible</span>
                                <?php endif; ?>
                            </td>
                            <td><?php echo $row['tipo_cubiculo']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            <!-- Cargar el sonido de alerta -->
            <audio id="alerta-sonido" src="\registroinfoteca\assets\cubiculos\alerta.mp3" preload="auto"></audio>
        </section>

        <script>
            /*Sticky header*/
            const header = document.querySelector("header");
            window.addEventListener("scroll", function () {
                header.classList.toggle("sticky", window.scrollY > 0);
            });

            /*menu*/
            const menuIcon = document.getElementById('menu-icon');
            const navbar = document.querySelector('.navbar');

            menuIcon.addEventListener('click', () => {
                navbar.classList.toggle('active');
            });
            
            let sonidoPermitido = false;
            function permitirSonido() {
                sonidoPermitido = true;
                alert("Sonido activado. Se reproducirá la alerta cuando falte 1 minuto, manten la pestaña abierta para escucharlo.");
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
                document.querySelectorAll('td[data-hora-salida]').forEach(function (td) {
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
            setInterval(verificarcubiculos, 5000); // Cada 5 segundos se revisa la hora de salida
        </script>
</body>

</html>

<?php
// Cerrar la conexión
$conexion->close();
?>