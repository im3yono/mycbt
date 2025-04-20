<?php 
require_once '../config/server.php';

$soal_query = mysqli_query($koneksi, "SELECT * FROM cbt_soal WHERE kd_soal='coba' ORDER BY no_soal");
$data_all 		= [];
$data_ack 		= [];
$data_tdkack 	= [];
$data_es 			= [];
$data_pg 			= [];

$jum_soal	= 20;
$jum_pg		= 15;
$jum_es		= 5;

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
	$nos	= 1;

	foreach ($data_all as $d_all) {
		// // Fungsi untuk menghasilkan opsi jawaban
		// $generateOptions = function ($acak = false) {
		// 	$options = ["1", "2", "3", "4", "5"];
		// 	if ($acak) shuffle($options);
		// 	return $options;
		// };

		// // Fungsi untuk mendapatkan kunci jawaban
		// $getAnswerKey = function ($koneksi, $kds, $no_soal) {
		// 	$keyData = mysqli_fetch_assoc(
		// 		mysqli_query($koneksi, "SELECT knci_pilgan AS jwbn, jns_soal FROM cbt_soal WHERE kd_soal='$kds' AND no_soal='$no_soal'")
		// 	);
		// 	return $keyData['jns_soal'] === "G" ? $keyData['jwbn'] : "N";
		// };

		// // Fungsi untuk memasukkan data jika belum ada
		// $insertIfNotExists = function ($koneksi, $sql_lj, $userlg, $nos, $kds, $token) {
		// 	$check = mysqli_query($koneksi, "SELECT COUNT(*) AS jumlah FROM cbt_ljk WHERE user_jawab='$userlg' AND urut='$nos' AND kd_soal='$kds' AND token='$token'");
		// 	if (mysqli_fetch_assoc($check)['jumlah'] == 0) {
		// 		mysqli_query($koneksi, $sql_lj);
		// 	}
		// };

		// Proses untuk soal tidak acak
		if ($d_all['ack_soal'] === "N") {
			foreach ($data_tdkack as $notack) {
				if ($d_all["no_soal"] === $notack["no_soal"]) {
          echo $notack["no_soal"];
					// $options = $generateOptions($notack['ack_opsi'] === "Y");
					// [$A, $B, $C, $D, $E] = $options;
					// $key = $getAnswerKey($koneksi, $kds, $notack["no_soal"]);

					// $sql_lj = "INSERT INTO cbt_ljk 
          //               (id, urut, user_jawab, token, kd_soal, no_soal, jns_soal, kd_mapel, kd_kls, kd_jur, A, B, C, D, E, jwbn, nil_jwb, knci_jwbn, nil_pg, es_jwb, nil_esai, tgl, jam) 
          //               VALUES 
          //               (NULL, '$nos', '$userlg', '$token', '$kds', '$notack[no_soal]', '$notack[jns_soal]', '$notack[kd_mapel]', '$dtkls[kd_kls]', '$dtkls[jur]', 
          //               '$A', '$B', '$C', '$D', '$E', 'N', '0', '$key', '0', '', '0', CURRENT_DATE, CURRENT_TIME)";

					// $insertIfNotExists($koneksi, $sql_lj, $userlg, $nos, $kds, $token);
					$nack++;
				}
			}
		}

		// Proses untuk soal acak
		if ($d_all['ack_soal'] === "Y") {
			foreach ($data_ack as $dt => $data) {
				if ($no === $dt + $nack) {
          echo $data["no_soal"];
					// $options = $generateOptions($data['ack_opsi'] === "Y");
					// [$A, $B, $C, $D, $E] = $options;
					// $key = $getAnswerKey($koneksi, $kds, $data["no_soal"]);

					// $sql_lj = "INSERT INTO cbt_ljk 
          //               (id, urut, user_jawab, token, kd_soal, no_soal, jns_soal, kd_mapel, kd_kls, kd_jur, A, B, C, D, E, jwbn, nil_jwb, knci_jwbn, nil_pg, es_jwb, nil_esai, tgl, jam) 
          //               VALUES 
          //               (NULL, '$nos', '$userlg', '$token', '$kds', '$data[no_soal]', '$data[jns_soal]', '$data[kd_mapel]', '$dtkls[kd_kls]', '$dtkls[jur]', 
          //               '$A', '$B', '$C', '$D', '$E', 'N', '0', '$key', '0', '', '0', CURRENT_DATE, CURRENT_TIME)";

					// $insertIfNotExists($koneksi, $sql_lj, $userlg, $nos, $kds, $token);
				}
			}
		}

		// if ($no == $use_s) break;

		$nos++;
		$no++;
    echo "<br>";
	}
?>