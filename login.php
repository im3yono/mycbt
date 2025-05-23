<!DOCTYPE html>
<html lang="en">

<?php
include_once("config/server.php");


if (validateDate($d_exp)) {
	require_once "config/mode.php";
	if (cek_aktif($d_exp, "<")) {
		echo '<meta http-equiv="refresh" content="0;url=aktivasi.php">';
	}
} else {
	echo '<meta http-equiv="refresh" content="0;url=aktivasi.php?er=1">';
}


?>

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title><?php echo $inf_nm ?></title>
	<link rel="shortcut icon" href="img/<?= ($inf_fav != null) ? $inf_fav : "fav.png"; ?>" type="image/x-icon">

	<link rel="stylesheet" href="vendor/twbs/bootstrap/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="vendor/twbs/bootstrap-icons/font/bootstrap-icons.css">
	<script src="vendor/twbs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

	<script src="node_modules/sweetalert2/dist/sweetalert2.min.js"></script>
	<link rel="stylesheet" href="node_modules/sweetalert2/dist/sweetalert2.min.css">
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
		max-width: 330px;
		padding: 15px;
	}

	.form-signin .form-floating:focus-within {
		z-index: 2;
	}

	.form-signin #username {
		margin-bottom: -1px;
		border-bottom-right-radius: 0;
		border-bottom-left-radius: 0;
	}

	.form-signin #password {
		margin-bottom: 10px;
		border-top-left-radius: 0;
		/* border-top-right-radius: 0; */
	}

	.form-signin .ckb {
		margin-bottom: 10px;
		/* border-top-left-radius: 0; */
		border-top-right-radius: 0;
	}

	.head {
		height: 200px;
		background-image: url(img/header-bg.png);
	}
</style>


<body>
	<div class="head">
		<div class="col-12 text-center">
			<img class="mt-4 img-fluid" src="img/MyTBK.png" alt="" width="330">
		</div>
	</div>
	<div class="container text-center" style="margin-top: -50px;">
		<div class="row justify-content-center mx-3">
			<div class="card shadow" style="width: 400px;">
				<main class="form-signin w-100 m-auto">
					<form action="" method="post" enctype="multipart/form-data">
						<h2><?= $dibaiki != "" ? $dibaiki : "Login"; ?></h2>
						<?= $dibaiki != "" ? "<p>Mohon maaf sementara server dalam perbaikan.</p>" : ""; ?>
						<?php if ($dibaiki == "") { ?>
							<p>Silahkan login dengan username dan password yang telah anda miliki</p>
							<?php
							if ($db_null == 1 && get_ip() != "127.0.0.1") {
								echo '<div class="alert alert-danger alert-dismissible fade show form-control-sm" role="alert">
							Database Belum tersedia <br> Hanya dapat diakses dari server</div>';
							} elseif ($db_null == 1) {
								echo '<div class="alert alert-danger alert-dismissible fade show form-control-sm" role="alert">
							Database Belum tersedia</div>';
							}
							if (isset($_GET['pesan'])) {
								if ($_GET['pesan'] == "gagal") {
									// echo "<script>alert('Username dan Password tidak sesuai  !');history.go(-1)</script";
									echo '<div class="alert alert-danger alert-dismissible fade show form-control-sm p-2" role="alert">
								Username atau Password tidak sesuai ! 
								</div>';
									echo '<meta http-equiv="refresh" content="3;url=?">';
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
								}
							}
							?>
							<div class="form-floating">
								<input type="text" class="form-control" id="username" name="username" placeholder="Username" required>
								<label for="username">Username</label>
							</div>
							<div class=" input-group">
								<div class="form-floating">
									<input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
									<label for="password">Password</label>
								</div>
								<div class="input-group-text ckb">
									<input class="btn-check" type="checkbox" id="view" onclick="showPass()" autocomplete="off">
									<label for="view" style="cursor: pointer;"><i class="fs-4 bi bi-eye ey"></i></label>
								</div>
							</div>

							<!-- <div class="checkbox mb-3">
              <label>
                <input type="checkbox" value="remember-me"> Remember me
              </label>
            </div> -->
							<button class="w-100 btn btn-lg btn-primary" type="submit" name="login" id="login">Masuk</button>
							<p class="mt-5 mb-3 ">
							<?php include_once("config/about.php");
						} ?>
							</p>
					</form>
				</main>
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