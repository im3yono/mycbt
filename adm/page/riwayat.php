<?php
include_once("../config/server.php");
include_once("../config/time_date.php");
include("db/setjdw_ujian.php");

// token Acak
function GeraHash($qtd)
{
	//Under the string $Caracteres you write all the characters you want to be used to randomly generate the code. 
	$Caracteres = 'ABCDEFGHIJKLMNPQRSTUVWXYZ12345789';
	//$Caracteres = 'abcdefghijklmnpqrstuvwxyz'; 
	// $Caracteres = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	//$Caracteres = '123456789'; 
	$QuantidadeCaracteres = strlen($Caracteres);
	$QuantidadeCaracteres--;
	$Hash = NULL;
	for ($x = 1; $x <= $qtd; $x++) {
		$Posicao = rand(0, $QuantidadeCaracteres);
		$Hash .= substr($Caracteres, $Posicao, 1);
	}
	return $Hash;
}
?>

<style>
		#uj {
		display: flex;
	}
	.rwytluj {
		background-color: aqua;
	}
</style>

<div class="container-fluid mb-5 p-0">
	<div class="row p-2 border-bottom fs-3 mb-4 shadow-sm text-uppercase">Riwayat Ujian</div>
	<div class="table-responsive">
		<table class="table table-hover table-striped table-bordered">
			<thead class="table-info text-center align-baseline">
				<tr class="align-middle">
					<th rowspan="2" style="min-width: 5%;">No.</th>
					<th rowspan="2" style="min-width: 7%;">Kode Soal</th>
					<th rowspan="2" style="min-width: 15%;">Mata Pelajaran</th>
					<th rowspan="2" style="min-width: 10%;">Kelas | Jurusan</th>
					<th rowspan="2" style="min-width: 5%;">Soal</th>
					<th colspan="4" style="min-width: 25%;">Pelaksanaan</th>
					<th rowspan="2" style="min-width: 5%;">Status Jadwal</th>
					<th rowspan="2" style="min-width: 5%;">Opsi</th>
				</tr>
				<tr>
					<th style="min-width: 8%;">Tanggal</th>
					<th>Jam</th>
					<th style="min-width: 90px;">Batas | Durasi</th>
					<th>Token</th>
				</tr>
			</thead>
			<tbody>
				<?php

				$batas = 10;
				$hal   = isset($_GET['pg']) ? (int)$_GET['pg'] : 1;
				$hal_awal = ($hal > 1) ? ($hal * $batas) - $batas : 0;

				$previous = $hal - 1;
				$next     = $hal + 1;

				$no = 1;
				$selectSQL = "SELECT * FROM jdwl";
				$data = mysqli_query($koneksi, $selectSQL);
				$jml_data = mysqli_num_rows($data);
				$tot_hal = ceil($jml_data / $batas);

				$dtmpl  = mysqli_query($koneksi, "SELECT * FROM jdwl WHERE jdwl.sts != 'Y' ORDER BY tgl_uji DESC limit $hal_awal,$batas");
				while ($dt = mysqli_fetch_array($dtmpl)) {
					// $dtt = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM kelas WHERE kd_kls ='$dt[kd_kls]';"));
					$mpel = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM mapel WHERE kd_mpel ='$dt[kd_mpel]'"));
					$jsl  = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM cbt_soal WHERE kd_soal ='$dt[kd_soal]'"));
					$jdwl = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM jdwl  WHERE kd_soal ='$dt[kd_soal]' AND sts!='Y'"));
					$pkts = mysqli_fetch_array(mysqli_query($koneksi,"SELECT * FROM cbt_pktsoal WHERE kd_soal ='$dt[kd_soal]'"));

					if (!empty($jdwl['jm_uji'])) {
						$waktu_awal		= $jdwl['jm_uji'];
						$waktu_akhir	= $jdwl['lm_uji']; // bisa juga waktu sekarang now()

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
						<th><?php echo $no++ ?></th>
						<td><?php echo $dt['kd_soal'] ?></td>
						<td><?php echo $mpel['nm_mpel'] ?></td>
						<td><?php echo $kkelas . $kelas . ' | ' . $jurusan ?></td>
						<td><?php echo $jsl . '/' . $pkts['jum_soal'] ?></td>
						<td><?php if (!empty($jdwl['tgl_uji'])) echo tgl_hari($jdwl['tgl_uji']) ?></td>
						<td><?php
								if (!empty($jdwl['jm_uji'])) {
									echo date('H:i', strtotime($jdwl['jm_uji'])) . '-';
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
								?>
						</td>
						<td><?php if (!empty($jdwl['jm_uji'])) echo date('H:i', strtotime($jdwl['bts_login'])) . ' | <br>' . $batas . ' menit'; ?></td>
						<td><?php if (!empty($jdwl['token'])) {
									echo $jdwl['token'];
								} ?></td>
						<td class="text-center">
							<?php

							if (!empty($jdwl['sts'])) {
								if ($jdwl['sts'] == "Y") {
									echo "<a class='btn btn-sm btn-primary'>Aktif</a>";
								} elseif ($jdwl['sts'] == "N") {
									echo "<a class='btn btn-sm btn-danger'>Nonaktif</a>";
								} elseif ($jdwl['sts'] == "H") {
									echo "<a class='btn btn-sm btn-success'>Riwayat</a>";
								}
							} else {
								echo "<a class='btn btn-sm btn-info'>SET</a>";
							}

							?>
						</td>
						<td class="text-center">
							<button class="btn btn-sm btn-info fs-6 mb-1" data-bs-toggle="modal" data-bs-target="#mdlpsi<?php echo $dt[0] ?>"><i class="bi bi-gear"></i></button>
							<!-- | <button class="btn btn-sm btn-warning fs-6 mb-1"><i class="bi bi-pencil-square"></i></button> |
							<button class="btn btn-sm btn-danger fs-6"><i class="bi bi-trash3"></i></button> -->
						</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
	<?php if ($jml_data >= $batas) { ?>
		<nav aria-label="Page navigation example">
			<ul class="pagination pagination-sm justify-content-end pe-3">
				<li class="page-item">
					<a class="page-link 
						<?php if ($hal == 1) {
							echo 'disabled';
						} ?>" <?php
									if ($hal > 1) {
										echo "href='?md=uj_set&pg=$previous'";
									} ?>><i class="bi bi-chevron-left"></i></a>
				</li>
				<?php
				for ($i = 1; $i <= $tot_hal; $i++) { ?>
					<li class="page-item 
        <?php if ($hal == $i) {
						echo 'active';
					} ?>"><a class="page-link" href="?md=uj_set&pg=<?php echo $i ?>"><?php echo $i; ?></a></li>
				<?php
				}
				?>
				<li class="page-item">
					<a class="page-link 
        <?php if ($hal == $tot_hal) {
					echo 'disabled';
				} ?>" <?php if ($hal < $tot_hal) {
								echo "href='?md=uj_set&pg=$next'";
							} ?>><i class="bi bi-chevron-right"></i></a>
				</li>
			</ul>
		</nav>
	<?php }
	// else{echo "<div class='col-12 text-center'>data kosong</div>";} 
	?>
	<div class="col-auto px-3 alert-success alert">
		<h4>Catatan :</h4>
		<table class="text-dark">
			<tr>
				<td><a class="btn btn-sm btn-primary" style="width: 80px;">Aktif</a></td>
				<td>Soal Siap untuk di ujikan</td>
			</tr>
			<tr>
				<td><a class='btn btn-sm btn-info' style="width: 80px;">SET</a></td>
				<td> Soal Siap untuk di Jadwalkan</td>
			</tr>
			<tr>
				<td><a class='btn btn-sm btn-success' style="width: 80px;">Riwayat</a></td>
				<td> Soal tidak aktif namun dapat di ujikan kembali</td>
			</tr>
			<tr>
				<td><a class='btn btn-sm btn-danger' style="width: 80px;">Nonaktif</a></td>
				<td> Soal tidak aktif dan tidak dapat di ujikan</td>
			</tr>
		</table>
		<!-- <p>Jika Penjadwalan belum muncul atau data belum tersedia ataupun belum <a class="btn btn-sm btn-primary">Aktif</a> <br> silahkan aktifkan terlebih dahulu pada menu bank soal atau klik <a href="?md=soal">disini</a><br></p> -->
	</div>
</div>


<!--=== Modal ===-->
<?php
$dtmpl  = mysqli_query($koneksi, "SELECT * FROM jdwl WHERE jdwl.sts != 'Y' ORDER BY tgl_uji DESC limit $hal_awal,$batas");
while ($dt = mysqli_fetch_array($dtmpl)) {
	$mpel = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM mapel WHERE kd_mpel ='$dt[kd_mpel]'"));
	$jsl  = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM cbt_soal WHERE kd_soal ='$dt[kd_soal]'"));
	$jdwl = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM jdwl WHERE kd_soal ='$dt[kd_soal]' AND sts!='Y'"));

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
	<div class="modal modal-lg fade" id="mdlpsi<?php echo $dt[0] ?>" tabindex="-1" aria-labelledby="OpsiLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h1 class="modal-title fs-5" id="OpsiLabel">Pengaktifan Jadwal : <?php echo $mpel['nm_mpel'] ?></h1>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<form action="" method="post">
					<div class="modal-body">
						<div class="row">
							<div class="col-12 m-0 border-bottom">
								<table class="fw-normal caption-top">
									<caption class="fw-semibold text-decoration-underline">Info Paket Soal</caption>
									<tr valign="top">
										<td style="width: 170px;">Kode Soal</td>
										<td>:</td>
										<td class="fw-bold"><?php echo $dt['kd_soal'] ?>
											<input type="text" hidden id="kds" name="kds" value="<?php echo $dt['kd_soal'] ?>">
										</td>
									</tr>
									<tr valign="top">
										<td style="width: 170px;">Mata Pelajaran</td>
										<td>:</td>
										<td class="fw-bold"><?php echo $mpel['nm_mpel'] ?>
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
										<td><?php echo $dt['author'] ?></td>
									</tr>
									<tr valign="top">
										<td>Jumlah Data Soal</td>
										<td>:</td>
										<td>
											<?php if ($jsl < $pkts['jum_soal']) {
												echo '<u class="text-danger text-decoration-none">' . $jsl . ' data soal</u>, ';
											} elseif ($jsl == $pkts['jum_soal']) {
												echo '<u class="fw-semibold text-decoration-none">' . $jsl . ' data soal</u>, ';
											} else {
												echo '<u class="text-success text-decoration-none">' . $jsl . ' data soal</u>, ';
											}
											echo '' . $pkts['jum_soal'] . ' ditampilkan' ?></td>
									</tr>
								</table>
							</div>
						</div>
						<div class="row mt-3 g-2">
							<div class="col-6">
								<div class="input-group">
									<span class="input-group-text bg-dark-subtle" id="basic-addon1" style="width: 100px;">Tanggal</span>
									<input type="date" id="tgl" name="tgl" class="form-control" value="<?php if (!empty($jdwl['tgl_uji'])) {
																																												echo $jdwl['tgl_uji'];
																																											} else {
																																												echo date('Y-m-d');
																																											} ?>">
								</div>
							</div>
							<div class="col-6">
								<div class="input-group">
									<span class="input-group-text bg-dark-subtle" id="basic-addon1" style="width: 100px;">Jam Mulai</span>
									<input type="time" id="jm_awal" name="jm_awal" class="form-control" value="<?php echo $jdwl['jm_uji'] ?>" required>
								</div>
							</div>
							<div class="col-6">
								<div class="input-group">
									<span class="input-group-text bg-dark-subtle" id="basic-addon1" style="width: 100px;">Durasi</span>
									<input type="number" id="durasi" name="durasi" class="form-control" value="<?php echo selisihJamToMenit($jdwl['jm_uji'], $jdwl['lm_uji']) ?>" required placeholder="Menit">
								</div>
							</div>
							<div class="col-6">
								<div class="input-group">
									<span class="input-group-text bg-dark-subtle" id="basic-addon1" style="width: 100px;">Telat Login</span>
									<input type="number" id="telat" name="telat" class="form-control" value="<?php echo selisihJam($jdwl['jm_uji'], $jdwl['bts_login']) ?>" required placeholder="Menit">
								</div>
							</div>
							<div class="col-6">
								<div class="input-group">
									<span class="input-group-text bg-dark-subtle" id="basic-addon1" style="width: 100px;">Token</span>
									<input type="text" id="token" name="token" class="form-control" value="<?php if (!empty($jdwl['token'])) {
																																														echo $jdwl['token'];
																																													} else {
																																														echo GeraHash(5);
																																													}  ?>">
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

<script src="../../node_modules/jquery/dist/jquery.min.js"></script>
<script>


</script>