<?php
if (PHP_VERSION >= "8.2.0") {
	require_once("data/md_index.php");
} else { ?>
	<!DOCTYPE html>
	<html lang="en">

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>PHP Version Error</title>
		<link href="vendor/twbs/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	</head>

	<body>
		<div class="container mt-5">
			<div class="alert alert-danger" role="alert">
				<h4 class="alert-heading">PHP Version Error</h4>
				<p>Versi PHP Anda <strong><?= PHP_VERSION ?></strong> tidak sesuai dengan yang dibutuhkan. Silakan perbarui versi PHP Anda ke <b>8.2</b> atau yang lebih baru agar semua fitur berfungsi dengan baik.</p>
				<hr>
				<p class="mb-0">Untuk informasi lebih lanjut, kunjungi <a href="https://www.php.net/downloads.php" class="alert-link">situs resmi PHP</a>.</p>
			</div>
		</div>
	</body>

	</html>
<?php
	exit();
}
?>