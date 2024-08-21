<?php

include_once("../../config/server.php");

// UPDATE cbt_ljk SET nil_esai = '100' WHERE cbt_ljk.id = 6;
if ($_GET['act'] == "nil") {
	$nil = $_POST['nil'];
	$usr = $_POST['usr'];
	$kds = $_POST['kds'];
	$nos = $_POST['nos'];
	$tkn = $_POST['tkn'];

	// Cek Jumlah Penilaian Esai
	$cek_es = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM cbt_pktsoal WHERE kd_soal='$kds'"));
	$cek_ljkes = mysqli_query($koneksi, "SELECT * FROM cbt_ljk WHERE jns_soal ='E' AND user_jawab = '$usr' AND kd_soal='$kds' AND token ='$tkn'");
	if ($cek_es['esai'] <= $cek_ljkes) {
		$sql =  "UPDATE cbt_ljk SET nil_esai = '$nil' WHERE user_jawab = '$usr' AND kd_soal='$kds' AND no_soal='$nos';";

		if (mysqli_query($koneksi, $sql)) {
			echo "Data berhasil disimpan";
		}
	}
}

if ($_GET['act'] == "prs") {
}