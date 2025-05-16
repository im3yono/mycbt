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

	<div class="row justify-content-center">
		<div class="col-xl-10">
			<form action="./db/pr_soal.php?kds=<?php echo $kds; ?>" method="post" enctype="multipart/form-data" class="fdata_soal">
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
									<!-- <option value="J">Menjodohkan</option>
									<option value="X">Benar/Salah</option> -->
									<option value="E">Esai</option>
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
						<div class="word-count" id="cr_crt"></div>
					</div>
				</div>
				<div class="row m-2 border border-secondary m-0 p-0" style="border-radius: 5px;">
					<div class="col-12 bg-secondary text-white p-2">Pertanyaan</div>
					<div class="p-0">
						<textarea name="tny" id="tny"></textarea>
						<div class="word-count" id="cr_tny"></div>
					</div>
				</div>
				<div class="row m-2 border border-secondary pb-3 text-center" style="border-radius: 5px;">
					<div class="col-12 bg-secondary text-white p-2 text-start">File Pendukung
					</div>
					<div class="row justify-content-center g-4 p-0 m-0">
						<div class="col-xl-4 col-md-6 col-12 fdukung">
							<div class="card text-center">
								<div class="card-body">
									<div class="text-center col">
										<input class="form-control form-control-sm" id="img_s" name="img_s" type="file" accept=".jpg,.jpeg,.png" hidden>
										<label for="img_s" style="cursor: pointer;"><img src="../img/img.png" id="imgs" class="card-img-top img-fluid" alt="..." style="width: 10rem; height: 10rem;"></label>
										<h6 class="card-title">Gambar</h6>
										<div class="input-group">
											<button type="button" class="btn btn-primary btn-sm" onclick="document.getElementById('img_s').click();"><i class="bi bi-upload"></i> Gambar</button>
											<input type="text" class="form-control form-control-sm text-center" name="img_sl" id="img_sl" readonly>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-xl-4 col-md-6 col-12 fdukung">
							<div class="card text-center">
								<div class="card-body">
									<div id="p_aud">
										<img src="../img/audio.png" class="card-img-top img-fluid" style="width: 10rem; height: 10rem;" alt="...">
									</div>
									<h6 class="card-title">Audio</h6>
									<div class="input-group">
										<button type="button" class="btn btn-primary btn-sm" onclick="document.getElementById('audio').click();"><i class="bi bi-upload"></i> Audio</button>
										<input type="text" class="form-control form-control-sm text-center" name="nm_audio" id="nm_audio" readonly>
									</div>
									<input class="form-control form-control-sm" id="audio" name="audio" type="file" accept=".mp3,.wav,.aac" hidden>
								</div>
							</div>
						</div>
						<div class="col-xl-4 col-md-6 col-12 fdukung">
							<div class="card text-center">
								<div class="card-body">
									<div id="p_vid">
										<img src="../img/video.jpg" class="card-img-top img-fluid" style="width: 10rem; height: 10rem;" alt="...">
									</div>
									<h6 class="card-title">Video</h6>
									<div class="input-group">
										<button type="button" class="btn btn-primary btn-sm" onclick="document.getElementById('video').click();"><i class="bi bi-upload"></i> Video</button>
										<input type="text" class="form-control form-control-sm text-center" name="nm_video" id="nm_video" readonly>
									</div>
									<input class="form-control form-control-sm" id="video" name="video" type="file" accept=".mp4,.avi,.mkv" hidden>
								</div>
							</div>
						</div>
					</div>
				</div>

				<!-- View Jenis Soal -->
				<div id="v_jnss"></div>

				<!-- Pilihan Ganda & Menjodohkan -->
				<div class="row m-2 border border-info" style="border-radius: 5px;" id="opjw">
					<div class="col-12 bg-info p-2">Opsi Jawaban</div>
					<?php for ($i = 1; $i <= 5; $i++) { ?>
						<div class="col-12 p-2" style="border-radius: 3px;">
							<div class="border border-info-subtle" style="border-radius: 5px;">
								<div class="row m-0 bg-info-subtle p-2 justify-content-center justify-content-md-start">
									<div class="col-auto">Jawaban <?= $i ?></div>
									<div class="col-auto form-check form-switch" id="key_p<?= $i ?>">
										<input type="radio" class="form-check-input" role="switch" name="keyopsi" id="keyopsi" value="<?= $i ?>" required>
									</div>
								</div>
								<div class="row g-3 p-3 justify-content-center">
									<div class="col-md-2 col-auto text-center">
										<input class="form-control form-control-sm" id="imgjw<?= $i ?>" name="imgjw<?= $i ?>" type="file" accept=".jpg,.jpeg,.png" hidden>
										<label for="imgjw<?= $i ?>" style="cursor: pointer;">
											<img src="<?= empty($dts["img$i"]) ? '../img/img.png' : '../images/' . $dts["img$i"]; ?>" id="img<?= $i ?>" class="card-img-top img-fluid" alt="..." style="height: 7rem;">
										</label>
										<input type="text" class="form-control form-control-sm text-center m-1" name="img<?= $i ?>jw" id="img<?= $i ?>jw" readonly onfocus="clearInput(this)">
									</div>
									<div class="col-md-10 col">
										<div class="row g-1 m-0">

											<div class="col-12 border border-secondary-subtle p-0">
												<textarea name="opsi<?= $i ?>" id="opsi<?= $i ?>"></textarea>
												<div class="word-count" id="cr_opsi<?= $i ?>"></div>
											</div>

											<div class="col-12 border border-secondary-subtle p-0 mt-3 hide" id="ljdh<?= $i ?>" style="border-radius: 5px;">
												<div class="row m-0 bg-secondary-subtle px-2 py-1">Opsi jodoh
												</div>
												<textarea name="jdh<?= $i ?>" id="jdh<?= $i ?>"></textarea>
												<div class="word-count" id="cr_jdh<?= $i ?>"></div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					<?php } ?>
				</div>

				<!-- Menjodohkan -->
				<!-- <div class="row m-2 border border-info hide" style="border-radius: 5px;" id="jdh">
					<div class="col-12 bg-info p-2">Opsi Menjodohkan</div>
					<div class="col-12 p-2" style="border-radius: 3px;">
						<div class="row m-0 bg-info-subtle p-2 justify-conten-center justify-content-md-start">Opsi 1</div>
						<div class="row gap-3 p-3 justify-content-center">
							<div class="col-md-2 col-auto text-center">
								<input class="form-control form-control-sm" id="imgjw1" name="imgjw1" type="file" accept=".jpg,.jpeg,.png" hidden>
								<label for="imgjw1" style="cursor: pointer;">
									<img src="<?php echo empty($dts["img1"]) ? '../img/img.png' : '../images/' . $dts["img1"]; ?>" id="img1" class="card-img-top img-fluid" alt="..." style="height: 7rem;">
								</label>
								<input type="text" class="form-control form-control-sm text-center m-1" name="img1jw" id="img1jw" readonly onfocus="clearInput(this)">
							</div>
							<div class="col-md-4 col">1</div>
							<div class="col-md-4 col">2</div>
						</div>
					</div>
				</div> -->

				<!-- Benar/Salah -->
				<!-- <div class="row m-2 border border-info hide" style="border-radius: 5px;" id="bas">
					<div class="col-12 bg-info p-2">Opsi Benar/Salah</div>
					<div class="col-12 p-2" style="border-radius: 3px;">
						<div class="row m-0 bg-info-subtle p-2 justify-conten-center justify-content-md-start">Opsi 1</div>
						<div class="row gap-3 p-3 justify-content-center">
							<div class="col-md-4 col">Benar</div>
							<div class="col-md-4 col">Salah</div>
						</div>
					</div>
				</div> -->

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
			const jnsSoal = $('#jns_soal').val();
			if (jnsSoal === 'G') {
				$("#opjw").removeClass("hide");
				$("#ackopsi").removeClass("hide");
				for (let i = 1; i <= 5; i++) {
					$('#ljdh' + i).addClass("hide");
					$('#key_p' + i).removeClass("hide");
					$("#keyopsi").attr("required", true);
				}
				// $('#bas').addClass("hide");

			} else if (jnsSoal === 'J') {
				$("#opjw").removeClass("hide");
				$("#ackopsi").addClass("hide");
				for (let i = 1; i <= 5; i++) {
					$('#ljdh' + i).removeClass("hide");
					$('#key_p' + i).addClass("hide");
					$("#keyopsi").attr("required", false);
				}
				// $('#bas').addClass("hide");

			// } else if (jnsSoal === 'X') {
			// 	$('#bas').removeClass("hide");
			// 	$("#opjw").addClass("hide");
			// 	$("#ackopsi").addClass("hide");
			// 	for (let i = 1; i <= 5; i++) {
			// 		$("#keyopsi").attr("required", false);
			// 	}
			// 	$('#jdh').addClass("hide");
				
			} else {
				$("#opjw").addClass("hide");
				$("#ackopsi").addClass("hide");
				for (let i = 1; i <= 5; i++) {
					$("#keyopsi").attr("required", false);
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

	<!-- Dropdown Jenis Soal -->
	<script>
		// $(document).ready(function() {
		// 	$("#jns_soal").change(function() {
		// 	var jnss = $(this).val();

		// 		$.ajax({
		// 			type: "POST",
		// 			url: "./db/jns_soal.php",
		// 			data: {
		// 				jnss: jnss
		// 			},
		// 			success: function(data) {
		// 				$("#v_jnss").html(data);
		// 				// console.log(data);
		// 			}
		// 		});
		// 	});
		// });
		// function selectJnsSoal(id){
		// }
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

	<!-- Audio Preview -->
	<script>
		document.getElementById('audio').addEventListener('change', function(event) {
			const file = event.target.files[0];
			const audio = document.getElementById('p_aud');

			if (file) {
				const url = URL.createObjectURL(file);
				audio.innerHTML = `<audio controls controlsList="nodownload" src="${url}" style="width: 100%;"></audio>`;
				$('#nm_audio').val("<?php echo 'au_' . $kds . "_"; ?>" +
					"<?php echo !empty($idts['no_soal']) ? $idts['no_soal'] : 1; ?>");
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
					"<?php echo !empty($idts['no_soal']) ? $idts['no_soal'] : 1; ?>");
			}
		});
	</script>