<?php

if (isset($_GET['st']) == 'ok') {

	include_once('../config/server.php');
	include_once('../config/server_m.php');

	$kls_sc = mysqli_fetch_array(mysqli_query($koneksi, "SELECT COUNT(*) AS jml FROM `kelas`;"));
	$kls_sm = mysqli_fetch_array(mysqli_query($sm_kon, "SELECT COUNT(*) AS jml FROM `kelas`;"));

	$peserta_sc = mysqli_fetch_array(mysqli_query($koneksi, "SELECT COUNT(*) AS jml FROM `cbt_peserta`;"));
	$peserta_sm = mysqli_fetch_array(mysqli_query($sm_kon, "SELECT COUNT(*) AS jml FROM `cbt_peserta`;"));

	$mapel_sc = mysqli_fetch_array(mysqli_query($koneksi, "SELECT COUNT(*) AS jml FROM `mapel`;"));
	$mapel_sm = mysqli_fetch_array(mysqli_query($sm_kon, "SELECT COUNT(*) AS jml FROM `mapel`;"));

	$ptk_sc = mysqli_fetch_array(mysqli_query($koneksi, "SELECT COUNT(*) AS jml FROM `cbt_pktsoal`;"));
	$pkt_sm = mysqli_fetch_array(mysqli_query($sm_kon, "SELECT COUNT(*) AS jml FROM `cbt_pktsoal`;"));

	$soal_sc = mysqli_fetch_array(mysqli_query($koneksi, "SELECT COUNT(*) AS jml FROM `cbt_soal`;"));
	$soal_sm = mysqli_fetch_array(mysqli_query($sm_kon, "SELECT COUNT(*) AS jml FROM `cbt_soal`;"));

	$jdwl_sc = mysqli_fetch_array(mysqli_query($koneksi, "SELECT COUNT(*) AS jml FROM `jdwl`;"));
	$jdwl_sm = mysqli_fetch_array(mysqli_query($sm_kon, "SELECT COUNT(*) AS jml FROM `jdwl`;"));


?>
	<style>
		.sync {
			background-color: aqua;
			z-index: 2;
		}

		/* Gaya tabel */
		.table-responsive th:nth-child(1),
		.table-responsive td:nth-child(1) {
			max-width: 45px;
			text-align: center;
			align-content: baseline;
		}

		.table-responsive th:nth-child(2),
		.table-responsive td:nth-child(2) {
			min-width: 350px;
			text-align: center;
			align-content: baseline;
		}

		.table-responsive th:nth-child(3),
		.table-responsive td:nth-child(3) {
			min-width: 350px;
			text-align: center;
			align-content: baseline;
		}

		.table-responsive th:nth-child(4),
		.table-responsive td:nth-child(4) {
			max-width: 150px;
			text-align: center;
			align-content: baseline;
		}

		.table-responsive th:nth-child(5),
		.table-responsive td:nth-child(5) {
			min-width: 100px;
			text-align: center;
			align-content: baseline;
		}
	</style>

	<div class="container-fluid mb-5 p-0">
		<div class="row p-2 border-bottom fs-3 mb-4 shadow-sm text-uppercase">Sinkronisasi</div>
		<div class="row mb-2 border-bottom pb-2 shadow-sm">
			<div class="col-auto mx-3">
				<p class="bg-success-subtle p-2 fs-6" style="border-radius: 7px;">Catatan : <br>
					1. Pastikan sebelum melakukan Sinkronisasi <b>IP dan database</b> sudah di setting pada pengaturan agar proses berjalan dengan lancar. <br>
					2. Pastikan Pengaturan php.ini bagian max_execution_time=3000. <br>
					3. Tarik Data Yang Dibutuhkan Agar Proses Lebih cepat.</b>
				</p>
			</div>
		</div>
		<div class="row pt-2 mx-3">

			<ul class="nav nav-tabs" id="myTab" role="tablist">
				<li class="nav-item" role="presentation">
					<button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#tarik" type="button" role="tab" aria-controls="tarik" aria-selected="true">Tarik Data</button>
				</li>
				<li class="nav-item" role="presentation">
					<button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#upload" type="button" role="tab" aria-controls="upload" aria-selected="false">Upload Hasil</button>
				</li>
			</ul>
			<div class="tab-content border border-top-0" id="myTabContent">
				<div class="tab-pane fade show active" id="tarik" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
					<div class="row p-2 border-bottom fs-3 mb-4 shadow-sm text-uppercase">Tarik Data Server Master</div>
					<div class="row m-0">
						<div class="col-12  mb-1 fs-6 fw-semibold">Kelas : <span id="kls"><?= $kls_sc['jml']; ?></span> data - Server Master : <span id="kls2"><?= $kls_sm['jml']; ?></span> data
							<div class="progress" role="progressbar" aria-label="Animated striped example" aria-valuemin="0" aria-valuemax="100" style="height: 25px;">
								<div class="progress-bar progress-bar-striped progress-bar-animated" style="width: 0" id="tr_kelas"></div>
							</div>
							<button type="button" class="btn btn-success my-2" onclick="tarikData('kelas','tr_kelas','kls','kls2')"><i class="bi bi-cloud-arrow-down"></i> Tarik data Kelas</button>
						</div>

						<div class="col-12 mb-1 fs-6 fw-semibold">Peserta : <span id="psrta"><?= $peserta_sc['jml']; ?></span> data - Server Master : <span id="psrta2"><?= $peserta_sm['jml']; ?></span> data
							<div class="progress" role="progressbar" aria-label="Animated striped example" aria-valuemin="0" aria-valuemax="100" style="height: 25px;">
								<div class="progress-bar progress-bar-striped progress-bar-animated" style="width: 0" id="tr_peserta"></div>
							</div>
							<button type="button" class="btn btn-success my-2" onclick="tarikData('peserta','tr_peserta','psrta','psrta2')"><i class="bi bi-cloud-arrow-down"></i> Tarik data Peserta</button>
						</div>

						<div class="col-12 mb-1 fs-6 fw-semibold">Mapel : <span id="mapel"><?= $mapel_sc['jml']; ?></span> data - Server Master : <span id="mapel2"><?= $mapel_sm['jml']; ?></span> data
							<div class="progress" role="progressbar" aria-label="Animated striped example" aria-valuemin="0" aria-valuemax="100" style="height: 25px;">
								<div class="progress-bar progress-bar-striped progress-bar-animated" style="width: 0" id="tr_mpel"></div>
							</div>
							<button type="button" class="btn btn-success my-2" onclick="tarikData('mapel','tr_mpel','mapel','mapel2')"><i class="bi bi-cloud-arrow-down"></i> Tarik data Mata Pelajaran</button>
						</div>

						<div class="col-12 mb-1 fs-6 fw-semibold">Paket Soal : <span id="paket"><?= $ptk_sc['jml']; ?></span> data - Server Master : <span id="paket2"><?= $pkt_sm['jml']; ?></span> data
							<div class="progress" role="progressbar" aria-label="Animated striped example" aria-valuemin="0" aria-valuemax="100" style="height: 25px;">
								<div class="progress-bar progress-bar-striped progress-bar-animated" style="width: 0" id="tr_psoal"></div>
							</div>
							<button type="button" class="btn btn-success my-2" onclick="tarikData('p_soal','tr_psoal','paket','paket2')"><i class="bi bi-cloud-arrow-down"></i> Tarik data Soal</button>
						</div>

						<div class="col-12 mb-1 fs-6 fw-semibold">Soal : <span id="soal"><?= $soal_sc['jml']; ?></span> data - Server Master : <span id="soal2"><?= $soal_sm['jml']; ?></span> data
							<div class="progress" role="progressbar" aria-label="Animated striped example" aria-valuemin="0" aria-valuemax="100" style="height: 25px;">
								<div class="progress-bar progress-bar-striped progress-bar-animated" style="width: 0" id="tr_soal"></div>
							</div>
							<button type="button" class="btn btn-success my-2" onclick="tarikData('soal','tr_soal','soal','soal2')"><i class="bi bi-cloud-arrow-down"></i> Tarik data Soal</button>
						</div>

						<div class="col-12 mb-1 fs-6 fw-semibold">File Pendukung Soal :
							<?php
							$photos = glob('../images/*');
							$photos_count = !empty($photos) ? count($photos) : 0;
							echo '<span id="file">' . $photos_count . '</span>';
							?>
							data - Server Master :
							<?php
							$url = $server_ms['ip_sv'] . '/' . $server_ms['fdr'] . '/api/images.php';
							// $url = "192.168.100.7/tbk/api/images.php";

							$ch = curl_init();
							curl_setopt($ch, CURLOPT_URL, $url);
							curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
							$json_data = curl_exec($ch);
							curl_close($ch);

							// Decode JSON ke array
							$response = json_decode($json_data, true);

							// Ambil nilai total_images
							$total_images = $response['total_images'] ?? 0;

							echo '<span id="file2">' . $total_images . '</span>';
							?> data
							<div class="progress" role="progressbar" aria-label="Animated striped example" aria-valuemin="0" aria-valuemax="100" style="height: 25px;">
								<div class="progress-bar progress-bar-striped progress-bar-animated" style="width: 0" id="tr_file"></div>
							</div>
							<button type="button" class="btn btn-success my-2" onclick="tarikData('dfile','tr_file','file','file2')"><i class="bi bi-cloud-arrow-down"></i> Tarik data Pendukung Soal</button>
						</div>

						<div class="col-12 mb-1 fs-6 fw-semibold">Jadwal : <span id="jdwl"><?= $jdwl_sc['jml']; ?></span> data - Server Master : <span id="jdwl2"><?= $jdwl_sm['jml']; ?></span> data
							<div class="progress" role="progressbar" aria-label="Animated striped example" aria-valuemin="0" aria-valuemax="100" style="height: 25px;">
								<div class="progress-bar progress-bar-striped progress-bar-animated" style="width: 0" id="tr_jdwl"></div>
							</div>
							<button type="button" class="btn btn-success my-2" onclick="tarikData('jdwl','tr_jdwl','jdwl','jdwl2')"><i class="bi bi-cloud-arrow-down"></i> Tarik data Jadwal</button>
						</div>

					</div>
				</div>
				<div class="tab-pane fade" id="upload" role="tabpanel" aria-labelledby="profile-tab" tabindex="0"><?php include_once("up_hasil.php") ?></div>
				<div class="tab-pane fade" id="contact-tab-pane" role="tabpanel" aria-labelledby="contact-tab" tabindex="0">...</div>
				<div class="tab-pane fade" id="disabled-tab-pane" role="tabpanel" aria-labelledby="disabled-tab" tabindex="0">...</div>
			</div>

		</div>
	</div>


	<!-- Javascript -->
	<script>
		function lockSts(id) {
			// var icon = button.querySelector("i");
			var icon = document.getElementById('icn_sts' + id);

			if (icon.classList.contains("bi-unlock")) {
				icon.classList.remove("bi-unlock");
				icon.classList.add("bi-lock");
			} else {
				icon.classList.remove("bi-lock");
				icon.classList.add("bi-unlock");
			}
		}
	</script>
	<script>
		function izinAkses() {
			// var statusKoneksi = document.getElementById("status_izin");

			// statusKoneksi.innerHTML = "Menghubungkan...";

			// fetch("../config/m_db.php?sm=izin", 
			$.ajax({
				type: 'POST',
				url: '../config/m_db.php?sm=izin', // Ganti dengan URL yang benar
				// data: {
				// 	del_bkp: del_bkp
				// }, // Kirim ID data yang ingin dihapus
				success: function(response) {
					// Tampilkan pesan hasil hapus dari server
					// location.reload();
					Swal.fire('Berhasil!', response, 'success')
						.then((result) => {
							// Jika notifikasi ditutup, muat ulang halaman
							if (result.isConfirmed || result.isDismissed) {
								location.reload();
							}
						});
				},
				error: function() {
					Swal.fire('Error', 'An error occurred.', 'error');
				}
			});
		}
	</script>
	<script>
		function tarikData(trdata, progres, data, data2) {
			var data2Text = $("#" + data2).text();
			var progressBar = $("#" + progres);
			var targetData = $("#" + data);

			progressBar.width("0%").html("0%");

			var startTime = Date.now() - 1000; // Waktu mulai proses
			var estimatedTime = 50 * data2Text; // Perkiraan waktu proses (ms), bisa disesuaikan

			// Interval untuk memperbarui progress jika upload progress tidak berjalan
			var interval = setInterval(function() {
				var elapsedTime = Date.now() - startTime;
				var progressPercent = Math.min((elapsedTime / estimatedTime) * 100, 98).toFixed(2);
				progressBar.width(progressPercent + "%").html(progressPercent + "%");
			}, 500);

			$.ajax({
				type: "POST",
				url: "db/tr_data.php",
				data: {
					td: trdata
				},
				beforeSend: function() {
					progressBar.width("0%").html("0%");
				},
				xhr: function() {
					var xhr = new window.XMLHttpRequest();
					xhr.upload.addEventListener("progress", function(evt) {
						if (evt.lengthComputable) {
							var percentComplete = ((evt.loaded / evt.total) * 100).toFixed(2);
							progressBar.width(percentComplete + "%").html(percentComplete + "%");
						}
					}, false);
					return xhr;
				},
				success: function(resp) {
					clearInterval(interval); // Hentikan simulasi progress
					progressBar.width("100%").html("100%");

					if (resp.trim() === data2Text) {
						Swal.fire('Berhasil!', resp + ' Data berhasil ditarik.', 'success');
						targetData.text(resp);
					} else {
						Swal.fire('Gagal!', 'Data gagal ditarik.', 'error');
					}
				},
				error: function(xhr, status, error) {
					clearInterval(interval);
					Swal.fire('Error!', 'Gagal menarik data: ' + xhr.responseText, 'error');
				}
			});
		}
	</script>
<?php } else {
	echo "<h4 class='m-3'>Access denied or invalid request.</h4>";
} ?>