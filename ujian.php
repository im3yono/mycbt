<?php
include_once("config/server.php");
require("data/ujian_db.php");
?>

<!DOCTYPE html>
<html lang="en">

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

	<!-- display perangkat -->
	<script>
		// Deteksi perangkat mobile dengan DPI tinggi
		const isMobileUA = /Android|iPhone|iPad|iPod|Mobile/i.test(navigator.userAgent);
		const highDPI = window.devicePixelRatio >= 2 && window.innerWidth > 768;

		if (isMobileUA && highDPI) {
			// document.body.classList.add("force-mobile");
			$('#main').addClass("force-mobile");
		}
	</script>

	<!-- Temma -->
	<script>
		(function() {
			const logoImg = document.getElementById("logo-img");
			const theme = localStorage.getItem("theme");
			if (theme === "dark") {
				document.documentElement.setAttribute("data-bs-theme", "dark");
			}
		})();
	</script>

	<!-- <script src="aset/time.js"></script> -->
</head>
<!-- CSS Kostum -->


<body id="main" class="main">
	<div class="head container-fluid pt-md-4 pt-4">
		<div class=" row justify-content-around">
			<div class="col col-md-5 text-center text-md-start logo">
				<img id="logo-img" class="img-fluid" src="img/MyTBK-dark.png" alt="" style="max-width: 230px;">
			</div>
			<div class="col col-md-5 text-md-end text-start">
				<div class="row justify-content-md-end justify-content-center">
					<div class="col-auto"><img src="<?= $ft ?>" class="img-thumbnail" style="width: 50px; height: 65px;" alt="" srcset=""></div>
					<div class="col-auto">
						<p class=""><?= $dtps_uji['nm'] . '<br>' . $dtps_uji['nis'] ?> <br> <?= $dtkls['nm_kls'] ?></p>
					</div>

				</div>
			</div>
		</div>
	</div>
	<div class="container-fluid pb-3" style="margin-top: -30px;">
		<div class="card shadow-sm mb-3 mx-md-3 sticky-top z-1" id="bar">
			<div class="row p-1 justify-content-around g-0">
				<div class="col-sm-auto col-12 h3 mx-sm-5 m-0 text-center text-sm-start">
					<label class="fw-semibold">No.</label>
					<div class="badge bg-primary text-wrap" id="nos" style="width: auto;">1</div>

					<!-- Pesan Siswa -->
					<?= ($dtps_uji['ischt'] == 'Y') ? '<button class="btn fs-4 ms-3" onclick="sisPsn()"><i class="bi bi-chat-text"></i></button>' : ''; ?>
					<!-- Akhir Pesan Siswa -->

				</div>
				<div class="col-md-auto col-12 p-0" id="jb"></div>
				<div class="col text-center text-md-end">
					<label class="time me-2 text-dark" id="lm_ujian">Waktu Ujian</label>
					<!-- waktu tambahan -->
					<!-- <?php
								// if (!empty($wkt_tambah)) {
								// 	echo '<label class="time bg-i me-2" id="lm_tambah">+' . $wkt_tambah . ' </label>';
								//} ?> -->
					<!-- <button class="btn btn-primary mx-3" onclick="openNav()">&#9776; Daftar Soal</button> -->
					<button class="btn btn-sm btn-primary mx-3" type="button" data-bs-toggle="offcanvas" data-bs-target="#list_soal" aria-controls="list_soal" id="df_soal">&#9776; Daftar Soal</button>
				</div>
			</div>
		</div>
		<div class="card shadow m-md-3 p-0 p-md-4">
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
	<div class="row m-3 justify-content-around text-center gap-2 pb-3">
		<button class="btn col-sm-3 fs-5 btnr btn-primary fw-semibold" id="btn_pr" hidden>Sebelumnya</button>
		<button class="btn col-sm-3 fs-5 btnr btn-warning fw-semibold" id="btn_rr">Ragu-Ragu</button>
		<button class="btn col-sm-3 fs-5 btnr btn-primary fw-semibold" id="btn_nx">Berikutnya</button>
		<button class="btn col-sm-3 fs-5 btnr btn-primary fw-semibold" id="btn_end" hidden>Selesai</button>
	</div>
	<footer>
		<!-- <div class="col-12 bg-dark text-white text-center" id="footer" style="height: 30px;"><?php include_once("config/about.php") ?></div> -->
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
		<h4 class="mx-4 text-dark">Daftar Soal</h4>
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

<!-- Modal Pesan -->
<?php if ($dtps_uji['ischt'] == 'Y'): ?>
	<div class="modal fade" id="cht" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h1 class="modal-title fs-5" id="chtLabel">Pesan</h1>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<p id="chtpsn" class="py-1 px-2 bg-secondary-subtle" style="border-radius: 5px;"></p>
					<form id="pesan_form">
						<div class="col">
							<textarea name="pesan" id="pesan" class="form-control" rows="5" placeholder="Ketik pesan disini..."></textarea>
							<input type="hidden" name="t_user" id="t_user" value="adm_<?= $_COOKIE['user']; ?>">
							<input type="hidden" name="f_user" id="f_user" value="<?= $_COOKIE['user']; ?>">
						</div>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
					<button type="button" class="btn btn-primary" id="kirim">Kirim</button>
				</div>
			</div>
		</div>
	</div>

	<script>
		function kirimPesan() {
			const psn = $('#pesan').val().trim();
			const t_usr = $('#t_user').val();
			const f_usr = $('#f_user').val();

			if (psn === '') {
				Swal.fire('Pesan kosong', 'Silakan ketik pesan terlebih dahulu.', 'warning');
				return;
			}

			$.ajax({
				type: 'POST',
				url: './adm/db/dbproses.php?pr=uj_psn',
				data: {
					keu: t_usr,
					dru: f_usr,
					psn: psn,
				},
				success: function(response) {
					Swal.fire(response, '', 'success').then(() => {
						const modalEl = document.getElementById('cht');
						const modal = bootstrap.Modal.getInstance(modalEl);
						modal.hide();
						$('#pesan').val('');
					});
				},
				error: function() {
					Swal.fire('Error', 'Gagal mengirim pesan.', 'error');
				}
			});
		}

		$(document).on('click', '#kirim', kirimPesan);
	</script>

	<script>
		function sisPsn() {
			const modal = new bootstrap.Modal(document.getElementById('cht'));
			modal.show();
			$.ajax({
				type: "POST",
				url: "data/psn.php",
				data: {
					usr: "<?= $userlg ?>",
					tkn: "<?= $token ?>",
					notf: 'intel'
				},
				success: function(response) {
					$("#chtpsn").html(response);
				},
				error: function() {
					$("#cht .modal-body p").html("<span class='text-danger'>Gagal memuat pesan.</span>");
				}
			});
		}
	</script>
<?php endif; ?>

<!-- lg dark & Light -->
<script>
	const logoImg = document.getElementById("logo-img");
	const theme = localStorage.getItem("theme");
	if (theme === "dark") {
		logoImg.src = "img/MyTBK.png";
	} else {
		logoImg.src = "img/MyTBK-dark.png";
	}
</script>

<!-- Waktu Ujian -->
<!-- Cek Keterlambatan -->
<script>
	// Ambil waktu akhir dari PHP
	var countDownDate = new Date("<?= $wktu ?>").getTime();

	// Ambil waktu server sekali di awal
	function getServerTime(callback) {
		var xhr = new XMLHttpRequest();
		xhr.open("HEAD", window.location.href, true);
		xhr.onreadystatechange = function() {
			if (xhr.readyState === 4 && xhr.status === 200) {
				var serverDate = new Date(xhr.getResponseHeader("Date"));
				callback(serverDate);
			}
		};
		xhr.send();
	}

	getServerTime(function(serverStartTime) {
		var now = serverStartTime.getTime();
		var sudahTambahan = false; // Penanda agar tambahan waktu hanya dilakukan sekali

		var x = setInterval(function() {
			now += 1000; // Tambah 1 detik tiap interval
			var distance = countDownDate - now;

			var days = Math.floor(distance / (1000 * 60 * 60 * 24));
			var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
			var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
			var seconds = Math.floor((distance % (1000 * 60)) / 1000);

			// Format
			if (minutes < 10) minutes = "0" + minutes;
			if (seconds < 10) seconds = "0" + seconds;

			var output = "";
			if (days > 0) output = days + " Hari, " + hours + ":" + minutes + ":" + seconds;
			else if (hours > 0) output = hours + ":" + minutes + ":" + seconds;
			else if (minutes > 0) output = minutes + ":" + seconds;
			else output = seconds;

			document.getElementById("lm_ujian").innerHTML = output;

			// Jika waktu habis dan belum coba ambil waktu tambahan
			if (distance < 0 && !sudahTambahan) {
				sudahTambahan = true; // Hanya ambil tambahan waktu sekali
				// Coba ambil waktu tambahan
				$.ajax({
					type: "POST",
					url: "data/wkt_tbh.php",
					data: {
						token: "<?= $token ?>",
						kds: "<?= $kds ?>"
					},
					success: function(data) {
						var wktTbhn = new Date(data).getTime();
						if (wktTbhn > now) {
							countDownDate = wktTbhn;
							document.getElementById("lm_ujian").innerHTML = "Tambahan Waktu Dimulai";
							sudahTambahan = false; // Reset agar jika masih habis bisa cek lagi
						} else {
							clearInterval(x);
							akhiriUjian();
						}
						console.log("Waktu Tambahan: " + data);
					},
					error: function() {
						clearInterval(x);
						akhiriUjian();
					}
				});
			} else if (distance < 0 && sudahTambahan) {
				// Sudah coba tambahan, tapi tetap habis
				clearInterval(x);
				akhiriUjian();
			}
		}, 1000);

		// Fungsi mengakhiri ujian
		function akhiriUjian() {
			document.getElementById("lm_ujian").innerHTML = "Waktu Habis";
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
			});
		}
	});
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
	$(document).ready(function() {
		$("#btn_rr").click(function() {
			// $('#abc' + document.getElementById("nos").innerHTML).html('<i class="bi bi-question"></i>');
			$('#abc' + document.getElementById("nos").innerHTML).removeClass("bg-dark").addClass("bg-warning text-dark");
		})
	});
</script>

<!-- copas -->
<?php if ($inf_set['optes'] == "on"): ?>
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
	<!-- <script>
console.warn("⚠️ PERINGATAN: Ini hanya untuk developer. Jangan ubah sembarangan!");
</script> -->
<?php endif; ?>