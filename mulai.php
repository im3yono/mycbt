<?php
include_once("config/server.php");
include_once("config/time_date.php");

$dtjdw = mysqli_query($koneksi, "SELECT * FROM jdwl WHERE token ='$_POST[token]' AND kd_soal = '$_POST[kds]'");
if (mysqli_num_rows($dtjdw) != null) {
	// if ($_POST['token'] == $_POST['token2']) {
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

	// Pra LJK
	if (!isset($_COOKIE['n_soal'])) {
		require_once("data/n_soal.php");
	}
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
				<img class="mt-5 img-fluid" src="img/MyTBK.png" alt="" width="330">
			</div>
		</div>
		<div class="container-fluid pb-md-0 pb-5" style="margin-top: -50px;font-family: Times New Roman;">
			<form action="" method="post">
				<div class="row gap-4 justify-content-center mx-3">
					<div class="card shadow-lg col-md-5 col-12 p-4 gap-2 fs-6">
						<h4 class="col-12 text-center border-bottom">Konfirmasi Data Tes</h4>
						<!-- <div class="row">
							<div class="col-auto">
								<label for="kt" class="text-decoration-underline">Sifat Tes : <?php if ($dtjdw['md_uji'] == '1') echo 'Online';
																																							else echo 'Full Offline'; ?></label>
							</div>
						</div> -->
						<div class="row g-2">
							<div class="col-lg-4 col-12">
								<label for="kt">Token</label>
								<input type="text" id="kt" name="kt" class="form-control" value="<?php echo $dtjdw['token'] ?>" readonly>
							</div>
							<!-- <div class="col-12">
						<label for="sst">Status Tes</label>
						<input type="text" id="sst" name="sst" class="form-control" value="<?php echo $dtjdw['token'] ?>" readonly> -->
						</div>
						<div class="row g-2">
							<div class="col">
								<label for="mapel">Mata Uji Tes</label>
								<input type="text" id="kds" name="kds" value="<?php echo $dtjdw['kd_soal'] ?>" hidden>
								<input type="text" id="mapel" name="mapel" class="form-control" value="<?php echo $dtjdw['kd_soal'] . ' (' . $mpel[0] ?>)" readonly>
							</div>
							<div class="col-lg-4 col-12">
								<lable class="author">Pembuat Soal</lable>
								<input type="text" id="author" class="form-control" value="<?= $dtjdw['author'] ?>" readonly>
							</div>
						</div>
						<div class="row g-2 text-nowrap">
							<div class="col-12 col-lg">
								<label for="tgl">Tanggal Tes</label>
								<input type="text" id="tgl" name="tgl" class="form-control" value="<?php echo tgl_hari($dtjdw['tgl_uji']) ?>" readonly>
							</div>
							<div class="col-12 col-lg">
								<label for="wkt">Waktu Tes</label>
								<input type="text" id="wkt" name="wkt" class="form-control" value="<?php echo date('H:i', strtotime($dtjdw['jm_uji'])) . '-' . date('H:i', strtotime($dtjdw['slsai_uji']))	 ?>" readonly>
							</div>
							<div class="col-12 col-lg">
								<label for="awkt">Alokasi Waktu Tes</label>
								<input type="text" id="awkt" name="awkt" class="form-control" value="<?php echo $batas . ' Menit' ?>" readonly>
							</div>
						</div>
						<?php if ($dtjdw['md_uji'] == '0') { ?>
							<div class="row mt-3 bg-danger-subtle">
								<h4 class="col-12 text-center border-bottom shadow-sm">Sifat Tes : <?= ($dtjdw['md_uji'] == '1') ? 'Online' : 'Full Offline'; ?></h4>
								<!-- <p>Sifat Tes : Online <br>
								Selama tes berlangsung peserta dapat malakukan akses internet dengan jaringan yang terhubung dengan sever atau selain server. namum dengan beberapa ketentuan. <br>
								1. apabila link server bersifat lokal maka akses tes hanaya dapat dilakukan dengan jaringan yang tersedia. <br>
								2. jika link bersifat online maka akses tes bisa dilakukan dimana saja.
							</p> -->
								<p style="text-align: justify;">Sifat Tes : Full Offline <br>
									Selama tes berlangsung jangan pernah memutuskan jaringan yang terhubung ke server atau melakukan koneksi selain jaringan yang sudah disediakan apabila melakukan atau menghubungkan perangkat ke internet maka secara otomatis akan terdeteksi dan akun login akan keluar serta akses login akan di blok.
								</p>
							</div>
						<?php } ?>
					</div>
					<div class="card col-md-5 col-12 shadow-lg p-4 gap-2">
						<!-- <p class="fs-5" style="text-align: justify;">Silahkan berdoa sesuai agama dan kepercayaan sebelum mengerjakan soal</p> -->
						<div class="alert alert-warning" role="alert" style=" font-size: 18px;">
							<i class="bi bi-info-circle"></i> Silahkan Berdoa Terlebih Dahulu Sebelum Memulai Tes <br><br>
							<h5 style="text-align: justify;">Doa untuk dijauhkan dari keraguan dan memohon kemuliaan pemahaman</h5>
							<p class="text-end" style="text-align: justify; font-size: 28px;"> اَللّٰهُمَّ اخْرِجْنَا مِنْ ظُلُمَاتِ الْوَهْمِ وَاَكْرِمْنَا بِنُوْرِالْفَهْمِ وَافْتَحْ عَلَيْنَا بِمَعْرِفَتِكَوَسَهِّلْ لَنَآ اَبْوَابَ فَضْلِكَ يَآ اَرْحَمَ الرَّاحِمِيْنَ
							</p>
							<p style="text-align: justify;">
								Bacaan Latin: 
								<br>
								Allahumma akhrijnaa min dhulumaatil wahmi, wa akrimnaa binuuril fahmi, waftah 'alainaa bima'rifatil ilmi, wasahhil lanaa abwaaba fadhlika yaa arhamar raahimin
								<br>
								Artinya: 
								<br>
								"Ya Allah, keluarkanlah kami dari gelapnya keraguan, dan muliakanlah kami dengan cahaya kepahaman. Bukakanlah untuk kami dengan kemakrifatan ilmu dan mudahkanlah pintu karunia-Mu bagi kami, wahat Zat yang Maha Pengasih."
							</p>
						</div>
						<input type="text" name="ip" id="ip" value="<?php echo get_ip(); ?>" hidden>
						<button type="submit" id="mulai" name="mulai" class="btn col-12 
						<?php if ($dtjdw['md_uji'] == '1') echo 'btn-success';
						else echo ' btn-danger'; ?>">MULAI</button>
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
<script>
	document.addEventListener("contextmenu", e => e.preventDefault());
	document.addEventListener("keydown", e => {
		if (e.ctrlKey && ["c", "x", "v", "u"].includes(e.key) ||
			e.key === "F12" || (e.ctrlKey && e.shiftKey && ["I", "J", "C"].includes(e.key))) {
			e.preventDefault();
		}
	});
	document.addEventListener("selectstart", e => e.preventDefault());
</script>