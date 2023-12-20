<?php
// include_once("../../config/server.php");
$dt_ps = mysqli_fetch_array(mysqli_query($koneksi, "SELECT COUNT(*)AS jml_ps FROM cbt_peserta;"));
$dt_rg = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM cbt_peserta GROUP BY ruang;"));
$dt_kls = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM kelas"));
$dt_mpl = mysqli_fetch_array(mysqli_query($koneksi, "SELECT COUNT(*)AS jml_mpl FROM mapel;"));
$dt_soal = mysqli_fetch_array(mysqli_query($koneksi, "SELECT COUNT(*)AS jml_soal FROM cbt_pktsoal;"));
?>

<style>
	.border-cs {
		height: 150px;
		/* width: 300px; */
		border-radius: 10px;
		/* background-color: aqua; */
		background: rgb(175, 242, 255);
		background: linear-gradient(280deg, rgba(175, 242, 255, 1) 0%, rgba(216, 249, 255, 1) 40%, rgba(255, 255, 255, 1) 80%);
	}

	@media only screen and (min-width: 576px) {
		.border-cs {
			width: 300px;
		}
	}

	@media only screen and (max-width: 575px) {
		.border-cs {
			width: 90%;
		}
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
	<div class="row gap-3 row-cols-4 justify-content-evenly mb-5">
		<div class="border border-cs">
			<div class="atas border-bottom row">
				<div class="kiri col-auto"><i class="bi bi-list-ol display-1 text-info-emphasis"></i></div>
				<div class="kanan col-auto p-2 text-end">
					<h3 style="font-family: Alkatra;">Mapel</h3>
					<h2><?php echo $dt_mpl['jml_mpl'] ?></h2>
				</div>
			</div>
			<div class="bawah col-auto text-end "><a href="?md=mpl" class="btn  btn-sm fs-6"> Daftar Mapel <i class="bi bi-arrow-right-circle text-info-emphasis"></i></a></div>
		</div>
		<div class="border border-cs">
			<div class="atas border-bottom row">
				<div class="kiri col-auto"><i class="bi bi-database display-1 text-info-emphasis"></i></div>
				<div class="kanan col-auto p-2 text-end">
					<h3 style="font-family: Alkatra;">Soal</h3>
					<h2><?php echo $dt_soal['jml_soal'] ?></h2>
				</div>
			</div>
			<div class="bawah col-auto text-end "><a href="?md=soal" class="btn  btn-sm fs-6"> Daftar Soal <i class="bi bi-arrow-right-circle text-info-emphasis"></i></a></div>
		</div>
		<div class="border border-cs">
			<div class="atas border-bottom row">
				<div class="kiri col-auto"><i class="bi bi-person-lines-fill display-1 text-info-emphasis"></i></div>
				<div class="kanan col-auto p-2 text-end">
					<h3 style="font-family: Alkatra;">Peserta</h3>
					<h2><?php echo $dt_ps['jml_ps'] ?></h2>
				</div>
			</div>
			<div class="bawah col-auto text-end "><a href="?md=sis" class="btn  btn-sm fs-6"> Daftar Peserta <i class="bi bi-arrow-right-circle text-info-emphasis"></i></a></div>
		</div>
		<div class="border border-cs">
			<div class="atas border-bottom row">
				<div class="kiri col-auto"><i class="bi bi-bookmarks display-1 text-info-emphasis"></i></div>
				<div class="kanan col-auto p-2 text-end">
					<h3 style="font-family: Alkatra;">Ruang</h3>
					<h2><?php echo $dt_rg ?></h2>
				</div>
			</div>
			<div class="bawah col-auto text-end ">
				<a href="?md=sis" class="btn  btn-sm fs-6"> Daftar Peserta <i class="bi bi-arrow-right-circle text-info-emphasis"></i></a>
			</div>
		</div>
		<div class="border border-cs">
			<div class="atas border-bottom row">
				<div class="kiri col-auto"><i class="bi bi-collection display-1 text-info-emphasis"></i></div>
				<div class="kanan col-auto p-2 text-end">
					<h3 style="font-family: Alkatra;">Kelas</h3>
					<h2><?php echo $dt_kls ?></h2>
				</div>
			</div>
			<div class="bawah col-auto text-end "><a href="?md=kls" class="btn  btn-sm fs-6"> Daftar Kelas <i class="bi bi-arrow-right-circle text-info-emphasis"></i></a></div>
		</div>
		<!-- <div class="border border-cs">2</div> -->
	</div>
	<div class="row px-4 gap-4">
		<div class="col-md col-12 bg-info" style="border-radius: 5px;">
			<div class="col-12 p-2 py-4 h1 text-white" style="font-family: Alkatra;">SERVER LOCAL</div>
			<div class="col-12 p-3 bg-light" style="border-radius: 8px;">TBKSync Lokal terhubung sebagai Server PUSAT</div>
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
			<table class="table table-hover table-bordered">
				<thead class="table-info text-center align-baseline">
					<tr>
						<th style="width: 5%;">No.</th>
						<th style="width: 13%;">Hari, Tanggal</th>
						<th style="width: 10%;">Jam <br>Mulai-Akhir</th>
						<th style="width: 10%">Lama Ujian</th>
						<th style="width: 27%;">Mata Pelajaran</th>
						<th style="width: 10%;">Ruang</th>
						<th style="width: 12%;">Status</th>
					</tr>
				</thead>
				<tbody class=" text-center align-items-baseline">
					<?php
					$jdwl	=	mysqli_query($koneksi, "SELECT * FROM jdwl ORDER BY tgl_uji, jm_uji ASC");
					$no		= 1;

					while ($dtjd = mysqli_fetch_array($jdwl)) {
						$mpl	=	mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM mapel WHERE mapel.kd_mpel = '$dtjd[kd_mpel]'"));
						$kls	=	mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM kelas WHERE kelas.kd_kls ='$dtjd[kd_kls]'"));
						$rng	=	mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM cbt_peserta WHERE cbt_peserta.kd_kls ='$dtjd[kd_kls]';"));
						$jdw	=	mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM jdwl WHERE jdwl.kd_soal = '$dtjd[kd_soal]' AND sts='Y';"));
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

							$tgl = $jdw['tgl_uji'];

							if ($jam > 23) {
								$jam1 =  $jam - 24;
								$tgl  = date('Y-m-d', strtotime('+1 days', strtotime($tgl)));
							} else {
								$jam1 =  $jam;
							}

							if ($jam1 < 10) {
								$jam1 = '0' . $jam1;
							}

							if ($menit < 600) {
								$menit1 =  '0' . floor($menit / 60);
							} else {
								$menit1 =  floor($menit / 60);
							}
							$jam_ak = $jam1 . ':' . $menit1;
							$wktu = $tgl . ' ' . $jam_ak . ':00';
						}

						if ($dtjd['kls'] == 1) {
							$nkls = "Semua";
						} else {
							$nkls = $dtjd['kls'];
						}
						if ($dtjd['kd_kls'] == 1) {
							$nrng = "Semua";
						} else {
							$nrng = $rng['ruang'];
						}

					?>
						<tr class="<?php if ($jdw['tgl_uji'] . ' ' . $jam_ak <= date('Y-m-d H:i')) {
													echo "text-success ";
												} ?>" style="font-family: Alkatra;">
							<th scope="row"><?php echo $no++; ?></th>
							<?php if (!empty($jdw['jm_uji'])) { ?>
								<td><?php
										echo tgl_hari($jdw['tgl_uji']);
										?></td>
								<td><?php
										if (!empty($jdw['jm_uji'])) {
											echo date('H:i', strtotime($jdw['jm_uji'])) . '-' . $jam_ak;
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
									// echo $nkls . " | " . $nrng;
									echo $nrng;
								} else {
									echo "<div class='text-danger'>Kelas Belum Terpilih Pada Bank Soal</div>";
								} ?></td>
							<td><?php
									if (!empty($jdw['sts'])) {
										if ($jdw['sts'] == "Y") {
											if ($wktu <= date('Y-m-d H:i')) {
												echo "Selesai";
											} elseif ($jdw['tgl_uji'] . ' ' . $jdw['jm_uji'] >= date('Y-m-d H:i:s')) { ?>
											<script>
												var countDownDate<?php echo $jdw[0] ?> = new Date("<?php echo $jdw['tgl_uji'] . ' ' . $jdw['jm_uji']  . ':00' ?>").getTime();

												// Memperbarui hitungan mundur setiap 1 detik
												var x<?php echo $jdw[0] ?> = setInterval(function() {

													// Untuk mendapatkan tanggal dan waktu hari ini
													// var now = new Date().getTime();
													// Jam Server
													var xmlHttp;

													function srvTime() {
														try {
															//FF, Opera, Safari, Chrome
															xmlHttp = new XMLHttpRequest();
														} catch (err1) {
															//IE
															try {
																xmlHttp = new ActiveXObject("Msxml2.XMLHTTP");
															} catch (err2) {
																try {
																	xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
																} catch (eerr3) {
																	//AJAX not supported, use CPU time.
																	alert("AJAX not supported");
																}
															}
														}
														xmlHttp.open("HEAD", window.location.href.toString(), false);
														xmlHttp.setRequestHeader("Content-Type", "text/html");
														xmlHttp.send("");
														return xmlHttp.getResponseHeader("Date");
													}

													var st = srvTime();
													var now = new Date(st);

													// Temukan jarak antara sekarang dan tanggal hitung mundur
													var distance = countDownDate<?php echo $jdw[0] ?> - now;

													// Perhitungan waktu untuk hari, jam, menit dan detik
													var days = Math.floor(distance / (1000 * 60 * 60 * 24));
													var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
													var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
													var seconds = Math.floor((distance % (1000 * 60)) / 1000);

													// Keluarkan hasil dalam elemen dengan id = "lm_ujian"
													if (days != "0") {
														document.getElementById("lm_ujian<?php echo $jdw[0] ?>").innerHTML = days + " Hari, " + hours + ":" + minutes + ":" + seconds;
													} else {
														document.getElementById("lm_ujian<?php echo $jdw[0] ?>").innerHTML = hours + ":" + minutes + ":" + seconds;
													}

													// Jika hitungan mundur selesai, tulis beberapa teks 
													if (distance < 0) {
														clearInterval(x<?php echo $jdw[0] ?>);
														document.getElementById("lm_ujian<?php echo $jdw[0] ?>").innerHTML = "Ujian dimulai";
													}
												}, 1000);
											</script>
										<?php
												echo '<label class="time me-2" id="lm_ujian' . $jdw[0] . '">Waktu Ujian</label>';
											} else { ?>
											<script>
												var countDownDate<?php echo $jdw[0] ?> = new Date("<?php echo $wktu ?>").getTime();

												// Memperbarui hitungan mundur setiap 1 detik
												var x<?php echo $jdw[0] ?> = setInterval(function() {

													// Untuk mendapatkan tanggal dan waktu hari ini
													// var now = new Date().getTime();
													// Jam Server
													var xmlHttp;

													function srvTime() {
														try {
															//FF, Opera, Safari, Chrome
															xmlHttp = new XMLHttpRequest();
														} catch (err1) {
															//IE
															try {
																xmlHttp = new ActiveXObject("Msxml2.XMLHTTP");
															} catch (err2) {
																try {
																	xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
																} catch (eerr3) {
																	//AJAX not supported, use CPU time.
																	alert("AJAX not supported");
																}
															}
														}
														xmlHttp.open("HEAD", window.location.href.toString(), false);
														xmlHttp.setRequestHeader("Content-Type", "text/html");
														xmlHttp.send("");
														return xmlHttp.getResponseHeader("Date");
													}

													var st = srvTime();
													var now = new Date(st);

													// Temukan jarak antara sekarang dan tanggal hitung mundur
													var distance = countDownDate<?php echo $jdw[0] ?> - now;

													// Perhitungan waktu untuk hari, jam, menit dan detik
													var days = Math.floor(distance / (1000 * 60 * 60 * 24));
													var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
													var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
													var seconds = Math.floor((distance % (1000 * 60)) / 1000);

													// Keluarkan hasil dalam elemen dengan id = "lm_ujian"
													if (days != "0") {
														document.getElementById("lm_ujian<?php echo $jdw[0] ?>").innerHTML = days + " Hari, " + hours + ":" + minutes + ":" + seconds;
													} else {
														document.getElementById("lm_ujian<?php echo $jdw[0] ?>").innerHTML = hours + ":" + minutes + ":" + seconds;
													}

													// Jika hitungan mundur selesai, tulis beberapa teks 
													if (distance < 0) {
														clearInterval(x<?php echo $jdw[0] ?>);
														document.getElementById("lm_ujian<?php echo $jdw[0] ?>").innerHTML = "Waktu Habis";
													}
												}, 1000);
											</script>
								<?php
												echo '<label class="time me-2" id="lm_ujian' . $jdw[0] . '">Waktu Ujian</label>';
												// echo "Terjadwal";
											}
										} elseif ($jdw['sts'] == "N") {
											echo "Tidak Aktif";
										}
									} else {
										echo "Belum Terjadwal";
									}

								?>
							</td>
						</tr>

					<?php  } ?>
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