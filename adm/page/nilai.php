<?php

?>

<style>
	#hasil {
		display: flex;
	}

	.nilai {
		background-color: aqua;
	}
</style>

<div class="container-fluid mb-5 p-0">
	<div class="row p-2 border-bottom fs-3 mb-4 shadow-sm ">Nilai Hasil Ujian</div>
	<div class="row">
		<div class="col-auto">
			<form action="hasil/c_nilai.php" method="post" id="form" target="prt">
				<div class="row">
					<div class="col-auto">
						<div class="input-group mb-3">
							<label class="input-group-text bg-info" for="inputGroupSelect01">Daftar Uji</label>
							<select class="form-select" id="kds" name="kds">
								<option value="" selected>Pilih Kode Soal & Token</option>
								<?php
								$qr_mpel = mysqli_query($koneksi, "SELECT * FROM nilai GROUP BY token ORDER BY tgl DESC");
								while ($data = mysqli_fetch_array($qr_mpel)) {
									echo '<option value="' . $data['kd_soal'] . ',' . $data['token'] . '">' . $data['kd_soal'] . ' (' . $data['token'] . ')</option>';
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
						<div class="input-group">
							<label for="ket" class="input-group-text bg-info">Keterangan</label>
							<select class="form-select" name="ket" id="ket">
								<option value="1">Tidak Aktif</option>
								<option value="2">Aktif</option>
							</select>
						</div>
					</div>
					<div class="col-auto">
						<button type="submit" class="btn btn-primary" id="tampil" name="tampil">Tampilkan</button>
					</div>
				</div>
			</form>
		</div>
	</div>
	<div class="row">
		<iframe src="hasil/c_nilai.php" name="prt" id="prt" style=" width: 100%;height: 78vh;padding: 10mm; border-radius: 5px;" class="col p-3 m-2 border bg-secondary-subtle"></iframe>
	</div>
</div>

<script>

</script>