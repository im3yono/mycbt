<?php

?>

<style>
	#hasil {
		display: flex;
	}

	.rekap {
		background-color: aqua;
	}
</style>

<div class="container-fluid mb-5 p-0">
	<div class="row p-2 border-bottom fs-3 mb-4 shadow-sm ">Nilai Hasil Ujian</div>
	<div class="row">
		<div class="col-auto">
			<!-- <form action="hasil/c_rekap.php" method="post" id="form" target="prt"> -->
			<form action="" method="post" id="fr_tampil" name="fr_tampil">
				<div class="row">
					<div class="col-auto">
						<div class="input-group mb-3">
							<label class="input-group-text bg-info" for="inputGroupSelect01">Bank Soal</label>
							<select class="form-select" id="kds" name="kds">
								<option value="" selected>Pilih Kode Bank Soal</option>
								<?php
								$qr_mpel = mysqli_query($koneksi, "SELECT * FROM cbt_pktsoal");
								while ($data = mysqli_fetch_array($qr_mpel)) {
									echo '<option value="' . $data['kd_soal'] . '">' . $data['kd_soal'] . '</option>';
								} ?>
							</select>
						</div>
					</div>
					<!-- <div class="col-auto">
				<div class="input-group mb-3">
					<label class="input-group-text bg-info" for="inputGroupSelect01">Kelas</label>
					<select class="form-select" id="kls" name="kls">
						<option selected>Pilih Kelas</option>
						<?php
						$qr_mpel = mysqli_query($koneksi, "SELECT * FROM kelas");
						while ($data = mysqli_fetch_array($qr_mpel)) {
							echo '<option value="' . $data['kd_kls'] . '">' . $data['nm_kls'] . '</option>';
						} ?>
					</select>
				</div>
			</div> -->
					<div class="col-auto">
						<button type="submit" class="btn btn-primary" id="tampil" name="tampil">Tampilkan</button>
					</div>
				</div>
			</form>
		</div>
	</div>
	<div class="row px-1">
		<div class="col-lg-6 col-12 p-2 border">
			<!-- <iframe src="hasil/c_rekap.php" name="prt" id="prt" style=" width: 100%;height: 73vh; border-radius: 5px;" class="col-lg-6 col-12 p-2 border shadow"></iframe> -->
			<?php 
			// include_once("hasil/c_rekap.php") 
			?>
			<div id="data"></div>
		</div>
		<div class="col p-2 border">
			<div class="row mx-1 p-2 border border shadow" style="border-radius: 5px;">mmmmmmmmmm</div>
		</div>
	</div>
</div>

<script src="../node_modules/jquery/dist/jquery.min.js"></script>
<script>
	// Fungsi untuk memuat data ke dalam tabel saat halaman dimuat
	$(document).ready(function() {
		loadData(); // Memuat data dari database saat halaman dimuat
	});

	// Fungsi untuk memuat data dari database
	function loadData() {
		$.ajax({
			url: 'hasil/c_rekap.php', // Ganti dengan skrip PHP yang memuat data dari database
			type: 'GET',
			success: function(response) {
				$('#data').html(response); // Memuat data ke dalam tabel
			}
		});
	}

	// Menangani pengiriman data baru ke server saat formulir disubmit
	$('#fr_tampil').submit(function(event) {
		event.preventDefault(); // Mencegah pengiriman formulir secara default

		// Mengambil nilai dari formulir
		var kds = $('#kds').val();

		// Mengirim data ke server menggunakan AJAX
		$.ajax({
			url: 'hasil/c_rekap.php', // Ganti dengan skrip PHP untuk menyimpan data ke database
			type: 'POST',
			data: {kds: kds},
			success: function(response) {
				// loadData(); // Memuat kembali data setelah menambahkan data baru
				$('#data').html(response);
				// $('#kds').val(''); // Mengosongkan kolom nama
				// $('#email').val(''); // Mengosongkan kolom email
			}
		});
	});
</script>