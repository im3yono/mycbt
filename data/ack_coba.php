<?php
require_once '../config/server.php';

$jum_soal	= 20;
$jum_pg		= 15;
$jum_es		= 5;

$soal_query = mysqli_query($koneksi, "SELECT * FROM cbt_soal WHERE kd_soal='coba' ORDER BY no_soal");
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

?>

<div id="no"></div>
<script>
	// Data awal soal (simulasi dari database)
	const soalData = <?= json_encode($data_all); ?>;

	// Tentukan jumlah soal yang dibutuhkan
	const jum_soal = 20;
	const jum_pg = 15;
	const jum_es = 5;

	// Membagi soal berdasarkan jenis dan status ack_soal
	const data_all = [];
	const data_ack = [];
	const data_tdkack = [];
	const data_es = [];
	const data_pg = [];
	let d_soal = [];

	soalData.forEach(row => {
		data_all.push(row);
		if (row.ack_soal === "Y") {
			if (row.jns_soal === "G") {
				data_pg.push(row);
			} else if (row.jns_soal === "E") {
				data_es.push(row);
			}
		} else {
			data_tdkack.push(row);
		}
	});

	// Ambil soal sesuai jumlah yang diperlukan
	const soal_terpilih_essay = data_es.slice(0, jum_es); // Ambil soal esai
	const soal_terpilih_pilihan_ganda = data_pg.slice(0, jum_pg); // Ambil soal pilihan ganda
	const data_ack_terpilih = [...soal_terpilih_essay, ...soal_terpilih_pilihan_ganda];

	// Fungsi untuk mengacak soal
	const shuffle = (array) => {
		for (let i = array.length - 1; i > 0; i--) {
			const j = Math.floor(Math.random() * (i + 1));
			[array[i], array[j]] = [array[j], array[i]]; // Tukar posisi
		}
	};

	// Acak soal yang sudah dipilih
	shuffle(data_ack_terpilih);

	// Menampilkan soal yang sudah diproses
	let no = 1;
	let nack = 1;
	let nos = 1;

	data_all.forEach(d_all => {
		// Proses soal tidak acak (ack_soal === "N")
		if (d_all.ack_soal === "N") {
			data_tdkack.forEach(notack => {
				if (d_all.no_soal === notack.no_soal) {
					d_soal.push(notack.no_soal); // Tampilkan soal yang tidak acak
					nack++;
				}
			});
		}

		// Proses soal acak (ack_soal === "Y")
		if (d_all.ack_soal === "Y") {
			data_ack_terpilih.forEach((data, dt) => {
				if (no === dt + nack) {
					d_soal.push(data.no_soal); // Tampilkan soal yang diacak
				}
			});
		}

		nos++;
		no++;
		console.log(d_soal); // Baris baru (optional, hanya untuk visualisasi)

	});
	// Simpan hasil ke dalam cookie
	document.cookie = "d_soal=" + JSON.stringify(d_soal) + "; path=/";
	document.cookie = "d_soal2=" + JSON.stringify(d_soal) + "; path=/";

	// Tampilkan hasil di elemen HTML
	// document.getElementById("no").innerHTML = d_soal.join(", ");
</script>
<?php 
if (isset($_COOKIE['d_soal2'])) {
	$out = json_decode($_COOKIE['d_soal2'], true); // Decode JSON data from the cookie
	if (is_array($out) && isset($out[2])) {
		echo $out[2]; // Tampilkan hasil dari cookie
	} else {
		echo "Index 2 tidak ditemukan dalam data cookie."; // Handle missing index
	}
} else {
	echo "Cookie 'd_soal2' tidak ditemukan."; // Handle missing cookie
}
?>