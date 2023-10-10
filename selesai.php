<?php
include_once("config/server.php");


$qrjmles = mysqli_query($koneksi, "SELECT * FROM cbt_ljk WHERE token ='A' AND user_jawab ='tri' AND kd_soal ='X_BIndo' AND jns_soal = 'E';");
$qrjmlpg = mysqli_query($koneksi, "SELECT * FROM cbt_ljk WHERE token ='A' AND user_jawab ='tri' AND kd_soal ='X_BIndo' AND jns_soal != 'E';");
$qrdtpg = mysqli_query($koneksi, "SELECT SUM(nil_pg) AS Benar FROM cbt_ljk WHERE token ='A' AND user_jawab ='tri' AND kd_soal ='X_BIndo' AND jns_soal != 'E';");
$dtnlpg  = mysqli_fetch_array($qrdtpg);
$jmldtpg  = mysqli_num_rows($qrjmlpg);
$jmldtes  = mysqli_num_rows($qrjmles);

$bnr  = $dtnlpg['Benar'];
$slh  = $jmldtpg - $dtnlpg['Benar'];
$esy  = $jmldtes;
$bns  = $_GET['jums'] - $esy - $jmldtpg;
$nil  = $bnr / $_GET['jums'] * 100;

?>


<div class="row m-0 justify-content-center p-3">
  <div class="col-md-6 col-12">
    <div class="card text-center fs-6 shadow-lg my-md-5 m-0">
      <div class="card-header fs-4">
        Konfirmasi Tes
      </div>
      <div class="card-body">
        <?php
        if ($_GET['stsnil'] != "T") {
          # code...
        ?>
          <div class="row mx-md-5 m-0 mb-4" style="border-radius: 7px;">
            <div class="col-12 bg-dark-subtle fw-bolder py-2 fs-5">Nilai</div>
            <div class="col-12 bg-info-subtle fw-bolder py-2 display-1" style="font-family: Aladin;"><?php echo $nil ?></div>
            <div class="col-md-6 col-12 bg-success-subtle p-3 fs-5 fw-medium">Benar : <?php echo $bnr ?></div>
            <div class="col-md-6 col-12 bg-danger-subtle p-3 fs-5 fw-medium">Salah : <?php echo $slh ?></div>
            <?php
            if ($esy != "0") {
            ?>
              <div class="col-md-6 col-12 bg-primary-subtle p-3 fs-5 fw-medium">Esai : <?php echo $esy ?></div>
            <?php
            }
            if ($bns != "0") {
            ?>
              <div class="col-md-6 col-12 bg-danger text-white p-3 fs-5 fw-medium">Ilegal : <?php echo $bns ?></div>
          </div>
      <?php }
          } ?>
      <p class="card-text">Terimakasih telah berpartisipasi dalam tes ini.
        Silahkan klik tombol Selesai untuk mengakhiri test.</p>

      </div>
      <div class="card-footer text-body-secondary">
        <button class="btn btn-outline-success" id="selesai">Selesai</button>
        <button class="btn btn-outline-danger" id="kembali">Kembali</button>
      </div>
    </div>
  </div>
</div>
<script src="node_modules/jquery/dist/jquery.min.js"></script>
<script>
$(document).ready(function(){
  $("#selesai").click(function(){
    window.location.replace('/tbk/logout.php');
  })
})
</script>
<script>
$(document).ready(function(){
  $("#kembali").click(function(){
    window.location.reload();
  })
})
</script>