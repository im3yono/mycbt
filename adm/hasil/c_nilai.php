<?php
include_once("../../config/server.php");
// error_reporting(0); //hide error

if (!empty($_POST['kds'])) {
	$dt = explode(",",$_POST['kds']);
	$kds = $dt[0];
	$token = $dt[1];
	// $kd_kls = $_POST['kls'];
	$qr_no = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM cbt_pktsoal WHERE kd_soal ='$kds'"));
	if ($qr_no['kd_kls'] == "1") {
		$kls = $qr_no['kls'] . " " . $qr_no['jur'];
	} else {
		$nm_kls = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM `kelas` WHERE kd_kls ='$qr_no[kd_kls]'"));
		$kls = $nm_kls['nm_kls'];
	}

	$qr_mpel = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM mapel WHERE kd_mpel ='$qr_no[kd_mpel]'"));

?>

	<html lang="en">

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="../../vendor/twbs/bootstrap/dist/css/bootstrap.min.css">
		<script src="../../vendor/twbs/bootstrap/dist/js/bootstrap.min.js"></script>
	</head>

	<body>
		<div class="row justify-content-center m-0">
			<div class="col-xl-8 col p-3 border shadow" style="border-radius: 7px; margin-top: 30px;">
				<table class="table table-borderless">
					<tr>
						<td style="width: 5cm;">Nama Mapel</td>
						<td class="fw-bold">: <?php echo $qr_mpel['nm_mpel'] ?></td>
						<td rowspan="4" valign="middle" class="text-center">
							<a href="d_nilai.php?kds=<?php echo $kds ?>&tkn=<?php echo $token ?>" class="btn btn-outline-primary btn-lg fw-bold">Download</a>
						</td>
					</tr>
					<tr>
						<td>Nama Pembuat Soal</td>
						<td>: <?php echo $qr_no['author'] ?></td>
					</tr>
					<tr>
						<td>Kelas</td>
						<td>: <?php echo $kls ?></td>
					</tr>
				</table>
				<!-- <div class="row"></div> -->
				<table class="table table-bordered border-dark">
					<thead class="text-center bg-info-subtle">
						<th style="width: 5mm;">No.</th>
						<th style="width: 50mm;">No. Peserta</th>
						<th style="width: 150mm;">Nama</th>
						<!-- <th style="width: 5mm;">Benar</th>
						<th style="width: 5mm;">Salah</th> -->
						<th style="width: 5mm;">Nilai</th>
						<th style="width: 100mm;">Keterangan</th>
					</thead>
					<tbody class="text-center">
						<?php
						$no =1;
						$qr = mysqli_query($koneksi, "SELECT * FROM `nilai` WHERE kd_soal ='$kds' AND token ='$token'");

						while ($data = mysqli_fetch_array($qr)) {
							$nm = mysqli_fetch_array(mysqli_query($koneksi,"SELECT * FROM cbt_peserta WHERE user='$data[user]'"));
							if ($data['kkm']<$data['nilai']) {
								$ket = "Tuntas";
							}else{$ket = "Tidak Tuntas";$tex = "text-danger";};

							
						?>
							<tr>
								<th><?php echo $no++ ?></th>
								<td><?php echo $data['user'] ?></td>
								<td class="text-start fw-semibold"><?php echo $nm['nm'] ?></td>
								<!-- <td><?php echo $data['nil_pg'] ?></td>
								<td><?php echo $data['nil_es'] ?></td> -->
								<td class="fw-bold <?php echo $tex.'">'. $data['nilai'] ?></td>
								<td><?php echo $ket ?></td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
	</body>

	</html>

<?php } else {
	echo "Pilih Kode Bank Soal Terlebih Dahulu";
} ?>