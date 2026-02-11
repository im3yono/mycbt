<?php
include_once("../../config/server.php");
// error_reporting(0); //hide error


?>
<html>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="shortcut icon" href="../../img/fav.png" type="image/x-icon">
<link rel="stylesheet" href="../../vendor/twbs/bootstrap/dist/css/bootstrap.min.css">
<script src="../../vendor/twbs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<?php if (isset($_POST['page']) == "") { ?>
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
		margin-left: 25px;
		width: auto;
		height: 85px;
		padding: 0;
		/* margin-top: 0px;
		border: 2px solid; */
	}

	td {
		vertical-align: top;
	}

	.qr {
		position: relative;
		width: 70px;
		height: 70px;
		top: -1mm;
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


	.img-abu {
		/* -webkit-filter: grayscale(100%); */
		/* Safari 6.0 - 9.0 */
		/* filter: grayscale(100%); */
		filter: grayscale(100%) contrast(200%);

	}
</style>

<body class="bg-secondary-subtle">
	<div class="m-0 p-0">
		<?php
		$batas = 8;
		$jmlpg = 1;
		$ttd = $_POST['ttd'] ?? '';
		$qrc = $_POST['qrc'] ?? '';
		$kls = $_POST['kls'] ?? '0';
		$crnm = $_POST['crnm'] ?? '';

		if (empty($ttd)) {
			$ttd = 0;
		}
		if ($kls != "0" && $kls != "") {
			$cr = "";
			if ($kls != "") {
				if ($kls == "1") {
					$cr = "";
				} else {
					$cr = "WHERE kd_kls = '" . $kls . "'";
				}
				if ($crnm != "") {
					if ($kls == "1") {
						$cr = "WHERE nm LIKE '%" . $crnm . "%'";
					} else {
						$cr .= " AND nm LIKE '%" . $crnm . "%'";
					}
				}
			} elseif ($crnm != "") {
				$cr = "WHERE nm LIKE '%" . $crnm . "%'";
			}
			$jml = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM cbt_peserta $cr"));
			$jmlpg = ceil($jml / $batas);
		}
		for ($i = 0; $i < $jmlpg; $i++) {
			$page = $i * $batas;
			// $qrs = mysqli_query($koneksi, "SELECT * FROM cbt_peserta limit $page,$batas");
		?>
			<div class="page ">
				<!-- Body -->
				<!-- <div class="isi"> -->
				<div class="row g-4">
					<?php
					if ($kls == "0") {
						echo '<p>Silahkan pilih kelas terlebih dahulu.</p>';
					} else {
						$qrs = mysqli_query($koneksi, "SELECT * FROM cbt_peserta $cr  limit $page,$batas");
						while ($dt = mysqli_fetch_array($qrs)) {
					?>
							<div class="col-6">
								<div class="border border-dark brd">
									<!-- KOP -->
									<div class="row justify-content-between border-bottom m-0 border-dark">
										<!-- <div class="col-auto p-0 "><img src="../../img/tut.png" alt="" srcset="" style="width: 3rem;"></div> -->
										<div class="col-auto p-0 img-abu"><img src="../../img/<?= $inf_fav != "" ? $inf_fav : "fav.png" ?>" alt="" srcset="" style="width: 3rem;"></div>
										<div class="col p-0 " style="font-size: 12px;">
											<div class="row text-center">
												<div class="fw-bold pgh text-uppercase">KARTU PESERTA
												</div>
											</div>
											<div class="row text-center ">
												<div class="fw-semibold pgh text-uppercase">
													<?= ($inf_head != null) ? $inf_head : " TES BERBASIS KOMPUTER"; ?>
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
											<div class="row text-center text-uppercase">
												<div class="fw-semibold pgh"><?= $inf_nm ?></div>
											</div>
										</div>
									</div>

									<div class="row m-0 p-1">
										<table class="dt">
											<tr>
												<!-- IMG -->
												<td rowspan="6" style="width: 70px" class="text-center">
													<img src="<?php if (empty($dt['ft'])) {
																			echo '../../img/noavatar.png';
																		} elseif (file_exists("../../pic_sis/$dt[ft]")) {
																			echo "../../pic_sis/$dt[ft]";
																		} else {
																			echo '../../img/noavatar.png';
																		} ?>" class="">
												</td>
												<td style="width: 2.8cm; height: 1cm;">Nama</td>
												<td style="width: 0;">:</td>
												<td colspan="2" style="text-transform: capitalize;"><?= singkatNama($dt['nm']) ?></td>
											</tr>
											<tr>
												<td>NISN/NIS</td>
												<td>:</td>
												<td class=""><?= $dt['nis'] ?></td>
											</tr>
											<tr>
												<td>Kelas (Jurusan)</td>
												<td>:</td>
												<td colspan="2">
													<?php
													$qrkls = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM kelas WHERE kd_kls='$dt[kd_kls]';"));
													// echo $qrkls['kls'] . ' (' . $qrkls['nm_kls'] . '_' . $qrkls['jur'] . ')';
													echo ($qrkls['nm_kls']??'') . ' (' . ($qrkls['jur']??'') . ')';
													?>
												</td>
											</tr>
											<!-- <tr>
												<td>Nama Pengguna</td>
												<td>:</td>
												<td class="fw-semibold"><?= $dt['user'] ?></td>
											</tr> -->
											<tr>
												<td>Link Ujian</td>
												<td>:</td>
												<td class="fw-semibold"><?= $dt['ip_sv']??''; ?></td>
											</tr>
											<!-- <tr>
												<td>Sesi</td>
												<td>:</td>
												<td><?= $dt['sesi'] ?></td>
											</tr> -->
										</table>
									</div>
									<!-- TTD -->
									<div class="row m-0 mt-2">
										<div class="col mt-0" style="width: 70%; font-size: 12px;">
											<?php
											if ($ttd == $inf_kep) {
												$ttd_ok = $inf_ttdp;
												$jd = 'Kepala';
											} else {
												$ttd_ok = $inf_ttdk;
												$jd = 'Ketua Panitia';
											}
											if ($ttd != 0 && !empty($ttd_ok)) echo '<img src="../../img/' . $ttd_ok . '" class="img-ttd">' ?>
											<div class="col text-center" style="margin-bottom: -7px;"><?= $jd ?></div>
											<div class="col text-center pb-4"><?= $inf_nm ?></div>
											<div class="col text-center pt-2"><?= $ttd == 0 ? '( _____________________ )' : $ttd ?></div>
										</div>
										<div class="col-auto border bg-dark-subtle p-0 text-center" style="width: 30%;">
											<div class="display-3">R<?= $dt['ruang']  ?></div>
										</div>
										<!-- <div class="qr" style="width: 27%;">
											<?php
											if ($qrc == 1 && $kls != 0) {
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

												if (!$dfl) {
													die("Gagal mengambil data server.");
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
										</div> -->
									</div>
								</div>
							</div>
					<?php }
					} ?>
				</div>
				<!-- </div> -->
				<!-- Akhir Body -->
			</div>
		<?php } ?>
	</div>
</body>

</html>