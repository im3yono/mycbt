<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Konfirmasi | Aplikasi UNBK</title>
	<link rel="shortcut icon" href="../img/<?php if($info['fav']!=null){echo $info['fav'];}else{echo"fav.png";} ?>" >

  <link rel="stylesheet" href="vendor/twbs/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="vendor/twbs/bootstrap-icons/font/bootstrap-icons.css">
  <script src="vendor/twbs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</head>
<!-- CSS Kostum -->
<style>
  html,
  body {
    height: 100%;
  }

  body {
    /* display: flex; */
    align-items: center;
    /* padding-top: 40px; */
    padding-bottom: 40px;
    background-image: url('img/swirl_pattern.png');
    /*  background-repeat: no-repeat;
      background-size: 100% 100%; */
    /* background-color: aquamarine; */

  }

  .form-signin {
    padding: 15px;
  }

  .form-signin .form-floating:focus-within {
    z-index: 2;
  }

  .form-signin input[type="text"] {
    margin-bottom: -1px;
    border-bottom-right-radius: 0;
    border-bottom-left-radius: 0;
  }

  .form-signin input[type="password"] {
    margin-bottom: 10px;
    border-top-left-radius: 0;
    border-top-right-radius: 0;
  }

  .head {
    height: 200px;
    background-image: url(img/header-bg.png);
  }

  .img {
    border-radius: 50%;
    width: 270px;
    height: 270px;
  }

  .time {
    border: 1px solid;
    border-color: #0099ff;
    background-color: #0099ff;
    width: 2fr;
    border-radius: 25px;
    margin: 3px;
    padding: 3px;
    padding-right: 10px;
    padding-left: 10px;
    font-family: Arial;
    font-size: 18px;
  }
</style>

<body>
  <div class="head">
    <div class="col-12 text-center">
      <img class="mt-5 img-fluid" src="img/logo.png" alt="">
    </div>
  </div>
  <div class="container-fluid pb-md-0 pb-5" style="margin-top: -50px;font-family: Times New Roman;">
    <div class="row gap-4 justify-content-center mx-3">
      <div class="card shadow-lg col-lg-3 p-3 gap-3 fs-5">
        <h4 class="col-12 text-center border-bottom">Konfirmasi Data Peserta</h4>
        <div class="col-auto text-center">
          <img src="img/noavatar.png" alt="" class="img-thumbnail img">
        </div>
        <label class="col-12 text-center" value="Nama">Nama</label>
        <label class="col-12 text-center" value="NIS">12346678</label>
      </div>
      <div class="card col shadow-lg p-3 gap-2">
        <h4 class="col-12 text-center border-bottom mb-3">DATA PESERTA</h4>
        <div class="col-12 text-center mb-2"><label class="time me-2" id="lm_ujian">Ujian dimulai</label></div>
        <div class="row justify-content-evenly gap-1 fs-5">
          <div class="col-12 col-md-5 mb-2">
            <label for="nm">Nama Peserta</label>
            <input type="text" id="nm" name="nm" class="form-control" value="Nama" readonly>
          </div>
          <div class="col-12 col-md-5 mb-2">
            <label for="usr">Username</label>
            <input type="text" id="usr" name="usr" class="form-control" value="Username" readonly>
          </div>
          <div class="col-12 col-md-5 mb-2">
            <label for="sts">Status Peserta</label>
            <input type="text" id="sts" name="sts" class="form-control" value="Nama" readonly>
          </div>
          <div class="col-12 col-md-5 mb-2">
            <label for="jns">Jenis Kelamin</label>
            <input type="text" id="jns" name="jns" class="form-control" value="Nama" readonly>
          </div>
          <div class="col-12 col-md-5 mb-2">
            <label for="sts_uji">Status Ujian</label>
            <input type="text" id="sts_uji" name="sts_uji" class="form-control" value="Nama" readonly>
          </div>
          <div class=" mb-3 col-md-5 col-12">
            <form action="mulai.php" method="post">
              <div class="form-floating">
                <input type="text" class="form-control mb-2" id="token" name="token" placeholder="Token" required disabled>
                <label for="token">Token</label>
                <button class="btn btn-primary" type="submit" id="submit" disabled>Submit</button>
                <span class="ms-4 badge bg-primary fs-6" hidden id="tk">KMAHDI</span>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <footer>
    <div class="col-12 bg-dark text-white text-center fixed-bottom" style="height: 30px;"><?php include_once("config/about.php") ?></div>
  </footer>
</body>

</html>


<!-- === JavaScript -->
<script>
  // Mengatur waktu akhir perhitungan mundur
  var countDownDate = new Date("2023-04-13 19:56:00").getTime();


  // Memperbarui hitungan mundur setiap 1 detik
  var x = setInterval(function() {

    // Untuk mendapatkan tanggal dan waktu hari ini
    // var now = new Date().getTime();
    // Jam Server
    var xmlHttp;

    function srvTime() {
      try {
        //FF, Opera, Safari, Chrome
        xmlHttp = new XMLHttpRequest();
      } catch (err1) {
        //IE
        try {
          xmlHttp = new ActiveXObject('Msxml2.XMLHTTP');
        } catch (err2) {
          try {
            xmlHttp = new ActiveXObject('Microsoft.XMLHTTP');
          } catch (eerr3) {
            //AJAX not supported, use CPU time.
            alert("AJAX not supported");
          }
        }
      }
      xmlHttp.open('HEAD', window.location.href.toString(), false);
      xmlHttp.setRequestHeader("Content-Type", "text/html");
      xmlHttp.send('');
      return xmlHttp.getResponseHeader("Date");
    }

    var st = srvTime();
    var now = new Date(st);

    // Temukan jarak antara sekarang dan tanggal hitung mundur
    var distance = countDownDate - now;

    // Perhitungan waktu untuk hari, jam, menit dan detik
    var days = Math.floor(distance / (1000 * 60 * 60 * 24));
    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    var seconds = Math.floor((distance % (1000 * 60)) / 1000);

    // Keluarkan hasil dalam elemen dengan id = "lm_ujian"
    if (days != "0") {
      document.getElementById("lm_ujian").innerHTML = days + " Hari, " + hours + ":" + minutes + ":" + seconds;
    } else {
      document.getElementById("lm_ujian").innerHTML = hours + ":" + minutes + ":" + seconds;
    }

    // Jika hitungan mundur selesai, tulis beberapa teks 
    if (distance < 0) {
      clearInterval(x);
      document.getElementById("lm_ujian").innerHTML = "Silahkan Masukkan Token Untuk Mengikuti Ujian";
      document.getElementById("lm_ujian").style.backgroundColor = "#00ff00";
      document.getElementById("lm_ujian").style.borderColor = "#00ff00";
      document.getElementById("token").disabled = false;
      document.getElementById("submit").disabled = false;
      document.getElementById("tk").hidden = false;
    }
  }, 1000);
</script>