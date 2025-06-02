// === Time === //
// <h1 style="font-size: 120px; font-family: arial;" id="jam"></h1>
window.onload = function () {
  jam();
};

// Jam Server menggunakan AJAX old
// function jam() {
//   // Jam Server
//   var xmlHttp;

//   function srvTime() {
//     try {
//       //FF, Opera, Safari, Chrome
//       xmlHttp = new XMLHttpRequest();
//     } catch (err1) {
//       //IE
//       try {
//         xmlHttp = new ActiveXObject("Msxml2.XMLHTTP");
//       } catch (err2) {
//         try {
//           xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
//         } catch (err3) {
//           //AJAX not supported, use CPU time.
//           alert("AJAX not supported");
//           return new Date().toUTCString();
//         }
//       }
//     }
//     if (!xmlHttp) {
//       // If xmlHttp is still undefined, fallback to local time
//       return new Date().toUTCString();
//     }
//     xmlHttp.open("HEAD", window.location.href.toString(), false);
//     xmlHttp.setRequestHeader("Content-Type", "text/html");
//     xmlHttp.send("");
//     return xmlHttp.getResponseHeader("Date");
//   }

//   var st = srvTime();

//   var e = document.getElementById("jam"),
//     d = new Date(st),
//     h,
//     m,
//     s;
//   h = set(d.getHours());
//   m = set(d.getMinutes());
//   s = set(d.getSeconds());

//   e.innerHTML = h + ":" + m + ":" + s + " Waktu Server";

//   setTimeout("jam()", 1000);
// }

// Jam Server menggunakan AJAX async
function set(x) {
  return x < 10 ? "0" + x : x;
}

function srvTimeAsync() {
  return new Promise((resolve, reject) => {
    let xmlHttp;
    try {
      xmlHttp = new XMLHttpRequest();
    } catch (err1) {
      try {
        xmlHttp = new ActiveXObject("Msxml2.XMLHTTP");
      } catch (err2) {
        try {
          xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
        } catch (err3) {
          resolve(new Date().toUTCString());
          return;
        }
      }
    }

    if (!xmlHttp) {
      resolve(new Date().toUTCString());
      return;
    }

    xmlHttp.open("HEAD", window.location.href.toString(), true); // async
    xmlHttp.onreadystatechange = function () {
      if (xmlHttp.readyState === 4) {
        const serverDate = xmlHttp.getResponseHeader("Date");
        if (serverDate) {
          resolve(serverDate);
        } else {
          resolve(new Date().toUTCString());
        }
      }
    };
    xmlHttp.setRequestHeader("Content-Type", "text/html");
    xmlHttp.send();
  });
}

async function jam() {
  const st = await srvTimeAsync();
  const d = new Date(st);
  const e = document.getElementById("jam");

  function updateClock() {
    d.setSeconds(d.getSeconds() + 1); // Simulasi detik berjalan
    const h = set(d.getHours());
    const m = set(d.getMinutes());
    const s = set(d.getSeconds());
    // e.innerHTML = `${h}:${m}:${s} Waktu Server`;
    e.innerHTML = `Server ${h}:${m}:${s}`;
    setTimeout(updateClock, 1000);
  }

  updateClock();
}

jam();

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
