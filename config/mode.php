<?php
include_once("server.php");
// Perbaikan
	$dibaiki = '';
if (isset($inf_set['mode']) && $inf_set['mode'] == "on") {
	$dibaiki = 'DALAM PROSES PERBAIKAN';
}
if (!empty($dibaiki) && (get_ip() == "127.0.0.1" || get_ip() == "::1")) {
	if (empty($_COOKIE['user']) && empty($_COOKIE['pass'])) {
		setcookie('user', 'admin', time() + 5400, "/");
		setcookie('pass', 'admin', time() + 5400, "/");
	}
}
