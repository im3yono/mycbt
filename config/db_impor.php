<?php
require_once 'db.php';

// Membuat koneksi
$conn = new mysqli($server, $userdb, $passdb);

$query = '';
$sqlScript = file('db_mytbk.sql');
foreach ($sqlScript as $line) {

	$startWith = substr(trim($line), 0, 2);
	$endWith = substr(trim($line), -1, 1);

	if (empty($line) || $startWith == '--' || $startWith == '/*' || $startWith == '//') {
		continue;
	}

	$query = $query . $line;
	if ($endWith == ';') {
		mysqli_query($conn, $query) or die('<div class="alert alert-danger">Masalah dalam menjalankan kueri SQL <b>' . $query . '</b></div>');
		$query = '';
	}
}
echo '<div class="alert alert-success">Database Berhasil Impor</div>';
