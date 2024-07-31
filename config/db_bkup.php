<?php
require_once 'server.php';
$backupDir = "../adm/file/db";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["bkp"])) {
	// Membuat koneksi ke database
	$conn = new mysqli($server, $userdb, $passdb, $db);

	// Memeriksa koneksi
	if ($conn->connect_error) {
		die("Koneksi gagal: " . $conn->connect_error);
	}

	// Mendapatkan daftar tabel
	$tables = array();
	$result = $conn->query("SHOW TABLES");
	while ($row = $result->fetch_row()) {
		$tables[] = $row[0];
	}

	$sqlScript = "CREATE DATABASE IF NOT EXISTS `$db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;\nUSE `$db`; \n\n";
	// $sqlScript = $db."\n\n";

	// Looping melalui tabel-tabel
	foreach ($tables as $table) {
		// Menambah perintah DROP TABLE
		$sqlScript .= "DROP TABLE IF EXISTS $table;\n";

		// Mendapatkan struktur tabel
		$result = $conn->query("SHOW CREATE TABLE $table");
		$row = $result->fetch_row();

		// Mendapatkan data tabel
		$result = $conn->query("SELECT * FROM $table");
		$columnCount = $result->field_count;
		$jmlin = $result->num_rows;
		$j = 1;
		$in_data = "";
		if (!empty($jmlin)) {
			$in_data = "INSERT INTO $table VALUES(";
		}
		$sqlScript .= $row[1] . ";\n\n" . $in_data;
		// Looping melalui data tabel
		while ($row = $result->fetch_row()) {
			// $sqlScript .= "";
			for ($i = 0; $i < $columnCount; $i++) {
				$row[$i] = $row[$i] ?? 'NULL';
				$row[$i] = $conn->real_escape_string($row[$i]);
				$sqlScript .= (is_numeric($row[$i]) ? $row[$i] : "'$row[$i]'") . ($i < ($columnCount - 1) ? "," : "");
			}
			if ($j < $jmlin) {
				$ak = ",\n(";
			} else {
				$ak = ";\n";
			}
			$sqlScript .= ")$ak";
			$j++;
		}

		$sqlScript .= "\n";
	}

	// Menentukan nama file backup
	$backupFile = $backupDir . '/' . $db . '_backup_' . date("Y-m-d_H-i-s") . '.sql';

	// Menyimpan file SQL
	if (!file_put_contents($backupFile, $sqlScript)) {
		die('<div class="alert alert-danger" role="alert">
		database berhasil dicadangkan
	</div>');
	}

	echo '<div class="alert alert-success" role="alert">
	database berhasil dicadangkan
	</div>';
	echo '<meta http-equiv="refresh" content="2">';

	// ."Backup database berhasil disimpan ke " . $backupFile;
}

// Delete File Backup
if (isset($_GET["dl"]) == "del_bkp") {
	$files    = glob('../adm/file/db/*');
	foreach ($files as $file) {
		if (is_file($file)) {
			unlink($file); // hapus file
			// echo '<meta http-equiv="refresh" content="0;url=./?md=setting">';
		}
	}
}
