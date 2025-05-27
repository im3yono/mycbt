<?php
include_once("../../config/server.php");
include_once("../../config/server_m.php");

// ======================== API daftar Kelas ======================== //

// SELECT * FROM `kelas`
if ($_POST['td'] == "kelas") {
	$qr_sm_kls = mysqli_query($sm_kon, "SELECT * FROM `kelas`");
	$total_data = mysqli_num_rows($qr_sm_kls);
	$current = 0;

	while ($row = mysqli_fetch_array($qr_sm_kls)) {
		$current++;

		$qr_sc_kls = mysqli_query($koneksi, "SELECT * FROM `kelas` WHERE id_kls = '$row[id_kls]'");
		$row_sc_kls = mysqli_num_rows($qr_sc_kls);

		if ($row_sc_kls > 0) {
			$qr = "UPDATE `kelas` SET kd_kls = '$row[kd_kls]', `nm_kls` = '$row[nm_kls]', kls = '$row[kls]', jur = '$row[jur]', kls_minat ='$row[kls_minat]', sts = '$row[sts]' WHERE `kelas`.`id_kls` = '$row[id_kls]';";
		} else {
			$qr = "INSERT INTO `kelas` (`id_kls`, `kd_kls`, `nm_kls`, kls, jur, kls_minat, sts) VALUES ($row[id_kls], '$row[kd_kls]', '$row[nm_kls]', '$row[kls]', '$row[jur]', '$row[kls_minat]', '$row[sts]');";
		}

		mysqli_query($koneksi, $qr);
	}
	echo $current;
}
// ======================== API daftar Peserta Tes ======================== //

// SELECT * FROM `peserta_tes`
if ($_POST['td'] == "peserta") {
	$qr_sm_peserta = mysqli_query($sm_kon, "SELECT * FROM `cbt_peserta`");
	$total_data = mysqli_num_rows($qr_sm_peserta);
	$current = 0;

	while ($row = mysqli_fetch_array($qr_sm_peserta)) {
		$current++;

		$qr_sc_peserta = mysqli_query($koneksi, "SELECT * FROM `cbt_peserta` WHERE id_peserta = '$row[id_peserta]'");
		$row_sc_peserta = mysqli_num_rows($qr_sc_peserta);

		if ($row_sc_peserta > 0) {
			// UPDATE `cbt_peserta` SET `ip_sv` = '192.168.100.1', `nm` = 'Peserta 1o', `tmp_lahir` = 'Sungai Tabuk1', `tgl_lahir` = '2025-03-07', `kd_kls` = 'XB', `jns_kel` = 'P', `ft` = 'noavatar.jpg', `user` = 'XA-01a', `pass` = '123a', `sesi` = '11', `ruang` = '11', `sts` = 'N' WHERE `cbt_peserta`.`id_peserta` = 1;
			$qr = "UPDATE `cbt_peserta` SET `ip_sv` = '$row[ip_sv]', `nm` = '" . addslashes($row['nm']) . "', `tmp_lahir` = '$row[tmp_lahir]', `tgl_lahir` = '$row[tgl_lahir]', `nis` = '$row[nis]', `kd_kls` = '$row[kd_kls]', `jns_kel` = '$row[jns_kel]', `ft` = '$row[ft]', `user` = '$row[user]', `pass` = '$row[pass]', `sesi` = '$row[sesi]', `ruang` = '$row[ruang]', `sts` = '$row[sts]' WHERE `cbt_peserta`.`id_peserta` = '$row[id_peserta]';";
		} else {
			// INSERT INTO `cbt_peserta` (`id_peserta`, `ip_sv`, `nm`, `tmp_lahir`, `tgl_lahir`, `nis`, `kd_kls`, `jns_kel`, `ft`, `user`, `pass`, `sesi`, `ruang`, `sts`) VALUES (NULL, '192.168.100.1', 'Peserta 1o', 'Sungai Tabuk1', '2025-03-06', 'XA-01', 'XIIC', 'P', 'noavatar.png', 'XA-21', '123a', '1', '1', 'Y');
			$qr = "INSERT INTO `cbt_peserta` (`id_peserta`, `ip_sv`, `nm`, `tmp_lahir`, `tgl_lahir`, `nis`, `kd_kls`, `jns_kel`, `ft`, `user`, `pass`, `sesi`, `ruang`, `sts`) VALUES ('$row[id_peserta]', '$row[ip_sv]', '" . addslashes($row['nm']) . "', '$row[tmp_lahir]', '$row[tgl_lahir]', '$row[nis]', '$row[kd_kls]', '$row[jns_kel]', '$row[ft]', '$row[user]', '$row[pass]', '$row[sesi]', '$row[ruang]', '$row[sts]');";
		}
		mysqli_query($koneksi, $qr);
	}
	echo $current;
}
// ======================== API daftar Mata Pelajaran ======================== //

// SELECT * FROM `mapel`

if ($_POST['td'] == "mapel") {
	$qr_sm_mapel = mysqli_query($sm_kon, "SELECT * FROM `mapel`");
	$total_data = mysqli_num_rows($qr_sm_mapel);
	$current = 0;

	while ($row = mysqli_fetch_array($qr_sm_mapel)) {
		$current++;

		$qr_sc_mapel = mysqli_query($koneksi, "SELECT * FROM `mapel` WHERE id_mpel = '$row[id_mpel]'");
		$row_sc_mapel = mysqli_num_rows($qr_sc_mapel);

		if (!empty($row_sc_mapel)) {
			// UPDATE `mapel` SET `kd_mpel` = 'COBAi', `nm_mpel` = 'Percobaani', `kkm` = '20', `kls` = '12', `jur` = '12', `kls_minat` = '12', `sts` = 'N' WHERE `mapel`.`id_mpel` = 7;
			$qr = "UPDATE `mapel` SET `kd_mpel` = '$row[kd_mpel]', `nm_mpel` = '" . addslashes($row['nm_mpel']) . "', `kkm` = '$row[kkm]', `kls` = '$row[kls]', `jur` = '$row[jur]', `kls_minat` = '$row[kls_minat]', `sts` = '$row[sts]' WHERE `mapel`.`id_mpel` = '$row[id_mpel]';";
		} else {
			// INSERT INTO `mapel` (`id_mpel`, `kd_mpel`, `nm_mpel`, `kkm`, `kls`, `jur`, `kls_minat`, `sts`) VALUES (NULL, '123', '123', '12', '12', '123', '123', 'Y');
			$qr = "INSERT INTO `mapel` (`id_mpel`, `kd_mpel`, `nm_mpel`, `kkm`, `kls`, `jur`, `kls_minat`, `sts`) VALUES ('$row[id_mpel]', '$row[kd_mpel]', '" . addslashes($row['nm_mpel']) . "', '$row[kkm]', '$row[kls]', '$row[jur]', '$row[kls_minat]', '$row[sts]');";
		}
		mysqli_query($koneksi, $qr);
	}
	echo $current;
}
// ======================== API daftar Paket Soal ======================== //

// SELECT * FROM `cbt_pktsoal`

if ($_POST['td'] == "p_soal") {
	$qr_sm_pktsoal = mysqli_query($sm_kon, "SELECT * FROM `cbt_pktsoal`");
	$total_data = mysqli_num_rows($qr_sm_pktsoal);
	$current = 0;

	while ($row = mysqli_fetch_array($qr_sm_pktsoal)) {
		$current++;

		$qr_sc_pktsoal = mysqli_query($koneksi, "SELECT * FROM `cbt_pktsoal` WHERE id_pktsoal = '$row[id_pktsoal]'");
		$row_sc_pktsoal = mysqli_num_rows($qr_sc_pktsoal);

		if (($row_sc_pktsoal) > 0) {
			// UPDATE `cbt_pktsoal` SET `kd_kls` = '11', `kls` = '11', `jur` = '11', `kd_mpel` = 'COBA1', `kd_soal` = 'TES1', `sesi` = '11', `pilgan` = '151', `prsen_pilgan` = '601', `esai` = '51', `prsen_esai` = '401', `jum_soal` = '201', `kkm` = '701', `tgl` = '2024-08-06', `author` = 'Triyono1', `sts` = 'Y' WHERE `cbt_pktsoal`.`id_pktsoal` = 1;
			$qr = "UPDATE `cbt_pktsoal` SET `kd_kls` = '$row[kd_kls]', `kls` = '$row[kls]', `jur` = '$row[jur]', `kd_mpel` = '$row[kd_mpel]', `kd_soal` = '$row[kd_soal]', `sesi` = '$row[sesi]', `pilgan` = '$row[pilgan]', `prsen_pilgan` = '$row[prsen_pilgan]', `esai` = '$row[esai]', `prsen_esai` = '$row[prsen_esai]', `jum_soal` = '$row[jum_soal]', `kkm` = '$row[kkm]', `tgl` = '$row[tgl]', `author` = '" . addslashes($row['author']) . "', `sts` = '$row[sts]' WHERE `cbt_pktsoal`.`id_pktsoal` = '$row[id_pktsoal]';";
		} else {
			// INSERT INTO `cbt_pktsoal` (`id_pktsoal`, `kd_kls`, `kls`, `jur`, `kd_mpel`, `kd_soal`, `sesi`, `pilgan`, `prsen_pilgan`, `esai`, `prsen_esai`, `jum_soal`, `kkm`, `tgl`, `author`, `sts`) VALUES (NULL, '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', current_timestamp(), '1', 'Y');
			$qr = "INSERT INTO `cbt_pktsoal` (`id_pktsoal`, `kd_kls`, `kls`, `jur`, `kd_mpel`, `kd_soal`, `sesi`, `pilgan`, `prsen_pilgan`, `esai`, `prsen_esai`, `jum_soal`, `kkm`, `tgl`, `author`, `sts`) VALUES ('$row[id_pktsoal]', '$row[kd_kls]', '$row[kls]', '$row[jur]', '$row[kd_mpel]', '$row[kd_soal]', '$row[sesi]', '$row[pilgan]', '$row[prsen_pilgan]', '$row[esai]', '$row[prsen_esai]', '$row[jum_soal]', '$row[kkm]', '$row[tgl]', '" . addslashes($row['author']) . "', '$row[sts]');";
		}
		mysqli_query($koneksi, $qr);
	}
	echo $current;
}

// ======================== API daftar Soal ======================== //
if ($_POST['td'] == "soal") {
	// SELECT * FROM `cbt_soal`

	$qr_sm_soal = mysqli_query($sm_kon, "SELECT * FROM `cbt_soal`");
	$total_data = mysqli_num_rows($qr_sm_soal);
	$current = 0;

	while ($row = mysqli_fetch_array($qr_sm_soal)) {
		$current++;

		$qr_sc_soal = mysqli_query($koneksi, "SELECT * FROM `cbt_soal` WHERE id_soal = '$row[id_soal]'");
		$row_sc_soal = mysqli_num_rows($qr_sc_soal);

		if (($row_sc_soal) > 0) {
			// UPDATE cbt_soal SET kd_mapel = '$kmpl[kd_mpel]', jns_soal = '$jns', lev_soal = '$ktg', kd_crta='$kd_crt', cerita = '$des', tanya = '$tanya', img = '$ft0', audio = '$taud', vid = '$tvid', jwb1 = '$opsi1', jwb2 = '$opsi2', jwb3 = '$opsi3', jwb4 = '$opsi4', jwb5 = '$opsi5', img1 = '$ft1', img2 = '$ft2', img3 = '$ft3', img4 = '$ft4', img5 = '$ft5', knci_pilgan = '$key', ack_soal = '$asoal', ack_opsi = '$aopsi' WHERE cbt_soal.no_soal = '$nos' AND cbt_soal.kd_soal = '$kds';
			$qr = "UPDATE cbt_soal SET 
			kd_soal 	= '$row[kd_soal]', 
			kd_mapel 	= '$row[kd_mapel]', 
			jns_soal 	= '$row[jns_soal]', 
			lev_soal 	= '$row[lev_soal]', 
			no_soal 	= '$row[no_soal]', 
			kd_crta 	= '$row[kd_crta]', 
			cerita 	= '" . addslashes($row['cerita']) . "', 
			tanya 	= '" . addslashes($row['tanya']) . "', 
			img 		= '$row[img]', 
			audio 	= '$row[audio]', 
			vid 		= '$row[vid]', 
			jwb1 		= '" . addslashes($row['jwb1']) . "', 
			jwb2 		= '" . addslashes($row['jwb2']) . "', 
			jwb3 		= '" . addslashes($row['jwb3']) . "', 
			jwb4 		= '" . addslashes($row['jwb4']) . "', 
			jwb5 		= '" . addslashes($row['jwb5']) . "', 
			img1 		= '$row[img1]', 
			img2 		= '$row[img2]', 
			img3 		= '$row[img3]', 
			img4 		= '$row[img4]', 
			img5 		= '$row[img5]', 
			knci_pilgan 	= '$row[knci_pilgan]', 
			ack_soal 			= '$row[ack_soal]', 
			ack_opsi 			= '$row[ack_opsi]' 
			WHERE id_soal = '$row[id_soal]';";
		} else {
			// INSERT INTO cbt_soal (id_soal, kd_soal, kd_mapel, jns_soal, lev_soal, no_soal, cerita, kd_crta, tanya, img, audio, vid, jwb1, jwb2, jwb3, jwb4, jwb5, img1, img2, img3, img4, img5, knci_pilgan, ack_soal, ack_opsi) VALUES (NULL, '$kds', '$kmpl[kd_mpel]', '$jns', '$ktg', '$nos', '$des', '$kd_crt', '$tanya', '$ft0', '$taud', '$tvid', '$opsi1', '$opsi2', '$opsi3', '$opsi4', '$opsi5', '$ft1', '$ft2', '$ft3', '$ft4', '$ft5', '$key', '$asoal', '$aopsi');
			$qr = "INSERT INTO cbt_soal (id_soal, kd_soal, kd_mapel, jns_soal, lev_soal, no_soal, cerita, kd_crta, tanya, img, audio, vid, jwb1, jwb2, jwb3, jwb4, jwb5, img1, img2, img3, img4, img5, knci_pilgan, ack_soal, ack_opsi) VALUES (
			'$row[id_soal]', 
			'$row[kd_soal]', 
			'$row[kd_mapel]', 
			'$row[jns_soal]', 
			'$row[lev_soal]', 
			'$row[no_soal]', 
			'" . addslashes($row['cerita']) . "', 
			'$row[kd_crta]', 
			'" . addslashes($row['tanya']) . "', 
			'$row[img]', 
			'$row[audio]', 
			'$row[vid]', 
			'" . addslashes($row['jwb1']) . "', 
			'" . addslashes($row['jwb2']) . "', 
			'" . addslashes($row['jwb3']) . "', 
			'" . addslashes($row['jwb4']) . "', 
			'" . addslashes($row['jwb5']) . "', 
			'$row[img1]', 
			'$row[img2]', 
			'$row[img3]', 
			'$row[img4]', 
			'$row[img5]', 
			'$row[knci_pilgan]', 
			'$row[ack_soal]', 
			'$row[ack_opsi]');";
		}
		mysqli_query($koneksi, $qr);
	}
	echo $current;
}

// ======================== API daftar gambar ======================== //

if ($_POST['td'] == "dfile") {
	// URL API yang menyediakan daftar gambar
	$api_url = $server_ms['ip_sv'] . '/' . $server_ms['fdr'] . '/api/images.php'; // Ganti dengan URL API kamu

	// Folder tujuan penyimpanan gambar
	$save_folder = "../../images/"; // Pastikan folder ini ada dan memiliki izin tulis

	// Pastikan folder tujuan ada
	if (!is_dir($save_folder)) {
		mkdir($save_folder, 0777, true); // Buat folder jika belum ada
	}

	// Ambil data dari API
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $api_url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$json_data = curl_exec($ch);
	curl_close($ch);

	// Decode JSON ke array
	$response = json_decode($json_data, true);

	if ($response && isset($response['images'])) {
		$current2 = 0;
		foreach ($response['images'] as $image) {
			$image_url = $server_ms['ip_sv'] . $image['url']; // URL gambar dari API

			$image_name = basename(str_replace('%20', ' ', $image_url)); // Nama file gambar
			$img_url = str_replace('\/', '/', $image_url); // Nama file gambar

			// Path penyimpanan di server
			$save_path = $save_folder . $image_name;

			// Download gambar menggunakan cURL
			$ch = curl_init($img_url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_BINARYTRANSFER, true); // Pastikan file dalam format biner
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // Ikuti redirect jika ada
			$image_data = curl_exec($ch);
			curl_close($ch);


			// Simpan gambar ke folder tujuan
			if ($image_data !== false) {
				file_put_contents($save_path, $image_data);
				// 	echo "✅ Gambar tersimpan";
				// } else {
				// 	echo "❌ Gagal Gambar tersimpan";
			}
			// echo $img_url;
			$current2++;
		}
	} else {
		echo "Gagal mengambil daftar gambar dari API.";
	}
	// echo $response['total_images'];
	echo $current2;
}

// ======================== API Daftar User ======================== //

if ($_POST['td'] == "user") {
	$qr_sm_user = mysqli_query($sm_kon, "SELECT * FROM `user`");
	$total_data = mysqli_num_rows($qr_sm_user);
	$current = 0;

	while ($row = mysqli_fetch_array($qr_sm_user)) {
		$current++;

		$qr_sc_user = mysqli_query($koneksi, "SELECT * FROM `user` WHERE id_user = '$row[id_user]'");
		$row_sc_user = mysqli_num_rows($qr_sc_user);

		if ($row_sc_user > 0) {
			$qr = "UPDATE `user` SET `kd_usr` = '$row[kd_usr]', `nm_user` = '$row[nm_user]', `username` = '$row[username]', `pass` = '$row[pass]', `tlp`= '$row[tlp]', `lvl` = '$row[lvl]', `sts` = '$row[sts]' WHERE `user`.`id_usr` = '$row[id_usr]';";
		} else {
			$qr = "INSERT INTO `user` (`id_usr`, `kd_usr', `nm_user`, `user`, `pass`, `lvl`, `sts`) VALUES ('$row[id_usr]', '$row[kd_usr]', '$row[nm_user]', '$row[user]', '$row[pass]', '$row[lvl]', '$row[sts]');";
		}
		if ($row['id_user'] != 1) {
			mysqli_query($koneksi, $qr);
		}
	}
	echo $current;
}

// ======================== API Daftar Jadwal ======================== //

if ($_POST['td'] == "jdwl") {
	// SELECT * FROM `jdwl`

	$qr_sm_soal = mysqli_query($sm_kon, "SELECT * FROM `jdwl`");
	$total_data = mysqli_num_rows($qr_sm_soal);
	$current2 = 0;

	while ($row = mysqli_fetch_array($qr_sm_soal)) {
		$current2++;

		$qr_sc_soal = mysqli_query($koneksi, "SELECT * FROM `jdwl` WHERE id_ujian = '$row[id_ujian]'");
		$row_sc_soal = mysqli_num_rows($qr_sc_soal);

		if (($row_sc_soal) > 0) {
			$qr = "UPDATE jdwl SET 
			kd_ujian 	= '$row[kd_ujian]', 
			kls 			= '$row[kls]', 
			kd_kls 		= '$row[kd_kls]', 
			jur 			= '$row[jur]', 
			nm_kls 		= '$row[nm_kls]', 
			kd_mpel 	= '$row[kd_mpel]', 
			jm_login 	= '$row[jm_login]', 
			tgl_uji 	= '$row[tgl_uji]', 
			jm_uji 		= '$row[jm_uji]', 
			slsai_uji	= '$row[slsai_uji]', 
			bts_login = '$row[bts_login]', 
			lm_uji 		= '$row[lm_uji]', 
			author 		= '$row[author]', 
			thn_ajr 	= '$row[thn_ajr]', 
			sesi 			= '$row[sesi]', 
			sts 			= '$row[sts]', 
			sts_token = '$row[sts_token]', 
			sts_nilai = '$row[sts_nilai]', 
			md_uji 		= '$row[md_uji]' 
			WHERE jdwl.kd_soal = '$row[kd_soal]' AND jdwl.token = '$row[token]';";
		} else {
			$qr = "INSERT INTO jdwl 
			(id_ujian, kd_ujian, smt, kls, kd_kls, jur, nm_kls, kd_mpel, kd_soal, jm_login, tgl_uji, jm_uji, slsai_uji, bts_login, lm_uji, token, author, thn_ajr, user, sesi, sts, sts_token, sts_nilai, md_uji) 
			VALUES 
			('$row[id_ujian]', '$row[kd_ujian]', '1', '$row[kls]', '$row[kd_kls]', '$row[jur]', '', '$row[kd_mpel]', '$row[kd_soal]', '', '$row[tgl_uji]', '$row[jm_uji]', '$row[slsai_uji]', '$row[bts_login]', '$row[lm_uji]', '$row[token]', '$row[author]', '$row[thn_ajr]', '', '$row[sesi]', 'Y', '$row[sts_token]', '$row[sts_nilai]', '$row[md_uji]');";
		} 
		mysqli_query($koneksi, $qr);
		mysqli_query($koneksi, "UPDATE `cbt_pktsoal` SET `sts` = 'Y' WHERE `cbt_pktsoal`.`kd_soal` = '$row[kd_soal]';");
	}
	echo $current2;
}
