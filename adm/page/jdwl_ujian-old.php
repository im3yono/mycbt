<?php

?>

<style>
	#uj {
		display: flex;
	}

	.jdwluj {
		background-color: aqua;
	}
</style>

<div class="container-fluid mb-5 p-0">
	<div class="row p-2 border-bottom fs-3 mb-4 shadow-sm ">Jadwal Ujian</div>
	<div class="col table-responsive">
		<table class="table table-hover table-bordered" id="jstable">
			<thead class="table-info text-center align-baseline">
				<tr>
					<th style="max-width: 50px;">No.</th>
					<th style="max-width: 100px;">Hari, Tanggal</th>
					<th style="max-width: 100px;">Token</th>
					<th style="width: 10%;">Jam <br> Mulai-Akhir</th>
					<th style="width: 10%">Lama Ujian</th>
					<th style="width: 300px">Mata Pelajaran</th>
					<th style="width: 200px">Pembuat</th>
					<th style="width: 10%;">Kelas | Ruang</th>
					<th style="width: 12%;">Status</th>
					<th style="max-width: 60px;">Opsi</th>
				</tr>
			</thead>
			<tbody class=" text-center align-items-baseline">
				<?php
				$jdwl	=	mysqli_query($koneksi, "SELECT * FROM jdwl ORDER BY jdwl.tgl_uji DESC");
				$no		= 1;

				while ($dtjd = mysqli_fetch_array($jdwl)) {
					$mpl	=	mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM mapel WHERE mapel.kd_mpel = '$dtjd[kd_mpel]'"));
					$kls	=	mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM kelas WHERE kelas.kd_kls ='$dtjd[kd_kls]'"));
					$rng	=	mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM cbt_peserta WHERE cbt_peserta.kd_kls ='$dtjd[kd_kls]';"));
					$jdw	=	mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM jdwl WHERE jdwl.kd_soal = '$dtjd[kd_soal]' AND sts='Y';"));
					$pkts = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM cbt_pktsoal WHERE kd_soal = '$dtjd[kd_soal]' AND sts='Y'"));
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
						<td class="text-wrap"><?php
																	echo tgl_hari($jdw['tgl_uji']);
																	?>
						</td>
						<td>
							<?= $dtjd['token']; ?>
						</td>
						<td><?php
								if (!empty($jdw['jm_uji'])) {
									echo date('H:i', strtotime($jdw['jm_uji'])) . '-' . $jam_ak;
								}
								?>
						</td>
						<td><?php echo $batas . ' menit'; ?></td>
						<td><?php if (!empty($dtjd['kd_mpel'])) {
									echo $mpl['nm_mpel'];
								} else {
									echo "<div class='text-danger'>Mata Pelajaran Belum Terpilih Pada Bank Soal</div>";
								} ?>
						</td>
						<td>
							pembuat
						</td>
						<td>
							<?php if (!empty($dtjd['kd_kls'])) {
								echo $nkls . " | " . $nrng;
							} else {
								echo "<div class='text-danger'>Kelas Belum Terpilih Pada Bank Soal</div>";
							} ?>
						</td>
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
											echo '<label class="time me-2 text-info" id="lm_ujian' . $jdw[0] . '">Waktu Ujian</label>';
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
											echo '<label class="time me-2 text-primary" id="lm_ujian' . $jdw[0] . '">Waktu Ujian</label>';
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
						<td>
							<!-- <button class="btn btn-sm btn-info fs-6 mb-1"><i class="bi bi-eye"></i></button> -->
							<button class="btn btn-sm btn-primary fs-6 m-1" data-bs-toggle="modal" data-bs-target="#mdlpsi<?php echo $dt[0] ?>"><i class="bi bi-gear"></i></button>
							<!-- <button class="btn btn-sm btn-warning fs-6 mb-1"><i class="bi bi-pencil-square"></i></button> -->
							<button class="btn btn-sm btn-danger fs-6 m-1"><i class="bi bi-trash3"></i></button>
						</td>
					</tr>

				<?php  } ?>
			</tbody>
		</table>
	</div>
</div>


<script>
	document.addEventListener("DOMContentLoaded", function() {
		// Inisialisasi Simple-DataTables pada tabel
		var dataTable = new simpleDatatables.DataTable("#jsdata", {
			perPageSelect: [5, 10, 25, 50, 'All'],
			perPage: 5,
			labels: {
				placeholder: "Cari...",
				perPage: " Data per halaman",
				noRows: "Tidak ada data yang ditemukan",
				info: "Menampilkan {start}/{end} dari {rows} Data",
			}
		});
	});
</script>