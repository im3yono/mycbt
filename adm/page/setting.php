<?php
// require_once '../config/db.php';
require '../config/server.php';
require_once '../config/conf_set.php';

// Rubah Databaase
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["nm_db"]) && isset($_POST["btn_sdb"])) {
	$nm_db = $_POST["nm_db"];

	// Format data yang akan disimpan ke file
	$data =  $nm_db;

	// Nama file untuk menyimpan data
	$file = "conf_set.php";

	// Menyimpan data ke dalam file (dengan mode APPEND)
	if (file_put_contents("../config/" . $file, '$rw_db[$n++] = "' . $data . '";', FILE_APPEND | LOCK_EX) !== false) {
		echo '<meta http-equiv="refresh" content="3">';
	} else {
		echo "Terjadi kesalahan saat menyimpan data.";
	}
} else {
}
?>



<style>
	.bg-akt {
		/* background: rgb(0,255,255);
background: radial-gradient(circle, rgba(0,255,255,0.5018382352941176) 0%, rgba(153,153,153,0.4009978991596639) 100%); */
		border-radius: 7px;
	}
</style>
<div class="container-fluid mb-5 p-0">
	<div class="row p-2 border-bottom fs-3 mb-4 shadow-sm text-uppercase">Pengaturan Aplikasi</div>
	<?php if ($code > date('m/d/Y')) { ?>
		<div class="row justify-content-center">
			<div class="col col-md-5 border text-center bg-akt bg-light shadow m-4">
				<div class="row justify-content-center gap-2">
					<h4 class="m-3">Aktivasi</h4>
					<p>Untuk mendapatkan Kode Aktivasi Aplikasi ini silahkan hubugi <br> 0852-4995-9547</p>
					<div class="col col-md-10">
						<input class="form-control form-control-lg text-center" type="text" id="nm_pt" name="nm_pt" placeholder="Nama Instansi">
					</div>
					<div class="col col-md-10">
						<input class="form-control form-control-lg text-center" type="text" id="kd_aktif" name="kd_aktif" placeholder="Kode Aktivasi">
					</div>
					<div class="col-12 m-3"><button type="button" class="btn btn-outline-primary">Aktivasi</button></div>
				</div>
			</div>
		</div>
	<?php } ?>
	<div class="row g-1">
		<div class="col-12 col-xl-6 border-start border-end">
			<div class="row g-2 mx-2">
				<div class="col-12">
					<h4 class="text-uppercase">DataBase</h4>
					<p>Nama Database yang digunakan: <?php echo $db ?></p>
				</div>
			</div>
			<div class="row g-3 mx-2 justify-content-center justify-content-lg-start">
				<?php if (!empty($rw_db)) { ?>
					<div class="col-12 col-sm-6 col-lg-6 col-xl-6">
						<div>Riwayat Database :</div>
						<p class="p-2 border border-dark" style="border-radius: 5px;">
						<?php
						for ($i = 0; $i < count(array_unique($rw_db)); $i++) {
							echo $rw_db[$i] . ', ';}
						?></p>
					</div>
				<?php } ?>
				<form action="" method="post">
					<div class="col-12 col-sm-6 col-lg-6 col-xl-6">
						<div class="form-floating mb-3">
							<input type="text" class="form-control" id="nm_db" name="nm_db" placeholder="Nama Database" value="<?php echo $db ?>">
							<label for="floatingInput">Ganti/Rubah Nama Database</label>
							<button type="submit" class="btn btn-primary m-2" id="btn_sdb" name="btn_sdb"><i class="bi bi-floppy"></i> Simpan Database</button>
						</div>
					</div>
				</form>
				<div class="col-12">
					<button type="button" class="btn btn-outline-primary m-2"><i class="bi bi-box-arrow-right"></i> Cadangkan Database</button>
					<button type="button" class="btn btn-outline-success m-2"><i class="bi bi-box-arrow-in-left"></i> Pulihkan Database</button>
					<button type="button" class="btn btn-outline-danger m-2"><i class="bi bi-eraser"></i> Bersihkan Data</button>
				</div>
			</div>
		</div>
		<div class="col-12 col-xl-6 border-start border-end my-4 my-xl-auto">
			<div class="row g-2 mx-2">
				<div class="col-12">
					<h4 class="text-uppercase">Data Ujian</h4>
					<p>wwrwrafnfsa sdjlaskdjdlakjdj lsdjalskdja lkskdjdlaskjdj</p>
					<div class="table-responsive text-nowrap">
						<table class="table">
							<thead>
								<th style="width: 25px;">No.</th>
								<th>Data</th>
								<th style="width: 100px;">Jumlah</th>
								<th style="width: 50px;">Opsi</th>
							</thead>
							<tbody>
								<tr>
									<th>1</th>
									<td>Kelas</td>
									<td>20</td>
									<td><i class="bi bi-gear"></i></td>
								</tr>
								<tr>
									<th>2</th>
									<td>Mata Pelajaran</td>
									<td>20</td>
									<td><i class="bi bi-gear"></i></td>
								</tr>
								<tr>
									<th>3</th>
									<td>Siswa</td>
									<td>20</td>
									<td><i class="bi bi-gear"></i></td>
								</tr>
								<tr>
									<th>4</th>
									<td>Soal</td>
									<td>20</td>
									<td><i class="bi bi-gear"></i></td>
								</tr>
								<tr>
									<th>5</th>
									<td>Ujian</td>
									<td>20</td>
									<td><i class="bi bi-gear"></i></td>
								</tr>
								<tr>
									<th>6</th>
									<td>Lembar Jawaban</td>
									<td>20</td>
									<td><i class="bi bi-gear"></i></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>