<?php
if (!empty($_GET['up'])) {
	include_once("../config/server.php");
	$dt_up = $_GET['up'];
	$kds = $_GET['kds'];
	$token = $_GET['token'];

	if (!empty($_COOKIE['user'])) {
		$adm = $_COOKIE['user'];
	} else {
		$adm = "";
	}



	if ($dt_up == "token") {
		$sql = "UPDATE jdwl SET sts_token = '$_GET[s]' WHERE jdwl.token = '$token' AND jdwl.kd_soal ='$kds';";
		if (mysqli_query($koneksi, $sql)) {
			echo '<meta http-equiv="refresh" content="0;url=../adm/?md=df_uji">';
		}
	}
	if ($dt_up == "nilai") {
		mysqli_query($koneksi, "UPDATE jdwl SET sts_nilai = '$_GET[s]' WHERE jdwl.token = '$token' AND jdwl.kd_soal ='$kds';");
		echo '<meta http-equiv="refresh" content="0;url=../adm/?md=df_uji">';
	}
	if ($dt_up == "offon") {
		mysqli_query($koneksi, "UPDATE jdwl SET md_uji = '$_GET[s]' WHERE jdwl.token = '$token' AND jdwl.kd_soal ='$kds';");
		echo '<meta http-equiv="refresh" content="0;url=../adm/?md=df_uji">';
	}

	// Update LJK ke Rekap
	if ($dt_up == "ljk") {
		// Ambil data paket soal
		$dt_paket = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM cbt_pktsoal WHERE kd_soal='$kds'"));
		$kkm = $dt_paket['kkm'];
		$jml_pg = $dt_paket['pilgan'];
		$jml_bs = $dt_paket['bs'];
		$jml_es = $dt_paket['esai'];
		$jml_esing = $dt_paket['esing'];
		$pr_pg = $dt_paket['prsen_pilgan'];
		$pr_bs = $dt_paket['prsen_bs'];
		$pr_esai = $dt_paket['prsen_esai'];
		$pr_esing = $dt_paket['prsen_esing'];

		// Ambil data jawaban peserta
		$qr_ljkusr = mysqli_query($koneksi, "SELECT * FROM cbt_ljk WHERE token='$token' AND kd_soal='$kds' GROUP BY user_jawab");

		if (mysqli_num_rows($qr_ljkusr) > 0) {
			// Proses rekap nilai
			while ($data = mysqli_fetch_array($qr_ljkusr)) {
				$bnr = 0;
				$bnr_x = 0;
				$nil_esai = 0;
				$nil_esing = 0;
				$nos = [];
				$opsi = [];
				$skor = [];

				$qr_ljkjwb = mysqli_query($koneksi, "SELECT * FROM cbt_ljk WHERE user_jawab ='$data[user_jawab]' AND token='$token' AND kd_soal='$kds' ORDER BY no_soal ASC");

				while ($jw = mysqli_fetch_array($qr_ljkjwb)) {
					$key_soal = mysqli_fetch_array(mysqli_query($koneksi, "SELECT knci_pilgan FROM cbt_soal WHERE kd_soal='$kds' AND no_soal='$jw[no_soal]'"));
					$key_pg = $key_soal['knci_pilgan'] ?? "0";

					// Tentukan jawaban opsi atau nilai esai
					// $jns_soal = ['E','G','J','X','P','ES'];
					if ($jw['jns_soal'] == "G") {
						$jwopsi = match ($jw['nil_jwb']) {
							"1" => "A",
							"2" => "B",
							"3" => "C",
							"4" => "D",
							"5" => "E",
							default => ($jw['nil_esai'] ?? "0"),
						};
					} elseif ($jw['jns_soal'] == "X") {
						$jwopsi = $jw['nil_jwb'] == "1" ? "1" : "0";
					} elseif ($jw['jns_soal'] == "ES") {
						$jwopsi = $jw['es_jwb'] ?? "";
					} else {
						$jwopsi = $jw['nil_esai'] ?? "0";
					}

					$nos[] = $jw['no_soal'];
					$opsi[] = $jwopsi;
					$skor[] = $jw['nil_pg'] != 0 ? $jw['nil_pg'] : ($jw['nil_esai'] != 0 ? $jw['nil_esai'] : 0);

					// Hitung jumlah benar dan nilai esai
					$bnr += $jw['nil_pg'];
					$bnr_x += $jw['nil_pg'];
					$nil_esing += $jw['nil_esai'];
					$nil_esai += $jw['nil_esai'];
				}

				// Penyesuaian nilai benar dan esai
				$bnr = min($bnr, $jml_pg);
				$bnr_x = min($bnr_x, $jml_bs);
				$nil_esing = min($nil_esing, $jml_esing);
				$nil_esai = $jml_es ? $nil_esai / $jml_es : 0;

				// Hitung nilai akhir
				$akh_pg 		= ($bnr / $jml_pg) * $pr_pg;
				$akh_x 			= ($bnr_x / $jml_bs) * $pr_bs;
				$akh_esing 	= ($nil_esing / $jml_esing) * $pr_esing;
				// $akh_esai 	= ($nil_esai / $jml_es) * $pr_esai;
				// $akh_pg 		= $bnr  * $pr_pg;
				// $akh_x 			= $bnr_x * $pr_bs;
				// $akh_esing 	= $nil_esing * $pr_esing;
				// $akh_esai 	= $nil_esai * $pr_esai;
				$akh_esai = $nil_esai * ($pr_esai / 100);

				$nil_tot 		= $akh_pg + $akh_x + $akh_esing + $akh_esai;

				$nos = implode(',', $nos);
				$opsi = implode(',', $opsi);
				$skor = implode(',', $skor);

				// Query untuk menyimpan atau memperbarui nilai
				// INSERT INTO `nilai` (`id_hasil`, `user`, `kd_mpel`, `kd_soal`, `token`, `jum_soal`, `kkm`, `no_soal`, `jwb`, `skor`, `nil_pg`, `nil_es`, `	nil_esing`, `	nil_bs`, `nilai`, `tgl_tes`, `tgl`, `adm`) VALUES (NULL, '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '2026-11-10', current_timestamp(), '1');
				$sql_nil = "INSERT INTO nilai 
						(id_hasil, user, kd_mpel, kd_soal, token, jum_soal, kkm, no_soal, jwb, skor, nil_pg, nil_es, nil_esing, nil_bs, nilai, tgl_tes, tgl, adm) 
						VALUES 
						(NULL, '$data[user_jawab]', '$data[kd_mapel]', '$data[kd_soal]', '$token', '$dt_paket[jum_soal]', '$kkm', '$nos', '$opsi', '$skor', '$akh_pg', '$akh_esai', '$akh_esing', '$akh_x', '$nil_tot', '$data[tgl]', CURRENT_TIME(), '$adm')";

				$sql_nilup = "UPDATE nilai SET 
						jum_soal='$dt_paket[jum_soal]', kkm='$kkm', no_soal='$nos', jwb='$opsi', skor='$skor', nil_pg='$akh_pg', nil_es='$akh_esai', nil_esing = '$akh_esing', nil_bs = '$akh_x', nilai='$nil_tot', 
						tgl=CURRENT_TIME(), adm='$adm' 
						WHERE user='$data[user_jawab]' AND kd_mpel='$data[kd_mapel]' AND kd_soal='$kds' AND token='$token'";

				$cek = mysqli_query($koneksi, "SELECT * FROM nilai WHERE user='$data[user_jawab]' AND kd_mpel='$data[kd_mapel]' AND kd_soal='$kds' AND token='$token'");
				if (mysqli_num_rows($cek) == 0) {
					mysqli_query($koneksi, $sql_nil);
					echo '<meta http-equiv="refresh" content="0;url=../adm/?md=df_uji&ss=ok">';
				} else {
					mysqli_query($koneksi, $sql_nilup);
					echo '<meta http-equiv="refresh" content="0;url=../adm/?md=df_uji&ss=up">';
				}
			}

			// Perbarui status ujian menjadi histori
			mysqli_query($koneksi, "UPDATE jdwl SET sts = 'H' WHERE token='$token' AND kd_soal='$kds'");
		} else {
			echo '<meta http-equiv="refresh" content="0;url=../adm/?md=df_uji&ss=null">';
		}
	}
}
