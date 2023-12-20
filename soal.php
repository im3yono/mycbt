<?php
include_once("config/server.php");
$kds = $_GET['kds'];
$nos = $_GET['nos'];
$usr = $_GET['usr'];
$token = $_GET['tkn'];

// echo "<br>". $kds." ".$nos." ".$usr." ".$token;

$cek_ip = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM peserta_tes WHERE user='$usr' AND kd_soal='$kds'AND token='$token'"));
if (empty($cek_ip['ip'])) {
		echo '<script>window.location="/tbk/?knf=rest"	</script>';
}
if (($cek_ip['ip'])!=get_ip()) {
		echo '<script>window.location="logout.php?info=on"	</script>';
}
if ($cek_ip['sts']=="S") {
	echo '<script>window.location="logout.php?info=selesai"</script>';
}


function clear($data)
{
	$data = str_replace("<p>", "", $data);
	$data = str_replace("</p>", "", $data);

	return $data;
};

// No Images
function imgs($lok, $imgs)
{
	if (!empty($imgs)) {
		if (file_exists("$lok/$imgs")) {
			echo $lok . '/' . $imgs;
		} else {
			echo "img/No_image_available.svg.png".'" style="min-width:90px;"';
		}
	}
};


$sql_opsi = "SELECT * FROM cbt_ljk WHERE user_jawab ='$usr' AND token = '$token' AND urut ='$nos'";
$dt_opsi  = mysqli_fetch_array(mysqli_query($koneksi, $sql_opsi));
// echo $dt_opsi['no_soal'];
if (!empty($dt_opsi['no_soal'])) {
	$sql_soal = "SELECT * FROM cbt_soal WHERE kd_soal ='$kds' AND no_soal ='$dt_opsi[no_soal]';";
	// $sql_soal ="SELECT * FROM cbt_soal WHERE kd_soal ='X_BIndo' AND no_soal ='16';";

	$dt_soal = mysqli_fetch_array(mysqli_query($koneksi, $sql_soal));

	// LJK
	$jw_a   = "jwb" . $dt_opsi['A'];
	$jw_b   = "jwb" . $dt_opsi['B'];
	$jw_c   = "jwb" . $dt_opsi['C'];
	$jw_d   = "jwb" . $dt_opsi['D'];
	$jw_e   = "jwb" . $dt_opsi['E'];

	$img1   = "img" . $dt_opsi['A'];
	$img2   = "img" . $dt_opsi['B'];
	$img3   = "img" . $dt_opsi['C'];
	$img4   = "img" . $dt_opsi['D'];
	$img5   = "img" . $dt_opsi['E'];

	// kunci
	$key = $dt_opsi['knci_jwbn'];

	$jwbn   = $dt_opsi['jwbn'];
	$niljw  = $dt_opsi['nil_jwb'];

	// Soal
	$ids		= $dt_soal['id_soal'];
	$audio  = $dt_soal['audio'];
	$vid    = $dt_soal['vid'];
	$img    = $dt_soal['img'];
	$des    = ($dt_soal['cerita']);
	$kd_des = ($dt_soal['kd_crta']);
	$tanya  = ($dt_soal['tanya']);

	$op_a   = $dt_soal[$jw_a];
	$img_a  = $dt_soal[$img1];

	$op_b   = $dt_soal[$jw_b];
	$img_b  = $dt_soal[$img2];

	$op_c   = $dt_soal[$jw_c];
	$img_c  = $dt_soal[$img3];

	$op_d   = $dt_soal[$jw_d];
	$img_d  = $dt_soal[$img4];

	$op_e   = $dt_soal[$jw_e];
	$img_e  = $dt_soal[$img5];




	if ($kd_des == 0) {
		$cerita = $des;
	} else {
		$kd_crt		= mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM cbt_soal WHERE no_soal ='$kd_des' AND kd_soal ='$kds'"));
		$cerita = $kd_crt['cerita'];
	}

	// echo $nos;
	// echo $dt_soal['audio'];
	// echo $dt_soal['vid'];
	// echo $dt_soal['img'];
	// echo $dt_soal['tanya'];

	// echo $dt_soal['jwb1'];
	// echo $dt_soal['img1'];

	// echo $dt_soal['jwb2'];
	// echo $dt_soal['img2'];

	// echo $dt_soal['jwb3'];
	// echo $dt_soal['img3'];

	// echo $dt_soal['jwb4'];
	// echo $dt_soal['img4'];

	// echo $dt_soal['jwb5'];
	// echo $dt_soal['img5'];


?>

	<!-- === Media === -->
	<?php if (!empty($img or $audio or $vid)) { ?>
		<div class="row m-3 gap-2 text-center justify-content-around">

			<?php if (!empty($vid)) { ?>
				<div class="col-12">
					<video controls controlsList="nodownload" preload="none" class="media" src="video/<?php echo $vid ?>" class="object-fit-contain"></video>
				</div>
			<?php }
			if (!empty($audio)) { ?>
				<div class="col-12">
					<audio controls controlsList="nodownload" preload="none" class="">
						<source src="audio/<?php echo $audio ?>" type="audio/mpeg">
						<!-- <source src="audio/preman_pensiun_dj.mp3" type="audio/mpeg"> -->
						Browsermu tidak mendukung tag audio
					</audio>
				</div>
			<?php }
			if (!empty($img)) { ?>
				<div class="col-12">
					<button type="button" class="btn " data-bs-toggle="modal" data-bs-target="#zoom">
						<img src="<?php imgs('images', $img) ?>" alt="" srcset="" class="media" id="myImgt">
					</button>
				</div>
			<?php } ?>
		</div>
	<?php } ?>
	<!-- === Akhir Media === -->

	<!-- === Deskripsi Soal=== -->
	<?php if (!empty($des || $kd_des)) { ?>
		<div class="row m-3 justify-content-center border" style="border-top-left-radius: 7px;border-top-right-radius: 7px;">
			<div class="fs-5 col col-sm-9" id="des"><?php echo $cerita ?></div>
		</div>
		<!-- === Akhir Deskripsi Soal=== -->

		<!-- === Soal Pilihan Ganda === -->
	<?php }
	if ($dt_soal["jns_soal"] == "G") { ?>
		<div class="row m-3 justify-content-around">
			<h4 class="fw-semibold text-decoration-underline">Pilihan Ganda</h4>
			<div class="fs-5"><?php echo $tanya ?></div>
		</div>

		<!-- === Opsi Jawaban === -->
		<div class="row mx-md-5 mx-auto my-3 fs-5 gap-3">
			<div class="col-12">
				<div class="row justify-content-md-start justify-content-center">
					<div class="col-auto" id="tes"></div>
				</div>

			</div>
			<div class="row">
				<div class="col-auto">
					<input type="radio" class="btn-check" name="jwb" id="jwbA" value="A" autocomplete="off" <?php if ($jwbn == "A") {
																																																		echo "checked";
																																																	} ?>>
					<label class="btn btn-outline-dark fw-semibold text-start" for="jwbA">A</label>
				</div>
				<div class="col-auto"><?php echo $op_a ?></div>
				<?php if (!empty($img_a)) { ?>
					<div class="col-auto">
						<button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#zoom">
							<img src="<?php imgs('images', $img_a) ?>" alt="" srcset="" class="img-thumbnail" style="max-width: 240px;" id="myImgA">
					</div>
				<?php } ?>
			</div>
			<div class="row">
				<div class="col-auto">
					<input type="radio" class="btn-check" name="jwb" id="jwbB" value="B" autocomplete="off" <?php if ($jwbn == "B") {
																																																		echo "checked";
																																																	} ?>>
					<label class="btn btn-outline-dark fw-semibold col-auto text-start" for="jwbB">B</label>
				</div>
				<div class="col-auto"><?php echo $op_b ?></div>
				<?php if (!empty($img_b)) { ?>
					<div class="col-auto">
						<button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#zoom">
							<img src="<?php imgs('images', $img_b) ?>" alt="" srcset="" class="img-thumbnail" style="max-width: 240px;" id="myImgB">
					</div>
				<?php } ?>
			</div>
			<div class="row">
				<div class="col-auto">
					<input type="radio" class="btn-check" name="jwb" id="jwbC" value="C" autocomplete="off" <?php if ($jwbn == "C") {
																																																		echo "checked";
																																																	} ?>>
					<label class="btn btn-outline-dark fw-semibold col-auto text-start" for="jwbC">C</label>
				</div>
				<div class="col-auto"><?php echo $op_c ?></div>
				<?php if (!empty($img_c)) { ?>
					<div class="col-auto">
						<button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#zoom">
							<img src="<?php imgs('images', $img_c) ?>" alt="" srcset="" class="img-thumbnail" style="max-width: 240px;" id="myImgC">
					</div>
				<?php } ?>
			</div>
			<div class="row">
				<div class="col-auto">
					<input type="radio" class="btn-check" name="jwb" id="jwbD" value="D" autocomplete="off" <?php if ($jwbn == "D") {
																																																		echo "checked";
																																																	} ?>>
					<label class="btn btn-outline-dark fw-semibold col-auto text-start" for="jwbD">D</label>
				</div>
				<div class="col-auto"><?php echo $op_d ?></div>
				<?php if (!empty($img_d)) { ?>
					<div class="col-auto">
						<button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#zoom">
							<img src="<?php imgs('images', $img_d) ?>" alt="" srcset="" class="img-thumbnail" style="max-width: 240px;" id="myImgD">
					</div>
				<?php } ?>
			</div>
			<div class="row">
				<div class="col-auto">
					<input type="radio" class="btn-check" name="jwb" id="jwbE" value="E" autocomplete="off" <?php if ($jwbn == "E") {
																																																		echo "checked";
																																																	} ?>>
					<label class="btn btn-outline-dark fw-semibold col-auto text-start" for="jwbE">E</label>
				</div>
				<div class="col-auto"><?php echo $op_e ?></div>
				<?php if (!empty($img_e)) { ?>
					<div class="col-auto">
						<button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#zoom">
							<img src="<?php imgs('images', $img_e) ?>" alt="" srcset="" class="img-thumbnail" style="max-width: 240px;" id="myImgE">
					</div>
				<?php } ?>
			</div>
		</div>
		<!-- === Akhir Opsi Jawaban === -->
		<!-- === Akhir Soal Pilihan Ganda === -->

		<!-- === Soal Esai === -->
	<?php } else { ?>
		<div class="row m-3 justify-content-around">
			<h4 class="fw-semibold text-decoration-underline">Esai</h4>
			<div class="fs-5"><?php echo $tanya ?></div>
		</div>
		<!-- === Jawabn Esai === -->
		<div class="row mx-4 mb-3">
			<label for="jwb_esai" class="form-label">Jawaban</label>
			<textarea class="form-control" id="jwb_esai" name="jwb_esai" rows="3"></textarea>
		</div>
		</div>
		<!-- === Akhir Jawabn Esai === -->
		<!-- === Akhir Soal Esai === -->
<?php }
} else {
	echo "<div class='col text-center p-3 fs-4'>Soal Tidak di Temukan</div>";
} ?>


<!-- === Modal === -->
<div id="myModalimg" class="modal">
	<span class="close">&times;</span>
	<img class="modal-content" id="img01">
	<div id="caption"></div>
</div>




<script src="node_modules/jquery/dist/jquery.min.js"></script>
<!-- <script src="aset/ckeditor/build/ckeditor.js"></script> -->
<script>
	// === Images ===//
	// Get the modal
	var modal = document.getElementById("myModalimg");

	// Get the image and insert it inside the modal - use its "alt" text as a caption
	var img = document.getElementById("myImgt");
	var modalImg = document.getElementById("img01");
	var captionText = document.getElementById("caption");
	img.onclick = function() {
		modal.style.display = "block";
		modalImg.src = this.src;
		captionText.innerHTML = this.alt;
	}
</script>
<script>
	var modal = document.getElementById("myModalimg");

	var img = document.getElementById("myImgA");
	var modalImg = document.getElementById("img01");
	var captionText = document.getElementById("caption");
	img.onclick = function() {
		modal.style.display = "block";
		modalImg.src = this.src;
		captionText.innerHTML = this.alt;
	}
</script>
<script>
	var modal = document.getElementById("myModalimg");

	var img = document.getElementById("myImgB");
	var modalImg = document.getElementById("img01");
	var captionText = document.getElementById("caption");
	img.onclick = function() {
		modal.style.display = "block";
		modalImg.src = this.src;
		captionText.innerHTML = this.alt;
	}
</script>
<script>
	var modal = document.getElementById("myModalimg");

	var img = document.getElementById("myImgC");
	var modalImg = document.getElementById("img01");
	var captionText = document.getElementById("caption");
	img.onclick = function() {
		modal.style.display = "block";
		modalImg.src = this.src;
		captionText.innerHTML = this.alt;
	}
	var img = document.getElementById("myImgD");
	var modalImg = document.getElementById("img01");
	var captionText = document.getElementById("caption");
	img.onclick = function() {
		modal.style.display = "block";
		modalImg.src = this.src;
		captionText.innerHTML = this.alt;
	}
</script>
<script>
	var modal = document.getElementById("myModalimg");

	var img = document.getElementById("myImgE");
	var modalImg = document.getElementById("img01");
	var captionText = document.getElementById("caption");
	img.onclick = function() {
		modal.style.display = "block";
		modalImg.src = this.src;
		captionText.innerHTML = this.alt;
	}
</script>
<script>
	// Get the <span> element that closes the modal
	var span = document.getElementsByClassName("close")[0];

	// When the user clicks on <span> (x), close the modal
	span.onclick = function() {
		modal.style.display = "none";
	}
</script>
<script>
	// Simpan Jawaban
	$(document).ready(function() {
		$('input[type="radio"]').click(function() {
			var jwb = $(this).val();
			console.log(jwb);
			$.ajax({
				url: "soal_jwb.php?tkn=<?php echo $token ?>&kds=<?php echo $kds ?>&id=<?php echo $ids ?>&nj=<?php echo "" ?>",
				method: "POST",
				data: {
					opsi: jwb,
					nos: <?php echo $nos ?>
				},
				success: function(data) {
					$("#jb").html(data);
					document.getElementById("abc<?php echo $nos ?>").innerHTML = jwb;
					document.getElementById("ns<?php echo $nos ?>").classList.add("btn-secondary");
					document.getElementById("ns<?php echo $nos ?>").classList.remove("btn-outline-secondary");
				}
			})
		})
	})
</script>