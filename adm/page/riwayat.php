<?php
include_once("../config/server.php");
include_once("../config/time_date.php");
include("db/setjdw_ujian.php");

?>

<style>
	#uj {
		display: flex;
	}

	.rwytuj {
		background-color: aqua;
	}

	/* Gaya tabel */
	.table-responsive th:nth-child(1),
	.table-responsive td:nth-child(1) {
		min-width: 20px;
		text-align: center;
		align-content: baseline;
	}

	.table-responsive th:nth-child(2),
	.table-responsive td:nth-child(2) {
		min-width: 150px;
		text-align: center;
		align-content: baseline;
	}

	.table-responsive th:nth-child(3),
	.table-responsive td:nth-child(3) {
		width: auto;
		min-width: 300px;
		text-align: left;
		align-content: baseline;
	}

	.table-responsive th:nth-child(4),
	.table-responsive td:nth-child(4) {
		min-width: 150px;
		/* text-align: center; */
		align-content: baseline;
	}

	.table-responsive th:nth-child(5),
	.table-responsive td:nth-child(5) {
		min-width: 60px;
		text-align: center;
		align-content: baseline;
	}

	.table-responsive th:nth-child(6),
	.table-responsive td:nth-child(6) {
		min-width: 170px;
		text-align: center;
		align-content: baseline;
	}

	.table-responsive th:nth-child(7),
	.table-responsive td:nth-child(7) {
		min-width: 150px;
		text-align: center;
		align-content: baseline;
	}

	.table-responsive th:nth-child(8),
	.table-responsive td:nth-child(8) {
		min-width: 150px;
		text-align: center;
	}

	.table-responsive th:nth-child(9),
	.table-responsive td:nth-child(9) {
		min-width: 80px;
		text-align: center;
	}

	.table-responsive th:nth-child(10),
	.table-responsive td:nth-child(10) {
		min-width: 150px;
		text-align: center;
	}

	.table-responsive th:nth-child(11),
	.table-responsive td:nth-child(11) {
		min-width: 80px;
		text-align: center;
	}
</style>

<div class="container-fluid mb-5 p-0">
	<div class="row p-2 border-bottom fs-3 mb-4 shadow-sm text-uppercase">Riwayat Ujian</div>
	<div class="table-responsive">
		<table class="table table-hover table-striped table-bordered border" id="jstable">
			<thead class="table-info text-center align-baseline">
				<tr class="align-middle">
					<th rowspan="2" style="min-width: 5%;">No.</th>
					<th rowspan="2" style="min-width: 7%;">Kode Soal</th>
					<th rowspan="2" style="min-width: 15%;">Mata Pelajaran</th>
					<th rowspan="2" style="min-width: 10%;">Kelas | Jurusan</th>
					<th rowspan="2" style="min-width: 5%;">Soal</th>
					<!-- <th colspan="4" style="min-width: 25%;">Pelaksanaan</th> -->
					<th style="min-width: 8%;">Tanggal</th>
					<th>Mulai-Akhir</th>
					<th style="min-width: 90px;">Batas | Durasi</th>
					<th>Token</th>
					<th rowspan="2" style="min-width: 5%;">Status Jadwal</th>
					<th rowspan="2" style="min-width: 5%;">Opsi</th>
				</tr>
				<!-- <tr>
				</tr> -->
			</thead>
			<tbody>
				<?php
				$no = 1;

				$dtmpl  = mysqli_query($koneksi, "SELECT * FROM jdwl WHERE sts !='Y' ORDER BY tgl_uji DESC");
				if (mysqli_num_rows($dtmpl) == 0) {
					echo "<tr><td colspan='11' class='text-center'>Tidak ada data riwayat ujian</td></tr>";
				}
				while ($dt = mysqli_fetch_array($dtmpl)) {
					// $dtt = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM kelas WHERE kd_kls ='$dt[kd_kls]';"));
					$mpel = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM mapel WHERE kd_mpel ='$dt[kd_mpel]'"));
					$jsl  = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM cbt_soal WHERE kd_soal ='$dt[kd_soal]'"));
					$jdwl = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM jdwl  WHERE kd_soal ='$dt[kd_soal]'"));
					$pkts = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM cbt_pktsoal WHERE kd_soal ='$dt[kd_soal]'"));

					if (!empty($dt['jm_uji'])) {
						$waktu_awal		= $dt['jm_uji'];
						$waktu_akhir	= $dt['lm_uji']; // bisa juga waktu sekarang now()

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

					if ($dt['kd_kls'] == "1") {
						$kkelas = "";
					} else {
						$kkelas = $dt['kd_kls'] . '_';
					}
					if ($dt['kls'] == "1") {
						$kelas = "Semua";
					} else {
						$kelas = $dt['kls'];
					}
					if ($dt['jur'] == "1") {
						$jurusan = "Semua";
					} else {
						$jurusan = $dt['jur'];
					}

				?>
					<tr align="center">
						<th><?= $no++ ?></th>
						<td><?= $dt['kd_soal'] ?></td>
						<td><?= $mpel['nm_mpel'] ?></td>
						<td><?= $kkelas . $kelas . ' | ' . $jurusan ?></td>
						<td><?= $jsl . '/' . $pkts['jum_soal'] ?></td>
						<td><?php if (!empty($dt['tgl_uji'])) echo tgl_hari($dt['tgl_uji']) ?></td>
						<td><?php
								if (!empty($dt['jm_uji'])) {
									echo date('H:i', strtotime($dt['jm_uji'])) . '-' . date('H:i', strtotime($dt['slsai_uji']));
									// if ($jam < 10) {
									// 	echo '0' . $jam;
									// } else {
									// 	echo $jam;
									// }
									// echo ':';
									// if ($menit < 600) {
									// 	echo '0' . floor($menit / 60);
									// } else {
									// 	echo floor($menit / 60);
									// }
								}
								?>
						</td>
						<td><?php if (!empty($dt['jm_uji'])) echo date('H:i', strtotime($dt['bts_login'])) . ' (<b>' . $batas . ' menit</b>)'; ?></td>
						<td><?php if (!empty($dt['token'])) {
									echo $dt['token'];
								} ?></td>
						<td class="text-center">
							<?php

							if (!empty($dt['sts'])) {
								if ($dt['sts'] == "Y" && $dt['tgl_uji'] != date("Y-m-d")) {
									echo "<a class='btn btn-sm btn-warning'>Aktif</a>";
								} elseif ($dt['sts'] == "Y") {
									echo "<a class='btn btn-sm btn-primary'>Aktif</a>";
								} elseif ($dt['sts'] == "N") {
									echo "<a class='btn btn-sm btn-danger'>Nonaktif</a>";
								} elseif ($dt['sts'] == "H") {
									echo "<a class='btn btn-sm btn-success'>Riwayat</a>";
								}
							} else {
								echo "<a class='btn btn-sm btn-info'>SET</a>";
							}

							?>
						</td>
						<td class="text-center">
							<button class="btn btn-sm btn-info fs-6 mb-1" data-bs-toggle="modal" data-bs-target="#mdlpsi<?= $dt[0] ?>"><i class="bi bi-gear"></i></button>
							<!-- | <button class="btn btn-sm btn-warning fs-6 mb-1"><i class="bi bi-pencil-square"></i></button> |
							<button class="btn btn-sm btn-danger fs-6"><i class="bi bi-trash3"></i></button> -->
						</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
	<div class="col-auto px-3 alert-success alert">
		<h4>Catatan :</h4>
		<table class="text-dark">
			<tr>
				<!-- <td><a class="btn btn-sm btn-primary" style="width: 80px;">Aktif</a></td>
				<td>Soal Siap untuk di ujikan</td> -->
			</tr>
			<tr>
				<td style="width: 100px;"><a class="btn btn-sm btn-warning">Aktif</a></td>
				<td>Soal tidak bisa di ujikan pastikan tanggal sesuai</td>
			</tr>
			<!-- <tr>
				<td><a class='btn btn-sm btn-info' style="width: 80px;">SET</a></td>
				<td> Soal Siap untuk di Jadwalkan</td>
			</tr> -->
			<tr>
				<td><a class='btn btn-sm btn-success'>Riwayat</a></td>
				<td> Soal tidak aktif namun dapat di ujikan kembali</td>
			</tr>
			<tr>
				<td><a class='btn btn-sm btn-danger'>Nonaktif</a></td>
				<td> Soal tidak aktif dan tidak dapat di ujikan</td>
			</tr>
		</table>
		<!-- <p>Jika Penjadwalan belum muncul atau data belum tersedia ataupun belum <a class="btn btn-sm btn-primary">Aktif</a> <br> silahkan aktifkan terlebih dahulu pada menu bank soal atau klik <a href="?md=soal">disini</a><br></p> -->
	</div>
</div>


<!--=== Modal ===-->
<?php
$dtmpl  = mysqli_query($koneksi, "SELECT * FROM jdwl ORDER BY tgl_uji DESC");
while ($dt = mysqli_fetch_array($dtmpl)) {
	$mpel	= mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM mapel WHERE kd_mpel ='$dt[kd_mpel]'"));
	$jsl	= mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM cbt_soal WHERE kd_soal ='$dt[kd_soal]'"));
	$dnt	= mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM jdwl WHERE kd_soal ='$dt[kd_soal]'"));
	$pkt	= mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM cbt_pktsoal WHERE kd_soal ='$dt[kd_soal]'"));

	if ($dt['kd_kls'] == "1") {
		$kkelas = "";
	} else {
		$kkelas = $dt['kd_kls'] . '_';
	}
	if ($dt['kls'] == "1") {
		$kelas = "Semua";
	} else {
		$kelas = $dt['kls'];
	}
	if ($dt['jur'] == "1") {
		$jurusan = "Semua";
	} else {
		$jurusan = $dt['jur'];
	}
?>
	<div class="modal modal-lg fade" id="mdlpsi<?= $dt[0] ?>" tabindex="-1" aria-labelledby="OpsiLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h1 class="modal-title fs-5" id="OpsiLabel">Pengaktifan Jadwal : <?= $mpel['nm_mpel'] ?></h1>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<form action="" method="post">
					<div class="modal-body">
						<div class="row">
							<div class="col-12 m-0 border-bottom">
								<table class="fw-normal caption-top">
									<caption class="fw-semibold text-decoration-underline text-black">Info Paket Soal</caption>
									<tr valign="top">
										<td style="width: 170px;">Kode Soal</td>
										<td>:</td>
										<td class="fw-bold"><?= $dt['kd_soal'] ?>
											<input type="text" hidden id="kds" name="kds" value="<?= $dt['kd_soal'] ?>">
										</td>
									</tr>
									<tr valign="top">
										<td style="width: 170px;">Mata Pelajaran</td>
										<td>:</td>
										<td class="fw-bold"><?= $mpel['nm_mpel'] ?>
											<input type="text" hidden id="kmpel" name="kmpel" value="<?php echo $mpel['kd_mpel'] ?>">
										</td>
									</tr>
									<tr valign="top">
										<td>Kelas (Jurusan)/ Sesi</td>
										<td>:</td>
										<td><?php echo $kkelas . $kelas . ' (' . $jurusan . ')/ ' . $dt['sesi'] ?>
											<input type="text" hidden id="kkls" name="kkls" value="<?php echo $dt['kd_kls'] ?>">
											<input type="text" hidden id="kls" name="kls" value="<?php echo $dt['kls'] ?>">
											<input type="text" hidden id="jur" name="jur" value="<?php echo $dt['jur'] ?>">
											<input type="text" hidden id="ses" name="ses" value="<?php echo $dt['sesi'] ?>">
										</td>
									</tr>
									<tr valign="top">
										<td>Pembuat Soal</td>
										<td>:</td>
										<td><?php echo $pkt['author'] ?></td>
										<input type="text" hidden id="author" name="author" value="<?php echo $pkt['author'] ?>">
									</tr>
									<tr valign="top">
										<td>Jumlah Data Soal</td>
										<td>:</td>
										<td>
											<?php if ($jsl < $pkt['jum_soal']) {
												echo '<u class="text-danger text-decoration-none">' . $jsl . ' data soal</u>, ';
											} elseif ($jsl == $pkt['jum_soal']) {
												echo '<u class="fw-semibold text-decoration-none">' . $jsl . ' data soal</u>, ';
											} else {
												echo '<u class="text-success text-decoration-none">' . $jsl . ' data soal</u>, ';
											}
											echo '' . $pkt['jum_soal'] . ' ditampilkan' ?></td>
									</tr>
								</table>
							</div>
						</div>
						<div class="row mt-3 g-2">
							<div class="col-6">
								<div class="input-group">
									<label class="input-group-text bg-success-subtle" for="mode_uji">Sifat Tes</label>
									<select class="form-select" id="mode_uji" name="mode_uji">
										<option value="0" <?php if ($dt['md_uji'] == "0") echo 'selected' ?>>Tertutup</option>
										<option value="1" <?php if ($dt['md_uji'] == "1") echo 'selected' ?>>Terbuka</option>
									</select>
									<input type="text" hidden id="pl_media" name="pl_media" value="<?php echo $dt['pl_m'] ?>">
								</div>
							</div>
							<div class="col-md-6 col-12">
								<div class="input-group">
									<span class="input-group-text bg-primary-subtle" id="basic-addon1" style="width: 115px;">Jenis Tes</span>
									<select class=" form-select" name="kd_tes" id="kd_tes" disabled>
										<option value="PH" <?= ($dt['kd_ujian'] == "PH") ? 'selected' : '' ?>>Penilaian Harian</option>
										<option value="PTS" <?= ($dt['kd_ujian'] == "PTS") ? 'selected' : '' ?>>Penilaian Tengah Semester</option>
										<option value="PAS" <?= ($dt['kd_ujian'] == "PAS") ? 'selected' : '' ?>>Penilaian Akhir Semester</option>
										<option value="UA" <?= ($dt['kd_ujian'] == "UA") ? 'selected' : '' ?>>Ujian Akhir</option>
									</select>
									<input type="text" hidden id="kdtes" name="kdtes" value="<?= $dt['kd_ujian'] ?>">
								</div>
							</div>
						</div>
						<div class="row mt-3 g-2">
							<div class="col-6">
								<div class="input-group">
									<span class="input-group-text bg-dark-subtle" id="basic-addon1" style="width: 100px;">Status</span>
									<select class="form-select" name="riwayat" id="riwayat">
										<option value="Y" <?php if ($dt['sts'] == "Y") echo 'selected' ?>>Ujian Aktif</option>
										<option value="H" <?php if ($dt['sts'] == "H") echo 'selected' ?>>Ujian Selesai</option>
										<option value="N" <?php if ($dt['sts'] == "N") echo 'selected' ?>>Nonaktif</option>
									</select>
								</div>
							</div>
							<div class="col-6">
								<div class="input-group">
									<span class="input-group-text bg-dark-subtle" id="basic-addon1" style="width: 100px;">Tanggal</span>
									<input type="date" id="tgl" name="tgl" class="form-control" value="<?php if (($dt['tgl_uji']) == date('Y-m-d')) {
																																												echo $dt['tgl_uji'];
																																											} else {
																																												echo date('Y-m-d');
																																											} ?>">
								</div>
							</div>
						</div>
						<div class="row mt-auto g-2">
							<div class="col-6">
								<div class="input-group">
									<span class="input-group-text bg-dark-subtle" id="basic-addon1" style="width: 100px;">Jam Mulai</span>
									<input type="time" id="jm_awal" name="jm_awal" class="form-control" value="<?php echo $dt['jm_uji'] ?>" required>
								</div>
							</div>
							<div class="col-6">
								<div class="input-group">
									<span class="input-group-text bg-dark-subtle" id="basic-addon1" style="width: 100px;">Jam Akhir</span>
									<input type="time" id="jm_akhir" name="jm_akhir" class="form-control" value="<?php echo $dt['slsai_uji'] ?>" required>
								</div>
							</div>
							<div class="col-6">
								<div class="input-group">
									<span class="input-group-text bg-dark-subtle" id="basic-addon1" style="width: 100px;">Durasi</span>
									<input type="number" id="durasi" name="durasi" class="form-control" value="<?php echo db_JamToMenit($dt['lm_uji']) ?>" required placeholder="Menit">
								</div>
							</div>
							<div class="col-6">
								<div class="input-group">
									<span class="input-group-text bg-dark-subtle" id="basic-addon1" style="width: 100px;">Telat Login</span>
									<input type="number" id="telat" name="telat" class="form-control" value="<?= selisihJamToMenit($dt['jm_uji'], $dt['bts_login']) ?>" required placeholder="Menit">
								</div>
							</div>
							<div class="col-6">
								<div class="input-group">
									<span class="input-group-text bg-dark-subtle" id="basic-addon1" style="width: 100px;">Token</span>
									<input type="text" id="token" name="token" class="form-control" value="<?php if (!empty($dt['token'])) {
																																														echo $dt['token'];
																																													} else {
																																														echo GeraHash(5);
																																													}  ?>" readonly>
									<select class="form-select" name="ttoken" id="ttoken">
										<option value="T">Tidak Tampil</option>
										<option value="Y">Tampil</option>
									</select>
								</div>
							</div>
							<!-- <div class="col-6">
								<div class="input-group">
									<span class="input-group-text" id="basic-addon1" style="width: 100px;">Token</span>
								</div>
							</div> -->
							<div class="col-6">
								<div class="input-group">
									<span class="input-group-text bg-dark-subtle" id="basic-addon1" style="width: 100px;">Nilai</span>
									<select class="form-select" name="nilai" id="nilai">
										<option value="T">Tidak Tampil</option>
										<option value="Y">Tampil</option>
									</select>
								</div>
							</div>
							<label for=""></label>
							<label for=""></label>
						</div>
					</div>
					<div class="modal-footer">
						<button type="submit" id="simpan" name="simpan" class="btn btn-primary">Simpan</button>
					</div>
				</form>
			</div>
		</div>
	</div>
<?php } ?>

<script src="../node_modules/jquery/dist/jquery.min.js"></script>
<script>
	document.addEventListener("DOMContentLoaded", function() {
		// Inisialisasi DataTables
		new simpleDatatables.DataTable("#jstable", {
			perPageSelect: [5, 10, 25, 50, "All"],
			perPage: 10,
			labels: {
				placeholder: "Cari...",
				perPage: " Data per halaman",
				noRows: "Tidak ada data yang ditemukan",
				info: "Menampilkan {start}/{end} dari {rows} Data",
			}
		});
	});
</script>