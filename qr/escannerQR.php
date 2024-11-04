<?php
session_start();

if (!isset($_SESSION['sesionActual']) && empty($_SESSION['sesionActual'])) {
    echo "No tienes una sesion activa";
    header('Location: /registroinfoteca/login/login.html');
}
?> 

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Escaner QR</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Paytone+One&family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap"
      rel="stylesheet" />
    <link rel="stylesheet" href="/registroinfoteca/assets/css/styles_QR.css">
  </head>
  <body>
    <div class="scanner-container">
      <h2>Escanea el QR en la entrada</h2>
      <div id="reader" style="width: 100%;"></div>
      <div class="result-container">
        <span id="result">Esperando...</span>
      </div>
    </div>
    <script src="html5-qrcode.min.js"></script>
    <script src="scriptQR.js"></script>
  </body>
</html>