<?php
include_once("get_ip.php");

// Pastikan file/class im3_devlop sudah di-include sebelum digunakan
if (!class_exists('im3_devlop')) {
	require_once("../my_devlop.php"); // Uncomment and sesuaikan path jika perlu
}

if (class_exists('im3_devlop')) {
	$dlp = new im3_devlop;
	$dibaiki = $dlp->my_project();
} else {
	// Class im3_devlop tidak tersedia
	// $dibaiki = 'DALAM PROSES PERBAIKAN';
	$dibaiki = '';
}



// Perbaikan

if (!empty($dibaiki) && (get_ip() == "127.0.0.1" || get_ip() == "::1")) {
	if (empty($_COOKIE['user']) && empty($_COOKIE['pass'])) {
		setcookie('user', 'admin', time() + 5400, "/");
		setcookie('pass', 'admin', time() + 5400, "/");
	}
}
