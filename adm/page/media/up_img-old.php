<div class="container-fluid mb-5 p-0">
	<div class="row p-2 border-bottom fs-3 mb-3 shadow-sm ">
		<div class="col-auto"><a href="?md=f_soal" class="btn btn-outline-dark"><i class="bi bi-arrow-left"></i> Kembali</a></div> Upload File Pendukung Soal
	</div>
	<div class="row p-2 m-0">
		<div class="col-12 border-bottom mb-3">
			<div class="alert alert-danger">
				<h3>Perhatian!!!</h3>
				<ul>
					<li>Pastikan File <u> PHP.ini</u> sudah di Set (upload_max_filesize=3000M, post_max_size = 3000M) !!!!</li>
					<li>Pergunakan huruf dan angkat (A-Z, a-z, 0-9) untuk Nama File </li>
					<li>Tidak boleh memakai Spasi</li>
				</ul>
			</div>
			<div>
				<h6>Extensi File yang suport adalah:</h6>
				<div class="row">
					<div class="col-auto">
						<ul>
							<li> jpg </li>
							<li> png </li>
							<li> jpeg </li>
						</ul>
					</div>
					<div class="col-auto">
						<ul>
							<li> mp3</li>
							<li> wav</li>
							<li> ogg</li>
						</ul>
					</div>
					<div class="col-auto">
						<ul>
							<li> mp4</li>
							<li> avi</li>
							<li> mkv</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<div class="col-auto ">
			<?php
			if ($_SERVER['REQUEST_METHOD'] == 'POST') {
				$fl_img = "./../images";
				$fl_aud = "./../audio";
				$fl_vid = "./../video";

				$err_exe = 0;
				$sccs    = 0;
				$frt_img 	=  array('png', 'jpg', 'jpeg', 'PNG', 'JPG', 'JPEG');
				$frt_au		= array('mp3', 'wav', 'ogg', 'MP3', 'WAV', 'OGG');
				$frt_vid	= array('mp4', 'avi', 'mkv', 'MP4', 'AVI', 'MKV');
				$format		= array_merge($frt_img, $frt_au, $frt_vid);

				$jumlahFile = count($_FILES['img']['name']);
				for ($i = 0; $i < $jumlahFile; $i++) {
					$nm = $_FILES['img']['name'][$i];
					$tmp = $_FILES['img']['tmp_name'][$i];
					// $tipe_file = pathinfo($namafile, PATHINFO_EXTENSION);

					$x         = explode('.', $_FILES['img']['name'][$i]);
					$exe  = strtolower(end($x));

					if (!in_array($exe, $format)) {
						$err_exe++;
					} else {
						if (in_array($exe, $frt_img)) {
							$folder = $fl_img;
						} elseif (in_array($exe, $frt_au)) {
							$folder = $fl_aud;
						} elseif (in_array($exe, $frt_vid)) {
							$folder = $fl_vid;
						}
						if (!is_dir($folder)) {
							// # jika tidak maka folder harus dibuat terlebih dahulu
							mkdir($folder, 0777, $rekursif = true);
							// echo "belum";
						} else {
							// echo "sudah";
						}
						move_uploaded_file($tmp, $folder . '/' . $nm);
						$sccs++;
					}
				}

				if ($err_exe != 0) {
					echo '<div class="alert alert-danger"> Gagal Upload Gambar/Audio : ' . $err_exe . '</div>';
				}
				if ($sccs != 0) {
					echo '<div class="alert alert-info"> Berhasil Upload Gambar/Audio : ' . $sccs . '</div>';
				}
			}
			?>
			<form method="post" enctype="multipart/form-data" action="">
				<div class="input-group">
					<input type="file" multiple class="form-control" name="img[]" id="img" aria-describedby="inputGroupFileAddon04" aria-label="Upload" accept=".jpg,.jpeg,.png,.mp3,.wav,.oog,.mp4,.avi,.mkv" required>
					<button type="submit" class="btn btn-primary" name="import">Upload</button>
				</div>
			</form>
		</div>
	</div>
	<div id="progress" class="mt-2 text-primary fw-bold"></div>
	<div class="row p-2 g-2">
		<div id="ft"></div>
	</div>
</div>

<script src="../node_modules/jquery/dist/jquery.min.js"></script>
<script>
	$(function() {
		var filesPreview = function(input, placeToInsertPreview) {
			if (input.files) {
				var filesAmount = input.files.length;

				for (let i = 0; i < filesAmount; i++) {
					let file = input.files[i];
					let previewElement;

					if (file.type.match('image.*')) {
						// Preview image dengan FileReader
						let reader = new FileReader();
						reader.onload = function(event) {
							previewElement = $('<img>', {
								src: event.target.result,
								class: 'p-2',
								width: 230
							});
							$(placeToInsertPreview).append(previewElement);
						}
						reader.readAsDataURL(file);

					} else if (file.type.match('audio.*')) {
						// Preview audio langsung pakai URL.createObjectURL
						previewElement = $('<audio>', {
							src: URL.createObjectURL(file),
							class: 'p-2',
							controls: true
						});
						$(placeToInsertPreview).append(previewElement);

					} else if (file.type.match('video.*')) {
						// Preview video langsung pakai URL.createObjectURL
						previewElement = $('<video>', {
							src: URL.createObjectURL(file),
							class: 'p-2',
							width: 230,
							controls: true
						});
						$(placeToInsertPreview).append(previewElement);
					}
				}
			}
		};

		$('#img').on('change', function() {
			$('#ft').empty(); // clear preview lama
			filesPreview(this, '#ft');
		});
	});
</script>
<script>
	async function uploadBigVideo(file) {
		let chunkSize = 5 * 1024 * 1024; // 5MB
		let totalChunks = Math.ceil(file.size / chunkSize);

		for (let i = 0; i < totalChunks; i++) {
			let start = i * chunkSize;
			let end = Math.min(file.size, start + chunkSize);
			let blob = file.slice(start, end);

			let formData = new FormData();
			formData.append("file", blob);
			formData.append("name", file.name);
			formData.append("chunk", i);
			formData.append("total", totalChunks);

			let res = await fetch("page/media/upload_chunk.php", {
				method: "POST",
				body: formData
			});
			let result = await res.json();
			// console.log(result);

			// Progress bar (opsional)
			let percent = Math.round(((i + 1) / totalChunks) * 100);
			document.getElementById("progress").innerText = "Upload Video: " + percent + "%";
		}
		// alert("Upload selesai: " + file.name);
	}

	document.querySelector("form").addEventListener("submit", async function(e) {
		e.preventDefault();

		let files = document.getElementById("img").files;

		// Buat formData manual supaya tidak lewat <form> langsung
		let formData = new FormData();
		let hasSmallFiles = false;

		for (let file of files) {
			if (file.type.match("video.*") && file.size > (20 * 1024 * 1024)) {
				// Video besar → pakai chunk upload
				await uploadBigVideo(file);
			} else {
				// File kecil → tambahkan ke FormData
				formData.append("img[]", file);
				hasSmallFiles = true;
			}
		}

		// Kalau ada file kecil, upload via fetch ke PHP biasa
		if (hasSmallFiles) {
			let res = await fetch("", {
				method: "POST",
				body: formData
			});
			let html = await res.text();
			document.body.innerHTML = html; // reload respon PHP
			// location.reload(); // reload halaman
		}
		// document.addEventListener("DOMContentLoaded", function() {

		// Sembunyikan spinner dan tampilkan tabel setelah loading selesai
		setTimeout(function() {
			document.getElementById("loadingSpinner").style.display = "none";
			document.getElementById("warper").style.display = "block";
		}, 500);

		setInterval(() => {
			location.reload();
		}, 5000);

		// });
	});
</script>