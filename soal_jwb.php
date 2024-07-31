<?php

use function PHPSTORM_META\map;

include_once("config/server.php");
if (empty($_COOKIE['user'])) {
	header('location:/'.$fd_root.'/');
} else {
	$userlg = $_COOKIE['user'];
	$token  = $_GET['tkn'];
	$nos     = $_POST['nos'];

	if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["opsi"])) {
		$opsi   = $_POST["opsi"];
		$sqkey	= mysqli_fetch_array(mysqli_query($koneksi, "SELECT *, knci_jwbn AS kc FROM cbt_ljk WHERE cbt_ljk.urut = '$nos' AND cbt_ljk.token = '$token' AND user_jawab = '$userlg';"));

		$nj = $sqkey[$opsi];

		$key	= "0";
		if ($sqkey['kc'] == $nj) {
			$key	= "1";
		} else {
			$key	= "0";
		}

		$sqls = "UPDATE cbt_ljk SET jwbn = '$opsi', nil_jwb = '$nj', nil_pg = '$key', jam = CURRENT_TIME WHERE cbt_ljk.urut = '$nos' AND cbt_ljk.token = '$token' AND user_jawab = '$userlg';";

		if (mysqli_query($koneksi, $sqls)) {
			echo '<div class="alert alert-success text-center p-1 my-0 mx-3" role="alert">Jawaban berhasil disimpan</div>';
		}
		// echo $_POST["data"];
		// echo '<div class="alert alert-success text-center p-1 m-0" role="alert">
		// Jawaban berhasil disimpan '.$_POST["nos"].' '.$_POST["opsi"].' '.$_GET["tkn"].' '.$_GET["usr"].' '.$_GET["kds"].'
		// </div>';
		//   echo '<div class="alert alert-success text-center p-1 my-0 mx-3" role="alert">
		// Jawaban berhasil disimpan</div>';
	}
	if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["esai"])) {
		$esai = $_POST['esai'];
		$sqls = "UPDATE cbt_ljk SET es_jwb = '$esai', jam = CURRENT_TIME WHERE cbt_ljk.urut = '$nos' AND cbt_ljk.token = '$token' AND user_jawab = '$userlg';";

		if (mysqli_query($koneksi, $sqls)) {
			echo '<div class="alert alert-success text-center p-1 my-0 mx-3" role="alert">Jawaban berhasil disimpan</div>';
		}
	}
}
