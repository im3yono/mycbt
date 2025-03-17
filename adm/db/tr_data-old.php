<?php
include_once("../../config/server.php");

// ======================== API daftar Kelas ======================== //

// SELECT * FROM `kelas`

$qr_sm_kls = mysqli_query($sm_kon, "SELECT * FROM `kelas`");

while ($row = mysqli_fetch_array($qr_sm_kls)) {
	$qr_sc_kls = mysqli_query($koneksi, "SELECT * FROM `kelas` WHERE id_kls = '$row[id_kls]'");
	$row_sc_kls = mysqli_fetch_array($qr_sc_kls);

	if (!empty($row_sc_kls)) {
		// UPDATE `kelas` SET `nm_kls` = 'XII IPA 1', `kd_kls` = 'XII IPA 1', `kd_kls` = '1' WHERE `kelas`.`kd_kls` = 1;
		$qr = "UPDATE `kelas` SET kd_kls = '$row[kd_kls]', `nm_kls` = '$row[nm_kls]', kls = '$row[kls]', jur = '$row[jur]', kls_minat ='$row[kls_minat]', sts = '$row[sts]'  WHERE `kelas`.`id_kls` = '$row[id_kls]';";
		if (mysqli_query($koneksi, $qr)) {
			echo "✅ Kelas di rubah";
		} else {
			echo "❌ Gagal Kelas di rubah";
		}
	} else {
		// INSERT INTO `kelas` (`kd_kls`, `nm_kls`, `kd_kls`) VALUES ('1', 'XII IPA 1', 'XII IPA 1');
		$qr = "INSERT INTO `kelas` (`id_kls`, `kd_kls`, `nm_kls`, kls, jur, kls_minat, sts) VALUES (Null, '$row[kd_kls]', '$row[nm_kls]', '$row[kls]', '$row[jur]', '$row[kls_minat]', '$row[sts]');";
		if (mysqli_query($koneksi, $qr)) {
			echo "✅ Kelas tersimpan";
		} else {
			echo "❌ Gagal Kelas tersimpan";
		}
	}
}

// ======================== API daftar Peserta Tes ======================== //

// SELECT * FROM `peserta_tes`

$qr_sm_peserta = mysqli_query($sm_kon, "SELECT * FROM `cbt_peserta`");

while ($row = mysqli_fetch_array($qr_sm_peserta)) {
	$qr_sc_peserta = mysqli_query($koneksi, "SELECT * FROM `cbt_peserta` WHERE id_peserta = '$row[id_peserta]'");
	$row_sc_peserta = mysqli_num_rows($qr_sc_peserta);

	if (!empty($row_sc_peserta)) {
		// UPDATE `cbt_peserta` SET `ip_sv` = '192.168.100.1', `nm` = 'Peserta 1o', `tmp_lahir` = 'Sungai Tabuk1', `tgl_lahir` = '2025-03-07', `kd_kls` = 'XB', `jns_kel` = 'P', `ft` = 'noavatar.jpg', `user` = 'XA-01a', `pass` = '123a', `sesi` = '11', `ruang` = '11', `sts` = 'N' WHERE `cbt_peserta`.`id_peserta` = 1;
		$qr = "UPDATE `cbt_peserta` SET `ip_sv` = '$row[ip_sv]', `nm` = '".addslashes($row['nm'])."', `tmp_lahir` = '$row[tmp_lahir]', `tgl_lahir` = '$row[tgl_lahir]', `nis` = '$row[nis]', `kd_kls` = '$row[kd_kls]', `jns_kel` = '$row[jns_kel]', `ft` = '$row[ft]', `user` = '$row[user]', `pass` = '$row[pass]', `sesi` = '$row[sesi]', `ruang` = '$row[ruang]', `sts` = '$row[sts]' WHERE `cbt_peserta`.`id_peserta` = '$row[id_peserta]';";
		if (mysqli_query($koneksi, $qr)) {
			echo "✅ Peserta Tes di rubah";
		} else {
			echo "❌ Gagal Peserta Tes di rubah";
		}
	} else {
		// INSERT INTO `cbt_peserta` (`id_peserta`, `ip_sv`, `nm`, `tmp_lahir`, `tgl_lahir`, `nis`, `kd_kls`, `jns_kel`, `ft`, `user`, `pass`, `sesi`, `ruang`, `sts`) VALUES (NULL, '192.168.100.1', 'Peserta 1o', 'Sungai Tabuk1', '2025-03-06', 'XA-01', 'XIIC', 'P', 'noavatar.png', 'XA-21', '123a', '1', '1', 'Y');
		$qr = "INSERT INTO `cbt_peserta` (`id_peserta`, `ip_sv`, `nm`, `tmp_lahir`, `tgl_lahir`, `nis`, `kd_kls`, `jns_kel`, `ft`, `user`, `pass`, `sesi`, `ruang`, `sts`) VALUES (NULL, '$row[ip_sv]', '".addslashes($row['nm'])."', '$row[tmp_lahir]', '$row[tgl_lahir]', '$row[nis]', '$row[kd_kls]', '$row[jns_kel]', '$row[ft]', '$row[user]', '$row[pass]', '$row[sesi]', '$row[ruang]', '$row[sts]');";
		if (mysqli_query($koneksi, $qr)) {
			echo "✅ Peserta Tes tersimpan";
		} else {
			echo "❌ Gagal Peserta Tes tersimpan";
		}
	}
}

// ======================== API daftar Mata Pelajaran ======================== //

// SELECT * FROM `mapel`

$qr_sm_mapel = mysqli_query($sm_kon, "SELECT * FROM `mapel`");

while ($row = mysqli_fetch_array($qr_sm_mapel)) {
	$qr_sc_mapel = mysqli_query($koneksi, "SELECT * FROM `mapel` WHERE id_mpel = '$row[id_mpel]'");
	$row_sc_mapel = mysqli_num_rows($qr_sc_mapel);

	if (!empty($row_sc_mapel)) {
		// UPDATE `mapel` SET `kd_mpel` = 'COBAi', `nm_mpel` = 'Percobaani', `kkm` = '20', `kls` = '12', `jur` = '12', `kls_minat` = '12', `sts` = 'N' WHERE `mapel`.`id_mpel` = 7;
		$qr = "UPDATE `mapel` SET `kd_mpel` = '$row[kd_mpel]', `nm_mpel` = '".addslashes($row['nm_mpel'])."', `kkm` = '$row[kkm]', `kls` = '$row[kls]', `jur` = '$row[jur]', `kls_minat` = '$row[kls_minat]', `sts` = '$row[sts]' WHERE `mapel`.`id_mpel` = '$row[id_mpel]';";
		if (mysqli_query($koneksi, $qr)) {
			echo "✅ Mata Pelajaran di rubah";
		} else {
			echo "❌ Gagal Mata Pelajaran di rubah";
		}
	} else {
		// INSERT INTO `mapel` (`id_mpel`, `kd_mpel`, `nm_mpel`, `kkm`, `kls`, `jur`, `kls_minat`, `sts`) VALUES (NULL, '123', '123', '12', '12', '123', '123', 'Y');
		$qr = "INSERT INTO `mapel` (`id_mpel`, `kd_mpel`, `nm_mpel`, `kkm`, `kls`, `jur`, `kls_minat`, `sts`) VALUES (NULL, '$row[kd_mpel]', '".addslashes($row['nm_mpel'])."', '$row[kkm]', '$row[kls]', '$row[jur]', '$row[kls_minat]', '$row[sts]');";
		if (mysqli_query($koneksi, $qr)) {
			echo "✅ Mata Pelajaran tersimpan";
		} else {
			echo "❌ Gagal Mata Pelajaran tersimpan";
		}
	}
}

// ======================== API daftar Paket Soal ======================== //

// SELECT * FROM `cbt_pktsoal`

$qr_sm_pktsoal = mysqli_query($sm_kon, "SELECT * FROM `cbt_pktsoal`");

while ($row = mysqli_fetch_array($qr_sm_pktsoal)) {
	$qr_sc_pktsoal = mysqli_query($koneksi, "SELECT * FROM `cbt_pktsoal` WHERE id_pktsoal = '$row[id_pktsoal]'");
	$row_sc_pktsoal = mysqli_num_rows($qr_sc_pktsoal);

	if (!empty($row_sc_pktsoal)) {
		// UPDATE `cbt_pktsoal` SET `kd_kls` = '11', `kls` = '11', `jur` = '11', `kd_mpel` = 'COBA1', `kd_soal` = 'TES1', `sesi` = '11', `pilgan` = '151', `prsen_pilgan` = '601', `esai` = '51', `prsen_esai` = '401', `jum_soal` = '201', `kkm` = '701', `tgl` = '2024-08-06', `author` = 'Triyono1', `sts` = 'Y' WHERE `cbt_pktsoal`.`id_pktsoal` = 1;
		$qr = "UPDATE `cbt_pktsoal` SET `kd_kls` = '$row[kd_kls]', `kls` = '$row[kls]', `jur` = '$row[jur]', `kd_mpel` = '$row[kd_mpel]', `kd_soal` = '$row[kd_soal]', `sesi` = '$row[sesi]', `pilgan` = '$row[pilgan]', `prsen_pilgan` = '$row[prsen_pilgan]', `esai` = '$row[esai]', `prsen_esai` = '$row[prsen_esai]', `jum_soal` = '$row[jum_soal]', `kkm` = '$row[kkm]', `tgl` = '$row[tgl]', `author` = '".addslashes($row['author'])."', `sts` = '$row[sts]' WHERE `cbt_pktsoal`.`id_pktsoal` = '$row[id_pktsoal]';";
		if (mysqli_query($koneksi, $qr)) {
			echo "✅ Paket Soal di rubah";
		} else {
			echo "❌ Gagal Paket Soal di rubah";
		}
	} else {
		// INSERT INTO `cbt_pktsoal` (`id_pktsoal`, `kd_kls`, `kls`, `jur`, `kd_mpel`, `kd_soal`, `sesi`, `pilgan`, `prsen_pilgan`, `esai`, `prsen_esai`, `jum_soal`, `kkm`, `tgl`, `author`, `sts`) VALUES (NULL, '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', current_timestamp(), '1', 'Y');
		$qr = "INSERT INTO `cbt_pktsoal` (`id_pktsoal`, `kd_kls`, `kls`, `jur`, `kd_mpel`, `kd_soal`, `sesi`, `pilgan`, `prsen_pilgan`, `esai`, `prsen_esai`, `jum_soal`, `kkm`, `tgl`, `author`, `sts`) VALUES (NULL, '$row[kd_kls]', '$row[kls]', '$row[jur]', '$row[kd_mpel]', '$row[kd_soal]', '$row[sesi]', '$row[pilgan]', '$row[prsen_pilgan]', '$row[esai]', '$row[prsen_esai]', '$row[jum_soal]', '$row[kkm]', '$row[tgl]', '".addslashes($row['author'])."', '$row[sts]');";
		if (mysqli_query($koneksi, $qr)) {
			echo "✅ Paket Soal tersimpan";
		} else {
			echo "❌ Gagal Paket Soal tersimpan";
		}
	}
}

// ======================== API daftar Soal ======================== //

// SELECT * FROM `cbt_soal`

$qr_sm_soal = mysqli_query($sm_kon, "SELECT * FROM `cbt_soal`");

while ($row = mysqli_fetch_array($qr_sm_soal)) {
	$qr_sc_soal = mysqli_query($koneksi, "SELECT * FROM `cbt_soal` WHERE id_soal = '$row[id_soal]'");
	$row_sc_soal = mysqli_num_rows($qr_sc_soal);

	if (!empty($row_sc_soal)) {
		// UPDATE cbt_soal SET kd_mapel = '$kmpl[kd_mpel]', jns_soal = '$jns', lev_soal = '$ktg', kd_crta='$kd_crt', cerita = '$des', tanya = '$tanya', img = '$ft0', audio = '$taud', vid = '$tvid', jwb1 = '$opsi1', jwb2 = '$opsi2', jwb3 = '$opsi3', jwb4 = '$opsi4', jwb5 = '$opsi5', img1 = '$ft1', img2 = '$ft2', img3 = '$ft3', img4 = '$ft4', img5 = '$ft5', knci_pilgan = '$key', ack_soal = '$asoal', ack_opsi = '$aopsi' WHERE cbt_soal.no_soal = '$nos' AND cbt_soal.kd_soal = '$kds';
		$qr = "UPDATE cbt_soal SET kd_mapel = '$row[kd_mapel]', jns_soal = '$row[jns_soal]', lev_soal = '$row[lev_soal]', kd_crta='$row[kd_crta]', cerita = '".addslashes($row['cerita'])."', tanya = '".addslashes($row['tanya'])."', img = '$row[img]', audio = '$row[audio]', vid = '$row[vid]', jwb1 = '".addslashes($row['jwb1']).", jwb2 = '".addslashes($row['jwb2'])."', jwb3 = '".addslashes($row['jwb3'])."', jwb4 = '".addslashes($row['wb4'])."', jwb5 = '".addslashes($row['jwb5'])."', img1 = '$row[img1]', img2 = '$row[img2]', img3 = '$row[img3]', img4 = '$row[img4]', img5 = '$row[img5]', knci_pilgan = '$row[knci_pilgan]', ack_soal = '$row[ack_soal]', ack_opsi = '$row[ack_opsi]' WHERE cbt_soal.no_soal = '$row[no_soal]' AND cbt_soal.kd_soal = '$row[kd_soal]';";
		if (mysqli_query($koneksi, $qr)) {
			echo "✅ Soal di rubah";
		} else {
			echo "❌ Gagal Soal di rubah";
		}
	} else {
		// INSERT INTO cbt_soal (id_soal, kd_soal, kd_mapel, jns_soal, lev_soal, no_soal, cerita, kd_crta, tanya, img, audio, vid, jwb1, jwb2, jwb3, jwb4, jwb5, img1, img2, img3, img4, img5, knci_pilgan, ack_soal, ack_opsi) VALUES (NULL, '$kds', '$kmpl[kd_mpel]', '$jns', '$ktg', '$nos', '$des', '$kd_crt', '$tanya', '$ft0', '$taud', '$tvid', '$opsi1', '$opsi2', '$opsi3', '$opsi4', '$opsi5', '$ft1', '$ft2', '$ft3', '$ft4', '$ft5', '$key', '$asoal', '$aopsi');
		$qr = "INSERT INTO cbt_soal (id_soal, kd_soal, kd_mapel, jns_soal, lev_soal, no_soal, cerita, kd_crta, tanya, img, audio, vid, jwb1, jwb2, jwb3, jwb4, jwb5, img1, img2, img3, img4, img5, knci_pilgan, ack_soal, ack_opsi) VALUES (NULL, '$row[kd_soal]', '$row[kd_mapel]', '$row[jns_soal]', '$row[lev_soal]', '$row[no_soal]', '".addslashes($row['cerita'])."', '$row[kd_crta]', '".addslashes($row['tanya'])."', '$row[img]', '$row[audio]', '$row[vid]', '".addslashes($row['jwb1'])."', '".addslashes($row['jwb2'])."', '".addslashes($row['jwb3'])."', '".addslashes($row['jwb4'])."', '".addslashes($row['jwb5'])."', '$row[img1]', '$row[img2]', '$row[img3]', '$row[img4]', '$row[img5]', '$row[knci_pilgan]', '$row[ack_soal]', '$row[ack_opsi]');";
		if (mysqli_query($koneksi, $qr)) {
			echo "✅ Soal tersimpan";
		} else {
			echo "❌ Gagal Soal tersimpan";
		}
	}
}


// ======================== API daftar gambar ======================== //

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
	foreach ($response['images'] as $image) {
		$image_url = $image['url']; // URL gambar dari API

		// $encoded_filename = ; // Mengganti spasi dengan %20
		$image_name = basename(str_replace('%20', ' ', $image_url)); // Nama file gambar

		// Path penyimpanan di server
		$save_path = $save_folder . $image_name;

		// Download gambar menggunakan cURL
		$ch = curl_init($image_url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_BINARYTRANSFER, true); // Pastikan file dalam format biner
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // Ikuti redirect jika ada
		$image_data = curl_exec($ch);
		curl_close($ch);

		// Simpan gambar ke folder tujuan
		if ($image_data !== false) {
			file_put_contents($save_path, $image_data);
			echo "✅ Gambar tersimpan";
		} else {
			echo "❌ Gagal Gambar tersimpan";
		}
	}
} else {
	echo "Gagal mengambil daftar gambar dari API.";
}
