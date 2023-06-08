<?php
// error_reporting(0); //hide error
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
} elseif ($_REQUEST['pr'] == "adm_klssts") {
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
// Mapel
elseif ($_REQUEST['pr'] == "adm_mpadd") {
	if ($_SERVER['REQUEST_METHOD'] == "POST") {
		$kls			= $_POST['kls'];
		$jur			= $_POST['jur'];
		$minat			= $_POST['minat'];
		$kd_mpel		= $_POST['kd_mpel'];
		$nm_mpel		= $_POST['nm_mpel'];
		$kkm		= $_POST['kkm'];
		// $jur	= $_POST['jur'];
		// $min		= $_POST['min'];

		$mpladd	= "INSERT INTO mapel (id_mpel, kd_mpel, nm_mpel, kkm, kls, jur, kls_minat, sts) VALUES (NULL, '$kd_mpel', '$nm_mpel', '$kkm', '$kls','$jur','$minat', 'Y');";
		// INSERT INTO mapel (id_mpel, kd_mpel, nm_mpel, kkm, kd_kls, sts) VALUES (NULL, 'BIndo', 'Bahasa Indonesia', '75', 'M3', 'Y');

		if ($koneksi->query($mpladd) === true) {
			echo '<meta http-equiv="refresh" content="0;url=../?md=mpl&pesan=add">';
		} else {
			echo '<meta http-equiv="refresh" content="0;url=../?md=mpl&pesan=gagal">';
		}
	}
} elseif ($_REQUEST['pr'] == "adm_mpedt") {
	// UPDATE mapel SET nm_mpel = '$nm_mpel', kkm = '$kkm', kls = '$kls', jur = '$jur' WHERE mapel.kd_mpel = '$kd_mpel';
	if ($_SERVER['REQUEST_METHOD'] == "POST") {
		// $kls			= $_POST['kd_kls'];
		// $jur			= $_POST['jur'];
		// $minat			= $_POST['minat'];
		$kd_mpel		= $_POST['kd_mpel'];
		$id_mpel		= $_POST['id_mpel'];
		$nm_mpel		= $_POST['nm_mpel'];
		// $kkm		= $_POST['kkm'];
		// $jur	= $_POST['jur'];
		// $min		= $_POST['min'];

		// $mpled	= "UPDATE mapel SET nm_mpel = '$nm_mapel', kkm = '$kkm', kls = '$kls', jur = '$jur' WHERE mapel.kd_mpel = '$kd_mpel';";
		$mpled	= "UPDATE mapel SET nm_mpel = '$nm_mpel', kd_mpel = '$kd_mpel' WHERE mapel.id_mpel = '$id_mpel';";
		// INSERT INTO mapel (id_mpel, kd_mpel, nm_mpel, kkm, kd_kls, sts) VALUES (NULL, 'BIndo', 'Bahasa Indonesia', '75', 'M3', 'Y');

		if ($koneksi->query($mpled) === true) {
			echo '<meta http-equiv="refresh" content="0;url=../?md=mpl&pesan=add">';
		} else {
			echo '<meta http-equiv="refresh" content="0;url=../?md=mpl&pesan=gagal">';
		}
	}
} elseif ($_REQUEST['pr'] == "adm_mpsts") {
	$dt = $_GET['dt'];
	$ckdt = mysqli_fetch_array(mysqli_query($koneksi, "SELECT sts FROM mapel WHERE kelas.kd_mpel = '$dt';"));
	if ($ckdt['sts'] == "Y") {
		mysqli_query($koneksi, "UPDATE kelas SET sts = 'N' WHERE kelas.kd_mpel = '$dt';");

		echo '<meta http-equiv="refresh" content="0;url=../?md=kls">';
	} else {
		mysqli_query($koneksi, "UPDATE kelas SET sts = 'Y' WHERE kelas.kd_mpel = '$dt';");

		echo '<meta http-equiv="refresh" content="0;url=../?md=kls">';
	}
}

// Peserta
elseif ($_REQUEST['pr'] == "adm_sisadd") {
	if ($_SERVER['REQUEST_METHOD'] == "POST") {
		$nis			= $_POST['nis'];
		$nm			= $_POST['nm'];
		$tmp			= $_POST['tmp'];
		$tgl			= $_POST['tgl'];
		$kel			= $_POST['kel'];
		$kls			= $_POST['kls'];
		// $kd_mpel		= $_POST['kls'];
		$usr		= $_POST['usr'];
		$pas		= $_POST['pas'];
		$ses		= $_POST['ses'];
		$ru		= $_POST['ru'];

		$format     = array('png', 'jpg', 'PNG', 'JPG', 'jpeg', 'JPEG');
		$x         = explode('.', $_FILES['ft']['name']);
		$ekstensi  = strtolower(end($x));
		$size      = $_FILES['ft']['size'];
		$file_tmp  = $_FILES['ft']['tmp_name'];
		$ft        = round(microtime(true)) . '_sis.' . end($x);
		$Fft       = (object) @$_FILES['ft'];

		$qrsis	= "INSERT INTO cbt_peserta (id_peserta, nm, tmp_lahir, tgl_lahir, nis, kd_kls, jns_kel, user, pass, sesi, ruang, sts) VALUES (NULL, '$nm', '$tmp', '$tgl', '$nis', '$kls', '$kel', '$usr', '$pas', '$ses', '$ru', 'Y');";
		$qrsisf	= "INSERT INTO cbt_peserta (id_peserta, nm, tmp_lahir, tgl_lahir, nis, kd_kls, jns_kel, ft, user, pass, sesi, ruang, sts) VALUES (NULL, '$nm', '$tmp', '$tgl', '$nis', '$kls', '$kel', '$ft', '$usr', '$pas', '$ses', '$ru', 'Y');";
		// $min		= $_POST['min'];
		if (!@$Fft->name) {
			if ($koneksi->query($qrsis) === true) {
				echo '<meta http-equiv="refresh" content="0;url=../?md=sis&pesan=add">';
			} else {
				echo '<meta http-equiv="refresh" content="0;url=../?md=sis&pesan=gagal">';
			}
		} elseif (in_array($ekstensi, $format) == true) {
			move_uploaded_file($file_tmp, '../../pic_sis/' . $ft);
			if ($koneksi->query($qrsisf) === true) {
				echo '<meta http-equiv="refresh" content="0;url=../?md=sis&pesan=add">';
			} else {
				echo '<meta http-equiv="refresh" content="0;url=../?md=sis&pesan=gagal">';
			}
		}
	}
} elseif ($_REQUEST['pr'] == "adm_sisedt") {
	if ($_SERVER['REQUEST_METHOD'] == "POST") {
		$nis			= $_POST['nis'];
		$nm			= $_POST['nm'];
		$tmp			= $_POST['tmp'];
		$tgl			= $_POST['tgl'];
		$kel			= $_POST['kel'];
		$kls			= $_POST['kls'];
		// $kd_mpel		= $_POST['kls'];
		$usr		= $_POST['usr'];
		$pas		= $_POST['pas'];
		$ses		= $_POST['ses'];
		$ru		= $_POST['ru'];

		$format     = array('png', 'jpg', 'PNG', 'JPG', 'jpeg', 'JPEG');
		$x         = explode('.', $_FILES['ft']['name']);
		$ekstensi  = strtolower(end($x));
		$size      = $_FILES['ft']['size'];
		$file_tmp  = $_FILES['ft']['tmp_name'];
		$ft        = $nis . '_sis.' . end($x);
		$Fft       = (object) @$_FILES['ft'];

		// UPDATE cbt_peserta SET id_peserta = NULL, nm = '$nm', tmp_lahir = '$tmp', tgl_lahir = '$tgl', nis = '$nis', kd_kls = '$kls', jns_kel = '$kel', ft = '$ft', pass = '$pas', sesi = '$ses', ruang = '$ru', sts = 'Y' WHERE cbt_peserta.user = '$usr';
		$qrsis	= "UPDATE cbt_peserta SET nm = '$nm', tmp_lahir = '$tmp', tgl_lahir = '$tgl', nis = '$nis', kd_kls = '$kls', jns_kel = '$kel', pass = '$pas', sesi = '$ses', ruang = '$ru', sts = 'Y' WHERE cbt_peserta.user = '$usr';";
		$qrsisf	= "UPDATE cbt_peserta SET nm = '$nm', tmp_lahir = '$tmp', tgl_lahir = '$tgl', nis = '$nis', kd_kls = '$kls', jns_kel = '$kel', ft = '$ft', pass = '$pas', sesi = '$ses', ruang = '$ru', sts = 'Y' WHERE cbt_peserta.user = '$usr';";
		
		// $min		= $_POST['min'];
		if (!@$Fft->name) {
			if ($koneksi->query($qrsis) === true) {
				echo '<meta http-equiv="refresh" content="0;url=../?md=sis&pesan=add">';
			} else {
				echo '<meta http-equiv="refresh" content="0;url=../?md=sis&pesan=gagal">';
			}
		} elseif (in_array($ekstensi, $format) == true) {
			move_uploaded_file($file_tmp, '../../pic_sis/' . $ft);
			if ($koneksi->query($qrsisf) === true) {
				echo '<meta http-equiv="refresh" content="0;url=../?md=sis&pesan=add">';
			} else {
				echo '<meta http-equiv="refresh" content="0;url=../?md=sis&pesan=gagal">';
			}
		}
	}
} elseif ($_REQUEST['pr'] == "adm_sissts") {
	$dt = $_GET['dt'];
	$ckdt = mysqli_fetch_array(mysqli_query($koneksi, "SELECT sts FROM cbt_peserta WHERE cbt_peserta.id_peserta = '$dt';"));
	if ($ckdt['sts'] == "Y") {
		mysqli_query($koneksi, "UPDATE cbt_peserta SET sts = 'N' WHERE cbt_peserta.id_peserta = '$dt';");

		echo '<meta http-equiv="refresh" content="0;url=../?md=sis">';
	} else {
		mysqli_query($koneksi, "UPDATE cbt_peserta SET sts = 'Y' WHERE cbt_peserta.id_peserta = '$dt';");

		echo '<meta http-equiv="refresh" content="0;url=../?md=sis">';
	}
}
// === Akhir Administrasi === //







// ==================================BANK SOAL================================== //
elseif($_REQUEST['pr']=="pkt"){}
elseif($_REQUEST['pr']=="sts"){
	$dt = $_GET['dt'];
	$ckdt = mysqli_fetch_array(mysqli_query($koneksi, "SELECT sts FROM cbt_pktsoal WHERE cbt_pktsoal.id_pktsoal = '$dt';"));
	if ($ckdt['sts'] == "Y") {
		mysqli_query($koneksi, "UPDATE cbt_pktsoal SET sts = 'N' WHERE cbt_pktsoal.id_pktsoal = '$dt';");

		echo '<meta http-equiv="refresh" content="0;url=../?md=soal">';
	} else {
		mysqli_query($koneksi, "UPDATE cbt_pktsoal SET sts = 'Y' WHERE cbt_pktsoal.id_pktsoal = '$dt';");

		echo '<meta http-equiv="refresh" content="0;url=../?md=soal">';
	}
}
// INSERT INTO `cbt_pktsoal` (`id_pktsoal`, `kd_kls`, `kd_soal`, `sesi`, `pilgan`, `prsen_pilgan`, `esai`, `prsen_esai`, `jum_soal`, `tgl`, `sts`) VALUES (NULL, '', '', '', '', '', '', '', '', current_timestamp(), 'Y');
// ===============================AKHIR BANK SOAL=============================== //
