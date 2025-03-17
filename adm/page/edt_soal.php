<?php
$pkt	= $_GET['ds'];
$dtpkt = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM cbt_pktsoal WHERE id_pktsoal = '$pkt'"));
$dtmpel = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM mapel WHERE kd_mpel = '$dtpkt[kd_mpel]'"));
$selectSQL = "SELECT * FROM cbt_soal WHERE kd_soal ='$dtpkt[kd_soal]'";
$jml_soal	= mysqli_num_rows(mysqli_query($koneksi,$selectSQL));


($dtpkt['sts'] == "Y") ? $del = "disabled" : $del = "";
if ($jml_soal >= $dtpkt['jum_soal']&&$dtpkt['sts'] == "Y") {
	$delhid = "hidden";
	$sts = "";
} else {
	$delhid = "";
	$sts = "hidden";
}

?>

<style>
	/* .rstuji {
		background-color: aqua;
	} */
	.image img {
		max-width: 100%;
		/* Batasi gambar agar tidak lebih lebar dari elemen induknya */
		height: auto;
		/* Jaga rasio aspek gambar */
		max-height: 15cm;
		/* Batasi tinggi maksimum gambar */
		aspect-ratio: 1 / 1;
		/* Atur rasio aspek gambar */
	}

	tr td .image_resized {
		width: auto;
		max-width: 200px;
		height: auto;
		max-height: 200px;
		aspect-ratio: 1/1;
	}

	p .image_resized {
		width: auto;
		max-width: 200px;
		height: auto;
		max-height: 200px;
		aspect-ratio: 1/1;
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
		min-width: 150px;
		/* text-align: center; */
		align-content: baseline;
	}

	.table-responsive th:nth-child(5),
	.table-responsive td:nth-child(5) {
		min-width: 150px;
		text-align: center;
		align-content: baseline;
	}
</style>

<div class="container-fluid mb-5 p-0">
	<div class="row p-2 border-bottom fs-3 mb-4 shadow-sm row justify-content-evenly">
		<div class="col">BANK SOAL | <?php echo $dtpkt['kd_soal'] . " | " . $dtmpel['nm_mpel'] . " | <i>" . $dtpkt['author'] . "</i>" ?> </div>
		<div class="col-auto" <?= $sts; ?>>
			<div class=" btn btn-primary">Status Soal Aktif</div>
		</div>
		<div class="col-sm-auto col-12 text-end">
			<a href="./db/dbproses.php?pr=clear&ds=<?php echo $pkt ?>" class="btn btn-danger" <?= $delhid; ?>>
				<i class="bi bi-trash3"></i> Kosongkan Soal
			</a>
		</div>
	</div>
	<div class="row border-bottom border-top p-2 mb-3 g-1">
		<!-- <?php $url = isset($_SERVER['HTTP_REFERER']) ? htmlspecialchars($_SERVER['HTTP_REFERER']) : '';  ?> -->
		<div class="col-auto ">
			<a href="?md=soal" class="btn btn-outline-dark"><i class="bi bi-arrow-left"></i> Kembali</a>
		</div>
		<!-- <div class="col-sm-auto col-12"><button class="btn btn-outline-dark" type="button" onclick="history.back(-1)"><i class="bi bi-arrow-left"></i> Kembali</button></div> -->
		<div class="col-12 col-sm">
			<div class="row justify-content-end g-1">
				<div class="col-sm-auto col-6" <?= $delhid; ?>><a href="?md=addsoal&kds=<?php echo $dtpkt['kd_soal'] ?>" class="btn btn-outline-primary"><i class="bi bi-plus"></i> Tambah Soal</a></div>
				<div class="col-sm-auto col-6" <?= $delhid; ?>><a href="?md=imsoal&kds=<?php echo $dtpkt['kd_soal'] ?>" class="btn btn-outline-secondary" type="button"><i class="bi bi-upload"></i> Upload</a></div>
				<div class="col-sm-auto col-6" <?= $delhid; ?>><a href="./db/dwld_soal.php?kds=<?php echo $dtpkt['kd_soal'] ?>&mpl=<?php echo $dtpkt['kd_mpel'] ?>" class="btn btn-outline-success"><i class="bi bi-download"></i> Download</a></div>
				<div class="col-sm-auto col-6"><a href="./print/c_soal.php?kds=<?php echo $dtpkt['kd_soal'] ?>" target="_blank" class="btn btn-outline-danger"><i class="bi bi-printer"></i> Cetak</a></div>
			</div>
		</div>
	</div>
	<div class="table-responsive border-top border-bottom mb-1">
		<table class="table table-hover" id="jsdata">
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
				<?php

				$batas = 10;
				$hal   = isset($_GET['pg']) ? (int)$_GET['pg'] : 1;
				$hal_awal = ($hal > 1) ? ($hal * $batas) - $batas : 0;

				$previous = $hal - 1;
				$next     = $hal + 1;

				$no = 1;
				$data = mysqli_query($koneksi, $selectSQL);
				$jml_data = mysqli_num_rows($data);
				$tot_hal = ceil($jml_data / $batas);

				// $dtmpl  = mysqli_query($koneksi, "SELECT * FROM cbt_soal WHERE kd_soal ='$dtpkt[kd_soal]' ORDER BY no_soal ASC limit $hal_awal,$batas");
				$dtmpl  = mysqli_query($koneksi, "SELECT * FROM cbt_soal WHERE kd_soal ='$dtpkt[kd_soal]' ORDER BY no_soal ASC");
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
							<button class="btn btn-sm fs-6 btn-info fw-bold" data-bs-toggle="modal" data-bs-target="#lihat<?php echo $dt['no_soal'] ?>"><i class="bi bi-eye"></i></button> |
							<a href="?md=edtsoal&kds=<?php echo $dtpkt['kd_soal'] ?>&eds=<?php echo $dt['no_soal'] ?>" class="btn btn-sm fs-6 btn-warning"><i class="bi bi-pencil-square"></i></a> |
							<button class="btn btn-sm fs-6 btn-danger" onclick="deleteData('<?php echo $dt['no_soal'] ?>','<?php echo $dtpkt['kd_soal'] ?>')" <?= $del; ?>><i class="bi bi-trash3"></i></button>
						</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>

<?php
$dtmpl  = mysqli_query($koneksi, "SELECT * FROM cbt_soal WHERE kd_soal ='$dtpkt[kd_soal]' ORDER BY no_soal ASC limit $hal_awal,$batas");
while ($dt = mysqli_fetch_array($dtmpl)) {
?>
	<!-- Modal -->
	<div class="modal fade" id="lihat<?php echo $dt['no_soal'] ?>" tabindex="-1" aria-labelledby="lihatLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg modal-dialog-scrollable">
			<div class="modal-content">
				<div class="modal-header">
					<h1 class="modal-title fs-5" id="lihatLabel">Soal No.<?= $dt['no_soal'] ?> | <?= $dt['jns_soal'] == "G" ? "Pilihan Ganda" : "Esai" ?>
					</h1>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body bg-light-subtle mx-2">
					<div class="row">
						<?php
						if ($dt['kd_crta'] != 0 || !empty($dt['cerita'])) { ?>
							<div class="col bg-info" style="border-top-left-radius: 5px;border-top-right-radius: 5px;"><i class="text-decoration-underline p-0">Deskripsi:</i></div>

							<div class="col-12 mb-2 p-2 bg-info-subtle" style="border-bottom-left-radius: 5px;border-bottom-right-radius: 5px;">
								<?php
								if (empty($dt['kd_crta'])) {
									echo $dt['cerita'];
								} else {
									$kd_crt		= mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM cbt_soal WHERE no_soal ='$dt[kd_crta]' AND kd_soal ='$dtpkt[kd_soal]'"));
									echo $kd_crt['cerita'];
								}

								?>
							</div>
						<?php }
						if (!empty($dt['img'])) { ?>
							<div class="col bg-info" style="border-top-left-radius: 5px;border-top-right-radius: 5px;"><i class="text-decoration-underline">Gambar Soal:</i></div>
							<?php
							if (empty($dt['img'])) {
								echo "../img/img.png";
							} else {
								$imagePath = "../images/" . $dt['img'];
								if (file_exists($imagePath)) {
									$img = $imagePath;
								} else {
									$img = "../img/no_image.png";
								}
							}
							?>
							<div class="col-12 text-center bg-info-subtle mb-2 p-2" style="border-bottom-left-radius: 5px;border-bottom-right-radius: 5px;"><img src="<?= $img ?>" class="img-thumbnail" style="max-width: 350px;" alt="" srcset=""></div>
						<?php } ?>
						<div class="col bg-dark-subtle" style="border-top-left-radius: 5px;border-top-right-radius: 5px;"><i class="text-decoration-underline">Pertanyaan:</i></div>
						<div class="col-12 mb-2 p-2 bg-info-subtle" style="border-bottom-left-radius: 5px;border-bottom-right-radius: 5px;">
							<?php echo $dt['tanya'] ?>
						</div>
						<?php if ($dt['jns_soal'] == "G") { ?>
							<div class="col bg-dark-subtle" style="border-top-left-radius: 5px;border-top-right-radius: 5px;"><i class="text-decoration-underline">Opsi Jawaban:</i></div>
							<div class="col-12 p-2 bg-info-subtle" style="border-bottom-left-radius: 5px;border-bottom-right-radius: 5px;">
								<table>
									<?php
									for ($i = 1; $i <= 5; $i++) {
										$key = "img$i";
										$jawabKey = "jwb$i";
										$isCorrect = $dt['knci_pilgan'] == "$i";
										$imgPath = "../images/" . $dt[$key];
										$jawab = str_replace(["<p>", "</p>"], "", $dt[$jawabKey]);
									?>
										<tr valign="top">
											<td>
												<?php if ($isCorrect) { ?>
													<img src="../img/benar.png" style="max-width: 20px;">
												<?php } ?>
											</td>
											<td><?= chr(64 + $i) ?>.</td> <!-- Menampilkan A, B, C, D, E -->
											<td class="p-2">
												<?php if (!empty($dt[$key])) { ?>
													<?php if (file_exists($imgPath)) { ?>
														<img src="<?= $imgPath ?>" class="img-thumbnail" style="max-width: 150px;">
													<?php } else { ?>
														<i class="text-bg-danger">Upload Gambar</i>
													<?php } ?>
												<?php } ?>
											</td>
											<td><?= $jawab ?></td>
										</tr>
									<?php } ?>
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

<!-- Format gambar text -->
<script type="text/javascript">
	// function resetAndAddStyle(className, newStyle) {
	// 	const elements = document.querySelectorAll(`.${className}`); // Menyeleksi semua elemen dengan className
	// 	elements.forEach(element => {
	// 		element.style.cssText = newStyle; // Menetapkan style menggunakan cssText untuk mengganti seluruh atribut style
	// 	});
	// }

	// // Memanggil fungsi untuk mengubah gaya semua elemen dengan class 'image_resized'
	// resetAndAddStyle('image_resized', 'width:auto;max-height:15cm;');


	// // Mendapatkan semua elemen <p> di halaman
	// var elements = document.getElementsByTagName('figure');

	// // Loop melalui elemen-elemen <p> dan menambahkan atribut
	// for (var i = 0; i < elements.length; i++) {
	//   elements[i].setAttribute('style', 'width:auto;max-height:15cm;');
	// }
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