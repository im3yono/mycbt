<!DOCTYPE html>
<html lang="en">

<?php
session_start();

// if (!isset($_SESSION['login'])) {
//     header("Location: ../login.php");
//     exit;
// }
require_once "../config/server.php";
require_once "../config/time_date.php";

if ($db_null == 0 && $tbl_null == 0) {
	if (isset($_POST['logout'])) {
		setcookie('user', '', time() - 3600, '/');
		setcookie('pass', '', time() - 3600, '/');
		header("Location: ../login.php");
		exit();
	}
	// USER
	if ($db_null != 1) {
		if (empty($_COOKIE['user'] && $_COOKIE['pass'])) {
			header('location:/' . $fd_root . '/');
		} elseif (isset($_COOKIE['user']) && isset($_COOKIE['pass'])) {
			$user = $_COOKIE['user'];
			$pass = $_COOKIE['pass'];
			$dt_adm    = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM user WHERE username='$user' AND pass=md5('$pass') AND sts='Y';"));
			if (empty($dt_adm)) {
				header('location:/' . $fd_root . '/');
			}
		}
	} else {
		$dt_adm = array("nm_user" => "Admin");
	}

	if (!empty($db_select)) {
		$info   = mysqli_fetch_array(mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM info"));
	}

	// Rubah Status Ujian Terlewat tanggal
	$dt_jdwl = mysqli_query($koneksi, "SELECT * FROM jdwl");
	while ($data = mysqli_fetch_array($dt_jdwl)) {
		$jwl			= $data['tgl_uji'];
		$id_jwl 	= $data['id_ujian'];
		if ($jwl < date('Y-m-d')) {
			mysqli_query($koneksi, "UPDATE jdwl SET sts = 'H' WHERE id_ujian = '$id_jwl'");
		}
	}
}

?>

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?php echo $inf_nm ?></title>
	<link rel="shortcut icon" href="../img/<?php echo $inf_fav ?>" type="image/x-icon">

	<link rel="stylesheet" href="../vendor/twbs/bootstrap/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="../vendor/twbs/bootstrap-icons/font/bootstrap-icons.css">
	<script src="../vendor/twbs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

	<link rel="stylesheet" href="../aset/simple-datatables/style.css">
	<script type="text/javascript" src="../aset/simple-datatables/simple-datatables.js"></script>
	<link rel="stylesheet" href="style.css">
	<link rel="stylesheet" href="../aset/ckeditor5/ckeditor5.css">

	<script src="../node_modules/sweetalert2/dist/sweetalert2.min.js"></script>
	<link rel="stylesheet" href="../node_modules/sweetalert2/dist/sweetalert2.min.css">
	<script src="../node_modules/jquery/dist/jquery.min.js"></script>
	<script src="../aset/time.js"></script>

</head>

<style>
	.swal2-timer-progress-bar {
		background: greenyellow !important;
		height: 7px;
		border-radius: 7px;
	}
</style>



<body style="overflow-y: hidden;overflow-x: hidden;height: 100%;">
	<nav class="navbar navbar-expand-lg bg-dark flex-auto" style="font-family: Alkatra;">
		<div class="container-fluid text-center">
			<div class="col-auto">
				<button class="navbar-toggler bg-light-subtle fs-6" type="button" data-bs-toggle="offcanvas" data-bs-target="#mnitem" aria-expanded="true" aria-controls="collapseWidthExample">
					<span class="navbar-toggler-icon"></span>
				</button>
				<a class="navbar-brand text-white p-0 offcanvas-md" href="#">
					<img src="../img/bnr-mytbk.png" alt="Logo" height="35" class="d-inline-block align-text-top">
				</a>
			</div>
			<div class="">
					<span class="text-light fs-md-4 fs-5 mx-3" id="jam"></span>
				<?php if ($db_null == 0 && $tbl_null == 0) :
					$images = glob("./images/$_COOKIE[user].*");
					if (!empty($images)) {
						$ftp = $images[0];
					} else {
						$ftp = '../img/noavatar.png';
					}
				?>
					<button type="button" class="btn btn-dark dropdown-toggle p-0 m-0" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
						<img src="<?= $ftp; ?>" class="img-thumbnail rounded-circle" style="width: 30px;">
					</button>
					<ul class="dropdown-menu dropdown-menu-end dropdown-menu-start fs-6 me-1" style="z-index: 3000;">
						<li class="text-center"><img src="<?= $ftp; ?>" class="img-thumbnail rounded-circle" style="height: 70px;width: 70px;"></li>
						<li class="text-center"><?= $dt_adm['nm_user'] ?></li>
						<?php if ($dt_adm['lvl'] === "A") {
						?>
							<li><a href="?md=puser" class="dropdown-item"><i class="bi bi-person-lines-fill"></i> Profil</a></li>
							<?php if (get_ip() == "127.0.0.1") { ?>
								<li><a href="/phpmyadmin/" target="_blank" class="dropdown-item" rel="noopener noreferrer">Database</a></li>
						<?php }
						} ?>
						<li>
							<!-- <a class="dropdown-item" href="../logout.php"><i class="bi bi-box-arrow-left"></i> Keluar</a> -->
							<button class="dropdown-item" type="submit" id="logout" name="logout"><i class="bi bi-door-open"></i> Keluar</button>
						</li>
						<!-- <li><?php $fld = $_SERVER['SCRIPT_NAME'];
											$fld = explode('/', $fld);
											echo $fld[1]; ?></li> -->
					</ul>
				<?php endif; ?>
			</div>
		</div>
	</nav>

	<div class="container-fluid">
		<div class="row" style="background-color: #212529;">
			<!-- <div class="row m-1 p-1">nbnb</div> -->
			<?php if ($db_null == 0 && $tbl_null == 0) { ?>
				<div class="offcanvas-lg offcanvas-start bg-dark ofx ofx-md " id="mnitem" tabindex="-1" aria-labelledby="mnitemlbl">
					<div class="offcanvas-header">
						<img src="../img/bnr-mytbk.png" alt="Logo" height="40" class="d-inline-block align-text-top"><h5 class="text-white" id="mnitemlbl">
							IM'3
						</h5>
					</div>
					<div class="offcanvas-body">
						<div class="col pt-1 px-1 mnu m-0 fw-bolder position-fixed">
							<ul class="nav mnu-itm mnu-md-itm list-group bg-dark py-2 gap-1">
								<?php if (cek_aktif($d_exp, ">=")) { ?>
									<li class="nav-item">
										<a href="?" class="dsh list-group-item ">
											<i class="bi bi-house"></i> Dashboard
										</a>
									</li>
									<?php if ($dt_adm['lvl'] == "A") { ?>
										<li class="nav-item" id="mn_sync" <?= ($server_ms['lev_svr'] == "C") ? 'style="display: none;"' : ''; ?>>
											<a href="?md=sync" class="list-group-item sync">
												<i class="bi bi-arrow-down-up"></i> Sinkronisasi
											</a>
										</li>
										<li class="nav-item ">
											<a class=" list-group-item " data-bs-toggle="collapse" href="#pf">
												<div class="row ps-2">&nbsp;Profil<div class="col text-end"><i class="bi bi-chevron-down"></i></div>
												</div>
											</a>
											<div class="collapse ps-3" id="pf">
												<ul class="nav list-group bg-dark gap-1 pt-1">
													<li class="nav-item">
														<a href="?md=id" class="iden list-group-item ">
															<i class="bi bi-info-circle"></i> Identitas
														</a>
													</li>
													<?php if ($_COOKIE['user'] == "admin") { ?>
														<li class="nav-item">
															<a href="?md=usr" class="usr list-group-item ">
																<i class="bi bi-people"></i> Managemen User
															</a>
														</li>
												<?php }
												} ?>
												<li class="nav-item">
													<a href="?md=puser" class="puser list-group-item ">
														<i class="bi bi-person"></i> Profil User
													</a>
												</li>
												<?php if ($dt_adm['lvl'] == "A") { ?>
												</ul>
											</div>
										</li>
										<li class="nav-item ">
											<a class=" list-group-item " data-bs-toggle="collapse" href="#adm">
												<div class="row ps-2">&nbsp;Administrasi <div class="col text-end"><i class="bi bi-chevron-down"></i></div>
												</div>
											</a>
											<div class="collapse ps-3" id="adm">
												<ul class="nav list-group bg-dark gap-1 pt-1">
													<li class="nav-item">
														<a href="?md=kls" class="kls list-group-item">
															<i class="bi bi-list-task"></i> Data Kelas
														</a>
													</li>
													<li class="nav-item">
														<a href="?md=sis" class="sis list-group-item ">
															<i class="bi bi-person-lines-fill"></i> Data Peserta
														</a>
													</li>
													<li class="nav-item">
														<a href="?md=mpl" class="mapel list-group-item ">
															<i class="bi bi-journals"></i> Data Matpel
														</a>
													</li>
												</ul>
											</div>
										</li>
									<?php }
												if ($dt_adm['lvl'] == "A" || $dt_adm['lvl'] == "U") { ?>
										<li class="nav-item ">
											<a class=" list-group-item " data-bs-toggle="collapse" href="#pr">
												<div class="row ps-2">&nbsp;Perlengkapan <div class="col text-end"><i class="bi bi-chevron-down"></i></div>
												</div>
											</a>
											<div class="collapse ps-3" id="pr">
												<ul class="nav list-group bg-dark gap-1 pt-1">
													<li class="nav-item">
														<a href="?md=pr_kartu" class="kartu list-group-item ">
															<i class="bi bi-person-vcard"></i> Kartu Login
														</a>
													</li>
													<li class="nav-item">
														<a href="?md=pr_hadir" class="hadir list-group-item ">
															<i class="bi bi-printer"></i> Daftar Hadir
														</a>
													</li>
												<?php }
												if ($dt_adm['lvl'] == "A" || $dt_adm['lvl'] == "X") { ?>
													<li class="nav-item">
														<a href="?md=pr_brita" class="berita list-group-item ">
															<i class="bi bi-printer"></i> Berita Acara
														</a>
													</li>
												<?php }
												if ($dt_adm['lvl'] == "A" || $dt_adm['lvl'] == "U") { ?>
												</ul>
											</div>
										</li>
										<li class="nav-item ">
											<a class=" list-group-item " data-bs-toggle="collapse" href="#ps">
												<div class="row ps-2">&nbsp;Paket Soal <div class="col text-end"><i class="bi bi-chevron-down"></i></div>
												</div>
											</a>
											<div class="collapse ps-3" id="ps">
												<ul class="nav list-group bg-dark gap-1 pt-1">
													<li class="nav-item">
														<a href="?md=soal" class="soal list-group-item ">
															<i class="bi bi-journal-text"></i> Bank Soal
														</a>
													</li>
													<li class="nav-item">
														<a href="?md=f_soal" class="f_soal list-group-item ">
															<i class="bi bi-file-earmark-arrow-up"></i> File Pendukung
														</a>
													</li>
												</ul>
											</div>
										</li>
									<?php }
												if ($dt_adm['lvl'] == "A") { ?>
										<li class="nav-item ">
											<a class=" list-group-item " data-bs-toggle="collapse" href="#uj">
												<div class="row ps-2">&nbsp;Ujian <div class="col text-end"><i class="bi bi-chevron-down"></i></div>
												</div>
											</a>
											<div class="collapse ps-3" id="uj">
												<ul class="nav list-group bg-dark gap-1 pt-1">
													<li class="nav-item">
														<a href="?md=uj_set" class="setuj list-group-item ">
															<i class="bi bi-clipboard2-check"></i> Aktivasi Ujian
														</a>
													</li>
													<li class="nav-item">
														<a href="?md=uj_jdwl" class="jdwluj list-group-item ">
															<i class="bi bi-calendar2-range"></i> Jadwal Ujian
														</a>
													</li>
													<li class="nav-item">
														<a href="?md=uj_rwyt" class="rwytuj list-group-item ">
															<i class="bi bi-clock-history"></i> Riwayat Ujian
														</a>
													</li>
												</ul>
											</div>
										</li>
										<li class="nav-item">
											<a href="?md=df_uji" class="dfuji list-group-item">
												<i class="bi bi-person-vcard"></i> Daftar Ujian
											</a>
										</li>
									<?php }
												if ($dt_adm['lvl'] == "A" ||  $dt_adm['lvl'] == "X") { ?>
										<li class="nav-item">
											<a href="?md=dfps_uji" class="dfsis list-group-item ">
												<i class="bi bi-people-fill"></i> Daftar Peserta
											</a>
										</li>
										<li class="nav-item">
											<a href="?md=rst_uji" class="rstuji list-group-item ">
												<i class="bi bi-person-fill-exclamation"></i> Reset Peserta
											</a>
										</li>
									<?php }
												if ($dt_adm['lvl'] == "A" ||  $dt_adm['lvl'] == "U") { ?>
										<li class="nav-item ">
											<a class=" list-group-item " data-bs-toggle="collapse" href="#hasil">
												<div class="row ps-2">&nbsp;Hasil <div class="col text-end"><i class="bi bi-chevron-down"></i></div>
												</div>
											</a>
											<div class="collapse ps-3" id="hasil">
												<ul class="nav list-group bg-dark gap-1 pt-1">
													<li class="nav-item">
														<a href="?md=anls" class="anls list-group-item ">
															<i class="bi bi-list-columns-reverse"></i> Analisa
														</a>
													</li>
													<li class="nav-item">
														<a href="?md=nilai" class="nilai list-group-item ">
															<i class="bi bi-123"></i> Nilai
														</a>
													</li>

													<!-- <li class="nav-item" id="mn_uphs" <?= ($server_ms['lev_svr'] == "M") ? 'style="display: none;"' : ''; ?>>
													<a href="?md=up_hasil" class="up_hasil list-group-item ">
														<i class="bi bi-upload"></i> Upload Hasil
													</a>
												</li> -->
												</ul>
											</div>
										</li>
									<?php }
											}
											if ($dt_adm['lvl'] == "A") { ?>
									<li class="nav-item">
										<a href="?md=setting" class="sett list-group-item ">
											Pengaturan
										</a>
									</li>
								<?php } ?>
							</ul>
						</div>
					</div>
				</div>
			<?php } ?>
			<div class="col p-auto m-auto pos bg-white cl-wp">
				<!-- <iframe src="page/md.php" frameborder="0" width="100%" height="100%"></iframe> -->

				<div id="loadingSpinner" class="spinner-container" style="margin-bottom: -5vh;">
					<div id="loadingSpinner" class="spinner-border" role="status" style="width: 3rem; height: 3rem;">
						<span class="visually-hidden">Loading...</span>
					</div>
				</div>

				<div class="ps-wp" id="warper">
					<?php
					// No Database
					if ($db_null == 1 || $tbl_null == 1) {
						require_once "../adm/page/setting.php";
					} elseif (cek_aktif($d_exp, "<")) {
						include_once("page/setting.php");
					} else {
						include_once("page/md.php");
					} ?>
				</div>
			</div>
		</div>
	</div>
	<!-- <footer class="bg-dark p-1 footer" style="position: fixed;">
    <div class="text-white"><?php include_once("../config/about.php") ?></div>
  </footer> -->
</body>

</html>



<!-- === JavaScript === -->
<!-- <script src="../aset/ckeditor/build/ckeditor.js"></script> -->
<script>
	document.addEventListener("DOMContentLoaded", function() {
		// Tampilkan spinner
		document.getElementById("loadingSpinner").style.display = "flex";

		// Sembunyikan spinner dan tampilkan tabel setelah loading selesai
		setTimeout(function() {
			document.getElementById("loadingSpinner").style.display = "none";
			document.getElementById("warper").style.display = "block";
		}, 300);

		// // Inisialisasi Simple-DataTables pada tabel
		// var dataTable = new simpleDatatables.DataTable("#jsdata", {
		// 	perPageSelect: [5, 10, 25, 50, 'All'],
		// 	perPage: 5,
		// 	labels: {
		// 		placeholder: "Cari...",
		// 		perPage: " Data per halaman",
		// 		noRows: "Tidak ada data yang ditemukan",
		// 		info: "Menampilkan {start}/{end} dari {rows} Data",
		// 	}
		// });
	});
</script>
<script>
	$(document).ready(function() {
		$("#logout").click(function() {
			window.location = ('../logout.php?fld=<?php echo $fd_root; ?>');
		})
	})
</script>