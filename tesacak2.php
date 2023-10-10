<!-- OLD ACAK SOAL -->
<?php
$ljk_cek	= mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM cbt_ljk WHERE user_jawab ='$userlg' AND token='$token' AND kd_soal='$kds'"));
if ($ljk_cek != $jum_soal) {
	$nos = 1;
	// SELECT * FROM cbt_soal WHERE kd_soal='X_BIndo' AND jns_soal='G' AND ack_soal='Y' ORDER BY RAND() LIMIT 10;
	// SELECT * FROM cbt_soal WHERE kd_soal='X_BIndo' ORDER BY IF(ack_soal='Y', RAND(no_soal),''), IF(ack_soal='N','no_soal ASC','') LIMIT 20;
	$dts_t	= mysqli_query($koneksi, "SELECT * FROM cbt_soal WHERE kd_soal='$kds' AND ack_soal='N' ORDER BY no_soal LIMIT $jum_soal;");

	// $dts_t	= mysqli_query($koneksi, "SELECT * FROM cbt_soal WHERE kd_soal='$kds' ORDER BY IF(ack_soal='Y', RAND(no_soal),''), IF(ack_soal='N','no_soal ASC','') LIMIT $jum_soal;");


	// query acak soal
	// SELECT * FROM cbt_soal WHERE kd_soal ='X_BIndo' ORDER BY CASE WHEN ack_soal IN ('Y') THEN no_soal ELSE RAND() END, no_soal;


	// for ($r2 = 1; $r2 = mysqli_fetch_array($sqlambilsoalpilT1); $r2++) {
	// while ($ljw = mysqli_fetch_array($dts_t)) {

	// Tidak Acak
	while ($ljw = mysqli_fetch_array($dts_t)) {
		$ab = array("1", "2", "3", "4", "5");
		if ($ljw['ack_opsi'] == "Y") {
			shuffle($ab);
		}
		$A = $ab[0];
		$B = $ab[1];
		$C = $ab[2];
		$D = $ab[3];
		$E = $ab[4];
		$var = array_search($ljw['knci_pilgan'], $ab);
		$key = $var + 1;
		if ($key == "1") {
			$key = $A;
		}
		if ($key == "2") {
			$key = $B;
		}
		if ($key == "3") {
			$key = $C;
		}
		if ($key == "4") {
			$key = $D;
		}
		if ($key == "5") {
			$key = $E;
		}

		// $no_s = $nos;
		if ($ljw['ack_soal'] == "Y") {
			// 	if ($ljw['no_soal'] > $jum_soal) {
			continue;
		}
		$sql_lj = "INSERT INTO cbt_ljk (id, urut, user_jawab, token, kd_soal, no_soal, jns_soal, kd_mapel, kd_kls, kd_jur, A, B, C, D, E, jwbn, nil_jwb, knci_jwbn, nil_pg, es_jwb, nil_esai, tgl, jam) VALUES (NULL, '$nos', '$userlg', '$token', '$kds', '$ljw[no_soal]', '$ljw[jns_soal]', '$ljw[kd_mapel]', '$dtkls[kd_kls]', '$dtkls[jur]', '$A', '$B', '$C', '$D', '$E', 'N', '0', '$key', '0', '', '0', CURRENT_DATE, CURRENT_TIME);";

		$ckno = mysqli_query($koneksi, "SELECT * FROM cbt_ljk WHERE user_jawab ='$userlg' AND urut ='$nos' AND kd_soal= '$kds'");
		if (empty(mysqli_num_rows($ckno))) {
			mysqli_query($koneksi, $sql_lj);
		}
		$nos++;
	}

	$soal_t	= mysqli_num_rows($dts_t);
	$soal_a	= $jum_soal - $soal_t;
	$dts_a	= mysqli_query($koneksi, "SELECT * FROM cbt_soal WHERE kd_soal='$kds' AND ack_soal='Y' ORDER BY RAND() LIMIT $soal_a;");
	// Acak
	while ($ljw = mysqli_fetch_array($dts_a)) {
		$ab = array("1", "2", "3", "4", "5");
		if ($ljw['ack_opsi'] == "Y") {
			shuffle($ab);
		}
		$A = $ab[0];
		$B = $ab[1];
		$C = $ab[2];
		$D = $ab[3];
		$E = $ab[4];
		$var = array_search($ljw['knci_pilgan'], $ab);
		$key = $var + 1;
		if ($key == "1") {
			$key = $A;
		}
		if ($key == "2") {
			$key = $B;
		}
		if ($key == "3") {
			$key = $C;
		}
		if ($key == "4") {
			$key = $D;
		}
		if ($key == "5") {
			$key = $E;
		}

		$sql_lj = "INSERT INTO cbt_ljk (id, urut, user_jawab, token, kd_soal, no_soal, jns_soal, kd_mapel, kd_kls, kd_jur, A, B, C, D, E, jwbn, nil_jwb, knci_jwbn, nil_pg, es_jwb, nil_esai, tgl, jam) VALUES (NULL, '$nos', '$userlg', '$token', '$kds', '$ljw[no_soal]', '$ljw[jns_soal]', '$ljw[kd_mapel]', '$dtkls[kd_kls]', '$dtkls[jur]', '$A', '$B', '$C', '$D', '$E', 'N', '0', '$key', '0', '', '0', CURRENT_DATE, CURRENT_TIME);";

		$ckno = mysqli_query($koneksi, "SELECT * FROM cbt_ljk WHERE user_jawab ='$userlg' AND urut ='$nos' AND kd_soal= '$kds'");
		if (empty(mysqli_num_rows($ckno))) {
			mysqli_query($koneksi, $sql_lj);
			// }
		}
		$nos++;
	}
} else {
}

?>