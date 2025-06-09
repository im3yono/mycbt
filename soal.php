<?php
include_once("config/server.php");
$kds = $_POST['kds'];
$nos = $_POST['nos'];
$usr = $_POST['usr'];
$token = $_POST['tkn'];

// echo "<br>". $kds." ".$nos." ".$usr." ".$token;

$cek_ip = mysqli_fetch_array(mysqli_query($koneksi, "SELECT ip,sts FROM peserta_tes WHERE user='$usr' AND kd_soal='$kds' AND token='$token'"));
if (empty($cek_ip['ip'])) {
	echo '<script>window.location="/' . $fd_root . '/?knf=rest"	</script>';
} elseif (($cek_ip['ip']) != get_ip()) {
	echo '<script>window.location="logout.php?info=on"	</script>';
}
if ($cek_ip['sts'] == "S") {
	echo '<script>window.location="logout.php?info=selesai"</script>';
}


function clear($data)
{
	$data = str_replace("<p>", "", $data);
	$data = str_replace("</p>", "", $data);

	return $data;
};

// No Images
function imgs($lok, $imgs)
{
	if (!empty($imgs)) {
		if (file_exists("$lok/$imgs")) {
			echo $lok . '/' . $imgs;
		} else {
			echo "img/No_image_available.svg.png" . '" style="min-width:90px;"';
		}
	}
};


$sql_opsi = "SELECT * FROM cbt_ljk WHERE user_jawab ='$usr' AND token = '$token' AND urut ='$nos'";
$dt_opsi  = mysqli_fetch_array(mysqli_query($koneksi, $sql_opsi));
// echo $dt_opsi['no_soal'];
if (!empty($dt_opsi['no_soal'])) {
	$sql_soal = "SELECT * FROM cbt_soal WHERE kd_soal ='$kds' AND no_soal ='$dt_opsi[no_soal]';";
	// $sql_soal ="SELECT * FROM cbt_soal WHERE kd_soal ='X_BIndo' AND no_soal ='16';";

	$dt_soal = mysqli_fetch_array(mysqli_query($koneksi, $sql_soal));

	// LJK
	$jw_a   = "jwb" . $dt_opsi['A'];
	$jw_b   = "jwb" . $dt_opsi['B'];
	$jw_c   = "jwb" . $dt_opsi['C'];
	$jw_d   = "jwb" . $dt_opsi['D'];
	$jw_e   = "jwb" . $dt_opsi['E'];

	$img1   = "img" . $dt_opsi['A'];
	$img2   = "img" . $dt_opsi['B'];
	$img3   = "img" . $dt_opsi['C'];
	$img4   = "img" . $dt_opsi['D'];
	$img5   = "img" . $dt_opsi['E'];

	// kunci
	$key = $dt_opsi['knci_jwbn'];

	$jwbn   = $dt_opsi['jwbn'];
	$niljw  = $dt_opsi['nil_jwb'];
	$jwb_es = $dt_opsi['es_jwb'];

	// Soal
	$ids		= $dt_soal['id_soal'];
	$audio  = $dt_soal['audio'];
	$vid    = $dt_soal['vid'];
	$img    = $dt_soal['img'];
	$des    = ($dt_soal['cerita']);
	$kd_des = ($dt_soal['kd_crta']);
	$tanya  = ($dt_soal['tanya']);

	$op_a   = $dt_soal[$jw_a];
	$img_a  = $dt_soal[$img1];

	$op_b   = $dt_soal[$jw_b];
	$img_b  = $dt_soal[$img2];

	$op_c   = $dt_soal[$jw_c];
	$img_c  = $dt_soal[$img3];

	$op_d   = $dt_soal[$jw_d];
	$img_d  = $dt_soal[$img4];

	$op_e   = $dt_soal[$jw_e];
	$img_e  = $dt_soal[$img5];

	// Play Media
	$pl_audio = $dt_opsi['pl_a'] == 0 ? 0 : $dt_opsi['pl_a'];
	$pl_vid   = $dt_opsi['pl_v'] == 0 ? 0 : $dt_opsi['pl_v'];



	if ($kd_des == 0) {
		$cerita = $des;
	} else {
		$kd_crt		= mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM cbt_soal WHERE no_soal ='$kd_des' AND kd_soal ='$kds'"));
		if (!empty($kd_crt['cerita'])) {
			$cerita = $kd_crt['cerita'];
		} else {
			$cerita = "Error Line 1" . $dt_soal['no_soal'] . ":<br>Deskripsi tidak tersedia";
			$crt = 'bg-danger text-white  text-center';
		}
	}

	// echo $nos;
	// echo $dt_soal['audio'];
	// echo $dt_soal['vid'];
	// echo $dt_soal['img'];
	// echo $dt_soal['tanya'];

	// echo $dt_soal['jwb1'];
	// echo $dt_soal['img1'];

	// echo $dt_soal['jwb2'];
	// echo $dt_soal['img2'];

	// echo $dt_soal['jwb3'];
	// echo $dt_soal['img3'];

	// echo $dt_soal['jwb4'];
	// echo $dt_soal['img4'];

	// echo $dt_soal['jwb5'];
	// echo $dt_soal['img5'];


?>

	<!-- === Media === -->
	<?php if (!empty($img or $audio or $vid)) { ?>
		<div class="row m-3 gap-2 text-center justify-content-around">

			<?php if (!empty($vid) && $pl_vid != '0') { ?>
				<div class="col-12">
					<div class="video-wrapper">
						<div class="alert alert-info text-center p-1 my-1 mx-0" role="alert" id="pl_vid"><?= $pl_vid > 0 ? 'Video hanya dapat diputar ' . $pl_vid . ' kali perhatikan dan berikan jawaban' : 'Tidak dapat diputar'; ?> </div>

						<video controlsList="nodownload" preload="none" class="" src="video/<?= $vid ?>" class="object-fit-contain" id="videoPlayer"></video>
					</div>

					<button class="btn btn-outline-dark" id="btn_vid">
						<div class="fs-1" id="play_vid"><i class="bi bi-play-btn"></i></div>Putar Video
					</button>

				</div>
			<?php }
			if (!empty($audio) && $pl_audio != '0') { ?>
				<div class="col-12">
					<div class="alert alert-info text-center p-1 my-1 mx-0" role="alert" id="pl_audio"><?= $pl_audio > 0 ? 'Audio hanya dapat diputar ' . $pl_audio . ' kali perhatikan dan berikan jawaban' : 'Tidak dapat diputar'; ?> </div>
					<?php
					$playCount = $pl_audio; // Ambil jumlah pemutaran dari database
					?>

					<audio controlsList="nodownload" preload="none" class="" id="audioPlayer">
						<source src="audio/<?= $audio ?>" type="audio/mpeg">
						Browsermu tidak mendukung tag audio
					</audio>
					<button class="btn btn-outline-dark" id="btn_ply">
						<div class=" fs-1" id="play_btn"><i class="bi bi-play-circle"></i></div> Putar Audio
					</button>
				</div>
			<?php }
			if (!empty($img)) { ?>
				<div class="col-12">
					<button type="button" class="btn " data-bs-toggle="modal" data-bs-target="#zoom">
						<img src="<?php imgs('images', $img) ?>" alt="" srcset="" class="media" id="myImgt">
					</button>
				</div>
			<?php } ?>
		</div>
	<?php } ?>
	<!-- === Akhir Media === -->

	<!-- === Deskripsi Soal=== -->
	<?php if (!empty($des || $kd_des)) { ?>
		<div class="row m-md-3 m-0 justify-content-center border" style="border-top-left-radius: 5px;border-top-right-radius: 5px;">
			<div class="fs-md-5 col col-sm-8 py-4 <?= $crt ?>" id="des"><?= $cerita ?></div>
		</div>
		<!-- === Akhir Deskripsi Soal=== -->

		<!-- === Soal Pilihan Ganda === -->
	<?php }
	if ($dt_soal["jns_soal"] == "G") { ?>
		<div class="row m-md-3 pt-2 m-1 justify-content-around">
			<h5 class="fw-semibold text-decoration-underline">Pilihan Ganda</h5>
			<div class="fs-md-5"><?= $tanya ?></div>
		</div>

		<!-- === Opsi Jawaban === -->
		<div class="row mx-md-5 mx-auto my-3 fs-6 fs-md-5 gap-3">
			<div class="col-12">
				<div class="row justify-content-md-start justify-content-center">
					<div class="col-auto" id="tes"></div>
				</div>
			</div>

			<?php
			$options = ['A', 'B', 'C', 'D', 'E']; // Menyimpan opsi
			foreach ($options as $option) :
				$jwbnChecked = ($jwbn == $option) ? "checked" : "";
				$op = ${'op_' . strtolower($option)}; // Mendapatkan opsi soal
				$img = ${'img_' . strtolower($option)}; // Mendapatkan gambar soal
			?>

				<div class="row align-middle">
					<div class="col-auto pe-0">
						<input type="radio" class="btn-check" name="jwb" id="jwb<?= $option ?>" value="<?= $option ?>" autocomplete="off" <?= $jwbnChecked ?>>
						<label class="btn btn-sm btn-outline-dark fw-semibold fs-md-5 text-start" for="jwb<?= $option ?>"><?= $option ?></label>
					</div>
					<div class="col-auto"><?= $op ?></div>

					<?php if (!empty($img)) : ?>
						<div class="col-auto">
							<button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#zoom">
								<img src="<?php imgs('images', $img) ?>" alt="" class="img-thumbnail" style="max-width: 240px;" width="240px" id="myImg<?= $option ?>">
							</button>
						</div>
					<?php endif; ?>
				</div>

			<?php endforeach; ?>
		</div>

		<!-- === Akhir Opsi Jawaban === -->
		<!-- === Akhir Soal Pilihan Ganda === -->

		<!-- === Soal Esai === -->
	<?php }
	if ($dt_soal["jns_soal"] == "E") { ?>
		<div class="row m-md-3 pt-2 m-1 justify-content-around">
			<h5 class="fw-semibold text-decoration-underline">Esai</h5>
			<div class="fs-md-5 "><?= $tanya ?></div>
		</div>
		<!-- === Jawabn Esai === -->
		<!-- 
			<div class="form-floating mx-4 mb-3">
				<textarea class="form-control" id="jwb_esai" name="jwb_esai"><?= $jwb_es ?></textarea>
				<label for="jwb_esai">Jawaban</label>
			</div>
		</div> -->
		<div class="row mx-md-4 mx-1 mb-3 border" style="border-radius: 5px;">
			<label for="jwb_esai" class="form-label fs-5 fw-bold fs-md-5 bg-info py-1 px-2 m-0" style="border-top-left-radius: 5px;border-top-right-radius: 5px;">Jawaban</label>
			<textarea class="form-control fs-md-5" id="jwb_esai" name="jwb_esai" rows="3"><?= $jwb_es ?></textarea>
		</div>
		<!-- === Akhir Jawabn Esai === -->
		<!-- === Akhir Soal Esai === -->
<?php }
} else {
	echo "<div class='col text-center p-3 fs-4'>Soal Tidak di Temukan</div>";
} ?>


<!-- === Modal === -->
<div id="myModalimg" class="modal">
	<span class="close">&times;</span>
	<img class="modal-content" id="img01">
	<div id="caption"></div>
</div>




<script src="node_modules/jquery/dist/jquery.min.js"></script>
<!-- <script src="aset/ckeditor/build/ckeditor.js"></script> -->

<!-- Fungsi modal Upload -->
<script>
	// Dapatkan elemen modal dan elemen yang akan digunakan dalam modal
	var modal = document.getElementById("myModalimg");
	var modalImg = document.getElementById("img01");
	var captionText = document.getElementById("caption");

	// Daftar ID gambar yang akan memiliki fungsi klik untuk membuka modal
	var imageIds = ["myImgt", "myImgA", "myImgB", "myImgC", "myImgD", "myImgE"];

	// Menambahkan event klik untuk setiap gambar dalam daftar
	imageIds.forEach(function(id) {
		var img = document.getElementById(id);
		if (img) {
			img.onclick = function() {
				modal.style.display = "block";
				modalImg.src = this.src;
				captionText.innerHTML = this.alt;
			}
		}
	});

	// Fungsi untuk menutup modal saat diklik di luar gambar
	modal.onclick = function() {
		modal.style.display = "none";
	}
</script>

<script>
	// Dapatkan elemen modal dan elemen di dalam modal
	var modal = document.getElementById("myModalimg");
	var modalImg = document.getElementById("img01");
	var captionText = document.getElementById("caption");

	// Dapatkan semua elemen gambar dengan kelas tertentu
	// var images = document.querySelectorAll(".image_resized");
	var images = document.querySelectorAll(".image_resized");

	// Tambahkan event listener ke setiap elemen gambar
	images.forEach(function(img) {
		img.addEventListener("click", function() {
			modal.style.display = "block"; // Tampilkan modal
			modalImg.src = this.src; // Ambil sumber gambar base64
			captionText.innerHTML = this.alt; // Ambil teks alternatif gambar
		});
	});

	// Tambahkan event untuk menutup modal
	modal.addEventListener("click", function() {
		modal.style.display = "none"; // Sembunyikan modal
	});
</script>

<script>
	// Dapatkan elemen modal dan elemen di dalam modal
	var modal = document.getElementById("myModalimg");
	var modalImg = document.getElementById("img01");
	var captionText = document.getElementById("caption");

	// Pastikan modal dan elemen-elemen yang diperlukan ada
	if (modal && modalImg && captionText) {
		// Dapatkan semua elemen figure dengan kelas 'image_resized' yang berisi gambar
		var figures = document.querySelectorAll(".image_resized");

		// Tambahkan event listener ke setiap tag figure yang berisi gambar
		figures.forEach(function(figure) {
			// Cari elemen <img> di dalam figure
			var img = figure.querySelector("img");

			// Pastikan gambar ditemukan dan memiliki sumber (src)
			if (img && img.src) {
				img.addEventListener("click", function() {
					// Tampilkan modal
					modal.style.display = "block";

					// Pastikan gambar memiliki sumber (src)
					if (this.src) {
						modalImg.src = this.src; // Ambil sumber gambar base64 atau URL
					} else {
						console.error("Gambar tidak memiliki sumber (src).");
					}

					// Tampilkan teks alternatif gambar, jika ada
					captionText.innerHTML = this.alt || "No caption available";
				});
			} else {
				console.warn("Gambar tidak ditemukan di dalam figure.");
			}
		});

		// Tambahkan event untuk menutup modal
		modal.addEventListener("click", function(event) {
			// Periksa apakah klik berada di luar gambar modal untuk menutupnya
			if (event.target === modal) {
				modal.style.display = "none"; // Sembunyikan modal
			}
		});
	} else {
		console.error("Elemen modal atau elemen lainnya tidak ditemukan.");
	}
</script>



<script>
	// Get the <span> element that closes the modal
	var span = document.getElementsByClassName("close")[0];

	// When the user clicks on <span> (x), close the modal
	span.onclick = function() {
		modal.style.display = "none";
	}
</script>
<script>
	// Simpan Jawaban Pilgan
	$(document).ready(function() {
		$('input[type="radio"]').click(function() {
			var jwb = $(this).val();
			console.log(jwb);
			$.ajax({
				url: "soal_jwb.php?tkn=<?= $token ?>&kds=<?= $kds ?>&id=<?= $ids ?>&nj=<?= "" ?>",
				method: "POST",
				data: {
					opsi: jwb,
					nos: <?= $nos ?>
				},
				success: function(data) {
					$("#jb").html(data);
					document.getElementById("abc<?= $nos ?>").innerHTML = jwb;
					document.getElementById("ns<?= $nos ?>").classList.add("btn-secondary");
					document.getElementById("ns<?= $nos ?>").classList.remove("btn-outline-secondary");
				}
			})
		})
	})
</script>
<script>
	// Simpan Jawaban Esai
	var timeoutId; // Variabel untuk menyimpan ID timeout

	// Fungsi untuk mengirim data ke server
	function kirimDataKeServer(data) {
		// Gunakan AJAX untuk mengirim data ke server
		$.ajax({
			type: 'POST',
			url: 'soal_jwb.php?tkn=<?= $token ?>&kds=<?= $kds ?>&id=<?= $ids ?>&nj=<?= "" ?>', // Ganti dengan URL atau path ke skrip PHP untuk menyimpan data
			data: {
				esai: data,
				nos: <?= $nos ?>
			},
			success: function(data) {
				$("#jb").html(data);
				document.getElementById("abc<?= $nos ?>").innerHTML = '<i class="bi bi-check2"></i>';
				document.getElementById("ns<?= $nos ?>").classList.add("btn-secondary");
				document.getElementById("ns<?= $nos ?>").classList.remove("btn-outline-secondary");
			},
			error: function(xhr, status, error) {
				console.error('Terjadi kesalahan:', error);
			}
		});
	}

	// Fungsi yang akan dipanggil saat pengguna berhenti mengetik
	function onBerhentiMengetik() {
		var dataInputValue = $('#jwb_esai').val();
		kirimDataKeServer(dataInputValue);
	}

	// Event listener untuk mendeteksi setiap kali pengguna mengetik
	$('#jwb_esai').on('input', function() {
		// Hapus timeout sebelumnya jika ada
		clearTimeout(timeoutId);

		// Atur timeout baru untuk menunggu pengguna berhenti mengetik selama 1 detik
		timeoutId = setTimeout(onBerhentiMengetik, 1000);
	});
</script>

<!-- Format gambar text -->
<script type="text/javascript">
	function resetAndAddStyle(className, newStyle) {
		const elements = document.querySelectorAll(`.${className}`);
		elements.forEach(element => {
			// element.removeAttribute('style'); // Hapus atribut style
			element.setAttribute('style', newStyle); // Tambahkan atribut style baru
			// element.setAttribute('id', newStyle); // Tambahkan atribut style baru
		});
	}

	resetAndAddStyle('image_resized', 'width:auto;max-height:700px;');
</script>

<!-- AUDIO & VIDEO SCRIPT -->
<?php if (!empty($vid) && $pl_vid != '0' || !empty($audio) && $pl_audio != '0') { ?>
	<script>
		function handleMedia(mediaId, btnId, infoId, type) {
			const media = document.getElementById(mediaId);
			const btn = $("#" + btnId);
			const info = $("#" + infoId);

			function togglePlay() {
				media.play();
				btn.attr('disabled', true);
			}

			function pauseOnNavigation() {
				if (!media.paused) {
					media.pause();
					btn.attr('disabled', false);
				}
			}

			// Event ketika media selesai diputar
			media.addEventListener('ended', () => btn.attr('disabled', false));

			// Event klik tombol play
			$(document).ready(() => {
				btn.on('click', function() {
					const jwb = "1";
					// console.log(jwb);
					$.ajax({
						url: "soal_jwb.php?tkn=<?= $token ?>&kds=<?= $kds ?>&id=<?= $ids ?>&nj=<?= "" ?>",
						method: "POST",
						data: {
							[type]: jwb,
							nos: <?= $nos ?>
						},
						success: function(data) {
							info.html((type === "audio" ? "Audio" : "Video") + " hanya dapat diputar " + data + " kali lagi");
							if (data == 0) {
								info.attr('hidden', true);
								btn.attr('hidden', true);
							}
						}
					});
					togglePlay();
				});
			});

			// Tambah pause saat navigasi
			['btn_nx', 'btn_pr', 'df_soal'].forEach(id =>
				document.getElementById(id).addEventListener('click', pauseOnNavigation)
			);
		}

		// Inisialisasi audio dan video
		<?= !empty($audio) && $pl_audio != '0' ? "handleMedia('audioPlayer', 'btn_ply', 'pl_audio', 'audio');" : ""; ?>
		<?= !empty($vid) && $pl_vid != '0' ? "handleMedia('videoPlayer', 'btn_vid', 'pl_vid', 'vid');" : ""; ?>
	</script>
<?php } ?>