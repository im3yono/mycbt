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

if ($db_null != 1) {
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
		$jwl      = $data['tgl_uji'];
		$id_jwl   = $data['id_ujian'];
		if ($jwl < date('Y-m-d')) {
			mysqli_query($koneksi, "UPDATE jdwl SET sts = 'H' WHERE id_ujian = '$id_jwl'");
		}
	}
}

?>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?php echo $inf_nm ?></title>
	<link rel="shortcut icon" href="../img/<?php echo $inf_fav ?>" type="image/x-icon">
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta name="title" content="<?php echo $inf_nm ?>" />
	<meta name="author" content="ColorlibHQ" />
	<meta name="description" content="AdminLTE is a Free Bootstrap 5 Admin Dashboard, 30 example pages using Vanilla JS." />
	<meta
		name="keywords"
		content="bootstrap 5, bootstrap, bootstrap 5 admin dashboard, bootstrap 5 dashboard, bootstrap 5 charts, bootstrap 5 calendar, bootstrap 5 datepicker, bootstrap 5 tables, bootstrap 5 datatable, vanilla js datatable, colorlibhq, colorlibhq dashboard, colorlibhq admin dashboard" />
	<link rel="stylesheet" href="adminlte.css" />
	<link rel="stylesheet" href="overlayscrollbars.min.css" />
	<!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous" />
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" integrity="sha256-9kPW/n5nn53j4WMRYAxe9c1rCY96Oogo/MKSVdKzPmI=" crossorigin="anonymous" /> -->


	<link rel="stylesheet" href="../vendor/twbs/bootstrap/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="../vendor/twbs/bootstrap-icons/font/bootstrap-icons.css">
	<script src="../vendor/twbs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

	<link rel="stylesheet" href="../aset/simple-datatables/style.css">
	<script type="text/javascript" src="../aset/simple-datatables/simple-datatables.js"></script>
	<!-- <link rel="stylesheet" href="style.css"> -->
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

	/* CSS untuk loading spinner */
	.spinner-container {
		display: flex;
		justify-content: center;
		align-items: center;
		height: 100vh;
		margin-top: -27vh;
	}

	/* Sembunyikan form secara default */
	#warper {
		display: none;
	}
</style>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
	<div class="app-wrapper">
		<nav class="app-header navbar navbar-expand bg-body sticky-top">
			<!--begin::Container-->
			<div class="container-fluid">
				<!--begin::Start Navbar Links-->
				<ul class="navbar-nav">
					<li class="nav-item">
						<a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
							<i class="bi bi-list"></i>
						</a>
					</li>
					<li class="nav-item d-none d-md-block fw-semibold"><a href="#" class="nav-link"><?php echo $inf_nm ?></a></li>
				</ul>
				<!--end::Start Navbar Links-->
				<!--begin::End Navbar Links-->
				<ul class="navbar-nav ms-auto">
					<li class="nav-item"><span class=" fs-md-4 fs-5 mx-3" id="jam"></span></li>
					<!--begin::Fullscreen Toggle-->
					<li class="nav-item">
						<a class="nav-link" href="#" data-lte-toggle="fullscreen">
							<i data-lte-icon="maximize" class="bi bi-arrows-fullscreen"></i>
							<i data-lte-icon="minimize" class="bi bi-fullscreen-exit" style="display: none"></i>
						</a>
					</li>
					<!--end::Fullscreen Toggle-->
					<!--begin::User Menu Dropdown-->
					<li class="nav-item dropdown user-menu">
						<?php
						// if ($db_null != 1) {
						$images = glob("./images/$_COOKIE[user].*");
						if (!empty($images)) {
							$ftp = $images[0];
						} else {
							$ftp = '../img/noavatar.png';
						}
						?>
						<button type="button" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
							<img src="<?= $ftp; ?>" class="user-image rounded-circle shadow" alt="User Image" />
							<span class="d-none d-md-inline"><?= $dt_adm['nm_user'] ?></span>
						</button>
						<ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
							<!--begin::User Image-->
							<li class="user-header text-bg-primary">
								<img src="<?= $ftp; ?>" class="rounded-circle shadow" alt="User Image" />
								<p>
									<?= $dt_adm['nm_user'] ?>
									<!-- <small>Member since Nov. 2023</small> -->
								</p>
							</li>
							<!--end::User Image-->
							<!--begin::Menu Body-->
							<li class="user-body">
								<!--begin::Row-->
								<div class="row">
									<?php if (get_ip() == "127.0.0.1") { ?>
										<div class="col-4 text-center"><a href="/phpmyadmin/">Database</a></div>
									<?php } ?>
									<div class="col-4 text-center"><a href="?md=puser">Profil</a></div>
									<div class="col-4 text-center"><a href="../logout.php?fld=<?php echo $fd_root; ?>"><i class="bi bi-door-open"></i> Keluar</a></div>
								</div>
								<!--end::Row-->
							</li>
							<!--end::Menu Body-->
							<!--begin::Menu Footer-->
							<!-- <li class="user-footer">
								<a href="#" class="btn btn-default btn-flat">Profile</a>
								<a href="#" class="btn btn-default btn-flat float-end">Sign out</a>
							</li> -->
							<!--end::Menu Footer-->
						</ul>
					</li>
					<!--end::User Menu Dropdown-->
				</ul>
				<!--end::End Navbar Links-->
			</div>
			<!--end::Container-->
		</nav>
		<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
			<!--begin::Sidebar Brand-->
			<div class="sidebar-brand">
				<!--begin::Brand Link-->
				<a href="?" class="brand-link">
					<!--begin::Brand Image-->
					<img src="../img/<?php echo $inf_fav ?>" alt="Logo" class="brand-image" />
					<!--end::Brand Image-->
					<!--begin::Brand Text-->
					<span class="brand-text fw-light">IM3_MyTBK</span>
					<!--end::Brand Text-->
				</a>
				<!--end::Brand Link-->
			</div>
			<!--end::Sidebar Brand-->
			<!--begin::Sidebar Wrapper-->
			<div class="sidebar-wrapper">
				<nav class="mt-2">
					<!--begin::Sidebar Menu-->
					<ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
						<li class="nav-item">
							<a href="?" class="nav-link ">
								<i class="nav-icon bi bi-speedometer"></i>
								<p>
									Dashboard
									<!-- <i class="nav-arrow bi bi-chevron-right"></i> -->
								</p>
							</a>
							<!-- <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="./index.html" class="nav-link active">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Dashboard v1</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="./index2.html" class="nav-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Dashboard v2</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="./index3.html" class="nav-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Dashboard v3</p>
                    </a>
                  </li>
                </ul> -->
						</li>
						<li class="nav-item">
							<a href="?md=sync" class="nav-link">
								<i class="nav-icon bi bi-arrow-down-up"></i>
								<p>Sinkronisasi</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="?md=id" class="nav-link">
								<i class="nav-icon bi bi-house-door"></i>
								<p>Identitas</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="#" class="nav-link">
								<i class="nav-icon bi bi-list-task"></i>
								<p>
									Administrasi
									<i class="nav-arrow bi bi-chevron-right"></i>
								</p>
							</a>
							<ul class="nav nav-treeview">
								<li class="nav-item">
									<a href="?md=kls" class="nav-link">
										<i class="nav-icon bi bi-grid"></i>
										<p>Kelas</p>
									</a>
								</li>
								<li class="nav-item">
									<a href="?md=sis" class="nav-link">
										<i class="nav-icon bi bi-person-lines-fill"></i>
										<p>Peserta</p>
									</a>
								</li>
								<li class="nav-item">
									<a href="?md=mpl" class="nav-link">
										<i class="nav-icon bi bi-journal"></i>
										<p>Mata Pelajaran</p>
									</a>
								</li>
							</ul>
						</li>
						<li class="nav-item">
							<a href="#" class="nav-link">
								<i class="nav-icon bi bi-list-check"></i>
								<p>
									Perlengkapan
									<!-- <span class="nav-badge badge text-bg-secondary me-3">6</span> -->
									<i class="nav-arrow bi bi-chevron-right"></i>
								</p>
							</a>
							<ul class="nav nav-treeview">
								<li class="nav-item">
									<a href="?md=pr_kartu" class="nav-link">
										<i class="nav-icon bi bi-person-vcard"></i>
										<p>Kartu Login</p>
									</a>
								</li>
								<li class="nav-item">
									<a href="?md=pr_hadir" class="nav-link">
										<i class="nav-icon bi bi-printer"></i>
										<p>Daftar Hadir</p>
									</a>
								</li>
								<li class="nav-item">
									<a href="?md=pr_brita" class="nav-link">
										<i class="nav-icon bi bi-printer"></i>
										<p>Berita Acara</p>
									</a>
								</li>
							</ul>
						</li>
						<li class="nav-item">
							<a href="#" class="nav-link">
								<i class="nav-icon bi bi-list-ul"></i>
								<p>
									Paket Soal
									<i class="nav-arrow bi bi-chevron-right"></i>
								</p>
							</a>
							<ul class="nav nav-treeview">
								<li class="nav-item">
									<a href="?md=soal" class="nav-link">
										<i class="nav-icon bi bi-journal-text"></i>
										<p>Bank Soal</p>
									</a>
								</li>
								<li class="nav-item">
									<a href="?md=f_soal" class="nav-link">
										<i class="nav-icon bi bi-files"></i>
										<p>File Pendukung</p>
									</a>
								</li>
							</ul>
						</li>
						<li class="nav-item">
							<a href="#" class="nav-link">
								<i class="nav-icon bi bi-pencil-square"></i>
								<p>
									Pelaksanaan Ujian
									<i class="nav-arrow bi bi-chevron-right"></i>
								</p>
							</a>
							<ul class="nav nav-treeview">
								<li class="nav-item">
									<a href="?md=uj_set" class="nav-link">
										<i class="nav-icon bi bi-circle"></i>
										<p>Aktivasi</p>
									</a>
								</li>
								<li class="nav-item">
									<a href="?md=uj_jdwl" class="nav-link">
										<i class="nav-icon bi bi-circle"></i>
										<p>Jadwal</p>
									</a>
								</li>
								<li class="nav-item">
									<a href="?md=uj_rwyt" class="nav-link">
										<i class="nav-icon bi bi-circle"></i>
										<p>Riwayat</p>
									</a>
								</li>
							</ul>
						</li>
						<li class="nav-item">
							<a href="?md=df_uji" class="nav-link">
								<i class="nav-icon bi bi-person-workspace"></i>
								<p>
									Daftar Uji Aktif
								</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="?md=dfps_uji" class="nav-link">
								<i class="nav-icon bi bi-people"></i>
								<p>
									Daftar Peserta
								</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="?md=rst_uji" class="nav-link">
								<i class="nav-icon bi bi-person-fill-exclamation"></i>
								<p>
									Request Reset
								</p>
							</a>
						</li>
						<li class="nav-header">CETAK HASIL</li>
						<li class="nav-item">
							<a href="?md=anls" class="nav-link">
								<i class="nav-icon bi bi-list-columns-reverse"></i>
								<p>
									Analisa
								</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="?md=nilai" class="nav-link">
								<i class="nav-icon bi bi-123"></i>
								<p>
									Nilai
								</p>
							</a>
						</li>
						<!-- <li class="nav-header">PENGATURAN</li> -->
						<li class="nav-header">------------------------------------</li>
						<li class="nav-item">
							<a href="?md=setting" class="nav-link">
								<i class="nav-icon bi bi-gear"></i>
								<p>PENGATURAN</p>
							</a>
						</li>
					</ul>
					<!--end::Sidebar Menu-->
				</nav>
			</div>
			<!--end::Sidebar Wrapper-->
		</aside>
		<main class="app-main">
			<div class="container-fluid">
				<div id="loadingSpinner" class="spinner-container" style="margin-bottom: -5vh;">
					<div id="loadingSpinner" class="spinner-border" role="status" style="width: 3rem; height: 3rem;">
						<span class="visually-hidden">Loading...</span>
					</div>
				</div>

				<div id="warper">
					<?php
					// No Database
					if ($db_null == 1) {
						require_once "../adm/page/setting.php";
					} elseif (cek_aktif($d_exp, "<")) {
						include_once("page/setting.php");
					} else {
						include_once("page/md.php");
					} ?>
				</div>
			</div>
		</main>
		<footer class="app-footer">
			<!--begin::To the end-->
			<div class="float-end d-none d-sm-inline">Panel By <a href="https://adminlte.io" class="text-decoration-none">AdminLTE.io</a></div>
			<!--end::To the end-->
			<!--begin::Copyright-->
			<strong>
				<?php require_once('../config/about.php') ?>
			</strong>
			All rights reserved.
			<!--end::Copyright-->
		</footer>
	</div>
</body>

</html>

<!--begin::Script-->
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script> -->
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script> -->
<script src="adminlte.js"></script>
<script src="overlayscrollbars.browser.es6.min.js"></script>
<script>
	const SELECTOR_SIDEBAR_WRAPPER = ".sidebar-wrapper";
	const Default = {
		scrollbarTheme: "os-theme-light",
		scrollbarAutoHide: "leave",
		scrollbarClickScroll: true,
	};
	document.addEventListener("DOMContentLoaded", function() {
		const sidebarWrapper = document.querySelector(SELECTOR_SIDEBAR_WRAPPER);
		if (sidebarWrapper && OverlayScrollbarsGlobal?.OverlayScrollbars !== undefined) {
			OverlayScrollbarsGlobal.OverlayScrollbars(sidebarWrapper, {
				scrollbars: {
					theme: Default.scrollbarTheme,
					autoHide: Default.scrollbarAutoHide,
					clickScroll: Default.scrollbarClickScroll,
				},
			});
		}
	});
</script>
<script>
	document.addEventListener("DOMContentLoaded", function() {
		// Tampilkan spinner
		document.getElementById("loadingSpinner").style.display = "flex";

		// Sembunyikan spinner dan tampilkan tabel setelah loading selesai
		setTimeout(function() {
			document.getElementById("loadingSpinner").style.display = "none";
			document.getElementById("warper").style.display = "block";
		}, 300);

	});
</script>
<!--end::Script-->