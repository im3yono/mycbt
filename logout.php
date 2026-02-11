<?php
// Hapus semua variabel sesi
session_start();
$_SESSION = array();

// Jika ingin menghancurkan sesi sepenuhnya, hapus juga cookie sesi.
if (ini_get("session.use_cookies")) {
	$params = session_get_cookie_params();
	setcookie(
		session_name(),
		'',
		time() - 3600,
		$params["path"],
		$params["domain"],
		$params["secure"],
		$params["httponly"]
	);
	setcookie(
		'user',
		'',
		time() - 3600,
		$params["secure"],
		$params["httponly"]
	);
	setcookie(
		'pass',
		'',
		time() - 3600,
		$params["secure"],
		$params["httponly"]
	);
}

// Hancurkan sesi
session_destroy();

// Hapus cookie login
setcookie('user', '', time() - 3600, '/');
setcookie('pass', '', time() - 3600, '/');
setcookie('connectionStatus', '', time() - 3600, '/');
setcookie('n_soal', '', time() - 3600, '/');
setcookie("browser", "", time() - 3600, "/");

// Redirect sesuai logika sebelumnya
$fld = $_SERVER['SCRIPT_NAME'];
$fld = explode('/', $fld);
if ($fld[2] == "adm") {
	header('location:/' . $_GET['fld'] . '/');
} else {
	if (!empty($_GET['info'])) {
		header('location:/' . $fld[1] . '/?login=' . $_GET['info']);
	} else {
		header('location:/' . $fld[1]);
	}
}
exit;
