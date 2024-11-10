<?php
session_start();

if (!isset($_SESSION['sesionActual']) && empty($_SESSION['sesionActual'])) {
    echo "<script>
            alert('No tienes una sesión activa');
            window.location.href = '/registroinfoteca/pagina_principal.php';
          </script>";
    }else{
    include("C:\\xampp\\htdocs\\registroinfoteca\\php\\conexion_be.php");

    $sql = "UPDATE sesiones_activas SET fin_sesion = CURRENT_TIMESTAMP() WHERE id = " . $_SESSION['sesionActual'];
    $result = $conn->query($sql);
    
    session_unset();
    session_destroy();
    
    echo "<script>
    alert('Cierre de sesión exitoso');
    window.location.href = '/registroinfoteca/pagina_principal.php';
  </script>";}
?> 