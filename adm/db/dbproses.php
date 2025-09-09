<?php
// error_reporting(0); //hide error
include_once("../../config/server.php");
include_once("db_sql.php");


// === Identitas === //
if ($_REQUEST['pr'] == "up") {
	if ($_SERVER['REQUEST_METHOD'] = "POST") {
		$idpt = $_POST['idpt'];
		// $nmpt   = $mem == null ? $_POST['nmpt'] : $mem;
		$almt   = $_POST['almt'];
		// $nmpt   = $_POST[''];
		$nmkpt = $_POST['nmkpt'];
		$nmpnpt = $_POST['nmpnpt'];
		$head1 = $_POST['head1'];
		$head2 = $_POST['head2'];

		// $idup = "UPDATE info SET idpt = '$idpt', nmpt = '$nmpt', almtpt = '$almt', nmkpt = '$nmkpt', nmpnpt = '$nmpnpt', head = '$head1', head2 = '$head2' WHERE info.id = '1';";
		$idup = "UPDATE info SET idpt = '$idpt', almtpt = '$almt', nmkpt = '$nmkpt', nmpnpt = '$nmpnpt', head = '$head1', head2 = '$head2' WHERE info.id = '1';";
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

		$muadd	= "INSERT INTO user (id_usr, nm_user, username, pass, tlp, lvl, sts) VALUES (NULL, '$nm', '$usr', MD5('$pass'), '$notlp', '$lvl', 'Y');";

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
				echo '<meta http-equiv="refresh" content="0;url=../?md=' . $_POST['use'] . '&pesan=edit">';
			} else {
				echo '<meta http-equiv="refresh" content="0;url=../?md=' . $_POST['use'] . '&pesan=gagal">';
			}
		} else {
			$muadd	= "UPDATE user SET nm_user = '$nm', username = '$usr', pass = MD5('$pass'), tlp = '$notlp', lvl = '$lvl' WHERE user.username = '$usrlm';";

			if ($koneksi->query($muadd) === true) {
				if ($_COOKIE['user'] != "admin") {
					setcookie('user', '', time() - 3600, '/');
					setcookie('pass', '', time() - 3600, '/');
				}
				echo '<meta http-equiv="refresh" content="0;url=../?md=' . $_POST['use'] . '">';
			} else {
				echo '<meta http-equiv="refresh" content="0;url=../?md=' . $_POST['use'] . '">';
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
		$kd_mpel		= $_POST['kd_mpel'];
		$nm_mpel		= $_POST['nm_mpel'];
		$kls				= "";
		$jur				= "";
		$minat			= "";
		$kkm				= "";
		// $kls			= $_POST['kls'];
		// $jur			= $_POST['jur'];
		// $minat			= $_POST['minat'];
		// $kkm		= $_POST['kkm'];
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
		$sv				= $_POST['sv'];
		$nis			= $_POST['nis'];
		$nm				= $_POST['nm'];
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

		$qrsis	= "INSERT INTO cbt_peserta (id_peserta, ip_sv, nm, tmp_lahir, tgl_lahir, nis, kd_kls, jns_kel, user, pass, sesi, ruang, sts) VALUES (NULL,'$sv', '$nm', '$tmp', '$tgl', '$nis', '$kls', '$kel', '$usr', '$pas', '$ses', '$ru', 'Y');";
		$qrsisf	= "INSERT INTO cbt_peserta (id_peserta, ip_sv, nm, tmp_lahir, tgl_lahir, nis, kd_kls, jns_kel, ft, user, pass, sesi, ruang, sts) VALUES (NULL, '$sv', '$nm', '$tmp', '$tgl', '$nis', '$kls', '$kel', '$ft', '$usr', '$pas', '$ses', '$ru', 'Y');";
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
		$sv		= $_POST['sv'];
		$nis	= $_POST['nis'];
		$nm		= $_POST['nm'];
		$tmp	= $_POST['tmp'];
		$tgl	= $_POST['tgl'];
		$kel	= $_POST['kel'];
		$kls	= $_POST['kls'];
		// $kd_mpel		= $_POST['kls'];
		$usr	= $_POST['usr'];
		$pas	= $_POST['pas'];
		$ses	= $_POST['ses'];
		$ru		= $_POST['ru'];
		$cht	= isset($_POST['cht']) ? 'Y' : 'N';

		$format     = array('png', 'jpg', 'PNG', 'JPG', 'jpeg', 'JPEG');
		$x         = explode('.', $_FILES['ft']['name']);
		$ekstensi  = strtolower(end($x));
		$size      = $_FILES['ft']['size'];
		$file_tmp  = $_FILES['ft']['tmp_name'];
		$ft        = $nis . '.' . end($x);
		$Fft       = (object) @$_FILES['ft'];

		// UPDATE cbt_peserta SET id_peserta = NULL, nm = '$nm', tmp_lahir = '$tmp', tgl_lahir = '$tgl', nis = '$nis', kd_kls = '$kls', jns_kel = '$kel', ft = '$ft', pass = '$pas', sesi = '$ses', ruang = '$ru', sts = 'Y' WHERE cbt_peserta.user = '$usr';
		$qrsis	= "UPDATE cbt_peserta SET ip_sv = '$sv', nm = '$nm', tmp_lahir = '$tmp', tgl_lahir = '$tgl', nis = '$nis', kd_kls = '$kls', jns_kel = '$kel', pass = '$pas', sesi = '$ses', ruang = '$ru', sts = 'Y', ischt = '$cht' WHERE cbt_peserta.user = '$usr';";
		$qrsisf	= "UPDATE cbt_peserta SET ip_sv = '$sv', nm = '$nm', tmp_lahir = '$tmp', tgl_lahir = '$tgl', nis = '$nis', kd_kls = '$kls', jns_kel = '$kel', ft = '$ft', pass = '$pas', sesi = '$ses', ruang = '$ru', sts = 'Y', ischt = '$cht' WHERE cbt_peserta.user = '$usr';";

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
elseif ($_REQUEST['pr'] == "pkt") {
	if ($_SERVER['REQUEST_METHOD'] == "POST") {
		$nmkls	= $_POST['nmkls'];
		$kls		= $_POST['kls'];
		$jur		= $_POST['jur'];
		$kd_soal	= $_POST['kd_soal'];
		$mpel		= $_POST['mpel'];
		$nm			= $_POST['nm'];
		$pg			= $_POST['pg'];
		$prpg		= $_POST['prpg'];
		$es			= $_POST['es'];
		$pres		= $_POST['pres'];
		$kkm		= empty($_POST['kkm']) ? "1" : $_POST['kkm'];
		$sesi		= $_POST['sesi'];
		$jsoal	= $pg + $es;

		$sqpkt	= "INSERT INTO cbt_pktsoal (id_pktsoal, kd_kls, kls, jur, kd_mpel, kd_soal, sesi, pilgan, prsen_pilgan, esai, prsen_esai, jum_soal, kkm, tgl, author, sts) VALUES (NULL, '$nmkls', '$kls', '$jur', '$mpel', '$kd_soal', '$sesi', '$pg', '$prpg', '$es', '$pres', '$jsoal', '$kkm', current_timestamp(), '$nm', 'N');";


		if ($koneksi->query($sqpkt) === true) {
			echo '<meta http-equiv="refresh" content="0;url=../?md=soal&pesan=add">';
		} else {
			echo '<meta http-equiv="refresh" content="0;url=../?md=soal&pesan=gagal">';
		}
	}
} elseif ($_REQUEST['pr'] == "cpkt") {
	if ($_SERVER['REQUEST_METHOD'] == "POST") {
		$nmkls	= $_POST['nmkls'];
		$kls		= $_POST['kls'];
		$jur		= $_POST['jur'];
		$kd_soal	= $_POST['kd_soal'];
		$mpel		= $_POST['mpel'];
		$nm			= $_POST['nm'];
		$pg			= $_POST['pg'];
		$prpg		= $_POST['prpg'];
		$es			= $_POST['es'];
		$pres		= $_POST['pres'];
		$kkm		= $_POST['kkm'];
		$sesi		= $_POST['sesi'];
		$jsoal	= $pg + $es;
		$kdsa		= $_POST['kds'];

		$sqpkt	= "INSERT INTO cbt_pktsoal (id_pktsoal, kd_kls, kls, jur, kd_mpel, kd_soal, sesi, pilgan, prsen_pilgan, esai, prsen_esai, jum_soal, kkm, tgl, author, sts) VALUES (NULL, '$nmkls', '$kls', '$jur', '$mpel', '$kd_soal', '$sesi', '$pg', '$prpg', '$es', '$pres', '$jsoal', '$kkm', current_timestamp(), '$nm', 'N');";
		$jumkdsa = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM cbt_soal WHERE kd_soal ='$kdsa';"));

		if ($koneksi->query($sqpkt) === true) {
			for ($i = 1; $i <= $jumkdsa; $i++) {
				$dts	= mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM cbt_soal WHERE kd_soal ='$kdsa' AND no_soal ='$i'"));

				$cerita = addslashes($dts['cerita']);
				$tanya = addslashes($dts['tanya']);
				$jwb1		= addslashes(($dts['jwb1']));
				$jwb2		= addslashes(($dts['jwb2']));
				$jwb3		= addslashes(($dts['jwb3']));
				$jwb4		= addslashes(($dts['jwb4']));
				$jwb5		= addslashes(($dts['jwb5']));

				$ins	= mysqli_query($koneksi, "INSERT INTO cbt_soal (id_soal, kd_soal, kd_mapel, jns_soal, lev_soal, no_soal, cerita, kd_crta, tanya, img, audio, vid, jwb1, jwb2, jwb3, jwb4, jwb5, img1, img2, img3, img4, img5, knci_pilgan, ack_soal, ack_opsi) VALUES (NULL, '$kd_soal', '$dts[kd_mapel]', '$dts[jns_soal]', '$dts[lev_soal]', '$i', '$cerita', '$dts[kd_crta]', '$tanya', '$dts[img]', '$dts[audio]', '$dts[vid]', '$jwb1', '$jwb2', '$jwb3', '$jwb4', '$jwb5', '$dts[img1]', '$dts[img2]', '$dts[img3]', '$dts[img4]', '$dts[img5]', '$dts[knci_pilgan]', '$dts[ack_soal]', '$dts[ack_opsi]');");
			}
			echo '<meta http-equiv="refresh" content="0;url=../?md=soal&pesan=add">';
		} else {
			echo '<meta http-equiv="refresh" content="0;url=../?md=soal&pesan=gagal">';
		}
	}
} elseif ($_REQUEST['pr'] == "epkt") {
	if ($_SERVER['REQUEST_METHOD'] == "POST") {
		$nmkls	= $_POST['nmkls'];
		$kls		= $_POST['kls'];
		$jur		= $_POST['jur'];
		$kd_soal	= $_POST['kd_soal'];
		$mpel		= $_POST['mpel'];
		$nm			= $_POST['nm'];
		$pg			= $_POST['pg'];
		$prpg		= $_POST['prpg'];
		$es			= $_POST['es'];
		$pres		= $_POST['pres'];
		$kkm		= $_POST['kkm'];
		$sesi		= $_POST['sesi'];
		$jsoal	= $pg + $es;

		// UPDATE cbt_pktsoal SET kd_kls = '$nmkls', kls = '$kls', jur = '$jur', kd_mpel = '$mpel', sesi = '$sesi', pilgan = '$pg', prsen_pilgan = '$prpg', esai = '$es', prsen_esai = '$pres', jum_soal = '$jsoal', kkm = '$kkm', author = '$nm' WHERE cbt_pktsoal.kd_soal = '$kd_soal';

		// $sqpkt	= "INSERT INTO cbt_pktsoal (id_pktsoal, kd_kls, kls, jur, kd_mpel, kd_soal, sesi, pilgan, prsen_pilgan, esai, prsen_esai, jum_soal, kkm, tgl, author, sts) VALUES (NULL, '$nmkls', '$kls', '$jur', '$mpel', '$kd_soal', '$sesi', '$pg', '$prpg', '$es', '$pres', '$jsoal', '$kkm', current_timestamp(), '$nm', 'N');";

		$sqpkt	= "UPDATE cbt_pktsoal SET kd_kls = '$nmkls', kls = '$kls', jur = '$jur', kd_mpel = '$mpel', sesi = '$sesi', pilgan = '$pg', prsen_pilgan = '$prpg', esai = '$es', prsen_esai = '$pres', jum_soal = '$jsoal', kkm = '$kkm', author = '$nm' WHERE cbt_pktsoal.kd_soal = '$kd_soal';";


		if ($koneksi->query($sqpkt) === true) {
			echo '<meta http-equiv="refresh" content="0;url=../?md=soal&pesan=edit">';
		} else {
			echo '<meta http-equiv="refresh" content="0;url=../?md=soal&pesan=gagal">';
		}
	}
} elseif ($_REQUEST['pr'] == "sts") {
	$dt = $_GET['dt'];
	$ckdt = mysqli_fetch_array(mysqli_query($koneksi, "SELECT sts FROM cbt_pktsoal WHERE id_pktsoal = '$dt';"));
	$new_sts = ($ckdt['sts'] == "Y") ? "N" : "Y";
	mysqli_query($koneksi, "UPDATE cbt_pktsoal SET sts = '$new_sts' WHERE id_pktsoal = '$dt' LIMIT 1;");
	echo $new_sts;
} elseif ($_REQUEST['pr'] == "clear") {
	// $dt = $_GET['dt'];
	$pkt	= $_GET['ds'];
	$dtpkt			= mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM cbt_pktsoal WHERE id_pktsoal = '$pkt'"));
	$dlsoal			= mysqli_query($koneksi, "DELETE FROM cbt_soal WHERE cbt_soal.kd_soal = '$dtpkt[kd_soal]'");
	// $dlpktsoal	= mysqli_query($koneksi,"DELETE FROM cbt_pktsoal WHERE cbt_pktsoal.id_pktsoal = '$pkt'");
	if ($dlsoal) {
		echo '<meta http-equiv="refresh" content="0;url=../?md=esoal&ds=' . $pkt . '">';
	}
	// else {
	// 	echo '<meta http-equiv="refresh" content="0;url=../?md=soal">';
	// }
}
// ===============================AKHIR BANK SOAL=============================== //

// =================================JADWAL================================== //
// elseif ($_REQUEST['pr'] == "stsjd") {
// 	$dt = $_GET['dt'];
// 	$ckdt = mysqli_fetch_array(mysqli_query($koneksi, "SELECT sts FROM cbt_pktsoal WHERE cbt_pktsoal.id_pktsoal = '$dt';"));
// 	if ($ckdt['sts'] == "Y") {
// 		mysqli_query($koneksi, "UPDATE cbt_pktsoal SET sts = 'N' WHERE cbt_pktsoal.id_pktsoal = '$dt';");

// 		echo '<meta http-equiv="refresh" content="0;url=../?md=uj_set">';
// 	} else {
// 		mysqli_query($koneksi, "UPDATE cbt_pktsoal SET sts = 'Y' WHERE cbt_pktsoal.id_pktsoal = '$dt';");

// 		echo '<meta http-equiv="refresh" content="0;url=../?md=uj_set">';
// 	}
// }
// ==============================AKHIR JADWAL=============================== //




// =============================== Uji Aktif =============================== //
elseif ($_REQUEST['pr'] == "uj_edt_ljk") {
	$nos = $_POST['nos'];
	$nou = $_POST['nou'];
	$usr = $_POST['usr'];
	$kds = $_POST['kds'];
	$tkn = $_POST['tk'];

	$djdwl = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM jdwl WHERE kd_soal='$kds' AND token = '$tkn'"));
	$d_soal = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * From cbt_soal WHERE kd_soal='$kds' AND no_soal ='$nou'"));

	// Fungsi untuk menghasilkan opsi jawaban
	$generateOptions = function ($acak = false) {
		$options = ["1", "2", "3", "4", "5"];
		if ($acak) shuffle($options);
		return $options;
	};

	// Fungsi untuk mendapatkan kunci jawaban
	$getAnswerKey = function ($koneksi, $kds, $no_soal) {
		$keyData = mysqli_fetch_assoc(
			mysqli_query($koneksi, "SELECT knci_pilgan AS jwbn, jns_soal FROM cbt_soal WHERE kd_soal='$kds' AND no_soal='$no_soal'")
		);
		return $keyData['jns_soal'] === "G" ? $keyData['jwbn'] : "";
	};


	$options = $generateOptions($d_soal['ack_opsi'] === "Y");
	[$A, $B, $C, $D, $E] = $options;
	$key = $getAnswerKey($koneksi, $kds, $nos);


	// UPDATE cbt_ljk SET no_soal = '23', jns_soal = 'J', pl_a = '2', pl_v = '3', A = '1', B = '3', C = '2', D = '5', E = '4', jwbn = '2', nil_jwb = '9', knci_jwbn = '5', nil_pg = '2' WHERE user_jawab='25-1030' AND urut='16' AND token='SERIUS' AND kd_soal='SIMULASI ASAS';
	$qr_up = "UPDATE cbt_ljk SET no_soal = '$nou', jns_soal = '$d_soal[jns_soal]', pl_a = '$djdwl[pl_m]', pl_v = '$djdwl[pl_m]', A = '$A', B = '$B', C = '$C', D = '$D', E = '$E', jwbn = 'N', nil_jwb = '0', knci_jwbn = '$d_soal[knci_pilgan]', nil_pg = '0', es_jwb = '', nil_esai = '0' WHERE user_jawab='$usr' AND urut = '$nos' AND token = '$tkn' AND kd_soal = '$kds';";
	if ($koneksi->query($qr_up) == true) {
		// echo ' Soal nomor ' . $nou . ' berhasil diupdate menjadi ' . $nos . '.';
		echo $d_soal['tanya'];
	} else {
		echo 'Gagal mengupdate soal nomor ' . $nou . '.';
	}
} elseif ($_REQUEST['pr'] == "uj_add_ljk") {
	$nos = $_POST['nos'];
	$nou = $_POST['nou'];
	$usr = $_POST['usr'];
	$kds = $_POST['kds'];
	$tkn = $_POST['tk'];

	$djdwl = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM jdwl WHERE kd_soal='$kds' AND token = '$tkn'"));
	$d_soal = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * From cbt_soal WHERE kd_soal='$kds' AND no_soal ='$nou'"));
	$d_sis = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM cbt_peserta WHERE user='$usr'"));
	$d_kls = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM kelas WHERE kd_kls='$d_sis[kd_kls]'"));
	$d_pkt = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM cbt_pktsoal WHERE kd_soal='$kds'"));

	// Fungsi untuk menghasilkan opsi jawaban
	$generateOptions = function ($acak = false) {
		$options = ["1", "2", "3", "4", "5"];
		if ($acak) shuffle($options);
		return $options;
	};

	// Fungsi untuk mendapatkan kunci jawaban
	$getAnswerKey = function ($koneksi, $kds, $no_soal) {
		$keyData = mysqli_fetch_assoc(
			mysqli_query($koneksi, "SELECT knci_pilgan AS jwbn, jns_soal FROM cbt_soal WHERE kd_soal='$kds' AND no_soal='$no_soal'")
		);
		return $keyData['jns_soal'] === "G" ? $keyData['jwbn'] : "";
	};


	// INSERT INTO cbt_ljk (id, urut, user_jawab, token, kd_soal, no_soal, jns_soal, kd_mapel, pl_a, pl_v, kd_kls, kd_jur, A, B, C, D, E, jwbn, nil_jwb, knci_jwbn, nil_pg, es_jwb, nil_esai, tgl, jam) VALUES (NULL, '20', '25-1030', 'SERIUS', 'SIMULASI ASAS', '20', 'G', 'SISMUL', '0', '0', 'M12A', 'Merderka', '5', '4', '2', '1', '3', 'N', '0', '2', '0', '', '0', '2025-06-05', '08:00:13');
	// INSERT INTO cbt_ljk (id, urut, user_jawab, token, kd_soal, no_soal, jns_soal, kd_mapel, pl_a, pl_v, kd_kls, kd_jur, A, B, C, D, E, jwbn, nil_jwb, knci_jwbn, nil_pg, es_jwb, nil_esai, tgl, jam) VALUES (NULL, '$nos', '$usr', '$tkn', '$kds', '$nou', '$d_soal[jns_soal]', '$d_pkt[kd_mpel]', '$djdwl[pl_m]', '$djdwl[pl_m]', '$d_sis[kd_kls]', '$d_kls[jur]', '5', '4', '2', '1', '3', 'N', '0', '2', '0', '', '0', '2025-06-05', '08:00:13');
	$options = $generateOptions($d_soal['ack_opsi'] === "Y");
	[$A, $B, $C, $D, $E] = $options;
	$key = $getAnswerKey($koneksi, $kds, $nos);

	// $qr_add = "INSERT INTO cbt_ljk (urut, user_jawab, token, kd_soal, no_soal, jns_soal, pl_a, pl_v, kd_kls, kd_jur, A, B, C, D, E, jwbn, nil_jwb, knci_jwbn, nil_pg, es_jwb, nil_esai) VALUES ('$nos', '$usr', '$tkn', '$kds', '$nou', '$d_soal[jns_soal]', '$djdwl[pl_m]', '$djdwl[pl_m]', '$d_kls[kd_kls]', '$d_kls[jur]', '$A', '$B', '$C', '$D', '$E', 'N', '0', '$key', '0', '', '0');";
	$qr_add = "INSERT INTO cbt_ljk (id, urut, user_jawab, token, kd_soal, no_soal, jns_soal, kd_mapel, pl_a, pl_v, kd_kls, kd_jur, A, B, C, D, E, jwbn, nil_jwb, knci_jwbn, nil_pg, es_jwb, nil_esai) VALUES (NULL, '$nos', '$usr', '$tkn', '$kds', '$nou', '$d_soal[jns_soal]', '$d_pkt[kd_mpel]', '$djdwl[pl_m]', '$djdwl[pl_m]', '$d_sis[kd_kls]', '$d_kls[jur]', '$A', '$B', '$C', '$D', '$E', 'N', '0', '$key', '0', '', '0');";
	if ($koneksi->query($qr_add) == true) {
		// echo ' Soal nomor ' . $nou . ' berhasil ditambahkan.';
		echo $d_soal['tanya'];
	} else {
		echo 'Gagal menambahkan soal nomor ' . $nou . '.';
	}
} elseif ($_REQUEST['pr'] == "uj_del_ljk") {
	$nos = $_POST['nos'];
	$usr = $_POST['usr'];
	$kds = $_POST['kds'];
	$tkn = $_POST['tk'];

	// DELETE FROM cbt_ljk WHERE user_jawab='25-1030' AND urut='16' AND token='SERIUS' AND kd_soal='SIMULASI ASAS';
	$qr_del = "DELETE FROM cbt_ljk WHERE user_jawab='$usr' AND urut='$nos' AND token='$tkn' AND kd_soal='$kds';";
	if ($koneksi->query($qr_del) == true) {
		echo 'ok';
	} else {
		echo 'Gagal menghapus soal nomor ' . $nos . '.';
	}
} elseif ($_REQUEST['pr'] == "uj_psn") {
	// echo $_POST['keu'] . " " . $_POST['dru'] . " " . $_POST['psn'];

	$keu = $_POST['keu'];
	$dru = $_POST['dru'];
	$psn = $_POST['psn'];

	if (mysqli_num_rows(mysqli_query($koneksi, "SELECT 1 FROM psn WHERE ke = '$keu'")) == 0) {
		$sql = "INSERT INTO psn (ke, dr, psn, tgl, jam) VALUES ('$keu', '$dru', '$psn', CURRENT_DATE, CURRENT_TIME)";
	} else {
		$sql = "UPDATE psn SET dr = '$dru', psn = '$psn', tgl = CURRENT_DATE, jam = CURRENT_TIME WHERE ke = '$keu'";
	}

	if ($koneksi->query($sql) === true) {
		echo "Pesan Terkirim!";
	} else {
		echo "Gagal mengirim pesan.";
	}
} elseif ($_REQUEST['pr'] == "uj_time") {
	$wkt = menitToJam($_POST['jm'], '00:00:00') ?? '00:00:00';
	$kds = $_POST['kds'];
	$tkn = $_POST['tkn'];
	$aut = $_POST['aut'];

	if ($_POST['jm'] == '') {
		$jm = 'Tidak ada tambahan waktu yang diberikan.';
	} else {
		$jm = 'Tambahan waktu sebanyak <b>' . menitToJam($_POST['jm']) . '</b> menit telah diberikan.';
	}

	// UPDATE jdwl SET jm_tmbh = '01:00:00' WHERE kd_soal = 'SIMULASI ASAS' AND token = 'SERIUS' AND author = '25-1030';
	$qr_up = "UPDATE jdwl SET jm_tmbh = '$wkt' WHERE kd_soal = '$kds' AND token = '$tkn' AND author = '$aut';";
	if ($koneksi->query($qr_up) === true) {
		echo  $jm;
	}
}
// ============================ Akhir Uji Aktif ============================ //


// ============================ Brita Acara ============================ //
elseif ($_REQUEST['pr'] == "data") {
	$username = $_POST['user'];

	$qr =  "SELECT * FROM cbt_peserta WHERE user = '$username'";
	if (mysqli_num_rows(mysqli_query($koneksi, $qr)) == 0) {
		echo "0";
		return;
	} else {
		$data = mysqli_fetch_array(mysqli_query($koneksi, $qr));
		echo $data['nm'];
		return;
	}
}
