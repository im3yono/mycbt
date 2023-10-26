<?php
// echo "Data Berhasil Di Hapus " . $_POST['no'] . " " . $_POST['kds'];
include_once("../../config/server.php");

$no  = $_POST['no'];
$kds = $_POST['kds'];

if (!empty($no) && !empty($kds)) {
	$sql = "DELETE FROM cbt_soal WHERE no_soal = '$no' AND kd_soal='$kds'";
	if (mysqli_query($koneksi, $sql)) {
		echo "Data Berhasil dihapus";
		$qrds	= mysqli_query($koneksi, "SELECT * FROM cbt_soal WHERE kd_soal='$kds' ORDER BY cbt_soal.no_soal ASC");
		$nos = 1;
		while ($row = mysqli_fetch_array($qrds)) {
			if ($nos!=$row) {
				mysqli_query($koneksi,"UPDATE cbt_soal SET no_soal = '$nos' WHERE id_soal = '$row[id_soal]';");
			}
			// UPDATE cbt_soal SET no_soal = '1' WHERE cbt_soal.id_soal = 109;
			$nos++;
		}
	}
}
