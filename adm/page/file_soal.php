<?php

?>

<style>
	#ps {
		display: flex;
	}

	.f_soal {
		background-color: aqua;
	}
</style>
<?php 
$cek_mpel =mysqli_query($koneksi,"SELECT *FROM mapel");
if (!empty(mysqli_num_rows($cek_mpel))) {
?>
<div class="container-fluid mb-5 p-0">
	<div class="row p-2 border-bottom fs-3 mb-4 shadow-sm ">Daftar File Pendukung Soal</div>
	<div class="row p-2 justify-content-center">
		<ul class="nav nav-tabs">
			<li class="nav-item">
				<a class="nav-link <?php if(empty($_GET['fl']))echo "active" ?>" href="?md=f_soal">Gambar <i class="text-danger"><?php $photos = glob('../images/*'); if(!empty(count($photos))) echo count($photos); ?></i></a>
			</li>
			<li class="nav-item">
				<a class="nav-link <?php if(!empty($_GET['fl'])){if($_GET['fl']=="a")echo "active";} ?>" href="?md=f_soal&fl=a">Audio</a>
			</li>
			<li class="nav-item">
				<a class="nav-link <?php if(!empty($_GET['fl'])){if($_GET['fl']=="v")echo "active";} ?>" href="?md=f_soal&fl=v">Video</a>
			</li>
			<li class="nav-item">
				<a class="nav-link disabled">PDF</a>
			</li>
		</ul>
		<div class="row p-2 mt-0 border border-top-0 gap-2 justify-content-start" style="border-bottom-left-radius: 7px; border-bottom-right-radius: 7px;">
				<?php 
				if (isset($_REQUEST['fl'])=="") {
					include_once("media/images.php");
				}elseif ($_REQUEST['fl']=="a"){
					include_once("media/audio.php");
				}elseif ($_REQUEST['fl']=="v"){
					include_once("media/video.php");
				}
				?>
		</div>
	</div>
</div>
<?php } else { ?>
	<div class="container-fluid">
		<div class="row m-5">
			<div class="col-12 text-center">
				<h4>Halaman Ini akan tampil apabila data <u>Mata Pelajaran</u> sudah terisi</h4>
			</div>
		</div>
	</div>
<?php } ?>

<script>

</script>