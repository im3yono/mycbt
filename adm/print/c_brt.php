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
	$jml = 24;
} elseif ($_POST['page'] == "1") {
	$pg = "A4";
	$sw = "210";
	$sh = "297";
	$jml = 24;
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

	.pgh {
		line-height: 16px;
	}

	.pgs {
		line-height: 1.2;
	}

	.pgh,
	.pgs,
	h5 {
		font-family: 'Times New Roman', Times, serif;
	}
</style>
<?php
if (empty($_POST['kls'])) {
?>
	<!-- <div class="col-12 text-center py-5"><i class="bg-danger-subtle p-2" style="border-radius: 5px;">Tentukan Data Kelas</i></div> -->

	<body class="bg-secondary-subtle">
		<div class="">
			<div class="page">
				<div class="isi">
					<!-- HEAD -->
					<div class="row justify-content-between text-uppercase mt-4 px-2" style="border-bottom-style: double;padding-bottom: 3px;">
						<div class="col-auto text-center p-0">
							<img src="../../img/<?= ($inf_lgdns != null) ? $inf_lgdns : "tut.png"; ?>" alt="" srcset="" class="rounded" style='max-width:80px; max-height:100px;'>
						</div>
						<div class="col-auto text-center">
							<div class="fs-5 pgh fw-semibold pt-1"><?= ($inf_head != null) ? $inf_head : " TES BERBASIS KOMPUTER"; ?></div>
							<div class="pgs" style="max-width: 15cm; font-size: 27px;"><?= ($inf_nm != null) ? $inf_nm : "SMA/SMK/MA";  ?></div>
							<div class="fs-5 pgh fw-semibold"> <?= empty($inf_head2) ? $inf_ta : $inf_head2 ?></div>
						</div>
						<div class="col-auto text-center p-0" style="filter: grayscale(100%) contrast(200%);">
							<img src="../../img/<?= ($inf_fav != null) ? "$inf_fav" : "fav.png"; ?>" alt="" srcset="" class="rounded" style='max-width:80px; max-height:100px;'>
						</div>
					</div>
					<!-- Akhir HEAD -->
					<!-- Body -->
					<div class="row py-3 mt-4 mx-3">
						<h5 class="text-center fw-semibold mb-4">BERITA ACARA PELAKSANAAN</h5>
						<div class="col-12 border px-2 py-4 justify-content-between ">
							<?php $tgl = tgl_hari(date('D'));
							// Misal tgl_hari(date('D')) menghasilkan "Senin, 10 Juni 2024"
							$parts = explode(',', $tgl);
							$hari = isset($parts[0]) ? trim($parts[0]) : '..................';
							$tanggal_bulan_tahun = isset($parts[1]) ? trim($parts[1]) : '';
							// Pisahkan tanggal, bulan, tahun jika formatnya "10 Juni 2024"
							$tgl_parts = explode(' ', $tanggal_bulan_tahun);
							$tgl = isset($tgl_parts[0]) ? $tgl_parts[0] : '..................';
							$bln = isset($tgl_parts[1]) ? $tgl_parts[1] : '..................';
							$thn = isset($tgl_parts[2]) ? $tgl_parts[2] : '..................';
							?>
							<p style="text-align: justify;">
								Pada hari ini <b><?= $hari; ?></b>, tanggal <b><?= $tgl; ?></b> bulan <b><?= $bln; ?></b> tahun <b><?= $thn; ?></b>, telah diselenggarakan Penilaian Akhir Semester Genap, Kelas .................. bertempat di <?= $inf_nm; ?> dengan Mata Pelajaran : .................. dari pukul : .................. sampai dengan pukul ..................
							</p>

							<p class="my-4">
							<table>
								<tr>
									<td>1.</td>
									<td style="width: 7cm;">Ruang</td>
									<td style="width: 5mm;">:</td>
									<td>............................................................</td>
								</tr>
								<tr>
									<td></td>
									<td>Jumlah Peserta Seharusnya</td>
									<td>:</td>
									<td>............................................................</td>
								</tr>
								<tr>
									<td></td>
									<td>umlah Hadir/Ikut Ujian</td>
									<td>:</td>
									<td>............................................................</td>
								</tr>
								<tr>
									<td></td>
									<td>Jumlah Tidak Hadir</td>
									<td>:</td>
									<td>............................................................</td>
								</tr>
								<tr>
									<td></td>
									<td>Yakni Nomor</td>
									<td>:</td>
									<td>............................................................</td>
								</tr>
							</table>
							<br>
							<tr>
								<td>2.</td>
								<td style="width: 7cm;">Catatan selama pelaksanaan ujian</td>
								<td style="width: 5mm;">:</td>
								<td>..................................................................... <br>
									....................................................................................................................................................................................................... <br>
									....................................................................................................................................................................................................... <br>
									....................................................................................................................................................................................................... <br>
									....................................................................................................................................................................................................... <br>
								</td>
							</tr>
							</p>

							<p>
								Berita acara ini dibuat dengan sesungguhnya untuk dapat dipergunakan sebagaimana mestinya. <br>
							</p>
						</div>
					</div>
					<!-- Akhir Body -->
					<!-- TTD -->
					<div class="row my-3">
						<div class="col-12 text-center fw-semibold">Yang membuat berita acara :</div>
					</div>
					<div class="row justify-content-start g-2 ms-5 me-2" style="font-size: small;">

						<!-- <div class="col ">Proktor<br><br><br><br>
							<div class="">( ________________________ )<br>NIP.</div>
						</div> -->
						<div class="col ms-5">Pengawas 1<br><br><br><br>
							<div class="">( ________________________ )<br>NIP.</div>
						</div>
						<div class="col ms-5">Pengawas 2<br><br><br><br>
							<div class="">( ________________________ )<br>NIP.</div>
						</div>
					</div>
					<!-- Akhir TTD -->
				</div>
				<!-- <div class="row justify-content-end" style="font-size: small;">
						<div class="col-auto">Halaman 1/2</div>
					</div> -->
			</div>
		</div>
	</body>
<?php
} ?>

</html>