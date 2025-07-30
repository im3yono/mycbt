<?php
// include_once("../../config/server.php");
$dt_ps = mysqli_fetch_array(mysqli_query($koneksi, "SELECT COUNT(*)AS jml_ps FROM cbt_peserta;"));
$dt_rg = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM cbt_peserta GROUP BY ruang;"));
$dt_kls = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM kelas"));
$dt_mpl = mysqli_fetch_array(mysqli_query($koneksi, "SELECT COUNT(*)AS jml_mpl FROM mapel;"));
$dt_soal = mysqli_fetch_array(mysqli_query($koneksi, "SELECT COUNT(*)AS jml_soal FROM cbt_pktsoal;"));
$dt_btsoal = mysqli_fetch_array(mysqli_query($koneksi, "SELECT COUNT(*)AS jml_btsoal FROM cbt_soal;"));

// Level user
if ($dt_adm['lvl'] == "A") {
	$levs = "Admin";
} elseif ($dt_adm['lvl'] == "U") {
	$levs = "User";
} elseif ($dt_adm['lvl'] == "X") {
	$levs = "Pengawas Ruangan";
}


?>
<style>
	.border-cs {
		height: 150px;
		margin: 10px;
		/* width: 300px; */
		border-radius: 10px;
		/* background-color: aqua; */
		background: rgb(175, 242, 255);
		background: linear-gradient(280deg, rgba(175, 242, 255, 1) 0%, rgba(216, 249, 255, 1) 40%, rgba(255, 255, 255, 1) 80%);
		box-shadow: 10px 10px 25px lightslategray;
	}

	.border-cs:hover {
		transform: translateY(5px);
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
		background: linear-gradient(145deg, rgba(227, 227, 227, 1) 10%, rgba(236, 236, 236, 1) 26%, rgba(251, 251, 251, 1) 81%);
		box-shadow: 0.5px 1.5px 1px inset;
	}

	.dsh {
		background-color: aqua;
		z-index: 2;
	}

	h2 {
		font-family: Sherman;
		font-size: 45px;
	}

	.sync {
		box-shadow: 1px 1px 7px;
	}

	.jdwl-uj {
		border-radius: 7px;
		margin: 2px;
		box-shadow: 0 0 7px;
	}
</style>
<div class="app-content-header">
	<!-- <div class="container-fluid">
		<div class="row">
			<div class="col-sm-6">
				<h3 class="mb-0">Dashboard</h3>
			</div>
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-end">
					<li class="breadcrumb-item"><a href="#">Home</a></li>
					<li class="breadcrumb-item active" aria-current="page">Dashboard</li>
				</ol>
			</div>
		</div>
	</div> -->
</div>
<div class="app-content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-xxl-7 col-12">
				<div class="row m-0">
					<!--begin::Col-->
					<div class="col-lg-4 col-6">
						<!--begin::Small Box Widget 1-->
						<div class="small-box text-bg-primary">
							<div class="inner">
								<h2><?= $dt_mpl['jml_mpl'] ?></h2>
								<p>Mata Pelajaran</p>
							</div>
							<img class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true" src="../aset/icon/book_open.svg" alt="" srcset="">
							<a href="?md=mpl" class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover"> Selengkapnya <i class="bi bi-link-45deg"></i> </a>
						</div>
						<!--end::Small Box Widget 1-->
					</div>
					<!--end::Col-->
					<div class="col-lg-4 col-6">
						<!--begin::Small Box Widget 2-->
						<div class="small-box text-bg-success">
							<div class="inner">
								<h2><?= $dt_kls ?></h2>
								<p>Kelas</p>
							</div>
							<img class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true" src="../aset/icon/local_library.svg" alt="" srcset="">
							<a href="?md=kls" class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover"> Selengkapnya <i class="bi bi-link-45deg"></i> </a>
						</div>
						<!--end::Small Box Widget 2-->
					</div>
					<!--end::Col-->
					<div class="col-lg-4 col-6">
						<!--begin::Small Box Widget 3-->
						<div class="small-box text-bg-warning">
							<div class="inner">
								<h2><?= $dt_soal['jml_soal'] ?></h2>
								<p>Paket Soal</p>
							</div>
							<img class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true" src="../aset/icon/box.svg" alt="" srcset="">
							<a href="?md=soal" class="small-box-footer link-dark link-underline-opacity-0 link-underline-opacity-50-hover"> Selengkapnya <i class="bi bi-link-45deg"></i> </a>
						</div>
						<!--end::Small Box Widget 3-->
					</div>
					<!--end::Col-->
					<div class="col-lg-4 col-6">
						<!--begin::Small Box Widget 4-->
						<div class="small-box text-bg-danger">
							<div class="inner">
								<h2><?= $dt_ps['jml_ps'] ?></h2>
								<p>Peserta</p>
							</div>
							<img class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true" src="../aset/icon/person_group.svg" alt="" srcset="">
							<a href="?md=sis" class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover"> Selengkapnya <i class="bi bi-link-45deg"></i> </a>
						</div>
						<!--end::Small Box Widget 4-->
					</div>
					<!--end::Col-->
					<div class="col-lg-4 col-6">
						<!--begin::Small Box Widget 4-->
						<div class="small-box text-bg-info">
							<div class="inner">
								<h2><?= $dt_rg ?></h2>
								<p>Ruang</p>
							</div>
							<img class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true" src="../aset/icon/door_sliding.svg" alt="" srcset="">
							<a href="?md=sis" class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover"> Selengkapnya <i class="bi bi-link-45deg"></i> </a>
						</div>
						<!--end::Small Box Widget 4-->
					</div>
					<!--end::Col-->
				</div>
			</div>
			<div class="col-xxl-5 col-12 mt-1 mb-4">
				<div class="row px-4 gap-4">
					<!-- Welcome -->
					<?php if ($dt_adm['lvl'] == "A") { ?>
						<div class="col-xxl-12 col-lg col-12 bg-info sync" style="border-radius: 5px;">
							<div class="col-12 p-2 py-4 h1 text-white text-uppercase" style="font-family: Alkatra;">STATUS SERVER : <?= $server_ms['lev_svr'] == "C" ? "Client" : "Master"; ?></div>
							<div class="col-12 p-3 bg-light" style="border-radius: 8px;" id="status_koneksi">Aplikasi digunakan sebagai Server <?= $server_ms['lev_svr'] == "C" ? "Client" : "Master"; ?></div>
							<div class="row">
								<div class="col-sm-6 col-12 py-3 fs-3">Server ID : <span class="h3 badge bg-primary"><?= $inf_id; ?></span></div>
								<div class="col-sm-6 col-12 py-3 fs-3 text-sm-end" <?= ($server_ms['lev_svr'] == "M") ? 'hidden' : ''; ?>>
									<!-- <a href="?md=synccl" class="btn btn-primary fs-4"><i class="bi bi-arrow-down-up"></i> Singkronisasi</a> -->
									<button type="button" class="btn btn-primary fs-5" onclick="tesKoneksi('<?= $server_ms['ip_sv']; ?>','<?= $server_ms['db_svr']; ?>','<?= $inf_id; ?>')"><i class="bi bi-arrow-down-up"></i> Singkronisasi</button>
								</div>
							</div>
						</div>
					<?php } ?>
					<div class="col-xxl-12 col-lg col-12 p-0">
						<div class="col cl p-3 mb-2 fs-3" style="border-radius: 5px;">Selamat Datang <?= $levs ?> </div>
						<?php if ($dt_adm['lvl'] == "A") { ?>
							<div class="col px-4 py-2 cl" style="border-radius: 5px;">
								Selamat datang, Admin! Terima kasih atas kerja keras dan dukungan Anda dalam memastikan kelancaran seluruh proses ujian. Dedikasi Anda dalam mengelola administrasi sangat berarti bagi suksesnya pelaksanaan ujian. Semoga semua berjalan lancar!
							</div>
						<?php } elseif ($dt_adm['lvl'] == "U") { ?>
							<div class="col px-4 py-2 cl" style="border-radius: 5px;">
								Selamat datang, Bapak/Ibu Guru dan Tim Pembuat Soal! Terima kasih atas dedikasi dan kerja keras Anda dalam menyusun soal ujian yang berkualitas. Kontribusi Anda sangat berarti dalam menciptakan proses evaluasi yang adil dan bermutu. Semoga semua persiapan berjalan lancar!
							</div>
						<?php } elseif ($dt_adm['lvl'] == "X") { ?>
							<div class="col px-4 py-2 cl" style="border-radius: 5px;">
								Selamat datang, Bapak/Ibu Pengawas Ruangan Ujian! Terima kasih atas dedikasi dan kerja samanya dalam memastikan kelancaran serta kejujuran pelaksanaan ujian. Semoga tugas hari ini berjalan lancar!
							</div>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
		<?php
		$ck_jdwl	=	(mysqli_query($koneksi, "SELECT * FROM jdwl WHERE sts!='N' ORDER BY tgl_uji, jm_uji ASC"));
		if (mysqli_num_rows($ck_jdwl) != 0) { ?>
			<div class="row">
				<div class="col-12">
					<div class="card card-outline card-success">
						<div class="card-header">
							<h3 class="card-title">Jadwal Ujian</h3>
							<div class="card-tools">
								<button type="button" class="btn btn-tool" data-lte-toggle="card-collapse">
									<i data-lte-icon="expand" class="bi bi-plus-lg"></i>
									<i data-lte-icon="collapse" class="bi bi-dash-lg"></i>
								</button>
								<button type="button" class="btn btn-tool" data-lte-toggle="card-maximize">
									<i data-lte-icon="maximize" class="bi bi-fullscreen"></i>
									<i data-lte-icon="minimize" class="bi bi-fullscreen-exit"></i>
								</button>
							</div>
							<!-- /.card-tools -->
						</div>
						<!-- /.card-header -->
						<div class="card-body">
							<div class="col table-responsive">
								<table class="table table-hover table-bordered">
									<thead class="table-info text-center align-baseline">
										<tr>
											<th style="width: 5%;">No.</th>
											<th style="width: 13%;">Hari, Tanggal</th>
											<th style="width: 10%;">Jam <br>Mulai-Akhir</th>
											<th style="width: 10%">Token <br>Lama Ujian</th>
											<th style="width: 27%;">Mata Pelajaran</th>
											<th style="width: 10%;">Ruang</th>
											<th style="width: 12%;">Status</th>
										</tr>
									</thead>
									<tbody class=" text-center align-items-baseline">
										<?php
										$jdwl	=	mysqli_query($koneksi, "SELECT * FROM jdwl WHERE sts!='N' ORDER BY tgl_uji, jm_uji ASC");
										$no		= 1;

										while ($dtjd = mysqli_fetch_array($jdwl)) {
											$mpl	=	mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM mapel WHERE mapel.kd_mpel = '$dtjd[kd_mpel]'"));
											$kls	=	mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM kelas WHERE kelas.kd_kls ='$dtjd[kd_kls]'"));
											$rng	=	mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM cbt_peserta WHERE cbt_peserta.kd_kls ='$dtjd[kd_kls]';"));
											$jdw	=	mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM jdwl WHERE jdwl.kd_soal = '$dtjd[kd_soal]' AND token='$dtjd[token]';"));

											if (!empty($jdw['sts'])) {
												$jdwsts = $jdw['sts'];
											} else {
												$jdwsts = 0;
											}
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
												<th scope="row"><?= $no++; ?></th>
												<?php if (!empty($jdw['jm_uji'])) { ?>
													<td><?php
															echo tgl_hari($jdw['tgl_uji']);
															?></td>
													<td><?php
															if (!empty($jdw['jm_uji'])) {
																echo date('H:i', strtotime($jdw['jm_uji'])) . '-' . $jam_ak;
															}
															?></td>
													<td><?= $dtjd['token'] . '<br>' . $batas . ' menit'; ?></td>
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
														if ($jdwsts == "H") {
															echo "Selesai";
														} elseif (!empty($jdwsts)) {
															if ($jdwsts == "Y") {
																if ($wktu <= date('Y-m-d H:i')) {
																	echo "Selesai";
																} elseif ($jdw['tgl_uji'] . ' ' . $jdw['jm_uji'] >= date('Y-m-d H:i:s')) { ?>
																<script>
																	var countDownDate<?= $jdw[0] ?> = new Date("<?= $jdw['tgl_uji'] . ' ' . $jdw['jm_uji']  . ':00' ?>").getTime();

																	// Memperbarui hitungan mundur setiap 1 detik
																	var x<?= $jdw[0] ?> = setInterval(function() {

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
																		var distance = countDownDate<?= $jdw[0] ?> - now;

																		// Perhitungan waktu untuk hari, jam, menit dan detik
																		var days = Math.floor(distance / (1000 * 60 * 60 * 24));
																		var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
																		var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
																		var seconds = Math.floor((distance % (1000 * 60)) / 1000);

																		// Keluarkan hasil dalam elemen dengan id = "lm_ujian"
																		if (days != "0") {
																			document.getElementById("lm_ujian<?= $jdw[0] ?>").innerHTML = days + " Hari, " + hours + ":" + minutes + ":" + seconds;
																		} else {
																			document.getElementById("lm_ujian<?= $jdw[0] ?>").innerHTML = hours + ":" + minutes + ":" + seconds;
																		}

																		// Jika hitungan mundur selesai, tulis beberapa teks 
																		if (distance < 0) {
																			clearInterval(x<?= $jdw[0] ?>);
																			document.getElementById("lm_ujian<?= $jdw[0] ?>").innerHTML = "Ujian dimulai";
																		}
																	}, 1000);
																</script>
															<?php
																	echo '<label class="time me-2" id="lm_ujian' . $jdw[0] . '">Waktu Ujian</label>';
																} else { ?>
																<script>
																	var countDownDate<?= $jdw[0] ?> = new Date("<?= $wktu ?>").getTime();

																	// Memperbarui hitungan mundur setiap 1 detik
																	var x<?= $jdw[0] ?> = setInterval(function() {

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
																		var distance = countDownDate<?= $jdw[0] ?> - now;

																		// Perhitungan waktu untuk hari, jam, menit dan detik
																		var days = Math.floor(distance / (1000 * 60 * 60 * 24));
																		var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
																		var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
																		var seconds = Math.floor((distance % (1000 * 60)) / 1000);

																		// Keluarkan hasil dalam elemen dengan id = "lm_ujian"
																		if (days != "0") {
																			document.getElementById("lm_ujian<?= $jdw[0] ?>").innerHTML = days + " Hari, " + hours + ":" + minutes + ":" + seconds;
																		} else {
																			document.getElementById("lm_ujian<?= $jdw[0] ?>").innerHTML = hours + ":" + minutes + ":" + seconds;
																		}

																		// Jika hitungan mundur selesai, tulis beberapa teks 
																		if (distance < 0) {
																			clearInterval(x<?= $jdw[0] ?>);
																			document.getElementById("lm_ujian<?= $jdw[0] ?>").innerHTML = "Waktu Habis";
																		}
																	}, 1000);
																</script>
													<?php
																	echo '<label class="time me-2" id="lm_ujian' . $jdw[0] . '">Waktu Ujian</label>';
																	// echo "Terjadwal";
																}
															} elseif ($jdwsts == "N") {
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
						<!-- /.card-body -->
					</div>
					<!-- /.card -->
				</div>
			</div>
		<?php } ?>
	</div>
</div>


<!-- === JavaScript === -->
<script>
	function tesKoneksi(ip, db, sv) {
		var statusKoneksi = document.getElementById("status_koneksi");
		statusKoneksi.innerHTML = "Menghubungkan Server Pusat...";

		var timeout = setTimeout(() => {
			statusKoneksi.innerHTML = '<span class="alert alert-danger p-1" role="alert">Periksa kembali pengaturan Server Master atau jaringan yang anda miliki.</span>';
			Swal.fire('Timeout', 'Tidak ada respon dari server master setelah 30 detik.', 'warning');
		}, 30000); // 1 menit timeout

		$.ajax({
			url: "../config/m_db.php?sm=sync",
			type: "POST",
			contentType: "application/x-www-form-urlencoded",
			data: {
				ip: ip,
				db: db,
				sv: sv,
			},
			success: function(response) {
				clearTimeout(timeout); // Hentikan timeout jika ada respon
				if (response.trim().startsWith("?")) { // Cek jika respons mengandung redirect
					setTimeout(() => {
						window.location.href = response.trim() + "&st=ok";
					}, 1000);
				} else if (response.trim().startsWith("=")) {
					if ($('#status_koneksi').length) {
						$('#status_koneksi').removeClass('bg-light bg-danger-subtle').addClass('bg-warning-subtle');
					}
					statusKoneksi.innerHTML = 'Server yang Anda tuju bukan merupakan Server Master.';
				} else {
					if ($('#status_koneksi').length) {
						$('#status_koneksi').removeClass('bg-light bg-warning-subtle').addClass('bg-danger-subtle');
					}
					statusKoneksi.innerHTML = response; // Tampilkan pesan dari server
				}
			},
			error: function(xhr, status, error) {
				clearTimeout(timeout); // Hentikan timeout jika ada error
				statusKoneksi.innerHTML = "Terjadi kesalahan koneksi: " + xhr.responseText;
				Swal.fire('Error', 'Terjadi kesalahan koneksi: ' + xhr.responseText, 'error');
			}
		});
	}
</script>