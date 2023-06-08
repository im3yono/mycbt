<?php
$dt_ps = mysqli_fetch_array(mysqli_query($koneksi, "SELECT COUNT(*)AS jml_ps FROM cbt_peserta;"));
$dt_mpl = mysqli_fetch_array(mysqli_query($koneksi, "SELECT COUNT(*)AS jml_mpl FROM mapel;"));
$dt_soal = mysqli_fetch_array(mysqli_query($koneksi, "SELECT COUNT(*)AS jml_soal FROM cbt_soal;"));
?>


<style>
	.border-cs {
		height: 140px;
		border-radius: 10px;
		/* background-color: aqua; */
		background: rgb(175, 242, 255);
		background: linear-gradient(280deg, rgba(175, 242, 255, 1) 0%, rgba(216, 249, 255, 1) 40%, rgba(255, 255, 255, 1) 80%);
	}

	.atas {
		height: 75%;
	}

	.kiri {
		width: 30%;
	}

	.kanan {
		width: 70%;
	}

	.bawah {
		height: 25%;
	}

	.cl {
		background: rgb(227, 227, 227);
		background: linear-gradient(90deg, rgba(227, 227, 227, 1) 0%, rgba(236, 236, 236, 1) 26%, rgba(251, 251, 251, 1) 81%);
	}

	.dsh {
		background-color: aqua;
		z-index: 2;
	}

	h2 {
		font-family: Sherman;
		font-size: 45px;
	}
</style>
<div class="container-fluid mb-5 p-0">
	<div class="row p-2 border-bottom fs-3 mb-4 shadow-sm ">
		Beranda admin
	</div>
	<div class="row gap-3 justify-content-evenly mb-5">
		<div class="col-lg-3 col-md-4 col-sm-6 col-12 border border-cs">
			<div class="atas border-bottom row">
				<div class="kiri col-auto"><i class="bi bi-person-lines-fill display-1 text-info-emphasis"></i></div>
				<div class="kanan col-auto p-2 text-end">
					<h3 style="font-family: Alkatra;">Peserta</h3>
					<h2><?php echo $dt_ps['jml_ps'] ?></h2>
				</div>
			</div>
			<div class="bawah col-auto text-end "><a href="?md=sis" class="btn  btn-sm fs-6"> Daftar Peserta <i class="bi bi-arrow-right-circle text-info-emphasis"></i></a></div>
		</div>
		<div class="col-lg-3 col-md-4 col-sm-6 col-12 border border-cs">
			<div class="atas border-bottom row">
				<div class="kiri col-auto"><i class="bi bi-list-ol display-1 text-info-emphasis"></i></div>
				<div class="kanan col-auto p-2 text-end">
					<h3 style="font-family: Alkatra;">Mapel</h3>
					<h2><?php echo $dt_mpl['jml_mpl'] ?></h2>
				</div>
			</div>
			<div class="bawah col-auto text-end "><a href="?md=mpl" class="btn  btn-sm fs-6"> Daftar Mapel <i class="bi bi-arrow-right-circle text-info-emphasis"></i></a></div>
		</div>
		<div class="col-lg-3 col-md-4 col-sm-6 col-12 border border-cs">
			<div class="atas border-bottom row">
				<div class="kiri col-auto"><i class="bi bi-database-fill display-1 text-info-emphasis"></i></div>
				<div class="kanan col-auto p-2 text-end">
					<h3 style="font-family: Alkatra;">Soal</h3>
					<h2><?php echo $dt_soal['jml_soal'] ?></h2>
				</div>
			</div>
			<div class="bawah col-auto text-end "><a href="?md=soal" class="btn  btn-sm fs-6"> Daftar Soal <i class="bi bi-arrow-right-circle text-info-emphasis"></i></a></div>
		</div>
		<!-- <div class="col-lg-3 col-md-4 col-sm-6 col-12 border border-cs">2</div> -->
	</div>
	<div class="row px-4 gap-4">
		<div class="col-md col-12 bg-info" style="border-radius: 5px;">
			<div class="col-12 p-2 py-4 h1 text-white" style="font-family: Alkatra;">SERVER LOCAL</div>
			<div class="col-12 p-3 bg-light" style="border-radius: 8px;">CBTSync Lokal terhubung sebagai Server PUSAT</div>
			<div class="col-12 py-3 fs-3">Server ID : <span class="h3 badge bg-primary"><?php echo $inf_id; ?></span></div>
		</div>
		<div class="col-md col-12 p-0">
			<div class="col cl p-3 mb-2 fs-3" style="border-radius: 5px;">Selamat Datang Admin</div>
			<div class="col px-4 py-2 cl" style="border-radius: 5px;">Saat ini anda masuk sebagai Admin serta anda dapat mengakses atau menggunakan seluruh fitur-fitur yang ada.</div>
		</div>
	</div>
	<div class="row p-2 mt-3">
		<div class="col-12 fs-3">Jadwal Ujian</div>
		<div class="col table-responsive">
			<table class="table table-hover table-striped table-bordered">
				<thead class="table-info text-center align-baseline">
					<tr>
						<th style="width: 5%;">No.</th>
						<th style="width: 13%;">Hari, Tanggal</th>
						<th style="width: 10%;">Jam Mulai-Akhir</th>
						<th style="width: 10%">Lama Ujian</th>
						<th style="width: 27%;">Mata Pelajaran</th>
						<th style="width: 10%;">Kelas | Ruang</th>
						<th style="width: 10%;">Status</th>
					</tr>
				</thead>
				<tbody class=" text-center align-baseline">
					<?php
					$jdwl	=	mysqli_query($koneksi, "SELECT * FROM cbt_pktsoal");
					$no		= 1;

					while ($dtjd = mysqli_fetch_array($jdwl)) {
						$mpl	=	mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM mapel WHERE mapel.kd_mpel = '$dtjd[kd_mpel]'"));
						$kls	=	mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM kelas WHERE kelas.kd_kls ='$dtjd[kd_kls]'"));
						$rng	=	mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM cbt_peserta WHERE cbt_peserta.kd_kls ='$dtjd[kd_kls]';"));
						$jdw	=	mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM ujian WHERE ujian.kd_mpel = '$dtjd[kd_mpel]';"));
						if (!empty($jdw['jm_uji'])) {
							$waktu_awal		= $jdw['jm_uji'];
							$waktu_akhir	= $jdw['lm_uji']; // bisa juga waktu sekarang now()

							$awal  = strtotime(($waktu_awal));
							$akhir = strtotime(($waktu_akhir));
							// $awal  = strtotime("08:00:00");
							// $akhir = strtotime("02:00:00");
							$nol = strtotime("00:00:00");
							$diff  = ($awal - $nol) + ($akhir - $nol);

							$jam   = floor($diff / (60 * 60));
							$menit = $diff - ($jam * (60 * 60));
							$detik = $diff % 60;

							$jmak  = floor(($akhir - $nol) / (60 * 60));
							$minak = ($akhir - $nol) - ($jmak * (60 * 60));
							$batas = ($jmak * 60) + floor($minak / 60);
						}

						// echo $awal.' '.$akhir."<br>".$batas."<br>";
						// echo 'Waktu tinggal: ' . $jam .  ' jam, ' . floor($menit / 60) . ' menit, ' . $detik . ' detik';

					?>
						<tr style="font-family: Alkatra;">
							<th scope="row"><?php echo $no++; ?></th>
							<?php if (!empty($jdw['jm_uji'])) { ?>
								<td><?php
										echo tgl_hari($jdw['tgl_uji']);
										?></td>
								<td><?php
										if (!empty($jdw['jm_uji'])) {
											echo date('H:i', strtotime($jdw['jm_uji'])) . '-';
											if ($jam < 10) {
												echo '0' . $jam;
											} else {
												echo $jam;
											}
											echo ':';
											if ($menit < 600) {
												echo '0' . floor($menit / 60);
											} else {
												echo floor($menit / 60);
											}
										}
										?></td>
								<td><?php echo $batas . ' menit'; ?></td>
							<?php } else {
								echo "<td colspan='3'><div class='text-danger'>Ujian Belum di Atur</div></td>";
							} ?>
							<td><?php if (!empty($dtjd['kd_mpel'])) {
										echo $mpl['nm_mpel'];
									} else {
										echo "<div class='text-danger'>Mata Pelajaran Belum Terpilih Pada Bank Soal</div>";
									} ?></td>
							<td>
								<?php if (!empty($dtjd['kd_kls'])) {
									echo $kls['nm_kls'] . " | " . $rng['ruang'];
								} else {
									echo "<div class='text-danger'>Kelas Belum Terpilih Pada Bank Soal</div>";
								} ?></td>
							<td><?php
									if (!empty($jdw['sts'])) {
										if ($jdw['sts'] == "Y") {
											echo "Terjadwal";
										} elseif ($jdw['sts'] == "N") {
											echo "Tidak Aktif";
										}
									} else {
										echo "Belum Terjadwal";
									}

									?>
							</td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
</div>







<!-- 
	INSERT INTO ujian (id_ujian, kd_ujian, smt, kls, kd_kls, jur, nm_kls, kd_mpel, jm_login, tgl_uji, jm_uji, bts_login, lm_uji, token, author, thn_ajr, user, sesi, sts) VALUES (NULL, 'UH', '1', 'X', 'M1', 'Merdeka', 'M1_Merdeka', 'MTK', '07:55:00', '2023-06-07', '08:00:00', '08:30:00', '02:00:00', 'KAMDT', 'admin', '2022/2023', 'admin', '1', 'Y');

	
 -->







<!-- === JavaScript === -->
<script>

</script>