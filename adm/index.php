<?php
include_once "../config/server.php";
include_once "../config/time_date.php";

$info   = mysqli_fetch_array(mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM info"));
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $info['nmpt'] ?></title>
  <link rel="shortcut icon" href="../img/<?php if($info['fav']!=null){echo $info['fav'];}else{echo"fav.png";} ?>" type="image/x-icon">

  <link rel="stylesheet" href="../vendor/twbs/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="../vendor/twbs/bootstrap-icons/font/bootstrap-icons.css">
  <script src="../vendor/twbs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="style.css">

  <script src="../node_modules/sweetalert2/dist/sweetalert2.min.js"></script>
  <link rel="stylesheet" href="../node_modules/sweetalert2/dist/sweetalert2.min.css">
  <script src="../node_modules/jquery/dist/jquery.min.js"></script>
  <script src="../aset/time.js"></script>

</head>

<body style="overflow-y: hidden;">
  <nav class="navbar navbar-expand-lg shadow bg-dark sticky-top flex-auto" style="font-family: Alkatra;">
    <div class="container-fluid text-center">
      <a class="navbar-brand text-white" href="#">
        <button class="navbar-toggler bg-light-subtle" type="button" data-bs-toggle="offcanvas" data-bs-target="#mnitem" aria-expanded="true" aria-controls="collapseWidthExample">
          <span class="navbar-toggler-icon"></span>
        </button>
        <img src="../img/<?php if($info['fav']!=null){echo $info['fav'];}else{echo"fav.png";}?>" alt="Logo" width="30" height="24" class="d-inline-block align-text-top">
        IM3_TBK
      </a>
      <div class="">
        <label class="text-light fs-md-4 fs-5 mx-3" id="jam"></label>
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

  <div class="container-fluid">
    <div class="row">
      <!-- <div class="row m-1 p-1">nbnb</div> -->
      <div class="offcanvas-lg offcanvas-start bg-dark ofx ofx-md " id="mnitem" tabindex="-1" aria-labelledby="mnitemlbl">
        <div class="offcanvas-header">
          <h5 class="text-white" id="mnitemlbl">IM3_CBT</h5>
        </div>
        <div class="offcanvas-body">
          <div class="col pt-1 px-1 mnu fw-bolder position-fixed">
            <ul class="nav mnu-itm mnu-md-itm list-group bg-dark py-2 gap-1">
              <li class="nav-item">
                <a href="?" class="dsh list-group-item ">
                  <i class="bi bi-house"></i> Dashboard
                </a>
              </li>
              <li class="nav-item ">
                <a class=" list-group-item " data-bs-toggle="collapse" href="#pf">
                  <div class="row ps-2">&nbsp;Profil<div class="col text-end"><i class="bi bi-chevron-down"></i></div>
                  </div>
                </a>
                <div class="collapse ps-3" id="pf">
                  <ul class="nav list-group bg-dark gap-1 pt-1">
                    <li class="nav-item">
                      <a href="?md=id" class="iden list-group-item ">
                        <i class="bi bi-info-circle"></i> Identitas
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="?md=usr" class="usr list-group-item ">
                        <i class="bi bi-people"></i> Managemen User
                      </a>
                    </li>
                  </ul>
                </div>
              </li>
              <li class="nav-item ">
                <a class=" list-group-item " data-bs-toggle="collapse" href="#adm">
                  <div class="row ps-2">&nbsp;Administrasi <div class="col text-end"><i class="bi bi-chevron-down"></i></div>
                  </div>
                </a>
                <div class="collapse ps-3" id="adm">
                  <ul class="nav list-group bg-dark gap-1 pt-1">
                    <li class="nav-item">
                      <a href="?md=kls" class="kls list-group-item">
                        <i class="bi bi-list-task"></i> Data Kelas
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="?md=sis" class="sis list-group-item ">
                        <i class="bi bi-person-lines-fill"></i> Data Peserta
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="?md=mpl" class="mapel list-group-item ">
                        <i class="bi bi-journals"></i> Data Mapel
                      </a>
                    </li>
                  </ul>
                </div>
              </li>
              </li>
              <li class="nav-item ">
                <a class=" list-group-item " data-bs-toggle="collapse" href="#ps">
                  <div class="row ps-2">&nbsp;Paket Soal <div class="col text-end"><i class="bi bi-chevron-down"></i></div>
                  </div>
                </a>
                <div class="collapse ps-3" id="ps">
                  <ul class="nav list-group bg-dark gap-1 pt-1">
                    <li class="nav-item">
                      <a href="?md=soal" class="soal list-group-item ">
                        <i class="bi bi-journal-text"></i> Bank Soal
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="?md=f_soal" class="f_soal list-group-item ">
                        <i class="bi bi-file-earmark-arrow-up"></i> File Pendukung
                      </a>
                    </li>
                  </ul>
                </div>
              </li>
              </li>
              <li class="nav-item ">
                <a class=" list-group-item " data-bs-toggle="collapse" href="#pr">
                  <div class="row ps-2">&nbsp;Perlengkapan <div class="col text-end"><i class="bi bi-chevron-down"></i></div>
                  </div>
                </a>
                <div class="collapse ps-3" id="pr">
                  <ul class="nav list-group bg-dark gap-1 pt-1">
                    <li class="nav-item">
                      <a href="?md=pr_kartu" class="kartu list-group-item ">
                        <i class="bi bi-person-vcard"></i> Kartu Login
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="?md=pr_hadir" class="hadir list-group-item ">
                        <i class="bi bi-printer"></i> Daftar Hadir
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="?md=pr_brita" class="berita list-group-item ">
                        <i class="bi bi-printer"></i> Berita Acara
                      </a>
                    </li>
                  </ul>
                </div>
              </li>
              <li class="nav-item ">
                <a class=" list-group-item " data-bs-toggle="collapse" href="#uj">
                  <div class="row ps-2">&nbsp;Ujian <div class="col text-end"><i class="bi bi-chevron-down"></i></div>
                  </div>
                </a>
                <div class="collapse ps-3" id="uj">
                  <ul class="nav list-group bg-dark gap-1 pt-1">
                    <li class="nav-item">
                      <a href="?md=uj_set" class="setuj list-group-item ">
                        <i class="bi bi-clipboard2-check"></i> Aktivasi Ujian
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="?md=uj_jdwl" class="jdwluj list-group-item ">
                        <i class="bi bi-calendar2-range"></i> Jadwal Ujian
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="?md=uj_rwyt" class="rwytuj list-group-item ">
                        <i class="bi bi-clock-history"></i> Riwayat Ujian
                      </a>
                    </li>
                  </ul>
                </div>
              </li>
              <li class="nav-item">
                <a href="?md=df_uji" class="dfuji list-group-item">
                  <i class="bi bi-person-vcard"></i> Daftar Ujian
                </a>
              </li>
              <li class="nav-item">
                <a href="?md=rst_uji" class="rstuji list-group-item ">
                  <i class="bi bi-printer"></i> Reset Peserta
                </a>
              </li>
              <li class="nav-item ">
                <a class=" list-group-item " data-bs-toggle="collapse" href="#hasil">
                  <div class="row ps-2">&nbsp;Hasil <div class="col text-end"><i class="bi bi-chevron-down"></i></div>
                  </div>
                </a>
                <div class="collapse ps-3" id="hasil">
                  <ul class="nav list-group bg-dark gap-1 pt-1">
                    <li class="nav-item">
                      <a href="?md=nilai" class="nilai list-group-item ">
                        <i class="bi bi-123"></i> Nilai
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="?md=rekap" class="rekap list-group-item ">
                        <i class="bi bi-card-list"></i> Rekap
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="?md=anls" class="anls list-group-item ">
                        <i class="bi bi-list-columns-reverse"></i> Analisa
                      </a>
                    </li>
                  </ul>
                </div>
              </li>


            </ul>
          </div>
        </div>
      </div>
      <div class="col mb-4 pos bg-white pos">
        <!-- <iframe src="page/md.php" frameborder="0" width="100%" height="100%"></iframe> -->
        <div class="m-0" id="warper">
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
<!-- <script src="../aset/ckeditor/build/ckeditor.js"></script> -->
<script>
  
</script>