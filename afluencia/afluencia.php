<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estadísticas de Afluencia</title>
    <link rel="stylesheet" href="/registroinfoteca/assets/css/styles_Afluencia.css">
    <link href="https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Paytone+One&family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <!-- Header -->
    <header id="inicio">
        <a href="#" class="logo">Infoteca</a>
        <div class="bx bx-menu" id="menu-icon"></div>
        <ul class="navbar">
            <li><a href="/registroinfoteca/pagina_principal.php">Inicio</a></li>
            <li><a href="/registroinfoteca/afluencia/afluencia.php">Afluencia</a></li>
            <li><a href="/registroinfoteca/eventos/eventos.php">Eventos</a></li>
            <li><a href="/registroinfoteca/cubiculos/cubiculos.php">Cubículos</a></li>
            <li>
                <?php
                session_start();
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
    <section class="afluencia" id="afluencia">
        <div class="afluencia-text">
            <h1>
                Afluencia
            </h1>
        </div>
    </section>

    <!-- Sección de inicio -->
    <section id="cuerpo" class="cuerpo">
        <div class="cuerpo-texto">
            <h2>Estadísticas en tiempo real</h2>
            <p>Obtén estadísticas en tiempo real de la infoteca para organizar tu visita de manera óptima: conoce la cantidad actual de personas, disponibilidad de cubículos, y los horarios de mayor y menor afluencia. Con esta información, podrás elegir el mejor momento para acceder a los servicios de la infoteca de forma cómoda y sin contratiempos. ¡Planifica tu visita al detalle y aprovecha al máximo el espacio!</p>
        </div>
    </section>

    <div class="estadisticas-container">
        <div class="tarjeta destacada">
            <p>Número de personas en la infoteca:</p>
            <div class="contador-container">
                <span class="contador" id="num_personas"></span>
                <i class="bx bxs-user"></i>
            </div>
        </div>
        <div class="tarjeta destacada">
            <p>Cubículos disponibles:</p>
            <div class="cubiculos-container" id="cubiculos_disponibles"></div>
            <span id="numero_cubiculos"></span>
        </div>
        <div class="tarjeta">
            <p>Promedio de permanencia:</p>
            <span class="promedio" id="promedio_permanencia"></span>
        </div>
        <div class="tarjeta">
            <p>Hora de mayor afluencia:</p>
            <span id="hora_mayor_afluencia"></span>
        </div>
        <div class="tarjeta">
            <p>Día de mayor afluencia:</p>
            <span id="dia_mayor_afluencia"></span>
        </div>
        <div class="tarjeta">
            <p>Día menos concurrido:</p>
            <span id="dia_menos_concurrido"></span>
        </div>
        <div class="tarjeta destacada">
            <p>Lockers disponibles:</p>
            <span class="contador" id="lockers_disponibles"></span>
        </div>
    </div>

    <div class="grafico-container">
        <canvas id="grafico"></canvas>
    </div>

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

        // Función de actualización de estadísticas
        function cargarEstadisticas() {
            $.ajax({
                url: 'cargar_estadisticas.php',
                type: 'GET',
                dataType: 'json',
                success: function (datos) {
                    $('#num_personas').text(datos.num_personas);
                    $('#promedio_permanencia').text(`${Math.floor(datos.promedio_permanencia / 60)}h ${Math.floor(datos.promedio_permanencia % 60)}m`);
                    $('#hora_mayor_afluencia').text(datos.hora_mayor_afluencia);
                    $('#dia_mayor_afluencia').text(datos.dia_mayor_afluencia);
                    $('#dia_menos_concurrido').text(datos.dia_menos_concurrido);
                    $('#lockers_disponibles').text(datos.lockers_disponibles);

                    // Actualizar los cubículos disponibles y mostrar el número
                    actualizarCubiculos(datos.cubiculos_disponibles);

                    // Actualizar gráfico
                    actualizarGrafico(datos.grafico_diario);
                }
            });
        }

        // Función para actualizar cubículos disponibles
        function actualizarCubiculos(cubiculosDisponibles) {
            const totalCubiculos = 11;
            const cubiculosContainer = $('#cubiculos_disponibles');
            const numeroCubiculos = $('#numero_cubiculos');

            cubiculosContainer.empty(); // Vaciar contenedor de cubículos
            numeroCubiculos.text(`${cubiculosDisponibles}/${totalCubiculos}`);

            for (let i = 0; i < totalCubiculos; i++) {
                const cubiculo = $('<i>').addClass('cubiculo');
                if (i < cubiculosDisponibles) {
                    cubiculo.addClass('disponible').html('<i class="bx bx-checkbox"></i>');
                } else {
                    cubiculo.html('<i class="bx bx-checkbox-square" style="color:#ffffff;"></i>');
                }
                cubiculosContainer.append(cubiculo);
            }
        }

        // Plugin personalizado para agregar un pie de página
        const footerPlugin = {
            id: 'customFooter',
            afterDraw: function (chart) {
                const { ctx, chartArea: { bottom, left, right } } = chart;
                ctx.save();
                ctx.font = '16px Poppins, sans-serif';
                ctx.fillStyle = '#221314';
                ctx.textAlign = 'center';
                ctx.fillText(
                    'Este gráfico muestra la tendencia diaria de uso de la infoteca, con los horarios y la cantidad de personas presentes en cada uno.',
                    left + (right - left) / 2,
                    bottom + 30
                );
                ctx.restore();
            }
        };

        // Función para actualizar gráfico de uso diario
        function actualizarGrafico(datos) {
            let labels = datos.map(d => d.hora);
            let valores = datos.map(d => d.cantidad);

            const ctx = document.getElementById('grafico').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Tendencia de uso diario',
                        data: valores,
                        backgroundColor: 'rgba(110, 84, 250, 0.3)', 
                        borderColor: 'rgba(110, 84, 250, 1)', 
                        borderWidth: 3, 
                        pointBackgroundColor: '#6e54fa', 
                        pointBorderColor: '#ffffff', 
                        pointBorderWidth: 3, 
                        pointRadius: 5, 
                        fill: true, 
                        tension: 0.4,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        title: {
                            display: true,
                            text: 'Uso Diario de la Infoteca', 
                            font: {
                                size: 18,
                                family: 'Poppins, sans-serif'
                            },
                            color: '#221314',
                            padding: { top: 20, bottom: 20 } 
                        },
                        legend: {
                            display: true,
                            labels: {
                                color: '#221314',
                                font: {
                                    size: 14,
                                }
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function (tooltipItem) {
                                    return tooltipItem.raw + ' personas';
                                }
                            },
                            backgroundColor: 'rgba(0, 0, 0, 0.7)',
                            titleColor: '#ffffff',
                            bodyColor: '#ffffff',
                            borderColor: '#6e54fa',
                            borderWidth: 2,
                        },
                        // Plugin personalizado para agregar un pie de página (no usado)
                        afterDraw(chart) {
                            const { ctx, chartArea: { bottom, left, right } } = chart;
                            ctx.save();
                            ctx.font = '16px Poppins, sans-serif';
                            ctx.fillStyle = '#221314';
                            ctx.textAlign = 'center';
                            ctx.fillText(
                                'Este gráfico muestra la tendencia diaria de uso de la infoteca, con los horarios y la cantidad de personas presentes en cada uno.',
                                left + (right - left) / 2,
                                bottom + 30
                            );
                            ctx.restore();
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                color: '#5a7184',
                                stepSize: 1,
                                callback: function (value) {
                                    return value % 1 === 0 ? value : ''; 
                                }
                            },
                            grid: {
                                color: 'rgba(90, 113, 132, 0.2)',
                                borderColor: 'rgba(90, 113, 132, 0.3)',
                            },
                            title: {
                                display: true,
                                text: 'Personas',
                                color: '#5a7184',
                                font: {
                                    size: 14
                                }
                            }
                        },
                        x: {
                            ticks: {
                                color: '#5a7184',
                            },
                            grid: {
                                color: 'rgba(90, 113, 132, 0.1)',
                            },
                            title: {
                                display: true,
                                text: 'Horario',
                                color: '#5a7184',
                                font: {
                                    size: 14
                                }
                            }
                        }
                    }
                }
            });
        }

        $(document).ready(function () {
            cargarEstadisticas();
            setInterval(cargarEstadisticas, 5000);
        });

    </script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</body>

</html>