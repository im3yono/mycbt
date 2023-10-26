<?php
include_once("../../config/server.php");

$usr	= $_POST['usr'];
$id	= $_POST['id'];
$aksi	= $_POST['ak'];

if ($aksi == "reset") {
	// UPDATE peserta_tes SET ip = '192.168.181.230' WHERE peserta_tes.id_tes = 3;
	$sql_reset	= "UPDATE peserta_tes SET ip = '' WHERE peserta_tes.id_tes = '$id' AND peserta_tes.user='$usr';";
	if (mysqli_query($koneksi, $sql_reset)) {
		echo "User <i class='fw-semibold'>" . $usr . "</i> Berhasil di Reset";
	}
}
if ($aksi == "rq_reset") {
	// UPDATE peserta_tes SET ip = '192.168.181.230' WHERE peserta_tes.id_tes = 3;
	$sql_reset	= "UPDATE peserta_tes SET ip = '', rq_rst = 'N' WHERE peserta_tes.id_tes = '$id' AND peserta_tes.user='$usr';";
	if (mysqli_query($koneksi, $sql_reset)) {
		echo "User <i class='fw-semibold'>" . $usr . "</i> Berhasil di Reset";
	}
}
if ($aksi == "s_reset") {
	// UPDATE peserta_tes SET ip = '192.168.181.230' WHERE peserta_tes.id_tes = 3;
	$sql_reset	= "UPDATE peserta_tes SET ip = '' WHERE peserta_tes.token='$id';;";
	if (mysqli_query($koneksi, $sql_reset)) {
		echo "<i class='fw-semibold'>" . $usr . "</i> User Berhasil di Reset";
	}
}
if ($aksi == "selesai") {
	// UPDATE peserta_tes SET sts = 'S' WHERE peserta_tes.id_tes = 3;
	$sql	= "UPDATE peserta_tes SET sts = 'S' WHERE peserta_tes.id_tes = '$id' AND peserta_tes.user='$usr';";
	if (mysqli_query($koneksi, $sql)) {
		echo "User <i class='fw-semibold'>" . $usr . "</i> Telah diselesaikan";
	}
}
if ($aksi == "s_all") {
	// UPDATE peserta_tes SET sts = 'S' WHERE peserta_tes.id_tes = 3;
	$sql	= "UPDATE peserta_tes SET sts = 'S' WHERE peserta_tes.token='$id';";
	if (mysqli_query($koneksi, $sql)) {
		echo "<i class='fw-semibold'>" . $usr . "</i> User Telah diselesaikan";
	}
}
if ($aksi == "online") {
	$sql	= "UPDATE peserta_tes SET sts = 'U' WHERE peserta_tes.id_tes = '$id' AND peserta_tes.user='$usr';";
	if (mysqli_query($koneksi, $sql)) {
		echo "User <i class='fw-semibold'>" . $usr . "</i> dapat mengerjakan kembali";
	}
}
if ($aksi == "s_on") {
	$sql	= "UPDATE peserta_tes SET sts = 'U' WHERE peserta_tes.token='$id';";
	if (mysqli_query($koneksi, $sql)) {
		echo "<i class='fw-semibold'>" . $usr . "</i> User dapat mengerjakan kembali";
	}
}
