<div class="row pb-2 border-bottom m-0 p-0">
	<div class="col-auto">
		<a href="?md=up_img" class="btn btn-primary">Upload Video</a>
	</div>
	<?php if ($dt_adm['lvl'] == "A") { ?>
		<div class="col-auto">
			<a href="?md=f_soal&fl=v&dl=all" class="btn btn-danger">Kosongkan Video</a>
		</div>
	<?php } ?>
</div>
<div class="row">
	<?php 
	$file = glob("../video/*.*");
	// foreach ($file as $f) {
	// 	if (is_file($f))
	// 		unlink($f); // hapus file
	// }

	if (!empty($_GET['dl'])) {
		$dl = $_GET['dl'];
		if ($dl == "all") {
			$file    = glob('../video/*');
			foreach ($file as $f) {
				if (is_file($f)) {
					unlink($f); // hapus file
					echo '<meta http-equiv="refresh" content="0;url=./?md=f_soal&fl=v">';
				}
			}
		} elseif (file_exists("../video/" . $dl)) {
			unlink("../video/" . $dl);
			echo '<meta http-equiv="refresh" content="0;url=./?md=f_soal&fl=v">';
		}
	}

	for ($i = 0; $i < count($file); $i++) {
		$video = $file[$i];
		// echo basename($image) . "<br />"; // show only image name if you want to show full path then use this code 
		// echo $image."<br />";

		if ($dt_adm['lvl'] == "A") { ?>
			<div class="col text-center position-relative">
				<a href="?md=f_soal&fl=v&dl=<?php echo basename($video) ?>" class="position-absolute top-0 end-0 link-dark p-0 badge fs-5">
					<i class="bi bi-x-circle"></i>
				</a>
				<div class="col border mt-2 p-1" style="border-radius: 15px;">
					<video controls style="max-width: 100%; max-height: 150px; object-fit: cover; border-radius: 10px;">
						<source src="<?php echo $video ?>" type="video/mp4">
						Your browser does not support the video element.
					</video>
				</div>
				<div class="fs-6 text-truncate" style="height: 50px;">
					<?php if (strlen(basename($video)) > 25) $cr = "...";
					else $cr = "";
					echo substr(basename($video), 0, 25) . $cr; ?>
				</div>
			</div>
	<?php }
	} ?>
</div>