<?php
include_once("get_ip.php");
// Perbaikan
$dibaiki = 'DALAM PROSES PERBAIKAN';
// $dibaiki = '';
if (!empty($dibaiki) && (get_ip() == "127.0.0.1" || get_ip() == "::1")) {
	if (empty($_COOKIE['user']) && empty($_COOKIE['pass'])) {
		setcookie('user', 'admin', time() + 5400, "/");
		setcookie('pass', 'admin', time() + 5400, "/");
	}
}
