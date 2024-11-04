function onScanSuccess(decodedText, decodedResult) {
  const resultDisplay = document.getElementById("result");
  const usuarioId = 0;

  if (decodedText.includes("SalidaRegistroInfoteca")) {
    resultDisplay.innerText = "Código de salida aceptado";
    html5QrcodeScanner.clear();
    fetch("registroQRsalida.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
      },
      body: `mensajeDecodificado=${encodeURIComponent(
        decodedText
      )}&usuario=${encodeURIComponent(usuarioId)}`,
    })
      .then((response) => response.text())
      .then((data) => {
        console.log(data);
        window.location.href = "/registroinfoteca/pagina_principal.php";
      })
      .catch((error) => {
        console.error("Error al enviar el código QR:", error);
      });
  } else if (decodedText.includes("RegistroInfoteca")) {
    resultDisplay.innerText = "Código de entrada aceptado";
    html5QrcodeScanner.clear();
    fetch("registroQRentrada.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
      },
      body: `mensajeDecodificado=${encodeURIComponent(
        decodedText
      )}&usuario=${encodeURIComponent(usuarioId)}`,
    })
      .then((response) => response.text())
      .then((data) => {
        console.log(data);
        window.location.href = "/registroinfoteca/lockers/lockers.php";
      })
      .catch((error) => {
        console.error("Error al enviar el código QR:", error);
      });
  }  else {
    resultDisplay.innerText = "Código no aceptado";
  }
}

var html5QrcodeScanner = new Html5QrcodeScanner("reader", {
  fps: 10,
  qrbox: 250,
});
html5QrcodeScanner.render(onScanSuccess);
