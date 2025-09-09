<!DOCTYPE html>
<html lang="id">

<head>
	<meta charset="UTF-8" />
	<title>MyTBK</title>
	<link rel="shortcut icon" href="img/bnr-mytbk.png" type="image/x-icon">
	<link rel="stylesheet" href="vendor/twbs/bootstrap/dist/css/bootstrap.min.css">
	<style>
		body {
			font-family: sans-serif;
			margin: 2rem;
			background-image: url("img/cubes.png");
			background-color: #ffffff36;
		}
	</style>
</head>

<body>
	<div class="row justify-content-center">
		<div class="col-auto col-md-6 col-xl-4">
			<div class="card text-center">
				<div class="card-header bg-primary-subtle">
					<h4>Akses Database</h4>
				</div>
				<div class="card-body">
					<p>Silahkan masukkan akses ke databse username dan password</p>

					<?php include_once('config/lib/funct.php');
					if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['username']) && isset($_POST['password'])) {
						$username = $_POST['username'];
						$password = $_POST['password'];
						$file = 'config/db_acc.php';

						if (!empty($username) && !empty($password)) {
							fileUser($file, $username, $password);
							echo "<div class='alert alert-success'>Proses Akses...</div>";
							echo '<meta http-equiv="refresh" content="3">';
						} else {
							echo "<div class='alert alert-danger'>Data tidak boleh kosong!</div>";
						}
					}
					?>

					<form method="post" class="col-12 col-md-8 col-xl-6 mx-auto">
						<div class="mb-3">
							<input type="text" class="form-control" name="username" id="username" placeholder="Username Database" required>
						</div>
						<div class="mb-3">
							<input type="password" class="form-control" name="password" id="password" placeholder="Password Database" required>
						</div>
						<button type="submit" class="btn btn-outline-primary">Simpan</button>
					</form>
				</div>
				<div class="card-footer text-body-emphasis">
					<?php include_once('config/about.php');
					echo $buat . $by ?>
				</div>
			</div>
		</div>
	</div>

</body>

</html>