<?php
include_once("../config/server.php");

$kds  = $_GET['kds'];
$eds  = $_GET['eds'];
$qr_dt	= (mysqli_query($koneksi, "SELECT * FROM cbt_pktsoal WHERE cbt_pktsoal.kd_soal ='$kds'"));
$dt			= mysqli_fetch_array($qr_dt);
$qr_dts		= (mysqli_query($koneksi, "SELECT * FROM cbt_soal WHERE cbt_soal.kd_soal ='$kds' AND cbt_soal.no_soal ='$eds'"));
$dts		= mysqli_fetch_array($qr_dts);

?>

<style>
	.custom-popover {
		--bs-popover-bg: var(--bs-warning);
	}

	.popover-img {
		--bs-popover-bg: var(--bs-dark-bg-subtle);
	}

	.hide {
		display: none;
	}

	#img_sl,
	#img1jw,
	#img2jw,
	#img3jw,
	#img4jw,
	#img5jw {
		cursor: pointer;
	}
</style>
<!-- <div class="tampildata"></div> -->
<div class="container-fluid p-0">
	<div class="row p-2 border-bottom fs-3 mb-4 shadow-sm bg-light">
		<div class="col-auto "><a href="?md=esoal&ds=<?php echo $dt[0]; ?>" class="btn btn-outline-dark"><i class="bi bi-arrow-left"></i> Kembali</a></div>
		<div class="col">Perbaiki Soal</div>
	</div>
	<div class="row justify-content-center">
		<div class="col-xl-10" id="form_edit">
			<form action="./db/tambah_soal.php?kds=<?php echo $kds; ?>" method="post" enctype="multipart/form-data" class="fdata_soal">
			<div class="sticky-md-top bg-white py-1">
				<div class="row m-2 justify-content-between">
					<div class="h5 col-auto">ID Soal <span class="badge bg-primary"><?php echo $dts[0] ?></span></div>
					<div class="col-auto"><button type="submit" class="btn btn-info text-white" id="simpan" name="simpan">Simpan</button></div>
				</div>
				<div class="row m-2 g-2">
					<div class="col-auto">
						<div class="input-group">
							<label for="nos" class="input-group-text bg-primary text-white">No.</label>
							<input id="nos" name="nos" class="form-control" type="text" style="max-width: 80px;" value="<?= !empty($dts['no_soal']) ? $dts['no_soal'] : 1; ?> " readonly>
							<!-- <select name="snos" id="snos" class="form-select">
								<?php
								$qr_nos = mysqli_query($koneksi, "SELECT * FROM cbt_soal WHERE cbt_soal.kd_soal ='$kds'");
								while ($snos = mysqli_fetch_array($qr_nos)) { ?>
									<option value="<?= $snos['no_soal'] ?>" <?= $dts['no_soal'] == $snos['no_soal'] ? "selected" : ""; ?>><?= $snos['no_soal'] ?></option>
								<?php } ?>
							</select> -->
						</div>
					</div>
					<div class="col-auto">
						<div class="input-group">
							<label for="jns_soal" class="input-group-text bg-primary text-white">Jenis Soal</label>
							<select class="form-select" id="jns_soal" name="jns_soal">
								<option value="G" <?php if ($dts['jns_soal'] == "G") {
																		echo "selected";
																	} ?>>Pilihan Ganda</option>
								<option value="E" <?php if ($dts['jns_soal'] == "E") {
																		echo "selected";
																	} ?>>Esai</option>
							</select>
						</div>
					</div>
					<div class="col-auto">
						<div class="input-group">
							<label for="ktg" class="input-group-text bg-primary text-white">Kategori Soal</label>
							<select class="form-select" id="ktg" name="ktg">
								<option value="1" <?php if ($dts['lev_soal'] == "1") {
																		echo "selected";
																	} ?>>Mudah</option>
								<option value="2" <?php if ($dts['lev_soal'] == "2") {
																		echo "selected";
																	} ?>>Sedang</option>
								<option value="3" <?php if ($dts['lev_soal'] == "3") {
																		echo "selected";
																	} ?>>Sukar</option>
							</select>
						</div>
					</div>
					<div class="col-auto">
						<div class="input-group">
							<label for="asoal" class="input-group-text bg-primary text-white">Acak Soal</label>
							<select class="form-select" id="asoal" name="asoal">
								<option value="Y" <?php if ($dts['ack_soal'] == "Y") {
																		echo "selected";
																	} ?>>Acak</option>
								<option value="N" <?php if ($dts['ack_soal'] == "N") {
																		echo "selected";
																	} ?>>Tidak</option>
							</select>
						</div>
					</div>
					<div class="col-auto <?php if ($dts['jns_soal'] == "E") {
																	echo "hide";
																} ?>" id="ackopsi">
						<div class="input-group">
							<label for="aopsi" class="input-group-text bg-primary text-white">Acak Opsi</label>
							<select class="form-select" id="aopsi" name="aopsi">
								<option value="Y" <?php if ($dts['ack_opsi'] == "Y") {
																		echo "selected";
																	} ?>>Acak</option>
								<option value="N" <?php if ($dts['ack_opsi'] == "N") {
																		echo "selected";
																	} ?>>Tidak</option>
							</select>
						</div>
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
												<option value="<?= $a['no_soal'] ?>" <?= ($dts['kd_crta'] == $a['no_soal']) ? 'selected' : ''; ?>>Soal No.<?= $a['no_soal']; ?></option>

										<?php }
										} ?>
									</select>
								</div>
							</span>
						</div>
					</div>
					<div class="p-0 <?php if (!empty($dts['kd_crta'])) {
														echo "hide";
													} ?>" id="crtd">
						<textarea name="crt" id="crt" class="mt-5"><?= $dts['cerita'] ?></textarea>
						<div class="word-count" id="cr_crt"></div>
					</div>
				</div>
				<div class="row m-2 border border-secondary" style="border-radius: 5px;">
					<div class="col-12 bg-secondary text-white p-2">Pertanyaan</div>
					<div class="p-0">
						<textarea name="tny" id="tny"><?= $dts['tanya'] ?></textarea>
						<div class="word-count" id="cr_tny"></div>
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
										<input class="form-control form-control-sm" id="img_s" name="img_s" type="file" accept=".jpg,.jpeg,.png" hidden>

										<label for="img_s" style="cursor: pointer;">
											<img src="<?php
																if (empty($dts['img'])) {
																	echo "../img/img.png";
																} else {
																	$imagePath = "../images/" . $dts['img'];
																	if (file_exists($imagePath)) {
																		echo $imagePath;
																	} else {
																		echo "../img/no_image.png";
																	}
																}
																?>"
												id="imgs" class="card-img-top img-fluid" alt="..." style="width: 10rem; height: 10rem;">
										</label>

										<h6 class="card-title">Gambar</h6>
										<span class="d-inline-block fw-semibold" tabindex="0" data-bs-toggle="deskrip" data-bs-placement="bottom" data-bs-custom-class="popover-img" data-bs-trigger="hover focus" data-bs-content="Klik Untuk Menghapus Gambar">
											<input type="text" value="<?php echo $dts['img'] ?>" class="form-control form-control-sm text-center mt-2 m-1" name="img_sl" id="img_sl" readonly onfocus="clearInput(this)">
										</span>
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
				<div class="row m-2 border border-info <?php echo $dts['jns_soal'] == 'E' ? 'hide' : ''; ?>" style="border-radius: 5px;" id="opjw">
					<div class="col-12 bg-info p-2">Opsi Jawaban</div>
					<?php for ($i = 1; $i <= 5; $i++) { ?>
						<div class="col-12 p-2" style="border-radius: 3px;">
							<div class="border border-info-subtle" style="border-radius: 5px;">
								<div class="row m-0 bg-info-subtle p-2 justify-content-center justify-content-md-start">
									<div class="col-auto">Jawaban <?= $i ?></div>
									<div class="col-auto form-check form-switch">
										<input type="radio" class="form-check-input" role="switch" name="keyopsi" value="<?= $i ?>" <?php echo $dts['knci_pilgan'] == $i ? 'checked' : ''; ?>>
									</div>
								</div>
								<div class="row gap-3 p-3 justify-content-center">
									<div class="col-md-2 col-auto text-center">
										<input class="form-control form-control-sm" id="imgjw<?= $i ?>" name="imgjw<?= $i ?>" type="file" accept=".jpg,.jpeg,.png" hidden>

										<label for="imgjw<?= $i ?>" style="cursor: pointer;">
											<img src="<?php
																if (empty($dts["img$i"])) {
																	echo "../img/img.png";
																} else {
																	$imagePath = "../images/" . $dts["img$i"];
																	if (file_exists($imagePath)) {
																		echo $imagePath;
																	} else {
																		echo "../img/no_image.png";
																	}
																}
																?>" id="img<?= $i ?>" class="card-img-top img-fluid" alt="..." style="height: 7rem;">
										</label>

										<input type="text" class="form-control form-control-sm text-center m-1" name="img<?= $i ?>jw" id="img<?= $i ?>jw" value="<?php echo $dts["img$i"]; ?>" readonly onfocus="clearInput(this)">
									</div>
									<div class="col-md-9 col">
										<textarea name="opsi<?= $i ?>" id="opsi<?= $i ?>"><?php echo $dts["jwb$i"]; ?></textarea>
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
</div>




<!-- JavaScript -->
<script>
	document.addEventListener("DOMContentLoaded", function() {
		// Tampilkan spinner
		document.getElementById("loadingSpinner").style.display = "flex";

		// Sembunyikan spinner dan tampilkan tabel setelah loading selesai
		setTimeout(function() {
			document.getElementById("loadingSpinner").style.display = "none";
			document.getElementById("form_edit").style.display = "block";
		}, 500); // Simulasi waktu loading selama 2 detik

		// Inisialisasi Simple-DataTables pada tabel
		var dataTable = new simpleDatatables.DataTable("#jsdata", {
			perPageSelect: [5, 10, 25, 50, 'All'],
			perPage: 5,
			labels: {
				placeholder: "Cari...",
				perPage: " Data per halaman",
				noRows: "Tidak ada data yang ditemukan",
				info: "Menampilkan {start}/{end} dari {rows} Data",
			}
		});
	});
</script>
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
</script>
<script>
	// View Images
	function loadImage(input, imgId, imgValue, suffix) {
		if (input.files && input.files[0]) {
			const reader = new FileReader();
			reader.onload = function(e) {
				$(imgId).attr('src', e.target.result);
				document.getElementById(imgValue).value =
					"<?php echo $kds . "_"; ?>" +
					"<?php echo !empty($dts['no_soal']) ? $dts['no_soal'] : 1; ?>" + suffix;
			};
			reader.readAsDataURL(input.files[0]);
		}
	}

	// Untuk gambar utama
	$("#img_s").change(function() {
		loadImage(this, '#imgs', 'img_sl', '');
	});

	// Untuk gambar dengan suffix (_jw1, _jw2, dst.)
	for (let i = 1; i <= 5; i++) {
		$(`#imgjw${i}`).change(function() {
			loadImage(this, `#img${i}`, `img${i}jw`, `_jw${i}`);
		});
	}



	// Delete field foto
	function clearInput(getValue) {
		if (getValue.value != "") {
			getValue.value = "";
		}
	}
</script>