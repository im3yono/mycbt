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
    max-width: 330px;
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
  <div class="container text-center" style="margin-top: -50px;">
    <div class="row justify-content-center mx-3">
      <div class="card shadow-lg" style="width: 400px;">
        <main class="form-signin w-100 m-auto">
          <form action="konfirmasi.php" method="post">
            <h2>Login Ujian</h2>
            <p>Silahkan login dengan username dan password yang telah anda miliki</p>
            <?php
            if (isset($_GET['pesan'])) {
              if ($_GET['pesan'] == "gagal") {
                // echo "<script>alert('Username dan Password tidak sesuai  !');history.go(-1)</script";
                echo '<div class="alert alert-danger alert-dismissible fade show form-control-sm" role="alert">
              Username dan Password <br> tidak sesuai ! <button type="button" class="btn-close" data-bs-dismiss="alert aria-lable="Close"></button></div>';
                echo '<meta http-equiv="refresh" content="3;url=login.php">';
              } elseif ($_GET['pesan'] == "id") {
                echo '<div class="alert alert-danger alert-dismissible fade show form-control-sm" role="alert">
              Id Karyawan belum terdaftar ! <button type="button" class="btn-close" data-bs-dismiss="alert aria-lable="Close"></button></div>';
                // echo '<meta http-equiv="refresh" content="3;url=login.php">';
              } elseif ($_GET['pesan'] == "ck") {
                echo '<div class="alert alert-success alert-dismissible fade show form-control-sm" role="alert">
              Id Karyawan Sudah Aktif <br> Silahkan Login ! <button type="button" class="btn-close" data-bs-dismiss="alert aria-lable="Close"></button></div>';
                // echo '<meta http-equiv="refresh" content="3;url=login.php">';
              } elseif ($_GET['pesan'] == "off") {
                echo '<div class="alert alert-success alert-dismissible fade show form-control-sm" role="alert">
              Akun Anda Belum Aktif <br> Hubungi Admin ! <button type="button" class="btn-close" data-bs-dismiss="alert aria-lable="Close"></button></div>';
                // echo '<meta http-equiv="refresh" content="3;url=login.php">';
              }
            }
            ?>
            <div class="form-floating">
              <input type="text" class="form-control" id="username" name="username" placeholder="Username" required>
              <label for="username">Username</label>
            </div>
            <div class="form-floating">
              <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
              <label for="password">Password</label>
            </div>

            <!-- <div class="checkbox mb-3">
              <label>
                <input type="checkbox" value="remember-me"> Remember me
              </label>
            </div> -->
            <button class="w-100 btn btn-lg btn-primary" type="submit" name="login">Sign in</button>
            <p class="mt-5 mb-3 ">&copy;Create 2022
              <?php if (date('Y') > 2022) {
                echo "- " . date('Y');
              } ?>
              by Triyono<br>
              <!-- supported by <img class="" src="img/bootstrap-logo.png" alt="" width="25" height="25"> -->
            </p>
          </form>
        </main>
      </div>
    </div>
  </div>
</body>

</html>