<?php
include_once("../../config/server.php");
include_once("../../config/time_date.php");


$kds = $_GET['kds'];
$sqls_pg = (mysqli_query($koneksi, "SELECT * FROM cbt_soal WHERE kd_soal='$kds' AND jns_soal ='G' ORDER BY cbt_soal.no_soal ASC"));
$sqls_es = (mysqli_query($koneksi, "SELECT * FROM cbt_soal WHERE kd_soal='$kds' AND jns_soal ='E' ORDER BY cbt_soal.no_soal ASC"));
$pkts = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM cbt_pktsoal WHERE kd_soal='$kds';"));
$mpel = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM mapel WHERE kd_mpel='$pkts[kd_mpel]';"));

if ($pkts['kd_kls'] == "1") {
	$kd_kls = "Semua_";
} else {
	$kd_kls = "Kode (" . $pkts['kd_kls'] . ")_";
}
if ($pkts['kls'] == "1") {
	$kls = "Semua";
} else {
	$kls = $pkts['kls'];
}
if ($pkts['jur'] == "1") {
	$jur = "Semua";
} else {
	$jur = $pkts['jur'];
}

?>

<link rel="shortcut icon" href="../../img/fav.png" type="image/x-icon">
<link rel="stylesheet" href="../../vendor/twbs/bootstrap/dist/css/bootstrap.min.css">
<script src="../../vendor/twbs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<!-- <link rel="stylesheet" href="../../img/icon/css/all.css"> -->
<link rel="stylesheet" href="page_soal.css">
<!-- <link rel="stylesheet" href="cetak.min.css"> -->
<style>
	p {
		line-height: 16px;
	}

	.pb2 {
		border-bottom-style: double;
		padding-bottom: 3px;
	}

	.pgh {
		line-height: 16px;
	}

	.pgs {
		line-height: 34px;
	}

	table tr td {
		padding: 0 !important;
	}
</style>

<body>
	<div class="page mb-5">
		<!-- Head -->
		<div class="kop">
			<div class="row kop-fons mx-0 justify-content-center">
				<div class="col-auto">
					<img src="../../img/<?php if ($inf_lgdns != null) {
																echo $inf_lgdns;
															} else {
																echo "tut.png";
															} ?>" alt="" srcset="" class="rounded" style='max-width:80px; max-height:100px;'>
				</div>
				<div class="col-auto fon16 text-center">
					<div class="fs-5 pgh fw-semibold"><?php if ($inf_head != null) {
																							echo $inf_head;
																						} else {
																							echo "TES BERBASIS KOMPUTER TINGKAT SMA/SMK/MA";
																						} ?></div>
					<div class="fs-2 pgs"><?php if ($inf_nm != null) {
																	echo $inf_nm;
																} else {
																	echo "SMA/SMK/MA";
																} ?></div>
					<div class="fs-6 pgh fw-semibold"><?php if ($inf_head2 != null) {
																							echo $inf_head2;
																						} else {
																							echo "SOAL UJIAN SEKOLAH BERBASIS TEKNOLOGI INFORMASI";
																						} ?></div>
				</div>
				<div class="col-auto">
					<img src="../../img/<?php if ($inf_fav != null) {
																echo "$inf_fav";
															} else {
																echo "fav.png";
															} ?>" alt="" srcset="" class="rounded" style='max-width:80px; max-height:100px;'>
				</div>
			</div>
			<div class="row text-center fon12">
				<p class="pb2">Alamat : <?php if ($inf_almt != null) {
																	echo $inf_almt;
																} else {
																	echo "Jalan Martapura Lama Desa Penggalaman RT. 001/0 Kecamatan Martapura Barat Kabupaten Banjar Kalimantan Selatan <i class='fa fa-phone'></i>(0811) 5176176 Email : smassta@gmail.com";
																} ?></p>
			</div>
		</div>
		<!-- Akhir Head -->
		<!-- Body -->
		<div class="pb2 mb-4 pb-2 text-nowrap">
			<div class="row m-0 px-2 pb-2 justify-content-between ">
				<div class="p-0 " style="width: 450px;">
					<div class="row justify-content-start">
						<div class="" style="width: 130px;">Mata Pelajaran</div>:
						<div class="border-bottom border-dark" style="width: 320px;"><?php echo substr($mpel['nm_mpel'], 0, 40);
																																					if (strlen($mpel['nm_mpel'] > 40)) echo '...'; ?></div>
					</div>
				</div>
				<div class="p-0 " style="width: 270px;">
					<div class="row justify-content-start">
						<div class="" style="width: 120px;">Kode Soal</div>:
						<div class="border-bottom border-dark" style="width: 150px;"><?php echo $kds ?></div>
					</div>
				</div>
			</div>
			<div class="row m-0 px-2 pb-2 justify-content-between ">
				<div class="p-0 " style="width: 450px;">
					<div class="row justify-content-start">
						<div class="" style="width: 130px;">Kelas</div>:
						<div class="border-bottom border-dark" style="width: 320px;"><?php echo $kd_kls . $kls ?></div>
					</div>
				</div>
				<div class="p-0 " style="width: 270px;">
					<div class="row justify-content-start">
						<div class="" style="width: 120px;">Jurusan</div>:
						<div class="border-bottom border-dark" style="width: 150px;"><?php echo $jur ?></div>
					</div>
				</div>
			</div>
			<div class="row m-0 px-2 pb-2 justify-content-between ">
				<div class="p-0 " style="width: 450px;">
					<div class="row justify-content-start">
						<div class="" style="width: 130px;">Pembuat Soal</div>:
						<div class="border-bottom border-dark" style="width: 320px;"><?php echo $pkts['author'] ?></div>
					</div>
				</div>
				<div class="p-0 " style="width: 270px;">
					<div class="row justify-content-start">
						<div class="" style="width: 120px;">Tanggal Buat</div>:
						<div class="border-bottom border-dark" style="width: 150px;"><?php echo tgl($pkts['tgl']) ?></div>
					</div>
				</div>
			</div>
		</div>
		<!-- Soal -->
		<?php
		if (mysqli_num_rows($sqls_pg) != "0") {
			$no = 1;
			if (mysqli_num_rows($sqls_es) != "0") {
				echo '<div class="px-3 text-decoration-underline fw-semibold">Soal Pilihan Ganda :</div>';
			}
			while ($dts = mysqli_fetch_array($sqls_pg)) {
		?>
				<div class="row px-2 mx-2 my-4">
					<table class="">
						<?php if(!empty($dts['cerita'])||$dts['kd_crta'] != 0){ ?>
						<tr style="page-break-after: auto;" valign="top">
							<?php if (!empty($dts['cerita'])) {
								echo "<td colspan='3' class='cerita' ><u class='fw-semibold'>Perhatikan Teks Berikut!</u><br>$dts[cerita]</td>";
							} elseif ($dts['kd_crta'] != 0) {
								$kd_crt		= mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM cbt_soal WHERE no_soal ='$dts[kd_crta]' AND kd_soal ='$kds'"));
								echo "<td colspan='3' class='cerita' ><u class='fw-semibold'>Perhatikan Teks Berikut!</u><br>$kd_crt[cerita]</td>";
							} ?>
						</tr>
						<?php } ?>
						<tr>
							<td rowspan="3" style="width: 1cm;" valign="top" align="center">
								<p><?php echo $no . "." ?></p>
							</td>
						</tr>
						<tr><?php
								if (!empty($dts['img'])) {
									if (file_exists("../../images/$dts[img]")) {
										echo "<td colspan='3'><img src='../../images/$dts[img]' style='max-width: 250px;'></td>";
									} else {
										echo '<td class="text-bg-danger fst-italic" style="min-width: 170px;"> <p>Belum Upload Gambar</p> </td>';
									}
								} ?></tr>
						<tr>
							<td valign="top" colspan="3"><?php echo $dts['tanya'] ?></td>
						</tr>
					</table>
					<!-- Opsi Jawaban -->
					<?php if ($dts["jns_soal"] == "G") { ?>
						<table>
							<tr>
								<td valign="top" align="center" style="width: 1cm;"><?php if ($dts['knci_pilgan'] == "1") {
																																			echo '<img src="../../img/benar.png" style="width: 21px;">';
																																		} ?></td>
								<td valign="top" align="center" style="width: 20px;">
									<p>A.</p>
								</td>

								<?php if (!empty($dts['img1'])) {
									echo '<td style="max-width: 182px; width: 0;">';
									if (file_exists("../../images/$dts[img1]")) {
										echo "<img src='../../images/$dts[img1]' style='max-width: 150px;' class='me-2 mb-1'></td>";
									} else {
										echo '<div class="text-bg-danger fst-italic" style="min-width: 170px;"> <p>Belum Upload Gambar</p> </div></td>';
									}
								} ?>
								<!-- &nbsp;&nbsp;&nbsp; -->
								<!-- </td> -->
								<td valign="top" colspan="2" style="text-align: justify;"><?php echo $dts['jwb1'] ?>
							</tr>
							<tr>
								<td valign="top" align="center" style="width: 1cm;"><?php if ($dts['knci_pilgan'] == "2") {
																																			echo '<img src="../../img/benar.png" style="width: 21px;">';
																																		} ?></td>
								<td valign="top" align="center">
									<p>B.</p>
								</td>
								<?php if (!empty($dts['img2'])) {
									echo '<td style="max-width: 182px; width: 0;">';
									if (file_exists("../../images/$dts[img2]")) {
										echo "<img src='../../images/$dts[img2]' style='max-width: 150px;'></td>";
									} else {
										echo '<div class="text-bg-danger fst-italic" style="min-width: 170px;"> <p>Belum Upload Gambar</p> </div></td>';
									}
								} ?>
								<td valign="top" colspan="2" style="text-align: justify;"><?php echo $dts['jwb2'] ?></td>
							</tr>
							<tr>
								<td valign="top" align="center" style="width: 1cm;"><?php if ($dts['knci_pilgan'] == "3") {
																																			echo '<img src="../../img/benar.png" style="width: 21px;">';
																																		} ?></td>
								<td valign="top" align="center">
									<p>C.</p>
								</td>
								<?php if (!empty($dts['img3'])) {
									echo '<td style="max-width: 182px; width: 0;">';
									if (file_exists("../../images/$dts[img3]")) {
										echo "<img src='../../images/$dts[img3]' style='max-width: 150px;'></td>";
									} else {
										echo '<div class="text-bg-danger fst-italic" style="min-width: 170px;"> <p>Belum Upload Gambar</p> </div></td>';
									}
								} ?>
								<td valign="top" colspan="2" style="text-align: justify;"><?php echo $dts['jwb3'] ?></td>
							</tr>
							<tr>
								<td valign="top" align="center" style="width: 1cm;"><?php if ($dts['knci_pilgan'] == "4") {
																																			echo '<img src="../../img/benar.png" style="width: 21px;">';
																																		} ?></td>
								<td valign="top" align="center">
									<p>D.</p>
								</td>
								<?php if (!empty($dts['img4'])) {
									echo '<td style="max-width: 182px; width: 0;">';
									if (file_exists("../../images/$dts[img4]")) {
										echo "<img src='../../images/$dts[img4]' style='max-width: 150px;'></td>";
									} else {
										echo '<div class="text-bg-danger fst-italic" style="min-width: 170px;"> <p>Belum Upload Gambar</p> </div></td>';
									}
								} ?>
								<td valign="top" colspan="2" style="text-align: justify;"><?php echo $dts['jwb4'] ?></td>
							</tr>
							<tr>
								<td valign="top" align="center" style="width: 1cm;"><?php if ($dts['knci_pilgan'] == "5") {
																																			echo '<img src="../../img/benar.png" style="width: 21px;">';
																																		} ?></td>
								<td valign="top" align="center">
									<p>E.</p>
								</td>
								<?php if (!empty($dts['img5'])) {
									echo '<td style="max-width: 182px; width: 0;">';
									if (file_exists("../../images/$dts[img5]")) {
										echo "<img src='../../images/$dts[img5]' style='max-width: 150px;'></td>";
									} else {
										echo '<div class="text-bg-danger fst-italic" style="min-width: 170px;"> <p>Belum Upload Gambar</p> </div></td>';
									}
								} ?>
								<td valign="top" colspan="2" style="text-align: justify;"><?php echo $dts['jwb5'] ?></td>
							</tr>
						</table>
					<?php } ?>
				</div>
			<?php $no++;
			}
		}
		if (mysqli_num_rows($sqls_es) != "0") {
			$noe = 1;
			echo '<div class="px-3 text-decoration-underline fw-semibold">Soal Esai :</div>';
			while ($dts = mysqli_fetch_array($sqls_es)) {
			?>
				<div class="row px-2 ms-0 me-4 my-2">
					<table class="">

						<?php if (!empty($dts['cerita'])) {
							echo "<tr style='page-break-after: auto;'><td colspan='3' class='cerita' >$dts[cerita]</td></tr>";
						} elseif ($dts['kd_crta'] != 0) {
							$kd_crt		= mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM cbt_soal WHERE no_soal ='$dts[kd_crta]' AND kd_soal ='$kds'"));
							echo "<tr style='page-break-after: auto;'><td colspan='3' class='cerita' >$kd_crt[cerita]</td></tr>";
						}
						?>

						<tr>
							<td rowspan="3" style="width: 1cm;" valign="top" align="center">
								<p><?php echo $noe . "." ?></p>
							</td>
						</tr>

						<?php
						if (!empty($dts['img'])) {
							if (file_exists("../../images/$dts[img]")) {
								echo "<tr><td colspan='3'><img src='../../images/$dts[img]' style='max-width: 250px;'></td></tr>";
							} else {
								echo '<tr><td class="text-bg-danger fst-italic" style="min-width: 170px;"> <p>Belum Upload Gambar</p> </td></tr>';
							}
						}
						// if (!empty($dts['img'])) {
						// 	echo "<td colspan='3'><img src='../../images/$dts[img]' style='max-width: 250px;'></td>";
						// } 
						?>
						<tr>
							<td valign="top" colspan="3"><?php echo $dts['tanya'] ?></td>
						</tr>
					</table>
				</div>
		<?php $noe++;
			}
		} ?>
		<!-- Akhir Soal -->
		<div class="row gap-1 justify-content-center mt-5">
			<div class="col-auto border border-dark px-2 mx-0 my-3">&nbsp;</div>
			<div class="col-11 border border-dark px-2 mx-0 my-3 text-uppercase fw-semibold text-center">
				<?php
				echo $inf_nm
				?>
			</div>
			<div class="col-auto border border-dark px-2 mx-0 my-3 ">&nbsp;</div>
		</div>
		<!-- Akhir Body -->
	</div>
</body>

<!-- Format gambar text -->
<script type="text/javascript">
	function resetAndAddStyle(className, newStyle) {
		const elements = document.querySelectorAll(`.${className}`);
		elements.forEach(element => {
			// element.removeAttribute('style'); // Hapus atribut style
			element.setAttribute('style', newStyle); // Tambahkan atribut style baru
		});
	}

	resetAndAddStyle('image_resized', 'width:auto;max-height:15cm;');
</script>

<script>
	window.print();
</script>