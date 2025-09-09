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
		$info   = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM info"));
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
	<meta charset="UTF-8">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title><?php echo $inf_nm ?></title>
	<link rel="shortcut icon" href="../img/<?php echo $inf_fav ?>" type="image/x-icon">
	<meta name="title" content="<?php echo $inf_nm ?>" />
	<link rel="stylesheet" href="adminlte.css" />
	<link rel="stylesheet" href="overlayscrollbars.min.css" />


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

	<link rel="stylesheet" href="../aset/font.css">
	<!-- <link rel="stylesheet" href="../aset/icon.css"> -->
</head>

<style>
	.swal2-timer-progress-bar {
		background: greenyellow !important;
		height: 7px;
		border-radius: 7px;
	}
</style>

<body class="layout-fixed fixed-header sidebar-expand-lg sidebar-mini app-loaded bg-body-tertiary fixed-header">
	<div class="app-wrapper">
		<nav class="app-header navbar navbar-expand bg-body-secondary">
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
					<li class="nav-item"><span class="nav-link" id="jam"></span></li>
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
							<?php if ($dt_adm['id_usr'] == "1") : ?>
								<li class="user-body">
									<!--begin::Row-->
									<div class="row">
										<?php if (get_ip() == "127.0.0.1") { ?>
											<div class="col-5 text-center"><a href="/phpmyadmin/">Database</a></div>
										<?php } ?>
										<div class="col-7 text-center"><a href="?md=usr">Manajemen User</a></div>
										<!-- <div class="col-4 text-center"><a href="#">Pesan</a></div> -->
										<!-- <div class="col-4 text-center"><a href="../logout.php?fld=<?php echo $fd_root; ?>"><i class="bi bi-door-open"></i> Keluar</a></div> -->
									</div>
									<!--end::Row-->
								</li>
							<?php endif; ?>
							<!--end::Menu Body-->
							<!--begin::Menu Footer-->
							<li class="user-footer">
								<a href="?md=puser" class="btn btn-default btn-flat">Profil</a>
								<a href="../logout.php?fld=<?php echo $fd_root; ?>" class="btn btn-default btn-flat float-end"><i class="bi bi-door-open"></i> Keluar</a>
							</li>
							<!--end::Menu Footer-->
						</ul>
					</li>
					<!--end::User Menu Dropdown-->
					<!--begin::Fullscreen Toggle-->
					<li class="nav-item">
						<a class="nav-link" href="#" data-lte-toggle="fullscreen">
							<i data-lte-icon="maximize" class="bi bi-arrows-fullscreen"></i>
							<i data-lte-icon="minimize" class="bi bi-fullscreen-exit" style="display: none"></i>
						</a>
					</li>
					<!--end::Fullscreen Toggle-->
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
					<img src="../img/bnr-mytbk.png" alt="Logo" class="brand-image" />
					<!--end::Brand Image-->
					<!--begin::Brand Text-->
					<!-- <span class="brand-text fw-light">IM'3</span> -->
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
						<?php if (cek_aktif($d_exp, ">=")) : ?>
							<li class="nav-item">
								<!-- <a href="?" class="nav-link "> -->
								<a href="?" class="nav-link ">
									<!-- <i class="nav-icon bi bi-speedometer"></i> -->
									<img src="../aset/icon/dashboard.svg" class="nav-icon">
									<p>
										Dashboard
									</p>
								</a>
							</li>
							<?php if ($dt_adm['lvl'] == "A") : ?>
								<li class="nav-item" id="mn_sync" <?= ($server_ms['lev_svr'] == "C") ? 'style="display: none;"' : ''; ?>>
									<a href="?md=sync" class="nav-link">
										<img src="../aset/icon/sync.svg" class="nav-icon">
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
												<img src="../aset/icon/local_library.svg" class="nav-icon">
												<p>Kelas</p>
											</a>
										</li>
										<li class="nav-item">
											<a href="?md=sis" class="nav-link">
												<img src="../aset/icon/person_group.svg" class="nav-icon">
												<p>Peserta</p>
											</a>
										</li>
										<li class="nav-item">
											<a href="?md=mpl" class="nav-link">
												<img src="../aset/icon/book_open.svg" class="nav-icon">
												<p>Mata Pelajaran</p>
											</a>
										</li>
									</ul>
								</li>
							<?php endif;
							if ($dt_adm['lvl'] == "A" || $dt_adm['lvl'] == "U") : ?>
								<li class="nav-item">
									<a href="#" class="nav-link">
										<!-- <i class="nav-icon bi bi-list-check"></i> -->
										<img src="../aset/icon/event_list.svg" class="nav-icon">
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
									<?php endif; ?>
									<li class="nav-item">
										<a href="?md=pr_brita" class="nav-link">
											<i class="nav-icon bi bi-printer"></i>
											<p>Berita Acara</p>
										</a>
									</li>
									<?php if ($dt_adm['lvl'] == "A" || $dt_adm['lvl'] == "U") : ?>
									</ul>
								</li>
								<li class="nav-item">
									<a href="#" class="nav-link">
										<!-- <i class="nav-icon bi bi-list-ul"></i> -->
										<img src="../aset/icon/box.svg" class="nav-icon">
										<p>
											Paket Soal
											<i class="nav-arrow bi bi-chevron-right"></i>
										</p>
									</a>
									<ul class="nav nav-treeview">
										<li class="nav-item">
											<a href="?md=soal" class="nav-link">
												<img src="../aset/icon/rate_review.svg" class="nav-icon">
												<p>Bank Soal</p>
											</a>
										</li>
										<li class="nav-item">
											<a href="?md=f_soal" class="nav-link">
												<img src="../aset/icon/files.svg" class="nav-icon">
												<p>File Pendukung</p>
											</a>
										</li>
									</ul>
								</li>
							<?php endif;
									if ($dt_adm['lvl'] == "A"): ?>
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
												<!-- <i class="nav-icon bi bi-circle"></i> -->
												<img src="../aset/icon/edit_notifications.svg" class="nav-icon">
												<p>Aktivasi</p>
											</a>
										</li>
										<li class="nav-item">
											<a href="?md=uj_jdwl" class="nav-link">
												<!-- <i class="nav-icon bi bi-circle"></i> -->
												<img src="../aset/icon/schedule.svg" class="nav-icon">
												<p>Jadwal</p>
											</a>
										</li>
										<li class="nav-item">
											<a href="?md=uj_rwyt" class="nav-link">
												<!-- <i class="nav-icon bi bi-circle"></i> -->
												<img src="../aset/icon/history.svg" class="nav-icon">
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
							<?php endif;
									if ($dt_adm['lvl'] == "A" ||  $dt_adm['lvl'] == "X"): ?>
								<li class="nav-item">
									<a href="?md=dfps_uji" class="nav-link">
										<img src="../aset/icon/groups.svg" class="nav-icon">
										<p>
											Daftar Peserta
										</p>
									</a>
								</li>
								<li class="nav-item">
									<a href="?md=rst_uji" class="nav-link">
										<!-- <i class="nav-icon bi bi-person-fill-exclamation"></i> -->
										<img src="../aset/icon/zone_person_alert.svg" class="nav-icon">
										<p>
											Request Reset
										</p>
									</a>
								</li>
							<?php endif;
									if ($dt_adm['lvl'] == "A" ||  $dt_adm['lvl'] == "U"): ?>
								<li class="nav-header">CETAK HASIL</li>
								<li class="nav-item">
									<a href="?md=nilai" class="nav-link">
										<i class="nav-icon bi bi-123"></i>
										<p>
											Nilai
										</p>
									</a>
								</li>
								<li class="nav-item">
									<a href="?md=anls" class="nav-link">
										<!-- <i class="nav-icon bi bi-list-columns-reverse"></i> -->
										<img src="../aset/icon/analytics.svg" class="nav-icon">
										<p>
											Analisa
										</p>
									</a>
								</li>
								<!-- <li class="nav-item">
									<a href="#" class="nav-link">
										<img src="../aset/icon/monitoring.svg" class="nav-icon">
										<p>
											Statistik Soal
										</p>
									</a>
								</li> -->
							<?php endif;
								endif;
								if ($dt_adm['lvl'] == "A"): ?>
							<!-- <li class="nav-header">PENGATURAN</li> -->
							<li class="nav-header">------------------------------------</li>
							<li class="nav-item">
								<a href="?md=setting" class="nav-link">
									<!-- <i class="nav-icon bi bi-gear"></i> -->
									<img src="../aset/icon/settings.svg" class="nav-icon">
									<p>PENGATURAN</p>
								</a>
							</li>
						<?php endif; ?>
					</ul>
					<!--end::Sidebar Menu-->
				</nav>
			</div>
			<!--end::Sidebar Wrapper-->
		</aside>
		<main class="app-main">
			<div class="app-content"></div>
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
		<footer class="app-footer px-2">
			<!--begin::To the end-->
			<div class="float-end d-none d-sm-inline">Panel By <a href="https://adminlte.io" class="text-decoration-none">AdminLTE.io</a></div>
			<!--end::To the end-->
			<!--begin::Copyright-->
			<strong>
				<?php require_once('../config/about.php');
				echo $buat . $by . $ver_app; ?>
			</strong>
			<!--end::Copyright-->
		</footer>
	</div>
</body>

</html>

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
<script>
	document.addEventListener("DOMContentLoaded", function() {
		const urlParams = new URLSearchParams(window.location.search);
		const currentMd = urlParams.get("md");

		document.querySelectorAll(".app-sidebar .nav-link").forEach(link => {
			const href = link.getAttribute("href");

			if (href && href.includes("md=")) {
				const linkMd = new URLSearchParams(href).get("md");

				if (linkMd === currentMd) {
					link.classList.add("active");

					// Tambahkan juga class "menu-open" dan "active" ke <li> parent dan treeview jika perlu
					// const navItem = link.closest(".nav-item");
					// if (navItem) navItem.classList.add("menu-open");

					const treeview = link.closest(".nav-treeview");
					if (treeview) {
						const parentLink = treeview.previousElementSibling;
						if (parentLink && parentLink.classList.contains("nav-link")) {
							parentLink.classList.add("active");
							parentLink.parentElement.classList.add("menu-open");
						}
					}
				}
			}
		});
	});
</script>

<!--end::Script-->