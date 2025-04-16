<?php
error_reporting(0); //hide error

if ($_GET['pesan'] == "hapus") {
?>
	<script>
		Swal.fire({
			title: 'Berhasil!',
			text: 'Data Berhasil dihapus.',
			icon: 'success'
		}).then((result) => {
			if (result.isConfirmed) {
				<?php
				$dths = $_GET['us'];
				if ($dths == "all") {
					mysqli_query($koneksi, "DELETE FROM cbt_pktsoal");
				} else {
					mysqli_query($koneksi, "DELETE FROM cbt_pktsoal WHERE cbt_pktsoal.id_pktsoal = '$dths'");
				}
				?>
				location.replace("?md=soal");
			}
		})
	</script>
<?php
}

if ($dt_adm['lvl'] == "A") {
	$adm = "1" ;
} else {
	$adm = $dt_adm['nm_user'];
}
?>

<style>
	#ps {
		display: flex;
	}

	.soal {
		background-color: aqua;
	}

	/* Gaya tabel */
	.table-responsive th:nth-child(1),
	.table-responsive td:nth-child(1) {
		min-width: 25px;
		text-align: center;
		align-content: baseline;
	}

	.table-responsive th:nth-child(2),
	.table-responsive td:nth-child(2) {
		min-width: 150px;
		text-align: center;
	}

	.table-responsive th:nth-child(3),
	.table-responsive td:nth-child(3) {
		width: auto;
		min-width: 300px;
		text-align: left;
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
		min-width: 100px;
		text-align: center;
		align-content: baseline;
	}

	.table-responsive th:nth-child(8),
	.table-responsive td:nth-child(8) {
		min-width: 80px;
		text-align: center;
		align-content: baseline;
	}

	.table-responsive th:nth-child(9),
	.table-responsive td:nth-child(9) {
		min-width: 150px;
		text-align: center;
		align-content: baseline;
	}

	/* Sembunyikan tabel secara default */
	#dataTable {
		display: none;
	}
</style>
<?php
$cek_mpel = mysqli_query($koneksi, "SELECT *FROM mapel");
if (!empty(mysqli_num_rows($cek_mpel))) {
?>
	<div class="container-fluid mb-5 p-0">
		<div class="row p-2 border-bottom fs-3 mb-4 shadow-sm ">Daftar Soal</div>
		<div class="row mb-3 mx-2">
			<div class="col-auto">
				<button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#tambah"><i class="bi bi-person-plus"></i> Tambah Bank Soal</button>
			</div>
			<?php if ($dt_adm['lvl'] == "A") { ?>
				<div class="col-auto">
					<a href="?md=uj_set"><button class="btn btn-outline-dark fw-semibold" type="button" data-bs-toggle="modal" data-bs-target=""><i class="bi bi-clipboard2-check"></i> Jadwalkan Bank Soal</button></a>
				</div>
			<?php } ?>
		</div>
		<div class="table-responsive">
			<table class="table table-hover table-striped table-bordered border" id="jsdata">
				<thead class="table-info text-center align-baseline">
					<tr>
						<th style="width: 30px;">No.</th>
						<th style="min-width: 100px;">Kode Soal</th>
						<th style="min-width: 300px;">Mata Pelajaran</th>
						<th style="min-width: 130px;">Pembuat</th>
						<th style="min-width: 170px;">Kelas</th>
						<th style="width: 5%;">Soal</th>
						<th style="width: 5%;">KKM</th>
						<th style="width: 50px;">Status Soal</th>
						<th style="max-width: 140px;">Opsi | Edit | Print | Hapus</th>
					</tr>
				</thead>
				<tbody id="dtable">
					<!-- Data tabel akan dimuat di sini secara dinamis -->
				</tbody>
			</table>

		</div>

		<?php
		// require_once('table/tbl_df_soal.php') 
		?>

		<div class="col-auto px-3 alert-success alert">
			<h4>Catatan :</h4>
			<p>Apabila Status Soal dalam keadaan <a class="btn btn-sm btn-outline-dark">Modif</a> maka soal belum dapat dijadwalkan <br>
				untuk mengaktifkan soal silahkan Klik tombol Modif maka status soal akan menjadi <a class="btn btn-sm btn-primary">Aktif</a>
			</p>
			<p class="bg-danger text-white p-1" style="border-radius: 3px;">1. Apabila melakukan hapus Bank Soal maka riwayat ujian otomatis di hapus. <br>2. Untuk melakukan hapus Bank Soal silahkan kosongkan terlebih dahulu data soal maka tombol hapus akan muncul.</p>
		</div>
	</div>
<?php } else { ?>
	<div class="container-fluid">
		<div class="row m-5">
			<div class="col-12 text-center">
				<h4>Halaman Ini akan tampil apabila data <u>Mata Pelajaran</u> sudah terisi</h4>
			</div>
		</div>
	</div>
<?php } ?>
<!-- === Modal === -->
<!-- === Tambah === -->
<div class="modal fade" id="tambah" tabindex="-1" aria-labelledby="tambahLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h1 class="modal-title fs-5" id="tambahLabel">Tambah Bank Soal</h1>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<form action="./db/dbproses.php?pr=pkt" method="post">
				<div class="modal-body">
					<div class="row g-1">
						<div class="input-group input-group-sm">
							<label class="input-group-text col-3" id="nmkls">Nama Kelas</label>
							<select class="form-select" id="nmkls" name="nmkls">
								<option value="1">Semua</option>
								<?php
								$kls	= mysqli_query($koneksi, "SELECT * FROM kelas GROUP BY nm_kls");
								while ($dtkl = mysqli_fetch_array($kls)) {
									echo "
										<option value='$dtkl[kd_kls]'>$dtkl[nm_kls]</option>
										";
								}
								?>
							</select>
						</div>
						<div class="input-group input-group-sm">
							<label class="input-group-text col-3" id="kls">Kelas</label>
							<select class="form-select" id="kls" name="kls">
								<option value="1">Semua</option>
								<?php
								$kls	= mysqli_query($koneksi, "SELECT * FROM kelas GROUP BY kls");
								while ($dtkl = mysqli_fetch_array($kls)) {
									echo "
										<option value='$dtkl[kls]'>$dtkl[kls]</option>
										";
								}
								?>
							</select>
						</div>
						<div class="input-group input-group-sm">
							<label class="input-group-text col-3" id="jur">Jurusan</label>
							<select class="form-select" id="jur" name="jur">
								<option value="1">Semua</option>
								<?php
								$kls	= mysqli_query($koneksi, "SELECT * FROM kelas GROUP BY jur");
								while ($dtkl = mysqli_fetch_array($kls)) {
									echo "
										<option value='$dtkl[jur]'>$dtkl[jur]</option>
										";
								}
								?>
							</select>
						</div>
						<div class="input-group input-group-sm">
							<label class="input-group-text col-3" id="kd_soal">Kode Soal</label>
							<input type="text" class="form-control" id="kd_soal" name="kd_soal" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" placeholder="Kode Tidak Boleh Sama" value="<?= $dt_adm != "A" ? $adm .'_'.rand() : ""; ?>">
						</div>
						<div class="input-group input-group-sm">
							<label class="input-group-text col-3" id="mpel">Mata Pelajaran</label>
							<select class="form-select" id="mpel" name="mpel">
								<?php
								$kls	= mysqli_query($koneksi, "SELECT * FROM mapel");
								while ($dtkl = mysqli_fetch_array($kls)) {
									echo "
										<option value='$dtkl[kd_mpel]'>$dtkl[nm_mpel]</option>
										";
								}
								?>
							</select>
						</div>
						<div class="input-group input-group-sm">
							<label class="input-group-text col-3" id="nm">Nama Pembuat</label>
							<input type="text" class="form-control" id="nm" name="nm" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" placeholder="Nama Pembuat Soal" value="<?= $dt_adm['lvl'] != 'A' ? $dt_adm['nm_user'] : ''; ?>" <?= $dt_adm['lvl'] != 'A' ? 'readonly' : ''; ?>>
						</div>
						<div class="input-group input-group-sm">
							<label class="input-group-text col-3" id="pg">Pilihan Ganda</label>
							<input type="text" class="form-control" id="pg" name="pg" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" placeholder="Jumlah Pilihan Ganda" value="">
							<input type="text" class="form-control" id="prpg" name="prpg" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" placeholder="Persentasi Pilihan Ganda" value="">
						</div>
						<div class="input-group input-group-sm">
							<label class="input-group-text col-3" id="es">Esai</label>
							<input type="text" class="form-control" id="es" name="es" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" placeholder="Jumlah Esai" value="">
							<input type="text" class="form-control" id="pres" name="pres" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" placeholder="Persentasi Esai" value="">
						</div>
						<div class="input-group input-group-sm">
							<!-- <label class="input-group-text col-3" id="kkm">Soal</label> -->
							<input type="number" min="1" max="10" class="form-control" id="sesi" name="sesi" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" placeholder="Sesi" value="<?= $dt_adm['lvl'] != 'A' ? '1' : ''; ?>" <?= $dt_adm['lvl'] != 'A' ? 'readonly' : 'required'; ?>>
							<input type="number" min="10" max="100" class="form-control" id="kkm" name="kkm" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" placeholder="KKM" onkeypress="return angka (event)" onchange="batas(this)" value="">
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
					<button type="submit" class="btn btn-primary" id="tambah" name="tambah">Tambah</button>
				</div>
			</form>
		</div>
	</div>
</div>

<!-- === Edit === -->
<?php
$mdedit	=	mysqli_query($koneksi, "SELECT * FROM cbt_pktsoal ORDER BY id_pktsoal ASC");

while ($mddt = mysqli_fetch_array($mdedit)) {
?>
	<div class="modal fade" id="Edit<?php echo $mddt[0]; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="EditLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h1 class="modal-title fs-5" id="EditLabel">Edit Bank Soal | <?php echo $mddt['kd_soal'] ?></h1>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<form action="./db/dbproses.php?pr=epkt" method="post">
					<div class="modal-body">
						<div class="row g-1">
							<div class="input-group input-group-sm">
								<label class="input-group-text col-3" id="nmkls">Nama Kelas</label>
								<select class="form-select" id="nmkls" name="nmkls">
									<option value="1">Semua</option>
									<?php
									$kls	= mysqli_query($koneksi, "SELECT * FROM kelas GROUP BY nm_kls");
									while ($dtkl = mysqli_fetch_array($kls)) {
										echo "
										<option value='$dtkl[kd_kls]' ";
										if ($mddt['kd_kls'] == $dtkl['kd_kls']) {
											echo "selected";
										}
										echo ">$dtkl[nm_kls]</option>
										";
									}
									?>
								</select>
							</div>
							<div class="input-group input-group-sm">
								<label class="input-group-text col-3" id="kls">Kelas</label>
								<select class="form-select" id="kls" name="kls">
									<option value="1">Semua</option>
									<?php
									$kls	= mysqli_query($koneksi, "SELECT * FROM kelas GROUP BY kls");
									while ($dtkl = mysqli_fetch_array($kls)) {
										echo "
										<option value='$dtkl[kls]'";
										if ($mddt['kls'] == $dtkl['kls']) {
											echo "selected";
										}
										echo ">$dtkl[kls]</option>
										";
									}
									?>
								</select>
							</div>
							<div class="input-group input-group-sm">
								<label class="input-group-text col-3" id="jur">Jurusan</label>
								<select class="form-select" id="jur" name="jur">
									<option value="1">Semua</option>
									<?php
									$kls	= mysqli_query($koneksi, "SELECT * FROM kelas GROUP BY jur");
									while ($dtkl = mysqli_fetch_array($kls)) {
										echo "
										<option value='$dtkl[jur]'";
										if ($mddt['jur'] == $dtkl['jur']) {
											echo "selected";
										}
										echo ">$dtkl[jur]</option>
										";
									}
									?>
								</select>
							</div>
							<!-- <div class="input-group input-group-sm"> -->
							<!-- <label class="input-group-text col-3" id="kd_soal">Kode Soal</label> -->
							<input type="text" class="form-control" id="kd_soal" name="kd_soal" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" placeholder="Kode Tidak Boleh Sama" value="<?php echo $mddt['kd_soal'] ?>" hidden>
							<!-- </div> -->
							<div class="input-group input-group-sm">
								<label class="input-group-text col-3" id="mpel">Mata Pelajaran</label>
								<select class="form-select" id="mpel" name="mpel">
									<?php
									$kls	= mysqli_query($koneksi, "SELECT * FROM mapel");
									while ($dtkl = mysqli_fetch_array($kls)) {
										echo "
										<option value='$dtkl[kd_mpel]'";
										if ($mddt['kd_mpel'] == $dtkl['kd_mpel']) {
											echo "selected";
										}
										echo ">$dtkl[nm_mpel]</option>
										";
									}
									?>
								</select>
							</div>
							<div class="input-group input-group-sm">
								<label class="input-group-text col-3" id="nm">Nama Pembuat</label>
								<input type="text" class="form-control" id="nm" name="nm" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" placeholder="Nama Pembuat Soal" value="<?php echo $mddt['author'] ?>">
							</div>
							<div class="input-group input-group-sm">
								<label class="input-group-text col-3" id="pg">Pilihan Ganda</label>
								<input type="text" class="form-control" id="pg" name="pg" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" placeholder="Jumlah Pilihan Ganda" value="<?php echo $mddt['pilgan'] ?>">
								<input type="text" class="form-control" id="prpg" name="prpg" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" placeholder="Persentasi Pilihan Ganda" value="<?php echo $mddt['prsen_pilgan'] ?>">
							</div>
							<div class="input-group input-group-sm">
								<label class="input-group-text col-3" id="es">Esai</label>
								<input type="text" class="form-control" id="es" name="es" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" placeholder="Jumlah Esai" value="<?php echo $mddt['esai'] ?>">
								<input type="text" class="form-control" id="pres" name="pres" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" placeholder="Persentasi Esai" value="<?php echo $mddt['prsen_esai'] ?>">
							</div>
							<div class="input-group input-group-sm">
								<label class="input-group-text col-3" id="sesi">Sesi</label>
								<input type="number" min="1" max="10" class="form-control" id="sesi" name="sesi" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" placeholder="Sesi" value="<?php echo $mddt['sesi'] ?>" required>
								<label class="input-group-text col-3" id="kkm">KKM</label>
								<input type="number" max="100" class="form-control" id="kkm" name="kkm" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" placeholder="KKM" onkeypress="return angka (event)" onchange="batas(this)" value="<?php echo $mddt['kkm'] ?>">
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-primary" id="Edit" name="Edit">Simpan</button>
						<button type="button" class="btn btn-success" data-bs-target="#copy<?php echo $mddt[0]; ?>" data-bs-toggle="modal">Copy Bank Soal</button>
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<!-- Copy Bank Soal -->
	<div class="modal fade" id="copy<?php echo $mddt[0]; ?>" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2" tabindex="-1">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h1 class="modal-title fs-5" id="exampleModalToggleLabel2">Copy Bank Soal | <?php echo $mddt['kd_soal'] ?></h1>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<form action="./db/dbproses.php?pr=cpkt" method="post">
					<div class="modal-body">
						<div class="row g-1">
							<div class="input-group input-group-sm">
								<label class="input-group-text col-3" id="nmkls">Nama Kelas</label>
								<select class="form-select" id="nmkls" name="nmkls">
									<option value="1">Semua</option>
									<?php
									$kls	= mysqli_query($koneksi, "SELECT * FROM kelas GROUP BY nm_kls");
									while ($dtkl = mysqli_fetch_array($kls)) {
										echo "
										<option value='$dtkl[kd_kls]' ";
										if ($mddt['kd_kls'] == $dtkl['kd_kls']) {
											echo "selected";
										}
										echo ">$dtkl[nm_kls]</option>
										";
									}
									?>
								</select>
							</div>
							<div class="input-group input-group-sm">
								<label class="input-group-text col-3" id="kls">Kelas</label>
								<select class="form-select" id="kls" name="kls">
									<option value="1">Semua</option>
									<?php
									$kls	= mysqli_query($koneksi, "SELECT * FROM kelas GROUP BY kls");
									while ($dtkl = mysqli_fetch_array($kls)) {
										echo "
										<option value='$dtkl[kls]'";
										if ($mddt['kls'] == $dtkl['kls']) {
											echo "selected";
										}
										echo ">$dtkl[kls]</option>
										";
									}
									?>
								</select>
							</div>
							<div class="input-group input-group-sm">
								<label class="input-group-text col-3" id="jur">Jurusan</label>
								<select class="form-select" id="jur" name="jur">
									<option value="1">Semua</option>
									<?php
									$kls	= mysqli_query($koneksi, "SELECT * FROM kelas GROUP BY jur");
									while ($dtkl = mysqli_fetch_array($kls)) {
										echo "
										<option value='$dtkl[jur]'";
										if ($mddt['jur'] == $dtkl['jur']) {
											echo "selected";
										}
										echo ">$dtkl[jur]</option>
										";
									}
									?>
								</select>
							</div>
							<div class="input-group input-group-sm">
								<label class="input-group-text col-3" id="kd_soal">Kode Soal</label>
								<input type="text" class="form-control" id="kd_soal" name="kd_soal" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" placeholder="Kode Tidak Boleh Sama" value="<?php echo $mddt['kd_soal'] . "-Copy_" . rand(1000, 9999); ?>">
								<input type="text" class="form-control" id="kds" name="kds" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" placeholder="Kode Tidak Boleh Sama" value="<?php echo $mddt['kd_soal']; ?>" hidden>
							</div>
							<div class="input-group input-group-sm">
								<label class="input-group-text col-3" id="mpel">Mata Pelajaran</label>
								<select class="form-select" id="mpel" name="mpel">
									<?php
									$kls	= mysqli_query($koneksi, "SELECT * FROM mapel");
									while ($dtkl = mysqli_fetch_array($kls)) {
										echo "
										<option value='$dtkl[kd_mpel]'";
										if ($mddt['kd_mpel'] == $dtkl['kd_mpel']) {
											echo "selected";
										}
										echo ">$dtkl[nm_mpel]</option>
										";
									}
									?>
								</select>
							</div>
							<div class="input-group input-group-sm">
								<label class="input-group-text col-3" id="nm">Nama Pembuat</label>
								<input type="text" class="form-control" id="nm" name="nm" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" placeholder="Nama Pembuat Soal" value="<?php echo $mddt['author'] ?>">
							</div>
							<div class="input-group input-group-sm">
								<label class="input-group-text col-3" id="pg">Pilihan Ganda</label>
								<input type="text" class="form-control" id="pg" name="pg" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" placeholder="Jumlah Pilihan Ganda" value="<?php echo $mddt['pilgan'] ?>">
								<input type="text" class="form-control" id="prpg" name="prpg" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" placeholder="Persentasi Pilihan Ganda" value="<?php echo $mddt['prsen_pilgan'] ?>">
							</div>
							<div class="input-group input-group-sm">
								<label class="input-group-text col-3" id="es">Esai</label>
								<input type="text" class="form-control" id="es" name="es" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" placeholder="Jumlah Esai" value="<?php echo $mddt['esai'] ?>">
								<input type="text" class="form-control" id="pres" name="pres" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" placeholder="Persentasi Esai" value="<?php echo $mddt['prsen_esai'] ?>">
							</div>
							<div class="input-group input-group-sm">
								<label class="input-group-text col-3" id="sesi">Sesi</label>
								<input type="number" min="1" max="10" class="form-control" id="sesi" name="sesi" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" placeholder="Sesi" value="<?php echo $mddt['sesi'] ?>" required>
								<label class="input-group-text col-3" id="kkm">KKM</label>
								<input type="number" min="10" max="100" class="form-control" id="kkm" name="kkm" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" placeholder="KKM" onkeypress="return angka (event)" onchange="batas(this)" value="<?php echo $mddt['kkm'] ?>" required>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-primary">Simpan</button>
						<button class="btn btn-secondary" type="button" data-bs-toggle="modal" data-bs-target="#Edit<?php echo $mddt[0]; ?>">Kembali</button>
					</div>
				</form>
			</div>
		</div>
	</div>
<?php } ?>

<!--===Akhir Modal===-->
<script src="../node_modules/jquery/dist/jquery.js"></script>
<!-- Aktivasi -->
<script>
	function statusSoal(id) {
		// Ambil elemen button berdasarkan ID
		var $sts = $('#sts' + id);

		// Tentukan teks dan kelas berdasarkan status tombol
		var buttonText = $sts.text().trim(); // Gunakan $sts untuk mendapatkan teks tombol
		var text, removeClass, addClass;

		if (buttonText == 'Aktif') {
			text = 'Modif';
			removeClass = 'btn-primary';
			addClass = 'btn-outline-dark';
		} else if (buttonText == 'Modif') {
			text = 'Aktif';
			removeClass = 'btn-outline-dark';
			addClass = 'btn-primary';
		}

		// Kirimkan ID soal ke server menggunakan AJAX
		$.ajax({
			url: 'db/dbproses.php?pr=sts&dt=' + id, // File PHP untuk menyimpan data
			type: 'POST',
			success: function(response) {
				// Ubah teks dan kelas tombol berdasarkan respons
				$sts.text(text); // Ganti teks tombol
				$sts.removeClass(removeClass); // Hapus kelas lama
				$sts.addClass(addClass); // Tambahkan kelas baru
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
		fetch("./page/content/tbl_df_soal.php?user=<?= $adm ?>")
			.then((response) => response.text())
			.then((data) => {
				const tableBody = document.querySelector("#dtable");
				if (tableBody) {
					tableBody.innerHTML = data;

					// Inisialisasi ulang DataTable setelah data dimuat
					if (dataTableElement) {
						new simpleDatatables.DataTable(dataTableElement, {
							perPageSelect: [5, 10, 25, 50, "All"],
							perPage: 10,
							labels: {
								placeholder: "Cari...",
								perPage: " Data per halaman",
								noRows: "Tidak ada data yang ditemukan",
								info: "Menampilkan {start}/{end} dari {rows} Data",
							},
						});
					}
				}
			})
			.catch((error) => console.error("Gagal memuat data tabel:", error));
	});
</script>
<!-- Akhir Table -->


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


	$('.alert_notif').on('click', function() {
		var getLink = $(this).attr('href');
		Swal.fire({
			title: 'Apa Anda Yakin?',
			text: "Data akan dihapus Secara Permanen!",
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Hapus',
			cancelButtonText: "Batal"
		}).then(result => {
			//jika klik ya maka arahkan ke proses.php
			if (result.isConfirmed) {
				window.location.href = getLink
			}
		})
		return false;
	});
</script>

<!-- 
	INSERT INTO `cbt_pktsoal` (`id_pktsoal`, `kd_kls`, `kls`, `jur`, `kd_mpel`, `kd_soal`, `sesi`, `pilgan`, `prsen_pilgan`, `esai`, `prsen_esai`, `jum_soal`, `tgl`, `author`, `sts`) VALUES (NULL, '3', '3', '3', '3', '3', '3', '3', '3', '3', '3', '3', current_timestamp(), '3', 'N');
-->