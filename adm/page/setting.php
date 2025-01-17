<?php
// require_once '../config/db.php';
require '../config/server.php';
require_once '../config/conf_db.php';

// set awal
// if ($db_null == 1 && $_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["nm_db"]) && isset($_POST["btn_sdb"])) {
// 	$usdb =  $_POST["userdb"];
// 	$psdb =  $_POST["passdb"];
// 	$nmdb =  $_POST["nm_db"];
// 	$db_get = $_POST['db_get'];
// 	$file = "db.php";
// 	if (file_put_contents("../config/" . $file, '$rw_db[$n++] = "' . $data . '";', FILE_APPEND | LOCK_EX) !== false) {
// 			echo '<meta http-equiv="refresh" content="3">';
// 	} else {
// 		echo "Terjadi kesalahan saat menyimpan data.";
// 	}
// }


// Rubah Databaase
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["nm_db"]) && isset($_POST["btn_sdb"])) {
	$data 	=  $_POST["nm_db"];
	$db_get = $_POST['db_get'];
	$file 	= "conf_db.php";
	if (file_put_contents("../config/" . $file, '$rw_db[$n++] = "' . $data . '";'."\n", FILE_APPEND | LOCK_EX) !== false) {
		try {
			mysqli_connect($server, $userdb, $passdb, $_POST["nm_db"]);
			echo '<meta http-equiv="refresh" content="3; url=../logout.php">';
		} catch (Exception $e) {
			echo "Terjadi kesalahan koneksi database: " . $e->getMessage();
			require_once '../config/db_impor.php';
			echo '<meta http-equiv="refresh" content="3">';
		}
	} else {
		echo "Terjadi kesalahan saat menyimpan data.";
	}
	// }
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["btn_hdb"])) {
	$file = "conf_db.php";
	if (file_put_contents("../config/" . $file, '<?php' . "\n" . '$n = 0;' . "\n" . '$rw_db = [];'. "\n") !== false) {
		echo '<meta http-equiv="refresh" content="3">';
	} else {
		echo "Terjadi kesalahan saat menghapus data.";
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
	<?php if ($code <= date('m/d/Y')) { ?>
		<div class="row justify-content-center my-3 py-5 border-bottom">
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
	<?php } else { ?>
		<div class="row g-1 pb-md-0 pb-5">
			<!-- <div class="col-12 bg-secondary p-2 sticky-top" style="border-top-left-radius: 5px;border-top-right-radius: 5px;">
				<div class="form-check form-switch">
					<input class="form-check-input" type="checkbox" role="switch" id="btn_off" checked>
					<label class="form-check-label text-white" for="btn_off">Pelaksanaan Full Offline</label>
				</div>
			</div> -->
			<div class="col-12 col-xl-6 border-start border-end">
				<!-- <div class="row g-2 mx-2"> -->
				<div class="col-12">
					<h4 class="text-uppercase bg-info-subtle p-1 ps-3 shadow-sm" style="border-radius: 5px;">DataBase</h4>
					<p class="ps-3">Nama Database yang digunakan: <?php echo $db ?></p>
				</div>
				<!-- </div> -->
				<div class="row g-3 mx-2 justify-content-center justify-content-lg-start">
					<?php if (!empty($rw_db)) { ?>
						<div class="col-12 col-sm-6 col-lg-6 col-xl-6">
							<div>Riwayat Database :</div>
							<p class="p-2 border border-dark" style="border-radius: 5px;">
								<?php
								foreach (array_unique($rw_db) as $data) {
									$drw_db[] =$data;
								}
								$jml_dt = count(array_unique($rw_db));
								for ($i = 0; $i < $jml_dt; $i++) {
									if ($i != $jml_dt-1) {
										$kma = ', ';
									} else {
										$kma = "";
									}
									echo $drw_db[$i] . $kma;
								}
								?></p>
						</div>
					<?php } ?>
					<form action="" method="post">
						<div class="col-12 col-sm-6 col-lg-6 col-xl-6">
							<?php if ($db_null == 1) { ?>
								<!-- <div class="form-floating mb-3">
								<input type="email" class="form-control" id="userdb" name="userdb" placeholder="root" required>
								<label for="floatingInput">Username Databse</label>
							</div>
							<div class="form-floating mb-3">
								<input type="password" class="form-control" id="passdb" name="passdb" placeholder="12345678" required>
								<label for="floatingPassword">Password Databse</label>
							</div> -->
							<?php } ?>
							<div class="form-floating mb-3">
								<input type="text" class="form-control" id="nm_db" name="nm_db" placeholder="Nama Database" value="<?php echo $db ?>">
								<label for="floatingInput">Ganti/Rubah Nama Database</label>
								<input type="text" name="db_get" id="db_get" value="simpan" hidden>
								<button type="submit" class="btn btn-primary m-2" id="btn_sdb" name="btn_sdb"><i class="bi bi-floppy"></i> Simpan</button>
								<?php if (!empty($rw_db)) echo '<button type="submit" class="btn btn-success m-2" id="btn_hdb" name="btn_hdb"><i class="bi bi-trash3"></i> Hapus Riwayat</button>'; ?>
							</div>
						</div>
					</form><?php
									if ($db_null != 1) { ?>
						<div class="col-12 col-sm-auto col-lg-auto col-xl-auto">
							<div>File Backup Database :</div>
							<?php
										$directory = './file/db';
										if (is_dir($directory)) {
											$files = scandir($directory);

											// Memfilter hanya file (bukan direktori) dan mengabaikan '.' dan '..'
											$files = array_filter($files, function ($file) use ($directory) {
												return is_file($directory . '/' . $file);
											});

											if (!empty($files)) {
												$i = 1;
												echo '
									<p class="p-2 border border-dark" style="border-radius: 5px;">';
												foreach ($files as $file) {
													echo $i++ . ". $file" . "<br>";
												}
												echo '</p>';
												// } else {
												// 	echo "File Backup Tidak Tersedia";
											}
										} else {
											echo "Direktori tidak valid.";
										}
							?>
						</div>
					<?php }
									if ($db_null != 1) { ?>
						<div class="col-12">
							<div class="col-auto">
								<?php require_once '../config/db_bkup.php'; ?>
							</div>
							<form action="" method="post">
								<!-- <button type="submit" class="btn btn-primary m-2" id="b_db" name="b_db"><i class="bi bi-database-fill-add"></i> Database Baru</button> -->
								<button type="submit" class="btn btn-outline-primary m-2" id="bkp" name="bkp"><i class="bi bi-box-arrow-right"></i> Cadangkan Database</button>
								<!-- <button type="button" class="btn btn-outline-success m-2" data-bs-toggle="modal" data-bs-target="#rdb"><i class="bi bi-box-arrow-in-left"></i> Pulihkan Database</button> -->
								<button type="button" class="btn btn-outline-danger m-2" id="del_bkp" name="del_bkp"><i class="bi bi-eraser"></i> Bersihkan Data</button>
							</form>
						</div><?php } ?>
				</div>
			</div>
			<?php if ($db_null == 0) {  ?>
				<div class="col-12 col-xl-6 border-start border-end py-xl-1 py-4 my-xl-auto">
					<div class="row g-2 mx-2">
						<div class="col-12">
							<h4 class="text-uppercase bg-info-subtle p-1 ps-3 shadow-sm" style="border-radius: 5px;">Data Ujian</h4>
							<?php require_once 'db/setting_up.php'; ?>
							<p class="px-3">Menu ini digunakan untuk menghapus isi database ( <i class="fw-semibold"><?php echo $db ?></i> ) yang sedang digunakan sesuai dengan Menu dan Item.</p>
							<div class="table-responsive text-nowrap">
								<table class="table table-light">
									<thead class="table-info">
										<th style="width: 25px;">No.</th>
										<th>Kelompok Data</th>
										<th style="width: 90px;">Jumlah</th>
										<th style="width: 270px;">Data Terpengaruh</th>
										<th style="width: 50px;">Opsi</th>
									</thead>
									<form action="" method="post">
										<tbody>
											<?php
											$dkls		= mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM kelas"));
											$dmpel	= mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM mapel"));
											$dsis		= mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM cbt_peserta"));
											$dpkt		= mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM cbt_pktsoal"));
											$dsoal	= mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM cbt_soal"));
											$jdwl		= mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM jdwl"));
											$duji		= mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM peserta_tes"));
											$dljk		= mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM cbt_ljk	"));
											$dnil		= mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM nilai"));
											?>
											<tr class="text-wrap">
												<th>1</th>
												<td>Kelas</td>
												<td class="fw-semibold"><?php echo $dkls ?></td>
												<td>Siswa dan data terkait</td>
												<td><button type="submit" id="kls" name="kls" class="btn btn-outline-danger"><i class="bi bi-trash3"></button></i></td>
											</tr>
											<tr>
												<th>2</th>
												<td>Mata Pelajaran</td>
												<td class="fw-semibold"><?php echo $dmpel ?></td>
												<td>Soal dan data terkait</td>
												<td><button type="submit" id="mpel" name="mpel" class="btn btn-outline-danger"><i class="bi bi-trash3"></button></i></td>
											</tr>
											<tr>
												<th>3</th>
												<td>Siswa</td>
												<td class="fw-semibold"><?php echo $dsis ?></td>
												<td>Peserta Ujian, Jawaban dan Nilai</td>
												<td><button type="submit" id="sis" name="sis" class="btn btn-outline-danger"><i class="bi bi-trash3"></button></i></td>
											</tr>
											<tr>
												<th rowspan="3">4</th>
												<td>Paket Soal</td>
												<td class="fw-semibold"><?php echo $dpkt ?></td>
												<td>Soal dan File Pendukung</td>
												<td><button type="submit" id="pkt" name="pkt" class="btn btn-outline-danger"><i class="bi bi-trash3"></button></i></td>
											</tr>
											<tr>
												<td>Soal</td>
												<td class="fw-semibold"><?php echo $dsoal ?></td>
												<td>File Pendukung</td>
												<td><button type="submit" id="soal" name="soal" class="btn btn-outline-danger"><i class="bi bi-trash3"></button></i></td>
											</tr>
											<tr>
												<td>File Pendukung</td>
												<td class="fw-semibold"><?php $photos = glob('../images/*');
																								echo count($photos); ?></td>
												<td>-</td>
												<td><button type="submit" id="file" name="file" class="btn btn-outline-danger"><i class="bi bi-trash3"></button></i></td>
											</tr>
											<tr>
												<th rowspan="3">5</th>
												<td>Jadwal Ujian</td>
												<td class="fw-semibold"><?php echo $jdwl ?></td>
												<td>Peserta Ujian</td>
												<td><button type="submit" id="jdwl" name="jdwl" class="btn btn-outline-danger"><i class="bi bi-trash3"></button></i></td>
											</tr>
											<tr>
												<td>Peserta Ujian</td>
												<td class="fw-semibold"><?php echo $duji ?></td>
												<td>Jawaban </td>
												<td><button type="submit" id="uji" name="uji" class="btn btn-outline-danger"><i class="bi bi-trash3"></button></i></td>
											</tr>
											<tr>
												<!-- <th>6</th> -->
												<td>Jawaban</td>
												<td class="fw-semibold"><?php echo $dljk ?></td>
												<td>-</td>
												<td><button type="submit" id="ljk" name="ljk" class="btn btn-outline-danger"><i class="bi bi-trash3"></button></i></td>
											</tr>
											<tr>
												<th>7</th>
												<td>Nilai</td>
												<td class="fw-semibold"><?php echo $dnil ?></td>
												<td>-</td>
												<td><button type="submit" id="nil" name="nil" class="btn btn-outline-danger"><i class="bi bi-trash3"></button></i></td>
											</tr>
										</tbody>
									</form>
								</table>
							</div>
							<div class="">
								<div class="col-12 bg-info-subtle mt-3 p-2" style="border-radius: 7px;">
									<h5>Catatan:</h5>
									<p>
										<font class="fw-semibold">Data Terpengaruh</font> : apabila menghapus data yang memiliki data terpengaruh maka akan otomatis menghapus data yang ikut terpengaruh.<br>
										<i class="fw-semibold">penghapusan data pada menu ini bersifat permanen</i> kecuali sebelumnya sudah melakukan backup(cadangkan Database).
									</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			<?php } ?>
		</div>
	<?php } ?>
</div>


<!-- Modal -->
<div class="modal fade" id="rdb" data-bs-keyboard="false" tabindex="-1" aria-labelledby="rdbLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h1 class="modal-title fs-5" id="rdbLabel">Pulihkan DataBase</h1>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<form action="" method="post" class="form-pulih">
					<div class="col">
						<input type="text" name="db_get" id="db_get" value="pulih" hidden>
						<select name="s_rdb" id="s_rdb" class="form-select">

							<?php
							$directory = './file/db';
							if (is_dir($directory)) {
								$files = scandir($directory);

								// Memfilter hanya file (bukan direktori) dan mengabaikan '.' dan '..'
								$files = array_filter($files, function ($file) use ($directory) {
									return is_file($directory . '/' . $file);
								});

								if (!empty($files)) {
									echo '<option selected>Pilih database</option>';
									foreach ($files as $file) {
										echo '<option value="' . "$file" . '">' . "$file" . "</option>";
									}
									// } else {
									// 	echo "File Backup Tidak Tersedia";
								} else {
									echo '<option>Tidak Ada file Yang Tersedia</option>';
								}
							} else {
								echo "Direktori tidak valid.";
							}
							?>

						</select>
					</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
				<button type="button" class="btn btn-primary" name="btn_pulih" id="btn_pulih">Simpan</button>
				</form>
			</div>
		</div>
	</div>
</div>

<!-- Akhir Modal -->


<script src="../node_modules/jquery/dist/jquery.js"></script>
<script>
	// pulihkan db
	$(document).ready(function() {
		$('#btn_pulih').click(function() {
			var data = $('.form-pulih').serialize();
			// console.log(jwb);
			$.ajax({
				method: "POST",
				url: "../config/db_impor.php",
				data: data,
				success: function(data) {
					location.reload();
				}
			})
		})
	})
</script>
<script>
	$(document).ready(function() {
		$('#del_bkp').click(function() {
			// Menampilkan konfirmasi SweetAlert2
			Swal.fire({
				title: 'Yakin Hapus Data?',
				text: 'Backup Database akan dihapus Secara Permanen!',
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Hapus',
				cancelButtonText: "Batal"
			}).then((result) => {
				if (result.isConfirmed) {
					// Jika pengguna mengonfirmasi, kirim permintaan AJAX untuk menghapus data
					$.ajax({
						type: 'POST',
						url: '../config/db_bkup.php?dl=del_bkp', // Ganti dengan URL yang benar
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
			});
		})
	})
</script>