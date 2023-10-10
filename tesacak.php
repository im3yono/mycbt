<?php
$servername = "localhost";
$username 	= "root";
$password 	= "29041994";
$dbname 		= "mytbk";

// Membuat koneksi ke database
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Memeriksa koneksi
if ($conn->connect_error) {
	die("Koneksi gagal: " . $conn->connect_error);
}

// Mengambil data dari Database
$sql = "SELECT * FROM cbt_soal WHERE kd_soal ='X_BIndo' ";
$qrsoal = $conn->query($sql);

// Memuat data ke dalam array
	while ($row = mysqli_fetch_array($qrsoal)) {
		$data_all[] = $row;
		if ($row["ack_soal"] == "Y") {
			$data_ack[] = $row;
		} else {
			$data_tdkack[] = $row;
		}
	}

$no = 1;
$dt = 0;
$ndt =0;
shuffle($data_ack);
foreach($data_ack as $dd){
	echo $dd["no_soal"]." ";
}
echo "<br><br>";
// Menampilkan hasil pengacakan
foreach ($data_all as $d_all) {
	// No Tidak Acak
	foreach ($data_tdkack as $dataack) {
		if ($d_all["no_soal"] == $dataack["no_soal"]) {
			if ($dataack["ack_soal"] == "N") {
				$nol = $dataack["no_soal"];
				echo $nol . ". Data: " . $dataack["ack_soal"] . " - ID: " . $dataack["no_soal"] . "<br>";
				$dt - 1;
				$ndt++;
			}
		}
	}
	// No Acak
	foreach ($data_ack as $dt => $data) {
		if ($d_all["no_soal"]-$ndt == $dt+1) {
				if ($d_all["ack_soal"] == "Y") {
					echo $no . ". Data: " . $data["ack_soal"] . " - ID: " . $data["no_soal"] . "ac <br>";
				}
		}
	}
	$no++;
}
$conn->close();
