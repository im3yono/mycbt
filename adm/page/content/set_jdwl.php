<?php
require_once('../../../config/server.php');

$batas = 10;
$hal   = isset($_GET['pg']) ? (int)$_GET['pg'] : 1;
$hal_awal = ($hal > 1) ? ($hal * $batas) - $batas : 0;

$previous = $hal - 1;
$next     = $hal + 1;

$no = 1;
$selectSQL = "SELECT * FROM cbt_pktsoal";
$data = mysqli_query($koneksi, $selectSQL);
$jml_data = mysqli_num_rows($data);
$tot_hal = ceil($jml_data / $batas);

$dtmpl  = mysqli_query($koneksi, "SELECT * FROM cbt_pktsoal WHERE cbt_pktsoal.sts = 'Y' ORDER BY id_pktsoal ASC limit $hal_awal,$batas");
while ($dt = mysqli_fetch_array($dtmpl)) {
	$mpel = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM mapel WHERE kd_mpel ='$dt[kd_mpel]'"));
	$jsl  = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM cbt_soal WHERE kd_soal ='$dt[kd_soal]'"));
	$jdwl = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM jdwl  WHERE kd_soal ='$dt[kd_soal]' AND tgl_uji=CURRENT_DATE() AND sts='Y'"));

	if (!empty($jdwl['jm_uji'])) {
		$waktu_awal    = $jdwl['jm_uji'];
		$waktu_akhir  = $jdwl['lm_uji']; // bisa juga waktu sekarang now()

		$awal  = strtotime(($waktu_awal));
		$akhir = strtotime(($waktu_akhir));
		// $awal  = strtotime("08:00:00");
		// $akhir = strtotime("02:00:00");
		$nol = strtotime("00:00:00");
		$diff  = ($awal - $nol) + ($akhir - $nol);

		$jam   = floor($diff / (60 * 60));
		$menit = $diff - ($jam * (60 * 60));
		$detik = $diff % 60;

		$jmak  = floor(($akhir - $nol) / (60 * 60));
		$minak = ($akhir - $nol) - ($jmak * (60 * 60));
		$batas = ($jmak * 60) + floor($minak / 60);
	}

	if ($dt['kd_kls'] == "1") {
		$kkelas = "";
	} else {
		$kkelas = $dt['kd_kls'] . '_';
	}
	if ($dt['kls'] == "1") {
		$kelas = "Semua";
	} else {
		$kelas = $dt['kls'];
	}
	if ($dt['jur'] == "1") {
		$jurusan = "Semua";
	} else {
		$jurusan = $dt['jur'];
	}

?>
	<tr align="center">
		<th><?php echo $no++ ?></th>
		<td><?php echo $dt['kd_soal'] ?></td>
		<td><?php echo $mpel['nm_mpel'] ?></td>
		<td><?php echo $dt['author'] ?></td>
		<td><?php echo $kkelas . $kelas . ' | ' . $jurusan ?></td>
		<td><?php echo $jsl . '/' . $dt['jum_soal'] ?></td>
		<td class="text-center">
			<?php

			if (!empty($jdwl['sts'])) {
				if ($jdwl['sts'] == "Y") {
					echo "<a class='btn btn-sm btn-primary'><i class='bi bi-check2'></i>Aktif</a>";
				} elseif ($jdwl['sts'] == "N") {
					echo "<a class='btn btn-sm btn-danger'>Nonaktif</a>";
				} elseif ($jdwl['sts'] == "H") {
					echo "<a class='btn btn-sm btn-success'>Riwayat</a>";
				}
			} else {
				// echo "<a href='#' class='btn btn-sm btn-info'>SET</a>";
				echo '<button type="button" class="btn btn-info btn-sm" id="sts' . $dt['id_pktsoal'] . '" onclick="statusSoal(' . $dt['id_pktsoal'] . ')">SET</button>';
			}

			?>
		</td>
		<td class="text-center">
			<button class="btn btn-sm btn-info fs-6 mb-1" onclick="modalView('<?= $dt['kd_soal'] ?>','vw')"><i class="bi bi-eye"></i></button>
			<button class="btn btn-sm btn-primary fs-6 mb-1" data-bs-toggle="modal" data-bs-target="#mdlpsi<?php echo $dt[0] ?>"><i class="bi bi-gear"></i></button>
			<button class="btn btn-sm btn-warning fs-6 mb-1" onclick="modalView('<?= $dt['kd_soal'] ?>','hs')"><i class="bi bi-clock-history"></i></button>
			<!-- | <button class="btn btn-sm btn-warning fs-6 mb-1"><i class="bi bi-pencil-square"></i></button> |
							<button class="btn btn-sm btn-danger fs-6"><i class="bi bi-trash3"></i></button> -->
		</td>
	</tr>
<?php } ?>