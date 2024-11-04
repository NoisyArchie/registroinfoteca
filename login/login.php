<?php
session_start();
include("C:\\xampp\\htdocs\\registroinfoteca\\php\\conexion_be.php");

// Función para validar correos internos
function validarCorreoInterno($correo) {
    return strpos($correo, '@uadec.edu.mx') !== false;
}

// Registro de usuario
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {
    $nombre_completo = $_POST['nombre_completo'];
    $correo = $_POST['correo'];
    $usuario = $_POST['usuario'];
    $contrasena = password_hash($_POST['contrasena'], PASSWORD_BCRYPT);
    $matricula = !empty($_POST['matricula']) ? $_POST['matricula'] : null;
    $tipo_usuario = $matricula ? 'interno' : 'externo';

    // Verificar si el usuario o la matrícula ya existen
    $verificarUsuario = $conn->query("SELECT * FROM usuarios WHERE usuario = '$usuario'");
    $verificarMatricula = $matricula ? $conn->query("SELECT * FROM usuarios WHERE matricula = '$matricula'") : false;

    if ($verificarUsuario->num_rows > 0) {
        echo "<script>alert('El usuario ya está registrado');</script>";
    } elseif ($matricula && $verificarMatricula && $verificarMatricula->num_rows > 0) {
        echo "<script>alert('La matrícula ya está registrada');</script>";
    } else {
        // Procesar credencial si es usuario externo
        $ruta_credencial = null;
        if ($tipo_usuario === 'externo') {
            if (isset($_FILES['credencial']) && $_FILES['credencial']['error'] === 0) {
                $ruta_destino = 'login\credenciales' . basename($_FILES['credencial']['name']);
                if (move_uploaded_file($_FILES['credencial']['tmp_name'], $ruta_destino)) {
                    $ruta_credencial = $ruta_destino;
                } else {
                    echo "<script>alert('Error al subir la credencial.');</script>";
                    exit;
                }
            } else {
                echo "<script>alert('Es obligatorio subir una credencial para usuarios externos.');</script>";
                exit;
            }
        }

        // Insertar en la base de datos
        $sql = "INSERT INTO usuarios (nombre_completo, correo, usuario, contrasena, matricula, tipo_usuario, credencial) 
                VALUES ('$nombre_completo', '$correo', '$usuario', '$contrasena', '$matricula', '$tipo_usuario', '$ruta_credencial')";
        
        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Registro exitoso');</script>";
            // Redirección para evitar el reenvío del formulario
           // header("Location: home/pagina_principal.php"); // Cambia `formulario.php` a la URL adecuada de tu página
            exit;
        } else {
            echo "<script>alert('Error: " . $sql . "<br>" . $conn->error . "');</script>";
        }
    }
}

// Verifica si es una solicitud de inicio de sesión
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
  $usuario = $_POST['usuario'];
  $correo = $_POST['correo'];
  $contrasena = $_POST['contrasena'];

  // Verificar en la base de datos
  $sql = "SELECT * FROM usuarios WHERE usuario = '$usuario' AND correo = '$correo'";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
      $user = $result->fetch_assoc();
      
      // Verificar la contraseña
      if (password_verify($contrasena, $user['contrasena'])) {
          // Registrar en la tabla de sesiones activas
          $usuario_id = $user['id'];
          $sql_sesion = "INSERT INTO sesiones_activas (usuario_id) VALUES ('$usuario_id')";

          if ($conn->query($sql_sesion) === TRUE) {
            $last_id = $conn->insert_id;
            $_SESSION['usuarioID'] = $usuario_id;
            //echo "$last_id"; 
            $_SESSION['sesionActual'] = $last_id;
           header('Location: /registroinfoteca/pagina_principal.php');
            exit; 
        } else {
              echo "<script>alert('Error al registrar la sesión.');</script>";
          }
      } else {
          echo "<script>alert('Contraseña incorrecta');</script>";
      }
  } else {
      echo "<script>alert('No existe una cuenta con ese usuario o correo');</script>";
  }
}

?>