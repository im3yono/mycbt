<?php
include_once("../config/conf.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["aktif"]) && isset($_POST["nm_pt"]) && isset($_POST["kd_aktif"])) {
	$nm = trim($_POST['nm_pt']);
	$kd_aktif = trim($_POST['kd_aktif']);
	$file = '../config/key.php';

	if (empty($nm) || empty($kd_aktif)) {
		echo "Data tidak boleh kosong!";
		exit;
	}

	$err = file_key($file, $nm, $kd_aktif);

	if ($err == '<meta http-equiv="refresh" content="3">') {
		// if (cek_aktif($d_exp, "<")) {
		// 	echo "<div class='alert alert-danger p-1'>Aktivasi Gagal";
		// } else {
			echo "sukses";
		// }
	} else {
		echo "<div class='alert alert-danger p-1'> Error " . $err . "</div>";
	}
} else {
	echo "Permintaan tidak valid!";
}
