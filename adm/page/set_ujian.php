<?php
include_once("../config/server.php");
include_once("../config/time_date.php");
include("db/setjdw_ujian.php");

// token Acak
function GeraHash($qtd)
{
	//Under the string $Caracteres you write all the characters you want to be used to randomly generate the code. 
	$Caracteres = 'ABCDEFGHIJKLMNPQRSTUVWXYZ12345789';
	//$Caracteres = 'abcdefghijklmnpqrstuvwxyz'; 
	// $Caracteres = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	//$Caracteres = '123456789'; 
	$QuantidadeCaracteres = strlen($Caracteres);
	$QuantidadeCaracteres--;
	$Hash = NULL;
	for ($x = 1; $x <= $qtd; $x++) {
		$Posicao = rand(0, $QuantidadeCaracteres);
		$Hash .= substr($Caracteres, $Posicao, 1);
	}
	return $Hash;
}
?>

<style>
	#uj {
		display: flex;
	}

	.setuj {
		background-color: aqua;
	}


	/* Gaya tabel */
	.table-responsive th:nth-child(1),
	.table-responsive td:nth-child(1) {
		min-width: 20px;
		text-align: center;
		align-content: baseline;
	}

	.table-responsive th:nth-child(2),
	.table-responsive td:nth-child(2) {
		min-width: 150px;
		text-align: center;
		align-content: baseline;
	}

	.table-responsive th:nth-child(3),
	.table-responsive td:nth-child(3) {
		width: auto;
		min-width: 300px;
		text-align: left;
		align-content: baseline;
	}

	.table-responsive th:nth-child(4),
	.table-responsive td:nth-child(4) {
		min-width: 200px;
		/* text-align: center; */
		align-content: baseline;
	}

	.table-responsive th:nth-child(5),
	.table-responsive td:nth-child(5) {
		min-width: 100px;
		text-align: center;
		align-content: baseline;
	}

	.table-responsive th:nth-child(6),
	.table-responsive td:nth-child(6) {
		min-width: 100px;
		text-align: center;
		align-content: baseline;
	}

	.table-responsive th:nth-child(7),
	.table-responsive td:nth-child(7) {
		min-width: 80px;
		text-align: center;
		align-content: baseline;
	}

	.table-responsive th:nth-child(8),
	.table-responsive td:nth-child(8) {
		min-width: 80px;
		text-align: center;
	}
</style>

<div class="container-fluid mb-5 p-0">
	<div class="row p-2 border-bottom fs-3 mb-4 shadow-sm text-uppercase">Penjadwalan Ujian</div>
	<div class="table-responsive">
		<table class="table table-hover table-striped table-bordered border" id="jsdata">
			<thead class="table-info text-center align-baseline">
				<tr class="align-middle">
					<th rowspan="2" style="width: 5%;">No.</th>
					<th rowspan="2" style="width: 7%;">Kode Soal</th>
					<th rowspan="2" style="width: 15%;">Mata Pelajaran</th>
					<th rowspan="2" style="width: 15%;">Nama Pembuat</th>
					<th rowspan="2" style="width: 10%;">Kelas | Jurusan</th>
					<th rowspan="2" style="width: 5%;">Soal</th>
					<th rowspan="2" style="width: 5%;">Status</th>
					<th rowspan="2" style="width: 5%;">Opsi</th>
				</tr>
				<tr>
				</tr>
			</thead>
			<tbody id="dtable">
			</tbody>
		</table>
	</div>

	<div class="col-auto px-3 alert-success alert">
		<h4>Catatan :</h4>
		<table class="text-dark">
			<tr>
				<td style="width: 75px;"><a class="btn btn-sm btn-primary"><i class="bi bi-check2"></i> Aktif</a></td>
				<td>Soal Siap untuk di ujikan</td>
			</tr>
			<tr>
				<td><a class='btn btn-sm btn-info'>SET</a></td>
				<td> Soal Siap untuk di Jadwalkan</td>
			</tr>
			<tr>
				<td><span class='btn btn-sm btn-info fs-6'><div class="bi bi-eye"></div></span></td>
				<td> Menampilkan <b>Jadwal Ujian Aktif</b> berdasarkan kode soal</td>
			</tr>
			<tr>
				<td><span class='btn btn-sm btn-warning fs-6'><i class="bi bi-clock-history"></div></span></td>
				<td> Menampilkan <b>Riwayat Ujian</b> berdasarkan kode soal</td>
			</tr>
			<tr>
				<td><span class='btn btn-sm btn-primary fs-6'><div class="bi bi-gear"></div></span></td>
				<td> Pengaturan pendajwalan soal</td>
			</tr>
		</table>
		<p>
			Jika data Penjadwalan Ujian belum muncul atau data belum tersedia ataupun belum status <a class="btn btn-sm btn-info">SET</a> <br> silahkan aktifkan terlebih dahulu pada menu bank soal atau klik <a href="?md=soal">disini</a><br></p>
	</div>
</div>


<!--=== Modal ===-->
<?php
$dtmpl  = mysqli_query($koneksi, "SELECT * FROM cbt_pktsoal WHERE cbt_pktsoal.sts = 'Y' ORDER BY id_pktsoal ASC");
while ($dt = mysqli_fetch_array($dtmpl)) {
	$mpel = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM mapel WHERE kd_mpel ='$dt[kd_mpel]'"));
	$jsl  = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM cbt_soal WHERE kd_soal ='$dt[kd_soal]'"));
	$jdwl = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM jdwl WHERE kd_soal ='$dt[kd_soal]' AND sts='Y'"));

	if ($dt['kd_kls'] == "1") {
		$kkelas = "";
	} else {
		$kkelas = $dt['kd_kls'] . '_';
	}
	if ($dt['kls'] == "1") {
		$kelas = "Semua";
	} else {
		$kelas = $dt['kls'];
	}
	if ($dt['jur'] == "1") {
		$jurusan = "Semua";
	} else {
		$jurusan = $dt['jur'];
	}
?>
	<div class="modal modal-lg fade" id="mdlpsi<?php echo $dt[0] ?>" tabindex="-1" aria-labelledby="OpsiLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h1 class="modal-title fs-5" id="OpsiLabel">Penjadwalan : <?= $mpel['nm_mpel'] ?></h1>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<form action="" method="post">
					<div class="modal-body">
						<div class="row">
							<div class="col-12 m-0 border-bottom">
								<table class="fw-normal caption-top">
									<caption class="fw-semibold text-decoration-underline">Info Paket Soal</caption>
									<tr valign="top">
										<td style="width: 170px;">Kode Soal</td>
										<td>:</td>
										<td class="fw-bold"><?php echo $dt['kd_soal'] ?>
											<input type="text" hidden id="kds" name="kds" value="<?php echo $dt['kd_soal'] ?>">
										</td>
									</tr>
									<tr valign="top">
										<td style="width: 170px;">Mata Pelajaran</td>
										<td>:</td>
										<td class="fw-bold"><?php echo $mpel['nm_mpel'] ?>
											<input type="text" hidden id="kmpel" name="kmpel" value="<?php echo $mpel['kd_mpel'] ?>">
										</td>
									</tr>
									<tr valign="top">
										<td>Pembuat Soal</td>
										<td>: </td>
										<td>
											<h5><?php echo $dt['author'] ?></h5>
											<input type="text" name="author" id="author" value="<?= $dt['author']; ?>" hidden>
										</td>
									</tr>
									<tr valign="top">
										<td>Jumlah Data Soal</td>
										<td>:</td>
										<td>
											<?php if ($jsl < $dt['jum_soal']) {
												echo '<u class="text-danger text-decoration-none">' . $jsl . ' data soal</u>, ';
											} elseif ($jsl == $dt['jum_soal']) {
												echo '<u class="fw-semibold text-decoration-none">' . $jsl . ' data soal</u>, ';
											} else {
												echo '<u class="text-success text-decoration-none">' . $jsl . ' data soal</u>, ';
											}
											echo '' . $dt['jum_soal'] . ' ditampilkan' ?></td>
									</tr>
								</table>
							</div>
						</div>
						<div class="row mt-3 g-2">
							<div class="col-md-6 col-12">
								<div class="input-group">
									<label class="input-group-text bg-success-subtle" for="inputGroupSelect01">Pelaksanaan Tes</label>
									<select class="form-select" id="mode_uji" name="mode_uji">
										<option selected value="0">Offline</option>
										<option value="1">Online</option>
									</select>
								</div>
							</div>
						</div>
						<div class="row mt-3 g-2">
							<div class="col-md-6 col-12">
								<div class="input-group">
									<span for="kkls" class="input-group-text bg-dark-subtle" style="width: 115px;">Nama Kelas</span>
									<select name="kkls" id="kkls" class="form-select">
										<option value="1">Semua</option>
										<?php
										$dtt = (mysqli_query($koneksi, "SELECT * FROM kelas"));
										while ($row = mysqli_fetch_array($dtt)) { ?>
											<option value="<?= $row['kd_kls']; ?>" <?= ($dt['kd_kls'] == $row['kd_kls'] ? "selected" : "") ?>><?= $row['nm_kls']; ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
							<div class="col-md-6 col-12">
								<div class="input-group">
									<span for="kls" class="input-group-text bg-dark-subtle" style="width: 115px;">Kelas</span>
									<select name="kls" id="kls" class="form-select">
										<option value="1">Semua</option>
										<?php
										$dtt = (mysqli_query($koneksi, "SELECT * FROM kelas GROUP BY kls"));
										while ($row = mysqli_fetch_array($dtt)) { ?>
											<option value="<?= $row['kls']; ?>" <?= ($dt['kls'] == $row['kls'] ? "selected" : "") ?>><?= $row['kls']; ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
							<div class="col-md-6 col-12">
								<div class="input-group">
									<span for="jur" class="input-group-text bg-dark-subtle" style="width: 115px;">Jurusan</span>
									<select name="jur" id="jur" class="form-select">
										<option value="1">Semua</option>
										<?php
										$dtt = (mysqli_query($koneksi, "SELECT * FROM kelas GROUP BY jur"));
										while ($row = mysqli_fetch_array($dtt)) { ?>
											<option value="<?= $row['jur']; ?>" <?= ($dt['jur'] == $row['jur'] ? "selected" : "") ?>><?= $row['jur']; ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
							<div class="col-md-6 col-12">
								<div class="input-group">
									<span for="ses" class="input-group-text bg-dark-subtle" style="width: 115px;">Sesi</span>
									<select name="ses" id="ses" class="form-select">
										<?php
										$dtt = (mysqli_query($koneksi, "SELECT * FROM kelas"));
										for ($i = 0; $i <= 7; $i++) { ?>
											<option value="<?= $i; ?>" <?= ($dt['sesi'] == $i ? "selected" : "") ?>><?= ($i == 0) ? "Semua" : $i ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
						</div>
						<div class="row mt-3 g-2">
							<div class="col-md-6 col-12">
								<div class="input-group">
									<span class="input-group-text bg-primary-subtle" id="basic-addon1" style="width: 115px;">Jenis Tes</span>
									<select class=" form-select" name="kdtes" id="kdtes">
										<option value="PH">Penilaian Harian</option>
										<option value="PTS">Penilaian Tengah Semester</option>
										<option value="PAS">Penilaian Akhir Semester</option>
										<option value="UA">Ujian Akhir</option>
									</select>
								</div>
							</div>
							<div class="col-md-6 col-12">
								<div class="input-group">
									<span class="input-group-text bg-info-subtle" id="basic-addon1" style="width: 115px;">Tanggal</span>
									<input type="date" id="tgl" name="tgl" class="form-control" value="<?= date('Y-m-d'); ?>">
								</div>
							</div>
						</div>
						<div class="row mt-auto g-2">
							<div class="col-md-6 col-12">
								<div class="input-group">
									<span class="input-group-text bg-dark-subtle" id="basic-addon1" style="width: 115px;">Jam Mulai</span>
									<input type="time" id="jm_awal" name="jm_awal" class="form-control" value="<?= date('H:i'); ?>" required>
								</div>
							</div>
							<div class="col-md-6 col-12">
								<div class="input-group">
									<span class="input-group-text bg-dark-subtle" id="basic-addon1" style="width: 115px;">Jam Akhir</span>
									<input type="time" id="jm_akhir" name="jm_akhir" class="form-control" value="<?= date('H:i'); ?>" required>
								</div>
							</div>
							<div class="col-md-6 col-12">
								<div class="input-group">
									<span class="input-group-text bg-dark-subtle" id="basic-addon1" style="width: 115px;">Durasi</span>
									<input type="number" id="durasi" min="" name="durasi" class="form-control" value="" required placeholder="Menit">
								</div>
							</div>
							<div class="col-md-6 col-12">
								<div class="input-group">
									<span class="input-group-text bg-dark-subtle" id="basic-addon1" style="width: 115px;">Telat Login</span>
									<input type="number" id="telat" name="telat" class="form-control" value="" required placeholder="Menit">
								</div>
							</div>
							<div class="col-md-6 col-12">
								<div class="input-group">
									<span class="input-group-text bg-dark-subtle" id="basic-addon1" style="width: 115px;">Token</span>
									<input type="text" id="token" name="token" class="form-control" value="<?php echo GeraHash(5)  ?>" required>
									<select class=" form-select" name="ttoken" id="ttoken">
										<option value="T">Tidak Tampil</option>
										<option value="Y">Tampil</option>
									</select>
								</div>
							</div>
							<div class="col-md-6 col-12">
								<div class="input-group">
									<span class="input-group-text bg-dark-subtle" id="basic-addon1" style="width: 115px;">Nilai</span>
									<select class="form-select" name="nilai" id="nilai">
										<option value="T">Tidak Tampil</option>
										<option value="Y">Tampil</option>
									</select>
								</div>
							</div>
							<label for=""></label>
							<label for=""></label>
						</div>
					</div>
					<div class="modal-footer">
						<button type="submit" id="simpan" name="simpan" class="btn btn-primary">Simpan</button>
					</div>
				</form>
			</div>
		</div>
	</div>
<?php } ?>

<!-- Modal -->
<div class="modal fade modal-lg" id="modalview" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h1 class="modal-title fs-5" id="exampleModalLabel"><span id='typ'> Aktif</span> | <i id="kdsoal"></i></h1>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div id="view"></div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
			</div>
		</div>
	</div>
</div>

<!-- <script src="./../node_modules/jquery/dist/jquery.min.js"></script> -->
<script src="../node_modules/jquery/dist/jquery.js"></script>

<!-- Aktivasi -->
<script>
	function statusSoal(id) {
		// Kirimkan ID soal ke server menggunakan AJAX
		$.ajax({
			url: 'db/dbproses.php?pr=sts&dt=' + id, // File PHP untuk menyimpan data
			type: 'POST',
			success: function(response) {
				$('#dtable').load("./page/content/set_jdwl.php");
			}
		});
	}
</script>
<!-- Akhir Aktivasi -->

<!-- Table -->
<script>
	document.addEventListener("DOMContentLoaded", function() {
		const dataTableElement = document.querySelector("#jsdata");


		// Memuat data tabel menggunakan AJAX
		fetch("./page/content/set_jdwl.php")
			.then((response) => response.text())
			.then((data) => {
				const tableBody = document.querySelector("#dtable");
				if (tableBody) {
					tableBody.innerHTML = data;

					// Inisialisasi ulang DataTable setelah data dimuat
					if (dataTableElement) {
						new simpleDatatables.DataTable(dataTableElement, {
							perPageSelect: [5, 10, 25, 50, "All"],
							perPage: 5,
							labels: {
								placeholder: "Cari...",
								perPage: " Data per halaman",
								noRows: "Tidak ada data yang ditemukan",
								info: "Menampilkan {start}/mdlpsi{end} dari {rows} Data",
							},
						});
					}
				}
				const element = document.querySelector("tbody"); // Pilih elemen berdasarkan kelas
				if (element) {
					element.id = "dtable"; // Tambahkan atribut id
				}
			})
			.catch((error) => console.error("Gagal memuat data tabel:", error));
	});
</script>
<!-- Akhir Table -->

<script>
	function modalView(kdSoal,tipe) {
		$('#modalview').modal('show');
		$('#kdsoal').text(kdSoal);
		var dOpsi, dId,typ;
		dOpsi = 'df_jdwl';
		dId = kdSoal;
		typ = tipe;

		$.ajax({
			type: 'POST',
			url: './page/content/edit_mdal.php',
			data: {
				opsi: dOpsi,
				id: dId,
				tm:typ,
			},

			success: function(data) {
				$('#view').html(data);
				if (typ=='hs') {
					$('#typ').text('Riwayat Ujian');
				}else{
					$('#typ').text('Daftar Jadwal Aktif');
				}
			}
		});
	}
</script>
<script type="text/javascript">
	function deleteJdwl(id,token) {
		// Menampilkan konfirmasi menggunakan SweetAlert2
		Swal.fire({
			title: 'Apakah Anda yakin?',
			text: "Data yang dihapus tidak dapat dikembalikan!",
			icon: 'warning',
			showCancelButton: true,
			confirmButtonText: 'Hapus',
			cancelButtonText: 'Batal',
		}).then((result) => {
			// Jika user menekan tombol 'Hapus'
			if (result.isConfirmed) {
				// Melakukan permintaan AJAX untuk menghapus data
				$.ajax({
					url: './db/db_edit_modal.php?jdw=del', // Ganti dengan URL untuk menghapus data
					type: 'POST',
					data: {
						id: id,token:token
					}, // Mengirimkan id data yang akan dihapus
					success: function(data) {
						// Menampilkan notifikasi sukses jika data berhasil dihapus
						Swal.fire(
							'Terhapus!',
							'Data telah berhasil dihapus.',
							'success'
						).then((result) => {
							if (result.isConfirmed) {
								// Reload halaman setelah dialog ditutup
								location.reload();
							}
						});
					},
					error: function(xhr, status, error) {
						// Menampilkan pesan error jika permintaan AJAX gagal
						console.error('Error:', error);
						Swal.fire(
							'Gagal!',
							'Data gagal dihapus. Silakan coba lagi.',
							'error'
						);
					}
				});
			}
		});
	}
</script>