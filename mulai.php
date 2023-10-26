<?php
include_once("config/server.php");
include_once("config/time_date.php");

$dtjdw = mysqli_query($koneksi, "SELECT * FROM jdwl WHERE token ='$_POST[token]' AND kd_soal = '$_POST[kds]'");
if (mysqli_num_rows($dtjdw) != null) {
	$dtjdw = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM jdwl WHERE token ='$_POST[token]' AND kd_soal = '$_POST[kds]'"));
	$mpel  = mysqli_fetch_array(mysqli_query($koneksi, "SELECT nm_mpel FROM mapel WHERE kd_mpel='$dtjdw[kd_mpel]'"));

	$waktu_awal		= $dtjdw['jm_uji'];
	$waktu_akhir	= $dtjdw['lm_uji']; // bisa juga waktu sekarang now()

	$awal  = strtotime(($waktu_awal));
	$akhir = strtotime(($waktu_akhir));
	// $awal  = strtotime("08:00:00");
	// $akhir = strtotime("02:00:00");
	$nol = strtotime("00:00:00");
	$diff  = ($awal - $nol) + ($akhir - $nol);

	$jam   = floor($diff / (60 * 60));
	$menit = $diff - ($jam * (60 * 60));
	$detik = $diff % 60;

	$jmak  = floor(($akhir - $nol) / (60 * 60));
	$minak = ($akhir - $nol) - ($jmak * (60 * 60));
	$batas = ($jmak * 60) + floor($minak / 60);
?>


	<!DOCTYPE html>
	<html lang="en">

	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Aplikasi UNBK</title>
		<link rel="shortcut icon" href="img/<?php if ($inf['fav'] != null) {
																					echo $inf['fav'];
																				} else {
																					echo "fav.png";
																				} ?>" type="image/x-icon">

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
			<form action="" method="post">
				<div class="row gap-4 justify-content-center mx-3">
					<div class="card shadow-lg col-md-5 col-12 p-4 gap-2 fs-6">
						<h4 class="col-12 text-center border-bottom">Konfirmasi Data Tes</h4>
						<!-- <div class="row"> -->
						<div class="col">
							<label for="kt">Token</label>
							<input type="text" id="kt" name="kt" class="form-control" value="<?php echo $dtjdw['token'] ?>" readonly>
						</div>
						<!-- <div class="col-12">
						<label for="sst">Status Tes</label>
						<input type="text" id="sst" name="sst" class="form-control" value="<?php echo $dtjdw['token'] ?>" readonly>
						</div> -->
						<div class="col">
							<label for="mapel">Mata Uji Tes</label>
							<input type="text" id="kds" name="kds" value="<?php echo $dtjdw['kd_soal'] ?>" hidden>
							<input type="text" id="mapel" name="mapel" class="form-control" value="<?php echo $dtjdw['kd_soal'] . ' (' . $mpel[0] ?>)" readonly>
						</div>
						<!-- </div>
						<div class="row"> -->
						<div class="col">
							<label for="tgl">Tanggal Tes</label>
							<input type="text" id="tgl" name="tgl" class="form-control" value="<?php echo tgl_hari($dtjdw['tgl_uji']) ?>" readonly>
						</div>
						<div class="col">
							<label for="wkt">Waktu Tes</label>
							<input type="text" id="wkt" name="wkt" class="form-control" value="<?php echo $dtjdw['jm_uji'] ?>" readonly>
						</div>
						<div class="col">
							<label for="awkt">Alokasi Waktu Tes</label>
							<input type="text" id="awkt" name="awkt" class="form-control" value="<?php echo $batas . ' Menit' ?>" readonly>
						</div>
						<!-- </div> -->
					</div>
					<div class="card col-md-5 col-12 shadow-lg p-4 gap-2">
						<p class="fs-5" style="text-align: justify;">Silahkan berdoa sesuai agama dan kepercayaan sebelum mengerjakan soal</p>
						<input type="text" name="ip" id="ip" value="<?php echo get_ip(); ?>" hidden>
						<button type="submit" id="mulai" name="mulai" class="btn btn-primary col-12">MULAI</button>
					</div>
				</div>
			</form>
		</div>
		<footer>
			<div class="col-12 bg-dark text-white text-center fixed-bottom" style="height: 25px;"><?php include_once("config/about.php") ?></div>
		</footer>
	</body>

	</html>

<?php
} else {
	include_once("konfirmasi.php");
}
?>


<!-- === JavaScript -->