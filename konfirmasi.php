<?php
include_once("config/server.php");

// if ($_SERVER['REQUEST_METHOD'] == "POST") {
// setcookie('user', $_POST['username']);
// setcookie('pass', $_POST['password']);
// $user = $_POST['user'];
// $pass = $_POST['pass'];

if (isset($_COOKIE['user']) && isset($_COOKIE['pass'])) {
	$user = $_COOKIE['user'];
	$pass = $_COOKIE['pass'];
} else {
	setcookie('user', $_POST['username'], time() + 36000);
	setcookie('pass', $_POST['password'], time() + 36000);
	$user = $_POST['username'];
	$pass = $_POST['password'];
}


$qrsis    = mysqli_query($koneksi, "SELECT * FROM cbt_peserta WHERE user ='$user' AND pass='$pass' AND sts='Y';");
$qradm    = mysqli_query($koneksi, "SELECT * FROM user WHERE username='$user' AND pass=md5('$pass') AND sts='Y';");
$ceksis   = mysqli_num_rows($qrsis);
$cekadm   = mysqli_num_rows($qradm);
$dtsis    = mysqli_fetch_array($qrsis);

if (!empty($cekadm)) {
	header("location:adm/index.php");          // halaman tujuan
} elseif (!empty($ceksis)) {

	// data ujian
	$dtujian    = (mysqli_query($koneksi, "SELECT * FROM jdwl WHERE tgl_uji = CURRENT_DATE AND jm_uji <= ADDTIME(CURRENT_TIME, '00:10:00') AND jm_uji >= SUBTIME(CURRENT_TIME, '03:00:00') AND sts ='Y';"));

	while ($dtuj = mysqli_fetch_array($dtujian)) {
		if (!empty($dtuj['jm_uji'])) {
			$waktu_awal		= $dtuj['jm_uji'];
			$waktu_akhir	= $dtuj['lm_uji']; // bisa juga waktu sekarang now()

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
		}
		if ($jam < 10) {
			$jam= '0' . $jam;
		} 
		
		if ($menit < 600) {
			$menit= '0' . floor($menit / 60);
		} else {
			$menit= floor($menit / 60);
		}
		$jamak = $jam.":".$menit;
		
		if ($jamak >= date('h:i')) {
			$lmuj=$dtuj['lm_uji'];
		}else{
			$lmuj="00:00:00";
		}

	}

	if (!empty($lmuj)) {
		$lm_uj=$lmuj;
	}else{
		$lm_uj="00:00:00";
	}


	$dtuji    = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM jdwl WHERE tgl_uji = CURRENT_DATE AND jm_uji <= ADDTIME(CURRENT_TIME, '00:10:00') AND jm_uji >= SUBTIME(CURRENT_TIME, '$lm_uj') AND sts ='Y';"));
	// $qrjdw    = mysqli_query($koneksi, "SELECT * FROM jdwl ");

	if (!empty($dtuji)) {
		$uj_kdmpel	= $dtuji['kd_mpel'];
		$uj_kdkls		= $dtuji['kd_kls'];
		$uj_kls			= $dtuji['kls'];
		$uj_jur			= $dtuji['jur'];
		$uj_kds			= $dtuji['kd_soal'];
		$uj_jmuji		= $dtuji['jm_uji'];
		$uj_tgluji	= $dtuji['tgl_uji'];
		$uj_token		= $dtuji['token'];
		$sts_token	= $dtuji['sts_token'];

		if ($sts_token == "T") {
			$uj_token = '<i class="text-warning">MINTA KE PENGAWAS</i>';
		}

		// data mapel
		$dtpkt    = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM mapel WHERE kd_mpel ='$uj_kdmpel'"));
		$pkt_nm		= $dtpkt['nm_mpel'];
	} else {
		$pkt_nm		= "Belum ada Jadwal Ujian";
	}


	// data kelas
	$dtkls    = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM kelas WHERE kd_kls='$dtsis[kd_kls]';"));
	// data paket
	// $dtpkt    = mysqli_fetch_array(mysqli_query($koneksi, ""));

	if (empty($uj_kls) && empty($uj_kdkls) && empty($uj_jur)) {
		$m_uji = "Belum Ada Jadwal Ujian";
	} else
	if ($uj_kls == "1" && $uj_kdkls == "1" && $uj_jur == "1") {
		$m_uji  = "Semua";
	} elseif ($uj_kls == $dtkls['kls'] && $uj_kdkls == $dtkls['kd_kls'] && $uj_jur == $dtkls['jur']) {

		$m_uji  = $uj_kds;
		$tgl_uji = $uj_tgluji;
		$jm_uji = $uj_jmuji;
	} else {
	}

	if (empty($dtsis['ft'])) {
		$img = "img/noavatar.png";
	} else {
		$img = "pic_sis/" . $dtsis['ft'];
	}

	// }
?>
	<!DOCTYPE html>
	<html lang="en">

	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Konfirmasi | <?php echo $inf['nmpt'] ?></title>
		<!-- <title><?php echo $inf['nmpt'] ?></title> -->
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
			<div class="row gap-4 justify-content-center mx-3">
				<div class="card shadow-lg col-lg-3 p-3 gap-1 fs-5">
					<h4 class="col-12 text-center border-bottom">Konfirmasi Data Peserta</h4>
					<div class="col-auto text-center">
						<img src="<?php echo $img ?>" alt="" class="img-thumbnail img">
					</div>
					<label class="col-12 text-center"><?php echo $dtsis['nm'] ?></label>
					<label class="col-12 text-center"><?php echo $dtsis['nis'] ?></label>
				</div>
				<div class="card col shadow-lg p-3 gap-2">
					<h4 class="col-12 text-center border-bottom mb-3">DATA PESERTA</h4>
					<?php if (!empty($dtuji)) { ?>
						<div class="col-12 text-center mb-2 text-white"><label class="time me-2" id="lm_ujian">Timer Ujian</label></div>
					<?php } ?>
					<div class="row justify-content-evenly g-1 fs-5">
						<div class="col-12 col-md-5 mb-2">
							<label for="nm">Nama Peserta</label>
							<input type="text" id="nm" name="nm" class="form-control" value="<?php echo $dtsis['nm'] ?>" readonly>
						</div>
						<div class="col-12 col-md-5 mb-2">
							<label for="usr">Username</label>
							<input type="text" id="usr" name="usr" class="form-control" value="<?php echo $dtsis['user'] ?>" readonly>
						</div>
						<div class="col-12 col-md-5 mb-2">
							<label for="sts">Status Peserta</label>
							<input type="text" id="sts" name="sts" class="form-control" value="<?php echo $dtsis['nm'] . ' (' . $dtkls['kls'] . ' | ' . $dtkls['jur'] . ' | Sesi ' . $dtsis['sesi'] . ' )'; ?>" readonly>
						</div>
						<div class="col-12 col-md-5 mb-2">
							<label for="jns">Jenis Kelamin</label>
							<input type="text" id="jns" name="jns" class="form-control" value="<?php if ($dtsis['jns_kel'] == "L") {
																																										echo "Laki-Laki";
																																									} else {
																																										echo "Perempuan";
																																									} ?>" readonly>
						</div>
						<?php if (!empty($dtuji)) { ?>
							<div class="col-12 col-md-5 mb-2">
								<label for="sts_uji">Status Ujian</label>
								<input type="text" id="sts_uji" name="sts_uji" class="form-control" value="<?php echo $pkt_nm; ?>" readonly>
							</div>
							<div class=" mb-3 col-md-5 col-12">
								<form action="" method="post">
									<div class="form-floating">
										<input type="text" name="kds" id="kds" value="<?php echo $uj_kds; ?>" hidden>
										<input type="text" class="form-control mb-2" id="token" name="token" placeholder="Token" required disabled>
										<label for="token">Token</label>
										<button class="btn btn-primary me-4" type="submit" id="konf" name="konf" disabled>Konfirmasi</button>
										<i for="">Token : </i>
										<span class="badge bg-primary fs-6" hidden id="tk"><?php echo $uj_token ?></span>
										<span class="badge bg-info fs-6" id="tki">Ujian Belum dimulai</span>
									</div>
								</form>
							</div>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
		<footer>
			<div class="col-12 bg-dark text-white text-center fixed-bottom" style="height: 30px;"><?php include_once("config/about.php") ?></div>
		</footer>
	</body>

	</html>


	<!-- === JavaScript -->
	<script>
		// Mengatur waktu akhir perhitungan mundur
		var countDownDate = new Date("<?php echo $tgl_uji . ' ' . $jm_uji ?>").getTime();


		// Memperbarui hitungan mundur setiap 1 detik
		var x = setInterval(function() {

			// Untuk mendapatkan tanggal dan waktu hari ini
			// var now = new Date().getTime();
			// Jam Server
			var xmlHttp;

			function srvTime() {
				try {
					//FF, Opera, Safari, Chrome
					xmlHttp = new XMLHttpRequest();
				} catch (err1) {
					//IE
					try {
						xmlHttp = new ActiveXObject('Msxml2.XMLHTTP');
					} catch (err2) {
						try {
							xmlHttp = new ActiveXObject('Microsoft.XMLHTTP');
						} catch (eerr3) {
							//AJAX not supported, use CPU time.
							alert("AJAX not supported");
						}
					}
				}
				xmlHttp.open('HEAD', window.location.href.toString(), false);
				xmlHttp.setRequestHeader("Content-Type", "text/html");
				xmlHttp.send('');
				return xmlHttp.getResponseHeader("Date");
			}

			var st = srvTime();
			var now = new Date(st);

			// Temukan jarak antara sekarang dan tanggal hitung mundur
			var distance = countDownDate - now;

			// Perhitungan waktu untuk hari, jam, menit dan detik
			var days = Math.floor(distance / (1000 * 60 * 60 * 24));
			var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
			var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
			var seconds = Math.floor((distance % (1000 * 60)) / 1000);

			if (minutes < "10") {
				minutes = "0" + minutes
			}
			if (seconds < "10") {
				seconds = "0" + seconds
			}

			// Keluarkan hasil dalam elemen dengan id = "lm_ujian"
			if (days != "0") {
				document.getElementById("lm_ujian").innerHTML = days + " Hari, " + hours + ":" + minutes + ":" + seconds;
			} else if (hours != "0") {
				document.getElementById("lm_ujian").innerHTML = hours + ":" + minutes + ":" + seconds;
			} else if (minutes != "0") {
				document.getElementById("lm_ujian").innerHTML = minutes + ":" + seconds;
			} else {
				document.getElementById("lm_ujian").innerHTML = seconds;
			}

			// Jika hitungan mundur selesai, tulis beberapa teks 
			if (distance < 0) {
				<?php if (!empty($tgl_uji)) { ?>
					clearInterval(x);
					document.getElementById("lm_ujian").innerHTML = "Silahkan Masukkan Token Untuk Mengikuti Ujian";
					document.getElementById("lm_ujian").style.backgroundColor = "#00ff00";
					document.getElementById("lm_ujian").style.borderColor = "#00ff00";
					document.getElementById("token").disabled = false;
					document.getElementById("konf").disabled = false;
					document.getElementById("tk").hidden = false;
					document.getElementById("tki").hidden = true;
				<?php } ?>
			}

		}, 1000);
	</script>

<?php
} else {
	// echo '<meta http-equiv="refresh" content="0;url=/>';
	// header("location:login.php");          // halaman tujuan
	include_once("login.php");
	setcookie('user', '', time() + 36000);
	setcookie('pass', '', time() + 36000);
}
?>