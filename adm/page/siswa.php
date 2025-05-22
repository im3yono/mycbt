<?php
error_reporting(0); //hide error
include_once("../../config/server.php");

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
					mysqli_query($koneksi, "DELETE FROM cbt_peserta");
				} else {
					mysqli_query($koneksi, "DELETE FROM cbt_peserta WHERE cbt_peserta.id_peserta = '$dths'");
				}
				?>
				location.replace("?md=sis");
			}
		})
	</script>
<?php
}
?>

<style>
	#adm {
		display: flow-root;
	}

	.sis {
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
</style>
<?php
$ck_kls = mysqli_query($koneksi, "SELECT * FROM kelas");
if (!empty(mysqli_num_rows($ck_kls))) {

?>
	<div id="tampil">
		<div class="container-fluid mb-5 p-0">
			<div class="row p-2 border-bottom fs-3 mb-4 shadow-sm ">Daftar Peserta Ujian</div>
			<div class="row mb-3 mx-2 justify-content-center">
				<div class="col row">
					<div class="col-auto"><button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#tambah"><i class="bi bi-person-plus"></i> Tambah Peserta</button></div>
					<div class="col-auto"><a href="?md=up_peserta" class="btn btn-warning"><i class="bi bi-upload"></i> Upload Data Peserta</a></div>
					<!-- <div class="col-auto"><a href="#" class="btn btn-danger"><i class="bi bi-trash3"></i> Kosongkan Data</a></div> -->

				</div>
				<div class="col row justify-content-end">
					<div class="col-auto">
						<!-- <form action="" method="post">
						<div class="input-group">
							<input type="search" class="form-control" placeholder="Cari Nama" name="crnm" id="crnm">
							<button type="submit" class="btn btn-primary" name="cr" id="cr"><i class="bi bi-search"></i></button>
						</div></form> -->
					</div>
				</div>
			</div>
			<div class="col table-responsive">
				<table class="table table-hover table-striped table-bordered border" id="jsdata">
					<thead class="table-info text-center align-baseline">
						<tr>
							<th style="min-width: 5%;">No.</th>
							<th style="min-width: 150px;">No Peserta | NIS | NISN | NIK</th>
							<th style="min-width: 150px;">Nama Peserta | Username</th>
							<th style="min-width: 150px;">Kelas | Jurusan | Ruangan</th>
							<th style="min-width: 10%;">Status</th>
							<th style="min-width: 100px;">Edit | hapus</th>
						</tr>
					</thead>
					<tbody>
						<?php
						// SELECT * FROM cbt_peserta WHERE nm LIKE '%tr%'
						// if (isset($_POST['cr'])) {
						// 	$selectSQL = "SELECT * FROM cbt_peserta WHERE nm LIKE '%$_POST[crnm]%'";
						// }else{
						// 	$selectSQL = "SELECT * FROM cbt_peserta";}

						$batas = 10;
						$hal   = isset($_GET['pg']) ? (int)$_GET['pg'] : 1;
						$hal_awal = ($hal > 1) ? ($hal * $batas) - $batas : 0;

						$previous = $hal - 1;
						$next     = $hal + 1;

						$no = 1;
						$selectSQL = "SELECT * FROM cbt_peserta ORDER BY kd_kls,nm ASC";
						$data = mysqli_query($koneksi, $selectSQL);
						$jml_data = mysqli_num_rows($data);
						$tot_hal = ceil($jml_data / $batas);

						$dtkls  = mysqli_query($koneksi, "SELECT * FROM cbt_peserta ORDER BY kd_kls,nm ASC");
						while ($dt = mysqli_fetch_array($dtkls)) {
							$kls_sis = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM kelas WHERE kd_kls ='$dt[kd_kls]';"));
						?>
							<tr class="text-center">
								<th><?php echo $no++ ?> <img src="../pic_sis/<?php if ($dt['ft'] == 'noavatar.png') {
																																		echo "../img/" . "noavatar.png";
																																	} else {
																																		echo "../pic_sis/" . $dt['ft'];
																																	} ?>" alt="" srcset="" class="rounded" style="height: 70px; width: 50px;"></th>
								<td class="fw-semibold"><?php echo $dt['nis'] ?></td>
								<td class="fw-semibold"><?php echo $dt['nm'] . ' | ' . $dt['user'] ?></td>
								<td class="fw-semibold"><?php echo $kls_sis['nm_kls'] . ' | ' . $kls_sis['jur'] . ' | ' . $dt['ruang'] ?></td>
								<td>
									<form action="" method="post">
										<?php

										if ($dt['sts'] == "Y") {
											echo "<a href='./db/dbproses.php?pr=adm_sissts&dt=" . $dt['id_peserta'] . "' class='btn btn-sm btn-primary'>Aktif</a>";
										} else {
											echo "<a href='./db/dbproses.php?pr=adm_sissts&dt=" . $dt['id_peserta'] . "' class='btn btn-sm btn-danger'>Nonaktif</a>";
										}

										?></form>
								</td>
								<td>
									<button class="btn btn-sm fs-6 btn-warning" type="button" data-bs-toggle="modal" data-bs-target="#Edit<?php echo $dt[0]; ?>"><i class="bi bi-pencil-square"></i></button> |
									<a href="?md=sis&pesan=hapus&us=<?php echo $dt[0]; ?>" class="btn btn-sm fs-6 btn-danger alert_notif"><i class="bi bi-trash3"></i></a>
								</td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
			<!-- <?php if ($jml_data > $batas) { ?>
				<nav aria-label="Page navigation example">
					<ul class="pagination pagination-sm justify-content-md-end  justify-content-center pe-3">
						<li class="page-item">
							<a class="page-link <?php if ($hal == 1) {
																		echo 'disabled';
																	} ?>" <?php if ($hal > 1) {
																					echo "href='?md=sis&pg=$previous'";
																				} ?>><i class="bi bi-chevron-left"></i></a>
						</li>
						<?php
						for ($i = 1; $i <= $tot_hal; $i++) { ?>
							<li class="page-item 
        <?php if ($hal == $i) {
								echo 'active';
							} ?>"><a class="page-link" href="?md=sis&pg=<?php echo $i ?>"><?php echo $i; ?></a></li>
						<?php
						}
						?>
						<li class="page-item">
							<a class="page-link 
        <?php if ($hal == $tot_hal) {
					echo 'disabled';
				} ?>" <?php if ($hal < $tot_hal) {
								echo "href='?md=sis&pg=$next'";
							} ?>><i class="bi bi-chevron-right"></i></a>
						</li>
					</ul>
				</nav>
			<?php } ?> -->
		</div>
	</div>
<?php } else { ?>
	<div class="container-fluid">
		<div class="row m-5">
			<div class="col-12 text-center">
				<h4>Halaman Ini akan tampil apabila data <u>Kelas</u> sudah terisi</h4>
			</div>
		</div>
	</div>
<?php } ?>
<!-- === Modal === -->
<!-- === Edit === -->
<?php
$mdedit	=	mysqli_query($koneksi, "SELECT * FROM cbt_peserta ORDER BY id_peserta ASC");

while ($mddt = mysqli_fetch_array($mdedit)) {
?>
	<div class="modal fade" id="Edit<?php echo $mddt[0]; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="EditLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h1 class="modal-title fs-5" id="EditLabel">Edit Data "<?php echo $mddt['nm']; ?>"</h1>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<form action="./db/dbproses.php?pr=adm_sisedt" method="post" enctype="multipart/form-data">
					<div class="modal-body">
						<div class="row g-1">
							<div class="input-group input-group-sm">
								<label class="input-group-text col-4" id="sv">IP/Hostname Server</label>
								<input type="text" class="form-control" id="sv" name="sv" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" value="<?php echo $mddt['ip_sv']; ?>" placeholder=" 192.168.1.1 or www.localhost.com">
							</div>
							<div class="input-group input-group-sm">
								<label class="input-group-text col-4" id="nis">NIS/No Peserta</label>
								<input type="text" class="form-control" id="nis" name="nis" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" value="<?php echo $mddt['nis']; ?>" placeholder="NIS atau No Peserta">
							</div>
							<div class="input-group input-group-sm">
								<label class="input-group-text col-4" id="nm">Nama Peserta</label>
								<input type="text" class="form-control" id="nm" name="nm" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" value="<?php echo $mddt['nm']; ?>" placeholder="Nama Peserta">
							</div>
							<div class="input-group input-group-sm">
								<label class="input-group-text col-4">Tempat, Tanggal Lahir</label>
								<input type="text" class="form-control" id="tmp" name="tmp" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" value="<?php echo $mddt['tmp_lahir']; ?>" placeholder="Tempat lahir">
								<input type="date" class="form-control" id="tgl" name="tgl" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" value="<?php echo date('Y-m-d', strtotime($mddt['tgl_lahir'])); ?>">
							</div>
							<div class="input-group input-group-sm">
								<label class="input-group-text col-4" id="kel">Jenis Kelamin</label>
								<!-- <input type="text" class="form-control" id="jur" name="jur" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" value=""> -->
								<select class="form-select" name="kel" id="kel">
									<option value="L" <?php if ($mddt['jns_kel'] == "L") {
																			echo "selected";
																		} ?>>Laki - Laki</option>
									<option value="P" <?php if ($mddt['jns_kel'] == "P") {
																			echo "selected";
																		} ?>>Perempuan</option>
								</select>
							</div>
							<div class="input-group input-group-sm">
								<label class="input-group-text col-4" id="kls">Nama Kelas</label>
								<select class="form-select" id="kls" name="kls">
									<option value="1">Semua</option>
									<?php
									$kls	= mysqli_query($koneksi, "SELECT * FROM kelas");	//  GROUP BY nm_kls
									while ($dtkl = mysqli_fetch_array($kls)) {
										echo "
											<option value='$dtkl[kd_kls]'";
										if ($mddt['kd_kls'] == $dtkl['kd_kls']) {
											echo "selected";
										}
										echo ">$dtkl[nm_kls]</option>
											";
									}
									?>
								</select>
								<!-- <select class="form-select" id="kls" name="kls">
									<option value="1">Semua</option>
									<?php
									$kls	= mysqli_query($koneksi, "SELECT * FROM kelas GROUP BY jur");
									while ($dtkl = mysqli_fetch_array($kls)) {
										echo "
											<option value='$dtkl[jur]'>$dtkl[jur]</option>
											";
									}
									?>
								</select> -->
							</div>
							<!-- <div class="input-group input-group-sm">
								<label class="input-group-text col-4" id="min">Username</label>
								<input type="text" class="form-control" id="min" name="min" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" value="">
							</div> -->
							<div class="input-group input-group-sm">
								<label class="input-group-text col-4" id="usr">Username</label>
								<input type="text" class="form-control" id="usr" name="usr" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" value="<?php echo $mddt['user']; ?>" placeholder="Username" readonly>
							</div>
							<div class="input-group input-group-sm">
								<label class="input-group-text col-4" id="pas">Password</label>
								<input type="text" class="form-control" id="pas" name="pas" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" value="<?php echo $mddt['pass']; ?>" placeholder="Password">
							</div>
							<div class="input-group input-group-sm">
								<label class="input-group-text col-4" id="ses">Sesi dan Ruangan</label>
								<input type="text" class="form-control" id="ses" name="ses" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" value="<?php echo $mddt['sesi']; ?>" placeholder="Sesi">
								<input type="text" class="form-control" id="ru" name="ru" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" value="<?php echo $mddt['ruang']; ?>" placeholder="Ruang">
							</div>
							<div class="input-group input-group-sm">
								<label class="input-group-text col-4" id="ft">Foto</label>
								<input type="file" class="form-control" id="ft" name="ft" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" value="">
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-primary">Simpan</button>
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
				<h1 class="modal-title fs-5" id="tambahLabel">Tambah User</h1>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<form action="./db/dbproses.php?pr=adm_sisadd" method="post" class="form-sis" enctype="multipart/form-data">
				<div class="modal-body">
					<div class="row g-1">
						<div class="input-group input-group-sm">
							<label class="input-group-text col-4" id="sv">IP/Hostname Server</label>
							<input type="text" class="form-control" id="sv" name="sv" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" value="" placeholder=" 192.168.1.1 or www.localhost.com">
						</div>
						<div class="input-group input-group-sm">
							<label class="input-group-text col-4" id="nis">NIS/No Peserta</label>
							<input type="text" class="form-control" id="nis" name="nis" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" value="" placeholder="NIS atau No Peserta">
						</div>
						<div class="input-group input-group-sm">
							<label class="input-group-text col-4" id="nm">Nama Peserta</label>
							<input type="text" class="form-control" id="nm" name="nm" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" value="" placeholder="Nama Peserta">
						</div>
						<div class="input-group input-group-sm">
							<label class="input-group-text col-4">Tempat, Tanggal Lahir</label>
							<input type="text" class="form-control" id="tmp" name="tmp" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" value="" placeholder="Tempat lahir">
							<input type="date" class="form-control" id="tgl" name="tgl" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" value="<?php echo date('Y-m-d'); ?>">
						</div>
						<div class="input-group input-group-sm">
							<label class="input-group-text col-4" id="kel">Jenis Kelamin</label>
							<!-- <input type="text" class="form-control" id="jur" name="jur" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" value=""> -->
							<select class="form-select" name="kel" id="kel">
								<option value="L">Laki - Laki</option>
								<option value="P">Perempuan</option>
							</select>
						</div>
						<div class="input-group input-group-sm">
							<label class="input-group-text col-4" id="kls">Nama Kelas</label>
							<select class="form-select" id="kls" name="kls">
								<!-- <option value="1">Semua</option> -->
								<?php
								$kls	= mysqli_query($koneksi, "SELECT * FROM kelas");	//  GROUP BY nm_kls
								while ($dtkl = mysqli_fetch_array($kls)) {
									echo "
											<option value='$dtkl[kd_kls]'>$dtkl[nm_kls]</option>
											";
								}
								?>
							</select>
							<!-- <select class="form-select" id="kls" name="kls">
									<option value="1">Semua</option>
									<?php
									$kls	= mysqli_query($koneksi, "SELECT * FROM kelas GROUP BY jur");
									while ($dtkl = mysqli_fetch_array($kls)) {
										echo "
											<option value='$dtkl[jur]'>$dtkl[jur]</option>
											";
									}
									?>
								</select> -->
						</div>
						<!-- <div class="input-group input-group-sm">
								<label class="input-group-text col-4" id="min">Username</label>
								<input type="text" class="form-control" id="min" name="min" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" value="">
							</div> -->
						<div class="input-group input-group-sm">
							<label class="input-group-text col-4" id="usr">Username</label>
							<input type="text" class="form-control" id="usr" name="usr" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" value="" placeholder="Username">
						</div>
						<div class="input-group input-group-sm">
							<label class="input-group-text col-4" id="pas">Password</label>
							<input type="password" class="form-control" id="pas" name="pas" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" value="" placeholder="Password">
						</div>
						<div class="input-group input-group-sm">
							<label class="input-group-text col-4" id="ses">Sesi dan Ruangan</label>
							<input type="text" class="form-control" id="ses" name="ses" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" value="" placeholder="Sesi">
							<input type="text" class="form-control" id="ru" name="ru" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" value="" placeholder="Ruang">
						</div>
						<div class="input-group input-group-sm">
							<label class="input-group-text col-4" id="ft">Foto</label>
							<input type="file" class="form-control" id="ft" name="ft" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
					<button type="submit" class="btn btn-primary">Tambah</button>
					<!-- <button type="button" class="btn btn-primary" id="add" name="add">Tambah</button> -->
				</div>
			</form>
		</div>
	</div>
</div>
<!-- === Akhir Modal === -->

<script>
	// Simpan
	// $(document).ready(function() {
	// 	$("#add").click(function() {
	// 		// const fileupload = $('#ft').prop('files')[0];
	// 		var data = $('.form-sis').serialize();
	// 		$.ajax({
	// 			type: 'POST',
	// 			url: "db/dbproses.php?pr=adm_sisadd",
	// 			data: data,
	// 			success: function() {
	// 				$('#tampil').load("page/md.php/?md=sis")
	// 			}
	// 		});
	// 	});
	// });

	// Hapus
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
<script>
		document.addEventListener("DOMContentLoaded", function() {
			// Inisialisasi Simple-DataTables pada tabel
			var dataTable = new simpleDatatables.DataTable("#jsdata", {
				perPageSelect: [5, 10, 25, 50, 100],
				perPage: 10,
				labels: {
					placeholder: "Cari...",
					perPage: " Data per halaman",
					noRows: "Tidak ada data yang ditemukan",
					info: "Menampilkan {start}/{end} dari {rows} Data",
				}
			});
		});
	</script>