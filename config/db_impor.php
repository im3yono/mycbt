<?php
require_once 'server.php';
$nm_db = $_POST["nm_db"];

if (empty($nm_db)) {
	$nm_db ="mytbk";
}

$buatdb = mysqli_query($koneksi, "CREATE DATABASE IF NOT EXISTS `$nm_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci; ") or die('<div class="alert alert-danger">Masalah dalam membuat Database</div>');
$im_dbkon = mysqli_connect($server, $userdb, $passdb,$nm_db);
$query = '';
$sqlScript = file('../config/db_mytbk.sql');
// $buatdb = mysqli_query($koneksi, "USE `$nm_db`") or die('<div class="alert alert-danger">Masalah dalam membuat Database</div>');
foreach ($sqlScript as $line) {

	$startWith = substr(trim($line), 0, 2);
	$endWith = substr(trim($line), -1, 1);

	if (empty($line) || $startWith == '--' || $startWith == '/*' || $startWith == '//') {
		continue;
	}

	$query = $query . $line;
	if ($endWith == ';') {
		mysqli_query($im_dbkon, $query) or die('<div class="alert alert-danger">Masalah dalam menjalankan kueri SQL <b>' . $query . '</b></div>');
		$query = '';
	}
}
echo '<div class="alert alert-success">Database Berhasil di Impor</div>';
