<?php
include_once("../config/server.php");

$kds  = $_GET['kds'];
$eds  = $_GET['eds'];
$dt = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM cbt_pktsoal WHERE cbt_pktsoal.kd_soal ='$kds'"));
$dts = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM cbt_soal WHERE cbt_soal.kd_soal ='$kds' AND cbt_soal.no_soal ='$eds'"));

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
	<form action="./db/tambah_soal.php?kds=<?php echo $kds; ?>" method="post" enctype="multipart/form-data" class="fdata_soal">
		<div class="row m-2 justify-content-between">
			<div class="h5 col-auto">ID Soal <span class="badge bg-primary"><?php echo $dts[0] ?></span></div>
			<div class="col-auto"><button type="submit" class="btn btn-info text-white" id="simpan" name="simpan">Simpan</button></div>
		</div>
		<div class="row m-2 g-2">
			<div class="col-auto">
				<div class="input-group">
					<label for="nos" class="input-group-text bg-primary text-white">No.</label>
					<input id="nos" name="nos" class="form-control" type="text" style="max-width: 80px;" value="<?php if (!empty($dts['no_soal'])) {echo $dts['no_soal']; } else { echo 1; } ?>">
				</div>
			</div>
			<div class="col-auto">
				<div class="input-group">
					<label for="jns_soal" class="input-group-text bg-primary text-white">Jenis Soal</label>
					<select class="form-select" id="jns_soal" name="jns_soal">
						<option value="G" <?php if($dts['jns_soal']=="G"){echo "selected";} ?>>Pilihan Ganda</option>
						<option value="E" <?php if($dts['jns_soal']=="E"){echo "selected";} ?>>Esai</option>
					</select>
				</div>
			</div>
			<div class="col-auto">
				<div class="input-group">
					<label for="ktg" class="input-group-text bg-primary text-white">Kategori Soal</label>
					<select class="form-select" id="ktg" name="ktg">
						<option value="1" <?php if($dts['lev_soal']=="1"){echo "selected";} ?>>Mudah</option>
						<option value="2" <?php if($dts['lev_soal']=="2"){echo "selected";} ?>>Sedang</option>
						<option value="3" <?php if($dts['lev_soal']=="3"){echo "selected";} ?>>Sukar</option>
					</select>
				</div>
			</div>
			<div class="col-auto">
				<div class="input-group">
					<label for="asoal" class="input-group-text bg-primary text-white">Acak Soal</label>
					<select class="form-select" id="asoal" name="asoal">
						<option value="Y" <?php if($dts['ack_soal']=="Y"){echo "selected";} ?>>Acak</option>
						<option value="N" <?php if($dts['ack_soal']=="N"){echo "selected";} ?>>Tidak</option>
					</select>
				</div>
			</div>
			<div class="col-auto <?php if($dts['jns_soal']=="E"){echo "hide";} ?>" id="ackopsi">
				<div class="input-group">
					<label for="aopsi" class="input-group-text bg-primary text-white">Acak Opsi</label>
					<select class="form-select" id="aopsi" name="aopsi">
						<option value="Y" <?php if($dts['ack_opsi']=="Y"){echo "selected";} ?>>Acak</option>
						<option value="N" <?php if($dts['ack_opsi']=="N"){echo "selected";} ?>>Tidak</option>
					</select>
				</div>
			</div>
		</div>
		<div class="row m-2 border border-secondary m-0 p-0" style="border-radius: 5px;">
			<div class="row bg-secondary m-0 p-1">
				<div class="col-auto text-white">Deskripsi</div>
				<div class="col-auto">
					<span class="d-inline-block" tabindex="0" data-bs-toggle="deskrip" data-bs-placement="right" data-bs-custom-class="custom-popover" data-bs-trigger="hover focus" data-bs-content="Pilih Untuk Mengunakan Deskripsi di Soal Tertentu">
						<div class="input-group"><label for="des" class="input-group-text bg-primary text-white">Deskripsi</label>
							<select class="form-select" id="des" name="des">
								<option value="0" selected>Tidak </option>
								<?php
								if (!empty($dts['no_soal'])) {
									$desk = mysqli_query($koneksi, "SELECT * FROM cbt_soal WHERE cbt_soal.kd_soal ='$kds' AND cbt_soal.cerita !=''");
									while ($a = mysqli_fetch_array($desk)) {
								?>
										<option value="<?php echo $a['no_soal']; ?>" <?php if($dts['kd_crta']==$a['no_soal']){echo "selected";} ?>><?php echo "Soal No." . $a['no_soal'] ?></option>
								<?php }
								} ?>
							</select>
						</div>
					</span>
				</div>
			</div>
			<div class="p-0 <?php if($dts['kd_crta']!="0"){echo "hide";} ?>" id="crtd">
				<textarea name="crt" id="crt" class="mt-5"><?php echo $dts['cerita'] ?></textarea>
			</div>
		</div>
		<div class="row m-2 border border-secondary" style="border-radius: 5px;">
			<div class="col-12 bg-secondary text-white p-2">Pertanyaan</div>
			<!-- <div class="col-12"> -->
			<textarea name="tny" id="tny"><?php echo $dts['tanya'] ?></textarea>
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
								<input class="form-control form-control-sm" id="img_s" name="img_s" type="file" hidden >
								<label for="img_s" style="cursor: pointer;"><img src="<?php if(empty($dts['img'])){echo "../img/img.png";}else{echo "../images/".$dts['img'];} ?>" id="imgs" class="card-img-top img-fluid" alt="..." style="width: 10rem; height: 11rem;"></label>Gambar
								<input type="text" class="form-control form-control-sm text-center mt-2 m-1" name="img_sl" id="img_sl" readonly>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-3 col-sm-6 col-12 fdukung">
					<div class="card text-center">
						<div class="card-body">
							<img src="../img/audio.png" class="card-img-top img-fluid" style="width: 10rem; height: 10rem;" alt="...">
							<h6 class="card-title">Audio <i>coming soon</i></h6>
							<input class="form-control form-control-sm" id="audio" name="audio" type="file" disabled>
						</div>
					</div>
				</div>
				<div class="col-md-3 col-sm-6 col-12 fdukung">
					<div class="card text-center">
						<div class="card-body">
							<img src="../img/video.jpg" class="card-img-top img-fluid" style="width: 10rem; height: 10rem;" alt="...">
							<h6 class="card-title">Video <i>coming soon</i></h6>
							<input class="form-control form-control-sm" id="video" name="video" type="file" disabled>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row m-2 border border-info <?php if($dts['jns_soal']=="E"){echo "hide";} ?>" style="border-radius: 5px;" id="opjw">
			<div class="col-12 bg-info p-2">Opsi Jawaban</div>
			<div class="col-12 p-2" style="border-radius: 3px;">
				<div class="border border-info-subtle" style="border-radius: 5px;">
					<div class="row m-0 bg-info-subtle p-2 justify-content-center justify-content-md-start">
						<div class="col-auto">Jawaban 1</div>
						<div class="col-auto form-check form-switch">
							<input type="radio" class="form-check-input" role="switch" name="keyopsi" id="keyopsi" required value="1" <?php if($dts['knci_pilgan']=="1"){echo "checked";} ?>>
						</div>
					</div>
					<div class="row gap-3 p-3 justify-content-center">
						<div class="col-md-2 col-6">
							<div class="text-center col">
								<input class="form-control form-control-sm" id="imgjw1" name="imgjw1" type="file" hidden >
								<label for="imgjw1" style="cursor: pointer;"><img src="<?php if(empty($dts['img1'])){echo "../img/img.png";}else{echo "../images/".$dts['img1'];} ?>" id="img1" class="card-img-top img-fluid" alt="..." style="height: 7rem;"></label>
								<input type="text" class="form-control form-control-sm text-center m-1" name="img1jw" id="img1jw" value="" readonly>
							</div>
						</div>
						<div class="col-md col-auto">
							<textarea name="opsi1" id="opsi1"><?php echo $dts['jwb1'] ?></textarea>
						</div>
					</div>
				</div>
			</div>
			<div class="col-12 p-2" style="border-radius: 3px;">
				<div class="border border-info-subtle" style="border-radius: 5px;">
					<div class="row m-0 bg-info-subtle p-2 justify-content-center justify-content-md-start">
						<div class="col-auto">Jawaban 2</div>
						<div class="col-auto form-check form-switch">
							<input type="radio" class="form-check-input" role="switch" name="keyopsi" id="keyopsi" value="2" <?php if($dts['knci_pilgan']=="2"){echo "checked";} ?>>
						</div>
					</div>
					<div class="row gap-3 p-3 justify-content-center">
						<div class="col-md-2 col-6">
							<div class="text-center col">
								<input class="form-control form-control-sm" id="imgjw2" name="imgjw2" type="file" hidden >
								<label for="imgjw2" style="cursor: pointer;"><img src="<?php if(empty($dts['img2'])){echo "../img/img.png";}else{echo "../images/".$dts['img2'];} ?>" id="img2" class="card-img-top img-fluid" alt="..." style="height: 7rem;"></label>
								<input type="text" class="form-control form-control-sm text-center m-1" name="img2jw" id="img2jw" value="" readonly>
							</div>
						</div>
						<div class="col-md col-auto">
							<textarea name="opsi2" id="opsi2"><?php echo $dts['jwb2'] ?></textarea>
						</div>
					</div>
				</div>
			</div>
			<div class="col-12 p-2" style="border-radius: 3px;">
				<div class="border border-info-subtle" style="border-radius: 5px;">
					<div class="row m-0 bg-info-subtle p-2 justify-content-center justify-content-md-start">
						<div class="col-auto">Jawaban 3</div>
						<div class="col-auto form-check form-switch">
							<input type="radio" class="form-check-input" role="switch" name="keyopsi" id="keyopsi"  value="3" <?php if($dts['knci_pilgan']=="3"){echo "checked";} ?>>
						</div>
					</div>
					<div class="row gap-3 p-3 justify-content-center">
						<div class="col-md-2 col-6">
							<div class="text-center col">
								<input class="form-control form-control-sm" id="imgjw3" name="imgjw3" type="file" hidden >
								<label for="imgjw3" style="cursor: pointer;"><img src="<?php if(empty($dts['img3'])){echo "../img/img.png";}else{echo "../images/".$dts['img3'];} ?>" id="img3" class="card-img-top img-fluid" alt="..." style="height: 7rem;"></label>
								<input type="text" class="form-control form-control-sm text-center m-1" name="img3jw" id="img3jw" value="" readonly>
							</div>
						</div>
						<div class="col-md col-auto">
							<textarea name="opsi3" id="opsi3"><?php echo $dts['jwb3'] ?></textarea>
						</div>
					</div>
				</div>
			</div>
			<div class="col-12 p-2" style="border-radius: 3px;">
				<div class="border border-info-subtle" style="border-radius: 5px;">
					<div class="row m-0 bg-info-subtle p-2 justify-content-center justify-content-md-start">
						<div class="col-auto">Jawaban 4</div>
						<div class="col-auto form-check form-switch">
							<input type="radio" class="form-check-input" role="switch" name="keyopsi" id="keyopsi"  value="4" <?php if($dts['knci_pilgan']=="4"){echo "checked";} ?>>
						</div>
					</div>
					<div class="row gap-3 p-3 justify-content-center">
						<div class="col-md-2 col-6">
							<div class="text-center col">
								<input class="form-control form-control-sm" id="imgjw4" name="imgjw4" type="file" hidden >
								<label for="imgjw4" style="cursor: pointer;"><img src="<?php if(empty($dts['img4'])){echo "../img/img.png";}else{echo "../images/".$dts['img4'];} ?>" id="img4" class="card-img-top img-fluid" alt="..." style="height: 7rem;"></label>
								<input type="text" class="form-control form-control-sm text-center m-1" name="img4jw" id="img4jw" value="" readonly>
							</div>
						</div>
						<div class="col-md col-auto">
							<textarea name="opsi4" id="opsi4"><?php echo $dts['jwb4'] ?></textarea>
						</div>
					</div>
				</div>
			</div>
			<div class="col-12 p-2" style="border-radius: 3px;">
				<div class="border border-info-subtle" style="border-radius: 5px;">
					<div class="row m-0 bg-info-subtle p-2 justify-content-center justify-content-md-start">
						<div class="col-auto">Jawaban 5</div>
						<div class="col-auto form-check form-switch">
							<input type="radio" class="form-check-input" role="switch" name="keyopsi" id="keyopsi"  value="5" <?php if($dts['knci_pilgan']=="5"){echo "checked";} ?>>
						</div>
					</div>
					<div class="row gap-3 p-3 justify-content-center">
						<div class="col-md-2 col-6">
							<div class="text-center col">
								<input class="form-control form-control-sm" id="imgjw5" name="imgjw5" type="file" hidden >
								<label for="imgjw5" style="cursor: pointer;"><img src="<?php if(empty($dts['img5'])){echo "../img/img.png";}else{echo "../images/".$dts['img5'];} ?>" id="img5" class="card-img-top img-fluid" alt="..." style="height: 7rem;"></label>
								<input type="text" class="form-control form-control-sm text-center m-1" name="img5jw" id="img5jw" value="" readonly>
							</div>
						</div>
						<div class="col-md col-auto">
							<textarea name="opsi5" id="opsi5"><?php echo $dts['jwb5'] ?></textarea>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row justify-content-end m-2 pb-5">
			<div class="col-auto"><button type="submit" class="btn btn-info text-white" id="simpan" name="simpan">Simpan</button></div>
		</div>
	</form>
</div>






<!-- JavaScript -->
<script src="../aset/ckeditor/build/ckeditor.js" type="text/javascript"></script>
<script src="../../node_modules/jquery/dist/jquery.min.js" type="text/javascript"></script>
<!-- <script src="../../node_modules/jquery/dist/jquery.js" type="text/javascript"></script> -->
<script type="text/javascript" >
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


// View Images
function imgs(input) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function(e) {
				$('#imgs').attr('src', e.target.result);
				document.getElementById("img_sl").value = "<?php echo $kds . "_"; if (!empty($dts['no_soal'])) { echo $dts['no_soal']; } else { echo 1; } ?>";
			}
			reader.readAsDataURL(input.files[0]);
		}
	}
	$("#img_s").change(function(){
		imgs(this);
	});

	function imgjw1(input) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function(e) {
				$('#img1').attr('src', e.target.result);
				document.getElementById("img1jw").value = "<?php echo $kds . "_"; if (!empty($dts['no_soal'])) { echo $dts['no_soal']; } else { echo 1; } echo "_jw1"; ?>";
			}
			reader.readAsDataURL(input.files[0]);
		}
	}
	$("#imgjw1").change(function(){
		imgjw1(this);
	});

	function imgjw2(input) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function(e) {
				$('#img2').attr('src', e.target.result);
				document.getElementById("img2jw").value = "<?php echo $kds . "_"; if (!empty($dts['no_soal'])) { echo $dts['no_soal']; } else { echo 1; } echo "_jw2"; ?>";
			}
			reader.readAsDataURL(input.files[0]);
		}
	}
	$("#imgjw2").change(function(){
		imgjw2(this);
	});

	function imgjw3(input) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function(e) {
				$('#img3').attr('src', e.target.result);
				document.getElementById("img3jw").value = "<?php echo $kds . "_"; if (!empty($dts['no_soal'])) { echo $dts['no_soal']; } else { echo 1; } echo "_jw3"; ?>";
			}
			reader.readAsDataURL(input.files[0]);
		}
	}
	$("#imgjw3").change(function(){
		imgjw3(this);
	});

	function imgjw4(input) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function(e) {
				$('#img4').attr('src', e.target.result);
				document.getElementById("img4jw").value = "<?php echo $kds . "_"; if (!empty($dts['no_soal'])) { echo $dts['no_soal']; } else { echo 1; } echo "_jw4"; ?>";
			}
			reader.readAsDataURL(input.files[0]);
		}
	}
	$("#imgjw4").change(function(){
		imgjw4(this);
	});

	function imgjw5(input) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function(e) {
				$('#img5').attr('src', e.target.result);
				document.getElementById("img5jw").value = "<?php echo $kds . "_"; if (!empty($dts['no_soal'])) { echo $dts['no_soal']; } else { echo 1; } echo "_jw5"; ?>";
			}
			reader.readAsDataURL(input.files[0]);
		}
	}
	$("#imgjw5").change(function(){
		imgjw5(this);
	});


</script>