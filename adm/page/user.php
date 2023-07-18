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
				mysqli_query($koneksi, "DELETE FROM user WHERE user.username = '$dths'");
				?>
				location.replace("?md=usr");
			}
		})
	</script>
<?php
}
?>

<style>
	#pf {
		display: flex;
	}

	.usr {
		background-color: aqua;
		/* min-width: 189px; */
	}
</style>

<div class="container-fluid mb-5 p-0">
	<div class="row p-2 border-bottom fs-3 mb-4 shadow-sm ">Managemen User</div>
	<div class="row mb-3 mx-2">
		<div class="col-auto"><button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#tambah"><i class="bi bi-person-plus"></i> Tambah User</button></div>
	</div>
	<div class="col table-responsive">
		<table class="table table-hover table-striped table-bordered">
			<thead class="table-info text-center">
				<tr>
					<th style="min-width: 5%;">No.</th>
					<th style="min-width: 15%;">Nama</th>
					<th style="min-width: 15%;">Username</th>
					<th style="min-width: 20%;">No Telepon</th>
					<th style="min-width: 10%;">Level</th>
					<th style="min-width: 10%;">Status</th>
					<th style="min-width: 100px;">Edit | hapus</th>
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
				$selectSQL = "SELECT * FROM user";
				$data = mysqli_query($koneksi, $selectSQL);
				$jml_data = mysqli_num_rows($data);
				$tot_hal = ceil($jml_data / $batas);

				$dtusr  = mysqli_query($koneksi, "SELECT * FROM user ORDER BY id_usr ASC limit $hal_awal,$batas");
				while ($dt = mysqli_fetch_array($dtusr)) {
				?>
					<tr class="text-center">
						<th><?php echo $no++ ?></th>
						<td class="fw-semibold"><?php echo $dt[2] ?></td>
						<td class="fw-semibold"><?php echo $dt[3] ?></td>
						<td class="fw-semibold"><?php echo $dt[5] ?></td>
						<td class="fw-semibold">
							<?php if ($dt['lvl'] == "A") {
								echo "Admin";
							} elseif ($dt['lvl'] == "U") {
								echo "User";
							} else {
								echo "Pengawas";
							} ?></td>
						<td>
							<form action="" method="post">
								<?php
								if ($dt['id_usr'] == "1") {
									echo "<div class='badge fs-6 p-2 bg-info'>Aktif</div>";
								} else {
									if ($dt[7] == "Y") {
										echo "<a href='./db/dbproses.php?pr=us_sts&dt=" . $dt['username'] . "' class='btn btn-sm btn-primary'>Aktif</a>";
									} else {
										echo "<a href='./db/dbproses.php?pr=us_sts&dt=" . $dt['username'] . "' class='btn btn-sm btn-danger'>Nonaktif</a>";
									}
								}

								?></form>
						</td>
						<td>
							<button class="btn btn-sm fs-6 btn-warning" type="button" data-bs-toggle="modal" data-bs-target="#Edit<?php echo $dt[0]; ?>"><i class="bi bi-pencil-square"></i></button>
							<?php if ($dt['nm_user'] != "Administator") {
								echo "|";
							} ?>
							<a href="?md=usr&pesan=hapus&us=<?php echo $dt['username'] ?>" class="btn btn-sm fs-6 btn-danger alert_notif" <?php if ($dt['id_usr'] == "1") {
																																																															echo "hidden";
																																																														} ?>><i class="bi bi-trash3"></i></a>
						</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
		<nav aria-label="Page navigation example">
			<ul class="pagination pagination-sm justify-content-end pe-3">
				<li class="page-item">
					<a class="page-link 
        <?php if ($hal == 1) {
					echo 'disabled';
				} ?>" <?php if ($hal > 1) {
								echo "href='?md=usr&pg=$previous'";
							} ?>><i class="bi bi-chevron-left"></i></a>
				</li>
				<?php
				for ($i = 1; $i <= $tot_hal; $i++) { ?>
					<li class="page-item 
        <?php if ($hal == $i) {
						echo 'active';
					} ?>"><a class="page-link" href="?md=usr&pg=<?php echo $i ?>"><?php echo $i; ?></a></li>
				<?php
				}
				?>
				<li class="page-item">
					<a class="page-link 
        <?php if ($hal == $tot_hal) {
					echo 'disabled';
				} ?>" <?php if ($hal < $tot_hal) {
								echo "href='?md=usr&pg=$next'";
							} ?>><i class="bi bi-chevron-right"></i></a>
				</li>
			</ul>
		</nav>
	</div>
	<div class="col-auto px-3 alert-success alert">
		<h4>Catatan :</h4>
		<p>User Admin tidak dapat dihapus</p>
	</div>
</div>


<!-- === Modal === -->
<!-- === Tambah === -->
<!-- === Edit === -->
<!-- Button trigger modal -->
<!-- Modal -->
<?php
$mdedit	=	mysqli_query($koneksi, "SELECT * FROM user ORDER BY id_usr ASC");

while ($mddt = mysqli_fetch_array($mdedit)) {
?>
	<div class="modal fade" id="Edit<?php echo $mddt[0]; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="EditLabel<?php echo $mddt[0] ?>" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h1 class="modal-title fs-5" id="EditLabel<?php echo $mddt[0] ?>">Rubah Data User</h1>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<form action="./db/dbproses.php?pr=us_ed" method="post">
					<div class="modal-body">
						<!-- <div class="input-group input-group-sm mb-3">
							<span class="input-group-text" id="kd">Kode</span>
							<input type="text" class="form-control" id="kd" name="kd" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" value="<?php echo $mddt['kd_usr'] ?>" readonly>
						</div> -->
						<div class="input-group input-group-sm mb-3" <?php if ($mddt['id_usr'] == "1") {
																														echo "hidden";
																													} ?>>
							<label class="input-group-text" for="lvl">Level User</label>
							<select class="form-select" id="lvl" name="lvl">
								<!-- <option selected disabled>Pilih Level</option> -->
								<option value="A" <?php if ($mddt['lvl'] == "A") {
																		echo "selected";
																	} ?>>Admin</option>
								<option value="U" <?php if ($mddt['lvl'] == "U") {
																		echo "selected";
																	} ?>>User</option>
								<option value="X" <?php if ($mddt['lvl'] == "X") {
																		echo "selected";
																	} ?>>Pengawas</option>
							</select>
						</div>
						<div class="input-group input-group-sm mb-3">
							<span class="input-group-text" id="nm">Nama</span>
							<input type="text" class="form-control" id="nm" name="nm" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" value="<?php echo $mddt[2] ?>" <?php if ($mddt['id_usr'] == "1") {
																																																																																										echo "readonly";
																																																																																									} ?>>
						</div>
						<div class="input-group input-group-sm mb-3">
							<span class="input-group-text" id="usr">Username</span>
							<input type="text" class="form-control" id="usr" name="usr" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" value="<?php echo $mddt[3] ?>">
							<input type="text" class="form-control" id="usrlm" name="usrlm" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" value="<?php echo $mddt[3] ?>" hidden>
						</div>
						<div class="input-group input-group-sm mb-3">
							<span class="input-group-text" id="pass">Password</span>
							<input type="password" class="form-control" id="pass" name="pass" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" placeholder="Masukkan Untuk Merubah Password">
						</div>
						<div class="input-group input-group-sm mb-3">
							<span class="input-group-text" id="notlp">No. Telepon</span>
							<input type="text" class="form-control" id="notlp" name="notlp" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" value="<?php echo $mddt[5] ?>">
						</div>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-primary" id="Edit<?php echo $mddt[0] ?>" name="Edit<?php echo $mddt[0] ?>">Simpan</button>
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
					</div>
				</form>
			</div>
		</div>
	</div>
<?php } ?>
<!-- === Modal Tambah === -->
<div class="modal fade" id="tambah" tabindex="-1" aria-labelledby="tambahLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h1 class="modal-title fs-5" id="tambahLabel">Tambah User</h1>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<form action="./db/dbproses.php?pr=us_add" method="post" enctype="multipart/form-data">
				<div class="modal-body">
					<div class="input-group input-group-sm mb-3">
						<label class="input-group-text" for="lvl">Level User</label>
						<select class="form-select" id="lvl" name="lvl">
							<!-- <option selected disabled>Pilih Level</option> -->
							<option value="A">Admin</option>
							<option value="U">User</option>
							<option value="X">Pengawas</option>
						</select>
					</div>
					<!-- <?php
								$kdlvl = $_GET['lvl'];
								$sqlckkd	= mysqli_fetch_array(mysqli_query($koneksi, "SELECT MAX(kd_usr) AS kodeTerbesar FROM user WHERE lvl = '$kdlvl';"));
								$kd = $sqlckkd['kodeTerbesar'];
								$urutan = (int) substr($kd, 3, 3);
								$urutan++;
								$huruf = $kdlvl;
								$kd = $huruf . sprintf("%02s", $urutan);
								?>
					<div class="input-group input-group-sm mb-3">
						<span class="input-group-text" id="kd">Kode</span>
						<input type="text" class="form-control" id="kd" name="kd" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" value="<?php echo $kd; ?>">
					</div> -->

					<div class="input-group input-group-sm mb-3">
						<span class="input-group-text" id="nm">Nama</span>
						<input type="text" class="form-control" id="nm" name="nm" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
					</div>
					<div class="input-group input-group-sm mb-3">
						<span class="input-group-text" id="usr">Username</span>
						<input type="text" class="form-control" id="usr" name="usr" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" required>
					</div>
					<div class="input-group input-group-sm mb-3">
						<span class="input-group-text" id="pass">Password</span>
						<input type="password" class="form-control" id="pass" name="pass" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" required>
					</div>
					<div class="input-group input-group-sm mb-3">
						<span class="input-group-text" id="notlp">No. Telepon</span>
						<input type="text" class="form-control" id="notlp" name="notlp" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
					<!-- <a href="./db/dbproses.php?pr=add" type="button" class="btn btn-primary" id="tambah" name="tambah">Tambah</a> -->
					<button type="submit" class="btn btn-primary" id="tambah" name="tambah">Tambah</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- === Akhir Modal Tambah === -->


<!-- === JavaScript === -->
<script>
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