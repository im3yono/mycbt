<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Aplikasi UNBK</title>
	<link rel="shortcut icon" href="img/logo_sma.png" type="image/x-icon">

	<link rel="stylesheet" href="vendor/twbs/bootstrap/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="vendor/twbs/bootstrap-icons/font/bootstrap-icons.css">
	<script src="vendor/twbs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
	<script src="aset/time.js"></script>
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
		transition: background-color .5s;

	}

	.time {
		border: 1px solid;
		border-color: #696969;
		background-color: #FFFAFA;
		width: 2fr;
		border-radius: 25px;
		margin: 3px;
		padding: 3px;
		padding-right: 10px;
		padding-left: 10px;
		font-family: Arial;
		font-size: 18px;
	}

	.head {
		height: 200px;
		background-image: url(img/header-bg.png);
	}

	.sidenav {
		height: 100%;
		width: 0px;
		position: fixed;
		z-index: 1;
		top: 0;
		right: 0;
		/* background-color: #fff; */
		overflow-x: hidden;
		transition: 0.5s;
		padding-top: 5px;
	}

	.sidenav a {
		padding: 8px 8px 8px 32px;
		text-decoration: none;
		font-size: 25px;
		color: #424141;
		display: block;
		transition: 0.3s;
	}

	.sidenav a:hover {
		color: #807d7d;
	}

	.sidenav .closebtn {
		position: relative;
		top: 0;
		left: 0px;
		font-size: 36px;
		margin-left: 0px;
	}

	#main {
		transition: margin-right .5s;
	}

	@media screen and (max-height: 350px) {
		.sidenav {
			padding-top: 0px;
			;
		}

		.sidenav a {
			font-size: 18px;
		}
	}

	.btnr{
		border-radius: 25px;
		
	}
</style>

<body id="main" class="main">
	<div class="head container-fluid pt-md-5 pt-3">
		<div class=" row justify-content-around">
			<div class="col-md-5 text-center text-md-start">
				<img class="img-fluid" src="img/logo.png" alt="">
			</div>
			<div class="col-md-5 text-md-end text-center mt-2">
				<p class="text-light">Nama akun <br> kelas</p>
			</div>
		</div>
	</div>
	<div class="container-fluid pb-5" style="margin-top: -30px;font-family: Times New Roman;">
		<div class="card shadow mb-3 mx-3 sticky-top z-1">
			<div class="row p-2 justify-content-around">
				<div class="col-sm-auto col-12 h3 text-center text-sm-start">
					<label class="fw-semibold align-text-bottom">No.</label>
					<div class="badge bg-primary text-wrap" style="width: auto;">50</div>
				</div>
				<div class="col text-center text-sm-end">
					<label class="time me-2" id="lm_ujian">Waktu Ujian</label>
					<button class="btn btn-primary mx-3" onclick="openNav()">&#9776; Daftar Soal</button>
				</div>
			</div>
		</div>
		<div class="card shadow-lg m-3 pb-2">
			<div class="row m-3">
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
			</div>
			<div class="row mx-5 my-3 fs-5">
				A <br> B <br> C <br> D <br> E
			</div>
		</div>
		<div class="m-3">
			<div class="row m-3 justify-content-around text-center gap-2">
				<button class="btn col-sm-3 fs-5 btnr btn-primary">Sebelumnya</button>
				<button class="btn col-sm-3 fs-5 btnr btn-warning">Ragu-Ragu</button>
				<button class="btn col-sm-3 fs-5 btnr btn-primary">Berikutnya</button>
			</div>
		</div>
	</div>
	</div>
</body>

</html>

<!-- === Slide === -->
<div id="df_soal" class="sidenav bg-dark z-3">
	<a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
	<h4 class="text-light m-4">Pilihan Ganda</h4>
	<?php
	$a = 1;
	while ($a <= 10) {
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

<!-- === Modal === -->
<!-- <div class="modal fade" id="df_soal" aria-hidden="true" aria-labelledby="df_soalLabel" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="df_soalLabel">Daftar Soal</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Show a second modal and hide this one with the button below.
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="df_soal2" aria-hidden="true" aria-labelledby="df_soalLabel2" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="df_soalLabel2">Modal 2</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Hide this modal and show the first with the button below.
      </div>
      <div class="modal-footer">
        <button class="btn btn-primary" data-bs-target="#df_soal" data-bs-toggle="modal">Back to first</button>
      </div>
    </div>
  </div>
</div> -->

<!-- === JavaScript === -->

<script>
	// Mengatur waktu akhir perhitungan mundur
	var countDownDate = new Date("2023-05-09 8:37:25").getTime();

	// Memperbarui hitungan mundur setiap 1 detik
	var x = setInterval(function() {

		// Untuk mendapatkan tanggal dan waktu hari ini
		var now = new Date().getTime();

		// Temukan jarak antara sekarang dan tanggal hitung mundur
		var distance = countDownDate - now;

		// Perhitungan waktu untuk hari, jam, menit dan detik
		var days = Math.floor(distance / (1000 * 60 * 60 * 24));
		var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
		var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
		var seconds = Math.floor((distance % (1000 * 60)) / 1000);

		// Keluarkan hasil dalam elemen dengan id = "lm_ujian"
		document.getElementById("lm_ujian").innerHTML = days + "d " + hours + "h " +
			minutes + "m " + seconds + "s ";

		// Jika hitungan mundur selesai, tulis beberapa teks 
		if (distance < 0) {
			clearInterval(x);
			document.getElementById("lm_ujian").innerHTML = "EXPIRED";
		}
	}, 1000);


	// === Slide === //
	function openNav() {
		document.getElementById("df_soal").style.width = "250px";
		// document.getElementById("main").style.marginRight = "250px";
		document.document.getElementById("main").style.backgroundColor = "rgba(0,0,0,0.8)";
	}

	function closeNav() {
		document.getElementById("df_soal").style.width = "0";
		// document.getElementById("main").style.marginRight = "0";
		document.body.style.backgroundColor = "white";
	}
</script>