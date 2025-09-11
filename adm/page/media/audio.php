<div class="row pb-2 border-bottom m-0 p-0">
	<div class="col-auto">
		<a href="?md=up_img" class="btn btn-primary">Upload Audio</a>
	</div>
	<?php if ($dt_adm['lvl'] == "A") { ?>
		<div class="col-auto">
			<a href="?md=f_soal&fl=a&dl=all" class="btn btn-danger">Kosongkan Audio</a>
		</div>
	<?php } ?>
</div>
<div class="row">
	<?php 
	$file = glob("../audio/*.*");
	// foreach ($file as $f) {
	// 	if (is_file($f))
	// 		unlink($f); // hapus file
	// }

	if (!empty($_GET['dl'])) {
		$dl = $_GET['dl'];
		if ($dl == "all") {
			$file    = glob('../audio/*');
			foreach ($file as $f) {
				if (is_file($f)) {
					unlink($f); // hapus file
					echo '<meta http-equiv="refresh" content="0;url=./?md=f_soal&fl=a">';
				}
			}
		} elseif (file_exists("../audio/" . $dl)) {
			unlink("../audio/" . $dl);
			echo '<meta http-equiv="refresh" content="0;url=./?md=f_soal&fl=a">';
		}
	}

	for ($i = 0; $i < count($file); $i++) {
		$audio = $file[$i];
		// echo basename($image) . "<br />"; // show only image name if you want to show full path then use this code 
		// echo $image."<br />";

		if ($dt_adm['lvl'] == "A") { ?>
			<div class="col text-center position-relative">
				<a href="?md=f_soal&fl=a&dl=<?php echo basename($audio) ?>" class="position-absolute top-0 end-0 link-dark p-0 badge fs-5">
					<i class="bi bi-x-circle"></i>
				</a>
				<div class="col border mt-2 p-1" style="border-radius: 15px;">
					<audio controls style="object-fit: cover; border-radius: 10px;">
						<source src="<?php echo $audio ?>" type="audio/mpeg">
						Your browser does not support the audio element.
					</audio>
				</div>
				<div class="fs-6 text-truncate" style="height: 50px;">
					<?php if (strlen(basename($audio)) > 25) $cr = "...";
					else $cr = "";
					echo substr(basename($audio), 0, 25) . $cr; ?>
				</div>
			</div>
	<?php }
	}
	?>
</div>