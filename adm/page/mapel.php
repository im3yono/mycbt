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
					mysqli_query($koneksi, "DELETE FROM mapel");
				} else {
					mysqli_query($koneksi, "DELETE FROM mapel WHERE mapel.kd_mpel = '$dths'");
				}
				?>
				location.replace("?md=mpl");
			}
		})
	</script>
<?php
}
?>

<style>
	#adm {
		display: flex;
	}

	.mapel {
		background-color: aqua;
	}
</style>

<div class="container-fluid mb-5 p-0">
	<div class="row p-2 border-bottom fs-3 mb-4 shadow-sm ">Daftar Mata Pelajaran</div>
	<div class="row mb-3 mx-2">
		<div class="col-auto"><button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#tambah"><i class="bi bi-person-plus"></i> Tambah Mata Pelajaran</button></div>
	</div>
	<div class="col table-responsive">
		<table class="table table-hover table-striped table-bordered">
			<thead class="table-info text-center align-baseline">
				<tr>
					<th style="width: 2%;">No.</th>
					<th style="width: 10%;">Kode Mata Pelajaran</th>
					<th style="width: 30%;">Nama Mata Pelajaran</th>
					<!-- <th style="width: 15%;">Kelas | Jurusan | Minat</th> -->
					<!-- <th style="width: 10%;">KKM</th> -->
					<th style="width: 5%;">Edit | hapus</th>
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
				$selectSQL = "SELECT * FROM mapel";
				$data = mysqli_query($koneksi, $selectSQL);
				$jml_data = mysqli_num_rows($data);
				$tot_hal = ceil($jml_data / $batas);

				$dtmpl  = mysqli_query($koneksi, "SELECT * FROM mapel ORDER BY id_mpel ASC limit $hal_awal,$batas");
				while ($dt = mysqli_fetch_array($dtmpl)) {
					// $dtt = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM kelas WHERE kd_kls ='$dt[kd_kls]';"));
				?>
					<tr class="text-center">
						<th><?php echo $no++ ?></th>
						<th><?php echo $dt['kd_mpel'] ?></th>
						<td class="fw-semibold text-start"><?php echo $dt['nm_mpel'] ?></td>
						<!-- <td class="fw-semibold"><?php if($dt['kls']!="1"){echo $dt['kls'];}else{echo "Semua";}if(!empty($dt['jur'])){echo  " | ";if($dt['jur']!="1"){echo $dt['jur'];}else{echo "Semua";} } if(!empty($dt['kls_minat'])){echo  " | " .$dt['kls_minat']; } ?></td> -->
						<!-- <td class="fw-semibold"><?php echo $dt['kkm'] ?></td> -->
						<!-- <td>
							<form action="" method="post">
								<?php

								if ($dt['sts'] == "Y") {
									echo "<a href='./db/dbproses.php?pr=adm_sts&dt=" . $dt['kd_kls'] . "' class='btn btn-sm btn-primary'>Aktif</a>";
								} else {
									echo "<a href='./db/dbproses.php?pr=adm_sts&dt=" . $dt['kd_kls'] . "' class='btn btn-sm btn-danger'>Nonaktif</a>";
								}

								?></form>
						</td> -->
						<td>
							<button class="btn btn-sm fs-6 btn-warning" type="button" data-bs-toggle="modal" data-bs-target="#Edit<?php echo $dt[0]; ?>"><i class="bi bi-pencil-square"></i></button>
							<?php
							echo " | 
							<a href='?md=mpl&pesan=hapus&us=$dt[kd_mpel] ' class='btn btn-sm fs-6 btn-danger alert_notif'><i class='bi bi-trash3'></i></a>";
							?>
						</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
		<?php if ($jml_data >= $batas) { ?>
			<nav aria-label="Page navigation example">
				<ul class="pagination pagination-sm justify-content-end pe-3">
					<li class="page-item">
						<a class="page-link 
						<?php if ($hal == 1) {
							echo 'disabled';
						} ?>" <?php
									if ($hal > 1) {
										echo "href='?md=mpl&pg=$previous'";
									} ?>><i class="bi bi-chevron-left"></i></a>
					</li>
					<?php
					for ($i = 1; $i <= $tot_hal; $i++) { ?>
						<li class="page-item 
        <?php if ($hal == $i) {
							echo 'active';
						} ?>"><a class="page-link" href="?md=mpl&pg=<?php echo $i ?>"><?php echo $i; ?></a></li>
					<?php
					}
					?>
					<li class="page-item">
						<a class="page-link 
        <?php if ($hal == $tot_hal) {
					echo 'disabled';
				} ?>" <?php if ($hal < $tot_hal) {
								echo "href='?md=mpl&pg=$next'";
							} ?>><i class="bi bi-chevron-right"></i></a>
					</li>
				</ul>
			</nav>
		<?php }
		// else{echo "<div class='col-12 text-center'>data kosong</div>";} 
		?>
	</div>
</div>

<!-- === Modal === -->
<!-- === Edit === -->
<?php
$mdedit	=	mysqli_query($koneksi, "SELECT * FROM mapel ORDER BY id_mpel ASC");

while ($mddt = mysqli_fetch_array($mdedit)) {
?>
	<div class="modal fade" id="Edit<?php echo $mddt[0]; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="EditLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h1 class="modal-title fs-5" id="EditLabel">Edit Data Kelas | <?php echo $mddt['nm_mpel']; ?></h1>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<form action="./db/dbproses.php?pr=adm_mpedt" method="post">
					<div class="modal-body">
						<div class="row g-2">
								<!-- <div class="input-group input-group-sm">
									<label class="input-group-text col-3" id="kd_kls">Kelas</label>
									<select class="form-select" id="kd_kls" name="kd_kls">
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
									<label class="input-group-text col-3" id="minat">Minat</label>
									<select class="form-select" id="minat" name="minat">
										<?php
										$kls	= mysqli_query($koneksi, "SELECT * FROM kelas GROUP BY kls_minat");
										while ($dtkl = mysqli_fetch_array($kls)) {
											echo "
										<option value='$dtkl[kls_minat]'";
											if ($mddt['kls_minat'] == $dtkl['kls_minat']) {
												echo "selected";
											}
											echo ">$dtkl[kls_minat]</option>
										";
										}
										?>
									</select>
								</div> -->
								<div class="input-group input-group-sm">
									<label class="input-group-text col-3" id="kd_mpel">Kode Mapel</label>
									<input type="text" class="form-control" id="kd_mpel" name="kd_mpel" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" value="<?php echo $mddt['kd_mpel']; ?>">
									<input type="text" class="form-control" id="id_mpel" name="id_mpel" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" value="<?php echo $mddt['id_mpel']; ?>" hidden>
								</div>
								<div class="input-group input-group-sm">
									<label class="input-group-text col-3" id="nm_mpel">Nama Mapel</label>
									<input type="text" class="form-control" id="nm_mpel" name="nm_mpel" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" value="<?php echo $mddt['nm_mpel']; ?>">
								</div>
								<!-- <div class="input-group input-group-sm">
									<label class="input-group-text col-3" id="kkm">KKM</label>
									<input type="number" min="10" max="100" onkeypress="return angka (event)" onchange="batas(this)" class="form-control" id="kkm" name="kkm" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" value="<?php echo $mddt['kkm']; ?>">
								</div> -->
							</div>
						</div>
						<div class="modal-footer">
							<button type="submit" class="btn btn-primary" id="Edit" name="Edit">Simpan</button>
							<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
						</div>
				</form>
			</div>
		</div>
	</div>
<?php } ?>

<!-- === Tambah === -->
<div class="modal fade" id="tambah" tabindex="-1" aria-labelledby="tambahLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h1 class="modal-title fs-5" id="tambahLabel">Tambah Mata Pelajaran</h1>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<form action="./db/dbproses.php?pr=adm_mpadd" method="post">
				<div class="modal-body">
					<div class="row g-1">
						<!-- <div class="input-group input-group-sm">
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
							<label class="input-group-text col-3" id="minat">Minat</label>
							<select class="form-select" id="minat" name="minat">
								<?php
								$kls	= mysqli_query($koneksi, "SELECT * FROM kelas GROUP BY kls_minat");
								while ($dtkl = mysqli_fetch_array($kls)) {
									echo "
										<option value='$dtkl[kls_minat]'>$dtkl[kls_minat]</option>
										";
								}
								?>
							</select>
						</div> -->
						<div class="input-group input-group-sm">
							<label class="input-group-text col-3" id="kd_mpel">Kode Mapel</label>
							<input type="text" class="form-control" id="kd_mpel" name="kd_mpel" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" placeholder="Kode Tidak Boleh Sama" value="">
						</div>
						<div class="input-group input-group-sm">
							<label class="input-group-text col-3" id="nm_mpel">Nama Mapel</label>
							<input type="text" class="form-control" id="nm_mpel" name="nm_mpel" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" placeholder="Nama Mata Pelajaran" value="">
						</div>
						<!-- <div class="input-group input-group-sm">
							<label class="input-group-text col-3" id="kkm">KKM</label>
							<input type="number" min="10" max="100" class="form-control" id="kkm" name="kkm" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" placeholder="Kereteria Ketuntasan Minimun" onkeypress="return angka (event)" onchange="batas(this)" value="" required>
						</div> -->
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