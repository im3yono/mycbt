<?php
include_once("config/server.php");

// Database Error
if ($db_null == 1) {
	if ($_POST['username'] == "admin" && $_POST['password'] == "admin" && get_ip() == "127.0.0.1") {
		header("location:adm/?md=setting");
		setcookie('user', '');
		setcookie('pass', '');
	} elseif (get_ip() != "127.0.0.1") {
		header("location:" . $_SERVER['SCRIPT_NAME'] . "?pesan=db");
	} else {
		header("location:" . $_SERVER['SCRIPT_NAME'] . "?pesan=dblg");
		setcookie('user', '');
		setcookie('pass', '');
	}
}

// if ($_SERVER['REQUEST_METHOD'] == "POST") {
// setcookie('user', $_POST['username']);
// setcookie('pass', $_POST['password']);
// $user = $_POST['user'];
// $pass = $_POST['pass'];

if (isset($_COOKIE['user']) && isset($_COOKIE['pass'])) {
	$user = $_COOKIE['user'];
	$pass = $_COOKIE['pass'];
}
// Login QR-Code
elseif (isset($_REQUEST["du"]) && isset($_REQUEST["dp"])) {
	foreach ($_GET as $loc => $link) {
		$_GET[$loc] = base64_decode(urldecode($link));
		$vari1 = $_GET['du'];
		$vari2 = $_GET['dp'];
	}
	setcookie('user', $vari1, time() + 5400, "/");
	setcookie('pass', $vari2, time() + 5400, "/");
	$user = $vari1;
	$pass = $vari2;
} else {
	$user = $_POST['username'];
	$pass = $_POST['password'];
}

// if ($_REQUEST["usr"] && $_REQUEST["pass"]) {
// 	$user = $_GET['usr'];
// 	$pass = $_GET['pass'];
// }

$qrsis    = mysqli_query($koneksi, "SELECT * FROM cbt_peserta WHERE user ='$user' AND pass='$pass' AND sts='Y';");
$qradm    = mysqli_query($koneksi, "SELECT * FROM user WHERE username='$user' AND pass=md5('$pass') AND sts='Y';");
$ceksis   = mysqli_num_rows($qrsis);
$cekadm   = mysqli_num_rows($qradm);
$dtsis    = mysqli_fetch_array($qrsis);
$dtkls		= mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM kelas WHERE kd_kls = '$dtsis[kd_kls]'"));

// Login Admin
if (!empty($cekadm)) {
	setcookie('user', $user, time() + 3600, "/");
	setcookie('pass', $pass, time() + 3600, "/");
	header("location:adm/");          // halaman tujuan
}
// Login Siswa
elseif (!empty($ceksis)) {
	setcookie('user', $user, time() + 5400, "/");
	setcookie('pass', $pass, time() + 5400, "/");
	// $ck_sis=$dtsis['dt_on'];
	// if (isset($_COOKIE['connectionStatus']) != "online") {
	// 	setcookie('connectionStatus', 'offline', time() + 5400, "/");
	// }

	// Penentu kelas


	// ============================================================  DATA UJI   ============================================================ //
	// $dtujian    = (mysqli_query($koneksi, "SELECT * FROM jdwl WHERE tgl_uji = CURRENT_DATE AND jm_uji <= ADDTIME(CURRENT_TIME, '00:10:00') AND jm_uji >= SUBTIME(CURRENT_TIME, '03:00:00') AND sts ='Y' AND kd_kls ='$dtsis[kd_kls]';"));
	$dtujian    = (mysqli_query($koneksi, "SELECT * FROM jdwl WHERE tgl_uji = CURRENT_DATE AND jm_uji <= ADDTIME(CURRENT_TIME, '00:10:00') AND jm_uji >= SUBTIME(CURRENT_TIME, '02:00:00') AND sts ='Y';"));

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

			// $jmak  = floor(($akhir - $nol) / (60 * 60));
			// $minak = ($akhir - $nol) - ($jmak * (60 * 60));
			// $batas = ($jmak * 60) + floor($minak / 60);
		}
		if ($jam < 10) {
			$jam = '0' . $jam;
		}

		if ($menit < 600) {
			$menit = '0' . floor($menit / 60);
		} else {
			$menit = floor($menit / 60);
		}
		$jamak = $jam . ":" . $menit;

		if ($jamak >= date('h:i')) {
			$lmuj = $dtuj['lm_uji'];
		} else {
			$lmuj = "00:00:00";
		}
	}

	if (!empty($lmuj)) {
		$lm_uj = $lmuj;
	} else {
		$lm_uj = "00:00:00";
	}

	// echo $lm_uj;

	// SELECT * FROM jdwl WHERE tgl_uji = CURRENT_DATE AND jm_uji <= ADDTIME(CURRENT_TIME, '00:10:00') AND jm_uji >= SUBTIME(CURRENT_TIME, '01:00:00') AND sts ='Y' AND (kd_kls = '1' OR kd_kls = 'XA') AND (kls ='1' OR kls='X') AND (jur='1' OR jur='Merdeka')
	$qr_dtjdwl	= mysqli_query($koneksi, "SELECT * FROM jdwl WHERE tgl_uji = CURRENT_DATE AND jm_uji <= ADDTIME(CURRENT_TIME, '00:10:00') AND jm_uji >= SUBTIME(CURRENT_TIME, '$lm_uj') AND sts ='Y'AND (kd_kls = '$dtkls[kd_kls]' OR kd_kls = '1') AND (kls ='$dtkls[kls]' OR kls='1') AND (jur='$dtkls[jur]' OR jur='1');");
	$dtuji    = mysqli_fetch_array($qr_dtjdwl);
	// $dtuji    = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM jdwl WHERE tgl_uji = CURRENT_DATE AND jm_uji <= ADDTIME(CURRENT_TIME, '00:10:00') AND jm_uji >= SUBTIME(CURRENT_TIME, '$lm_uj') AND sts ='Y';"));
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

		while ($a = mysqli_fetch_array($qr_dtjdwl)) {
			echo $a['kd_mpel'] . ', ';
		}

		// data mapel
		$dtpkt    = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM mapel WHERE kd_mpel ='$uj_kdmpel'"));
		$pkt_nm		= $dtpkt['nm_mpel'];

		if ($sts_token == "T") {
			$token = "<i class='text-warning'>MINTA KE PENGAWAS</i>";
		} else {
			$token = $uj_token;
		}
	} else {
		$pkt_nm		= "Belum ada Jadwal Ujian";
	}


	// data kelas
	$dtkls    = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM kelas WHERE kd_kls='$dtsis[kd_kls]';"));
	// data paket
	// $dtpkt    = mysqli_fetch_array(mysqli_query($koneksi, ""));


	if (empty($uj_kls) && empty($uj_kdkls) && empty($uj_jur) && empty($uj_kdmpel)) {
		$m_uji = "Belum Ada Jadwal Ujian";
		// echo "cek 1";
	} elseif ($uj_kls == "1" && $uj_kdkls == "1" && $uj_jur == "1") {
		$m_uji  = "Semua";
		$tgl_uji = $uj_tgluji;
		$jm_uji = $uj_jmuji;
		// echo "cek 2";
	} elseif ($uj_kls == $dtkls['kls'] || $uj_kdkls == $dtkls['kd_kls'] || $uj_jur == $dtkls['jur']) {
		// echo "cek 3";
		$m_uji  = $uj_kds;
		$tgl_uji = $uj_tgluji;
		$jm_uji = $uj_jmuji;
	} else {
		// echo"kosong";
	}
	// 	echo "data".$tgl_uji." ".$uj_kls." ".$uj_kdkls." ".$uj_jur;
	// echo "siswa". $tgl_uji." ".$dtkls['kls']." ".$dtkls['kd_kls']." ".$dtkls['jur']." ".$uj_tgluji;



	if (empty($dtsis['ft'])) {
		$img = "img/noavatar.png";
	} else {
		$img = "pic_sis/" . $dtsis['ft'];
	}
	if (!file_exists("$img")) {
		$img = "img/noavatar.png";
	}
	// }
	// Reques Login
	if ($_SERVER['REQUEST_METHOD'] == "GET") {
		if (isset($_GET["reques"])) {
			$sql_req	= "UPDATE peserta_tes SET rq_rst = 'Y' WHERE peserta_tes.user = '$user' AND kd_soal='$uj_kds' AND token='$uj_token';";
			if (mysqli_query($koneksi, $sql_req)) {
				echo '<script>window.location="logout.php?info=tunggu"</script>';
			}
		}
	}
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

		<script src="node_modules/sweetalert2/dist/sweetalert2.min.js"></script>
		<link rel="stylesheet" href="node_modules/sweetalert2/dist/sweetalert2.min.css">
		<script src="node_modules/jquery/dist/jquery.min.js"></script>
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
			width: 200px;
			height: 200px;
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
			<div class="row gap-4 justify-content-center mx-3">
				<div class="card shadow-lg col-lg-3 p-3 gap-1 fs-5">
					<h4 class="col-12 text-center border-bottom">Konfirmasi Data Peserta</h4>
					<div class="col-12 text-center">
						<img src="<?php echo $img ?>" alt="" class="img-thumbnail img">
					</div>
					<div class="col-12 text-center">
						<label class="col-12 text-center"><?php echo $dtsis['nm'] ?></label>
						<label class="col-12 text-center"><?php echo $dtsis['nis'] ?></label>
					</div>
					<div class="col-12 text-center">
						<button class="btn btn-danger" type="button" id="logout" name="logout">Keluar</button>
					</div>
				</div>
				<div class="card col shadow-lg p-3 gap-2">
					<h4 class="col-12 text-center border-bottom mb-3">DATA PESERTA</h4>
					<?php
					if (empty($uj_kdmpel) && empty($uj_token)) {
						$uj_kdmpel	= "";
						$uj_token		= "";
					}
					$uji_cek = (mysqli_query($koneksi, "SELECT * FROM peserta_tes WHERE user ='$user' AND token='$uj_token' AND kd_mpel ='$uj_kdmpel';"));
					$uji_cek2 = mysqli_fetch_array($uji_cek);
					$uji_cek3 = mysqli_num_rows($uji_cek);
					if (!empty($uji_cek3)) {
						if ($uji_cek2['ip'] == "") {
							$ip = get_ip();
						} else {
							$ip	= $uji_cek2['ip'];
						}
					} else {
						$ip = get_ip();
					}
					if (get_ip() != $ip) { ?>
						<div class="alert alert-danger text-center fs-5" role="alert">
							Anda Sudah login ditempat lain
						</div>
						<form action="" method="get">
							<div class="col-12 text-center">
								<button class="btn btn-danger" id="reques" name="reques">Request Reset Login</button>
							</div>
						</form>
					<?php } elseif (!empty($uji_cek2['dt_on']) == "1") { ?>
						<div class="alert alert-danger text-center fs-5" role="alert">
							Anda Belum Dapat Izin Segera Lapor Ke Pengawas
						</div>
						<div class="col text-center">
							<button type="button" class="btn btn-info" onclick="window.location.reload();"><i class="bi bi-arrow-clockwise"></i> Reload</button>
						</div>
						<?php } else {
						if (!empty($dtuji)) { ?>
							<div class="col-12 text-center mb-2 text-white"><label class="time me-2" id="lm_ujian">Timer Ujian</label></div>
						<?php } ?>
						<div class="row justify-content-evenly g-1 fs-5">
							<div class="col-12 col-md-5 mb-2">
								<label for="nm">Nama Peserta</label>
								<input type="text" id="nm" name="nm" class="form-control" value="<?php echo $dtsis['nm'] ?>" readonly>
							</div>
							<div class="col-12 col-md-5 mb-2">
								<label for="jns">Jenis Kelamin</label>
								<input type="text" id="jns" name="jns" class="form-control" value="<?php if ($dtsis['jns_kel'] == "L") {
																																											echo "Laki-Laki";
																																										} else {
																																											echo "Perempuan";
																																										} ?>" readonly>
							</div>
							<div class="col-12 col-md-5 mb-2">
								<label for="usr">Username</label>
								<input type="text" id="usr" name="usr" class="form-control" value="<?php echo $dtsis['user'] ?>" readonly>
							</div>
							<div class="col-12 col-md-5 mb-2">
								<label for="sts">Status Peserta</label>
								<input type="text" id="sts" name="sts" class="form-control" value="<?php echo $dtsis['nm'] . ' (' . $dtkls['kls'] . ' | ' . $dtkls['jur'] . ' | Sesi ' . $dtsis['sesi'] . ' )'; ?>" readonly>
							</div>
							<?php if (!empty($dtuji)) { ?>
								<div class="col-12 col-md-5 mb-2">
									<label for="sts_uji">Status Mata Pelajaran Ujian</label>
									<input type="text" id="sts_uji" name="sts_uji" class="form-control" value="<?php echo $pkt_nm; ?>" readonly>
								</div>
								<div class=" mb-3 col-md-5 col-12">
									<?php
									$sts_uji = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM peserta_tes WHERE user='$user' AND kd_soal='$uj_kds'AND token='$uj_token'"));
									if (empty($sts_uji['sts'])) {
										$x = "";
									} else {
										$x = $sts_uji['sts'];
									}
									if ($x == "S") {
									?>
										<label for="sts">Status Ujian</label>
										<input type="text" class="form-control bg-warning" value="Anda Telah Selesai Mengikuti Ujian" readonly>
										<!-- <button class="btn btn-danger mt-2" type="submit" id="logout" name="logout">Keluar</button> -->
									<?php } else { ?>
										<form action="" method="post">
											<!-- <input type="text" name="user" id="user" value="<?php echo $user ?>">
											<input type="text" name="pass" id="pass" value="<?php echo $pass ?>"> -->
											<div class="form-floating">
												<input type="text" name="kds" id="kds" value="<?php echo $uj_kds; ?>" hidden>
												<!-- <input type="text" name="token2" id="token2" value="<?php echo $token ?>" hidden> -->
												<input type="text" class="form-control mb-2" id="token" name="token" placeholder="Token" required disabled>
												<label for="token" id="lbl_tkn">UJIAN AKAN SEGERA DIMULAI</label>
												<div class="row g-2 my-1 justify-content-between">
													<div class="col-md-auto col">
														<i for="">Token : </i>
														<span class="badge bg-info fs-6 fw-light" id="tk">Token Belum Tersedia</span>
														<!-- <span class="badge bg-info fs-6" id="tki">Token Belum Tersedia</span> -->
													</div>
													<div class="col-md-auto col-12 text-center text-md-start pt-3 pt-md-0">
														<button class="btn btn-primary btn-lg btn-md-sm text-uppercase" type="submit" id="konf" name="konf" disabled>Konfirmasi</button>
													</div>
												</div>
											</div>
										</form>
									<?php } ?>
								</div>
							<?php } ?>
						</div>
					<?php } ?>
				</div>
			</div>
		</div>
		<footer>
			<div class="col-12 bg-dark text-white text-center fixed-bottom" style="height: 30px;"><?php include_once("config/about.php") ?></div>
		</footer>
	</body>

	</html>


	<!-- === JavaScript -->
	<script src="node_modules/jquery/dist/jquery.js"></script>
	<?php if (!empty($uji_cek2['dt_on']) == "0") { ?>
	<script>
		// Mengatur waktu akhir perhitungan mundur
		var countDownDate = new Date("<?php echo $tgl_uji . ' ' . $jm_uji ?>").getTime();

		// Memperbarui hitungan mundur setiap 1 detik
		var x = setInterval(function() {
			// Fungsi untuk mendapatkan waktu server
			async function getServerTime() {
				try {
					let response = await fetch('./config/time_svr.php');
					if (!response.ok) {
						throw new Error('Network response was not ok');
					}
					let data = await response.json();
					return new Date(data.server_time).getTime();
				} catch (error) {
					console.error('Ada masalah dengan fetch operation:', error);
					return null;
				}
			}

			getServerTime().then(serverTime => {
				if (serverTime) {
					// Temukan jarak antara sekarang dan tanggal hitung mundur
					var now = serverTime;
					var distance = countDownDate - now;

					// Perhitungan waktu untuk hari, jam, menit, dan detik
					var days = Math.floor(distance / (1000 * 60 * 60 * 24));
					var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
					var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
					var seconds = Math.floor((distance % (1000 * 60)) / 1000);

					if (minutes < 10) minutes = "0" + minutes;
					if (seconds < 10) seconds = "0" + seconds;

					// Keluarkan hasil dalam elemen dengan id = "lm_ujian"
					if (days != 0) {
						document.getElementById("lm_ujian").innerHTML = days + " Hari, " + hours + ":" + minutes + ":" + seconds;
					} else if (hours != 0) {
						document.getElementById("lm_ujian").innerHTML = hours + ":" + minutes + ":" + seconds;
					} else if (minutes != 0) {
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
							// document.getElementById("tk").hidden = false;
							document.getElementById("tk").innerHTML = "<?php echo $token ?>";
							// document.getElementById("tki").hidden = true;
							// document.getElementById("tki").innerHTML = "<?php echo $token ?>";
							document.getElementById("lbl_tkn").innerHTML = "Masukkan Token";
						<?php } ?>
					}
				}
			});
		}, 1000);
	</script>
<?php } ?>
<?php
} elseif (empty($cekadm) && empty($ceksis)) {
	// echo '<meta http-equiv="refresh" content="0;url=/>';
	// header("location:login.php");          // halaman tujuan
	include_once("login.php");
	setcookie('user', '');
	setcookie('pass', '');
}
?>

<!-- <script type="text/javascript">
    window.setTimeout( function() {
  window.location.reload();
	document.cookie = "user=";
	document.cookie = "pass=";
}, 300000);
</script> -->
<?php
if (isset($_REQUEST['knf']) == "") {
} elseif (($_REQUEST['knf']) == "rest") { ?>
	<script> </script>
	<script>
		Swal.fire({
			icon: 'info',
			title: 'Admin',
			text: 'Silahkan Untuk Melanjutkan Kembali',
			backdrop: 'rgba(0,0,0,0.7)',
			allowOutsideClick: false,
			allowEscapeKey: false,
			// footer: '<a href="">Why do I have this issue?</a>'
		}).then((result) => {
			if (result.isConfirmed) {
				window.location = "<?php echo $fd_root ?>";
				// window.location = "<?php echo $_SERVER['REQUEST_URI']; ?>";
			}
		})
	</script>
<?php
}
?>
<script>
	$(document).ready(function() {
		$("#logout").click(function() {
			window.location.replace('logout.php');
		})
	})
</script>