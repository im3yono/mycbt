<div class="row pb-2 border-bottom m-0 p-0">
	<div class="col-auto">
		<a href="?md=up_img" class="btn btn-primary">Upload Gambar</a>
	</div>
	<?php if ($dt_adm['lvl'] == "A") { ?>
		<div class="col-auto">
			<a href="?md=f_soal&dl=all" class="btn btn-danger">Kosongkan Gambar</a>
		</div>
	<?php } ?>
</div>
<div class="row gap-2 m-0 p-0 justify-content-evenly">
	<?php
	$files = glob("../images/*.*");
	// foreach ($files as $file) {
	// 	if (is_file($file))
	// 		unlink($file); // hapus file
	// }

	if (!empty($_GET['dl'])) {
		$dl = $_GET['dl'];
		if ($dl == "all") {
			$files    = glob('../images/*');
			foreach ($files as $file) {
				if (is_file($file)) {
					unlink($file); // hapus file
					echo '<meta http-equiv="refresh" content="0;url=./?md=f_soal">';
				}
			}
		} elseif (file_exists("../images/" . $dl)) {
			unlink("../images/" . $dl);
			echo '<meta http-equiv="refresh" content="0;url=./?md=f_soal">';
		}
	}

	for ($i = 0; $i < count($files); $i++) {
		$image = $files[$i];
		// echo basename($image) . "<br />"; // show only image name if you want to show full path then use this code 
		// echo $image."<br />";

		if ($dt_adm['lvl'] == "A") { ?>
			<div class="col text-center position-relative" style="width: 180px; height: 200px;">
				<a href="?md=f_soal&dl=<?php echo basename($image) ?>" class="position-absolute top-0 end-0 link-dark p-0 badge fs-5">
					<i class="bi bi-x-circle"></i>
				</a>
				<div class="col border mt-2 p-1" style="min-height: 85%;border-radius: 15px;">
					<img src="<?php echo $image ?>" alt="Random image" style="max-width: 100%; max-height: 150px; object-fit: cover; border-radius: 10px;" />
				</div>
				<div class="fs-6 text-truncate" style="height: 50px;">
					<?php if (strlen(basename($image)) > 25) $cr = "...";
					else $cr = "";
					echo substr(basename($image), 0, 25) . $cr; ?>
				</div>
			</div>
	<?php }
	} ?>
</div>