<?php
include_once("../../config/server.php");
// error_reporting(0); //hide error
function cekAngka($angka)
{
	if ($angka % 2 === 0) {
		echo "text-center";
	} else {
		echo "text-start";
	}
}

if (empty($_POST['page'])) {
	$pg = "A4";
	$sw = "210";
	$sh = "297";
	$jml = 25;
} elseif ($_POST['page'] == "1") {
	$pg = "A4";
	$sw = "210";
	$sh = "297";
	$jml = 25;
} else {
	$pg = "F4";
	$sw = "215";
	$sh = "330";
	$jml = 30;
}


?>
<html>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="shortcut icon" href="../../img/fav.png" type="image/x-icon">
<link rel="stylesheet" href="../../vendor/twbs/bootstrap/dist/css/bootstrap.min.css">
<script src="../../vendor/twbs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<!-- <link rel="stylesheet" href="page_soal.css"> -->
<style>
	.page {
		width: <?php echo $sw; ?>mm;
		min-height: <?php echo $sh; ?>mm;
		/* max-height: 297mm; */
		padding: 3mm 5mm;
		margin: 5mm auto;
		border: 1px #d3d3d3 solid;
		border-radius: 5px;
		background: white;
		box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
	}

	.isi {
		margin: 2mm;
		min-height: <?php echo $sh; ?>mm;
	}

	@media print {

		html,
		body {
			width: <?php echo $sw; ?>mm;
			height: <?php echo $sh; ?>mm;
		}

		.page {
			padding: 0;
			/* margin: 0 5mm; */
			border: initial;
			border-radius: initial;
			width: initial;
			min-height: initial;
			box-shadow: initial;
			background: initial;
			page-break-after: always;
		}

		@page {
			size: <?php echo $pg; ?>;
			padding: 0;
			margin: 0 5mm;
		}

		.pb-2 {

			padding: 0;
		}
	}
</style>
<?php
if (empty($_POST['kls'])) {
?>
	<!-- <div class="col-12 text-center py-5"><i class="bg-danger-subtle p-2" style="border-radius: 5px;">Tentukan Data Kelas</i></div> -->

	<body>
		<div class="">
			<div class="page">
					<div class="isi">
				<!-- HEAD -->
				<div class="row justify-content-center" style="border-bottom-style: double;padding-bottom: 3px;">
					<div class="col-auto text-center">
						<img src="../../img/<?php if ($inf_lgdns != null) {
																	echo $inf_lgdns;
																} else {
																	echo "tut.png";
																} ?>" alt="" srcset="" class="rounded" style='max-width:80px; max-height:100px;'>
					</div>
					<div class="col-auto text-center">
						<div class="fs-5 pgh fw-semibold"><?php if ($inf_head != null) {
																								echo $inf_head;
																							} else {
																								echo "DAFTAR HADIR PESERTA TES BERBASIS KOMPUTER";
																							} ?></div>
						<div class="fs-2 pgs"><?php if ($inf_nm != null) {
																		echo $inf_nm;
																	} else {
																		echo "SMA/SMK/MA";
																	} ?></div>
						<!-- <div class="fs-6 pgh fw-semibold"><?php if ($inf_head2 != null) {
																											echo $inf_head2;
																										} else {
																											echo "SOAL UJIAN SEKOLAH BERBASIS TEKNOLOGI INFORMASI";
																										} ?></div> -->
					</div>
					<div class="col-auto text-center">
						<img src="../../img/<?php if ($inf_fav != null) {
																	echo "$inf_fav";
																} else {
																	echo "fav.png";
																} ?>" alt="" srcset="" class="rounded" style='max-width:80px; max-height:100px;'>
					</div>
				</div>
				<!-- Akhir HEAD -->
				<!-- Body -->
				<div class="row py-2">
					<div class="row m-0 px-2 pb-2 justify-content-between ">
						<div class="p-0 " style="width: 450px;">
							<div class="row justify-content-start">
								<div class="" style="width: 130px;">Mata Pelajaran</div>:
								<div class="border-bottom border-dark" style="width: 320px;"></div>
							</div>
						</div>
						<div class="p-0 " style="width: 270px;">
							<div class="row justify-content-start">
								<div class="" style="width: 120px;">Sesi/Ruang</div>:
								<div class="border-bottom border-dark" style="width: 150px;"></div>
							</div>
						</div>
					</div>
					<div class="row m-0 px-2 pb-2 justify-content-between ">
						<div class="p-0 " style="width: 450px;">
							<div class="row justify-content-start">
								<div class="" style="width: 130px;">Hari Tanggal</div>:
								<div class="border-bottom border-dark" style="width: 320px;"></div>
							</div>
						</div>
						<div class="p-0 " style="width: 270px;">
							<div class="row justify-content-start">
								<div class="" style="width: 120px;">Pukul</div>:
								<div class="border-bottom border-dark" style="width: 150px;"></div>
							</div>
						</div>
					</div>
				</div>
				<table class="table table-sm table-bordered table-striped">
					<thead class="text-center align-text-top" style="background-color: #f7c745;">
						<th class="p-0" style="width: 7mm;">No.</th>
						<th class="p-0" style="width: 20mm;">No. Peserta</th>
						<th style="width: 55mm;">Nama</th>
						<th style="width: 45mm;">Tanda Tangan</th>
						<th class="p-0" style="width: 10mm;">Keterangan</th>
					</thead>
					<tbody>
						<?php
						$no = 1;
						for ($i = $no; $i <= $jml; $i++) {
							if ($no % 2 === 0) {
								$tno = "text-center";
							} else {
								$tno = "text-start";
							}
						?>

							<tr>
								<td align="center"><?php echo $no ?>.</td>
								<td></td>
								<td></td>
								<td class="<?php echo $tno ?>"><?php echo $no ?>.</td>
								<td></td>
							</tr>
						<?php $no++;
						} ?>
					</tbody>
				</table>
				<!-- Akhir Body -->
				<!-- TTD -->
				<div class="row justify-content-start gap-2 mx-2" style="font-size: small;">
					<div class="col-auto ">
						<div class="col ">
							<i>Keterangan:</i>
							<div>1. Daftar hadir dibuat rangkap 2(dua)<br>2. Pengawas ruang menyilang Nama Peserta yang tidak hadir.</div>
						</div>
						<div class="col "><br>
							<div class="row pb-1 border border-bottom-0 border-dark">
								<div class="col">Jumlah Peserta Hadir</div>
								<div class="col-auto">:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Orang</div>
							</div>
							<div class="row pb-1 border border-top-0 border-dark">
								<div class="col">Jumlah Peserta yang Tidak Hadir</div>
								<div class="col-auto">:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Orang</div>
							</div>
							<div class="row pb-1 border border-dark">
								<div class="col">Jumlah Peserta yang Seharusnya Hadir</div>
								<div class="col-auto">:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Orang</div>
							</div>
						</div>
					</div>
					<div class="col text-center "><br>Pengawas 1<br><br><br><br>
						<div class="text-start">(________________________)<br>NIP.</div>
					</div>
					<div class="col text-center "><br>Pengawas 2<br><br><br><br>
						<div class="text-start">(________________________)<br>NIP.</div>
					</div>
				</div>
				<!-- Akhir TTD --></div>
			</div>
		</div>
	</body>
	<?php
} else {
	$no = 1;
	$jmldata		= mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM cbt_peserta WHERE kd_kls = '$_POST[kls]'"));
	$tot_page = ceil($jmldata / $jml);
	for ($ipg = 1; $ipg <= $tot_page; $ipg++) {
	?>

		<body>
			<div class="">
				<div class="page">
					<div class="isi">
						<!-- HEAD -->
						<div class="row justify-content-center" style="border-bottom-style: double;padding-bottom: 3px;">
							<div class="col-auto text-center">
								<img src="../../img/<?php if ($inf_lgdns != null) {
																			echo $inf_lgdns;
																		} else {
																			echo "tut.png";
																		} ?>" alt="" srcset="" class="rounded" style='max-width:80px; max-height:100px;'>
							</div>
							<div class="col-auto text-center">
								<div class="fs-5 pgh fw-semibold"><?php if ($inf_head != null) {
																										echo $inf_head;
																									} else {
																										echo "DAFTAR HADIR PESERTA TES BERBASIS KOMPUTER";
																									} ?></div>
								<div class="fs-2 pgs"><?php if ($inf_nm != null) {
																				echo $inf_nm;
																			} else {
																				echo "SMA/SMK/MA";
																			} ?></div>
								<!-- <div class="fs-6 pgh fw-semibold"><?php if ($inf_head2 != null) {
																													echo $inf_head2;
																												} else {
																													echo "SOAL UJIAN SEKOLAH BERBASIS TEKNOLOGI INFORMASI";
																												} ?></div> -->
							</div>
							<div class="col-auto text-center">
								<img src="../../img/<?php if ($inf_fav != null) {
																			echo "$inf_fav";
																		} else {
																			echo "fav.png";
																		} ?>" alt="" srcset="" class="rounded" style='max-width:80px; max-height:100px;'>
							</div>
						</div>
						<!-- Akhir HEAD -->
						<!-- Body -->
						<div class="row py-2">
							<div class="row m-0 px-2 pb-2 justify-content-between ">
								<div class="p-0 " style="width: 450px;">
									<div class="row justify-content-start">
										<div class="" style="width: 130px;">Mata Pelajaran</div>:
										<div class="border-bottom border-dark" style="width: 320px;"></div>
									</div>
								</div>
								<div class="p-0 " style="width: 270px;">
									<div class="row justify-content-start">
										<div class="" style="width: 120px;">Sesi/Ruang</div>:
										<div class="border-bottom border-dark" style="width: 150px;"></div>
									</div>
								</div>
							</div>
							<div class="row m-0 px-2 pb-2 justify-content-between ">
								<div class="p-0 " style="width: 450px;">
									<div class="row justify-content-start">
										<div class="" style="width: 130px;">Hari Tanggal</div>:
										<div class="border-bottom border-dark" style="width: 320px;"></div>
									</div>
								</div>
								<div class="p-0 " style="width: 270px;">
									<div class="row justify-content-start">
										<div class="" style="width: 120px;">Pukul</div>:
										<div class="border-bottom border-dark" style="width: 150px;"></div>
									</div>
								</div>
							</div>
						</div>
						<table class="table table-sm table-bordered table-striped">
							<thead class="text-center align-text-top" style="background-color: #f7c745;">
								<th class="p-0" style="width: 7mm;">No.</th>
								<th class="p-0" style="width: 20mm;">No. Peserta</th>
								<th style="width: 55mm;">Nama</th>
								<th style="width: 45mm;">Tanda Tangan</th>
								<th class="p-0" style="width: 10mm;">Keterangan</th>
							</thead>
							<tbody>
								<?php


								$hal   = isset($ipg) ? (int)$ipg : 1;
								$awal = ($hal > 1) ? ($hal * $jml) - $jml : 0;

								$sql		= mysqli_query($koneksi, "SELECT * FROM cbt_peserta WHERE kd_kls = '$_POST[kls]' ORDER BY nm ASC LIMIT $awal, $jml");
								while ($data = mysqli_fetch_array($sql)) {
									if ($no % 2 === 0) {
										$tno = "text-center";
									} else {
										$tno = "text-start";
									}
									echo '
								<tr>
									<td align="center">' . $no . '.</td>
									<td align="center">' . $data['user'] . '</td>
									<td>' . $data['nm'] . '</td>
									<td class="' . $tno . '">' . $no . '.</td>
									<td></td>
								</tr>
								';
									$no++;
								}
								if ($ipg < $tot_page || $tot_page == "1") {
									for ($i = $no; $i <= ($jml * $ipg); $i++) {
										if ($no % 2 === 0) {
											$tno = "text-center";
										} else {
											$tno = "text-start";
										}
								?>

										<tr>
											<td align="center"><?php echo $no ?>.</td>
											<td></td>
											<td></td>
											<td class="<?php echo $tno ?>"><?php echo $no ?>.</td>
											<td></td>
										</tr>
								<?php $no++;
									}
								}
								?>
							</tbody>
						</table>
						<!-- Akhir Body -->
						<!-- TTD -->
						<div class="row justify-content-start gap-2 mx-2" style="font-size: small;">
							<div class="col-auto ">
								<div class="col ">
									<i>Keterangan:</i>
									<div>1. Daftar hadir dibuat rangkap 2(dua)<br>2. Pengawas ruang menyilang Nama Peserta yang tidak hadir.</div>
								</div>
								<div class="col "><br>
									<div class="row pb-1 border border-bottom-0 border-dark">
										<div class="col">Jumlah Peserta Hadir</div>
										<div class="col-auto">:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Orang</div>
									</div>
									<div class="row pb-1 border border-top-0 border-dark">
										<div class="col">Jumlah Peserta yang Tidak Hadir</div>
										<div class="col-auto">:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Orang</div>
									</div>
									<div class="row pb-1 border border-dark">
										<div class="col">Jumlah Peserta yang Seharusnya Hadir</div>
										<div class="col-auto">:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Orang</div>
									</div>
								</div>
							</div>
							<div class="col text-center "><br>Pengawas 1<br><br><br><br>
								<div class="text-start">(________________________)<br>NIP.</div>
							</div>
							<div class="col text-center "><br>Pengawas 2<br><br><br><br>
								<div class="text-start">(________________________)<br>NIP.</div>
							</div>
						</div>
						<!-- Akhir TTD -->
					</div>
					<div class="row justify-content-end" style="font-size: small;">
						<div class="col-auto">Halaman 1/<?php echo $tot_page ?></div>
					</div>
				</div>
			</div>
		</body>
<?php }
} ?>

</html>