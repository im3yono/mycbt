<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Aplikasi UNBK</title>
	<link rel="shortcut icon" href="img/tut.png" type="image/x-icon">

	<link rel="stylesheet" href="vendor/twbs/bootstrap/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="vendor/twbs/bootstrap-icons/font/bootstrap-icons.css">
	<script src="vendor/twbs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</head>
<!-- CSS Kostum -->
<style>
	html,
	body {
		height: 100%;
	}

	body {
		/* display: flex; */
		align-items: center;
		/* padding-top: 40px; */
		padding-bottom: 40px;
		background-image: url('img/swirl_pattern.png');
		/*  background-repeat: no-repeat;
      background-size: 100% 100%; */
		/* background-color: aquamarine; */

	}

	.form-signin {
		padding: 15px;
	}

	.form-signin .form-floating:focus-within {
		z-index: 2;
	}

	.form-signin input[type="text"] {
		margin-bottom: -1px;
		border-bottom-right-radius: 0;
		border-bottom-left-radius: 0;
	}

	.form-signin input[type="password"] {
		margin-bottom: 10px;
		border-top-left-radius: 0;
		border-top-right-radius: 0;
	}

	.head {
		height: 200px;
		background-image: url(img/header-bg.png);
	}

	.img {
		border-radius: 50%;
		width: 270px;
		height: 270px;
	}

	.time {
		border: 1px solid;
		border-color: #0099ff;
		background-color: #0099ff;
		width: 2fr;
		border-radius: 25px;
		margin: 3px;
		padding: 3px;
		padding-right: 10px;
		padding-left: 10px;
		font-family: Arial;
		font-size: 18px;
	}
</style>

<body>
	<div class="head">
		<div class="col-12 text-center">
			<img class="mt-5 img-fluid" src="img/logo.png" alt="">
		</div>
	</div>
	<div class="container-fluid pb-md-0 pb-5" style="margin-top: -50px;font-family: Times New Roman;">
		<div class="row gap-4 justify-content-center mx-3">
			<div class="card shadow-lg col-md-5 col-12 p-4 gap-2 fs-6">
				<h4 class="col-12 text-center border-bottom">Konfirmasi Data Tes</h4>
				<div class="col-12">
					<label for="kt">Kode Tes</label>
					<input type="text" id="kt" name="kt" class="form-control" value="Kode Tes" readonly>
				</div>
				<div class="col-12">
					<label for="sst">Status Tes</label>
					<input type="text" id="sst" name="sst" class="form-control" value="Status Tes" readonly>
				</div>
				<div class="col-12">
					<label for="mapel">Mata Uji Tes</label>
					<input type="text" id="mapel" name="mapel" class="form-control" value="Mata Uji Tes" readonly>
				</div>
				<div class="col-12">
					<label for="tgl">Tanggal Tes</label>
					<input type="text" id="tgl" name="tgl" class="form-control" value="Tanggal Tes" readonly>
				</div>
				<div class="col-12">
					<label for="wkt">Waktu Tes</label>
					<input type="text" id="wkt" name="wkt" class="form-control" value="Waktu Tes" readonly>
				</div>
				<div class="col-12">
					<label for="awkt">Alokasi Waktu Tes</label>
					<input type="text" id="awkt" name="awkt" class="form-control" value="Alokasi Waktu Tes" readonly>
				</div>
			</div>
			<div class="card col-md-5 col-12 shadow-lg p-4 gap-2">
				<p class="fs-5" style="text-align: justify;">Tombol MULAI hanya akan aktif apabila waktu sekarang sudah melewati waktu mulai tes</p>
				<a href="ujian.php" class="btn btn-primary col-12">MULAI</a>
			</div>
		</div>
	</div>
	<footer>
		<div class="col-12 bg-dark text-white text-center fixed-bottom" style="height: 25px;"><?php include_once("config/about.php") ?></div>
	</footer>
</body>

</html>


<!-- === JavaScript -->