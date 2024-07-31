<?php
require_once 'server.php';
$nm_db = $_POST["nm_db"];
$db_get = $_POST['db_get'];

if (empty($nm_db)) {
	$nm_db ="mytbk";
}

if ($db_get=="simpan") {
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
}
if ($db_get=="pulih") {
	$db_file = $_POST['s_rdb'];
	$sqlScript = file('..adm/file/db/'.$db_file);
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
}