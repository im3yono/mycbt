<?php
include_once("../../config/server.php");
// error_reporting(0); //hide error

if (!empty($_POST['kds'])) {
	$dt = explode(",", $_POST['kds']);
	$kds = $dt[0];
	$token = $dt[1];
	// $kd_kls = $_POST['kls'];
	$qr_no = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM cbt_pktsoal WHERE kd_soal ='$kds'"));
	if ($qr_no['kd_kls'] == "1") {
		if ($qr_no['kls'] == "1") {
			$kls = 'Semua ' . '(' . $qr_no['jur'] . ')';
		} else {
			$kls = $qr_no['kls'] . " (" . $qr_no['jur'] . ')';
		}
	} else {
		$nm_kls = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM kelas WHERE kd_kls ='$qr_no[kd_kls]'"));
		$kls = $nm_kls['nm_kls'];
	}

	$qr_mpel = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM mapel WHERE kd_mpel ='$qr_no[kd_mpel]'"));
	$jml_soal = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM cbt_soal WHERE kd_soal = '$kds';"));



?>


	<html lang="en">

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="../../vendor/twbs/bootstrap/dist/css/bootstrap.min.css">
		<script src="../../vendor/twbs/bootstrap/dist/js/bootstrap.min.js"></script>
		<link rel="stylesheet" href="../../vendor/twbs/bootstrap-icons/font/bootstrap-icons.min.css">
	</head>

	<body>
		<table class="table table-borderless">
			<tr>
				<td style="width: 5cm;">Nama Mapel</td>
				<td class="fw-bold">: <?php echo $qr_mpel['nm_mpel'] ?></td>
				<td style="width: 4cm;"><?= ($_POST['ket'] == 2) ? 'KKM':'' ?></td>
				<td class="fw-bold" style="width: 7cm;"><?= ($_POST['ket'] == 2) ? ': '.$qr_no['kkm'] :'' ?></td>
				<td rowspan="4" valign="middle" class="text-center">
					<a href="dwn_analisa.php?kds=<?= $kds ?>&tkn=<?= $token ?>&ket=<?= $_POST['ket']; ?>" class="btn btn-outline-primary btn-lg fw-bold">Download</a>
				</td>
			</tr>
			<tr>
				<td>Nama Pembuat Soal</td>
				<td>: <?php echo $qr_no['author'] ?></td>
				<td>Kelas</td>
				<td>: <?php echo $kls ?></td>
			</tr>
			<tr>
				<td>Bobot Nilai</td>
				<td class="fw-bold">: Pilgan =<?php echo $qr_no['prsen_pilgan'] . '%, Esai =' . $qr_no['prsen_esai'] . '%' ?></td>
				<td>Jumlah Soal</td>
				<td class="fw-bold">: <?php echo $jml_soal . " di gunakan " . $qr_no['pilgan'] + $qr_no['esai'] ?> soal</td>
				<!-- <td class="fw-bold">: <?php echo $qr_no['pilgan'] + $qr_no['esai'] . " (Ganda = " . $qr_no['pilgan'] . ", Esai = " . $qr_no['esai'] . ")" ?></td> -->
			</tr>
			<tr>
			</tr>
		</table>
		<style>
			::-webkit-scrollbar {
				height: 7px;
			}

			/* Track */
			::-webkit-scrollbar-track {
				background: transparent;
			}

			/* Handle */
			::-webkit-scrollbar-thumb {
				background: #888;
				border-radius: 10px;
			}

			/* Handle on hover */
			::-webkit-scrollbar-thumb:hover {
				background: #555;
				overflow: visible;
			}
		</style>
		<div class="">
			<table class="table table-bordered border-dark text-center table-hover">
				<thead class="bg-info-subtle">
					<tr>
						<th rowspan="2" valign="middle" class="text-center" style="width: 5mm;">No.</th>
						<th rowspan="2" valign="middle" class="text-center" style="width: 30mm;">No. Peserta</th>
						<th rowspan="2" valign="middle" class="text-center" style="width: 60mm;">Nama</th>
						<?php
						// $qr_no = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM cbt_pktsoal WHERE kd_soal ='$kds'"));
						$qr_jmlno = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM cbt_soal WHERE kd_soal ='$kds'"));
						if (!empty($qr_jmlno)) {
							$jml_soal = $qr_jmlno;
						} else {
							$jml_soal = 0;
						}
						for ($i = 1; $i <= $jml_soal; $i++) {
							echo '<th class="text-center" style="width: 10mm;">' . $i . ' </th>';
						}
						?>
						<th colspan="2" valign="middle" class="text-center">PilGan (<?php echo $qr_no['pilgan'] ?>)</th>
						<?php if (!empty($qr_no['esai'])) {
							echo '<th rowspan="2" valign="middle" class="text-center" style="width: 20mm;">Esai<br>(' . $qr_no['esai'] . ')</th>';
						} ?>
						<th rowspan="2" valign="middle" class="text-center" style="width: 20mm;">Nilai</th>
						<th rowspan="2" valign="middle" class="text-center" style="width: 50mm;">Keterangan</th>
					</tr>
					<tr>
						<?php
						for ($j = 1; $j <= $jml_soal; $j++) {
							$qr_key = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM cbt_soal WHERE kd_soal = '$kds' AND no_soal='$j';"));
							// while ($qr_key = mysqli_fetch_array($qrs)) {
							if (!empty($qr_key)) {
								if ($qr_key['jns_soal'] == "G") {
									if ($qr_key['knci_pilgan'] == "1") {
										$jwopsi = "A";
									} elseif ($qr_key['knci_pilgan'] == "2") {
										$jwopsi = "B";
									} elseif ($qr_key['knci_pilgan'] == "3") {
										$jwopsi = "C";
									} elseif ($qr_key['knci_pilgan'] == "4") {
										$jwopsi = "D";
									} elseif ($qr_key['knci_pilgan'] == "5") {
										$jwopsi = "E";
									} else {
										$jwopsi = "";
									}
								} elseif ($qr_key['jns_soal'] == "E") {
									$jwopsi = "ES";
								}
								if ($qr_key['lev_soal'] == "1") {
									$cl_key = "#ADFF2F";
								} elseif ($qr_key['lev_soal'] == "2") {
									$cl_key = "#FFD700";
								} else {
									$cl_key = "#FF6347";
								}
							} else {
								$jwopsi = "X";
							}
							echo '<td class="text-center fw-semibold" style="width: 5mm;background-color: ' . $cl_key . ';">' . $jwopsi . ' </td>';
						}
						?>
						<th valign="middle" class="text-center" style="width: 5mm;background-color: #33ff33;">Benar</th>
						<th valign="middle" class="text-center" style="width: 5mm;background-color: #ff4444;">Salah</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$no = 1;
					$qr_opsi = mysqli_query($koneksi, "SELECT * FROM nilai WHERE kd_soal='$kds' AND token ='$token'");
					while ($data = mysqli_fetch_array($qr_opsi)) {
						$user = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM cbt_peserta WHERE user ='$data[user]'"));

						$ket = "";
						$ket_cl = "";
						if ($_POST['ket'] == 2) {
							if ($data['nilai'] >= $data['kkm']) {
								$ket = "TUNTAS";
								$ket_cl = "#33ff33";
							} else {
								$ket = "TIDAK TUNTAS";
								$ket_cl = "#ff4444";
							}
						}
					?>
						<tr>
							<th><?php echo $no++; ?></th>
							<td><?php echo $data['user'] ?></td>
							<td class="text-start"><?php echo $user['nm'] ?></td>
							<?php
							$opsi = explode(",", $data['jwb']);
							$nos	= explode(",", $data['no_soal']);
							$j = 0;
							$b_cl = "#ffffff";

							for ($i = 1; $i <= $qr_jmlno; $i++) {
								if (in_array($i, $nos)) {
									if (!empty($opsi[$j])) {
										$b = $opsi[$j];
										// $a = $nos[$i - 1];
									} else {
										$b = "";
										$a = '';
										$b_cl = "#ffffff";
									}
									$qr_key = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM cbt_soal WHERE kd_soal = '$kds' AND no_soal='$i';"));
									// while ($qr_key = mysqli_fetch_array($qrs)) {
									if (!empty($qr_key)) {
										if ($qr_key['jns_soal'] == "G") {
											if ($qr_key['knci_pilgan'] == "1") {
												$b_opsi = "A";
											} elseif ($qr_key['knci_pilgan'] == "2") {
												$b_opsi = "B";
											} elseif ($qr_key['knci_pilgan'] == "3") {
												$b_opsi = "C";
											} elseif ($qr_key['knci_pilgan'] == "4") {
												$b_opsi = "D";
											} elseif ($qr_key['knci_pilgan'] == "5") {
												$b_opsi = "E";
											} else {
												$b_opsi = "";
											}
											if ($b_opsi == $b) {
												$b_cl = "#33ff33";
											} else {
												$b_cl = "#ff4444";
											}
										} elseif ($qr_key['jns_soal'] == "E") {
											if ($b == 1) {
												$b = '0';
											}
											if ($b >= 50) {
												$b_cl = "#33ff33";
											} else {
												$b_cl = "#ff4444";
											}
											// $b_cl = "#ffffff";
										} else {
											$b_cl = "#ffffff";
										}
									}
									$j++;
								} else {
									$b = '';
									$j - 1;
									$b_cl = "#ffffff";
								}
								echo '<td class="text-center align-baseline" style="width: 10mm;background-color:' . $b_cl . ';">';
								if (!empty($b)) {
									echo $b;
								} elseif ($qr_key['jns_soal'] == "E") {
									echo $b;
								}
								echo ' </td>';
							}
							?>
							<td><?php echo $data['nil_pg'] ?></td>
							<td><?php $slh = $qr_no['pilgan'] - $data['nil_pg'];
									if ($slh < 0) echo 0;
									else echo $slh;
									?>
							</td>
							<?php if (!empty($qr_no['esai'])) {
								$data['nil_es']=='1'? $niles ='0': $niles=$data['nil_es'];
								echo "<td>" . $niles . "</td>";
							} ?>
							<td class="fw-semibold" style="color: <?php echo $ket_cl ?>;"><?php echo $data['nilai'] ?></td>
							<td class="<?php echo $ket_cl ?>"><?php echo $ket; ?></td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</body>

	</html>
<?php } else {
	echo "Pilih Kode Bank Soal Terlebih Dahulu";
} ?>