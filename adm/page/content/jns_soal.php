<?php
require_once '../../../config/server.php';

$jns_opsi = $_POST['jnss'];

	// <!-- Pilihan Ganda -->
if ($jns_opsi == 'G') { ?>
	<div class="row m-2 border border-info" style="border-radius: 5px;" id="opjw">
		<div class="col-12 bg-info p-2">Opsi Jawaban</div>
		<?php for ($i = 1; $i <= 5; $i++) { ?>
			<div class="col-12 p-2" style="border-radius: 3px;">
				<div class="border border-info-subtle" style="border-radius: 5px;">
					<div class="row m-0 bg-info-subtle p-2 justify-content-center justify-content-md-start">
						<div class="col-auto">Jawaban <?= $i ?></div>
						<div class="col-auto form-check form-switch">
							<input type="radio" class="form-check-input" role="switch" name="keyopsi" required>
						</div>
					</div>
					<div class="row gap-3 p-3 justify-content-center">
						<div class="col-md-2 col-auto text-center">
							<input class="form-control form-control-sm" id="imgjw<?= $i ?>" name="imgjw<?= $i ?>" type="file" accept=".jpg,.jpeg,.png" hidden>
							<label for="imgjw<?= $i ?>" style="cursor: pointer;">
								<img src="<?php echo empty($dts["img$i"]) ? '../img/img.png' : '../images/' . $dts["img$i"]; ?>" id="img<?= $i ?>" class="card-img-top img-fluid" alt="..." style="height: 7rem;">
							</label>
							<input type="text" class="form-control form-control-sm text-center m-1" name="img<?= $i ?>jw" id="img<?= $i ?>jw" readonly onfocus="clearInput(this)">
						</div>
						<div class="col-md-9 col">
							<textarea name="opsi<?= $i ?>" id="opsi<?= $i ?>"></textarea>
							<div class="word-count" id="cr_opsi<?= $i ?>"></div>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>
	</div>
<?php
}

	// <!-- Menjodohkan -->
if ($jns_opsi == 'J') { ?>
	<div class="row m-2 border border-info" style="border-radius: 5px;" id="jdh">
		<div class="col-12 bg-info p-2">Opsi Menjodohkan</div>
		<div class="col-12 p-2" style="border-radius: 3px;">
			<div class="row m-0 bg-info-subtle p-2 justify-conten-center justify-content-md-start">Opsi 1</div>
			<div class="row gap-3 p-3 justify-content-center">
				<div class="col-md-2 col-auto text-center">
					<input class="form-control form-control-sm" id="imgjw1" name="imgjw1" type="file" accept=".jpg,.jpeg,.png" hidden>
					<label for="imgjw1" style="cursor: pointer;">
						<img src="<?php echo empty($dts["img1"]) ? '../img/img.png' : '../images/' . $dts["img1"]; ?>" id="img1" class="card-img-top img-fluid" alt="..." style="height: 7rem;">
					</label>
					<input type="text" class="form-control form-control-sm text-center m-1" name="img1jw" id="img1jw" readonly onfocus="clearInput(this)">
				</div>
				<div class="col-md-4 col">1</div>
				<div class="col-md-4 col">2</div>
			</div>
		</div>
	</div>
<?php
}

// <!-- Benar/Salah -->
if ($jns_opsi == 'X') { ?>
	<div class="row m-2 border border-info" style="border-radius: 5px;" id="bas">
		<div class="col-12 bg-info p-2">Opsi Benar/Salah</div>
		<div class="col-12 p-2" style="border-radius: 3px;">
			<div class="row m-0 bg-info-subtle p-2 justify-conten-center justify-content-md-start">Opsi 1</div>
			<div class="row gap-3 p-3 justify-content-center">
				<div class="col-md-4 col">Benar</div>
				<div class="col-md-4 col">Salah</div>
			</div>
		</div>
	</div>
<?php
}
if ($jns_opsi == 'E') {
	# code...
}

?>
	<!-- JavaScript -->
	<script type="importmap">
		{
			"imports": {
				"ckeditor5": "../../../aset/ckeditor5/ckeditor5.js",
				"ckeditor5/": "../../../aset/ckeditor5/"
			}
		}
		</script>
	<script type="module" src="../../../aset/ckeditor5/ckeditor5.js"></script>
	<script type="module" src="../../../aset/main_ck5.js"></script>
	<script type="text/javascript" src="../../../node_modules/jquery/dist/jquery.min.js"></script>