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
		$jml_es = $dt_paket['esai'];
		$pr_pg = $dt_paket['prsen_pilgan'];
		$pr_esai = $dt_paket['prsen_esai'];

		// Ambil data jawaban peserta
		$qr_ljkusr = mysqli_query($koneksi, "SELECT * FROM cbt_ljk WHERE token='$token' AND kd_soal='$kds' GROUP BY user_jawab");

		if (mysqli_num_rows($qr_ljkusr) > 0) {
			// Perbarui status ujian menjadi histori
			mysqli_query($koneksi, "UPDATE jdwl SET sts = 'H' WHERE token='$token' AND kd_soal='$kds'");

			// Proses rekap nilai
			while ($data = mysqli_fetch_array($qr_ljkusr)) {
				$bnr = 0;
				$nil_esai = 0;
				$nos = [];
				$opsi = [];
				$skor = [];

				$qr_ljkjwb = mysqli_query($koneksi, "SELECT * FROM cbt_ljk WHERE user_jawab ='$data[user_jawab]' AND token='$token' AND kd_soal='$kds' ORDER BY no_soal ASC");

				while ($jw = mysqli_fetch_array($qr_ljkjwb)) {
					$key_soal = mysqli_fetch_array(mysqli_query($koneksi, "SELECT knci_pilgan FROM cbt_soal WHERE kd_soal='$kds' AND no_soal='$jw[no_soal]'"));
					$key_pg = $key_soal['knci_pilgan'] ?? "0";

					// Tentukan jawaban opsi atau nilai esai
					$jwopsi = match ($jw['nil_jwb']) {
						"1" => "A",
						"2" => "B",
						"3" => "C",
						"4" => "D",
						"5" => "E",
						default => ($jw['nil_esai'] ?? "0"),
					};

					$nos[] = $jw['no_soal'];
					$opsi[] = $jwopsi;
					$skor[] = $jw['nil_pg'];

					// Hitung jumlah benar dan nilai esai
					$bnr += $jw['nil_pg'];
					$nil_esai += $jw['nil_esai'];
				}

				// Penyesuaian nilai benar dan esai
				$bnr = min($bnr, $jml_pg);
				$nil_esai = $jml_es ? $nil_esai / $jml_es : 0;

				// Hitung nilai akhir
				$akh_esai = $nil_esai * ($pr_esai / 100);
				$nil_tot = (($bnr / $jml_pg) * $pr_pg) + $akh_esai;

				// Query untuk menyimpan atau memperbarui nilai
				$sql_nil = "INSERT INTO nilai 
            (id_hasil, user, kd_mpel, kd_soal, token, jum_soal, kkm, no_soal, jwb, skor, nil_pg, nil_es, nilai, tgl_tes, tgl, adm) 
            VALUES 
            (NULL, '$data[user_jawab]', '$data[kd_mapel]', '$data[kd_soal]', '$token', '$dt_paket[jum_soal]', '$kkm', 
            '" . implode(',', $nos) . "', '" . implode(',', $opsi) . "', '" . implode(',', $skor) . "', 
            '$bnr', '$nil_esai', '$nil_tot', '$data[tgl]', CURRENT_TIME(), '$adm')";

				$sql_nilup = "UPDATE nilai SET 
            jum_soal='$dt_paket[jum_soal]', kkm='$kkm', 
            no_soal='" . implode(',', $nos) . "', jwb='" . implode(',', $opsi) . "', 
            skor='" . implode(',', $skor) . "', nil_pg='$bnr', nil_es='$nil_esai', nilai='$nil_tot', 
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
		} else {
			echo '<meta http-equiv="refresh" content="0;url=../adm/?md=df_uji&ss=null">';
		}
	}
}
