<?php
include_once("../config/server.php");

$kds  = $_GET['kds'];
$dt = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM cbt_pktsoal WHERE cbt_pktsoal.kd_soal ='$kds'"));
$dts = mysqli_fetch_array(mysqli_query($koneksi, "SELECT max(id_soal)AS id FROM cbt_soal WHERE cbt_soal.kd_soal ='$kds'"));
$ids = mysqli_fetch_array(mysqli_query($koneksi, "SELECT max(id_soal)AS id FROM cbt_soal"));
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
<!-- <div class="tampildata"></div> -->
<div class="container-fluid p-0">
	<div class="row p-2 border-bottom fs-3 mb-4 shadow-sm bg-light">
		<div class="col-auto "><a href="?md=esoal&ds=<?php echo $dt[0]; ?>" class="btn btn-outline-dark"><i class="bi bi-arrow-left"></i> Kembali</a></div>
		<div class="col">Tambah Soal</div>
	</div>
	
	<div class="row justify-content-center"><div class="col-xl-10">
	<form action="./db/tambah_soal.php?kds=<?php echo $kds; ?>" method="post" enctype="multipart/form-data" class="fdata_soal">
		<div class="sticky-md-top bg-white py-1">
		<div class="row m-2 justify-content-between">
			<div class="h5 col-auto">ID Soal <span class="badge bg-primary"><?php echo $ids['id'] + 1 ?></span></div>
			<div class="col-auto"><button type="submit" class="btn btn-info text-white" id="simpan" name="simpan">Simpan</button></div>
		</div>
		<div class="row m-2 g-2">
			<div class="col-auto">
				<div class="input-group">
					<label for="nos" class="input-group-text bg-primary text-white">No.</label>
					<input id="nos" name="nos" class="form-control" type="text" style="max-width: 80px;" value="<?= !empty($idts['no_soal']) ? $idts['no_soal'] + 1 : 1; ?>">
				</div>
			</div>
			<div class="col-auto">
				<div class="input-group">
					<label for="jns_soal" class="input-group-text bg-primary text-white">Jenis Soal</label>
					<select class="form-select" id="jns_soal" name="jns_soal">
						<option value="G">Pilihan Ganda</option>
						<option value="E" >Esai</option>
					</select>
				</div>
			</div>
			<div class="col-auto">
				<div class="input-group">
					<label for="ktg" class="input-group-text bg-primary text-white">Kategori Soal</label>
					<select class="form-select" id="ktg" name="ktg">
						<option value="1">Mudah</option>
						<option value="2">Sedang</option>
						<option value="3">Sukar</option>
					</select>
				</div>
			</div>
			<div class="col-auto">
				<div class="input-group">
					<label for="asoal" class="input-group-text bg-primary text-white">Acak Soal</label>
					<select class="form-select" id="asoal" name="asoal">
						<option value="Y">Acak</option>
						<option value="T">Tidak</option>
					</select>
				</div>
			</div>
			<div class="col-auto" id="ackopsi">
				<div class="input-group">
					<label for="aopsi" class="input-group-text bg-primary text-white">Acak Opsi</label>
					<select class="form-select" id="aopsi" name="aopsi">
						<option value="Y">Acak</option>
						<option value="T">Tidak</option>
					</select>
				</div>
			</div>
		</div></div>
		<div class="row m-2 border border-secondary m-0 p-0" style="border-radius: 5px;">
			<div class="row bg-secondary m-0 p-1">
				<div class="col-auto text-white">Deskripsi</div>
				<div class="col-auto">
					<span class="d-inline-block" tabindex="0" data-bs-toggle="deskrip" data-bs-placement="right" data-bs-custom-class="custom-popover" data-bs-trigger="hover focus" data-bs-content="Pilih Untuk Mengunakan Deskripsi di Soal Tertentu">
						<div class="input-group"><label for="des" class="input-group-text bg-primary text-white">Deskripsi</label>
							<select class="form-select" id="des" name="des">
								<option value="0" selected>Tidak </option>
								<?php
								if (!empty($idts['no_soal'])) {
									$desk = mysqli_query($koneksi, "SELECT * FROM cbt_soal WHERE cbt_soal.kd_soal ='$kds' AND cbt_soal.cerita !=''");
									while ($a = mysqli_fetch_array($desk)) {
								?>
										<option value="<?php echo $a['no_soal']; ?>"><?php echo "Soal No." . $a['no_soal'] ?></option>
								<?php }
								} ?>
							</select>
						</div>
					</span>
				</div>
			</div>
			<div class="p-0" id="crtd">
				<textarea name="crt" id="crt" class="mt-5"></textarea>
			</div>
		</div>
		<div class="row m-2 border border-secondary m-0 p-0" style="border-radius: 5px;">
			<div class="col-12 bg-secondary text-white p-2">Pertanyaan</div>
			<div class="p-0">
			<textarea name="tny" id="tny"></textarea>
			</div>
		</div>
		<div class="row m-2 border border-secondary pb-3 text-center" style="border-radius: 5px;">
			<div class="col-12 bg-secondary text-white p-2 text-start">File Pendukung
			</div>
			<div class="row justify-content-center g-4 p-0 m-0">
				<div class="col-md-3 col-sm-6 col-12 fdukung">
					<div class="card text-center">
						<div class="card-body">
							<div class="text-center col">
								<input class="form-control form-control-sm" id="img_s" name="img_s" type="file" accept=".jpg,.jpeg,.png" hidden >
								<label for="img_s" style="cursor: pointer;"><img src="../img/img.png" id="imgs" class="card-img-top img-fluid" alt="..." style="width: 10rem; height: 11rem;"></label>
								<h6 class="card-title">Gambar</h6>
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
							<input class="form-control form-control-sm" id="audio" name="audio" type="file">
						</div>
					</div>
				</div>
				<div class="col-md-3 col-sm-6 col-12 fdukung">
					<div class="card text-center">
						<div class="card-body">
							<img src="../img/video.jpg" class="card-img-top img-fluid" style="width: 10rem; height: 10rem;" alt="...">
							<h6 class="card-title">Video</h6>
							<input class="form-control form-control-sm" id="video" name="video" type="file">
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row m-2 border border-info" style="border-radius: 5px;" id="opjw">
			<div class="col-12 bg-info p-2">Opsi Jawaban</div>
			<?php for ($i = 1; $i <= 5; $i++) { ?>
				<div class="col-12 p-2" style="border-radius: 3px;">
					<div class="border border-info-subtle" style="border-radius: 5px;">
						<div class="row m-0 bg-info-subtle p-2 justify-content-center justify-content-md-start">
							<div class="col-auto">Jawaban <?= $i ?></div>
							<div class="col-auto form-check form-switch">
								<input type="radio" class="form-check-input" role="switch" name="keyopsi" required>
							</div>
						</div>
						<div class="row gap-3 p-3 justify-content-center">
							<div class="col-md-2 col-auto text-center">
								<input class="form-control form-control-sm" id="imgjw<?= $i ?>" name="imgjw<?= $i ?>" type="file" accept=".jpg,.jpeg,.png" hidden>
								<label for="imgjw<?= $i ?>" style="cursor: pointer;">
									<img src="<?php echo empty($dts["img$i"]) ? '../img/img.png' : '../images/' . $dts["img$i"]; ?>" id="img<?= $i ?>" class="card-img-top img-fluid" alt="..." style="height: 7rem;">
								</label>
								<input type="text" class="form-control form-control-sm text-center m-1" name="img<?= $i ?>jw" id="img<?= $i ?>jw" readonly onfocus="clearInput(this)">
							</div>
							<div class="col-md-9 col">
								<textarea name="opsi<?= $i ?>" id="opsi<?= $i ?>"></textarea>
								<div class="word-count" id="cr_opsi<?= $i ?>"></div>
							</div>
						</div>
					</div>
				</div>
			<?php } ?>
		</div>
		<div class="row justify-content-end m-2 pb-5">
			<div class="col-auto"><button type="submit" class="btn btn-info text-white" id="simpan" name="simpan">Simpan</button></div>
		</div>
	</form>
	</div>
</div>






<!-- JavaScript -->
<script type="importmap">
		{
			"imports": {
				"ckeditor5": "./../aset/ckeditor5/ckeditor5.js",
				"ckeditor5/": "./../aset/ckeditor5/"
			}
		}
		</script>
<script type="module" src="../aset/ckeditor5/ckeditor5.js"></script>
<script type="module" src="../aset/main_ck5.js"></script>
<script type="text/javascript" src="./../node_modules/jquery/dist/jquery.min.js"></script>


<script>
	const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="deskrip"]')
	const popoverList = [...popoverTriggerList].map(popoverTriggerEl => new bootstrap.Popover(popoverTriggerEl))

	// hide

	$("#jns_soal").on("change", function() {
		if ($('#jns_soal').val() == 'E') {
			$("#opjw").addClass("hide");
			$("#ackopsi").addClass("hide");
			$("#keyopsi").prop("required", false);
		} else {
			$("#opjw").removeClass("hide");
			$("#ackopsi").removeClass("hide");
			$("#keyopsi").prop("required", true);

		}
	});
	$("#des").on("change", function() {
		if ($('#des').val() != '0') {
			$("#crtd").addClass("hide");
		} else {
			$("#crtd").removeClass("hide");
		}
	});

	// simpan data
	// $(document).ready(function() {
	// 	$("#simpan").click(function() {
	// 		var data = $('.fdata_soal').serialize();
	// 		$.ajax({
	// 			type: 'POST',
	// 			url: "./db/tambah_soal.php",
	// 			data: data,
	// 			success: function() {
	// 				Swal.fire({
	// 					title:'Data berhasil disimpan',
	// 					icon:'success',
	// 					showConfirmButton: false,
	// 					timer: 2000
	// 			})
	// 			// setTimeout(function(){
	// 			// 	location.reload();
	// 			// },2500);
	// 			}
	// 		});
	// 			// $('.tampildata').load("./db/tambah_soal.php");
	// 	});
	// });

</script>
<script>
// View Images
function updateImagePreview(input, imgSelector, inputSelector, suffix) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $(imgSelector).attr('src', e.target.result);
            document.getElementById(inputSelector).value = "<?php echo $kds . "_"; ?>" +
                "<?php echo !empty($idts['no_soal']) ? $idts['no_soal'] + 1 : 1; ?>" + suffix;
        };
        reader.readAsDataURL(input.files[0]);
    }
}

$("#img_s").change(function() {
    updateImagePreview(this, '#imgs', 'img_sl', '');
});

for (let i = 1; i <= 5; i++) {
    $(`#imgjw${i}`).change(function() {
        updateImagePreview(this, `#img${i}`, `img${i}jw`, `_jw${i}`);
    });
}


</script>