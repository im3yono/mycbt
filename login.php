<!DOCTYPE html>
<html lang="en">

<?php
include_once("config/server.php");

?>

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title><?= $inf_nm ?></title>
	<link rel="shortcut icon" href="img/<?= ($inf_fav != null) ? $inf_fav : "fav.png"; ?>" type="image/x-icon">

	<link rel="stylesheet" href="vendor/twbs/bootstrap/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="vendor/twbs/bootstrap-icons/font/bootstrap-icons.css">
	<script src="vendor/twbs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

	<script src="node_modules/sweetalert2/dist/sweetalert2.min.js"></script>
	<link rel="stylesheet" href="node_modules/sweetalert2/dist/sweetalert2.min.css">
	<link rel="stylesheet" href="aset/font.css">
	<link rel="stylesheet" href="aset/login.css">

	<script src="aset/time.js"></script>
</head>



<body>
	<div class="head">
		<!-- <div class="col-12 text-center">
			<img class="mt-4 img-fluid" src="img/MyTBK.png" alt="" width="330">
		</div> -->
	</div>
	<div class="container-lg container-fluid text-center" style="margin-top: -50px;">
		<div class="row mx-0 login justify-content-center">
			<div class="col col-img p-0">
				<div class="login-img ">
					<img src="img/bnr-mytbk.png" alt="" srcset="" width="200">
				</div>
			</div>
			<div class="col-auto p-0">
				<div class="login-form">
					<div class="row m-0 p-0 " style="width: 400px;">
						<div class="col-12 text-center header-login">
							<img class="mt-4 img-fluid" src="img/bnr-mytbk.png" alt="" width="200">
						</div>
						<div class="col-12">
							<main class="form-signin w-100 m-auto">
								<form action="" method="post" enctype="multipart/form-data" autocomplete="off">
									<h2 class="font-aladin"><?= $dibaiki != "" ? $dibaiki : "Login"; ?></h2>
									<?= $dibaiki != "" ? "<p>Mohon maaf sementara server dalam perbaikan.</p>" : ""; ?>
									<?php if ($dibaiki == "") { ?>
										<p class="font-capriola">Silahkan login dengan username dan password yang telah anda miliki.</p>
										<?php
										if (($db_null == 1 || $tbl_null == 1) && get_ip() != "127.0.0.1") {
											echo '<div class="alert alert-danger alert-dismissible fade show form-control-sm" role="alert">Database Belum tersedia <br> Hanya dapat diakses dari server</div>';
										} elseif ($db_null == 1 && get_ip() == "127.0.0.1") {
											echo '<div class="alert alert-danger alert-dismissible fade show form-control-sm" role="alert">Database Belum tersedia</div>';
										} elseif ($tbl_null == 1 && get_ip() == "127.0.0.1") {
											echo '<div class="alert alert-warning alert-dismissible fade show form-control-sm" role="alert">Database Belum Siap</div>';
										}
										if (isset($_GET['pesan'])) {
											if ($_GET['pesan'] == "gagal") {
												// echo "<script>alert('Username dan Password tidak sesuai  !');history.go(-1)</script";
												echo '
												<div id="alert-login" class="alert alert-danger alert-dismissible fade show form-control-sm p-2 mt-2" role="alert">
													Username atau Password tidak sesuai!
												</div>

												<script>
													// Tutup otomatis setelah 3 detik
													setTimeout(function() {
														const alert = document.getElementById("alert-login");
														if (alert) {
															alert.classList.remove("show");
															alert.classList.add("hide");

															// Optional: benar-benar hapus dari DOM setelah animasi
															setTimeout(function() {
																alert.remove();
															}, 100); // waktu transisi bootstrap
														}
													}, 3000); // 3 detik
												</script>
												';
											} elseif ($_GET['pesan'] == "id") {
												echo '<div class="alert alert-danger alert-dismissible fade show form-control-sm p-2" role="alert">
												Id Karyawan belum terdaftar ! 
												</div>';
												// echo '<meta http-equiv="refresh" content="3;url=login.php">';
											} elseif ($_GET['pesan'] == "ck") {
												echo '<div class="alert alert-success alert-dismissible fade show form-control-sm p-2" role="alert">
												Id Karyawan Sudah Aktif <br> Silahkan Login ! 
												</div>';
												// echo '<meta http-equiv="refresh" content="3;url=login.php">';
											} elseif ($_GET['pesan'] == "off") {
												echo '<div class="alert alert-success alert-dismissible fade show form-control-sm p-2" role="alert">
												Akun Anda Belum Aktif <br> Hubungi Admin ! 
												</div>';
												// echo '<meta http-equiv="refresh" content="3;url=login.php">';
											} elseif ($_GET['pesan'] == "db") {
												echo '<div class="alert alert-success alert-dismissible fade show form-control-sm p-2" role="alert">
												Hanya dapat diakses dari server
												</div>';
											} elseif ($_GET['pesan'] == "dblg") {
												echo '<div class="alert alert-warning alert-dismissible fade show form-control-sm p-2" role="alert">
												Username dan Password <br> tidak sesuai !
												</div>';
												// echo '<meta http-equiv="refresh" content="3;url=login.php">';
											} elseif ($_GET['pesan'] == "admOff") {
												echo '<div class="alert alert-warning alert-dismissible fade show form-control-sm p-2" role="alert">
												akses admin sedang dinonaktifkan
												</div>';
											} elseif ($_GET['pesan'] == "sisOff") {
												echo '<div class="alert alert-warning alert-dismissible fade show form-control-sm p-2" role="alert">
												akses siswa sedang dinonaktifkan
												</div>';
											}
										}
										?>
										<div class="form-floating">
											<input type="text" class="form-control" id="username" name="username" placeholder="Username" required autocomplete="off">
											<label for="username">Username</label>
										</div>
										<div class=" input-group">
											<div class="form-floating">
												<input type="password" class="form-control" id="password" name="password" placeholder="Password" required autocomplete="new-password">
												<label for="password">Password</label>
											</div>
											<div class="input-group-text ckb">
												<input class="btn-check" type="checkbox" id="view" onclick="showPass()" autocomplete="off">
												<label for="view" style="cursor: pointer;"><i class="fs-4 bi bi-eye ey"></i></label>
											</div>
										</div>
										<button class="w-100 btn btn-lg btn-primary font-Delius fw-bold" type="submit" name="login" id="login">Masuk</button>
										<p class="mt-md-4 m-2 font-Delius">
										<?php include_once("config/about.php");
									} ?>
										</p>
								</form>
							</main>
						</div>
						<div class="col-12">
							<div class="fs-md-4 fs-3 pt-md-2 font-aladin">Waktu <span id="jam"></span></div>
						</div>
					</div>
				</div>
			</div>
		</div>
</body>

</html>
<?php
if (isset($_REQUEST['login']) == "") {
} elseif (($_REQUEST['login']) == "on") { ?>
	<script>
		Swal.fire({
			icon: 'error',
			title: 'Peringatan',
			text: 'Anda Sudah Login',
			// footer: '<a href="">Why do I have this issue?</a>'
		})
	</script>
<?php
} elseif (($_REQUEST['login']) == "tunggu") { ?>
	<script>
		Swal.fire({
			icon: 'success',
			title: 'Berhasil!',
			text: 'Mohon Menunggu Admin Sedang Melakukan Restart ',
			// footer: '<a href="">Why do I have this issue?</a>'
		})
	</script>
<?php
} elseif (($_REQUEST['login']) == "selesai") { ?>
	<script>
		Swal.fire({
			icon: 'success',
			title: 'Selesai!',
			text: 'Terima Kasih Telah Mengikuti Tes',
			// footer: '<a href="">Why do I have this issue?</a>'
		})
	</script>
<?php
}
?>
<script src="node_modules/jquery/dist/jquery.min.js"></script>
<script>
	function showPass() {
		var x = document.getElementById("password");
		var ey = document.getElementById("view");
		if (x.type === "password") {
			$('.ey').removeClass('bi-eye');
			$('.ey').addClass('bi-eye-slash');
			x.type = "text";
		} else {
			$('.ey').removeClass('bi-eye-slash');
			$('.ey').addClass('bi-eye');
			x.type = "password";
		}
	}
</script>