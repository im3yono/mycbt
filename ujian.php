<?php
include_once("config/server.php");

$userlg = $_COOKIE['user'];
$token	= $_POST['kt'];
// if (empty($userlg)) {
// 	# code...
// }
$dtps_uji	= mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM cbt_peserta WHERE user ='$userlg'"));
$dtkls		= mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM kelas WHERE kd_kls='$dtps_uji[kd_kls]'"));
$dtjdwl		= mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM jdwl WHERE token='$token'"));
$dtpkt		= mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM cbt_pktsoal WHERE kd_soal='$dtjdwl[kd_soal]'"));
$dts			= mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM cbt_soal WHERE kd_soal='$dtjdwl[kd_soal]'"));


// ===========================================...CEK LEMBAR JAWABAN...=========================================== //
$ljk_cek	= mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM cbt_ljk WHERE user_jawab ='$userlg' AND token='$token' AND kd_soal='$dtjdwl[kd_soal]'"));
if (empty($ljk_cek)) {
	$nos = 1;

	// INSERT INTO cbt_ljk (id, urut, user_jawab, token, kd_soal, no_soal, jns_soal, kd_mapel, kd_kls, kd_jur, A, B, C, D, E, jwbn, nil_jwb, knci_jwbn, nil, es_jwb, nil_esai, tgl, jam) VALUES (NULL, '5', 'tri', 'ksdaa', 'MTK_IPA', '1', 'G', 'MTK', 'XII', 'IPA', '1', '2', '3', '4', '5', 'C', '3', '1', '0', '', '0', '2023-04-09', '19:26:41');
	// SELECT * FROM cbt_soal WHERE kd_soal='X_BIndo' AND jns_soal='G' AND ack_soal='Y' ORDER BY RAND() LIMIT 10;
}
// timer
if (!empty($dtjdwl['jm_uji'])) {
	$waktu_awal		= $dtjdwl['jm_uji'];
	$waktu_akhir	= $dtjdwl['lm_uji']; // bisa juga waktu sekarang now()

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
	<script src="aset/time.js"></script>
</head>
<!-- CSS Kostum -->


<body id="main" class="main">
	<div class="head container-fluid pt-md-5 pt-3">
		<div class=" row justify-content-around">
			<div class="col-md-5 text-center text-md-start">
				<img class="img-fluid" src="img/logo.png" alt="">
			</div>
			<div class="col-md-5 text-md-end text-center mt-2">
				<p class="text-light"><?php echo $dtps_uji['nm'] ?> <br> <?php echo $dtkls['nm_kls'] ?></p>
			</div>
		</div>
	</div>
	<div class="container-fluid pb-3" style="margin-top: -30px;font-family: Times New Roman;">
		<div class="card shadow mb-3 mx-3 sticky-top z-1">
			<div class="row p-2 justify-content-around">
				<div class="col-sm-auto col-12 h3 mx-5 text-center text-sm-start">
					<label class="fw-semibold">No.</label>
					<div class="badge bg-primary text-wrap" style="width: auto;">50</div>
				</div>
				<div class="col text-center text-sm-end">
					<label class="time me-2" id="lm_ujian">Waktu Ujian</label>
					<!-- <button class="btn btn-primary mx-3" onclick="openNav()">&#9776; Daftar Soal</button> -->
					<button class="btn btn-primary mx-3" type="button" data-bs-toggle="offcanvas" data-bs-target="#list_soal" aria-controls="list_soal">&#9776; Daftar Soal</button>
				</div>
			</div>
		</div>
		<div class="card shadow-lg m-3 pb-2">
			<!-- === Media === -->
			<div class="row m-3 gap-2 text-center justify-content-around">

				<div class="col-12">
					<video controls controlsList="nodownload" preload="none" class="media" src="video/videoplayback.mp4" class="object-fit-contain"></video>
				</div>
				<div class="col-12">
					<audio controls controlsList="nodownload" preload="none" class="">
						<source src="audio/preman_pensiun_dj.mp3" type="audio/mpeg">
						<!-- <source src="audio/preman_pensiun_dj.mp3" type="audio/mpeg"> -->
						Browsermu tidak mendukung tag audio
					</audio>
				</div>
				<div class="col-12">
					<button type="button" class="btn " data-bs-toggle="modal" data-bs-target="#zoom">
						<img src="images/20211108-sebuah-tulisan-aneuk-nanggroe-yang-belum-pernah-ke-sabang-pariwisata-aceh-yang-santai-banget-sabang-.jpg" alt="" srcset="" class="media" id="myImg">
					</button>
				</div>

			</div>
			<!-- === Akhir Media === -->
			<!-- === Pilihan Ganda === -->
			<div class="row m-3 text-center justify-content-around">
				<h4 class="fw-semibold text-decoration-underline">Pilihan Ganda</h4>
				<p style="text-align: justify;" class="fs-5">
					Lorem ipsum dolor sit amet consectetur, adipisicing elit. Rerum cumque vero id, nostrum unde ex laboriosam commodi officia praesentium dignissimos voluptatem natus consectetur, incidunt nobis ab sint est voluptatum perspiciatis.
					Quos eum rerum ad minima voluptas perspiciatis voluptatibus in distinctio earum, soluta magnam omnis labore atque veritatis ab architecto et mollitia blanditiis consequuntur a velit provident necessitatibus dolore aut. Reiciendis!
					Beatae quia, necessitatibus dolorum debitis consequuntur nemo sapiente vitae at sint quos. Harum fugit quos odit ducimus impedit repellat praesentium doloremque, facilis minima reiciendis rerum dignissimos, hic libero repellendus! Eius.
					Earum debitis vero eius, delectus quos commodi modi quo ipsam consequuntur, ut labore accusantium voluptatum. Mollitia molestias voluptatibus odit, quaerat, perspiciatis aliquam quo eligendi facilis, itaque voluptatem id maiores culpa.
					Magnam, a! Aliquam pariatur similique blanditiis. Odio cum mollitia labore voluptates, laborum autem sequi aliquid, ratione at assumenda praesentium doloremque. Facilis sapiente libero laboriosam minima ea reprehenderit, dolore nisi eum!
					Aspernatur quis sunt, quos praesentium voluptatibus maxime at, quibusdam distinctio quia architecto, temporibus laudantium. Ullam totam ut, omnis natus pariatur deleniti, odit doloremque, harum asperiores dolores quam laboriosam assumenda fugiat.
					Beatae, cum non rem repudiandae quasi nesciunt ea quibusdam. Illo similique minima magnam est nemo ducimus earum corrupti ex, id, dolores illum! Officiis vitae tempora rem laborum, a ratione asperiores.
					Eius corrupti dolore non officiis sint veniam ipsum necessitatibus repellat, eligendi, maxime esse? Eos modi nihil harum, ex tempore nam, officia similique, porro beatae praesentium vitae alias sed autem illum.
					Aliquid eius, quasi consequuntur expedita nesciunt, quaerat omnis eos nemo ipsa molestias maxime doloribus pariatur odio aperiam necessitatibus, nisi tempore? Amet eveniet reprehenderit dolor magnam culpa ratione, consectetur eum a.
					Ea, cumque possimus eius, laborum illo animi eaque vero modi fugit rerum ipsa illum quaerat velit incidunt voluptatum harum magni autem. Minima earum hic dicta aliquid voluptates rem, laboriosam laudantium?
				</p>
				<p style="text-align: justify;" class="fs-5">Lorem ipsum dolor sit amet consectetur adipisicing elit. Cumque ipsam sed iste fuga libero numquam voluptate exercitationem voluptates! Necessitatibus nulla adipisci qui dolores. Officiis quidem rerum, in deserunt quis iure?...</p>
			</div>
			<!-- === Akhir Pilihan Ganda === -->
			<!-- === Esai === -->
			<div class="row m-3 text-center justify-content-around">
				<h4 class="fw-semibold text-decoration-underline">Esai</h4>
				<p style="text-align: justify;" class="fs-5">
					Lorem ipsum dolor sit amet consectetur, adipisicing elit. Rerum cumque vero id, nostrum unde ex laboriosam commodi officia praesentium dignissimos voluptatem natus consectetur, incidunt nobis ab sint est voluptatum perspiciatis.
					Quos eum rerum ad minima voluptas perspiciatis voluptatibus in distinctio earum, soluta magnam omnis labore atque veritatis ab architecto et mollitia blanditiis consequuntur a velit provident necessitatibus dolore aut. Reiciendis!
					Beatae quia, necessitatibus dolorum debitis consequuntur nemo sapiente vitae at sint quos. Harum fugit quos odit ducimus impedit repellat praesentium doloremque, facilis minima reiciendis rerum dignissimos, hic libero repellendus! Eius.
					Earum debitis vero eius, delectus quos commodi modi quo ipsam consequuntur, ut labore accusantium voluptatum. Mollitia molestias voluptatibus odit, quaerat, perspiciatis aliquam quo eligendi facilis, itaque voluptatem id maiores culpa.
					Magnam, a! Aliquam pariatur similique blanditiis. Odio cum mollitia labore voluptates, laborum autem sequi aliquid, ratione at assumenda praesentium doloremque. Facilis sapiente libero laboriosam minima ea reprehenderit, dolore nisi eum!
					Aspernatur quis sunt, quos praesentium voluptatibus maxime at, quibusdam distinctio quia architecto, temporibus laudantium. Ullam totam ut, omnis natus pariatur deleniti, odit doloremque, harum asperiores dolores quam laboriosam assumenda fugiat.
					Beatae, cum non rem repudiandae quasi nesciunt ea quibusdam. Illo similique minima magnam est nemo ducimus earum corrupti ex, id, dolores illum! Officiis vitae tempora rem laborum, a ratione asperiores.
					Eius corrupti dolore non officiis sint veniam ipsum necessitatibus repellat, eligendi, maxime esse? Eos modi nihil harum, ex tempore nam, officia similique, porro beatae praesentium vitae alias sed autem illum.
					Aliquid eius, quasi consequuntur expedita nesciunt, quaerat omnis eos nemo ipsa molestias maxime doloribus pariatur odio aperiam necessitatibus, nisi tempore? Amet eveniet reprehenderit dolor magnam culpa ratione, consectetur eum a.
					Ea, cumque possimus eius, laborum illo animi eaque vero modi fugit rerum ipsa illum quaerat velit incidunt voluptatum harum magni autem. Minima earum hic dicta aliquid voluptates rem, laboriosam laudantium?
				</p>
				<p style="text-align: justify;" class="fs-5">Lorem ipsum dolor sit amet consectetur adipisicing elit. Cumque ipsam sed iste fuga libero numquam voluptate exercitationem voluptates! Necessitatibus nulla adipisci qui dolores. Officiis quidem rerum, in deserunt quis iure?...</p>
			</div>
			<!-- === Akhir Esai === -->
			<!-- === Jawaban === -->
			<div class="row mx-md-5 mx-auto my-3 fs-5 gap-3">
				<div class="row">
					<div class="col-auto">
						<input type="radio" class="btn-check" name="jwb" id="jwbA" autocomplete="off">
						<label class="btn btn-outline-dark text-start" for="jwbA">A</label>
					</div>
					<div class="col-auto">Jawaban A</div>
					<div class="col-auto">
						<button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#zoom">
							<img src="images/ice-cubes.jpg" alt="" srcset="" class="img-thumbnail" style="max-width: 240px;" id="myImgA">
					</div>
				</div>
				<div class="row">
					<div class="col-auto">
						<input type="radio" class="btn-check" name="jwb" id="jwbB" autocomplete="off">
						<label class="btn btn-outline-dark col-auto text-start" for="jwbB">B</label>
					</div>
					<div class="col-auto">Jawaban A</div>
					<div class="col-auto">
						<button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#zoom">
							<img src="images/ice-cubes.jpg" alt="" srcset="" class="img-thumbnail" style="max-width: 240px;" id="myImgB">
					</div>
				</div>
				<div class="row">
					<div class="col-auto">
						<input type="radio" class="btn-check" name="jwb" id="jwbC" autocomplete="off">
						<label class="btn btn-outline-dark col-auto text-start" for="jwbC">C</label>
					</div>
					<div class="col-auto">Jawaban A</div>
					<div class="col-auto">
						<button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#zoom">
							<img src="images/ice-cubes.jpg" alt="" srcset="" class="img-thumbnail" style="max-width: 240px;" id="myImgC">
					</div>
				</div>
				<div class="row">
					<div class="col-auto">
						<input type="radio" class="btn-check" name="jwb" id="jwbD" autocomplete="off">
						<label class="btn btn-outline-dark col-auto text-start" for="jwbD">D</label>
					</div>
					<div class="col-auto">Jawaban A</div>
					<div class="col-auto">
						<button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#zoom">
							<img src="images/ice-cubes.jpg" alt="" srcset="" class="img-thumbnail" style="max-width: 240px;" id="myImgD">
					</div>
				</div>
				<div class="row">
					<div class="col-auto">
						<input type="radio" class="btn-check" name="jwb" id="jwbE" autocomplete="off">
						<label class="btn btn-outline-dark col-auto text-start" for="jwbE">E</label>
					</div>
					<div class="col-auto">Jawaban A</div>
					<div class="col-auto">
						<button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#zoom">
							<img src="images/ice-cubes.jpg" alt="" srcset="" class="img-thumbnail" style="max-width: 240px;" id="myImgE">
					</div>
				</div>
			</div>
			<!-- === Akhir Jawaban === -->
		</div>
	</div>
	<div class="row m-3 justify-content-around text-center gap-2">
		<button class="btn col-sm-3 fs-5 btnr btn-primary">Sebelumnya</button>
		<button class="btn col-sm-3 fs-5 btnr btn-warning">Ragu-Ragu</button>
		<button class="btn col-sm-3 fs-5 btnr btn-primary">Berikutnya</button>
	</div>
	<footer>
		<div class="col-12 bg-dark text-white text-center" style="height: 30px;"><?php include_once("config/about.php") ?></div>
	</footer>
</body>

</html>

<!-- === Slide === -->
<div id="df_soal" class="sidenav bg-dark z-3">
	<a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
	<h4 class="text-light m-4">Pilihan Ganda</h4>
	<?php
	$ls_soal = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM cbt_ljk"));
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
</div>

<div class="offcanvas offcanvas-end bg-light" tabindex="-1" id="list_soal" aria-labelledby="list_soalLabel">
	<div class=" offcanvas-header">
		<button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
		<h4 class="mx-4">Daftar Soal</h4>
	</div>
	<?php
	$ckpg = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM cbt_ljk WHERE jns_soal = 'G'"));
	$ckes = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM cbt_ljk WHERE jns_soal = 'E'"));
	$ls_pg = (mysqli_query($koneksi, "SELECT * FROM cbt_ljk WHERE jns_soal = 'G'"));
	$ls_es = (mysqli_query($koneksi, "SELECT * FROM cbt_ljk WHERE jns_soal = 'E'"));
	// $ls_es = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM cbt_ljk WHERE jns_soal = 'E'"));
	if ($ckpg["jns_soal"] == "G") {
	?>
		<h5 class="m-4">Pilihan Ganda</h5>
		<div class="offcanvas-body">
		<?php
		$no = 1;
		while ($dt = mysqli_fetch_array($ls_pg)) {
			$jw = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM cbt_ljk WHERE jns_soal = 'G';"));
			echo "
				<button type='button' class='btn btn-dark position-relative ms-3 mb-3 text-center' style='width: 40px;'>
				$dt[urut]
				<span class='position-absolute top-0 start-100 translate-middle badge rounded-pill bg-info'>
				$dt[jwbn]
				</span>
			</button>
		 	";
			$no++;
		}
	}
	if ($ckes["jns_soal"] == "E") {
		echo "<h5 class='m-4'>Esai</h5>";
		$no = 1;
		while ($dt = mysqli_fetch_array($ls_es)) {
			$jw = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM cbt_ljk WHERE jns_soal = 'E' AND urut ='$no';"));
			echo "
				<button type='button' class='btn btn-dark position-relative ms-3 mb-3 text-center' style='width: 40px;'>
				$dt[urut]
				</button>
		 		";
			$no++;
		}
	} ?>
		</div>
</div>

<!-- === Modal === -->
<div id="myModalimg" class="modal">
	<span class="close">&times;</span>
	<img class="modal-content" id="img01">
	<div id="caption"></div>
</div>

<!-- === JavaScript === -->
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

		// Keluarkan hasil dalam elemen dengan id = "lm_ujian"
		if (days != "0") {
			document.getElementById("lm_ujian").innerHTML = days + " Hari, " + hours + ":" + minutes + ":" + seconds;
		} else {
			document.getElementById("lm_ujian").innerHTML = hours + ":" + minutes + ":" + seconds;
		}

		// Jika hitungan mundur selesai, tulis beberapa teks 
		if (distance < 0) {
			clearInterval(x);
			document.getElementById("lm_ujian").innerHTML = "Waktu Habis";
		}
	}, 1000);


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

	// === Images ===//
	// Get the modal
	var modal = document.getElementById("myModalimg");

	// Get the image and insert it inside the modal - use its "alt" text as a caption
	var img = document.getElementById("myImg");
	var modalImg = document.getElementById("img01");
	var captionText = document.getElementById("caption");
	img.onclick = function() {
		modal.style.display = "block";
		modalImg.src = this.src;
		captionText.innerHTML = this.alt;
	}
	var img = document.getElementById("myImgA");
	var modalImg = document.getElementById("img01");
	var captionText = document.getElementById("caption");
	img.onclick = function() {
		modal.style.display = "block";
		modalImg.src = this.src;
		captionText.innerHTML = this.alt;
	}
	var img = document.getElementById("myImgB");
	var modalImg = document.getElementById("img01");
	var captionText = document.getElementById("caption");
	img.onclick = function() {
		modal.style.display = "block";
		modalImg.src = this.src;
		captionText.innerHTML = this.alt;
	}
	var img = document.getElementById("myImgC");
	var modalImg = document.getElementById("img01");
	var captionText = document.getElementById("caption");
	img.onclick = function() {
		modal.style.display = "block";
		modalImg.src = this.src;
		captionText.innerHTML = this.alt;
	}
	var img = document.getElementById("myImgD");
	var modalImg = document.getElementById("img01");
	var captionText = document.getElementById("caption");
	img.onclick = function() {
		modal.style.display = "block";
		modalImg.src = this.src;
		captionText.innerHTML = this.alt;
	}
	var img = document.getElementById("myImgE");
	var modalImg = document.getElementById("img01");
	var captionText = document.getElementById("caption");
	img.onclick = function() {
		modal.style.display = "block";
		modalImg.src = this.src;
		captionText.innerHTML = this.alt;
	}

	// Get the <span> element that closes the modal
	var span = document.getElementsByClassName("close")[0];

	// When the user clicks on <span> (x), close the modal
	span.onclick = function() {
		modal.style.display = "none";
	}
</script>