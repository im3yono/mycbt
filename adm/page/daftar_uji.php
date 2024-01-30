<?php
include_once("../config/server.php");

$qr_dtuj	= mysqli_query($koneksi, "SELECT * FROM jdwl WHERE sts ='Y';");
?>

<style>
	.dfuji {
		background-color: aqua;
	}
</style>

<div class="container-fluid mb-5 p-0">
	<div class="row p-2 border-bottom fs-3 mb-4 shadow-sm ">Daftar Ujian</div>
	<div class="row g-2 pb-3">
		<div class="col-12 col-md-8">
			<div class="col-auto"><a href="?md=rst_uji" class="btn btn-danger">Request Reset</a></div>
			<div class="col-auto"></div>
			<div class="col-auto"></div>
		</div>
		<!-- <div class="col col-md-4">
			<div class="row">
				<div class="col-auto">
					<div class="btn btn-outline-primary p-1"><i class="bi bi-check2"></i></div> Selesai
				</div>
				<div class="col-auto">
					<div class="btn btn-outline-warning p-1"><i class="bi bi-arrow-clockwise"></i></div> Reset
				</div>
				<div class="col-auto">
					<div class="btn btn-outline-danger p-1"><i class="bi bi-x-circle"></i></div> Mengerjakan
				</div>
			</div>
		</div> -->
	</div>
	<div class="table-responsive">
		<table class="table table-hover table-bordered">
			<thead class="table-info text-center align-baseline">
				<tr class="align-middle">
					<th style="min-width: 5%;">No.</th>
					<th style="min-width: 100px;">Kode Soal</th>
					<th style="width: 250px;">Mata Pelajaran</th>
					<!-- <th style="min-width: 10%;">Kelas | Jurusan</th> -->
					<th style="width: 50px;">Jumlah Soal</th>
					<!-- <th style="min-width: 50px;">Ruang</th> -->
					<th style="width: 30px;">Sesi</th>
					<!-- <th style="min-width: 90px;">Login</th> -->
					<th style="min-width: 100px;">Status</th>
					<th class="p-0" style="width: 50px;">Tampil</th>
					<th style="min-width: 50px;">Token</th>
					<th style="width: 80px;">Action</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$no = 1;
				$qr_dtuj	= mysqli_query($koneksi, "SELECT * FROM jdwl WHERE sts!='H' ORDER BY tgl_uji DESC");
				while ($row = mysqli_fetch_array($qr_dtuj)) {
					if (!empty($row['jm_uji'])) {
						$waktu_awal		= $row['jm_uji'];
						$waktu_akhir	= $row['lm_uji']; // bisa juga waktu sekarang now()

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

						$tgl = $row['tgl_uji'];

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

					$mpel = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM mapel WHERE kd_mpel='$row[kd_mpel]'"));
					$pkt_s = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM cbt_pktsoal WHERE kd_soal='$row[kd_soal]'"));
					$sts = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM peserta_tes WHERE token ='$row[token]' AND kd_soal='$row[kd_soal]' AND sts='U'"));
					$cek_es = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM cbt_ljk WHERE jns_soal ='E' AND nil_esai ='0' AND token ='$row[token]' AND kd_soal='$row[kd_soal]';"));

				?>
					<tr align="center" class="align-middle">
						<th><?php echo $no; ?></th>
						<td><?php echo $row['kd_soal']; ?></td>
						<td class="text-start">
							<!-- <input type="text" name="user" id="user" value="<?php echo $row['user']; ?>" hidden> -->
							<?php echo $mpel['nm_mpel']; ?>
						</td>
						<!-- <td>1|IPA</td> -->
						<td>
							<?php echo $pkt_s['jum_soal']; ?>
						</td>
						<!-- <td>
							<?php echo $row['ruang']; ?>
						</td> -->
						<td class="p-1">
							<?php echo $row['sesi']; ?>
						</td>
						<!-- <td>08:03:47</td> -->
						<td>
							<?php echo tgl_hari($row['tgl_uji']) . "<br>" . date('H:i', strtotime($row['jm_uji'])) . "-" . $jam_ak; ?>
						</td>
						<td class="p-1">
							<?php
							if ($row['sts_token'] == "Y") {
								$ttoken = "btn-primary";
								$stoken = "T";
							} else {
								$ttoken = "btn-outline-primary";
								$stoken = "Y";
							}
							if ($row['sts_nilai'] == "Y") {
								$tnil = "btn-info";
								$snil = "T";
							} else {
								$tnil = "btn-outline-info";
								$snil = "Y";
							}
							?>
							<a href="?md=dbup&up=token&kds=<?php echo $row['kd_soal'] . '&token=' . $row['token'] . '&s=' . $stoken; ?>" class="btn btn-sm m-1 <?php echo $ttoken ?>" style="width: 70px;">Token</a>
							<a href="?md=dbup&up=nilai&kds=<?php echo $row['kd_soal'] . '&token=' . $row['token'] . '&s=' . $snil; ?>" class="btn btn-sm m-1 <?php echo $tnil ?>" style="width: 70px;">Hasil</a>
						</td>
						<td class="align-middle">
							<a href="?md=dfu_ps&tk=<?php echo $row['token']; ?>" class="btn btn-lg fw-semibold btn-outline-primary m-0 p-1" style="min-width: 170px;"><?php echo $row['token'] ?></a>
						</td>
						<td>
							<?php
							if ($row['tgl_uji'] == date('Y-m-d')) {
								if ($jam_ak >= date('H:i')) {
									if ($sts == "0") {
										if ($cek_es != "0") {
											if ($pkt_s['esai'] != "0") { ?>
												<a href="?md=priksa_esai&kds=<?php echo $row['kd_soal'] ?>&tkn=<?php echo $row['token'] . '&mpel=' . $row['kd_mpel'] ?>" class="btn btn-sm btn-outline-primary m-1" id="esai" name="esai" style="width: 80px;">Cek Esai</a>
											<?php }
										} else { ?>
											<a href="?md=dbup&up=ljk&kds=<?php echo $row['kd_soal'] . '&token=' . $row['token'] ?>" class="btn btn-sm btn-primary p-1" id="aktif" name="aktif" style="width: 80px; <?php if ($sts != "0") {
																																																																																																echo "pointer-events: none;";
																																																																																															} ?>">Selesai</a>
										<?php }
									} else { ?>
										<button class="btn btn-outline-info p-1" id="aktif" name="aktif" data-bs-toggle="modal" data-bs-target="#setAktif<?php echo $row[0] ?>" style="width: 80px;"><i class="bi bi-gear"></i> Aktif</button>
										<?php }
								} elseif ($jam_ak <= date('H:i')) {
									if ($pkt_s['esai'] != "0") {
										if ($cek_es != "0") { ?>
											<a href="?md=priksa_esai&kds=<?php echo $row['kd_soal'] ?>&tkn=<?php echo $row['token'] . '&mpel=' . $row['kd_mpel'] ?>" class="btn btn-sm btn-outline-primary m-1" id="esai" name="esai" style="width: 80px;">Cek Esai </a>
										<?php }
									} else { ?>
										<a href="?md=dbup&up=ljk&kds=<?php echo $row['kd_soal'] . '&token=' . $row['token'] ?>" class="btn btn-sm btn-primary p-1" id="aktif" name="aktif" style="width: 80px; <?php if ($sts != "0") {
																																																																																															echo "pointer-events: none;";
																																																																																														} ?>">Selesai</a>
									<?php }
								}
							} else {
								if ($cek_es != "0") { ?>
									<a href="?md=priksa_esai&kds=<?php echo $row['kd_soal'] ?>&tkn=<?php echo $row['token'] . '&mpel=' . $row['kd_mpel'] ?>" class="btn btn-sm btn-outline-primary m-1" id="esai" name="esai" style="width: 80px;">Cek Esai</a>
								<?php } else { ?>
									<a href="?md=dbup&up=ljk&kds=<?php echo $row['kd_soal'] . '&token=' . $row['token'] ?>" class="btn btn-sm btn-primary p-1" id="selesai" name="selesai" style="width: 80px; <?php if ($sts != "0") {
																																																																																																echo "pointer-events: none;";
																																																																																															} ?>">Selesai</a>

								<?php }
							}
							if (!empty($ip)) { ?>
								<button class="btn btn-outline-warning p-1" id="riwayat" name="riwayat">Riwayat</i></button>
							<?php } ?>
						</td>
					</tr>
				<?php $no++;
				} ?>
			</tbody>
		</table>
	</div>
	<div class="row mt-3 bg-info-subtle m-1" style="border-radius: 7px;">
		<div class="col-12 fs-5 fw-semibold">Catatan :</div>
		<div class="col-12 mx-3">Setelah Tes Berakhir pastikan seluruh peserta selesai dalam melaksanakan ujian apabila ada yang belum selesai klik pada token dan selesaikan seluruh perserta tes. <br>apabila soal memiliki jenis esai silahkan klik pada tombol <button class="btn btn-sm btn-outline-primary m-1" style="width: 80px;">Cek Esai</button> untuk memeriksa jawaban soal esai.</div>
		<div class="col-12 mx-3">Setelah semua prosedur di atas dilakukan silahkan klik tombol <button class="btn btn-sm btn-primary m-1" style="width: 80px;">Selesai</button> untuk mengakhiri tes dan memproses nilai peserta</div>
	</div>
</div>


<!-- Modal -->
<?php
$mdl_dtuj	= mysqli_query($koneksi, "SELECT * FROM jdwl WHERE sts!='H' ORDER BY tgl_uji DESC");
while ($row = mysqli_fetch_array($mdl_dtuj)) {
	$mpel = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM mapel WHERE kd_mpel='$row[kd_mpel]'"));
?>
	<div class="modal fade" id="setAktif<?php echo $row[0] ?>" tabindex="-1" aria-labelledby="setAktifLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h1 class="modal-title fs-5" id="setAktifLabel">Pengaturan</h1>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<form action="" method="post">
						<div class="row g-1 pb-2 px-3">
							<div class="col-12">
								<div class="input-group">
									<span class="input-group-text bg-dark-subtle" id="basic-addon1" style="width: 160px;">Kode Soal</span>
									<input type="text" id="kds" name="kds" class="form-control" value="<?php echo $row['kd_soal'] ?>" disabled>
								</div>
							</div>
							<div class="col-12">
								<div class="input-group">
									<span class="input-group-text bg-dark-subtle" id="basic-addon1" style="width: 160px;">Mata Pelajaran</span>
									<input type="text" id="mpel" name="mpel" class="form-control" value="<?php echo $mpel['nm_mpel'] ?>" disabled>
								</div>
							</div>
							<div class="col-12">
								<div class="input-group">
									<span class="input-group-text bg-dark-subtle" id="basic-addon1" style="width: 160px;">Waktu Tambahan</span>
									<input type="number" id="jm_tambah" name="jm_tambah" class="form-control" placeholder="Menit" required>
								</div>
							</div>
						</div>
						<div class="modal-footer p-0">
							<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
							<button type="button" class="btn btn-primary">Simpan</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
<?php } ?>

<script src="../../node_modules/jquery/dist/jquery.min.js"></script>
<!-- <script>
	function reset(usr, id, aksi) {
		$.ajax({
			type: 'POST',
			url: './db/reset_lg.php', // Ganti dengan URL yang benar
			data: {
				usr: usr,
				id: id,
				ak: aksi,
			}, // Kirim ID data yang ingin dihapus
			success: function(response) {
				// Tampilkan pesan hasil hapus dari server
				// location.reload();
				Swal.fire('Berhasil!', response, 'success')
					.then((result) => {
						// Jika notifikasi ditutup, muat ulang halaman
						if (result.isConfirmed || result.isDismissed) {
							location.reload();
						}
					});
			},
			error: function() {
				Swal.fire('Error', 'An error occurred.', 'error');
			}
		});
	}
</script> -->
<?php if (isset($_REQUEST['ss']) == "") {
} elseif (!empty($_REQUEST['ss'] == "ok")) { ?>
	<script>
		Swal.fire({
			title: 'Berhasil',
			text: 'Data Penilaian Soal Pilihan Ganda Berhasil diproses',
			icon: 'success',
			backdrop: 'rgba(0,0,0,0.7)',
			allowOutsideClick: false,
			allowEscapeKey: false,
		})
	</script>
<?php } elseif (!empty($_REQUEST['ss'] == "up")) { ?>
	<script>
		Swal.fire({
			title: 'Berhasil',
			text: 'Data berhasil diperbaharui',
			icon: 'info',
			backdrop: 'rgba(0,0,0,0.7)',
			allowOutsideClick: false,
			allowEscapeKey: false,
		})
	</script>
<?php } elseif (!empty($_REQUEST['ss'] == "null")) { ?>
	<script>
		Swal.fire({
			title: 'Error',
			text: 'Data tidak dapat diperoses',
			icon: 'error',
			backdrop: 'rgba(0,0,0,0.7)',
			allowOutsideClick: false,
			allowEscapeKey: false,
		})
	</script>
<?php } ?>