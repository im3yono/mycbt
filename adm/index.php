<?php
include_once "../config/server.php";

$info   = mysqli_fetch_array(mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM info"));
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $info['nmpt'] ?></title>
  <link rel="shortcut icon" href="../img/<?php echo $info['fav'] ?>" type="image/x-icon">

  <link rel="stylesheet" href="../vendor/twbs/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="../vendor/twbs/bootstrap-icons/font/bootstrap-icons.css">
  <script src="../vendor/twbs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="style.css">

</head>

<body style="overflow-y: hidden;">
  <nav class="navbar navbar-expand-lg shadow bg-dark sticky-top">
    <div class="container-fluid">
      <a class="navbar-brand text-white" href="#">
        <button class="navbar-toggler bg-light-subtle" type="button" data-bs-toggle="offcanvas" data-bs-target="#mnitem" aria-expanded="true" aria-controls="collapseWidthExample">
          <span class="navbar-toggler-icon"></span>
        </button>
        <img src="../img/<?php echo $info['fav'] ?>" alt="Logo" width="30" height="24" class="d-inline-block align-text-top">
        IM3_CBT
      </a>
      <!-- <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#akun" aria-controls="akun">Akun</button> -->
      <div class="">
      <label class="text-light fs-5 mx-3" id="jam"></label>
        <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
          Akun
        </button>
        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-start fs-6">
          <li class="px-2">Admin</li>
          <li class="px-2">Menu item</li>
          <li><a class="dropdown-item" href="#"><i class="bi bi-box-arrow-left"></i> Keluar</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <div class="offcanvas offcanvas-end" tabindex="-1" id="akun" aria-labelledby="akunLabel" style="width: 200px;">
    <div class="offcanvas-header">
      <h5 class="offcanvas-title" id="akunLabel">Panel Admin</h5>
    </div>
    <div class="offcanvas-body">
      Nama Admin <br>
      level admin <br>
      logout <br>
    </div>
  </div>

  <div class="container-fluid">
    <div class="row">
      <!-- <div class="row m-1 p-1">nbnb</div> -->
      <div class="offcanvas-lg offcanvas-start bg-dark" id="mnitem" style="width: 240px;" tabindex="-1" aria-labelledby="mnitemlbl">
        <div class="offcanvas-header">
          <h5 class="text-white" id="mnitemlbl">IM3_CBT</h5>
        </div>
        <div class="offcanvas-body">
          <div class="col pt-1 mnu fw-bolder position-fixed">
            <ul class="nav list-group bg-dark py-2 gap-1">
              <li class="nav-item">
                <a href="#" class=" list-group-item list-group-item-action list-group-item-dark">
                  <i class="bi bi-house"></i> Dashboard
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class=" list-group-item list-group-item-action list-group-item-dark">
                  <i class="bi bi-info-circle"></i> Identitas
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class=" list-group-item list-group-item-action list-group-item-dark">
                  <i class="bi bi-people"></i> Managemen User
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class=" list-group-item list-group-item-action list-group-item-dark">
                  <i class="bi bi-list-task"></i> Data Kelas
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class=" list-group-item list-group-item-action list-group-item-dark">
                  <i class="bi bi-journals"></i> Data Mapel
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class=" list-group-item list-group-item-action list-group-item-dark">
                  <i class="bi bi-person-lines-fill"></i> Data Peserta
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class=" list-group-item list-group-item-action list-group-item-dark">
                  <i class="bi bi-journal-text"></i> Daftar Soal
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class=" list-group-item list-group-item-action list-group-item-dark">
                  <i class="bi bi-file-earmark-arrow-up"></i> File Pendukung
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class=" list-group-item list-group-item-action list-group-item-dark">
                  <i class="bi bi-person-vcard"></i> Kartu Login
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class=" list-group-item list-group-item-action list-group-item-dark">
                  <i class="bi bi-printer"></i> Daftar Hadir
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class=" list-group-item list-group-item-action list-group-item-dark">
                  <i class="bi bi-printer"></i> Berita Acara
                </a>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <br>
      <div class="col mb-4 pos bg-white pos">
        <div class="m-2">
          <?php include_once("page/md.php") ?>
        </div>
      </div>
    </div>
  </div>
  <!-- <footer class="bg-dark p-1 footer" style="position: fixed;">
    <div class="text-white"><?php include_once("../config/about.php") ?></div>
  </footer> -->
</body>

</html>



<!-- === JavaScript === -->
<script src="../aset/time.js"></script>