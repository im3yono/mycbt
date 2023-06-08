<?php

?>

<style>
	#ps {
		display: flex;
	}

	.soal {
		background-color: aqua;
	}
</style>

<div class="container-fluid mb-5 p-0">
	<div class="row p-2 border-bottom fs-3 mb-4 shadow-sm ">Daftar Soal</div>
	<div class="row mb-3 mx-2">
		<div class="col-auto">
			<button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#tambah"><i class="bi bi-person-plus"></i> Tambah Bank Soal</button>
		</div>
	</div>
	<div class="table-responsive">
		<table class="table table-hover table-striped table-bordered">
			<thead class="table-info text-center align-baseline">
				<tr>
					<th style="width: 5%;">No.</th>
					<th style="width: 10%;">Kode Soal</th>
					<th style="width: 35%;">Mata Pelajaran</th>
					<th style="width: 10%;">Pembuat</th>
					<th style="width: 15%;">Nama Kelas | Kelas | Jurusan</th>
					<th style="width: 5%;">Soal </th>
					<th style="width: 5%;">KKM </th>
					<th style="width: 5%;">Status Soal</th>
					<th style="width: 10%;">Atur | Edit | Hapus</th>
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
					$dtkls = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM kelas WHERE kd_kls ='$dt[kd_kls]';"));
					$dtjs = mysqli_fetch_array(mysqli_query($koneksi, "SELECT COUNT(*) AS dtsoal FROM cbt_soal WHERE kd_soal ='$dt[kd_soal]';"));
				?>
					<tr class="text-center">
						<th><?php echo $no++ ?></th>
						<td><?php echo $dt['kd_soal'] ?></td>
						<td><?php echo $dtmp['nm_mpel'] ?></td>
						<td><?php echo $dt['author'] ?></td>
						<td><?php if (!empty($dt['kd_kls'])) {
									echo $dtkls['nm_kls'] . " | " . $dt['kls'] . " | " . $dt['jur'];
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
							<button class="btn btn-sm btn-info fs-6 mb-1" type="button" data-bs-toggle="modal" data-bs-target="#Edit<?php echo $dt[0]; ?>"><i class="bi bi-gear"></i></button> |
							<button class="btn btn-sm btn-warning fs-6 mb-1"><i class="bi bi-pencil-square"></i></button> |
							<button class="btn btn-sm btn-danger fs-6"><i class="bi bi-trash3"></i></button>
						</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>

<!-- === Modal === -->
<!-- === Tambah === -->
<div class="modal fade" id="tambah" tabindex="-1" aria-labelledby="tambahLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h1 class="modal-title fs-5" id="tambahLabel">Tambah Bank Soal</h1>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<form action="./db/dbproses.php?pr=" method="post">
				<div class="modal-body">
					<div class="row g-1">
						<div class="input-group input-group-sm">
							<label class="input-group-text col-3" id="nmkls">Nama Kelas</label>
							<select class="form-select" id="nmkls" name="nmkls">
								<option value="1">Semua</option>
								<?php
								$kls	= mysqli_query($koneksi, "SELECT * FROM kelas GROUP BY kls");
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
								$kls	= mysqli_query($koneksi, "SELECT * FROM kelas GROUP BY jur");
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
							<!-- <label class="input-group-text col-3" id="kkm">KKM</label> -->
							<input type="number" min="10" max="100" class="form-control" id="jsoal" name="jsoal" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" placeholder="Jumlah Soal Digunakan" onkeypress="return angka (event)" onchange="batas(this)" value="" required>
							<input type="number" min="10" max="100" class="form-control" id="kkm" name="kkm" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" placeholder="Kereteria Ketuntasan Minimun" onkeypress="return angka (event)" onchange="batas(this)" value="" required>
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
					<h1 class="modal-title fs-5" id="EditLabel">Edit Bank Soal </h1>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<form action="./db/dbproses.php?pr=" method="post">
					<div class="modal-body">
						<div class="row g-1">
							<div class="input-group input-group-sm">
								<label class="input-group-text col-3" id="nmkls">Nama Kelas</label>
								<select class="form-select" id="nmkls" name="nmkls">
									<option value="1">Semua</option>
									<?php
									$kls	= mysqli_query($koneksi, "SELECT * FROM kelas GROUP BY kls");
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
									$kls	= mysqli_query($koneksi, "SELECT * FROM kelas GROUP BY jur");
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
								<!-- <label class="input-group-text col-3" id="kkm">KKM</label> -->
								<input type="number" min="10" max="100" class="form-control" id="jsoal" name="jsoal" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" placeholder="Jumlah Soal Digunakan" onkeypress="return angka (event)" onchange="batas(this)" value="" required>
								<input type="number" min="10" max="100" class="form-control" id="kkm" name="kkm" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" placeholder="Kereteria Ketuntasan Minimun" onkeypress="return angka (event)" onchange="batas(this)" value="" required>
							</div>
						</div>
					</div>
						<div class="modal-footer">
							<button type="submit" class="btn btn-primary" id="Edit" name="Edit">Simpan</button>
							<button type="submit" class="btn btn-success
							" id="copy" name="copy">Copy Bank Soal</button>
							<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
						</div>
				</form>
			</div>
		</div>
	</div>
<?php } ?>

<!--===Akhir Modal===-->

<script>

</script>


<!-- 
	INSERT INTO `cbt_pktsoal` (`id_pktsoal`, `kd_kls`, `kls`, `jur`, `kd_mpel`, `kd_soal`, `sesi`, `pilgan`, `prsen_pilgan`, `esai`, `prsen_esai`, `jum_soal`, `tgl`, `author`, `sts`) VALUES (NULL, '3', '3', '3', '3', '3', '3', '3', '3', '3', '3', '3', current_timestamp(), '3', 'N');
 -->