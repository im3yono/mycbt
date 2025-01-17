// === Time === //
// <h1 style="font-size: 120px; font-family: arial;" id="jam"></h1>
window.onload = function () {
  jam();
};

function jam() {
  // Jam Server
  var xmlHttp;

  function srvTime() {
    try {
      //FF, Opera, Safari, Chrome
      xmlHttp = new XMLHttpRequest();
    } catch (err1) {
      //IE
      try {
        xmlHttp = new ActiveXObject("Msxml2.XMLHTTP");
      } catch (err2) {
        try {
          xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
        } catch (eerr3) {
          //AJAX not supported, use CPU time.
          alert("AJAX not supported");
        }
      }
    }
    xmlHttp.open("HEAD", window.location.href.toString(), false);
    xmlHttp.setRequestHeader("Content-Type", "text/html");
    xmlHttp.send("");
    return xmlHttp.getResponseHeader("Date");
  }

  var st = srvTime();

  var e = document.getElementById("jam"),
    d = new Date(st),
    h,
    m,
    s;
  h = set(d.getHours());
  m = set(d.getMinutes());
  s = set(d.getSeconds());

  e.innerHTML = h + ":" + m + ":" + s + " Waktu Server";

  setTimeout("jam()", 1000);
}

function set(e) {
  e = e < 10 ? "0" + e : e;
  return e;
}

function waktuMundur(id, datetime) {
  // Tentukan tanggal tujuan
  const targetDate = new Date(datetime).getTime();

  // Perbarui hitungan setiap detik
  const countdownInterval = setInterval(() => {
    const now = new Date().getTime();
    const distance = targetDate - now;

    // Hitung hari, jam, menit, dan detik
    const days = Math.floor(distance / (1000 * 60 * 60 * 24));
    const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    const seconds = Math.floor((distance % (1000 * 60)) / 1000);

    // Tampilkan hasil
    document.getElementById(id).innerHTML = `${days} Hari ${hours} Jam ${minutes} Menit ${seconds} Detik`;

    // Jika waktu habis
    if (distance < 0) {
      clearInterval(countdownInterval);
      document.getElementById(id).innerHTML = "Waktu Habis!";
    }
  }, 1000);
}
