<?php
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
?>
<!-- //index -->