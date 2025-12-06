	<noscript>
		<div style="background-color: #ffdddd; color: red; padding: 50px 15px; text-align: center; font-weight: bold;">
			<h3>⚠️ JavaScript tidak aktif di browser Anda. Aktifkan JavaScript untuk menjalankan aplikasi ini dengan benar.</h3>
		</div>
	</noscript>
	<?php
	if (!file_exists("config/db_acc.php")) {
		include_once("user_db.php");
		exit;
	} else {
		// Fungtion
		require_once("config/db.php");
		if (validateDate($d_exp)) {
			require_once "config/mode.php";
			if (cek_aktif($d_exp, "<")) {
				include_once 'aktivasi.php';
				exit;
			}
		} else {
			// echo '<meta http-equiv="refresh" content="0;url=aktivasi.php?er=1">';
			include_once 'aktivasi.php';
			exit;
		}

		include_once("config/server.php");
		if ($_SERVER['REQUEST_METHOD'] == "POST") {
			if (isset($_POST["login"])) {
				include_once("konfirmasi.php");
			} else
	if (isset($_POST["konf"])) {
				include_once("mulai.php");
			} else
	if (isset($_POST["mulai"])) {
				include_once("ujian.php");
			}
			exit();
		} elseif (isset($_COOKIE['user']) && isset($_COOKIE['pass'])) {
			include_once("konfirmasi.php");
		} elseif (isset($_REQUEST["du"]) && isset($_REQUEST["dp"])) {
			include_once("konfirmasi.php");
		} else {

			include_once("login.php");
		}
	}
	?>