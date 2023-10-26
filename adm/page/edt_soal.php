<?php
$pkt	= $_GET['ds'];
$dtpkt = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM cbt_pktsoal WHERE id_pktsoal = '$pkt'"));
$dtmpel = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM mapel WHERE kd_mpel = '$dtpkt[kd_mpel]'"));
?>

<style>
	/* .rstuji {
		background-color: aqua;
	} */
</style>

<div class="container-fluid mb-5 p-0">
	<div class="row p-2 border-bottom fs-3 mb-4 shadow-sm row justify-content-evenly">
		<div class="col">BANK SOAL | <?php echo $dtpkt['kd_soal'] . " | " . $dtmpel['nm_mpel'] . " | <i>" . $dtpkt['author'] . "</i>" ?> </div>
		<div class="col-sm-auto col-12 text-end">
			<a href="./db/dbproses.php?pr=clear&ds=<?php echo $pkt ?>" class="btn btn-danger">
				<i class="bi bi-trash3"></i> Kosongkan Soal
			</a>
		</div>
	</div>
	<div class="row border-bottom border-top p-2 mb-3 g-1">
		<!-- <?php $url = isset($_SERVER['HTTP_REFERER']) ? htmlspecialchars($_SERVER['HTTP_REFERER']) : '';  ?> -->
		<div class="col-auto "><a href="?md=soal" class="btn btn-outline-dark"><i class="bi bi-arrow-left"></i> Kembali</a></div>
		<!-- <div class="col-sm-auto col-12"><button class="btn btn-outline-dark" type="button" onclick="history.back(-1)"><i class="bi bi-arrow-left"></i> Kembali</button></div> -->
		<div class="col-12 col-sm">
			<div class="row justify-content-end g-1">
				<div class="col-sm-auto col-6"><a href="?md=addsoal&kds=<?php echo $dtpkt['kd_soal'] ?>" class="btn btn-outline-primary"><i class="bi bi-plus"></i> Tambah Soal</a></div>
				<!-- <div class="col-sm-auto col-6"><button class="btn btn-secondary" type="button" data-bs-toggle="modal" data-bs-target="#upload"><i class="bi bi-upload"></i> Upload</button></div> -->
				<div class="col-sm-auto col-6"><a href="?md=imsoal&kds=<?php echo $dtpkt['kd_soal'] ?>" class="btn btn-outline-secondary" type="button"><i class="bi bi-upload"></i> Upload</a></div>
				<div class="col-sm-auto col-6"><a href="./db/dwld_soal.php?kds=<?php echo $dtpkt['kd_soal'] ?>&mpl=<?php echo $dtpkt['kd_mpel'] ?>" target="_blank" class="btn btn-outline-success"><i class="bi bi-download"></i> Download</a></div>
				<div class="col-sm-auto col-6"><a href="./print/c_soal.php?kds=<?php echo $dtpkt['kd_soal'] ?>" target="_blank" class="btn btn-outline-danger"><i class="bi bi-printer"></i> Cetak</a></div>
			</div>
		</div>
	</div>
	<div class="table-responsive border-top border-bottom">
		<table class="table table-hover">
			<thead>
				<tr class="table-info text-center align-baseline">
					<th scope="col" style="min-width: 50px;width: 70px;">No Soal</th>
					<th scope="col" style="min-width: 50px;">Jenis Soal</th>
					<th scope="col" style="min-width: 500px;">Pertanyaan</th>
					<th scope="col" style="min-width: 100px;width: 130px;">Soal | Opsi</th>
					<th scope="col" style="min-width: 135px;width: 150px;">Lihat | Edit | Hapus</th>
				</tr>
			</thead>
			<tbody class="table-group-divider">
				<!-- 
					SELECT * FROM cbt_soal
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
						<td scope="row" class="text-center"><?php if ($dt['jns_soal'] == "G") {
																									echo "PilGan";
																								} else {
																									echo "Esai";
																								} ?></td>
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
							<button class="btn btn-sm fs-6 btn-outline-info fw-bold" data-bs-toggle="modal" data-bs-target="#lihat<?php echo $dt['no_soal'] ?>"><i class="bi bi-eye"></i></button> |
							<a href="?md=edtsoal&kds=<?php echo $dtpkt['kd_soal'] ?>&eds=<?php echo $dt['no_soal'] ?>" class="btn btn-sm fs-6 btn-outline-warning"><i class="bi bi-pencil-square"></i></a> |
							<button class="btn btn-sm fs-6 btn-outline-danger" onclick="deleteData('<?php echo $dt['no_soal'] ?>','<?php echo $dtpkt['kd_soal'] ?>')"><i class="bi bi-trash3"></i></button>
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

<?php
$dtmpl  = mysqli_query($koneksi, "SELECT * FROM cbt_soal WHERE kd_soal ='$dtpkt[kd_soal]' ORDER BY no_soal ASC limit $hal_awal,$batas");
while ($dt = mysqli_fetch_array($dtmpl)) {
?>
	<!-- Modal -->
	<div class="modal fade" id="lihat<?php echo $dt['no_soal'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="lihatLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg modal-dialog-scrollable">
			<div class="modal-content">
				<div class="modal-header">
					<h1 class="modal-title fs-5" id="lihatLabel">Soal No.<?php echo $dt['no_soal'] ?> | <?php if ($dt['jns_soal'] == "G") {
																																																echo "Pilihan Ganda";
																																															} else {
																																																echo "Esai";
																																															} ?></h1>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body bg-light-subtle mx-2">
					<div class="row">
						<?php
						if (!empty($dt['img'])) {
							echo '<div class="col bg-info" style="border-top-left-radius: 5px;border-top-right-radius: 5px;"><i class="text-decoration-underline">Gambar Soal:</i></div>';
						?>
							<div class="col-12 text-center bg-info-subtle mb-2 p-2" style="border-bottom-left-radius: 5px;border-bottom-right-radius: 5px;"><img src="../images/<?php echo $dt['img'] ?>" class="img-thumbnail" style="max-width: 350px;" alt="" srcset=""></div>
						<?php }
						if ($dt['kd_crta'] != 0 || !empty($dt['cerita'])) {
							echo '<div class="col bg-info" style="border-top-left-radius: 5px;border-top-right-radius: 5px;"><i class="text-decoration-underline p-0">Deskripsi:</i></div>';
						?>

							<div class="col-12 mb-2 p-2 bg-info-subtle" style="border-bottom-left-radius: 5px;border-bottom-right-radius: 5px;">
								<?php
								if ($dt['kd_crta'] == 0) {
									echo $dt['cerita'];
								} else {
									$kd_crt		= mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM cbt_soal WHERE no_soal ='$dt[kd_crta]' AND kd_soal ='$dtpkt[kd_soal]'"));
									echo $kd_crt['cerita'];
								}

								?>
							</div>
						<?php } ?>
						<div class="col bg-info" style="border-top-left-radius: 5px;border-top-right-radius: 5px;"><i class="text-decoration-underline">Pertanyaan:</i></div>
						<div class="col-12 mb-2 p-2 bg-info-subtle" style="border-bottom-left-radius: 5px;border-bottom-right-radius: 5px;">
							<?php echo $dt['tanya'] ?>
						</div>
						<?php if ($dt['jns_soal'] == "G") { ?>
							<div class="col bg-info" style="border-top-left-radius: 5px;border-top-right-radius: 5px;"><i class="text-decoration-underline">Opsi Jawaban:</i></div>
							<div class="col-12 p-2 bg-info-subtle" style="border-bottom-left-radius: 5px;border-bottom-right-radius: 5px;">
								<table>
									<tr>
										<td><?php if ($dt['knci_pilgan'] == "1") {
													echo '<img src="../img/benar.png" style="max-width: 20px;">';
												} ?></td>
										<td>A.</td>
										<td class="p-2">
											<?php
											if (!empty($dt['img1'])) {
												if (file_exists("../images/$dt[img1]")) {
													echo "<img src='../images/" . $dt['img1'] . "' class='img-thumbnail' style='max-width: 150px;'>  </td><td class=''>";
												} else {
													echo '<i class="text-bg-danger"> Upload Gambar </i></td><td class="">';
												}
											}
											$Jawab1 = str_replace("<p>", "", $dt['jwb1']);
											$Jawab1 = str_replace("</p>", "", $Jawab1);
											echo $Jawab1;

											?>

										</td>
									</tr>
									<tr>
										<td><?php if ($dt['knci_pilgan'] == "2") {
													echo '<img src="../img/benar.png" style="max-width: 20px;">';
												} ?></td>
										<td>B.</td>
										<td class="p-2">
											<?php
											if (!empty($dt['img2'])) {
												if (file_exists("../images/$dt[img2]")) {
													echo "<img src='../images/" . $dt['img2'] . "' class='img-thumbnail' style='max-width: 150px;'>  </td><td>";
												} else {
													echo '<i class="text-bg-danger"> Upload Gambar </i></td><td>';
												}
											}
											$Jawab2 = str_replace("<p>", "", $dt['jwb2']);
											$Jawab2 = str_replace("</p>", "", $Jawab2);
											echo $Jawab2;
											?></td>
									</tr>
									<tr>
										<td><?php if ($dt['knci_pilgan'] == "3") {
													echo '<img src="../img/benar.png" style="max-width: 20px;">';
												} ?></td>
										<td>C.</td>
										<td class="p-2">
											<?php
											if (!empty($dt['img3'])) {
												if (file_exists("../images/$dt[img3]")) {
													echo "<img src='../images/" . $dt['img3'] . "' class='img-thumbnail' style='max-width: 150px;'>  </td><td>";
												} else {
													echo '<i class="text-bg-danger"> Upload Gambar </i></td><td>';
												}
											}
											$Jawab3 = str_replace("<p>", "", $dt['jwb3']);
											$Jawab3 = str_replace("</p>", "", $Jawab3);
											echo $Jawab3;
											?></td>
									</tr>
									<tr>
										<td><?php if ($dt['knci_pilgan'] == "4") {
													echo '<img src="../img/benar.png" style="max-width: 20px;">';
												} ?></td>
										<td>D.</td>
										<td class="p-2">
											<?php
											if (!empty($dt['img4'])) {
												if (file_exists("../images/$dt[img4]")) {
													echo "<img src='../images/" . $dt['img4'] . "' class='img-thumbnail' style='max-width: 150px;'>  </td><td>";
												} else {
													echo '<i class="text-bg-danger"> Upload Gambar </i></td><td>';
												}
											}
											$Jawab4 = str_replace("<p>", "", $dt['jwb4']);
											$Jawab4 = str_replace("</p>", "", $Jawab4);
											echo $Jawab4;
											?></td>
									</tr>
									<tr>
										<td><?php if ($dt['knci_pilgan'] == "5") {
													echo '<img src="../img/benar.png" style="max-width: 20px;">';
												} ?></td>
										<td>E.</td>
										<td class="p-2">
											<?php
											if (!empty($dt['img5'])) {
												if (file_exists("../images/$dt[img5]")) {
													echo "<img src='../images/" . $dt['img5'] . "' class='img-thumbnail' style='max-width: 150px;'> </td><td>";
												} else {
													echo '<i class="text-bg-danger"> Upload Gambar </i></td><td>';
												}
											}
											$Jawab5 = str_replace("<p>", "", $dt['jwb5']);
											$Jawab5 = str_replace("</p>", "", $Jawab5);
											echo $Jawab5;
											?></td>
									</tr>
								</table>
							</div>
						<?php } ?>
					</div>
				</div>
				<div class="modal-footer">
					<div class="col-12 text-center">
						<button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">Tutup</button>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php } ?>
<!-- Akhir Modal -->
<script src="../node_modules/jquery/dist/jquery.min.js"></script>
<script src="../node_modules/sweetalert2/dist/sweetalert2.min.js"></script>
<link rel="stylesheet" href="../node_modules/sweetalert2/dist/sweetalert2.min.css">

<script>
	function deleteData(no, kds) {
		// Menampilkan konfirmasi SweetAlert2
		Swal.fire({
			title: 'Yakin Hapus Data?',
			text: 'Data akan dihapus Secara Permanen!',
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Hapus',
			cancelButtonText: "Batal"
		}).then((result) => {
			if (result.isConfirmed) {
				// Jika pengguna mengonfirmasi, kirim permintaan AJAX untuk menghapus data
				$.ajax({
					type: 'POST',
					url: './db/dlt_soal.php', // Ganti dengan URL yang benar
					data: {
						no: no,
						kds: kds
					}, // Kirim ID data yang ingin dihapus
					success: function(response) {
						// Tampilkan pesan hasil hapus dari server
						// location.reload();
						Swal.fire('Berhasil!', response, 'success')
							.then((result) => {
								// Jika notifikasi ditutup, muat ulang halaman
								if (result.isConfirmed || result.isDismissed) {
									location.reload();
								}
							});
					},
					error: function() {
						Swal.fire('Error', 'An error occurred.', 'error');
					}
				});
			}
		});
	}
</script>