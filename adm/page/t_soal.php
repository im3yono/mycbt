<?php
include_once("../config/server.php");

$kds  = $_GET['kds'];
$dt = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM cbt_pktsoal WHERE cbt_pktsoal.kd_soal ='$kds'"));
$dts = mysqli_fetch_array(mysqli_query($koneksi, "SELECT max(id_soal)AS id FROM cbt_soal WHERE cbt_soal.kd_soal ='$kds'"));
$idts = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM cbt_soal WHERE cbt_soal.id_soal ='$dts[id]'"));


?>

<style>
  .custom-popover {
    --bs-popover-bg: var(--bs-warning);
  }

  .hide {
    display: none;
  }
</style>

<div class="container-fluid p-0">
  <div class="row p-2 border-bottom fs-3 mb-4 shadow-sm bg-light">
    <div class="col-auto "><a href="?md=esoal&ds=<?php echo $dt[0]; ?>" class="btn btn-outline-dark"><i class="bi bi-arrow-left"></i> Kembali</a></div>
    <div class="col">Tambah Soal</div>
  </div>
  <div class="row m-2">
    <h5>ID Soal <span class="badge bg-primary"><?php echo $dts['id'] + 1 ?></span></h5>
  </div>
  <div class="row m-2 g-2">
    <div class="col-auto">
      <div class="input-group">
        <label for="nos" class="input-group-text bg-primary text-white">No.</label>
        <input id="nos" name="nos" class="form-control" type="text" style="max-width: 80px;" value="<?php echo $idts['no_soal'] + 1 ?>">
      </div>
    </div>
    <div class="col-auto">
      <div class="input-group">
        <label for="jnss" class="input-group-text bg-primary text-white">Jenis Soal</label>
        <select class="form-select" id="jns_soal" name="jns_soal">
          <option value="G">Pilihan Ganda</option>
          <option value="E" onselect="hideOP()">Esai</option>
        </select>
      </div>
    </div>
    <div class="col-auto">
      <div class="input-group">
        <label for="ktg" class="input-group-text bg-primary text-white">Kategori Soal</label>
        <select class="form-select">
          <option value="1">Mudah</option>
          <option value="2">Sedang</option>
          <option value="3">Sukar</option>
        </select>
      </div>
    </div>
  </div>
  <div class="row m-2 border border-secondary m-0 p-0" style="border-radius: 5px;">
    <div class="row bg-secondary m-0 p-1">
      <div class="col-auto text-white">Deskripsi</label></div>
      <div class="col-auto">
        <span class="d-inline-block" tabindex="0" data-bs-toggle="deskrip" data-bs-placement="right" data-bs-custom-class="custom-popover" data-bs-trigger="hover focus" data-bs-content="Pilih Untuk Mengunakan Deskripsi di Soal Tertentu">
          <div class="input-group"><label for="des" class="input-group-text bg-primary text-white">Deskripsi</label>
            <select class="form-select" id="des" name="des">
              <option value="0" selected>Tidak </option>
              <?php
              $desk = mysqli_query($koneksi, "SELECT * FROM cbt_soal WHERE cbt_soal.kd_soal ='$kds' AND cbt_soal.cerita !=''");
              while ($a = mysqli_fetch_array($desk)) {
              ?>
                <option value="G"><?php echo "Soal No." . $a['no_soal'] ?></option>
              <?php } ?>
            </select>
          </div>
        </span>
      </div>
    </div>
    <div class="p-0" id="crtd">
      <textarea name="crt" id="crt" class="mt-5"></textarea>
    </div>
  </div>
  <div class="row m-2 border border-secondary" style="border-radius: 5px;">
    <div class="col-12 bg-secondary text-white p-2">Pertanyaan</div>
    <!-- <div class="col-12"> -->
    <textarea name="tny" id="tny"></textarea>
    <!-- </div> -->
  </div>
  <div class="row m-2 border border-secondary pb-3 text-center" style="border-radius: 5px;">
    <div class="col-12 bg-secondary text-white p-2 text-start">File Pendukung
    </div>
    <div class="row justify-content-center g-4 p-0 m-0">
      <div class="col-md-3 col-sm-6 col-12 fdukung">
        <div class="card text-center">
          <div class="card-body">
            <div class="text-center col">
              <input class="form-control form-control-sm" id="img_s" name="img_s" type="file" hidden onchange="imgs(this);">
              <label for="img_s" style="cursor: pointer;"><img src="../img/img.png" id="imgs" class="card-img-top img-fluid" alt="..." style="width: 10rem; height: 11rem;"></label>Gambar
              <input type="text" class="form-control form-control-sm text-center mt-2 m-1" name="img_sl" id="img_sl" readonly>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-3 col-sm-6 col-12 fdukung">
        <div class="card text-center">
          <div class="card-body">
            <img src="../img/audio.png" class="card-img-top img-fluid" style="width: 10rem; height: 10rem;" alt="...">
            <h6 class="card-title">Audio</h6>
            <form action="./db/upload.php?up=lgsek" method="post" enctype="multipart/form-data">
              <input class="form-control form-control-sm" id="lgsek" name="lgsek" type="file" onchange="this.form.submit()">
            </form>
          </div>
        </div>
      </div>
      <div class="col-md-3 col-sm-6 col-12 fdukung">
        <div class="card text-center">
          <div class="card-body">
            <img src="../img/video.jpg" class="card-img-top img-fluid" style="width: 10rem; height: 10rem;" alt="...">
            <h6 class="card-title">Video</h6>
            <form action="./db/upload.php?up=lgsek" method="post" enctype="multipart/form-data">
              <input class="form-control form-control-sm" id="lgsek" name="lgsek" type="file" onchange="this.form.submit()">
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row m-2 border border-info" style="border-radius: 5px;" id="opjw">
    <div class="col-12 bg-info p-2">Opsi Jawaban</div>
    <div class="col-12 p-2" style="border-radius: 3px;">
      <div class="border border-info-subtle" style="border-radius: 5px;">
        <div class="row m-0 bg-info-subtle p-2 justify-content-center justify-content-md-start">
          <div class="col-auto">Jawaban 1</div>
          <div class="col-auto form-check form-switch">
            <input type="radio" class="form-check-input" role="switch" name="opsi" id="opsi" value="1">
          </div>
        </div>
        <div class="row gap-3 p-3 justify-content-center">
          <div class="col-md-3 col-6">
            <div class="text-center col">
              <input class="form-control form-control-sm" id="imgjw1" name="imgjw1" type="file" hidden onchange="imgjw1(this);">
              <label for="imgjw1" style="cursor: pointer;"><img src="../img/img.png" id="img1" class="card-img-top img-fluid" alt="..." style="height: 7rem;"></label>
              <input type="text" class="form-control form-control-sm text-center m-1" name="img1jw" id="img1jw" value="<?php echo $kds . "_" . $idts['no_soal'] + 1 . "_jw1"; ?>" readonly>
            </div>
          </div>
          <div class="col-md col-auto">
            <textarea name="opsi1" id="opsi1"></textarea>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>





<!-- JavaScript -->
<script src="../aset/ckeditor/build/ckeditor.js" type="text/javascript"></script>
<script>
  ClassicEditor
    .create(document.querySelector('#crt'))
    .catch(error => {
      console.error(error);
    });
  ClassicEditor
    .create(document.querySelector('#tny'))
    .catch(error => {
      console.error(error);
    });
  ClassicEditor
    .create(document.querySelector('#opsi1'))
    .catch(error => {
      console.error(error);
    });
  ClassicEditor
    .create(document.querySelector('#opsi2'))
    .catch(error => {
      console.error(error);
    });
  ClassicEditor
    .create(document.querySelector('#opsi3'))
    .catch(error => {
      console.error(error);
    });
  ClassicEditor
    .create(document.querySelector('#opsi4'))
    .catch(error => {
      console.error(error);
    });
  ClassicEditor
    .create(document.querySelector('#opsi5'))
    .catch(error => {
      console.error(error);
    });

  const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="deskrip"]')
  const popoverList = [...popoverTriggerList].map(popoverTriggerEl => new bootstrap.Popover(popoverTriggerEl))

  // hide

  $("#jns_soal").on("change", function() {
    if ($('#jns_soal').val() == 'E') {
      $("#opjw").addClass("hide");
    } else {
      $("#opjw").removeClass("hide");
    }
  });
  $("#des").on("change", function() {
    if ($('#des').val() != '0') {
      $("#crtd").addClass("hide");
    } else {
      $("#crtd").removeClass("hide");
    }
  });

  // View Images
  function imgs(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function(e) {
        $('#imgs').attr('src', e.target.result);
        // document.getElementById("img_sl").innerHTML = "<?php echo $kds . "_" . $idts['no_soal'] + 1; ?>";
      }

      reader.readAsDataURL(input.files[0]);
    }
  }

  function imgjw1(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();

      reader.onload = function(e) {
        $('#img1').attr('src', e.target.result);
      }

      reader.readAsDataURL(input.files[0]);
    }
  }
</script>