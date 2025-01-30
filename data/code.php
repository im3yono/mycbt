<?php
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
	$soal_terpilih_essay = array_slice($data_es, 0, $jum_es); // Ambil 5 soal esai
	$soal_terpilih_pilihan_ganda = array_slice($data_pg, 0, $jum_pg); // Ambil 10 soal pilihan ganda
	$data_ack		= array_merge($soal_terpilih_essay, $soal_terpilih_pilihan_ganda);
	shuffle($data_ack);




		// Ambil data soal
		$soal_query = mysqli_query($koneksi, "SELECT * FROM cbt_soal WHERE kd_soal='$kds' ORDER BY no_soal");
		$data_all = [];
		$data_ack = [];
		$data_tdkack = [];
	
		while ($row = mysqli_fetch_array($soal_query)) {
			$data_all[] = $row;
			if ($row["ack_soal"] == "Y") {
				$data_ack[] = $row;
			} else {
				$data_tdkack[] = $row;
			}
		}
	
		shuffle($data_ack);