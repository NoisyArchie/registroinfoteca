<?php
if (isset($_GET['numero_cubiculo'])) {
    $numero_cubiculo = $_GET['numero_cubiculo'];
} else {
    die("No se ha seleccionado un cubiculo.");
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservación de cubiculo</title>
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

        .reservacion-form {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
            padding: 20px;
            max-width: 400px;
            margin: 0 auto;
        }

        label {
            font-size: 1.2em;
            display: block;
            margin-bottom: 10px;
        }

        input[type="text"],
        input[type="time"],
        input[type="file"] {
            width: 100%;
            padding: 3px;
            font-size: 1em;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        button {
            padding: 10px 20px;
            font-size: 1.2em;
            background-color: #6e54fa;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #423494;
        }

        .back-link {
            display: inline-block;
            margin-top: 20px;
            text-decoration: none;
            color: #6e54fa;
            font-size: 1.1em;
        }

        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <h1>Reservar cubiculo #<?php echo $numero_cubiculo; ?></h1>
    <div class="reservacion-form">
        <form method="POST" action="reservarCubiculos.php" enctype="multipart/form-data">
            <input type="hidden" name="numero_cubiculo" value="<?php echo $numero_cubiculo; ?>">

            <label for="credencial">Subir Credencial:</label>
            <input type="file" name="credencial" id="credencial" accept="image/*" required>

            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" id="nombre" required>

            <label for="hora_entrada">Hora de Entrada:</label>
            <input type="time" name="hora_entrada" id="hora_entrada" required>

            <label for="hora_salida">Hora de Salida:</label>
            <input type="time" name="hora_salida" id="hora_salida" required>

            <button type="submit">Confirmar Reservación</button>
        </form>
    </div>
    <a class="back-link" href="cubiculos.php">Volver a la lista de cubiculo</a>
</body>

</html>