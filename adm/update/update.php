<!DOCTYPE html>
<html lang="id">

<head>
	<meta charset="UTF-8" />
	<title>Upload Update Aplikasi</title>
	<style>
		body {
			font-family: sans-serif;
			margin: 2rem;
		}

		input[type="file"] {
			margin: 10px 0;
		}

		#result {
			margin-top: 1rem;
		}
	</style>
</head>

<body>
	<h2>Upload File Update Aplikasi (.zip)</h2>
	<form id="uploadForm">
		<input type="file" name="updateFile" id="updateFile" accept=".zip" required />
		<br />
		<button type="submit">Upload & Update</button>
	</form>

	<div id="result"></div>

	<script>
		document.getElementById("uploadForm").addEventListener("submit", async function(e) {
			e.preventDefault();

			const fileInput = document.getElementById("updateFile");
			const file = fileInput.files[0];
			const result = document.getElementById("result");

			if (!file) {
				result.innerHTML = '<span style="color:red;">Silakan pilih file terlebih dahulu.</span>';
				return;
			}

			const formData = new FormData();
			formData.append("updateFile", file);

			result.innerHTML = "⏳ Mengunggah dan memproses update...";

			try {
				const response = await fetch("upload_update.php", {
					method: "POST",
					body: formData,
				});

				const text = await response.text();
				result.innerHTML = text;
			} catch (error) {
				console.error(error);
				result.innerHTML = '<span style="color:red;">Terjadi kesalahan saat mengunggah file!</span>';
			}
		});
	</script>
</body>

</html>