<!DOCTYPE html>
<html lang="en">

<?php
include_once("config/server.php");
require("data/ujian_db.php");
?>

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Ujian</title>
	<link rel="shortcut icon" href="img/<?= ($inf['fav'] != null) ? $inf['fav'] : "fav.png"; ?>" type="image/x-icon">

	<link rel="stylesheet" href="vendor/twbs/bootstrap/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="vendor/twbs/bootstrap-icons/font/bootstrap-icons.css">
	<script src="vendor/twbs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
	<script src="node_modules/jquery/dist/jquery.min.js"></script>
	<link rel="stylesheet" href="style_ujian.css">

	<script src="node_modules/sweetalert2/dist/sweetalert2.min.js"></script>
	<link rel="stylesheet" href="node_modules/sweetalert2/dist/sweetalert2.min.css">
	<!-- <script src="aset/time.js"></script> -->
</head>
<!-- CSS Kostum -->


<body id="main" class="main">
	<div class="head container-fluid pt-md-5 pt-3">
		<div class=" row justify-content-around">
			<div class="col-md-5 text-center text-md-start">
				<img class="img-fluid" src="img/MyTBK.png" alt="" style="max-width: 230px;">
			</div>
			<div class="col-md-5 text-md-end text-start mt-2">
				<div class="row justify-content-md-end justify-content-center">
					<div class="col-auto"><img src="<?= $ft ?>" class="img-thumbnail" style="width: 50px; height: 65px;" alt="" srcset=""></div>
					<div class="col-auto">
						<p class="text-light"><?= $dtps_uji['nm'] ?> <br> <?= $dtkls['nm_kls'] ?></p>
					</div>

				</div>
			</div>
		</div>
	</div>
	<div class="container-fluid pb-3" style="margin-top: -30px;font-family: Times New Roman;">
		<div class="card shadow mb-3 mx-md-3 sticky-top z-1" id="bar">
			<div class="row p-2 justify-content-around">
				<div class="col-sm-auto col-12 h3 mx-sm-5 text-center text-sm-start">
					<label class="fw-semibold">No.</label>
					<div class="badge bg-primary text-wrap" id="nos" style="width: auto;">1</div>
				</div>
				<div class="col-md-auto col-12 p-1" id="jb"></div>
				<div class="col text-center text-md-end">
					<label class="time me-2" id="lm_ujian">Waktu Ujian</label>
					<!-- waktu tambahan -->
					<!-- <?php if (!empty($wkt_tambah)) {
									echo '<label class="time bg-i me-2" id="lm_tambah">+' . $wkt_tambah . ' </label>';
								} ?> -->
					<!-- <button class="btn btn-primary mx-3" onclick="openNav()">&#9776; Daftar Soal</button> -->
					<button class="btn btn-primary mx-3" type="button" data-bs-toggle="offcanvas" data-bs-target="#list_soal" aria-controls="list_soal" id="df_soal">&#9776; Daftar Soal</button>
				</div>
			</div>
		</div>
		<div class="card shadow-lg m-md-3 p-0 p-md-4">
			<div class="border" style="border-radius: 7px;">

				<div id="soal"></div>
				<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> -->
				<script src="node_modules/jquery/dist/jquery.min.js"></script>
				<script>
					// soal.php
					$(document).ready(function() {
						var nsoal = document.getElementById("nos").innerHTML;

						function fetchData() {
							$.ajax({
								type: "POST",
								url: "soal.php",
								data: {
									usr: "<?= $userlg ?>",
									tkn: "<?= $token ?>",
									kds: "<?= $kds ?>",
									nos: nsoal
								},
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
		<div class="col-12 bg-dark text-white text-center" id="footer" style="height: 30px;"><?php include_once("config/about.php") ?></div>
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
			$jwb = "&nbsp;";
			$fbnt = "btn-outline-secondary";

			if ($dt['jns_soal'] == 'G') {
				$jwb = $dt['jwbn'];
				if ($jwb == "R") {
					$jwb = "-";
					$fbnt = "btn-secondary";
				} elseif ($jwb != "N") {
					$fbnt = "btn-secondary";
				} else {
					$jwb = "&nbsp;";
				}
			} elseif ($dt['jns_soal'] == 'E') {
				$jwb = $dt['es_jwb'];
				if ($jwb != "") {
					$jwb = '<i class="bi bi-check2"></i>';
					$fbnt = "btn-secondary";
				} else {
					$jwb = "&nbsp;";
				}
			}

			$jw = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM cbt_ljk WHERE user_jawab='$userlg' AND token = '$token' AND kd_soal ='$kds';"));
			echo "
				<button type='button' id='ns$dt[urut]' class='btn $fbnt fw-semibold position-relative ms-3 mb-3 p-1 fs-5 text-center' style='width: 40px;'  data-bs-dismiss='offcanvas' aria-label='Close'>
				$dt[urut]
				<span class='position-absolute top-0 start-100 translate-middle badge rounded-pill bg-dark fs-6' id='abc$dt[urut]'>
				$jwb
				</span>
			</button>
			";
		?>
			<script>
				$(document).ready(function() {
					$("#ns<?= $dt['urut'] ?>").click(function() {
						var nsoal = <?= $dt['urut'] ?>;

						function fetchData() {
							$.ajax({
								type: "POST",
								url: "soal.php",
								data: {
									usr: "<?= $userlg ?>",
									tkn: "<?= $token ?>",
									kds: "<?= $kds ?>",
									nos: <?= $dt['urut'] ?>
								},
								success: function(response) {
									$("#soal").html(response);
									// $("#list_soal").load(response);
									document.getElementById("nos").innerHTML = nsoal;
									document.getElementById("jb").innerHTML = "";
									if (nsoal != 1) {
										document.getElementById("btn_pr").hidden = false;
										document.getElementById("btn_nx").hidden = false;
										document.getElementById("btn_end").hidden = true;
									} else if (<?= $jum_soal  ?> != nsoal) {
										document.getElementById("btn_pr").hidden = true;
										document.getElementById("btn_nx").hidden = false;
										document.getElementById("btn_end").hidden = true;
									}
									if (<?= $jum_soal  ?> <= nsoal) {
										document.getElementById("btn_nx").hidden = true;
										document.getElementById("btn_end").hidden = false;
									}
								}
							});
						}
						// Fetch data initially when the page loads
						fetchData();

						// Fetch data when a button is clicked
						$("#ns<?= $dt['urut'] ?>").click(function() {
							fetchData();
						});
						// $.ajax({
						// 	type: "GET",
						// 	url : "list_soal.php?kt=<?= $token ?>&kds=<?= $kds ?>",
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
<script>
	// Mengatur waktu akhir perhitungan mundur
	var countDownDate = new Date("<?= $wktu ?>").getTime();

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

			// var nx_soal = "<?= $jum_soal ?>";
			$.ajax({
				type: "GET",
				url: "selesai.php?usr=<?= $userlg ?>&tkn=<?= $token ?>&kds=<?= $kds ?>&stsnil=<?= $dtjdwl['sts_nilai'] ?>&jums=<?= $jum_soal ?>&time=0",
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
				type: "POST",
				url: "soal.php",
				data: {
					usr: "<?= $userlg ?>",
					tkn: "<?= $token ?>",
					kds: "<?= $kds ?>",
					nos: nx_soal
				},
				success: function(response) {
					$("#soal").html(response);
					document.getElementById("jb").innerHTML = "";
					document.getElementById("nos").innerHTML = nx_soal;
					document.getElementById("nos").innerHTML = nx_soal;
					if (nsoal != 0) {
						document.getElementById("btn_pr").hidden = false;
						document.getElementById("btn_end").hidden = true;
					}
					if (<?= $jum_soal  ?> == nx_soal) {
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
				type: "POST",
				url: "soal.php",
				data: {
					usr: "<?= $userlg ?>",
					tkn: "<?= $token ?>",
					kds: "<?= $kds ?>",
					nos: nx_soal
				},
				success: function(response) {
					$("#soal").html(response);
					document.getElementById("nos").innerHTML = nx_soal;
					if (nx_soal == 1) {
						document.getElementById("btn_pr").hidden = true;
					}
					if (<?= $jum_soal ?> <= nsoal) {
						document.getElementById("btn_nx").hidden = false;
						document.getElementById("btn_end").hidden = true;
					}
				}
			})
		})
	})
	$(document).ready(function() {
		$("#btn_end").click(function() {
			Swal.fire({
				title: 'Apakah Anda yakin?',
				text: "Anda tidak dapat mengubah jawaban setelah mengakhiri ujian.",
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Ya, Akhiri Ujian!',
				cancelButtonText: 'Batal'
			}).then((result) => {
				if (result.isConfirmed) {
					var nsoal = document.getElementById("nos").innerHTML;
					var nx_soal = parseInt(nsoal) - 1;
					$.ajax({
						type: "GET",
						url: "selesai.php?usr=<?= $userlg ?>&tkn=<?= $token ?>&kds=<?= $kds ?>&stsnil=<?= $dtjdwl['sts_nilai'] ?>&jums=<?= $jum_soal ?>&time=1",
						success: function(response) {
							$("#soal").html(response);
							document.getElementById("btn_pr").hidden = true;
							document.getElementById("btn_rr").hidden = true;
							document.getElementById("btn_end").hidden = true;
							document.getElementById("bar").hidden = true;
							$("#footer").addClass("fixed-bottom");
						}
					});
				}
			});
		});
	});
</script>

<!-- Copas -->
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