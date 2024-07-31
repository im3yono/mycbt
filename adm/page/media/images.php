<div class="row pb-2 border-bottom m-0 p-0">
	<div class="col-auto">
		<a href="?md=up_img" class="btn btn-primary">Upload Gambar</a>
	</div>
	<div class="col-auto">
		<a href="?md=f_soal&dl=all" class="btn btn-danger">Kosongkan Gambar</a>
	</div>
</div>
<div class="row gap-2 m-0 p-0 justify-content-start">
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
	?>
		<div class="col border text-center position-relative" style="border-radius: 15px; max-width: 30%;">
			<a href="?md=f_soal&dl=<?php echo basename($image) ?>" class="position-absolute top-0 end-0 link-dark p-0 badge fs-5">
				<i class="bi bi-x-circle"></i>
			</a>
			<img src="<?php echo  $image ?>" alt="Random image" width="130" />
			<br><?php echo basename(substr($image,0,25)."...") ?>
		</div>
	<?php } ?>
</div>