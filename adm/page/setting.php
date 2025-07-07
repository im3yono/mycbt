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
	if (file_put_contents("../config/" . $file, '$rw_db[$n++] = "' . $data . '";' . "\n", FILE_APPEND | LOCK_EX) !== false) {
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
	if (file_put_contents("../config/" . $file, '<?php' . "\n" . '$n = 0;' . "\n" . '$rw_db = [];' . "\n") !== false) {
		echo '<meta http-equiv="refresh" content="3">';
	} else {
		echo "Terjadi kesalahan saat menghapus data.";
	}
} else {
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["aktif"]) && isset($_POST["nm_pt"]) && isset($_POST["kd_aktif"])) {
	$nm = ($_POST['nm_pt']);
	$kd_aktif 	= $_POST['kd_aktif'];
	$file 	= '../config/key.php';

	// Pastikan nilai tidak kosong
	if (empty($nm) || empty($kd_aktif)) {
		echo "<p style='color: red;'>Data tidak boleh kosong!</p>";
		exit;
	}

	$err = file_key($file, $nm, $kd_aktif);
}
?>


<style>
	.bg-akt {
		/* background: rgb(0,255,255);
background: radial-gradient(circle, rgba(0,255,255,0.5018382352941176) 0%, rgba(153,153,153,0.4009978991596639) 100%); */
		border-radius: 7px;
	}
</style>
<div class="container-fluid mb-1 p-0">
	<div class="row p-2 border-bottom fs-3 mb-4 shadow-sm text-uppercase">Pengaturan Aplikasi</div>
	<?php
	// Cek apakah alert sudah pernah ditutup (menggunakan cookie)
	$showAlert = !isset($_COOKIE['hide_alert_setting']);
	if ($showAlert):
	?>
		<div class="alert mb-5 alert-danger alert-dismissible fade show" role="alert" id="autoCloseAlert">
			<div class="row">
				<h5>Peringatan :</h5>
				<div class="col">
					<p>Pasitkan pada pengaturan <b>my.ini</b> sudah di set seperti berikut :<br>
						• key_buffer=16M <br>
						• max_allowed_packet=128M <br>
						• sort_buffer_size=512K <br>
						• net_buffer_length=8K <br>
						• read_buffer_size=256K <br>
						• read_rnd_buffer_size=512K <br>
						• myisam_sort_buffer_size=8M
					</p>
				</div>
				<div class="col">
					<p>Pastikan Pengaturan <b>php.ini</b> sudah di set seperti berikut : <br>
						• date.timezone = Asia/Makassar <br>
						• max_execution_time=3000 <br>
						• upload_max_filesize=5000M <br>
						• max_file_uploads=700 <br>
						• aktifkan ";extension=gd" <br>
					</p>
				</div>
			</div>
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" id="closeAlertBtn"></button>
		</div>
		<script>
			document.getElementById('closeAlertBtn').addEventListener('click', function() {
				// Set cookie hide_alert_setting selama 6 jam
				var d = new Date();
				d.setTime(d.getTime() + (6*60*60*1000)); // 6 jam
				document.cookie = "hide_alert_setting=1; expires=" + d.toUTCString() + "; path=/";
			});
		</script>
	<?php endif; ?>
	
	<?php if (cek_aktif($d_exp, "<")) { ?>
		<script>
			$(document).ready(function() {
				$('#activationModal').modal({
					backdrop: 'static',
					keyboard: false
				});
				$('#activationModal').modal('show');
			});
		</script>
	<?php }
	if (cek_aktif($d_exp, ">=")) { ?>
		<div class="row g-3 pb-2 mb-2 mx-lg-3 border" style="border-top-left-radius: 5px;border-top-right-radius: 5px;">
			<?php if (cek_aktif($d_exp, "<=", "1")) {
				$exp_bg = "bg-danger border-danger";
				if (cek_aktif($d_exp, ">")) {
					$exp = "Aktivasi Kembali : " . tgl_hari($d_exp);
					$exp_bg = "bg-secondary border-secondary";
				} elseif (cek_aktif($d_exp, "==")) {
					$exp = "Akhir penggunaan aplikasi";
				} else {
					$exp = "<p>Untuk mendapatkan Kode Aktivasi Aplikasi ini silahkan hubugi : 0852-4995-9547</p>";
				} ?>
				<div class="col-12 mt-0 sticky-top border <?= $exp_bg; ?>" style="border-top-left-radius: 5px;border-top-right-radius: 5px;">
					<div class="row m-0 p-0">
						<div class="col-auto p-1">
							<button type="button" class="btn btn-info" onclick="atc()"><i class="bi bi-key-fill"></i> Aktivasi</button>
						</div>
						<div class="col pt-2">
							<div class="text-light"><?= $exp; ?></div>
						</div>
					</div>
				</div>
			<?php } ?>
			<div class="col-12 col-xl-6">
				<!-- <div class="row g-2 mx-2"> -->
				<div class="col-12">
					<h4 class="text-uppercase bg-info-subtle p-1 ps-3 shadow-sm" style="border-radius: 5px;">DataBase</h4>
					<p class="ps-3">Nama Database yang digunakan : <span class="fw-bold"><?= $db ?></span></p>
				</div>
				<!-- </div> -->
				<div class="row g-3 mx-2 mb-3 justify-content-center justify-content-lg-start">
					<?php if (!empty($rw_db)) { ?>
						<div class="col-12 col-sm-6 col-lg-6 col-xl-6">
							<div>Riwayat Database :</div>
							<p class="p-2 border border-dark" style="border-radius: 5px;">
								<?php
								foreach (array_unique($rw_db) as $data) {
									$drw_db[] = $data;
								}
								$jml_dt = count(array_unique($rw_db));
								for ($i = 0; $i < $jml_dt; $i++) {
									if ($i != $jml_dt - 1) {
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
								<label for="db_get">Ganti/Rubah Nama Database</label>
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

				<!-- ========== Setting Mode Server ========== -->
				<?php if ($db_null == 0) {
					// if ($_SERVER["REMOTE_ADDR"] == "localhost" || $_SERVER["REMOTE_ADDR"] == "127.0.0.1") { 
				?>
					<div class="row m-0">
						<div class="col-12 mb-3">
							<div class="row bg-info-subtle p-1 shadow-sm fs-5 fw-semibold" style="border-radius: 5px;">
								<div class="col text-uppercase" id="txtmode">Server <?= $server_ms['lev_svr'] == "C" ? "Client" : "Master"; ?></div>
								<div class="col-auto">
									<div class="form-check form-switch">
										<input class="form-check-input" onchange="modeSV()" type="checkbox" role="switch" id="modeSV" <?= $server_ms['lev_svr'] == "C" ? "checked" : ""; ?>>
										<!-- <label class="form-check-label" for="flexSwitchCheckChecked">Checked switch checkbox input</label> -->
									</div>
								</div>
							</div>
						</div>
						<div class="row m-0">
							<div class="col-12 col-sm-6 col-lg-6 col-xl-6 " id="form_koneksi" <?= ($server_ms['lev_svr'] == "M") ? 'style="display: none;"' : ''; ?>>
								<form method="post">
									<div class="col mb-3">
										<label for="ip" class="form-label">IP Server Master</label>
										<input type="text" name="ip" id="ip" class="form-control" placeholder="192.168.xxx.xxx" value="<?= $server_ms['ip_sv']; ?>">
									</div>
									<div class="col mb-3">
										<label for="nm_db" class="form-label">Nama Database Server Master</label>
										<input type="text" name="db" id="db" class="form-control" placeholder="db_mytbk" value="<?= $server_ms['db_svr']; ?>">
									</div>
									<div class="col mb-3">
										<button type="button" class="btn btn-outline-info" onclick="tesKoneksi()">Tes Koneksi</button>
										<button type="button" class="btn btn-primary" onclick="saveKoneksi()" disabled>Simpan</button>
									</div>
									<div id="status_koneksi" class="mb-3"></div>
								</form>
							</div>
							<div class="col-12 col-sm-6 col-lg-6 col-xl-6 bg-success-subtle p-2" style="border-radius: 7px;" id="info_koneksi">
								<h5>Catatan :</h5>
								<p id="info_cl" <?= ($server_ms['lev_svr'] == "C") ? 'style="display: none;"' : ''; ?>> Saat ini server digunakan sebagai Server Master</p>
								<p id="info_ms" <?= ($server_ms['lev_svr'] == "M") ? 'style="display: none;"' : ''; ?>>
									Apabila sever yang anda gunakan ini sebagai server client maka IP Server Master sesuaikan dengan IP server utama yang anda gunakan.
									<br>
									Dan apabila di gunakan sebagai Server Master maka masukkan IP server master/utama
									<br><br>
									Untuk database apabila sever yang anda gunakan ini sebagai server client maka nama Databse Server Master samakan dengan nama Databse Server Master/Utama.
								</p>
							</div>
						</div>
					</div>
					<?php //} 
					?>
					<!-- ========== Akhir Setting Mode Server ========== -->

			</div>
			<div class="col-12 col-xl-6">
				<div class="row g-2 p-0">
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
								<form action="" method="post" id="deleteForm">
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
											<td><button type="button" onclick="confirmDelete('kls')" class="btn btn-outline-danger"><i class="bi bi-trash3"></i></button></td>
										</tr>
										<tr>
											<th>2</th>
											<td>Mata Pelajaran</td>
											<td class="fw-semibold"><?php echo $dmpel ?></td>
											<td>Soal dan data terkait</td>
											<td><button type="button" onclick="confirmDelete('mpel')" class="btn btn-outline-danger"><i class="bi bi-trash3"></i></button></td>
										</tr>
										<tr>
											<th>3</th>
											<td>Siswa</td>
											<td class="fw-semibold"><?php echo $dsis ?></td>
											<td>Peserta Ujian, Jawaban dan Nilai</td>
											<td><button type="button" onclick="confirmDelete('sis')" class="btn btn-outline-danger"><i class="bi bi-trash3"></i></button></td>
										</tr>
										<tr>
											<th rowspan="3">4</th>
											<td>Paket Soal</td>
											<td class="fw-semibold"><?php echo $dpkt ?></td>
											<td>Soal dan File Pendukung</td>
											<td><button type="button" onclick="confirmDelete('pkt')" class="btn btn-outline-danger"><i class="bi bi-trash3"></i></button></td>
										</tr>
										<tr>
											<td>Soal</td>
											<td class="fw-semibold"><?php echo $dsoal ?></td>
											<td>File Pendukung</td>
											<td><button type="button" onclick="confirmDelete('soal')" class="btn btn-outline-danger"><i class="bi bi-trash3"></i></button></td>
										</tr>
										<tr>
											<td>File Pendukung</td>
											<td class="fw-semibold"><?php $photos = glob('../images/*');
																							echo count($photos); ?></td>
											<td>-</td>
											<td><button type="button" onclick="confirmDelete('file')" class="btn btn-outline-danger"><i class="bi bi-trash3"></i></button></td>
										</tr>
										<tr>
											<th rowspan="3">5</th>
											<td>Jadwal Ujian</td>
											<td class="fw-semibold"><?php echo $jdwl ?></td>
											<td>Peserta Ujian</td>
											<td><button type="button" onclick="confirmDelete('jdwl')" class="btn btn-outline-danger"><i class="bi bi-trash3"></i></button></td>
										</tr>
										<tr>
											<td>Peserta Ujian</td>
											<td class="fw-semibold"><?php echo $duji ?></td>
											<td>Jawaban </td>
											<td><button type="button" onclick="confirmDelete('uji')" class="btn btn-outline-danger"><i class="bi bi-trash3"></i></button></td>
										</tr>
										<tr>
											<!-- <th>6</th> -->
											<td>Jawaban</td>
											<td class="fw-semibold"><?php echo $dljk ?></td>
											<td>-</td>
											<td><button type="button" onclick="confirmDelete('ljk')" class="btn btn-outline-danger"><i class="bi bi-trash3"></i></button></td>
										</tr>
										<tr>
											<th>7</th>
											<td>Nilai</td>
											<td class="fw-semibold"><?php echo $dnil ?></td>
											<td>-</td>
											<td><button type="button" onclick="confirmDelete('nil')" class="btn btn-outline-danger"><i class="bi bi-trash3"></i></button></td>
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
	<div class="row pb-md-0 mb-md-0 mb-5 pb-5">
		<div class="col text-center bg-dark text-white"><?php include("../config/about.php") ?></div>
	</div>
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

<div class="modal fade" id="activationModal" tabindex="-1" aria-labelledby="activationModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="activationModalLabel">Aktivasi</h5>
			</div>
			<div class="modal-body">
				<p class="text-center">Untuk mendapatkan Kode Aktivasi Aplikasi ini silahkan hubungi <br>
					<a href="https://wa.me/6285249959547" target="_blank"><i class="bi bi-whatsapp"></i> 0852-4995-9547</a>
				</p>
				<div><?= empty($err) ? "" : $err; ?></div>
				<form action="" method="post">
					<div class="mb-3">
						<input class="form-control form-control-lg text-center" type="text" id="nm_pt" name="nm_pt" placeholder="Nama Instansi" value="<?= $inf_nm; ?>">
					</div>
					<div class="mb-3">
						<input class="form-control form-control-lg text-center" type="text" id="kd_aktif" name="kd_aktif" placeholder="Kode Aktivasi" required>
					</div>
					<div class="text-center">
						<button type="submit" class="btn btn-outline-primary" id="aktif" name="aktif">Aktivasi</button>
					</div>
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
<script>
	function tesKoneksi() {
		var ip = document.getElementById("ip").value;
		var db = document.getElementById("db").value;
		var statusKoneksi = document.getElementById("status_koneksi");

		statusKoneksi.innerHTML = "Menghubungkan...";

		fetch("../config/m_db.php?sm=teskon", {
				method: "POST",
				headers: {
					"Content-Type": "application/x-www-form-urlencoded"
				},
				body: "ip=" + encodeURIComponent(ip) + "&db=" + encodeURIComponent(db)
			})
			.then(response => response.text())
			.then(data => {
				statusKoneksi.innerHTML = data;
				if (data.includes("Koneksi berhasil!")) {
					document.querySelector("button[onclick='saveKoneksi()']").disabled = false;
					Swal.fire('Terhubung!', 'Koneksi berhasil.', 'success');
				} else {
					document.querySelector("button[onclick='saveKoneksi()']").disabled = true;
					Swal.fire('Gagal Terhubung', data, 'error');
				}
			})
			.catch(error => {
				statusKoneksi.innerHTML = "Terjadi kesalahan: " + error;
				document.querySelector("button[onclick='saveKoneksi()']").disabled = true;
			});
	}

	function saveKoneksi() {
		var ip = $("#ip").val();
		var db = $("#db").val();

		$.ajax({
			type: "POST",
			url: "../config/m_db.php?sm=savekon",
			data: {
				ip: ip,
				db: db
			},
			success: function(response) {
				Swal.fire('Berhasil!', 'Koneksi berhasil disimpan.', 'success');
			},
			error: function() {
				Swal.fire('Error', 'Terjadi kesalahan saat menyimpan koneksi.', 'error');
			}
		});
	}

	function modeSV() {
		var modeSV = $("#modeSV").is(":checked");
		$("#txtmode").text(modeSV ? "Server Client" : "Server Master");
		$("#form_koneksi").toggle(modeSV);
		$("#info_ms").toggle(modeSV);
		$("#mn_sync").toggle(!modeSV);
		$("#info_cl").toggle(!modeSV);
		$("#mn_uphs").toggle(!modeSV);
		$("#mn_uphs").toggle(modeSV);
		$("#info_koneksi").toggleClass("col-sm-6 col-lg-6 col-xl-6", modeSV);

		$.ajax({
			type: "POST",
			url: "../config/m_db.php?sm=modeSV",
			data: {
				mode: modeSV ? "C" : "M"
			},
			success: function(response) {
				Swal.fire('Berhasil!', 'Status server berhasil diubah.', 'success');
			},
			error: function() {
				Swal.fire('Error', 'Terjadi kesalahan saat mengubah status server.', 'error');
			}
		});
	}
</script>

<script>
	function confirmDelete(id) {
		Swal.fire({
			title: 'Yakin ingin menghapus data?',
			text: "Data yang dihapus tidak dapat dikembalikan!",
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Hapus',
			cancelButtonText: 'Batal'
		}).then((result) => {
			if (result.isConfirmed) {
				var form = document.getElementById('deleteForm');
				var input = document.createElement('input');
				input.type = 'hidden';
				input.name = id;
				input.value = id;
				form.appendChild(input);
				form.submit();
			}
		});
	}
</script>

<script>
	function atc() {
		$('#activationModal').modal('show');
	};
</script>