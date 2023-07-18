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
					mysqli_query($koneksi, "DELETE FROM kelas");
				} else {
					mysqli_query($koneksi, "DELETE FROM kelas WHERE kelas.kd_kls = '$dths'");
				}
				?>
				location.replace("?md=kls");
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

	.kls {
		background-color: aqua;
	}
</style>

<div class="container-fluid mb-5 p-0">
	<div class="row p-2 border-bottom fs-3 mb-4 shadow-sm ">Daftar Kelas</div>
	<div class="row mb-3 mx-2">
		<div class="col-auto"><button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#tambah"><i class="bi bi-person-plus"></i> Tambah Kelas</button></div>
		<div class="col-auto">
			<?php
			$kls	= mysqli_fetch_array(mysqli_query($koneksi, "SELECT COUNT(*) AS jml_p FROM cbt_peserta;"));
			$pkts	= mysqli_fetch_array(mysqli_query($koneksi, "SELECT COUNT(*) AS jml_ps FROM cbt_pktsoal"));
			if ($kls['jml_p'] + $pkts['jml_ps'] == 0) {
				echo "<a href='?md=kls&pesan=hapus&us=all' class='btn btn-warning alert_notif'><i class='bi bi-trash3'></i> Kosongkan Kelas</a>";
			}
			?>
		</div>
	</div>
	<div class="col table-responsive">
		<table class="table table-hover table-striped table-bordered">
			<thead class="table-info text-center align-baseline">
				<tr>
					<th style="min-width: 5%;">No.</th>
					<th style="min-width: 10%;">Kode Kelas</th>
					<th style="min-width: 25%;">Kelas | Nama Kelas</th>
					<th style="min-width: 25%;">Jurusan | Minat</th>
					<th style="min-width: 5%;">Jumlah Siswa</th>
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
				$selectSQL = "SELECT * FROM kelas";
				$data = mysqli_query($koneksi, $selectSQL);
				$jml_data = mysqli_num_rows($data);
				$tot_hal = ceil($jml_data / $batas);

				$dtkls  = mysqli_query($koneksi, "SELECT * FROM kelas ORDER BY id_kls ASC limit $hal_awal,$batas");
				while ($dt = mysqli_fetch_array($dtkls)) {
					$jml_sis = mysqli_fetch_array(mysqli_query($koneksi, "SELECT COUNT(kd_kls)AS jml_sis FROM cbt_peserta WHERE kd_kls ='$dt[kd_kls]';"));
				?>
					<tr class="text-center">
						<th><?php echo $no++ ?></th>
						<th><?php echo $dt['kd_kls'] ?></th>
						<td class="fw-semibold"><?php echo $dt['kls'] ; if(!empty($dt['nm_kls'])){echo " | " . $dt['nm_kls'];} ?></td>
						<td class="fw-semibold"><?php echo $dt['jur'] ; if(!empty($dt['kls_minat'])){echo " | " . $dt['kls_minat'];} ?></td>
						<td class="fw-semibold"><?php echo $jml_sis['jml_sis'] ?></td>
						<td>
							<form action="" method="post">
								<?php

								if ($dt['sts'] == "Y") {
									echo "<a href='./db/dbproses.php?pr=adm_klssts&dt=" . $dt['kd_kls'] . "' class='btn btn-sm btn-primary'>Aktif</a>";
								} else {
									echo "<a href='./db/dbproses.php?pr=adm_klssts&dt=" . $dt['kd_kls'] . "' class='btn btn-sm btn-danger'>Nonaktif</a>";
								}

								?></form>
						</td>
						<td>
							<button class="btn btn-sm fs-6 btn-warning" type="button" data-bs-toggle="modal" data-bs-target="#Edit<?php echo $dt[0]; ?>"><i class="bi bi-pencil-square"></i></button>
							<?php
							if ($jml_sis['jml_sis'] == 0) {
								echo "
							
							|
							<a href='?md=kls&pesan=hapus&us=$dt[kd_kls] ' class='btn btn-sm fs-6 btn-danger alert_notif'><i class='bi bi-trash3'></i></a>";
							} ?>
						</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
		<?php if ($jml_data >= $batas) {?>
		<nav aria-label="Page navigation example">
			<ul class="pagination pagination-sm justify-content-md-end  justify-content-center pe-3">
				<li class="page-item">
					<a class="page-link <?php if ($hal == 1) {echo 'disabled';} ?>" <?php if ($hal > 1) {echo "href='?md=kls&pg=$previous'";} ?>><i class="bi bi-chevron-left"></i></a>
				</li>
				<?php
				for ($i = 1; $i <= $tot_hal; $i++) { ?>
					<li class="page-item 
        <?php if ($hal == $i) {
						echo 'active';
					} ?>"><a class="page-link" href="?md=kls&pg=<?php echo $i ?>"><?php echo $i; ?></a></li>
				<?php
				}
				?>
				<li class="page-item">
					<a class="page-link 
        <?php if ($hal == $tot_hal) {
					echo 'disabled';
				} ?>" <?php if ($hal < $tot_hal) {
								echo "href='?md=kls&pg=$next'";
							} ?>><i class="bi bi-chevron-right"></i></a>
				</li>
			</ul>
		</nav>
		<?php }
		// else{echo "<div class='col-12 text-center'>data kosong</div>";} 
		?>
	</div>
		<div class="col-auto px-3 alert-light alert">
			<h4>Catatan :</h4>
			<p>Tombol Hapus/Delete akan muncul apabila jumlah siswa bernilai 0 <br> agar jumlah siswa bernilai 0 maka lakukan penghapusan pada Data Peserta. </p>
		</div>
</div>

	<!-- === Modal === -->
	<!-- === Edit === -->
	<?php
	$mdedit	=	mysqli_query($koneksi, "SELECT * FROM kelas ORDER BY id_kls ASC");

	while ($mddt = mysqli_fetch_array($mdedit)) {
	?>
		<div class="modal fade" id="Edit<?php echo $mddt[0]; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="EditLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h1 class="modal-title fs-5" id="EditLabel">Edit Kelas | <?php echo $mddt['nm_kls']; ?></h1>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<form action="./db/dbproses.php?pr=adm_klsedt" method="post">
						<div class="modal-body">
							<div class="row g-1">
								<div class="input-group input-group-sm">
									<label class="input-group-text col-4" id="kd_kls">Kode Kelas</label>
									<input type="text" class="form-control" id="kd_kls" name="kd_kls" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" value="<?php echo $mddt['kd_kls']; ?>">
									<input type="text" class="form-control" id="kd_kl" name="kd_kl" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" value="<?php echo $mddt['kd_kls']; ?>" hidden>
								</div>
								<div class="input-group input-group-sm">
									<label class="input-group-text col-4" id="kls">Kelas</label>
									<input type="text" class="form-control" id="kls" name="kls" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" value="<?php echo $mddt['kls']; ?>">
								</div>
								<div class="input-group input-group-sm">
									<label class="input-group-text col-4" id="nm_kls">Nama Kelas</label>
									<input type="text" class="form-control" id="nm_kls" name="nm_kls" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" value="<?php echo $mddt['nm_kls']; ?>">
								</div>
								<div class="input-group input-group-sm">
									<label class="input-group-text col-4" id="jur">Jurusan</label>
									<input type="text" class="form-control" id="jur" name="jur" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" value="<?php echo $mddt['jur']; ?>">
								</div>
								<div class="input-group input-group-sm">
									<label class="input-group-text col-4" id="min">Minat</label>
									<input type="text" class="form-control" id="min" name="min" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" value="<?php echo $mddt['kls_minat']; ?>">
								</div>
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
					<h1 class="modal-title fs-5" id="tambahLabel">Tambah Kelas</h1>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<form action="./db/dbproses.php?pr=adm_klsadd" method="post">
					<div class="modal-body">
						<div class="row g-1">
							<div class="input-group input-group-sm">
								<label class="input-group-text col-4" id="kd_kls">Kode Kelas</label>
								<input type="text" class="form-control" id="kd_kls" name="kd_kls" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" value="">
							</div>
							<div class="input-group input-group-sm">
								<label class="input-group-text col-4" id="kls">Kelas</label>
								<input type="text" class="form-control" id="kls" name="kls" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" value="">
							</div>
							<div class="input-group input-group-sm">
								<label class="input-group-text col-4" id="nm_kls">Nama Kelas</label>
								<input type="text" class="form-control" id="nm_kls" name="nm_kls" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" value="">
							</div>
							<div class="input-group input-group-sm">
								<label class="input-group-text col-4" id="jur">Jurusan</label>
								<input type="text" class="form-control" id="jur" name="jur" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" value="">
							</div>
							<div class="input-group input-group-sm">
								<label class="input-group-text col-4" id="min">Minat</label>
								<input type="text" class="form-control" id="min" name="min" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" value="">
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-primary" id="tambah" name="tambah">Tambah</button>
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<!-- === Akhir Modal === -->


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