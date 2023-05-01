<?php
error_reporting(0); //hide error

if ($_GET['ed'] == "hapus") {
?>
	<script>
		Swal.fire({
			title: 'Are you sure?',
			text: "You won't be able to revert this!",
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Yes, delete it!'
		}).then((result) => {
			if (result.isConfirmed) {
				<?php

				?>
				Swal.fire(
					'Deleted!',
					'Your file has been deleted.',
					'success'
				)
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
					<th style="width: 5%;">No.</th>
					<th style="width: 10%;">Kode Mata Pelajaran</th>
					<th style="width: 30%;">Nama Mata Pelajaran</th>
					<th style="width: 15%;">Kelas</th>
					<th style="width: 10%;">KKM</th>
					<th style="width: 10%;">Edit | hapus</th>
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
					$dtt = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM kelas WHERE kd_kls ='$dt[kd_kls]';"));
				?>
					<tr class="text-center">
						<th><?php echo $no++ ?></th>
						<th><?php echo $dt['kd_mpel'] ?></th>
						<td class="fw-semibold"><?php echo $dt['nm_mpel'] ?></td>
						<td class="fw-semibold"><?php echo $dtt['nm_kls'] ?></td>
						<td class="fw-semibold"><?php echo $dt['kkm'] ?></td>
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
							if ($jml_sis['jml_sis'] == 0) {
								echo "
							
							|
							<a href='?md=mpl&pesan=hapus&us= $dt[kd_mpl] ' class='btn btn-sm fs-6 btn-danger alert_notif'><i class='bi bi-trash3'></i></a>";
							} ?>
						</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
		<?php if ($jml_data >= $batas) {?>
		<nav aria-label="Page navigation example">
			<ul class="pagination pagination-sm justify-content-end pe-3">
				<li class="page-item">
					<a class="page-link <?php if ($hal == 1) {echo 'disabled';} ?>" <?php if ($hal > 1) {echo "href='?md=mpl&pg=$previous'";} ?>><i class="bi bi-chevron-left"></i></a>
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


<!-- === Modal === -->
<!-- === Edit === -->
<div class="modal fade" id="Edit" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="EditLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h1 class="modal-title fs-5" id="EditLabel">Rubah Data User</h1>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<form action="" method="post">
				<div class="modal-body">
					Lorem ipsum, dolor sit amet consectetur adipisicing elit. Est reprehenderit veniam, iste sint neque ullam, ad aliquid explicabo aspernatur laborum quae dolor asperiores! Sunt tempora, beatae quis delectus molestiae ratione?
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary" id="Edit" name="Edit">Simpan</button>
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
				</div>
			</form>
		</div>
	</div>
</div>

<!-- === Tambah === -->
<div class="modal fade" id="tambah" tabindex="-1" aria-labelledby="tambahLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h1 class="modal-title fs-5" id="tambahLabel">Tambah User</h1>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<form action="" method="post">
				<div class="modal-body">
					Lorem ipsum dolor sit amet consectetur adipisicing elit. Adipisci ipsam rerum dolorem fugit nam, provident quasi eum quas assumenda minus quia eligendi amet repellendus animi in ex placeat, quos minima?
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
					<a href="?md=mpl&ed=add" type="button" class="btn btn-primary" id="tambah" name="tambah">Tambah</a>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- === Akhir Modal === -->
<script>

</script>

<script>

</script>