<?php
require_once("../../../config/server.php");


$no = 1;
$qry = mysqli_query($koneksi, "SELECT * FROM jdwl");

while ($row = mysqli_fetch_array($qry)) {

	// Ambil data kelas dari tabel kelas
	$d_kls = '';
	if ($row['kd_kls'] == '1' && $row['kls'] == '1' && $row['jur'] == '1') {
		$d_kls = "Semua";
	} elseif ($row['kd_kls'] != '1' && $row['kls'] == '1' && $row['jur'] == '1') {
		$d_kls = $kls['nm_kls'] . " | Semua";
	} elseif ($row['kd_kls'] == '1' && $row['kls'] != '1' && $row['jur'] == '1') {
		$d_kls = $row['kls'] . " | Semua";
	} elseif ($row['kd_kls'] != '1' && $row['kls'] != '1' && $row['jur'] == '1') {
		$d_kls = $kls['nm_kls'] . " | Semua";
	} elseif ($row['kd_kls'] == '1' && $row['kls'] == '1' && $row['jur'] != '1') {
		$d_kls = "Semua | " . $row['jur'];
	} elseif ($row['kd_kls'] != '1' && $row['kls'] == '1' && $row['jur'] != '1') {
		$d_kls = $kls['nm_kls'] . " | " . $row['jur'];
	} elseif ($row['kd_kls'] == '1' && $row['kls'] != '1' && $row['jur'] != '1') {
		$d_kls = $row['kls'] . " | " . $row['jur'];
	} else {
		$d_kls = $kls['nm_kls'] . " | " . $row['jur'];
	}
	$kls = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM kelas WHERE kd_kls = '$row[kd_kls]'"));
?>
	<tr>
		<th><?= $no; ?></th>
		<td><?= $row['kd_soal']; ?></td>
		<td><?= $row['kd_mpel']; ?></td>
		<td><?= jamZone($row['jm_uji']) . '<br>' . tgl_hari($row['tgl_uji']) ?></td>
		<td><?= $d_kls; ?></td>
		<td>6</td>
		<td>7</td>
		<td><button type="button" class="btn btn-primary btn-sm" onclick="opsi(1,'abc')"><i class="bi bi-gear"></i></button></td>
	</tr>
<?php } ?>