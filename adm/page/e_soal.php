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

	.popover-fld {
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

	/* .fdukung .card-body{
		min-height: 250px;
	} */

	audio {
		width: 100%;
		max-width: 100%;
		/* height: auto; */
		display: block;
		margin: 0 auto;
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
			<form action="./db/pr_soal.php?kds=<?php echo $kds; ?>" method="post" enctype="multipart/form-data" class="fdata_soal">
				<div class="sticky-md-top bg-white py-1">
					<div class="row m-2 justify-content-between">
						<div class="h5 col-auto">ID Soal <span class="badge bg-primary"><?php echo $dts[0] ?></span></div>
						<div class="col-auto"><button type="submit" class="btn btn-info text-white" id="simpan" name="simpan">Simpan</button></div>
					</div>
					<div class="row m-2 g-2">
						<div class="col-auto">
							<div class="input-group">
								<label for="nos" class="input-group-text bg-primary text-white">No.</label>
								<input id="nos" name="nos" class="form-control" type="text" style="max-width: 80px;" value="<?= !empty($dts['no_soal']) ? $dts['no_soal'] : 1; ?>" readonly>
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
									<option value="G" <?= ($dts['jns_soal'] == "G") ? "selected" : ''; ?>>Pilihan Ganda</option>
									<!-- <option value="J" <?= ($dts['jns_soal'] == "J") ? "selected" : ''; ?>>Menjodohkan</option>
									<option value="X" <?= ($dts['jns_soal'] == "X") ? "selected" : ''; ?>>Benar/Salah</option> -->
									<option value="E" <?= ($dts['jns_soal'] == "E") ? "selected" : ''; ?>>Esai</option>
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
						<div class="col-auto <?php if ($dts['jns_soal'] == "E" || $dts['jns_soal'] == "X") {
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
												$sltdb = ($dts['kd_crta'] == $a['no_soal'] && $dts['kd_crta'] != $dts['no_soal']) ? "selected" : "";
										?>
												<option value="<?= $a['no_soal'] ?>" <?= $sltdb; ?>>Soal No.<?= $a['no_soal']; ?></option>
										<?php }
										} ?>
									</select>
								</div>
							</span>
						</div>
					</div>
					<div class="p-0 <?= (!empty($dts['kd_crta']) && $dts['kd_crta'] != $dts['no_soal']) ? "hide" : '' ?>" id="crtd">
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
					<div class="row justify-content-center g-5 p-0 m-0">
						<div class="col-xl-4 col-md-6 col-12 fdukung">
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
										<span class="d-inline-block fw-semibold" tabindex="0" data-bs-toggle="deskrip" data-bs-placement="bottom" data-bs-custom-class="popover-fld" data-bs-trigger="hover focus" data-bs-content="Klik Nama Untuk Menghapus Gambar">
											<div class="input-group">
												<button type="button" class="btn btn-primary btn-sm" onclick="document.getElementById('img_s').click();"><i class="bi bi-upload"></i> Gambar</button>
												<input type="text" value="<?php echo $dts['img'] ?>" class="form-control form-control-sm text-center" name="img_sl" id="img_sl" readonly onfocus="clearInput(this)">
											</div>
										</span>
									</div>

								</div>
							</div>
						</div>
						<div class="col-xl-4 col-md-6 col-12 fdukung">
							<div class="card text-center">
								<div class="card-body">
									<?php
									if ($dts['audio'] == "") {
										$aud = '<img src="../img/audio.png" class="card-img-top img-fluid" style="width: 10rem; height: 10rem;" alt="...">';
									} else {
										$aud = '<audio controls controlsList="nodownload" src="../audio/' . $dts['audio'] . '" id="aud" name="aud" width="100%"></audio>';
										if (!file_exists("../audio/" . $dts['audio'])) {
											$aud = '<img src="../img/audio.png" class="card-img-top img-fluid" style="width: 10rem; height: 10rem;" alt="...">';
										}
									}
									?>

									<div id="p_aud"><?= $aud; ?></div>
									<!-- <img src="../img/audio.png" class="card-img-top img-fluid" style="width: 10rem; height: 10rem;" alt="..."> -->
									<h6 class="card-title">Audio</h6>
									<div class="">
										<span class="d-inline-block fw-semibold" tabindex="0" data-bs-toggle="deskrip" data-bs-placement="bottom" data-bs-custom-class="popover-fld" data-bs-trigger="hover focus" data-bs-content="Klik Nama Untuk Menghapus Audio">
											<div class="input-group">
												<button type="button" class="btn btn-primary btn-sm" onclick="document.getElementById('audio').click();"><i class="bi bi-upload"></i> Audio</button>
												<input type="text" name="nm_audio" id="nm_audio" value="<?php echo $dts['audio'] ?>" class="form-control form-control-sm text-center" readonly onfocus="clearInput(this)">
											</div>
										</span>
									</div>
									<input class="form-control form-control-sm" id="audio" name="audio" type="file" accept="audio/*" style="display: none;">
								</div>
							</div>
						</div>
						<div class="col-xl-4 col-md-6 col-12 fdukung">
							<div class="card text-center">
								<div class="card-body">
									<?php
									if ($dts['vid'] == "") {
										$vid = '<img src="../img/video.jpg" class="card-img-top img-fluid" style="width: 10rem; height: 10rem;" alt="...">';
									} else {
										$vid = '<video controls controlsList="nodownload" src="../video/' . $dts['vid'] . '" width="100%" style="border-radius: 5px;"></video>';
										if (!file_exists("../video/" . $dts['vid'])) {
											$vid = '<img src="../img/video.jpg" class="card-img-top img-fluid" style="width: 10rem; height: 10rem;" alt="...">';
										}
									}
									?>

									<div id="p_vid"><?= $vid; ?></div>
									<!-- <video controls controlsList="nodownload" src="../video/<?= $dts['vid']; ?>"></video> -->
									<h6 class="card-title">Video</h6>
									<div class="">
										<span class="d-inline-block fw-semibold" tabindex="0" data-bs-toggle="deskrip" data-bs-placement="bottom" data-bs-custom-class="popover-fld" data-bs-trigger="hover focus" data-bs-content="Klik Nama Untuk Menghapus Video">
											<div class="input-group">
												<button type="button" class="btn btn-primary btn-sm" onclick="document.getElementById('video').click();"><i class="bi bi-upload"></i> Video</button>
												<input type="text" name="nm_video" id="nm_video" value="<?php echo $dts['vid'] ?>" class="form-control form-control-sm text-center" readonly onfocus="clearInput(this)">
											</div>
										</span>
									</div>
									<input class="form-control form-control-sm" id="video" name="video" type="file" accept="video/*" style="display: none;">
								</div>
							</div>
						</div>
					</div>
				</div>

				<!-- Pilihan Ganda -->
				<div class="row m-2 border border-info <?= $dts['jns_soal'] == 'E' || $dts['jns_soal'] == 'X' ? 'hide' : ''; ?>" style="border-radius: 5px;" id="opjw">
					<div class="col-12 bg-info p-2">Opsi Jawaban</div>
					<?php for ($i = 1; $i <= 5; $i++) {
						$tx_opsi = explode('|||', $dts["jwb$i"]);
					?>
						<div class="col-12 p-2" style="border-radius: 3px;">
							<div class="border border-info-subtle" style="border-radius: 5px;">
								<div class="row m-0 bg-info-subtle p-2 justify-content-center justify-content-md-start">
									<div class="col-auto">Jawaban <?= $i ?></div>
									<div class="col-auto form-check form-switch <?= $dts['jns_soal'] == 'J' ? 'hide' : ''; ?>" id="key_p<?= $i; ?>">
										<input type="radio" class="form-check-input" role="switch" name="keyopsi" value="<?= $i ?>" <?= $dts['knci_pilgan'] == $i ? 'checked' : ''; ?>>
									</div>
								</div>
								<div class="row g-3 p-3 justify-content-center">
									<div class="col-md-2 col-auto text-center">
										<input class="form-control form-control-sm" id="imgjw<?= $i ?>" name="imgjw<?= $i ?>" type="file" accept=".jpg,.jpeg,.png" hidden>

										<label for="imgjw<?= $i ?>" style="cursor: pointer;">
											<img src="<?php
																if (empty($dts["img$i"])) {
																	echo "../img/img.png";
																} else {
																	$imagePath = "../images/" . $dts["img$i"];
																	(file_exists($imagePath)) ? $imagePath : "../img/no_image.png";
																}
																?>" id="img<?= $i ?>" class="card-img-top img-fluid" alt="..." style="height: 7rem;">
										</label>

										<input type="text" class="form-control form-control-sm text-center m-1" name="img<?= $i ?>jw" id="img<?= $i ?>jw" value="<?php echo $dts["img$i"]; ?>" readonly onfocus="clearInput(this)">
									</div>
									<div class="col-md-10 col">
										<div class="row g-1 m-0">

											<div class="col-12 border border-secondary-subtle p-0">
												<textarea name="opsi<?= $i ?>" id="opsi<?= $i ?>"><?= $tx_opsi[0]; ?></textarea>
												<div class="word-count" id="cr_opsi<?= $i ?>"></div>
											</div>

											<div class="col-12 border border-secondary-subtle p-0 mt-3 <?= $dts['jns_soal'] == 'J' ? '' : 'hide'; ?>" id="ljdh<?= $i ?>" style="border-radius: 5px;">
												<div class="row m-0 bg-secondary-subtle px-2 py-1">Opsi jodoh
												</div>
												<textarea name="jdh<?= $i ?>" id="jdh<?= $i ?>"><?= $tx_opsi[1]; ?></textarea>
												<div class="word-count" id="cr_jdh<?= $i ?>"></div>
											</div>
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
<!-- <script>
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
</script> -->
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
		const jnsSoal = $('#jns_soal').val();
		if (jnsSoal === 'G') {
			$("#opjw").removeClass("hide");
			$("#ackopsi").removeClass("hide");
			for (let i = 1; i <= 5; i++) {
				$('#ljdh' + i).addClass("hide");
				$('#key_p' + i).removeClass("hide");
				$("#keyopsi" + i).attr("required", true);
			}
			// $('#bas').addClass("hide");

		} else if (jnsSoal === 'J') {
			$("#opjw").removeClass("hide");
			$("#ackopsi").addClass("hide");
			for (let i = 1; i <= 5; i++) {
				$('#ljdh' + i).removeClass("hide");
				$('#key_p' + i).addClass("hide");
				$("#keyopsi" + i).attr("required", false);
			}
			// $('#bas').addClass("hide");

			// } else if (jnsSoal === 'X') {
			// 	$('#bas').removeClass("hide");
			// 	$("#opjw").addClass("hide");
			// 	$("#ackopsi").addClass("hide");
			// 	for (let i = 1; i <= 5; i++) {
			// 		$("#keyopsi" + i).attr("required", false);
			// 	}
			// 	$('#jdh').addClass("hide");

		} else {
			$("#opjw").addClass("hide");
			$("#ackopsi").addClass("hide");
			for (let i = 1; i <= 5; i++) {
				$("#keyopsi" + i).attr("required", false);
			}
			// $("#bas").addClass("hide");
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

<!-- Audio Preview -->
<script>
	document.getElementById('audio').addEventListener('change', function(event) {
		const file = event.target.files[0];
		const audio = document.getElementById('p_aud');

		if (file) {
			const url = URL.createObjectURL(file);
			audio.innerHTML = `<audio controls controlsList="nodownload" src="${url}" style="width: 100%;"></audio>`;
			$('#nm_audio').val("<?php echo 'au_' . $kds . "_"; ?>" +
				"<?php echo !empty($dts['no_soal']) ? $dts['no_soal'] : 1; ?>");
		}
	});
</script>

<!-- Video Preview -->
<script>
	document.getElementById('video').addEventListener('change', function(event) {
		const file_v = event.target.files[0];
		const video = document.getElementById('p_vid');

		if (file_v) {
			const url = URL.createObjectURL(file_v);
			video.innerHTML = `<video controls controlsList="nodownload" src="${url}" style="width: 100%;border-radius: 5px;"></video>`;
			$('#nm_video').val("<?php echo 'vid_' . $kds . "_"; ?>" +
				"<?php echo !empty($dts['no_soal']) ? $dts['no_soal'] : 1; ?>");
		}
	});
</script>