<?php

if (empty($_COOKIE['user'])) {
	header('location:/' . $fd_root . '/');
} else {
	$userlg	= $_COOKIE['user'];
	$token	= $_POST['kt'];
	$kds		= $_POST['kds'];
	$ip			= $_POST['ip'];
}

$dtps_uji	= mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM cbt_peserta WHERE user ='$userlg'"));
$dtkls		= mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM kelas WHERE kd_kls='$dtps_uji[kd_kls]'"));
$dtjdwl		= mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM jdwl WHERE token='$token' AND kd_soal='$kds'"));


// ===========================================...CEK LEMBAR JAWABAN...=========================================== //
$dtpkt		= mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM cbt_pktsoal WHERE kd_soal='$kds'"));

$jum_soal	= $dtpkt['jum_soal'];
$jum_pg		= $dtpkt['pilgan'];
$jum_es		= $dtpkt['esai'];

$ljk_cek	= mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM cbt_ljk WHERE user_jawab='$userlg' AND token='$token' AND kd_soal='$kds'"));
$uji_cek	= mysqli_query($koneksi, "SELECT * FROM peserta_tes WHERE user='$userlg' AND token='$token' AND kd_soal='$kds'");
$ip_cek		= mysqli_fetch_array($uji_cek);

// Tambahkan data ke tabel peserta_tes jika belum ada dan update ip jika ada
if (mysqli_num_rows($uji_cek) == 0) {
	$insert_tes = "INSERT INTO peserta_tes 
				(id_tes, id_ujian, kd_soal, user, sesi, ruang, nis, kd_kls, kd_mpel, pilgan, esai, jum_soal, tgl_uji, jm_uji, jm_lg, jm_out, lm_uji, token, ip, sts, dt_on)
				VALUES 
				(NULL, '$dtjdwl[id_ujian]', '$kds', '$userlg', '$dtps_uji[sesi]', '$dtps_uji[ruang]', '$dtps_uji[nis]', '$dtps_uji[kd_kls]', '$dtpkt[kd_mpel]', 
				'$dtpkt[pilgan]', '$dtpkt[esai]', '$dtpkt[jum_soal]', '$dtjdwl[tgl_uji]', '$dtjdwl[jm_uji]', CURRENT_TIME, '', '', '$token', '$ip', 'U', '0')";
	mysqli_query($koneksi, $insert_tes);
} else {
	if (empty($ip_cek['ip'])) {
		mysqli_query($koneksi, "UPDATE peserta_tes SET ip='$ip' WHERE user='$userlg' AND token='$token' AND kd_soal='$kds'");
	}
}

$nos	= 1;
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
	return $keyData['jns_soal'] === "G" ? $keyData['jwbn'] : "N";
};

// Fungsi untuk memasukkan data jika belum ada
$insertIfNotExists = function ($koneksi, $sql_lj, $userlg, $nos, $no_s, $kds, $token) {
	$check = mysqli_query($koneksi, "SELECT COUNT(*) AS jumlah FROM cbt_ljk WHERE user_jawab='$userlg' AND (urut='$nos' OR no_soal='$no_s') AND kd_soal='$kds' AND token='$token'");
	if (mysqli_fetch_assoc($check)['jumlah'] == 0) {
		mysqli_query($koneksi, $sql_lj);
	}
};

// Proses Validasi Pembuatan LJK
if (!isset($_COOKIE['n_soal'])) {
	if ($ljk_cek != $jum_soal) {
		$use_s = $jum_soal;

		// Ambil data soal
		$soal_query = mysqli_query($koneksi, "SELECT * FROM cbt_soal WHERE kd_soal='$kds' ORDER BY no_soal");
		$data_all 		= [];
		$data_ack 		= [];
		$data_tdkack 	= [];
		$data_es 			= [];
		$data_pg 			= [];

		while ($row = mysqli_fetch_array($soal_query)) {
			$data_all[] = $row;
			if ($row["ack_soal"] == "Y") {

				if ($row['jns_soal'] == 'G') {
					$data_pg[] = $row;
				} elseif ($row['jns_soal'] == 'E') {
					$data_es[] = $row;
				}

				// $data_ack[] = $row;
			} else {
				$data_tdkack[] = $row;
			}
		}

		// Batasi jumlah soal
		$soal_terpilih_essay = array_slice($data_es, 0, $jum_es); // Ambil sesuai data keperluan soal esai
		$soal_terpilih_pilihan_ganda = array_slice($data_pg, 0, $jum_pg); // Ambil sesuai data keperluan soal pilihan ganda
		$data_ack		= array_merge($soal_terpilih_essay, $soal_terpilih_pilihan_ganda);
		shuffle($data_ack);

		$no 	= 1;
		$nack	= 1;

		foreach ($data_all as $d_all) {

			// Proses untuk soal tidak acak
			if ($d_all['ack_soal'] === "N") {
				foreach ($data_tdkack as $notack) {
					if ($d_all["no_soal"] === $notack["no_soal"]) {
						$options = $generateOptions($notack['ack_opsi'] === "Y");
						[$A, $B, $C, $D, $E] = $options;
						$key = $getAnswerKey($koneksi, $kds, $notack["no_soal"]);

						$sql_lj = "INSERT INTO cbt_ljk 
                        (id, urut, user_jawab, token, kd_soal, no_soal, jns_soal, kd_mapel, kd_kls, kd_jur, A, B, C, D, E, jwbn, nil_jwb, knci_jwbn, nil_pg, es_jwb, nil_esai, tgl, jam) 
                        VALUES 
                        (NULL, '$nos', '$userlg', '$token', '$kds', '$notack[no_soal]', '$notack[jns_soal]', '$notack[kd_mapel]', '$dtkls[kd_kls]', '$dtkls[jur]', 
                        '$A', '$B', '$C', '$D', '$E', 'N', '0', '$key', '0', '', '0', CURRENT_DATE, CURRENT_TIME)";

						$insertIfNotExists($koneksi, $sql_lj, $userlg, $nos, $notack['no_soal'], $kds, $token);
						$nack++;
					}
				}
			}

			// Proses untuk soal acak
			if ($d_all['ack_soal'] === "Y") {
				foreach ($data_ack as $dt => $data) {
					if ($no === $dt + $nack) {
						$options = $generateOptions($data['ack_opsi'] === "Y");
						[$A, $B, $C, $D, $E] = $options;
						$key = $getAnswerKey($koneksi, $kds, $data["no_soal"]);

						$sql_lj = "INSERT INTO cbt_ljk 
                        (id, urut, user_jawab, token, kd_soal, no_soal, jns_soal, kd_mapel, kd_kls, kd_jur, A, B, C, D, E, jwbn, nil_jwb, knci_jwbn, nil_pg, es_jwb, nil_esai, tgl, jam) 
                        VALUES 
                        (NULL, '$nos', '$userlg', '$token', '$kds', '$data[no_soal]', '$data[jns_soal]', '$data[kd_mapel]', '$dtkls[kd_kls]', '$dtkls[jur]', 
                        '$A', '$B', '$C', '$D', '$E', 'N', '0', '$key', '0', '', '0', CURRENT_DATE, CURRENT_TIME)";

						$insertIfNotExists($koneksi, $sql_lj, $userlg, $nos, $data['no_soal'], $kds, $token);
					}
				}
			}

			if ($no == $use_s) break;

			$nos++;
			$no++;
		}
	} elseif (empty($ip_cek['ip'])) {
		mysqli_query($koneksi, "UPDATE peserta_tes SET ip='$ip' WHERE user='$userlg' AND token='$token' AND kd_soal='$kds'");
	}
} else {
	$n_soal = json_decode($_COOKIE['n_soal'], true);
	foreach ($n_soal as $no_s) {
		// Ambil data soal
		$d_soal = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM cbt_soal WHERE kd_soal='$kds' AND no_soal ='$no_s'"));

		$pl_m = $dtjdwl['pl_m'];
		$pl_a = $d_soal['audio'] ? $pl_m : '0';
		$pl_v = $d_soal['vid'] ? $pl_m : '0';

		$options = $generateOptions($d_soal['ack_opsi'] === "Y");
		[$A, $B, $C, $D, $E] = $options;
		$key = $getAnswerKey($koneksi, $kds, $no_s);

		$sql_lj = "INSERT INTO cbt_ljk 
		(id, urut, user_jawab, token, kd_soal, no_soal, jns_soal, kd_mapel, pl_a, pl_v, kd_kls, kd_jur, A, B, C, D, E, jwbn, nil_jwb, knci_jwbn, nil_pg, es_jwb, nil_esai, tgl, jam) VALUES (NULL, '$nos', '$userlg', '$token', '$kds', '$no_s', '$d_soal[jns_soal]', '$d_soal[kd_mapel]', '$pl_a', '$pl_v', '$dtkls[kd_kls]', '$dtkls[jur]', '$A', '$B', '$C', '$D', '$E', 'N', '0', '$key', '0', '', '0', CURRENT_DATE, CURRENT_TIME)";

		$insertIfNotExists($koneksi, $sql_lj, $userlg, $nos, $no_s, $kds, $token);
		$nos++;
	}
}
// ========================================...AKHIR CEK LEMBAR JAWABAN...======================================== //


// ============================================...WAKTU...============================================ //

$dt_usrlg0 = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM peserta_tes  WHERE user='$userlg' AND kd_soal='$kds' AND token ='$token'"));
if ($dt_usrlg0['jm_uji'] != $dtjdwl['jm_uji']) {
	$jm_up = date('H:i:s');
	mysqli_query($koneksi, "UPDATE peserta_tes SET jm_uji = '$dtjdwl[jm_uji]', jm_lg = '$jm_up' WHERE user='$userlg' AND kd_soal='$kds' AND token ='$token'");
}
$dt_usrlg = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM peserta_tes  WHERE user='$userlg' AND kd_soal='$kds' AND token ='$token'"));
if ($dtjdwl['jm_tmbh'] != "00:00:00") {
	list($tbh_jam, $tbh_menit, $tbh_detik) = explode(':', $dtjdwl['jm_tmbh']);
	if ($tbh_jam != "00") {
		$tbh_jam = $tbh_jam . ":";
	} else {
		$tbh_jam = "";
	}
	if ($tbh_menit != "00") {
		$tbh_menit = $tbh_menit . ":";
	} else {
		$tbh_menit = "";
	}
	if ($tbh_detik == "00") {
		$tbh_detik = "00";
	}

	$wkt_tambah = $tbh_jam . $tbh_menit . $tbh_detik;
}
if (!empty($dtjdwl['jm_uji'])) {
	if (strtotime($dtjdwl['bts_login']) > strtotime($dt_usrlg['jm_lg'])) {
		$jm_awal = $dt_usrlg['jm_lg'];
	} else {
		$jm_awal = $dtjdwl['jm_uji'];
	}
	// if (!empty($jm_up)) {
	// 	$waktu_awal		= $jm_up;
	// } else {
	// 	$waktu_awal		= $jm_awal;
	// }

	$waktu_awal    = $jm_awal;
	// $waktu_awal		= $dtjdwl['jm_uji'];
	$waktu_akhir  = $dtjdwl['lm_uji'];

	$awal  = strtotime(($waktu_awal));
	$akhir = strtotime(($waktu_akhir));
	// $awal  = strtotime("08:00:00");
	// $akhir = strtotime("02:00:00");
	$nos = strtotime("00:00:00");
	$diff  = ($awal - $nos) + ($akhir - $nos);

	$jam   = floor($diff / (60 * 60));
	$menit = $diff - ($jam * (60 * 60));
	$detik = $diff % 60;

	$jmak  = floor(($akhir - $nos) / (60 * 60));
	$minak = ($akhir - $nos) - ($jmak * (60 * 60));
	$batas = ($jmak * 60) + floor($minak / 60);

	$tgl = $dtjdwl['tgl_uji'];

	if ($jam > 23) {
		$jam1 =  $jam - 24;
		$tgl  = date('Y-m-d', strtotime('+1 days', strtotime($tgl)));
	} else {
		$jam1 =  $jam;
	}

	if ($jam1 < 10) {
		$jam1 = '0' . $jam1;
	}

	if ($menit < 600) {
		$menit1 =  '0' . floor($menit / 60);
	} else {
		$menit1 =  floor($menit / 60);
	}
	$jam_ak = $jam1 . ':' . $menit1;

	$wktu = $tgl . ' ' . $jam_ak . ':00';
}

if (!empty($dtps_uji['ft'])) {
	if ($dtps_uji['ft'] != 'noavatar.png') {
		$ft = "pic_sis/" . $dtps_uji['ft'];
	} else {
		$ft = "img/noavatar.png";
	}
} else {
	$ft = "img/noavatar.png";
}
// ========================================...AKHIR WAKTU...======================================== //



// .-------------------------------------------------------------------------------------------------------.
// |                                       Menghapus LJK doble Nomer                                       |
// '-------------------------------------------------------------------------------------------------------'

$ljk_cek2	= mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM cbt_ljk WHERE user_jawab='$userlg' AND token='$token' AND kd_soal='$kds'"));
if ($ljk_cek2 > $jum_soal) {
	$qrdel  = "DELETE FROM cbt_ljk WHERE id NOT IN (SELECT id FROM ( SELECT MIN(id) AS id FROM cbt_ljk WHERE user_jawab='$userlg' AND token='$token' AND kd_soal='$kds' GROUP BY urut) AS temp) AND user_jawab='$userlg' AND token='$token' AND kd_soal='$kds';";
	mysqli_query($koneksi, $qrdel);
	// echo '<div class="col-12 text-center p-2"><button type="button" class="btn btn-danger" id="ljk" name="ljk">Muat Ulang</button></div>';
}


// =============== CEK STATUS INTERNET =============== //
if ($dtjdwl['md_uji'] == '0') {
	require_once 'config/get_connected.php';
}
