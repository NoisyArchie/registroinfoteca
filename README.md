# registroinfoteca

Este proyecto tiene como objetivo gestionar los recursos y eventos de la infoteca campus Arteaga de la UAdeC. Permite a los usuarios reservar cubículos, ver estadísticas en tiempo real sobre la afluencia, y realizar otras acciones relacionadas con el uso de la infoteca. Se pretende agilizar al máximo los procesos que por lo general, al ser efectuados manualmente/analogicamente suelen tomar mucho tiempo.

## Características
- **Página de inicio** con información general sobre la infoteca.
- **Sistema de login** para autenticar usuarios.
- **Reserva de cubículos** para que los usuarios puedan hacer reservacion de sus cubículos y observar disponbilidades
- **Eventos** con la opción de registrarse y ver detalles.
- **Estadísticas en tiempo real** de la afluencia de personas y más datos útiles para el usuario
- **Funcional en dispositivos móviles**
- **Sistema de asistencia mediante código qr** para aglizar los largos procesos de registro y asignación de casilleros que sufren los usuarios que visitan infoteca

  ## Librerías y Tecnologías Utilizadas
- **HTML**, **CSS**, **JavaScript**.
- **PHP** para la parte del backend.
- **MySQL** para la base de datos.
- **AJAX** que es usado para cargar y actualizar datos en la sección de afluencia sin tener que recargar la página.
- **Chart.js** para las gráficas de la sección de afluencia.
- **HTML5-QrCode** para el sistema de asistencia mediante códigos qr.
- **XAMPP** como servidor local para ejecutar el proyecto.

## Instalación

Para ejecutar este proyecto localmente en tu máquina, sigue estos pasos:

1. **Descarga e instala XAMPP** desde [su página oficial](https://www.apachefriends.org/index.html).

2. **Clona el repositorio en tu computadora**:
   ```bash
   git clone https://github.com/NoisyArchie/registroinfoteca.git

3. Mueve la carpeta del proyecto clonada a la subcarpeta `htdocs` dentro del directorio de instalación de XAMPP (por defecto, `C:\xampp\htdocs` en Windows).
   
4. Inicia XAMPP y asegúrate de que los servicios de Apache, MySQL y Filezilla estén funcionando.
   
5. Accede a la página desde tu navegador usnado la dirección: http://localhost/registroinfoteca (para acceder a la carpeta) o http://localhost/registroinfoteca/pagina_principal.php para acceder al inicio.
   
6. Crea una base de datos en phpmyadmin e importa el archivo sql que viene incluido en el proyecto, el archivo se llama registroinfoteca.sql


## Historial de versiones
- v1.4: Sección de afluencia con estadísticas en tiempo real, ajustes de diseño y media queries para dispositivos móviles.
- v1.3: Funcionalidades de registro de asistencia y asignación de lockers.
- v1.2: Agregados eventos y reservación de cubículos, mejoras en el login.
- v1.1: Mejoras generales en la página de inicio y login.
- v1.0: Página principal y sistema de login.


## Contribuidores
Este proyecto fue desarrollado por un equipo de estudiantes de la Facultad de Sistemas en la materia de Ingeniería de Software impartida por la Dra. Valeria Soto:

- **Diana Marcela Arévalo Sifuentes**: 
- **Carlo Hiram Fernández Salinas**: 
- **Oswaldo Castañeda de la Torre**:
- **Martín Guzmán Peña**: 
- **Héctor Elí Tavera Guía**: 
- **Angel de Jesús Sánchez Jaramillo**:

  Para cualquier duda o aclaración dirigirse al siguiente correo: angeljaramillo@uadec.edu.mx

