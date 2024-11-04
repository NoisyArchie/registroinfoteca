<html>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta charset="utf-8" />
    <title>Infoteca - Campus Arteaga</title>
    <link rel="stylesheet" href="eventoestilo.css" />
    <link
      rel="stylesheet"
      href="https://unpkg.com/boxicons@latest/css/boxicons.min.css"
    />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Paytone+One&family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap"
      rel="stylesheet"
    />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
    />
  </head>
  <body>
    <!--header-->
    <header>
        <a href="#" class="logo">Infoteca</a>
        <div class="bx bx-menu" id="menu-icon"></div>
        <ul class="navbar">
          <li><a href="#inicio">Inicio</a></li>
          <li><a href="#afluencia">Afluencia</a></li>
          <li><a href="/registroinfoteca/eventos/eventos.php">Eventos</a></li>
          <li><a href="/registroinfoteca/cubiculos/cubiculos.php">Cubículos</a></li>
          <li>
            <?php
              session_start();
              if (isset($_SESSION['usuarioID']) && !empty($_SESSION['usuarioID'])){
                ?>
                <a href="/registroinfoteca/login/cerrar_sesion.php">Cerrar Sesión</a></li>
                <?php
              }else{
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
                    EVENTOS
                </h1>
            </div>
        </section>

         <!--INICIO-->
         <section class="cuerpo" id="cuerpo">
            <div class="cuerpo-text">
                <h2>¡Bienvenido!</h2>
                <p>En esta sección podrás enterarte de los eventos y talleres que te ofrecemos en Infoteca Campus Arteaga <br>
                Registrate y no te pierdas ninguno de ellos.</p>
            </div>
         </section>

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
                <div class="day">Sun</div>
                <div class="day">Mon</div>
                <div class="day">Tue</div>
                <div class="day">Wed</div>
                <div class="day">Thu</div>
                <div class="day">Fri</div>
                <div class="day">Sat</div>
              </div>
              <div class="days">
              </div>
            </div>
          </div>
        </section>
      

</html>

<script>

    /*Sticky header*/
const header = document.querySelector("header");
window.addEventListener("scroll", function(){
    header.classList.toggle("sticky", window.scrollY > 0);
});

/*cambio de fondo*/
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


/*calendario*/
const daysContainer = document.querySelector(".days"),
  nextBtn = document.querySelector(".next-btn"),
  prevBtn = document.querySelector(".prev-btn"),
  month = document.querySelector(".month"),
  todayBtn = document.querySelector(".today-btn");

const months = [
  "Enero",
  "Febrero",
  "Marzo",
  "Abril",
  "Mayo",
  "Junio",
  "Julio",
  "Agosto",
  "Septiembre",
  "Octubre",
  "Noviembre",
  "Diciembre",
];

const days = ["Dom", "Lun", "Mar", "Mier", "Jue", "Vie", "Sab"];

// get current date
const date = new Date();

// get current month
let currentMonth = date.getMonth();

// get current year
let currentYear = date.getFullYear();

// function to render days
function renderCalendar() {
  // get prev month current month and next month days
  date.setDate(1);
  const firstDay = new Date(currentYear, currentMonth, 1);
  const lastDay = new Date(currentYear, currentMonth + 1, 0);
  const lastDayIndex = lastDay.getDay();
  const lastDayDate = lastDay.getDate();
  const prevLastDay = new Date(currentYear, currentMonth, 0);
  const prevLastDayDate = prevLastDay.getDate();
  const nextDays = 7 - lastDayIndex - 1;

  // update current year and month in header
  month.innerHTML = `${months[currentMonth]} ${currentYear}`;

  // update days html
  let days = "";

  // prev days html
  for (let x = firstDay.getDay(); x > 0; x--) {
    days += `<div class="day prev">${prevLastDayDate - x + 1}</div>`;
  }

  // current month days
  for (let i = 1; i <= lastDayDate; i++) {
    // check if its today then add today class
    if (
      i === new Date().getDate() &&
      currentMonth === new Date().getMonth() &&
      currentYear === new Date().getFullYear()
    ) {
      // if date month year matches add today
      days += `<div class="day today">${i}</div>`;
    } else {
      //else dont add today
      days += `<div class="day ">${i}</div>`;
    }
  }

  // next MOnth days
  for (let j = 1; j <= nextDays; j++) {
    days += `<div class="day next">${j}</div>`;
  }

  // run this function with every calendar render
  hideTodayBtn();
  daysContainer.innerHTML = days;
}

renderCalendar();

nextBtn.addEventListener("click", () => {
  // increase current month by one
  currentMonth++;
  if (currentMonth > 11) {
    // if month gets greater that 11 make it 0 and increase year by one
    currentMonth = 0;
    currentYear++;
  }
  // rerender calendar
  renderCalendar();
});

// prev monyh btn
prevBtn.addEventListener("click", () => {
  // increase by one
  currentMonth--;
  // check if let than 0 then make it 11 and deacrease year
  if (currentMonth < 0) {
    currentMonth = 11;
    currentYear--;
  }
  renderCalendar();
});

// go to today
todayBtn.addEventListener("click", () => {
  // set month and year to current
  currentMonth = date.getMonth();
  currentYear = date.getFullYear();
  // rerender calendar
  renderCalendar();
});

// lets hide today btn if its already current month and vice versa

function hideTodayBtn() {
  if (
    currentMonth === new Date().getMonth() &&
    currentYear === new Date().getFullYear()
  ) {
    todayBtn.style.display = "none";
  } else {
    todayBtn.style.display = "flex";
  }
}

</script>