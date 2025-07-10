<?php
include_once("config/conf.php");
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["aktif"]) && isset($_POST["nm_pt"]) && isset($_POST["kd_aktif"])) {
	$nm 		= $_POST['nm_pt'];
	$kd_aktif 	= $_POST['kd_aktif'];
	$file 	= 'config/key.php';

	// Pastikan nilai tidak kosong
	if (empty($nm) || empty($kd_aktif)) {
		echo "<p style='color: red;'>Data tidak boleh kosong!</p>";
		exit;
	}

	$err = file_key($file, $nm, $kd_aktif);
	echo '<meta http-equiv="refresh" content="0;url=logout.php">';
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title>AKTIVASI APLIKASI</title>
	<link rel="shortcut icon" href="img/fav.png" type="image/x-icon">

	<link rel="stylesheet" href="vendor/twbs/bootstrap/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="vendor/twbs/bootstrap-icons/font/bootstrap-icons.css">
	<script src="vendor/twbs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

	<script src="node_modules/sweetalert2/dist/sweetalert2.min.js"></script>
	<link rel="stylesheet" href="node_modules/sweetalert2/dist/sweetalert2.min.css">
	<link rel="stylesheet" href="aset/aktivasi.css">
</head>


<body>
	<div class="head">
		<!-- <div class="col-12 text-center">
			<img class="mt-4 img-fluid" src="img/MyTBK.png" alt="" width="330">
		</div> -->
	</div>
	<div class="container text-center" style="margin-top: -50px;">
		<div class="row mx-3 login">
			<div class="col-auto shadow login-form " style="width: 400px;">
				<main class="form-signin w-100 m-auto">
					<form action="" method="post">
						<div class="row justify-content-center gap-2">
							<h2>Aktivasi</h2>
							<p>Untuk mendapatkan Kode Aktivasi Aplikasi ini silahkan hubungi <br> <a href="https://wa.me/6285249959547" target="_blank" class="link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover"><i class="bi bi-whatsapp"></i> 0852-4995-9547</a>
							</p>
							<div><?= empty($err) ? "" : $err; ?></div>
							<div><?= isset($_GET['er']) ? '<div class="alert alert-danger p-1" role="alert">Aktivasi Tidak Valid</div>' : ""; ?></div>
							<div class="input-group" style="margin-bottom: -8px;">
								<div class="form-floating">
									<input class="form-control" type="text" id="nm_pt" name="nm_pt" placeholder="Nama Instansi" value="<?= $mem; ?>" required>
									<label for="nm_pt">Nama Instansi</label>
								</div>
							</div>
							<div class="input-group">
								<div class="form-floating">
									<input class="form-control" type="text" id="kd_aktif" name="kd_aktif" placeholder="Kode Aktivasi" required>
									<label for="kd_aktof">Kode Aktivasi</label>
								</div>
							</div>
							<div class="col-12 m-3"><button type="submit" class="btn btn-outline-primary" id="aktif" name="aktif">Aktivasi</button></div>
						</div>
					</form>
					<p class="my-3 ">
						<?php include_once("config/about.php");
						?>
					</p>
				</main>
			</div>
			<div class="col col-img p-0">
				<div class="login-img ">
					<!-- <h4>WELCOME</h4> -->
					<script src="aset/animasi/aktivasi.js"></script>
					<lottie-player
						src="aset/animasi/animasi.json"
						background="transparent"
						speed="1"
						style="width: 100%; height: 100%;"
						loop autoplay>
					</lottie-player>

				</div>
			</div>
		</div>
	</div>
</body>

</html>