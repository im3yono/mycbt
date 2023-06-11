<?php
$pkt	= $_GET['ds'];
$dtpkt = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM `cbt_pktsoal` WHERE id_pktsoal = '$pkt'"));
$dtmpel = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM `mapel` WHERE kd_mpel = '$dtpkt[kd_mpel]'"));
?>

<style>
	/* .rstuji {
		background-color: aqua;
	} */
</style>

<div class="container-fluid mb-5 p-0">
	<div class="row p-2 border-bottom fs-3 mb-4 shadow-sm row justify-content-evenly">
		<div class="col">BANK SOAL | <?php echo $dtpkt['kd_soal'] . " | " . $dtmpel['nm_mpel'] . " | <i>" . $dtpkt['author'] . "</i>" ?> </div>
		<div class="col-sm-auto col-12 text-end"><button class="btn btn-danger"><i class="bi bi-trash3"></i> Kosongkan</button></div>
	</div>
	<div class="row border-bottom border-top p-2 mb-3 g-1">
		<!-- <?php $url = isset($_SERVER['HTTP_REFERER']) ? htmlspecialchars($_SERVER['HTTP_REFERER']) : '';  ?> -->
		<div class="col-auto "><a href="?md=soal" class="btn btn-outline-dark"><i class="bi bi-arrow-left"></i> Kembali</a></div>
		<!-- <div class="col-sm-auto col-12"><button class="btn btn-outline-dark" type="button" onclick="history.back(-1)"><i class="bi bi-arrow-left"></i> Kembali</button></div> -->
		<div class="col">
			<div class="row justify-content-end g-1">
				<div class="col-sm-auto col-6"><button class="btn btn-primary"><i class="bi bi-plus"></i> Tambah Soal</button></div>
				<!-- <div class="col-sm-auto col-6"><button class="btn btn-secondary" type="button" data-bs-toggle="modal" data-bs-target="#upload"><i class="bi bi-upload"></i> Upload</button></div> -->
				<div class="col-sm-auto col-6"><a href="?md=imsoal&kds=<?php echo $dtpkt['kd_soal']?>" class="btn btn-secondary" type="button"><i class="bi bi-upload"></i> Upload</a></div>
				<div class="col-sm-auto col-6"><button class="btn btn-success"><i class="bi bi-download"></i> Download</button></div>
				<div class="col-sm-auto col-6"><button class="btn btn-outline-danger"><i class="bi bi-printer"></i> Cetak</button></div>
			</div>
		</div>
	</div>
	<div class="table-responsive border-top border-bottom">
		<table class="table table-sm">
			<thead>
				<tr class="table-info text-center align-baseline">
					<th scope="col" style="min-width: 50px;width: 70px;">No Soal</th>
					<th scope="col" style="min-width: 500px;">Pertanyaan</th>
					<th scope="col" style="min-width: 100px;width: 130px;">Soal | Opsi</th>
					<th scope="col" style="min-width: 135px;width: 150px;">Lihat | Edit | Hapus</th>
				</tr>
			</thead>
			<tbody class="table-group-divider">
				<!-- 
					SELECT * FROM `cbt_soal`
				 -->
				<?php

				$batas = 10;
				$hal   = isset($_GET['pg']) ? (int)$_GET['pg'] : 1;
				$hal_awal = ($hal > 1) ? ($hal * $batas) - $batas : 0;

				$previous = $hal - 1;
				$next     = $hal + 1;

				$no = 1;
				$selectSQL = "SELECT * FROM cbt_soal WHERE kd_soal ='$dtpkt[kd_soal]'";
				$data = mysqli_query($koneksi, $selectSQL);
				$jml_data = mysqli_num_rows($data);
				$tot_hal = ceil($jml_data / $batas);

				$dtmpl  = mysqli_query($koneksi, "SELECT * FROM cbt_soal WHERE kd_soal ='$dtpkt[kd_soal]' ORDER BY no_soal ASC limit $hal_awal,$batas");
				while ($dt = mysqli_fetch_array($dtmpl)) {
				?>
					<tr>
						<th scope="row" class="text-center"><?php echo $dt['no_soal'] ?></th>
						<td><?php echo $dt['tanya'] ?></td>
						<td class="text-center">
							<?php
							if ($dt['ack_soal'] == "Y") {
								echo "Acak | ";
							} else {
								echo "Tidak | ";
							}
							if ($dt['ack_opsi'] == "Y") {
								echo "Acak";
							} else {
								echo "Tidak";
							}
							?></td>
						<td class="text-center">
							<button class="btn btn-sm fs-6 btn-outline-info fw-bold"><i class="bi bi-eye"></i></button> |
							<button class="btn btn-sm fs-6 btn-outline-warning"><i class="bi bi-pencil-square"></i></button> |
							<button class="btn btn-sm fs-6 btn-outline-danger"><i class="bi bi-trash3"></i></button>
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
										echo "href='?md=esoal&ds=$pkt&pg=$previous'";
									} ?>><i class="bi bi-chevron-left"></i></a>
				</li>
				<?php
				for ($i = 1; $i <= $tot_hal; $i++) { ?>
					<li class="page-item 
        <?php if ($hal == $i) {
						echo 'active';
					} ?>"><a class="page-link" href="?md=esoal&ds=<?php echo $pkt ?>&pg=<?php echo $i ?>"><?php echo $i; ?></a></li>
				<?php
				}
				?>
				<li class="page-item">
					<a class="page-link 
        <?php if ($hal == $tot_hal) {
					echo 'disabled';
				} ?>" <?php if ($hal < $tot_hal) {
								echo "href='?md=esoal&ds=$pkt&pg=$next'";
							} ?>><i class="bi bi-chevron-right"></i></a>
				</li>
			</ul>
		</nav>
	<?php }
	// else{echo "<div class='col-12 text-center'>data kosong</div>";} 
	?>
</div>

<!-- Modal -->
<!-- Upload -->
<!-- <div class="modal fade modal-sm" id="upload" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="uploadLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h1 class="modal-title fs-5" id="uploadLabel">Upload Soal</h1>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div class="input-group">
					<input type="file" class="form-control" id="inputGroupFile04" aria-describedby="inputGroupFileAddon04" aria-label="Upload">
					<button class="btn btn-outline-secondary" type="button" id="inputGroupFileAddon04">Button</button>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-success">Upload</button>
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
			</div>
		</div>
	</div>
</div> -->
<!-- Akhir Modal -->

<script>

</script>