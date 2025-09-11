<div class="container-fluid mb-5 p-0">
	<div class="row p-2 border-bottom fs-3 mb-3 shadow-sm ">
		<div class="col-auto">
			<a href="?md=f_soal" class="btn btn-outline-dark">
				<i class="bi bi-arrow-left"></i> Kembali
			</a>
		</div>
		Upload File Pendukung Soal
	</div>
	<div class="row p-2 m-0">
		<div class="col-12 border-bottom mb-3">
			<div class="alert alert-info">
				<h6>Extensi File yang suport adalah:</h6>
				<ul class="mb-0">
					<li>Gambar: jpg, png, jpeg</li>
					<li>Audio: mp3, wav, ogg</li>
					<li>Video: mp4, avi, mkv</li>
				</ul>
			</div>
		</div>
		<div class="col-auto ">
			<form id="uploadForm">
				<div class="input-group">
					<input type="file" multiple class="form-control"
						name="img[]" id="img"
						accept=".jpg,.jpeg,.png,.mp3,.wav,.ogg,.mp4,.avi,.mkv" required>
					<button type="submit" class="btn btn-primary">Upload</button>
				</div>
			</form>
		</div>
	</div>
	<div class="row p-2 g-2">
		<div id="progress" class="mt-2 text-primary fw-bold"></div>
		<div id="ft"></div>
	</div>
</div>

<script src="../node_modules/jquery/dist/jquery.min.js"></script>
<script>
	// preview file
	$(function() {
		$('#img').on('change', function() {
		$('#progress').empty();
		// document.getElementById("progress").innerHTML = "";
			$('#ft').empty();
			let files = this.files;
			for (let file of files) {
				let previewElement;
				if (file.type.match('image.*')) {
					let reader = new FileReader();
					reader.onload = function(e) {
						previewElement = $('<img>', {
							src: e.target.result,
							class: 'p-2',
							width: 230
						});
						$('#ft').append(previewElement);
					};
					reader.readAsDataURL(file);
				} else if (file.type.match('audio.*')) {
					previewElement = $('<audio>', {
						src: URL.createObjectURL(file),
						class: 'p-2',
						controls: true
					});
					$('#ft').append(previewElement);
				} else if (file.type.match('video.*')) {
					previewElement = $('<video>', {
						src: URL.createObjectURL(file),
						class: 'p-2',
						width: 230,
						controls: true
					});
					$('#ft').append(previewElement);
				}
			}
		});
	});

	// upload dengan chunk
	async function uploadFile(file) {
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

			let percent = Math.round(((i + 1) / totalChunks) * 100);
			document.getElementById("progress").innerHTML = `
				<div class="progress">
					<div class="progress-bar progress-bar-striped progress-bar-animated bg-primary" 
						role="progressbar" style="width: ${percent}%;" aria-valuenow="${percent}" aria-valuemin="0" aria-valuemax="100">
						${percent}%
					</div>
				</div>
			`;
		}
	}

	document.getElementById("uploadForm").addEventListener("submit", async function(e) {
		e.preventDefault();
		let files = document.getElementById("img").files;
		for (let file of files) {
			await uploadFile(file);
		}
		// alert("Semua file berhasil diupload!");
	});
</script>