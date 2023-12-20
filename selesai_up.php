<?php
include_once("config/server.php");

$userlg = $_GET['usr'];
$token = $_GET['tkn'];
$kds = $_GET['kds'];

// SIMPAN SELESAI
if (!empty($userlg)) {
	$sqr_end  = mysqli_query($koneksi,"UPDATE peserta_tes SET sts = 'S' WHERE peserta_tes.token = '$token' AND peserta_tes.user='$userlg' AND peserta_tes.kd_soal='$kds';");
}
