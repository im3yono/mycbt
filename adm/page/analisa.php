<?php

?>

<style>
	#hasil {
		display: flex;
	}

	.anls {
		background-color: aqua;
	}
</style>

<div class="container-fluid p-0">
	<div class="row p-2 border-bottom fs-3 mb-4 shadow-sm ">Analisa Hasil Ujian</div>
	<div class="row">
		<div class="col-auto">
			<form action="hasil/c_analisa.php" method="post" id="form" target="prt">
				<div class="row">
					<div class="col-auto">
						<div class="input-group mb-3">
							<label class="input-group-text bg-info" for="inputGroupSelect01">Daftar Uji</label>
							<select class="form-select" id="kds" name="kds">
								<option value="" selected>Pilih Kode Soal & Token</option>
								<?php
								$qr_mpel = mysqli_query($koneksi, "SELECT * FROM nilai GROUP BY token ORDER BY tgl DESC");
								while ($data = mysqli_fetch_array($qr_mpel)) {
									echo '<option value="' . $data['kd_soal'] .','. $data['token']. '">' . $data['kd_soal'] .' ('. $data['token'] .')</option>';
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
		<div class="col-auto">
		</div>
	</div>
	<div class="row">
		<iframe src="hasil/c_analisa.php" name="prt" id="prt" style=" width: 100%;height: 78vh;padding: 7mm; border-radius: 5px;" class="col p-3 m-2 border bg-secondary-subtle"></iframe>
	</div>
</div>

<script src="../node_modules/jquery/dist/jquery.min.js"></script>
<!-- reload -->
<!-- <script>
	// Fungsi untuk reload otomatis setiap 5 detik
	setInterval(function() {
		location.reload();
	}, 5000); // Waktu dalam milidetik (misalnya, 5000 untuk 5 detik)
</script> -->
<!-- <script>
	function download() {
		var iframe = document.getElementById('prt');

		// Mendapatkan isi dokumen dari iframe
		var iframeDocument = iframe.contentDocument || iframe.contentWindow.document;

		// Mengambil konten dari iframe
		var content = iframeDocument.documentElement.outerHTML;

		// Membuat file dengan konten dari iframe
		var blob = new Blob([content], {
			type: 'text/html'
		});

		// Membuat link untuk mengunduh file
		var link = document.createElement('a');
		link.href = URL.createObjectURL(blob);
		link.download = 'nama_file.html'; // Ganti dengan nama file yang diinginkan
		link.click();
	}
</script> -->
<script>
	$(document).ready(function() {
		// Fungsi untuk menyimpan data saat tombol diklik
		$("#download").click(function(e) {
			e.preventDefault(); // Mencegah perilaku default dari tombol

			// Mengambil data dari formulir
			var dataToSend = {
				field1: $("#kds").val(),
			};
			// var dataToSend = $("#kds").val();
			// Kirim permintaan AJAX ke server
			$.ajax({
				type: "POST", // Atau 'GET' tergantung pada kebutuhan Anda
				url: "hasil/dwn_analisa.php", // Ganti dengan URL skrip PHP yang menangani penyimpanan data
				data: dataToSend,
				success: function(data) {
					// Handle respons dari server jika perlu
					// console.log("Data berhasil disimpan: " + data);
					// $("#dwn").html(data);
					// Lakukan sesuatu setelah data berhasil disimpan
				},
				error: function(xhr, status, error) {
					// Handle kesalahan jika terjadi
					console.error("Error: " + error);
				}
			});
		});
	});
</script>