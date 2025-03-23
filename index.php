<?php
if (PHP_VERSION == "8.1.6") {

	// include_once('config/get_connected.php');
	if ($_SERVER['REQUEST_METHOD'] == "POST") {
		if (isset($_POST["login"])) {
			include_once("konfirmasi.php");
		} else
	if (isset($_POST["konf"])) {
			include_once("mulai.php");
		} else
	if (isset($_POST["mulai"])) {
			// =============== CEK STATUS INTERNET =============== //
			// if (is_connected() == true) {
			// 	// echo "terhubung internet";
			// 	if (isset($_REQUEST['info']) != "on") {
			// include_once("on.php");
			// 	}
			// } else {
			include_once("ujian.php");
			// }
		}
		exit();
	} else
if (isset($_COOKIE['user']) && isset($_COOKIE['pass'])) {
		include_once("konfirmasi.php");
	} elseif (isset($_REQUEST["du"]) && isset($_REQUEST["dp"])) {
		include_once("konfirmasi.php");
	} else {

		include_once("login.php");
	}



	// if (isset($_REQUEST['uj']) == "") {
	// 	include_once("login.php");
	// }elseif (($_REQUEST['uj']) == "lg") {
	// 	include_once("login.php");
	// }elseif (($_REQUEST['uj']) == "kf") {
	// 	include_once("konfirmasi.php");
	// }elseif (($_REQUEST['uj']) == "ml") {
	// 	include_once("mulai.php");
	// }elseif (($_REQUEST['uj']) == "on") {
	// 	include_once("ujian.php");
	// }




} else { ?>
	<!DOCTYPE html>
	<html lang="en">

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>PHP Version Error</title>
		<link href="vendor/twbs/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	</head>

	<body>
		<div class="container mt-5">
			<div class="alert alert-danger" role="alert">
				<h4 class="alert-heading">PHP Version Error</h4>
				<p>Versi PHP Anda <strong><?= PHP_VERSION ?></strong> tidak sesuai dengan yang dibutuhkan. Silakan perbarui versi PHP Anda ke <b>8.1.6</b> atau yang lebih baru agar semua fitur berfungsi dengan baik.</p>
				<hr>
				<p class="mb-0">Untuk informasi lebih lanjut, kunjungi <a href="https://www.php.net/downloads.php" class="alert-link">situs resmi PHP</a>.</p>
			</div>
		</div>
	</body>

	</html>
<?php
	exit();
}
?>