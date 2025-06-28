<?php
include_once("../config/server.php");
$dusrnm = $_COOKIE['user'];
$qr_u	= mysqli_query($koneksi, "SELECT * FROM `user` WHERE username ='$dusrnm'");
$du 	= mysqli_fetch_array($qr_u);

$images = glob("./images/$dusrnm.*");
if (!empty($images)) {
	$ftp = $images[0];
} else {
	$ftp = '../img/noavatar.png';
}
?>


<style>
	#pf {
		display: flex;
	}

	.puser {
		background-color: aqua;
	}
	.profil {
		background-color: #f8f9fa;
	}
</style>
<div class="container-fluid mb-5 p-0 pb-5">
	<div class="row p-2 border-bottom fs-3 mb-4 shadow-sm text-uppercase fw-semibold">Profil</div>

	<div class="row profil gap-3 p-3 m-md-5 m-0">
		<div class="col-12 col-md-4 p-2 border align-content-center" style="border-radius: 7px;min-width: 200px;min-height: 200px;">
			<div class="row justify-content-center m-0 p-0">
				<div class="card text-center" style="max-width: 300px;">
					<form action="./db/upload.php?up=ftp" method="post" enctype="multipart/form-data">
						<div class="card-body pt-4 d-flex flex-column align-items-center">
							<label for="ftp" style="cursor: pointer;">
								<img src="<?= $ftp; ?>" class="" alt="..." style="height: 170px; width: 170px;">
							</label>
							<h6 class="card-title">Klik gambar untuk ganti Foto Profile</h6>
							<input class="form-control form-control-sm" id="ftp" name="ftp" type="file" onchange="this.form.submit()" hidden>
						</div>
					</form>
				</div>
			</div>
		</div>
		<div class="col-12 col-md p-3 border" style="border-radius: 7px;">
			<form action="./db/dbproses.php?pr=us_ed" method="post" id="fr" class="needs-validation">
				<input type="text" name="use" id="use" value="puser" hidden>
				<div class="row">
					<div class="mb-3 col-sm-6 col">
						<label for="nm" class="form-label">Nama</label>
						<input type="text" class="form-control" id="nm" name="nm" value="<?= $du['nm_user'] ?>" <?= $du['username'] == "admin" ? "readonly" : ""; ?>>
					</div>
					<div class="mb-3 col-sm-6 col-12">
						<label for="usr" class="form-label">Username</label>
						<input type="text" class="form-control" id="usr" name="usr" value="<?= $du['username'] ?>" <?= $du['username'] == "admin" ? "readonly" : ""; ?>>
						<input type="text" id="usrlm" name="usrlm" value="<?= $du['username'] ?>" hidden>
					</div>
				</div>
				<div class="row">
					<div class="mb-3 col-sm-6 col-12">
						<label for="pass" class="form-label">Password</label>
						<input type="password" class="form-control" id="pass" name="pass">
					</div>
					<div class="mb-3 col-sm-6 col-12">
						<label for="knotlp" class="form-label">Konfirmasi Password</label>
						<input type="password" class="form-control" id="kpass" name="kpass">
					</div>
					<div class="mb-3 col-sm-6 col-12">
						<label for="notlp" class="form-label">No Tlp/Hp</label>
						<input type="text" class="form-control" id="notlp" name="notlp" value="<?= $du['tlp'] ?>">
						<input type="text" id="lvl" name="lvl" value="<?= $du['lvl'] ?>" hidden>
					</div>
				</div>
				<button type="submit" class="btn btn-primary">Simpan</button>
			</form>
		</div>
	</div>
</div>

<!-- <script src="../../node_modules/jquery/dist/jquery.js"></script> -->
<script>
	document.getElementById('fr').addEventListener('submit', function(event) {
		var pass = document.getElementById('pass').value;
		var kpass = document.getElementById('kpass').value;
		if (pass !== kpass) {
			event.preventDefault();
			Swal.fire({
				icon: 'error',
				title: 'Oops...',
				text: 'Password dan Konfirmasi Password tidak cocok!'
			});
		}
	});
</script>