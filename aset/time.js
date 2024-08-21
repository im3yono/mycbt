// === Time === //
// <h1 style="font-size: 120px; font-family: arial;" id="jam"></h1>
window.onload = function () {
  jam();
};

function jam() {
  var e = document.getElementById("jam"),
    d = new Date(),h,m,s;
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

// var x = setInterval(function () {
//   // Untuk mendapatkan tanggal dan waktu hari ini
//   // var now = new Date().getTime();
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
//         } catch (eerr3) {
//           //AJAX not supported, use CPU time.
//           alert("AJAX not supported");
//         }
//       }
//     }
//     xmlHttp.open("HEAD", window.location.href.toString(), false);
//     xmlHttp.setRequestHeader("Content-Type", "text/html");
//     xmlHttp.send("");
//     return xmlHttp.getResponseHeader("Date");
//   }

//   var st = srvTime();
//   var date = new Date(st);

//   // Perhitungan waktu untuk jam, menit dan detik
//   // var days = Math.floor(distance / (1000 * 60 * 60 * 24));
//   // var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
//   // var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
//   // var seconds = Math.floor((distance % (1000 * 60)) / 1000);

//   var tahun = date.getFullYear();
//   var bulan = date.getMonth();
//   var tanggal = date.getDate();
//   var hari = date.getDay();
//   var jam = date.getHours();
//   var menit = date.getMinutes();
//   var detik = date.getSeconds();

// //   let angka = 19;
// //   let cetak = angka.padStart(3,"0")
// //   //artinya 3 merupakan banyak angkanya dan diganti dengan "0"
// //   console.log(cetak);
// //   //hasilnya maka seperti : 019

// let menit2 = menit.padStart(2,"0")

// // var MyDate = new Date();
// // var MyDateString;
// // MyDate.setDate(MyDate.getDate() + 20);
// // MyDateString = ('0' + MyDate.getDate()).slice(-2) + '/'
// //              + ('0' + (MyDate.getMonth()+1)).slice(-2) + '/'
// //              + MyDate.getFullYear();

//   // document.getElementById("jam").innerHTML = hours + ":" + minutes + ":" + seconds + " Waktu Server";
//   document.getElementById("jam").innerHTML = jam + ":" + menit + ":" + detik + " Waktu Server";
//   // document.getElementById("jam").innerHTML = distance + " Waktu Server";
// }, 1000);
