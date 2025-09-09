<!DOCTYPE html>
<html lang="id">

<head>
	<meta charset="UTF-8" />
	<title>Upload Update Aplikasi</title>
	<link rel="shortcut icon" href="../../img/bnr-mytbk.png" type="image/x-icon">
	<link rel="stylesheet" href="../../vendor/twbs/bootstrap/dist/css/bootstrap.min.css">
	<style>
		body {
			font-family: sans-serif;
			margin: 2rem;

			background-image: url("../../img/cubes.png");
			/*  background-repeat: no-repeat;
      background-size: 100% 100%; */
			/* background-color: aquamarine; */
			background-color: #ffffff36;
		}

		/* input[type="file"] {
			margin: 10px 0;
		} */

		#result {
			margin-top: 1rem;
		}
	</style>
</head>
<?php if ($_COOKIE['user'] != "admin") {
	header("Location: ../?md=setting");
} ?>

<body>
	<div class="row justify-content-center">
		<div class="col-auto col-md-6 col-xl-4">
			<div class="card text-center">
				<div class="card-header bg-primary-subtle">
					<h4>Update Aplikasi</h4>
				</div>
				<div class="card-body">
					<p>Silakan pilih file update aplikasi yang ingin diunggah. Pastikan file tersebut dalam format ZIP.</p>
					<form id="uploadForm">
						<div class="input-group">
							<input type="file" class="form-control" name="updateFile" id="updateFile" aria-describedby="inputGroupFileAddon04" aria-label="Upload">
							<button class="btn btn-primary" type="submit" id="updateFile">Upload & Update</button>
						</div>
					</form>
					<div class="row justify-content-center mt-5">
						<div class="col-auto" id="result"></div>
						<div class="col-auto">
							<a href='javascript:history.go(-1)' class='btn btn-outline-secondary mt-2'>Kembali ke halaman Pengaturan</a>
						</div>
					</div>
				</div>
				<div class="card-footer text-body-emphasis">
					<?php include_once('../../config/about.php');
					echo $buat . $by ?>
				</div>
			</div>
		</div>
	</div>


	<script>
		document.getElementById("uploadForm").addEventListener("submit", async function(e) {
			e.preventDefault();

			const fileInput = document.getElementById("updateFile");
			const file = fileInput.files[0];
			const result = document.getElementById("result");

			if (!file) {
				result.innerHTML = '<span class="text-danger">Silakan pilih file terlebih dahulu.</span>';
				return;
			}

			const formData = new FormData();
			formData.append("updateFile", file);

			// Tampilkan spinner bootstrap
			result.innerHTML = `
		<div class="d-flex align-items-center gap-2">
			<div class="spinner-border text-primary" role="status" style="width: 1.5rem; height: 1.5rem;">
				<span class="visually-hidden">Loading...</span>
			</div>
			<span>Mengunggah dan memproses update...</span>
		</div>
	`;

			try {
				const response = await fetch("upload_update.php", {
					method: "POST",
					body: formData,
				});

				const text = await response.text();
				result.innerHTML = text;
			} catch (error) {
				console.error(error);
				result.innerHTML = '<span class="text-danger">Terjadi kesalahan saat mengunggah file!</span>';
			}
		});
	</script>

</body>

</html>