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
?>

<style>
	#ps {
		display: flex;
	}

	.soal {
		background-color: aqua;
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
			<div class="col-auto">
				<a href="?md=uj_set"><button class="btn btn-outline-dark fw-semibold" type="button" data-bs-toggle="modal" data-bs-target=""><i class="bi bi-clipboard2-check"></i> Jadwalkan Bank Soal</button></a>
			</div>
		</div>
		<div class="table-responsive">
			<table class="table table-hover table-striped table-bordered">
				<thead class="table-info text-center align-baseline">
					<tr>
						<th style="width: 30px;">No.</th>
						<th style="min-width: 100px;">Kode Soal</th>
						<th style="min-width: 300px">Mata Pelajaran</th>
						<th style="min-width: 130px">Pembuat</th>
						<th style="min-width: 170px;">Kelas | Jurusan | Nama Kelas</th>
						<th style="width: 5%;">Soal </th>
						<th style="width: 5%;">KKM </th>
						<th style="width: 50px;">Status Soal</th>
						<th style="min-width: 145px;">Atur | Edit | Hapus</th>
					</tr>
				</thead>
				<tbody>
					<?php

					$batas = 10;
					$hal   = isset($_GET['pg']) ? (int)$_GET['pg'] : 1;
					$hal_awal = ($hal > 1) ? ($hal * $batas) - $batas : 0;

					$previous = $hal - 1;
					$next     = $hal + 1;

					$no = 1;
					$selectSQL = "SELECT * FROM cbt_pktsoal";
					$data = mysqli_query($koneksi, $selectSQL);
					$jml_data = mysqli_num_rows($data);
					$tot_hal = ceil($jml_data / $batas);

					$dtmpl  = mysqli_query($koneksi, "SELECT * FROM cbt_pktsoal ORDER BY id_pktsoal ASC limit $hal_awal,$batas");
					while ($dt = mysqli_fetch_array($dtmpl)) {
						$dtmp = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM mapel WHERE kd_mpel ='$dt[kd_mpel]';"));
						$dtjs = mysqli_fetch_array(mysqli_query($koneksi, "SELECT COUNT(*) AS dtsoal FROM cbt_soal WHERE kd_soal ='$dt[kd_soal]';"));
						$qrkls = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM kelas WHERE kd_kls ='$dt[kd_kls]';"));

						if ($dt['kd_kls'] == "1") {
							$dtkls	= " | " . "Semua";
						} else {
							$dtkls	= " | " . $qrkls['nm_kls'];
						}

						if ($dt['kls'] == "1") {
							$kls	= "Semua";
						} else {
							$kls	= $dt['kls'];
						}

						if ($dt['jur'] == "1") {
							$jurkls	= " | " . "Semua";
						} else {
							$jurkls	= " | " . $dt['jur'];
						}

						if ($dt['kd_kls'] == "1" && $dt['kls'] == "1" && $dt['jur'] == "1") {
							$dtkls = "Seluruh Kelas";
							$kls="";$jurkls="";
						}


					?>
						<tr class="text-center">
							<th><?php echo $no++ ?></th>
							<td><?php echo $dt['kd_soal'] ?></td>
							<td><?php echo $dtmp['nm_mpel'] ?></td>
							<td><?php echo $dt['author'] ?></td>
							<td><?php if (!empty($dt['kd_kls'])) {
										echo $kls .  $jurkls.$dtkls;
									} else {
										echo "<div class='text-danger'>Silahkan Pilih Kelas</div>";
									} ?></td>
							<td><?php echo $dtjs['dtsoal'] . "/" . $dt['jum_soal'] ?></td>
							<td><?php echo $dt['kkm'] ?></td>
							<td>
								<?php

								if ($dt['sts'] == "Y") {
									echo "<a href='./db/dbproses.php?pr=sts&dt=" . $dt['id_pktsoal'] . "' class='btn btn-sm btn-primary'>Aktif</a>";
								} else {
									echo "<a href='./db/dbproses.php?pr=sts&dt=" . $dt['id_pktsoal'] . "' class='btn btn-sm btn-info'>Modif</a>";
								}

								?>
							</td>
							<td class="text-center">
								<button class="btn btn-sm btn-info fs-6" type="button" data-bs-toggle="modal" data-bs-target="#Edit<?php echo $dt[0]; ?>"><i class="bi bi-gear"></i></button> |
								<a href="?md=esoal&ds=<?php echo $dt[0]; ?>" class="btn btn-sm btn-warning fs-6"><i class="bi bi-pencil-square"></i></a>
								<?php if ($dtjs['dtsoal'] == 0) {
									echo ' | <a href="?md=soal&pesan=hapus&us=' . $dt["id_pktsoal"] . '" class="btn btn-sm btn-danger fs-6 alert_notif"><i class="bi bi-trash3"></i></a>';
								} ?>
							</td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
		<?php if ($jml_data >= $batas) { ?>
			<nav aria-label="Page navigation example">
				<ul class="pagination pagination-sm justify-content-end pe-3">
					<li class="page-item">
						<a class="page-link 
						<?php if ($hal == 1) {
							echo 'disabled';
						} ?>" <?php
									if ($hal > 1) {
										echo "href='?md=soal&pg=$previous'";
									} ?>><i class="bi bi-chevron-left"></i></a>
					</li>
					<?php
					for ($i = 1; $i <= $tot_hal; $i++) { ?>
						<li class="page-item 
        <?php if ($hal == $i) {
							echo 'active';
						} ?>"><a class="page-link" href="?md=soal&pg=<?php echo $i ?>"><?php echo $i; ?></a></li>
					<?php
					}
					?>
					<li class="page-item">
						<a class="page-link 
        <?php if ($hal == $tot_hal) {
					echo 'disabled';
				} ?>" <?php if ($hal < $tot_hal) {
								echo "href='?md=soal&pg=$next'";
							} ?>><i class="bi bi-chevron-right"></i></a>
					</li>
				</ul>
			</nav>
		<?php }
		// else{echo "<div class='col-12 text-center'>data kosong</div>";} 
		?>
		<div class="col-auto px-3 alert-success alert">
			<h4>Catatan :</h4>
			<p>Apabila Status Soal dalam keadaan <a class="btn btn-sm btn-info">Modif</a> maka soal belum dapat dijadwalkan <br>
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
							<input type="text" class="form-control" id="kd_soal" name="kd_soal" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" placeholder="Kode Tidak Boleh Sama" value="">
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
							<input type="text" class="form-control" id="nm" name="nm" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" placeholder="Nama Pembuat Soal" value="">
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
							<input type="number" min="1" max="10" class="form-control" id="sesi" name="sesi" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" placeholder="Sesi" value="" required>
							<input type="number" min="10" max="100" class="form-control" id="kkm" name="kkm" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" placeholder="KKM" onkeypress="return angka (event)" onchange="batas(this)" value="" required>
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
								<input type="number" min="10" max="100" class="form-control" id="kkm" name="kkm" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" placeholder="KKM" onkeypress="return angka (event)" onchange="batas(this)" value="<?php echo $mddt['kkm'] ?>" required>
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
								<input type="text" class="form-control" id="kd_soal" name="kd_soal" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" placeholder="Kode Tidak Boleh Sama" value="<?php echo $mddt['kd_soal'] . "-Copy_" . rand(); ?>">
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