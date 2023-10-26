<?php
include_once("../../config/server.php");
error_reporting(0); //hide error


?>
<html>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="shortcut icon" href="../../img/fav.png" type="image/x-icon">
<link rel="stylesheet" href="../../vendor/twbs/bootstrap/dist/css/bootstrap.min.css">
<script src="../../vendor/twbs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<?php if ($_POST['page'] == "") { ?>
	<link rel="stylesheet" href="page_kartu.css">
<?php } else if ($_POST['page'] == "1") { ?>
	<link rel="stylesheet" href="page_kartu.css">
<?php } else if ($_POST['page'] == "2") { ?>
	<link rel="stylesheet" href="page_kartu-f4.css">
<?php } ?>
<style>
	p {
		line-height: 16px;
	}

	.pb2 {
		border-bottom-style: double;
	}

	.pgh {
		line-height: 16px;
	}

	.pgs {
		line-height: 34px;
	}

	.page {
		max-height: 330mm;
		margin-bottom: 10mm;
	}

	.brd {
		width: 9.7cm;
		height: 6.8cm;
	}

	.dt {
		font-size: 15px;
		font-family: 'Times New Roman', Times, serif;
	}

	.ttd {
		font-size: 13px;
		font-family: 'Times New Roman', Times, serif;
	}

	tr td {
		padding: 0;
		padding-left: 5px;

	}

	tr td img {
		width: 65px;
		height: 85px;
		padding: 5px;
		border-image: auto;
	}

	.img-ttd {
		position: absolute;
		margin-left: 45px;
		width: auto;
		height: 78px;
	}

	td {
		vertical-align: top;
	}

	.qr {
		width: 80px;
		height: 80px;
	}

	/* @media print {
		.page {
			margin-left: -135px;
			margin-right: -140px;
		}
	} */

	/* table,th,td {
		border: 1px solid black;
		border-collapse: collapse;
	} */
</style>

<body>
	<div class="container pb-2">
		<?php
		$batas = 8;
		$ttd = $_POST['ttd'];
		$qrc = $_POST['qrc'];
		$kls = $_POST['kls'];
		$crnm = $_POST['crnm'];

		if (empty($ttd)) {
			$ttd = 0;
		}
		if ($kls == "" && $crnm == "") {
			// echo "kosong - lev=" .$levc." kls=".$klsc." jur=".$jurc;
			$cr = "";
		} elseif ($kls == "1" && $crnm == "") {
			// echo "kosong - lev=" .$levc." kls=".$klsc." jur=".$jurc;
			$cr = "";
		} elseif ($kls != "" && $crnm == "") {
			// echo "WHERE " .$levc." ".$klsc." ".$jurc;
			$cr = "WHERE  kd_kls = '" . $kls . "' ";
		}
		if ($kls == "1" && $crnm != "") {
			// echo "kosong - lev=" .$levc." kls=".$klsc." jur=".$jurc;
			$cr = " WHERE nm LIKE '%" . $crnm . "%'";
		} elseif ($kls != "" && $crnm != "") {
			// echo "WHERE " .$levc." ".$klsc." ".$jurc;
			$cr = "WHERE kd_kls = '" . $kls . "' AND nm = '" . $crnm . "' ";
		}
		// echo $cr;
		$jml = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM cbt_peserta $cr"));
		$jmlpg = ceil($jml / $batas);
		for ($i = 0; $i < $jmlpg; $i++) {
			$page = $i * $batas;
			$qrs = mysqli_query($koneksi, "SELECT * FROM cbt_peserta $cr  limit $page,$batas");
			// $qrs = mysqli_query($koneksi, "SELECT * FROM cbt_peserta limit $page,$batas");
		?>
			<div class="page">
				<!-- Body -->
				<div class="isi">
					<div class="row g-3">
						<?php
						while ($dt = mysqli_fetch_array($qrs)) {
						?>
							<div class="col-6">
								<div class="border border-dark brd">
									<div class="row border-bottom m-0 border-dark">
										<div class="col-auto p-0 "><img src="../../img/tut.png" alt="" srcset="" style="width: 3rem;"></div>
										<div class="col p-0 ">
											<div class="row text-center">
												<div class="fs-6 fw-semibold pgh">KARTU PESERTA</div>
											</div>
											<div class="row text-center">
												<div class="fs-6 fw-semibold pgh">
													TES BERBASIS APLIKASI
												</div>
											</div>
											<!-- <div class="row text-center">
											<div class="col fon8 fw-semibold pgh" style="font-size: 0.7vw;">
												<?php if ($inf_head != null) {
													echo $inf_head;
												} else {
													echo "TES BERBASIS KOMPUTER TINGKAT SMA/SMK/MA";
												} ?>
											</div>
										</div> -->
											<div class="row text-center">
												<div class="fs-6 fw-semibold pgh"><?php echo $inf_nm ?></div>
											</div>
										</div>
										<div class="col-auto p-0 "><img src="../../img/fav.png" alt="" srcset="" style="width: 3rem;"></div>
									</div>
									<div class="row m-0 p-1">
										<table class="dt">
											<tr>
												<td rowspan="5" style="width: 70px" class="text-center">
													<img src="<?php if (empty($dt['ft'])) {
																			echo '../../img/noavatar.png';
																		} elseif (file_exists("../../pic_sis/$dt[ft]")) {
																			echo "../../pic_sis/$dt[ft]";
																		} else {
																			echo '../../img/noavatar.png';
																		} ?>" class="">
												</td>
												<td style="width: 2.8cm; height: 1cm;">Nama Peserta</td>
												<td style="width: 0;">:</td>
												<td colspan="2" style="text-transform: capitalize;"><?php echo $dt['nm'] ?></td>
											</tr>
											<tr>
												<td>Kelas (Jurusan)</td>
												<td>:</td>
												<td colspan="2">
													<?php
													$qrkls = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM kelas WHERE kd_kls='$dt[kd_kls]';"));
													echo $qrkls['kls'] . '_' . $qrkls['kd_kls'] . ' (' . $qrkls['jur'] . ')';
													?>
												</td>
											</tr>
											<tr>
												<td>Username</td>
												<td>:</td>
												<td class="fw-semibold"><?php echo $dt['user'] ?></td>
											</tr>
											<tr>
												<td>Password</td>
												<td>:</td>
												<td class="fw-semibold"><?php echo $dt['pass'] ?></td>
											</tr>
											<tr>
												<td>Sesi-Ruang</td>
												<td>:</td>
												<td><?php echo $dt['sesi'] . '-' . $dt['ruang'] ?></td>
											</tr>
										</table>
									</div>
									<div class="row m-0">
										<div class="qr" style="width: 30%;">
											<?php
											if ($qrc != 0) {
												include_once("../../aset/phpqrcode/qrlib.php");
												// nama folder tempat folder_qr file qrcode
												$folder_qr = "../page/media/qr/";

												// membuat folder dengan nama "temp"
												if (!file_exists($folder_qr))
													mkdir($folder_qr);

												$link = urlencode(base64_encode($dt['user']));
												$link2 = urlencode(base64_encode($dt['pass']));

												$dfl = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM svr WHERE id_sv ='$inf[id_sv]'"));
												if ($dfl['ip_sv'] == $dt['ip_sv']) {
													$fdr = $dfl['fdr'];
												} else {
													$fdr = "tbk";
												}

												// isi qrcode yang ingin dibuat. akan muncul saat di scan
												$isi = "http://" . $dt['ip_sv'] . "/" . $fdr . "/?du=" . $link . "&dp=" . $link2;
												$qrnm = $dt['nm'] . "_" . $dt['user'];

												// perintah untuk membuat qrcode dan menyimpannya dalam folder temp
												QRcode::png($isi, $folder_qr . $qrnm . ".png", QR_ECLEVEL_M, 4, 1);

												// menampilkan qrcode 
												echo '<img src="' . $folder_qr . $qrnm . '.png" class="qr">';
											}
											?>
										</div>
										<div class="col mt-2" style="width: 70%; font-size: 12px;">
											<?php if ($ttd != 0) echo '<img src="../../img/ttd ibu elly.png" class="img-ttd">' ?>
											<div class="col text-center pb-3"><?php echo $inf_nm ?></div>
											<div class="col text-center pt-2"><?php echo $inf_kpn ?></div>
										</div>
									</div>
								</div>
							</div>
						<?php } ?>
					</div>
				</div>
				<!-- Akhir Body -->
			</div>
		<?php } ?>
	</div>
</body>

</html>