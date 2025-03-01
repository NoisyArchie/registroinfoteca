<html>

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta charset="utf-8" />
  <title>Eventos - Infoteca</title>
  <link rel="stylesheet" href="eventoestilo.css" />
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
    <section class="eventos" id="eventos">
      <div class="eventos-text">
        <h1>
          Eventos
        </h1>
      </div>
    </section>

    <!--INICIO-->
    <section class="cuerpo" id="cuerpo">
      <div class="cuerpo-text">
        <h2>¡Bienvenido!</h2>
        <p>Explora todos los eventos y talleres que Infoteca Campus Arteaga tiene para ti. <br>
          ¡Regístrate y no te pierdas ninguna oportunidad de aprender y conectar!</p>
      </div>
    </section>

    <div class="color-indicators">
      <div class="indicator">
        <span class="color-box event-color"></span>
        <p>Evento</p>
      </div>
      <div class="indicator">
        <span class="color-box today-color"></span>
        <p>Hoy</p>
      </div>
    </div>

    <div id="calendar">
      <!--CALENDARIO-->
      <section class="calendario" id="calendario">
        <div class="container">
          <div class="calendar">
            <div class="header">
              <div class="month"></div>
              <div class="btns">
                <div class="btn today-btn">
                  <i class="fas fa-calendar-day"></i>
                </div>
                <div class="btn prev-btn">
                  <i class="fas fa-chevron-left"></i>
                </div>
                <div class="btn next-btn">
                  <i class="fas fa-chevron-right"></i>
                </div>
              </div>
            </div>
            <div class="weekdays">
              <div class="day">Dom</div>
              <div class="day">Lun</div>
              <div class="day">Mar</div>
              <div class="day">Mie</div>
              <div class="day">Jue</div>
              <div class="day">Vie</div>
              <div class="day">Sab</div>
            </div>
            <div class="days">
            </div>
          </div>
        </div>
    </div>
  </div>

  <div id="event-details" class="event-details">
    <span class="event-details-close">&times;</span>
    <h3 id="event-title"></h3>
    <img id="event-image" src="" alt="Imagen del evento">
    <p>
      <i class="fas fa-calendar-day"></i>
      <span id="event-date"></span>
    </p>
    <p id="event-description"></p>
    <a id="event-link" href="" target="_blank">Registrarse</a>
  </div>
  </section>


</html>

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

  /*Cambio de fondo*/
  const images = [
    'assets/eventos1.jpg',
    'assets/eventos2.jpg',
    'assets/eventos3.jpg'
  ];

  let currentImageIndex = 0;
  const eventosSection = document.querySelector('.eventos');

  function changeBackgroundImage() {
    eventosSection.style.backgroundImage = `linear-gradient(rgba(0, 0, 0, 0.75), rgba(0, 0, 0, 0.75)), url(${images[currentImageIndex]})`;
    currentImageIndex = (currentImageIndex + 1) % images.length;
  }

  setInterval(changeBackgroundImage, 7000);

  /* Calendario */
  const daysContainer = document.querySelector(".days"),
    nextBtn = document.querySelector(".next-btn"),
    prevBtn = document.querySelector(".prev-btn"),
    month = document.querySelector(".month"),
    todayBtn = document.querySelector(".today-btn");

  const months = [
    "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio",
    "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"
  ];

  // Definir eventos (año, mes, dia)
  const events = {
    "2024-10-10": {
      title: "Congreso de programadores",
      image: 'assets/eventos1.jpg',
      date: "10 de octubre - 10AM",
      description: "Se llevará a cabo el congreso de programadores, con varios cursos impartidos por personal calificado... bla bla bla",
      link: "https://forms.office.com/Pages/ResponsePage.aspx?id=gsNAcvN36kKVdjcJfbNi0APzSyytTvNIvs-2bBwmcHVUM00wS1Q5VVZJTTlIMjNYMFZRRDlUTDNEUS4u"
    },
    "2024-11-08": {
      title: "MexIHC-2024",
      image: 'assets/mexihc.png',
      date: "8 de Noviembre - 10AM",
      description: "Mex-IHC tiene el objetivo del intercambio de ideas entre investigadores, académicos, grupos de interés, estudiantes y profesionistas del campo de Interacción Humano-Computadora y la Usabilidad de Sistemas Interactivos.",
      link: "https://www.mexihc.org/2024/es"
    }
  };

  // Obtener fecha actual
  const date = new Date();
  let currentMonth = date.getMonth();
  let currentYear = date.getFullYear();

  // Renderizar el calendario
  function renderCalendar() {
    date.setDate(1);
    const firstDay = new Date(currentYear, currentMonth, 1);
    const lastDay = new Date(currentYear, currentMonth + 1, 0);
    const lastDayIndex = lastDay.getDay();
    const lastDayDate = lastDay.getDate();
    const prevLastDay = new Date(currentYear, currentMonth, 0);
    const prevLastDayDate = prevLastDay.getDate();
    const nextDays = 7 - lastDayIndex - 1;

    month.innerHTML = `${months[currentMonth]} ${currentYear}`;
    let daysHTML = "";

    // Días del mes anterior
    for (let x = firstDay.getDay(); x > 0; x--) {
      daysHTML += `<div class="day prev">${prevLastDayDate - x + 1}</div>`;
    }

    // Días del mes actual
    for (let i = 1; i <= lastDayDate; i++) {
      const dayDate = new Date(currentYear, currentMonth, i);
      const formattedDate = dayDate.toISOString().split("T")[0];
      const isToday = i === new Date().getDate() && currentMonth === new Date().getMonth() && currentYear === new Date().getFullYear();

      let dayClass = "day";
      if (isToday) dayClass += " today";
      if (events[formattedDate]) dayClass += " event";

      daysHTML += `<div class="${dayClass}" onclick="showEventDetails('${formattedDate}')">${i}</div>`;
    }

    // Días del próximo mes
    for (let j = 1; j <= nextDays; j++) {
      daysHTML += `<div class="day next">${j}</div>`;
    }

    daysContainer.innerHTML = daysHTML;
    hideTodayBtn();
  }

  renderCalendar();

  nextBtn.addEventListener("click", () => {
    currentMonth++;
    if (currentMonth > 11) {
      currentMonth = 0;
      currentYear++;
    }
    renderCalendar();
  });

  prevBtn.addEventListener("click", () => {
    currentMonth--;
    if (currentMonth < 0) {
      currentMonth = 11;
      currentYear--;
    }
    renderCalendar();
  });

  todayBtn.addEventListener("click", () => {
    currentMonth = date.getMonth();
    currentYear = date.getFullYear();
    renderCalendar();
  });

  function hideTodayBtn() {
    if (currentMonth === new Date().getMonth() && currentYear === new Date().getFullYear()) {
      todayBtn.style.display = "none";
    } else {
      todayBtn.style.display = "flex";
    }
  }

  // Mostrar detalles del evento
  function showEventDetails(date) {
    const event = events[date];
    if (event) {
      document.getElementById("event-title").textContent = event.title;
      document.getElementById("event-image").src = event.image;
      document.getElementById("event-date").textContent = event.date;
      document.getElementById("event-description").textContent = event.description;
      document.getElementById("event-link").href = event.link;
      document.getElementById("event-details").style.display = "block";

      document.getElementById("main-content").classList.add("blur-background");
    }
  }

  document.querySelector(".event-details-close").addEventListener("click", () => {
    document.getElementById("event-details").style.display = "none";

    document.getElementById("main-content").classList.remove("blur-background");
  });

</script>