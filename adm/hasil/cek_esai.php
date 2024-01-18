<?php
include_once("../config/server.php");


$kds = $_GET['kds'];
$token = $_GET['tkn'];
$kd_mpel = $_GET['mpel'];
$d_mpel = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM mapel WHERE kd_mpel='$kd_mpel'"))


?>



<div class="container-fluid mb-5 p-0">
	<div class="row p-2 border-bottom fs-3 mb-4 shadow-sm justify-content-between">
		<div class="col-10">
			<div class="row">
				<div class="col-auto">
					<a href="?md=df_uji" class="btn btn-outline-dark"><i class="bi bi-arrow-left"></i> Kembali</a>
				</div>
				<div class="col-auto">Koreksi Jawaban Esai</div>
			</div>
		</div>
		<div class="col-auto">
			<form action="" method="post" id="fr_prs">
				<!-- <a href="hasil/nil_es.php?act=prs&kds=<?php echo $kds ?>&tkn=<?php echo $token . '&mpel=' . $kd_mpel ?>" class="btn btn-outline-primary alert_notif">Proses Nilai</a> -->
				<button class="btn btn-outline-primary">Proses Nilai</button>
			</form>
		</div>
	</div>
	<div class="row my-2 fw-semibold">
		<div class="col-auto">Kode Soal : <?php echo $kds ?></div>
		<div class="col-auto">Nama Mapel : <?php echo $d_mpel['nm_mpel'] ?></div>
	</div>
	<div class="table-responsive">
		<table class="table table-hover table-bordered">
			<thead class="bg-info-subtle text-center align-baseline">
				<th style="width: 5mm;">No.</th>
				<th style="width: 15mm;">No. Peserta</th>
				<th style="width: 35mm;">Nama</th>
				<th style="width: 5mm;">No. Soal</th>
				<th style="width: 70mm;">Soal</th>
				<th style="width: 70mm;">Jawaban</th>
				<th style="width: 10mm;">Nilai <br>(0-100)</th>
				<th style="width: 10mm;">Action</th>
			</thead>
			<tbody>
				<?php
				$no = 1;

				$qr_es = mysqli_query($koneksi, "SELECT * FROM `cbt_ljk` WHERE jns_soal='E'AND kd_soal='$kds' AND token='$token';");
				if (mysqli_num_rows($qr_es) > 0) {
					while ($data = mysqli_fetch_array($qr_es)) {

						$d_usr = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM `cbt_peserta` WHERE user ='$data[user_jawab]';"));
						$d_soal = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM `cbt_soal` WHERE kd_soal='$kds'AND jns_soal='E' AND no_soal='$data[no_soal]';"));
				?>
						<tr>
							<th class="text-center"><?php echo $no ?></th>
							<td><?php echo $data['user_jawab'] ?></td>
							<td><?php echo $d_usr['nm'] ?></td>
							<td class="text-center"><?php echo $data['no_soal'] ?></td>
							<td><?php echo $d_soal['tanya'] ?></td>
							<td><?php echo $data['es_jwb'] ?></td>
							<form action="" method="post" id="formNilai<?php echo $no ?>">
								<td><input type="number" min="10" max="100" name="nilai<?php echo $no ?>" id="nilai<?php echo $no ?>" class="form-control form-control-sm text-end" style="width: 60px;" onkeypress="return angka (event)" onchange="batas(this)" value="<?php echo $data['nil_esai'] ?>"></td>
								<td class="text-center ">
									<button class="btn btn-sm btn-outline-info">Simpan</button>
								</td>
							</form>
						</tr>
						<script src="../node_modules/jquery/dist/jquery.min.js"></script>
						<script>
							$(document).ready(function() {
								$('#formNilai<?php echo $no ?>').submit(function(event) {
									event.preventDefault(); // Mencegah pengiriman formulir secara default

									// Mengambil nilai dari formulir
									var nil = $('#nilai<?php echo $no ?>').val();
									let usr = "<?php echo $data['user_jawab'] ?>";
									let kds = "<?php echo $kds ?>";
									let nos = "<?php echo $data['no_soal'] ?>";

									// Kirim data ke server menggunakan AJAX
									$.ajax({
										type: 'POST',
										url: 'hasil/nil_es.php?act=nil', // Ganti dengan path ke skrip PHP untuk menyimpan data ke database
										data: {
											nil: nil,
											usr: usr,
											kds: kds,
											nos: nos
										},
										success: function(response) {
											Swal.fire({
												title: "Berhasil!",
												text: "Nilai Berhasil Disimpan",
												icon: "success"
											});
											// Tambahkan logika lain setelah data tersimpan, jika diperlukan
										},
										error: function(xhr, status, error) {
											Swal.fire({
												icon: "error",
												title: "Error",
												text: "Nilai Gagal Disimpan",
											});
											// alert('Terjadi kesalahan: ' + error);
										}
									});
								});
							});
						</script>
					<?php $no++;
					}
				} else {
					?>
					<tr>
						<td colspan="8" class="text-center text-uppercase fw-semibold">data kosong</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>

<script src="../node_modules/jquery/dist/jquery.min.js"></script>
<script>
	function angka(evt) {
		var charCode = (evt.which) ? evt.which : event.keyCode
		if (charCode > 31 && (charCode < 48 || charCode > 57))

			return false;
		return true;
	}

	function batas(val) {
		if (Number(val.value) > 100) {
			val.value = 100
		}
	}
</script>
<script>
	$(document).ready(function() {
		$('#fr_prs').submit(function(event) {
			event.preventDefault(); // Mencegah pengiriman formulir secara default
			Swal.fire({
				title: 'Apa Anda Yakin?',
				text: "Data akan diproses dan tidak bisa di perbaiki kembali",
				icon: 'warning',
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				backdrop: 'rgba(0,0,0,0.8)',
				allowOutsideClick: false,
				allowEscapeKey: false,
				showCancelButton: true,
				confirmButtonText: 'Proses',
				cancelButtonText: "Batal",
			}).then(result => {
				//jika klik ya maka arahkan ke proses.php
				if (result.isConfirmed) {
					// Mengambil nilai dari formulir
					// var nil = $('#nilai').val();
					// let usr = "";
					let kds = "<?php echo $kds ?>";
					let token = "<?php echo $token ?>";

					// Kirim data ke server menggunakan AJAX
					$.ajax({
						type: 'POST',
						url: 'hasil/nil_es.php?act=prs', // Ganti dengan path ke skrip PHP untuk menyimpan data ke database
						data: {
							// nil: nil,
							// usr: usr,
							kds: kds,
							token: token
						},
						success: function(response) {
							Swal.fire({
								title: "Berhasil!",
								text: "Nilai Berhasil Disimpan",
								icon: "success"
							});
							// Tambahkan logika lain setelah data tersimpan, jika diperlukan
						},
						error: function(xhr, status, error) {
							Swal.fire({
								icon: "error",
								title: "Error",
								text: "Nilai Gagal Disimpan",
							});
							// alert('Terjadi kesalahan: ' + error);
						}
					});
				}
			})
			return false;
		});
	});
</script>