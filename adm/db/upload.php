<?php
include_once("../../config/server.php");

// ====== Identitas ====== //

// Logo dinas
if ($_REQUEST['up'] == "lgdnas") {
	if ($_SERVER['REQUEST_METHOD'] = "POST") {
		$format     = array('png', 'jpg', 'PNG', 'JPG', 'jpeg', 'JPEG');
		$x         = explode('.', $_FILES['lgdns']['name']);
		$ekstensi  = strtolower(end($x));
		$size      = $_FILES['lgdns']['size'];
		$file_tmp  = $_FILES['lgdns']['tmp_name'];
		$ft        = 'logo_dinas.' . end($x);
		$Fft       = (object) @$_FILES['lgdns'];


		if (in_array($ekstensi, $format) == true) {
			$updinas = "UPDATE info SET lg_dinas = '$ft' WHERE info.id = '1'";
			move_uploaded_file($file_tmp, '../../img/' . $ft);
			if (mysqli_query($koneksi, $updinas)) {
				echo '<meta http-equiv="refresh" content="0;url=../?md=id">';
			} else {
				echo '<meta http-equiv="refresh" content="0;url=../?md=id">';
			}
		}
	}
}
// Logo Sekolah
elseif ($_REQUEST['up'] == "lgsek") {
	if ($_SERVER['REQUEST_METHOD'] = "POST") {
		$format     = array('png', 'jpg', 'PNG', 'JPG', 'jpeg', 'JPEG');
		$x         = explode('.', $_FILES['lgsek']['name']);
		$ekstensi  = strtolower(end($x));
		$size      = $_FILES['lgsek']['size'];
		$file_tmp  = $_FILES['lgsek']['tmp_name'];
		$ft        = 'logo_sek.' . end($x);
		$Fft       = (object) @$_FILES['lgsek'];


		if (in_array($ekstensi, $format) == true) {
			$updinas = "UPDATE info SET fav = '$ft' WHERE info.id = '1'";
			move_uploaded_file($file_tmp, '../../img/' . $ft);
			if (mysqli_query($koneksi, $updinas)) {
				echo '<meta http-equiv="refresh" content="0;url=../?md=id">';
			} else {
				echo '<meta http-equiv="refresh" content="0;url=../?md=id">';
			}
		}
	}
}
// Logo admin
elseif ($_REQUEST['up'] == "lgadm") {
	if ($_SERVER['REQUEST_METHOD'] = "POST") {
		$format     = array('png', 'jpg', 'PNG', 'JPG', 'jpeg', 'JPEG');
		$x         = explode('.', $_FILES['lgadm']['name']);
		$ekstensi  = strtolower(end($x));
		$size      = $_FILES['lgadm']['size'];
		$file_tmp  = $_FILES['lgadm']['tmp_name'];
		$ft        = 'foto_adm.' . end($x);
		$Fft       = (object) @$_FILES['lgadm'];


		if (in_array($ekstensi, $format) == true) {
			$updinas = "UPDATE info SET ft_adm = '$ft' WHERE info.id = '1'";
			move_uploaded_file($file_tmp, '../../img/' . $ft);
			if (mysqli_query($koneksi, $updinas)) {
				echo '<meta http-equiv="refresh" content="0;url=../?md=id">';
			} else {
				echo '<meta http-equiv="refresh" content="0;url=../?md=id">';
			}
		}
	}
}
// Logo sis
elseif ($_REQUEST['up'] == "lgsis") {
	if ($_SERVER['REQUEST_METHOD'] = "POST") {
		$format     = array('png', 'jpg', 'PNG', 'JPG', 'jpeg', 'JPEG');
		$x         = explode('.', $_FILES['lgsis']['name']);
		$ekstensi  = strtolower(end($x));
		$size      = $_FILES['lgsis']['size'];
		$file_tmp  = $_FILES['lgsis']['tmp_name'];
		$ft        = 'foto_sis.' . end($x);
		$Fft       = (object) @$_FILES['lgsis'];


		if (in_array($ekstensi, $format) == true) {
			$updinas = "UPDATE info SET ft_sis = '$ft' WHERE info.id = '1'";
			move_uploaded_file($file_tmp, '../../img/' . $ft);
			if (mysqli_query($koneksi, $updinas)) {
				echo '<meta http-equiv="refresh" content="0;url=../?md=id">';
			} else {
				echo '<meta http-equiv="refresh" content="0;url=../?md=id">';
			}
		}
	}
}

// === Akhir Identitas === //

// Foto Profile
elseif ($_REQUEST['up'] == "ftp") {
	if ($_SERVER['REQUEST_METHOD'] == "POST") {
		$format     = array('png', 'jpg', 'PNG', 'JPG', 'jpeg', 'JPEG');
		$x         = explode('.', $_FILES['ftp']['name']);
		$ekstensi  = strtolower(end($x));
		$size      = $_FILES['ftp']['size'];
		$file_tmp  = $_FILES['ftp']['tmp_name'];
		$ft        = $_COOKIE['user'] . '.' . end($x);
		$Fft       = (object) @$_FILES['ftp'];

		// Check if file with the same name but different format exists and delete it
		foreach ($format as $ext) {
			$existingFile = '../images/' . $_COOKIE['user'] . '.' . $ext;
			if (file_exists($existingFile)) {
				unlink($existingFile);
			}
		}

		if (in_array($ekstensi, $format) == true) {
			move_uploaded_file($file_tmp, '../images/' . $ft);
			echo '<meta http-equiv="refresh" content="0;url=../?md=puser">';
		}
	}
}
