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
		<table class="table table-hover table-striped table-bordered">
			<thead class="table-info text-center align-baseline">
				<tr class="align-middle">
					<th style="min-width: 5%;">No.</th>
					<th style="min-width: 100px;">Kode Soal</th>
					<th style="width: 250px;">Mata Pelajaran</th>
					<!-- <th style="min-width: 10%;">Kelas | Jurusan</th> -->
					<th style="width: 50px;">Jumlah Soal</th>
					<!-- <th style="min-width: 50px;">Ruang</th> -->
					<th style="min-width: 50px;">Sesi</th>
					<!-- <th style="min-width: 90px;">Login</th> -->
					<th style="min-width: 120px;">Status</th>
					<!-- <th colspan="4" style="min-width: 25%;">Ujian</th> -->
					<th style="min-width: 50px;">Token</th>
					<th style="min-width: 100px;">Action</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$no = 1;
				$qr_dtuj	= mysqli_query($koneksi, "SELECT * FROM `jdwl` WHERE sts!='H'");
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

				?>
					<tr align="center">
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
						<td>
							<?php echo $row['sesi']; ?>
						</td>
						<!-- <td>08:03:47</td> -->
						<td>
							<?php echo tgl_hari($row['tgl_uji']) . "<br>" . date('H:i',strtotime($row['jm_uji']))."-".$jam_ak	; ?>
						</td>
						<td>
							<a href="?md=dfu_ps&tk=<?php echo $row['token']; ?>" class="btn btn-outline-primary m-0 p-1" style="min-width: 110px;"><?php echo $row['token']; ?></a>
						</td>
						<td>
							<?php
							if ($row['tgl_uji'] == date('Y-m-d')) {
								if ($jam_ak > date('H:i')) { ?>
									<button class="btn btn-outline-info p-1">Aktif</button>
								<?php }
								if ($jam_ak < date('H:i')) { ?>
									<button class="btn btn-primary p-1">Selesai</button>
								<?php }
							} else { ?>
								<button class="btn btn-primary p-1">Selesai</button>
							<?php }
							if (!empty($ip)) { ?>
								<button class="btn btn-outline-warning p-1">Riwayat</i></button>
							<?php } ?>
						</td>
					</tr>
				<?php $no++;
				} ?>
			</tbody>
		</table>
	</div>
</div>

<script src="../../node_modules/jquery/dist/jquery.min.js"></script>
<script>
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
</script>