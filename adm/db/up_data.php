<?php
require_once("../../config/server_m.php");
require_once("../../config/server.php");

$no = 0;
$qr_dt = mysqli_query($koneksi, "SELECT * FROM `nilai` WHERE kd_soal='$_POST[kds]' GROUP BY user;");
while ($row = mysqli_fetch_array($qr_dt)) {
	// $sql_nil = "INSERT INTO nilai 
	//           (id_hasil, user, kd_mpel, kd_soal, token, jum_soal, kkm, no_soal, jwb, skor, nil_pg, nil_es, nilai, tgl_tes, tgl, adm) 
	//           VALUES 
	//           (NULL, '$data[user_jawab]', '$data[kd_mapel]', '$data[kd_soal]', '$token', '$dt_paket[jum_soal]', '$kkm', 
	//           '" . implode(',', $nos) . "', '" . implode(',', $opsi) . "', '" . implode(',', $skor) . "', 
	//           '$bnr', '$nil_esai', '$nil_tot', '$data[tgl]', CURRENT_TIME(), '$adm')";

	// 			$sql_nilup = "UPDATE nilai SET 
	//           jum_soal='$dt_paket[jum_soal]', kkm='$kkm', 
	//           no_soal='" . implode(',', $nos) . "', jwb='" . implode(',', $opsi) . "', 
	//           skor='" . implode(',', $skor) . "', nil_pg='$bnr', nil_es='$nil_esai', nilai='$nil_tot', 
	//           tgl=CURRENT_TIME(), adm='$adm' 
	//           WHERE user='$data[user_jawab]' AND kd_mpel='$data[kd_mapel]' AND kd_soal='$kds' AND token='$token'";

	$qrin_upnil = "INSERT INTO nilai 
            (id_hasil, user, kd_mpel, kd_soal, token, jum_soal, kkm, no_soal, jwb, skor, nil_pg, nil_es, nilai, tgl_tes, tgl, adm) 
            VALUES 
            (NULL, '$row[user]', '$row[kd_mpel]', '$row[kd_soal]', '$row[token]', '$row[jum_soal]', '$row[kkm]', '$row[no_soal]', '$row[jwb]', '$row[skor]', '$row[nil_pg]', '$row[nil_es]', '$row[nilai]', '$row[tgl_tes]', '$row[tgl]', '$inf_id')";
	$qrup_upnil = "UPDATE nilai SET
            jum_soal  = '$row[jum_soal]', 
            kkm 			= '$row[kkm]', 
            no_soal 	= '$row[no_soal]', 
            jwb 			= '$row[jwb]', 
            skor  		= '$row[skor]', 
            nil_pg  	= '$row[nil_pg]', 
            nil_es  	= '$row[nil_es]', 
            nilai 		= '$row[nilai]', 
            tgl_tes 	= '$row[tgl_tes]', 
            tgl 			= '$row[tgl]', 
            adm 			= '$inf_id' 
            WHERE user = '$row[user]' AND kd_mpel = '$row[kd_mpel]' AND kd_soal = '$row[kd_soal]' AND token = '$row[token]'";
						$cek = mysqli_query($sm_kon, "SELECT * FROM nilai WHERE user = '$row[user]' AND kd_mpel = '$row[kd_mpel]' AND kd_soal = '$row[kd_soal]' AND token = '$row[token]'");
						if (mysqli_num_rows($cek) == 0) {
							mysqli_query($sm_kon, $qrin_upnil);
						} else {
							mysqli_query($sm_kon, $qrup_upnil);
						}
						$no++;
}
echo $no;
