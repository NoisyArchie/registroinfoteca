<?php
session_start();

if (!isset($_SESSION['sesionActual']) && empty($_SESSION['sesionActual'])) {
    echo "No tienes una sesion activa";
    header('Location: /registroinfoteca/pagina_principal.php');
}else{
    include("C:\\xampp\\htdocs\\registroinfoteca\\php\\conexion_be.php");

    $sql = "UPDATE sesiones_activas SET fin_sesion = CURRENT_TIMESTAMP() WHERE id = " . $_SESSION['sesionActual'];
    $result = $conn->query($sql);
    
    session_unset();
    session_destroy();
    
    header('Location: /registroinfoteca/pagina_principal.php');
}
?> 