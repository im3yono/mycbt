<?php
include_once 'validator.php';

$uploadDir = __DIR__ . '/uploads/';
$rootPath  = realpath(__DIR__ . '/../../'); // ke folder TBK/
$backupDir = $rootPath . '/backup/' . date('Ymd_His') . '/';

if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
if (!is_dir(dirname($backupDir))) mkdir(dirname($backupDir), 0777, true);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['updateFile'])) {
	$file = $_FILES['updateFile'];
	$ext  = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
	if ($ext !== 'zip') {
		exit('<span style="color:red;">File harus berformat .zip!</span>');
	}

	$zipPath = $uploadDir . basename($file['name']);
	if (!move_uploaded_file($file['tmp_name'], $zipPath)) {
		exit('<span style="color:red;">Upload gagal!</span>');
	}

	// Validasi isi ZIP
	$validation = validateZipContents($zipPath);
	if (isset($validation['error'])) {
		unlink($zipPath);
		echo "<b>Validasi gagal:</b> " . $validation['error'] . "<br>";
		if (!empty($validation['files'])) {
			echo "<ul>";
			foreach ($validation['files'] as $badFile) echo "<li>$badFile</li>";
			echo "</ul>";
		}
		exit;
	}

	// Fungsi Backup
	function recurseCopy($src, $dst, $skip = ['backup', 'uploads', 'node_modules', 'vendor', 'data'])
	{
		$dir = opendir($src);
		@mkdir($dst, 0777, true);
		while (false !== ($file = readdir($dir))) {
			if ($file != '.' && $file != '..') {
				if (in_array($file, $skip)) continue;
				$srcPath = "$src/$file";
				$dstPath = "$dst/$file";
				if (is_dir($srcPath)) {
					recurseCopy($srcPath, $dstPath, $skip);
				} else {
					copy($srcPath, $dstPath);
				}
			}
		}
		closedir($dir);
	}

	recurseCopy($rootPath, $backupDir);

	// Ekstrak
	$zip = new ZipArchive;
	if ($zip->open($zipPath) === TRUE) {
		if ($zip->extractTo($rootPath)) {
			$zip->close();
			unlink($zipPath);
			echo "<span style='color:green;'>Update berhasil!</span><br>";
			$backupDisplayPath = str_replace('/', '\\', realpath($backupDir));
			echo "Backup tersimpan di: <code>$backupDisplayPath</code>";
		} else {
			$zip->close();
			echo "<span style='color:red;'>Gagal ekstrak ZIP! Melakukan rollback...</span><br>";
			recurseCopy($backupDir, $rootPath);
			echo "<span style='color:orange;'>Rollback selesai.</span>";
		}
	} else {
		echo "<span style='color:red;'>ZIP tidak dapat dibuka!</span>";
	}
} else {
	echo "<span style='color:red;'>Tidak ada file dikirim.</span>";
}
