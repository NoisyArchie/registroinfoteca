<?php
header('Content-Type: application/json');
$conexion = new mysqli("localhost", "root", "", "registroinfoteca");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$conexion->query("SET lc_time_names = 'es_ES'");

$estadisticas = [];

// Número de personas en la infoteca
$sql = "SELECT COUNT(*) AS total FROM qr_adentro WHERE salida IS NULL";
$resultado = $conexion->query($sql);
$estadisticas['num_personas'] = $resultado->fetch_assoc()['total'];

// Cubículos disponibles
$sql = "SELECT COUNT(*) AS disponibles FROM cubiculos WHERE estado = 'Disponible'";
$resultado = $conexion->query($sql);
$estadisticas['cubiculos_disponibles'] = $resultado->fetch_assoc()['disponibles'];

// Promedio de permanencia (en minutos)
$sql = "SELECT AVG(TIMESTAMPDIFF(MINUTE, entrada, salida)) AS promedio FROM qr_adentro WHERE salida IS NOT NULL";
$resultado = $conexion->query($sql);
$estadisticas['promedio_permanencia'] = round($resultado->fetch_assoc()['promedio'], 2);

// Hora de mayor afluencia
$sql = "SELECT HOUR(entrada) AS hora, COUNT(*) AS total FROM qr_adentro GROUP BY HOUR(entrada) ORDER BY total DESC LIMIT 1";
$resultado = $conexion->query($sql);
$estadisticas['hora_mayor_afluencia'] = $resultado->fetch_assoc()['hora'] . ":00";

// Día de mayor afluencia
$sql = "SELECT CONCAT(UPPER(SUBSTRING(DAYNAME(entrada), 1, 1)), LOWER(SUBSTRING(DAYNAME(entrada), 2))) AS dia, COUNT(*) AS total 
        FROM qr_adentro 
        GROUP BY DAYNAME(entrada) 
        ORDER BY total DESC LIMIT 1";
$resultado = $conexion->query($sql);
$estadisticas['dia_mayor_afluencia'] = $resultado->fetch_assoc()['dia'];

// Día menos concurrido
$sql = "SELECT CONCAT(UPPER(SUBSTRING(DAYNAME(entrada), 1, 1)), LOWER(SUBSTRING(DAYNAME(entrada), 2))) AS dia, COUNT(*) AS total 
        FROM qr_adentro 
        GROUP BY DAYNAME(entrada) 
        ORDER BY total ASC LIMIT 1";
$resultado = $conexion->query($sql);
$estadisticas['dia_menos_concurrido'] = $resultado->fetch_assoc()['dia'];

// Lockers disponibles
$sql = "SELECT COUNT(*) AS disponibles FROM lockers WHERE ocupado = 0";
$resultado = $conexion->query($sql);
$estadisticas['lockers_disponibles'] = $resultado->fetch_assoc()['disponibles'];

// Tendencia de uso diario (gráfico)
$sql = "SELECT HOUR(entrada) AS hora, COUNT(*) AS total FROM qr_adentro WHERE DATE(entrada) = CURDATE() GROUP BY HOUR(entrada)";
$resultado = $conexion->query($sql);
$grafico_diario = [];
while ($fila = $resultado->fetch_assoc()) {
    $grafico_diario[] = ["hora" => $fila['hora'] . ":00", "cantidad" => $fila['total']];
}
$estadisticas['grafico_diario'] = $grafico_diario;
echo json_encode($estadisticas);
$conexion->close();
?>
