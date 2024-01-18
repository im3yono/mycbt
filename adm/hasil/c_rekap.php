<?php
// error_reporting(0); //hide error


if (!empty($_POST['kds'])) {
	include_once("../../config/server.php");

	$kds = $_POST['kds'];
	// $kd_kls = $_POST['kls'];
	$qr_no = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM cbt_pktsoal WHERE kd_soal ='$kds'"));
	if ($qr_no['kd_kls'] == "1") {
		$kls = $qr_no['kls'] . " " . $qr_no['jur'];
	} else {
		$nm_kls = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM `kelas` WHERE kd_kls ='$qr_no[kd_kls]'"));
		$kls = $nm_kls['nm_kls'];
	}

	$qr_mpel = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM mapel WHERE kd_mpel ='$qr_no[kd_mpel]'"));

	echo '
		<div class="row justify-content-center m-0">
			<div class="col-12 px-3" style="border-radius: 7px;">
				<table class="table table-borderless">
					<tr>
						<td style="width: auto;">Nama Mapel</td>
						<td>: </td><td class="fw-bold">' . $qr_mpel['nm_mpel'] . '</td>
						<!-- <td rowspan="4" valign="middle" class="text-center">
							<a href="d_nilai.php?kds=' . $kds . '" class="btn btn-outline-primary btn-lg fw-bold">Download</a>
						</td> -->
					</tr>
					<tr>
						<td>Nama Pembuat Soal</td>
						<td>: </td><td> ' . $qr_no['author'] . '</td>
					</tr>
					<tr>
						<td>Kelas</td>
						<td>: </td><td>' . $kls . '</td>
					</tr>
				</table>
				<table class="table table-bordered border-dark table-hover">
					<thead class="text-center align-middle bg-info-subtle">
						<th style="width: 5mm;">No.</th>
						<th style="width: 50mm;">No. Peserta</th>
						<th style="width: 150mm;">Nama</th>
						<th style="width: 50mm;">Kelas | Jurusan</th>
						<th style="width: 5mm;">Nilai</th>
						<th style="width: 10mm;">Rekap Nilai</th>
					</thead>
					<tbody class="text-center">';

	$no = 1;
	$qr = mysqli_query($koneksi, "SELECT * FROM `nilai` WHERE kd_soal ='$kds'");

	while ($data = mysqli_fetch_array($qr)) {
		$nm = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM cbt_peserta WHERE user='$data[user]'"));
		if ($data['kkm'] < $data['nilai']) {
			$ket = "Tuntas";
			$tex = "";
		} else {
			$ket = "Tidak Tuntas";
			$tex = "text-danger";
		};
		echo '
							<tr>
								<th>' . $no++ . '</th>
								<td>' . $data['user'] . '</td>
								<td class="text-start">' . $nm['nm'] . '</td>
								<td class="text-start">' . "Kelas | Jurusan" . '</td>
								<td class="fw-bold ' . $tex . '">' . $data['nilai'] . '</td>
								<td><a href="#" class="btn btn-outline-primary btn-sm" style="width: 70px;"><i class="bi bi-eye"> Lihat</i></a></td>
							</tr>
						';
	}
	echo '
					</tbody>
				</table>
			</div>
		</div>';
	// } elseif ($_POST['kds'] == "0") {
	// 	echo "Pilih Kode Bank Soal Terlebih Dahulu";
} else {
	echo "Pilih Kode Bank Soal Terlebih Dahulu";
}
