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

	// Update LJK ke Rekap
	if ($dt_up == "ljk") {
		$dt_paket = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM cbt_pktsoal WHERE kd_soal='$kds'"));
		$kkm = $dt_paket['kkm'];
		$jml_pg = $dt_paket['pilgan'];
		$jml_es = $dt_paket['esai'];
		$pr_pg = $dt_paket['prsen_pilgan'];
		$pr_esai = $dt_paket['prsen_esai'];

		$qr_ljkusr = mysqli_query($koneksi, "SELECT * FROM cbt_ljk WHERE token='$token' AND kd_soal='$kds' GROUP BY user_jawab;");
		if (!empty(mysqli_num_rows($qr_ljkusr))) {
			// UPDATE jdwl SET sts = 'H' WHERE jdwl.id_ujian = 1;

			// Satatus Ujian Menjadi Histori/Riwayat
			mysqli_query($koneksi, "UPDATE jdwl SET sts = 'H' WHERE token='$token' AND kd_soal='$kds';");
			// Buat Rekap Nilai
			while ($data = mysqli_fetch_array($qr_ljkusr)) {
				$bnr = 0;
				$nil_esai = 0;
				$nos = [];
				$opsi = [];
				$skor = [];

				$qr_ljkjwb = mysqli_query($koneksi, "SELECT * FROM cbt_ljk WHERE user_jawab ='$data[user_jawab]' AND token='$token' AND kd_soal='$kds' ORDER BY no_soal ASC");
				while ($jw = mysqli_fetch_array($qr_ljkjwb)) {
					$key_soal = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM cbt_soal WHERE kd_soal='$kds' AND no_soal ='$jw[no_soal]'"));
					if (!empty($key_soal['knci_pilgan'])) $key_pg = $key_soal['knci_pilgan'];
					else $key_pg = "0";

					if ($jw['jwbn'] != "N" && $jw['nil_esai'] == 0) {
						if ($jw['nil_jwb'] == "1") {
							$jwopsi = "A";
						} elseif ($jw['nil_jwb'] == "2") {
							$jwopsi = "B";
						} elseif ($jw['nil_jwb'] == "3") {
							$jwopsi = "C";
						} elseif ($jw['nil_jwb'] == "4") {
							$jwopsi = "D";
						} elseif ($jw['nil_jwb'] == "5") {
							$jwopsi = "E";
						} elseif ($jw['nil_jwb'] == "0") {
							$jwopsi = "0";
						}
					}else{
						$jwopsi = $jw['nil_esai'];
					}

					$nos[] = $jw['no_soal'] . ",";
					$opsi[] = $jwopsi . ",";
					$skor[] = $jw['nil_pg'].',';
					// $skor[] = $key_pg . ',';
					$bnr = $bnr + $jw['nil_pg'];
					$nil_esai = $nil_esai + $jw['nil_esai'];
				}
				// Perbaiki penjumlahan nilai apabila ada perbedaan soal
				if ($bnr >= $jml_pg) $bnr = $jml_pg;
				$nil_esai =  $nil_esai / $jml_es;
				$akh_esai = $nil_esai * ($pr_esai / 100);
				$nil_tot = (($bnr / $jml_pg) * $pr_pg) + $akh_esai;
				// echo $data['user_jawab'] . "<br>";
				// echo implode('', $nos) . "<br>";
				// echo implode('', $opsi) . "<br>";
				// echo implode('', $skor) . "<br>";
				// echo $bnr . "<br>" . "<br>";
				$sql_nil = "INSERT INTO nilai (id_hasil, user, kd_mpel, kd_soal, token, jum_soal, kkm, no_soal, jwb, skor, nil_pg, nil_es, nilai, tgl_tes, tgl, adm) VALUES (NULL, '$data[user_jawab]', '$data[kd_mapel]', '$data[kd_soal]', '$token', '$dt_paket[jum_soal]', '$dt_paket[kkm]', '" . implode('', $nos) . "', '" . implode('', $opsi) . "', '" . implode('', $skor) . "', '$bnr', '$nil_esai', '$nil_tot', '$data[tgl]', CURRENT_TIME(), '$adm');";

				$sql_nilup = "UPDATE nilai SET jum_soal ='$dt_paket[jum_soal]', kkm='$dt_paket[kkm]', no_soal = '" . implode('', $nos) . "', jwb = '" . implode('', $opsi) . "', skor = '" . implode('', $skor) . "', nil_pg='$bnr', nil_es='$nil_esai', nilai = '$nil_tot', tgl = CURRENT_TIME(), adm = '$adm' WHERE user ='$data[user_jawab]' AND kd_mpel='$data[kd_mapel]' AND kd_soal='$kds' AND token='$token';";

				$cek = mysqli_query($koneksi, "SELECT * FROM nilai WHERE user ='$data[user_jawab]' AND kd_mpel='$data[kd_mapel]' AND kd_soal='$kds' AND token='$token';");
				if (empty(mysqli_num_rows($cek))) {
					if (mysqli_query($koneksi, $sql_nil)) {
						echo '<meta http-equiv="refresh" content="0;url=../adm/?md=df_uji&ss=ok">';
					}
				} else {
					if (mysqli_query($koneksi, $sql_nilup)) {
						echo '<meta http-equiv="refresh" content="0;url=../adm/?md=df_uji&ss=up">';
					}
				}
			}

			// Menghapus data LJK Peserta
			// DELETE FROM cbt_ljk WHERE cbt_ljk.token = '3KENP' AND kd_soal ='X_BIndo'
			// mysqli_query($koneksi,"DELETE FROM cbt_ljk WHERE token='$token' AND kd_soal='$kds';");
		} else {
			echo '<meta http-equiv="refresh" content="0;url=../adm/?md=df_uji&ss=null">';
		}
	}
}
