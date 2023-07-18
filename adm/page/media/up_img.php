<div class="container-fluid mb-5 p-0">
	<div class="row p-2 border-bottom fs-3 mb-3 shadow-sm "><div class="col-auto"><a href="?md=f_soal" class="btn btn-outline-dark"><i class="bi bi-arrow-left"></i> Kembali</a></div> Upload File Gambar</div>
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
				<h6>Extensi File Gambar yang suport adalah:</h6>
				<ul>
					<li> jpg </li>
					<li> png </li>
					<li> jpeg </li>
				</ul>
			</div>
		</div>
		<div class="col-auto ">
			<?php
			if ($_SERVER['REQUEST_METHOD'] == 'POST') {
				$folder = "./../images";
				if (!is_dir($folder)) {
					// # jika tidak maka folder harus dibuat terlebih dahulu
					mkdir($folder, 0777, $rekursif = true);
					echo "belum";
				} else {
					// echo "sudah";
				}

				$err_exe = 0;
				$sccs    = 0;
				$format =  array('png', 'jpg', 'jpeg', 'PNG', 'JPG', 'JPEG');
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
						move_uploaded_file($tmp, $folder . '/' . $nm);
						$sccs++;
					}
				}

				if ($err_exe != 0) {
					echo '<div class="alert alert-danger"> Gagal Upload Gambar : ' . $err_exe . '</div>';
				}
				if ($sccs != 0) {
					echo '<div class="alert alert-info"> Berhasil Upload Gambar : ' . $sccs . '</div>';
				}
			}
			?>
			<form method="post" enctype="multipart/form-data" action="">
				<div class="input-group">
					<input type="file" multiple class="form-control" name="img[]" id="img" aria-describedby="inputGroupFileAddon04" aria-label="Upload">
					<button type="submit" class="btn btn-primary" name="import">Upload</button>
				</div>
			</form>
		</div>
	</div>
	<div class="row p-2 g-2">
		<!-- <div class="col border text-center" style="border-radius: 5px; max-width: 170px;min-width: 130px;"> -->
		<div id="ft"></div>
		<!-- </div> -->
	</div>
</div>

<script src="../../../node_modules/jquery/dist/jquery.min.js"></script>
<script src="./../../node_modules/jquery/dist/jquery.min.js"></script>
<script src="../../node_modules/jquery/dist/jquery.min.js"></script>
<script>
	$(function() {
		// Multiple images preview in browser
		var imagesPreview = function(input, placeToInsertImagePreview) {

			if (input.files) {
				var filesAmount = input.files.length;

				for (i = 0; i < filesAmount; i++) {
					var reader = new FileReader();

					reader.onload = function(event) {
						$($.parseHTML('<img width="230" class="p-2" >')).attr('src', event.target.result).appendTo(placeToInsertImagePreview);
					}

					reader.readAsDataURL(input.files[i]);
				}
			}

		};

		$('#img').on('change', function() {
			imagesPreview(this, '#ft');
		});
	});
</script>