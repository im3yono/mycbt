<?php
include_once("../../config/server.php");
include_once("db_sql.php");


// === Identitas === //
if ($_REQUEST['pr'] == "up") {
	if ($_SERVER['REQUEST_METHOD'] = "POST") {
		$idpt = $_POST['idpt'];
		$nmpt   = $_POST['nmpt'];
		$almt   = $_POST['almt'];
		// $nmpt   = $_POST[''];
		$nmkpt = $_POST['nmkpt'];
		$nmpnpt = $_POST['nmpnpt'];

		$idup = "UPDATE info SET idpt = '$idpt', nmpt = '$nmpt', almtpt = '$almt', nmkpt = '$nmkpt', nmpnpt = '$nmpnpt' WHERE info.id = '1';";
		if ($koneksi->query($idup) === true) {
			echo '<meta http-equiv="refresh" content="0;url=../?md=id">';
		} else {
			echo '<meta http-equiv="refresh" content="0;url=../?md=id">';
		}
	}
}
// === Akhir Identitas === //


// ====== Managemen User ====== //
elseif ($_REQUEST['pr'] == "us_add") {
	if ($_SERVER['REQUEST_METHOD'] == "POST") {
		// $kdus			= $_POST['kd'];
		$nm			= $_POST['nm'];
		$usr		= $_POST['usr'];
		$pass		= $_POST['pass'];
		$notlp	= $_POST['notlp'];
		$lvl		= $_POST['lvl'];

		$muadd	= "INSERT INTO user (id_usr, nm_user, username, pass, tlp, lvl, sts) VALUES (NULL, '$nm', '$usr', '$pass', '$notlp', '$lvl', 'Y');";

		if ($koneksi->query($muadd) === true) {
			echo '<meta http-equiv="refresh" content="0;url=../?md=usr&pesan=add">';
		} else {
			echo '<meta http-equiv="refresh" content="0;url=../?md=usr&pesan=gagal">';
		}
	}
} elseif ($_REQUEST['pr'] == "us_ed") {
	if ($_SERVER['REQUEST_METHOD'] == "POST") {
		// $kdus			= $_POST['kd'];
		$nm			= $_POST['nm'];
		$usr		= $_POST['usr'];
		$usrlm		= $_POST['usrlm'];
		$pass		= $_POST['pass'];
		$notlp	= $_POST['notlp'];
		$lvl		= $_POST['lvl'];

		if (empty($pass)) {
			$muadd	= "UPDATE user SET nm_user = '$nm', username = '$usr', tlp = '$notlp', lvl = '$lvl' WHERE user.username = '$usrlm';";

			if ($koneksi->query($muadd) === true) {
				echo '<meta http-equiv="refresh" content="0;url=../?md=usr&pesan=edit">';
			} else {
				echo '<meta http-equiv="refresh" content="0;url=../?md=usr&pesan=gagal">';
			}
		} else {
			$muadd	= "UPDATE user SET nm_user = '$nm', username = '$usr', pass = MD5('$pass'), tlp = '$notlp', lvl = '$lvl' WHERE user.username = '$usrlm';";

			if ($koneksi->query($muadd) === true) {
				echo '<meta http-equiv="refresh" content="0;url=../?md=usr">';
			} else {
				echo '<meta http-equiv="refresh" content="0;url=../?md=usr">';
			}
		}
	}
} elseif ($_REQUEST['pr'] == "us_sts") {
	$dt = $_GET['dt'];
	$ckdt = mysqli_fetch_array(mysqli_query($koneksi, "SELECT sts FROM user WHERE user.username = '$dt';"));
	if ($ckdt['sts'] == "Y") {
		mysqli_query($koneksi, "UPDATE user SET sts = 'N' WHERE user.username = '$dt';");

		echo '<meta http-equiv="refresh" content="0;url=../?md=usr">';
	} else {
		mysqli_query($koneksi, "UPDATE user SET sts = 'Y' WHERE user.username = '$dt';");

		echo '<meta http-equiv="refresh" content="0;url=../?md=usr">';
	}
}
// === Akhir Managemen User === //


// ====== Administrasi ---=== //
// kelas
elseif ($_REQUEST['pr'] == "adm_klsadd") {
	if ($_SERVER['REQUEST_METHOD'] == "POST") {
		$kd			= $_POST['kd_kls'];
		$kls		= $_POST['kls'];
		$nm		= $_POST['nm_kls'];
		$jur	= $_POST['jur'];
		$min		= $_POST['min'];

		$klsadd	= "INSERT INTO kelas (id_kls, kd_kls, nm_kls, kls, jur, kls_minat, sts) VALUES (NULL, '$kd', '$nm', '$kls', '$jur', '$min', 'Y');";
		// "INSERT INTO user (id_usr, nm_user, username, pass, tlp, lvl, sts) VALUES (NULL, '$nm', '$usr', '$pass', '$notlp', '$lvl', 'Y');";

		if ($koneksi->query($klsadd) === true) {
			echo '<meta http-equiv="refresh" content="0;url=../?md=kls&pesan=add">';
		} else {
			echo '<meta http-equiv="refresh" content="0;url=../?md=kls&pesan=gagal">';
		}
	}
} elseif ($_REQUEST['pr'] == "adm_klsedt") {
	if ($_SERVER['REQUEST_METHOD'] == "POST") {
		$kd			= $_POST['kd_kls'];
		$kdl		= $_POST['kd_kl'];
		$kls		= $_POST['kls'];
		$nm		= $_POST['nm_kls'];
		$jur	= $_POST['jur'];
		$min		= $_POST['min'];

		$klsadd	= "UPDATE kelas SET kd_kls = '$kd', nm_kls = '$nm', kls = '$kls', jur = '$jur', kls_minat = '$min' WHERE kelas.kd_kls = '$kdl';";
		// UPDATE kelas SET kd_kls = 'M2n', nm_kls = 'X2_Merdeka', kls = 'Xi', jur = 'Merdeka lh', kls_minat = 'Fisikai' WHERE kelas.id_kls = 2;

		if ($koneksi->query($klsadd) === true) {
			echo '<meta http-equiv="refresh" content="0;url=../?md=kls&pesan=add">';
		} else {
			echo '<meta http-equiv="refresh" content="0;url=../?md=kls&pesan=gagal">';
		}
	}
} elseif ($_REQUEST['pr'] == "adm_sts") {
	$dt = $_GET['dt'];
	$ckdt = mysqli_fetch_array(mysqli_query($koneksi, "SELECT sts FROM kelas WHERE kelas.kd_kls = '$dt';"));
	if ($ckdt['sts'] == "Y") {
		mysqli_query($koneksi, "UPDATE kelas SET sts = 'N' WHERE kelas.kd_kls = '$dt';");

		echo '<meta http-equiv="refresh" content="0;url=../?md=kls">';
	} else {
		mysqli_query($koneksi, "UPDATE kelas SET sts = 'Y' WHERE kelas.kd_kls = '$dt';");

		echo '<meta http-equiv="refresh" content="0;url=../?md=kls">';
	}
}
// === Akhir Administrasi === //