<?php
include_once("config/server.php");
if (empty($_COOKIE['user'])) {
	header('location:/tbk/');
} else {
	$userlg = $_COOKIE['user'];
	$token	= $_POST['kt'];
	$kds		= $_POST['kds'];
	$ip			= $_POST['ip'];

	// echo $userlg." ".$token." ".$kds;
}

$dtps_uji	= mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM cbt_peserta WHERE user ='$userlg'"));
$dtkls		= mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM kelas WHERE kd_kls='$dtps_uji[kd_kls]'"));
$dtjdwl		= mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM jdwl WHERE token='$token' AND kd_soal='$kds'"));
$dtpkt		= mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM cbt_pktsoal WHERE kd_soal='$kds'"));
// $dts			= mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM cbt_soal WHERE kd_soal='$dtjdwl[kd_soal]'"));
$jum_soal	= $dtpkt['jum_soal'];

// ===========================================...CEK LEMBAR JAWABAN...=========================================== //
$ljk_cek	= mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM cbt_ljk WHERE user_jawab ='$userlg' AND token='$token' AND kd_soal='$kds'"));
$up_uji = "UPDATE peserta_tes SET ip = '$ip' WHERE user ='$userlg' AND token='$token' AND kd_soal='$kds';";
$uji_cek = mysqli_query($koneksi, "SELECT * FROM peserta_tes WHERE user ='$userlg' AND token='$token' AND kd_soal='$kds'");
$ip_cek = mysqli_fetch_array($uji_cek);

if ($ljk_cek != $jum_soal) {
	// $nos = 1;
	$dts_t	= mysqli_query($koneksi, "SELECT * FROM cbt_soal WHERE kd_soal='$kds' ORDER BY no_soal LIMIT $jum_soal;");

	$uji = "INSERT INTO peserta_tes (id_tes, id_ujian, kd_soal, user, sesi, ruang, nis, kd_kls, kd_mpel, pilgan, esai, jum_soal, tgl_uji, jm_uji, jm_lg, jm_out, lm_uji, token, ip, sts) VALUES (NULL, '$dtjdwl[id_ujian]', '$kds', '$userlg', '$dtps_uji[sesi]', '$dtps_uji[ruang]', '$dtps_uji[nis]', '$dtps_uji[kd_kls]', '$dtpkt[kd_mpel]', '$dtpkt[pilgan]', '$dtpkt[esai]', '$dtpkt[jum_soal]', '$dtjdwl[tgl_uji]', '$dtjdwl[jm_uji]', CURRENT_TIME, '', '', '$token', '$ip', 'U')";

	if (empty(mysqli_num_rows($uji_cek))) {
		mysqli_query($koneksi, $uji);
	} else {
		if (empty($ip_cek['ip'])) {
			mysqli_query($koneksi, $up_uji);
		}
		// elseif ($ip_cek['ip'] != get_ip()) {
		// 	echo '<script>window.location="logout.php?info=on"</script>';
		// }
	}
	// Buat Lembar Jawab
	// Mengambil data dari Database
	// Memuat data ke dalam array
	while ($row = mysqli_fetch_array($dts_t)) {
		$data_all[] = $row;
		if ($row["ack_soal"] == "Y") {
			$data_ack[] = $row;
		} else {
			$data_tdkack[] = $row;
		}
	}

	$nos = 1;
	$dt = 0;
	$ndt = 0;
	shuffle($data_ack);
	// foreach ($data_ack as $dd) {
	// 	echo $dd["no_soal"] . " ";
	// }

	// Menampilkan hasil pengacakan
	foreach ($data_all as $d_all) {
		// No Tidak Acak
		if (!empty($data_tdkack)) {
			foreach ($data_tdkack as $dataack) {
				$ab = array("1", "2", "3", "4", "5");
				if ($dataack['ack_opsi'] == "Y") {
					shuffle($ab);
				}
				$A = $ab[0];
				$B = $ab[1];
				$C = $ab[2];
				$D = $ab[3];
				$E = $ab[4];
				$var = array_search($dataack['knci_pilgan'], $ab);
				$key = $var + 1;
				if ($key == "1") {
					$key = $A;
				}
				if ($key == "2") {
					$key = $B;
				}
				if ($key == "3") {
					$key = $C;
				}
				if ($key == "4") {
					$key = $D;
				}
				if ($key == "5") {
					$key = $E;
				}
				if ($dataack['jns_soal']=="E") {
					$key = "N";
				}
				if ($d_all["no_soal"] == $dataack["no_soal"]) {
					if ($dataack["ack_soal"] == "N") {
						$nos = $dataack["no_soal"];
						// echo $nos . ". Data: " . $dataack["ack_soal"] . " - ID: " . $dataack["no_soal"] . "<br>";
						// Query Lembar jawaban Tidak Acak
						$sql_lj = "INSERT INTO cbt_ljk (id, urut, user_jawab, token, kd_soal, no_soal, jns_soal, kd_mapel, kd_kls, kd_jur, A, B, C, D, E, jwbn, nil_jwb, knci_jwbn, nil_pg, es_jwb, nil_esai, tgl, jam) VALUES (NULL, '$nos', '$userlg', '$token', '$kds', '$dataack[no_soal]', '$dataack[jns_soal]', '$dataack[kd_mapel]', '$dtkls[kd_kls]', '$dtkls[jur]', '$A', '$B', '$C', '$D', '$E', 'N', '0', '$key', 'N', '', '0', CURRENT_DATE, CURRENT_TIME);";

						$ckno = mysqli_query($koneksi, "SELECT * FROM cbt_ljk WHERE user_jawab ='$userlg' AND urut ='$nos' AND kd_soal= '$kds'");
						if (empty(mysqli_num_rows($ckno))) {
							mysqli_query($koneksi, $sql_lj);
						}
						$dt - 1;
						$ndt++;
					}
				}
			}
		}

		// No Acak
		if (!empty($data_ack)) {
			foreach ($data_ack as $dt => $data) {
				$ab = array("1", "2", "3", "4", "5");
				if ($data['ack_opsi'] == "Y") {
					shuffle($ab);
				}
				$A = $ab[0];
				$B = $ab[1];
				$C = $ab[2];
				$D = $ab[3];
				$E = $ab[4];
				$var = array_search($data['knci_pilgan'], $ab);
				$key = $var + 1;
				if ($key == "1") {
					$key = $A;
				}
				if ($key == "2") {
					$key = $B;
				}
				if ($key == "3") {
					$key = $C;
				}
				if ($key == "4") {
					$key = $D;
				}
				if ($key == "5") {
					$key = $E;
				}
				if ($d_all["no_soal"] - $ndt == $dt + 1) {
					if ($d_all["ack_soal"] == "Y") {
						// echo $no . ". Data: " . $data["ack_soal"] . " - ID: " . $data["no_soal"] . "ac <br>";
						// Query Lembar jawaban Acak
						$sql_lj = "INSERT INTO cbt_ljk (id, urut, user_jawab, token, kd_soal, no_soal, jns_soal, kd_mapel, kd_kls, kd_jur, A, B, C, D, E, jwbn, nil_jwb, knci_jwbn, nil_pg, es_jwb, nil_esai, tgl, jam) VALUES (NULL, '$nos', '$userlg', '$token', '$kds', '$data[no_soal]', '$data[jns_soal]', '$data[kd_mapel]', '$dtkls[kd_kls]', '$dtkls[jur]', '$A', '$B', '$C', '$D', '$E', 'N', '0', '$key', 'N', '', '0', CURRENT_DATE, CURRENT_TIME);";

						$ckno = mysqli_query($koneksi, "SELECT * FROM cbt_ljk WHERE user_jawab ='$userlg' AND urut ='$nos' AND kd_soal= '$kds'");
						if (empty(mysqli_num_rows($ckno))) {
							mysqli_query($koneksi, $sql_lj);
							// }
						}
					}
				}
			}
		}
		$nos++;
	}
} elseif (empty($ip_cek['ip'])) {
	mysqli_query($koneksi, $up_uji);
}
// ========================================...AKHIR CEK LEMBAR JAWABAN...======================================== //


// ============================================...WAKTU...============================================ //

$dt_usrlg0 = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM peserta_tes  WHERE user='$userlg' AND kd_soal='$kds' AND token ='$token'"));
	if ($dt_usrlg0['jm_uji']!=$dtjdwl['jm_uji']) {
		$jm_up = date('H:i:s');
		mysqli_query($koneksi,"UPDATE peserta_tes SET jm_uji = '$dtjdwl[jm_uji]', jm_lg = '$jm_up' WHERE user='$userlg' AND kd_soal='$kds' AND token ='$token'");

	}
	$dt_usrlg = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM peserta_tes  WHERE user='$userlg' AND kd_soal='$kds' AND token ='$token'"));
if ($dtjdwl['jm_tmbh'] != "00:00:00") {
	list($tbh_jam, $tbh_menit, $tbh_detik) = explode(':', $dtjdwl['jm_tmbh']);
	if ($tbh_jam!="00") {
		$tbh_jam=$tbh_jam.":";
	} else {$tbh_jam="";}
	if ($tbh_menit!="00") {
		$tbh_menit=$tbh_menit.":";
	}  else {$tbh_menit="";}
	if ($tbh_detik=="00") {
		$tbh_detik="00";
	}
	
	$wkt_tambah = $tbh_jam.$tbh_menit.$tbh_detik;
}
if (!empty($dtjdwl['jm_uji'])) {
	if (strtotime($dtjdwl['bts_login']) > strtotime($dt_usrlg['jm_lg'])) {
		$jm_awal = $dt_usrlg['jm_lg'];
	} else {
		$jm_awal = $dt_usrlg['jm_uji'];
	}
	// if (!empty($jm_up)) {
	// 	$waktu_awal		= $jm_up;
	// } else {
	// 	$waktu_awal		= $jm_awal;
	// }
	
	$waktu_awal		= $jm_awal;
	// $waktu_awal		= $dtjdwl['jm_uji'];
	$waktu_akhir	= $dtjdwl['lm_uji'];

	$awal  = strtotime(($waktu_awal));
	$akhir = strtotime(($waktu_akhir));
	// $awal  = strtotime("08:00:00");
	// $akhir = strtotime("02:00:00");
	$nos = strtotime("00:00:00");
	$diff  = ($awal - $nos) + ($akhir - $nos);

	$jam   = floor($diff / (60 * 60));
	$menit = $diff - ($jam * (60 * 60));
	$detik = $diff % 60;

	$jmak  = floor(($akhir - $nos) / (60 * 60));
	$minak = ($akhir - $nos) - ($jmak * (60 * 60));
	$batas = ($jmak * 60) + floor($minak / 60);

	$tgl = $dtjdwl['tgl_uji'];

	if ($jam > 23) {
		$jam1 =  $jam - 24;
		$tgl  = date('Y-m-d', strtotime('+1 days', strtotime($tgl)));
	} else {
		$jam1 =  $jam;
	}

	if ($jam1 < 10) {
		$jam1 = '0' . $jam1;
	}

	if ($menit < 600) {
		$menit1 =  '0' . floor($menit / 60);
	} else {
		$menit1 =  floor($menit / 60);
	}
	$jam_ak = $jam1 . ':' . $menit1;

	$wktu = $tgl . ' ' . $jam_ak . ':00';
}


if (!empty($dtps_uji['ft'])) {
	$ft = "pic_sis/" . $dtps_uji['ft'];
} else {
	$ft = "pic_sis/noavatar.png";
}
// ========================================...AKHIR WAKTU...======================================== //

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
	<link rel="stylesheet" href="style_ujian.css">
	<!-- <script src="aset/time.js"></script> -->
</head>
<!-- CSS Kostum -->


<body id="main" class="main">
	<div class="head container-fluid pt-md-5 pt-3">
		<div class=" row justify-content-around">
			<div class="col-md-5 text-center text-md-start">
				<img class="img-fluid" src="img/logo.png" alt="">
			</div>
			<div class="col-md-5 text-md-end text-start mt-2">
				<div class="row justify-content-md-end justify-content-center">
					<div class="col-auto"><img src="<?php echo $ft ?>" class="img-thumbnail" style="width: 50px; height: 65px;" alt="" srcset=""></div>
					<div class="col-auto">
						<p class="text-light"><?php echo $dtps_uji['nm'] ?> <br> <?php echo $dtkls['nm_kls'] ?></p>
					</div>

				</div>
			</div>
		</div>
	</div>
	<div class="container-fluid pb-3" style="margin-top: -30px;font-family: Times New Roman;">
		<div class="card shadow mb-3 mx-3 sticky-top z-1" id="bar">
			<div class="row p-2 justify-content-around">
				<div class="col-sm-auto col-12 h3 mx-5 text-center text-sm-start">
					<label class="fw-semibold">No.</label>
					<div class="badge bg-primary text-wrap" id="nos" style="width: auto;">1</div>
				</div>
				<div class="col-sm-auto col-12 p-1" id="jb"></div>
				<div class="col text-center text-sm-end">
					<label class="time me-2" id="lm_ujian">Waktu Ujian</label>
					<?php if (!empty($wkt_tambah)) {
						# code...
						echo '
					<label class="time bg-i me-2" >+' . $wkt_tambah . ' </label>';
					} ?>
					<!-- <button class="btn btn-primary mx-3" onclick="openNav()">&#9776; Daftar Soal</button> -->
					<button class="btn btn-primary mx-3" type="button" data-bs-toggle="offcanvas" data-bs-target="#list_soal" aria-controls="list_soal">&#9776; Daftar Soal</button>
				</div>
			</div>
		</div>
		<div class="card shadow-lg m-3 p-4">
			<div class="border" style="border-radius: 7px;">
				<div id="soal"></div>
				<?php
				// include_once("soal.php?kds=X_BIndo&nos=16");
				?>
				<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> -->
				<script src="node_modules/jquery/dist/jquery.min.js"></script>
				<script>
					// soal.php
					$(document).ready(function() {
						var nsoal = document.getElementById("nos").innerHTML;

						function fetchData() {
							$.ajax({
								type: "GET",
								url: "soal.php?usr=<?php echo $userlg ?>&tkn=<?php echo $token ?>&kds=<?php echo $kds ?>&nos=" + nsoal,
								success: function(response) {
									$("#soal").html(response);
								}
							});
						}

						// Fetch data initially when the page loads
						fetchData();

						// Fetch data when a button is clicked
						$("#refresh-button").click(function() {
							fetchData();
						});
					});
				</script>
			</div>
		</div>
	</div>
	<div class="row m-3 justify-content-around text-center gap-2">
		<button class="btn col-sm-3 fs-5 btnr btn-primary fw-semibold" id="btn_pr" hidden>Sebelumnya</button>
		<button class="btn col-sm-3 fs-5 btnr btn-warning fw-semibold" id="btn_rr">Ragu-Ragu</button>
		<button class="btn col-sm-3 fs-5 btnr btn-primary fw-semibold" id="btn_nx">Berikutnya</button>
		<button class="btn col-sm-3 fs-5 btnr btn-primary fw-semibold" id="btn_end" hidden>Selesai</button>
	</div>
	</div>
	<footer>
		<div class="col-12 bg-dark text-white text-center" style="height: 30px;"><?php include_once("config/about.php") ?></div>
	</footer>
</body>

</html>

<!-- === Slide === -->
<!-- <div id="df_soal" class="sidenav bg-dark z-3">
	<a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
	<h4 class="text-light m-4">Pilihan Ganda</h4>
	<?php
	$ls_soal = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM cbt_ljk WHERE kd_soal ='$kds'"));
	$a = 1;
	while ($a <= $ls_soal) {
		echo "
		<button type='button' class='btn btn-light position-relative ms-3 mb-3 text-center' style='width: 40px;'>
		$a
		<span class='position-absolute top-0 start-100 translate-middle badge rounded-pill bg-info'>
			A
		</span>
	</button>
		 ";
		$a++;
	}
	?>
	<h4 class="text-light m-4">Esai</h4>
</div> -->

<div class="offcanvas offcanvas-end bg-light" tabindex="-1" id="list_soal" aria-labelledby="list_soalLabel">
	<div class="offcanvas-header">
		<button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
		<h4 class="mx-4">Daftar Soal</h4>
	</div>
	<div id="lst_soal"></div>
	<?php
	// $ckpg = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM cbt_ljk WHERE user_jawab='tri'"));
	// $ckes = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM cbt_ljk WHERE jns_soal = 'E'"));
	$ls_pg = (mysqli_query($koneksi, "SELECT * FROM cbt_ljk WHERE user_jawab='$userlg' AND token = '$token' AND kd_soal ='$kds' ORDER BY cbt_ljk.urut ASC"));
	// $ls_es = (mysqli_query($koneksi, "SELECT * FROM cbt_ljk WHERE jns_soal = 'E'"));
	?>
	<!-- <h5 class="m-4">Pilihan Ganda</h5> -->
	<div class="offcanvas-body g-3 ">
		<?php
		while ($dt = mysqli_fetch_array($ls_pg)) {
			$jwb = $dt['jwbn'];
			if ($jwb == "N") {
				$jwb = " &nbsp;";
				$fbnt = "btn-outline-secondary";
			} elseif ($jwb == "R") {
				$fbnt = "btn-secondary";
				$jwb = "-";
			} else {
				$fbnt = "btn-secondary";
			}
			$jw = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM cbt_ljk WHERE user_jawab='$userlg' AND token = '$token' AND kd_soal ='$kds';"));
			echo "
				<button type='button' id='ns$dt[urut]' class='btn $fbnt fw-semibold position-relative ms-3 mb-3 p-1 fs-5 text-center' style='width: 40px;'  data-bs-dismiss='offcanvas' aria-label='Close'>
				$dt[urut]
				<span class='position-absolute top-0 start-100 translate-middle badge rounded-pill bg-primary fs-6' id='abc$dt[urut]'>
				$jwb
				</span>
			</button>
			";
		?>
			<script>
				$(document).ready(function() {
					$("#ns<?php echo $dt['urut'] ?>").click(function() {
						var nsoal = <?php echo $dt['urut'] ?>;

						function fetchData() {
							$.ajax({
								type: "GET",
								url: "soal.php?usr=<?php echo $userlg ?>&tkn=<?php echo $token ?>&kds=<?php echo $kds ?>&nos=<?php echo $dt['urut'] ?>",
								success: function(response) {
									$("#soal").html(response);
									// $("#list_soal").load(response);
									document.getElementById("nos").innerHTML = nsoal;
									document.getElementById("jb").innerHTML = "";
									if (nsoal != 1) {
										document.getElementById("btn_pr").hidden = false;
										document.getElementById("btn_nx").hidden = false;
										document.getElementById("btn_end").hidden = true;
									} else if (<?php echo $jum_soal  ?> != nsoal) {
										document.getElementById("btn_pr").hidden = true;
										document.getElementById("btn_nx").hidden = false;
										document.getElementById("btn_end").hidden = true;
									}
									if (<?php echo $jum_soal  ?> == nsoal) {
										document.getElementById("btn_nx").hidden = true;
										document.getElementById("btn_end").hidden = false;
									}
								}
							});
						}
						// Fetch data initially when the page loads
						fetchData();

						// Fetch data when a button is clicked
						$("#ns<?php echo $dt['urut'] ?>").click(function() {
							fetchData();
						});
						// $.ajax({
						// 	type: "GET",
						// 	url : "list_soal.php?kt=<?php echo $token ?>&kds=<?php echo $kds ?>",
						// 	success: function(response){
						// 		$("#lst_soal").html(response);
						// 	}
						// });
					})
				})
			</script>
		<?php
		}
		?>
	</div>
</div>



<!-- === JavaScript === -->
<script src="node_modules/jquery/dist/jquery.min.js"></script>

<!-- Waktu Ujian -->
<!-- Cek Keterlambatan -->
<?php  ?>
<script>
	// Mengatur waktu akhir perhitungan mundur
	var countDownDate = new Date("<?php echo $wktu ?>").getTime();

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
					xmlHttp = new ActiveXObject("Msxml2.XMLHTTP");
				} catch (err2) {
					try {
						xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
					} catch (eerr3) {
						//AJAX not supported, use CPU time.
						alert("AJAX not supported");
					}
				}
			}
			xmlHttp.open("HEAD", window.location.href.toString(), false);
			xmlHttp.setRequestHeader("Content-Type", "text/html");
			xmlHttp.send("");
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
			clearInterval(x);
			document.getElementById("lm_ujian").innerHTML = "Waktu Habis";

			// var nx_soal = "<?php echo $jum_soal ?>";
			$.ajax({
				type: "GET",
				url: "selesai.php?usr=<?php echo $userlg ?>&tkn=<?php echo $token ?>&kds=<?php echo $kds ?>&stsnil=<?php echo $dtjdwl['sts_nilai'] ?>&jums=<?php echo $jum_soal ?>&time=0",
				success: function(response) {
					$("#soal").html(response);
					document.getElementById("btn_pr").hidden = true;
					document.getElementById("btn_rr").hidden = true;
					document.getElementById("btn_end").hidden = true;
					document.getElementById("btn_nx").hidden = true;
					document.getElementById("bar").hidden = true;
				}
			})
		}
	}, 1000);
</script>
<!-- Akhir Waktu Ujian -->
<script>
	// === Slide === //
	function openNav() {
		document.getElementById("df_soal").style.width = "400px";
		// document.getElementById("main").style.marginRight = "250px";
		document.document.getElementById("main").style.backgroundColor = "rgba(0,0,0,0.8)";
	}

	function closeNav() {
		document.getElementById("df_soal").style.width = "0";
		// document.getElementById("main").style.marginRight = "0";
		document.body.style.backgroundColor = "white";
	}
</script>
<script>
	// btn pindah soal
	$(document).ready(function() {
		$("#btn_nx").click(function() {
			var nsoal = document.getElementById("nos").innerHTML;
			var nx_soal = parseInt(nsoal) + 1;
			$.ajax({
				type: "GET",
				url: "soal.php?usr=<?php echo $userlg ?>&tkn=<?php echo $token ?>&kds=<?php echo $kds ?>&nos=" + nx_soal,
				success: function(response) {
					$("#soal").html(response);
					document.getElementById("jb").innerHTML = "";
					document.getElementById("nos").innerHTML = nx_soal;
					document.getElementById("nos").innerHTML = nx_soal;
					if (nsoal != 0) {
						document.getElementById("btn_pr").hidden = false;
						document.getElementById("btn_end").hidden = true;
					}
					if (<?php echo $jum_soal  ?> == nx_soal) {
						document.getElementById("btn_nx").hidden = true;
						document.getElementById("btn_end").hidden = false;
					}
				}
			})
		})
	})
	$(document).ready(function() {
		$("#btn_pr").click(function() {
			var nsoal = document.getElementById("nos").innerHTML;
			var nx_soal = parseInt(nsoal) - 1;
			document.getElementById("jb").innerHTML = "";
			$.ajax({
				type: "GET",
				url: "soal.php?usr=<?php echo $userlg ?>&tkn=<?php echo $token ?>&kds=<?php echo $kds ?>&nos=" + nx_soal,
				success: function(response) {
					$("#soal").html(response);
					document.getElementById("nos").innerHTML = nx_soal;
					if (nx_soal == 1) {
						document.getElementById("btn_pr").hidden = true;
					}
					if (<?php echo $jum_soal ?> <= nsoal) {
						document.getElementById("btn_nx").hidden = false;
						document.getElementById("btn_end").hidden = true;
					}
				}
			})
		})
	})
	$(document).ready(function() {
		$("#btn_end").click(function() {
			var nsoal = document.getElementById("nos").innerHTML;
			var nx_soal = parseInt(nsoal) - 1;
			$.ajax({
				type: "GET",
				url: "selesai.php?usr=<?php echo $userlg ?>&tkn=<?php echo $token ?>&kds=<?php echo $kds ?>&stsnil=<?php echo $dtjdwl['sts_nilai'] ?>&jums=<?php echo $jum_soal ?>&time=1",
				success: function(response) {
					$("#soal").html(response);
					document.getElementById("btn_pr").hidden = true;
					document.getElementById("btn_rr").hidden = true;
					document.getElementById("btn_end").hidden = true;
					document.getElementById("bar").hidden = true;
					// document.getElementById("btn_end").hidden = true;
				}
			})
		})
	})
</script>