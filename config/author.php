<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<title>Author Information</title>
</head>

<style>
	.bg-author {
		background-image: url("../img/cubes.png");
		/* background-color: #ffffff21; */
	}
</style>

<?php include_once('about.php'); ?>

<body>
	<div class="container-fluid container-xl my-5">
		<div class="row g-5 justify-content-center">
			<div class="col-12 col-md-10 col-lg-8">
				<div class="card">
					<div class="card-header text-center">
						<h4>Fitur Aplikasi <?= $ver_app ?></h4>
					</div>
					<div class="card-body bg-author" style="text-align: justify;">
						<?= $_des; ?>
					</div>
				</div>

			</div>
			<div class="col-12 col-md-10 col-lg-4">
				<div class="card">
					<div class="card-header text-center">
						<h4>Aplikasi MyTBK</h4>
					</div>
					<div class="card-body bg-author">
						<?= $_app; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>

</html>