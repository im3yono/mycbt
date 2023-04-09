<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Aplikasi UNBK</title>
  <link rel="shortcut icon" href="img/logo_sma.png" type="image/x-icon">

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
</style>

<body>
  <div class="head">
    <div class="col-12 text-center">
      <img class="mt-5 img-fluid" src="img/logo.png" alt="">
    </div>
  </div>
  <div class="container-fluid" style="margin-top: -50px;font-family: Times New Roman;">
    <div class="row gap-2 justify-content-center mx-3">
      <div class="card shadow-lg col-md-4">
        <main class="form-signin w-100 m-auto">
            <h4 class="">BIODATA</h4>
            <img src="img/noavatar.png" alt="" class="img-thumbnail" width="140px">
          <div class="col">
            Nama Peserta <br>
            
          </div>
        </main>
      </div>
      <div class="card col shadow-lg">
        <main class="form-signin w-100 m-auto">
          <h4>DATA UJIAN</h4>
        </main>
      </div>
    </div>
  </div>
</body>

</html>