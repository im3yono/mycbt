<?php
include_once("../../config/server.php");
error_reporting(0); //hide error


?>
<html>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="shortcut icon" href="../../img/fav.png" type="image/x-icon">
<link rel="stylesheet" href="../../vendor/twbs/bootstrap/dist/css/bootstrap.min.css">
<script src="../../vendor/twbs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<?php if ($_POST['page'] == "") { ?>
	<link rel="stylesheet" href="page.css">
<?php } else if ($_POST['page'] == "1") { ?>
	<link rel="stylesheet" href="page.css">
<?php } else if ($_POST['page'] == "2") { ?>
	<link rel="stylesheet" href="page-f4.css">
<?php } ?>
<style>
	p {
		line-height: 16px;
	}

	.pb2 {
		border-bottom-style: double;
	}

	.pgh {
		line-height: 16px;
	}

	.pgs {
		line-height: 34px;
	}

	.page {
		max-height: 330mm;
		margin-bottom: 10mm;
	}

	.brd {
		width: 9.7cm;
		height: 6.8cm;
	}

	.dt {
		font-size: 15px;
		font-family: 'Times New Roman', Times, serif;
	}

	.ttd {
		font-size: 13px;
		font-family: 'Times New Roman', Times, serif;
	}

	tr td {
		padding: 0;
		padding-left: 5px;

	}

	tr td img {
		width: 65px;
		height: 85px;
		padding: 5px;
		border-image: auto;
	}

	.img-ttd {
		position: absolute;
		margin-left: 45px;
		width: auto;
		height: 78px;
	}

	td {
		vertical-align: top;
	}

	.qr {
		width: 80px;
		height: 80px;
	}

	/* @media print {
		.page {
			margin-left: -135px;
			margin-right: -140px;
		}
	} */

	/* table,th,td {
		border: 1px solid black;
		border-collapse: collapse;
	} */
</style>

<body>
	<div class="container pb-2">
		<?php
		$batas = 8;
		$ttd = $_POST['ttd'];
		$kls = $_POST['kls'];
		$crnm = $_POST['crnm'];

		if (empty($ttd)) {
			$ttd = 0;
		}
		if ($kls == "" && $crnm == "") {
			// echo "kosong - lev=" .$levc." kls=".$klsc." jur=".$jurc;
			$cr = "";
		} elseif ($kls == "1" && $crnm == "") {
			// echo "kosong - lev=" .$levc." kls=".$klsc." jur=".$jurc;
			$cr = "";
		} elseif ($kls != "" && $crnm == "") {
			// echo "WHERE " .$levc." ".$klsc." ".$jurc;
			$cr = "WHERE  kd_kls = '" . $kls . "' ";
		}
		if ($kls == "1" && $crnm != "") {
			// echo "kosong - lev=" .$levc." kls=".$klsc." jur=".$jurc;
			$cr = " WHERE nm LIKE '%" . $crnm . "%'";
		} elseif ($kls != "" && $crnm != "") {
			// echo "WHERE " .$levc." ".$klsc." ".$jurc;
			$cr = "WHERE kd_kls = '" . $kls . "' AND nm = '" . $crnm . "' ";
		}
		// echo $cr;
		$jml = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM cbt_peserta $cr"));
		$jmlpg = ceil($jml / $batas);
		for ($i = 0; $i < $jmlpg; $i++) {
			$page = $i * $batas;
			$qrs = mysqli_query($koneksi, "SELECT * FROM cbt_peserta $cr  limit $page,$batas");
			// $qrs = mysqli_query($koneksi, "SELECT * FROM cbt_peserta limit $page,$batas");
		?>
			<div class="page">
				<!-- Body -->
				<div class="isi">
					<div class="row g-3">
						<?php
						while ($dt = mysqli_fetch_array($qrs)) {
						?>
							
						<?php } ?>
					</div>
				</div>
				<!-- Akhir Body -->
			</div>
		<?php } ?>
	</div>
</body>

</html>