<?php
include_once("config/server.php");

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title><?php echo $inf_nm ?></title>
	<link rel="shortcut icon" href="img/<?php if ($inf_fav != null) {
																				echo $inf_fav;
																			} else {
																				echo "fav.png";
																			} ?>" type="image/x-icon">

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
          <?php 
          $uri = explode("/",$_SERVER["REQUEST_URI"]);
          ?>
					<!-- <form action="<?php echo $_SERVER['SERVER_NAME']."/". $uri[1] ?>" method="post" enctype="multipart/form-data"> -->
					<form action="logout.php" method="post" enctype="multipart/form-data">
						<h2>Peringatan!!!</h2>
            <p>
              Anda Terdeteksi Online
            </p>
						<button class="w-100 btn btn-lg btn-primary" type="submit" name="login" id="login">Masuk</button>
						<p class="mt-5 mb-3 ">&copy;Create 2022
							<?php if (date('Y') > 2022) {
								echo "- " . date('Y');
							} ?>
							by Triyono<br>
							<!-- supported by <img class="" src="img/bootstrap-logo.png" alt="" width="25" height="25"> -->
						</p>
					</form>
				</main>
			</div>
		</div>
	</div>
</body>
</html>