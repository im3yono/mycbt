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
		<!-- <div class="col-12 col-md-8"> -->
		<!-- <div class="col-auto"><a href="?md=dfps_uji" class="btn btn-primary">Daftar Peserta</a></div> -->
		<div class="col-auto"></div>
		<div class="col-auto"></div>
		<!-- </div> -->
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
		<table class="table table-hover border-dark">
			<thead class="table-info text-center align-baseline">
				<tr class="align-middle">
					<th style="max-width: 30px;">No.</th>
					<th style="width: 180px;">Kode Soal</th>
					<th style="width: auto;">Mata Pelajaran</th>
					<th style="min-width: 150px;">Pembuat</th>
					<th style="min-width: 50px;">Soal</th>
					<!-- <th style="min-width: 50px;">Ruang</th> -->
					<th style="min-width: 30px;">Sesi</th>
					<th style="min-width: 150px;">Status</th>
					<th style="min-width: 80px;">Selesai/Login</th>
					<th class="p-0" style="width: 50px;">Tampil</th>
					<th class="p-0" style="min-width: 50px;">Token</th>
					<th style="width: 80px;">Action</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$no = 1;
				$qr_dtuj	= mysqli_query($koneksi, "SELECT * FROM jdwl WHERE sts='Y' AND tgl_uji = '" . date("Y/m/d") . "' ORDER BY tgl_uji DESC");
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

					$mpel 	= mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM mapel WHERE kd_mpel='$row[kd_mpel]'"));
					$pkt_s 	= mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM cbt_pktsoal WHERE kd_soal='$row[kd_soal]'"));
					$sts_lg = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM peserta_tes WHERE token ='$row[token]' AND kd_soal='$row[kd_soal]'"));
					$sts 		= mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM peserta_tes WHERE token ='$row[token]' AND kd_soal='$row[kd_soal]' AND sts='U'"));
					$sts_s 	= mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM peserta_tes WHERE token ='$row[token]' AND kd_soal='$row[kd_soal]' AND sts='S'"));
					$cek_es = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM cbt_ljk WHERE jns_soal ='E' AND nil_esai ='0' AND token ='$row[token]' AND kd_soal='$row[kd_soal]';"));

				?>
					<tr align="center" class="align-middle">
						<th><?= $no; ?></th>
						<td><?= $row['kd_soal']; ?></td>
						<td class="text-start">
							<!-- <input type="text" name="user" id="user" value="<?= $row['user']; ?>" hidden> -->
							<?= $mpel['nm_mpel']; ?>
						</td>
						<td><?= $pkt_s['author']; ?></td>
						<td>
							<?= $pkt_s['jum_soal']; ?>
						</td>
						<!-- <td>
							<?= $row['ruang']; ?>
						</td> -->
						<td class="p-1">
							<?= $row['sesi']; ?>
						</td>
						<!-- <td>08:03:47</td> -->
						<td>
							<?= tgl_hari($row['tgl_uji']) . "<br>" . date('H:i', strtotime($row['jm_uji'])) . "-" . $jam_ak . "<br>"; ?>
							<?php if ($row['jm_tmbh'] != "00:00:00") echo '<button class="btn badge bg-success" onclick="addTime(\'' . $row['kd_soal'] . '\',\'' . $mpel['nm_mpel'] . '\',\'' . $row['token'] . '\',\'' . $pkt_s['author'] . '\',\''.db_JamToMenit($row['jm_tmbh']).'\')">Tambahan : ' . date('H:i', strtotime($row['jm_tmbh'])) . '</button>'; ?>
						</td>
						<td>
							<?= $sts_s.'/'.$sts_lg; ?>
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
							if ($row['md_uji'] == "0") {
								$ton = "btn-danger";
								$son = "1";
								$tekon = 'Offline';
							} else {
								$ton = "btn-success";
								$son = "0";
								$tekon = 'Online';
							}
							?>
							<a href="?md=dbup&up=token&kds=<?= $row['kd_soal'] . '&token=' . $row['token'] . '&s=' . $stoken; ?>" class="btn btn-sm m-1 <?= $ttoken ?>" style="width: 70px;">Token</a>
							<a href="?md=dbup&up=nilai&kds=<?= $row['kd_soal'] . '&token=' . $row['token'] . '&s=' . $snil; ?>" class="btn btn-sm m-1 <?= $tnil ?>" style="width: 70px;">Hasil</a>
						</td>
						<td class="align-middle">
							<a href="?md=dfu_ps&tk=<?= $row['token']; ?>&kds=<?= $row['kd_soal'] ?>" class="btn btn-lg fw-semibold btn-outline-primary m-0 p-1" style="min-width: 170px;"><?= $row['token'] ?></a>
						</td>
						<td>
							<?php
							$tgl_sama = ($row['tgl_uji'] == date('Y-m-d'));
							$jam_valid = ($jam_ak >= date('H:i'));
							$esai_ada = ($pkt_s['esai'] != "0");
							$cek_esai = ($cek_es != "0");
							$selesai_disabled = ($sts != "0") ? "pointer-events: none;" : "";
							$selesai_class = ($sts != "0") ? "btn-outline-primary" : "btn-primary";
							$link_soal = '&kds=' . $row['kd_soal'] . '&token=' . $row['token'];

							if ($tgl_sama && $jam_valid):
								if ($sts == "0"):
									if ($cek_esai && $esai_ada): ?>
										<a href="?md=priksa_esai<?= $link_soal ?>&mpel=<?= $row['kd_mpel'] ?>" class="btn btn-sm btn-outline-primary m-1" id="esai" name="esai" style="width: 80px;">Cek Esai</a>
									<?php else: ?>
										<a href="?md=dbup&up=ljk<?= $link_soal ?>" class="btn btn-sm <?= $selesai_class; ?> p-1" id="aktif" name="aktif" style="width: 80px; <?= $selesai_disabled; ?>">Selesai</a>
									<?php endif;
								else: ?>
									<button class="btn btn-outline-info p-1" id="aktif" name="aktif" data-bs-toggle="modal" onclick="addTime('<?= $row['kd_soal']; ?>','<?= $mpel['nm_mpel']; ?>','<?= $row['token'] ?>','<?= $pkt_s['author']; ?>')" style="width: 80px;"><i class="bi bi-gear"></i> Aktif</button>
								<?php endif;
							else: ?>
								<?php if ($cek_esai && $esai_ada): ?>
									<a href="?md=priksa_esai<?= $link_soal ?>&mpel=<?= $row['kd_mpel'] ?>" class="btn btn-sm btn-outline-primary m-1" id="esai" name="esai" style="width: 80px;">Cek Esai</a>
								<?php else: ?>
									<a href="?md=dbup&up=ljk<?= $link_soal ?>" class="btn btn-sm <?= $selesai_class; ?> p-1" id="selesai" name="selesai" style="width: 80px; <?= $selesai_disabled; ?>">Selesai</a>
								<?php endif;
							endif;

							if (!empty($ip)) { ?>
								<button class="btn btn-outline-warning p-1" id="riwayat" name="riwayat">Riwayat</i></button>
							<?php } ?>
							<a href="?md=dbup&up=offon&kds=<?= $row['kd_soal'] . '&token=' . $row['token'] . '&s=' . $son; ?>" class="btn btn-sm m-1 <?= $ton ?>" style="width: 70px;"><?= $tekon; ?></a>
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
<!-- <?php
			$mdl_dtuj	= mysqli_query($koneksi, "SELECT * FROM jdwl WHERE sts!='H' ORDER BY tgl_uji DESC");
			while ($row = mysqli_fetch_array($mdl_dtuj)) {
				$mpel = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM mapel WHERE kd_mpel='$row[kd_mpel]'"));
			?> -->
<div class="modal fade" id="setAktif" tabindex="-1">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h1 class="modal-title fs-5" id="setAktifLabel">Pengaturan</h1>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<form action="" method="post" id="form_tmbh_waktu">
					<div class="row g-1 pb-2 px-3">
						<div class="col-12">
							<div class="input-group">
								<span class="input-group-text bg-info fw-semibold" id="basic-addon1" style="width: 160px;">Pembuat</span>
								<input type="text" name="author" id="author" class="form-control" readonly>
							</div>
						</div>
						<div class="col-12">
							<div class="input-group">
								<span class="input-group-text bg-info fw-semibold" id="basic-addon1" style="width: 160px;">Token</span>
								<input type="text" name="token" id="token" class="form-control" readonly>
							</div>
						</div>
						<div class="col-12">
							<div class="input-group">
								<span class="input-group-text bg-info fw-semibold" id="basic-addon1" style="width: 160px;">Kode Soal</span>
								<input type="text" id="kds" name="kds" class="form-control" readonly>
							</div>
						</div>
						<div class="col-12">
							<div class="input-group">
								<span class="input-group-text bg-info fw-semibold" id="basic-addon1" style="width: 160px;">Mata Pelajaran</span>
								<input type="text" id="mpel" name="mpel" class="form-control" readonly>
							</div>
						</div>
						<div class="col-12">
							<div class="input-group">
								<span class="input-group-text bg-info fw-semibold" id="basic-addon1" style="width: 160px;">Waktu Tambahan</span>
								<input type="number" id="jm_tambah" name="jm_tambah" class="form-control" placeholder="Menit" required>
							</div>
						</div>
					</div>
				</form>
				<div class="modal-footer p-0">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
					<button type="button" class="btn btn-primary" id="simpan" name="simpan" onclick="saveTime()">Simpan</button>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- <?php } ?> -->

<script src="../node_modules/jquery/dist/jquery.min.js"></script>

<script>
	function addTime(kds, mpel, tkn, aut,val='') {
		$('#setAktif').modal('show');
		$('#kds').val(kds);
		$('#mpel').val(mpel);
		$('#token').val(tkn);
		$('#author').val(aut);
		$('#jm_tambah').val(val); // Reset input waktu tambahan
	}

	function saveTime() {
		var formTmbhWkt = $('#form_tmbh_waktu').serializeArray();
		var kds = formTmbhWkt.find(obj => obj.name === 'kds')?.value || '';
		var tkn = formTmbhWkt.find(obj => obj.name === 'token')?.value || '';
		var aut = formTmbhWkt.find(obj => obj.name === 'author')?.value || '';
		var jm = formTmbhWkt.find(obj => obj.name === 'jm_tambah')?.value || '';

		$.ajax({
			type: 'POST',
			url: './db/dbproses.php?pr=uj_time',
			data: {
				kds: kds,
				tkn: tkn,
				aut: aut,
				jm: jm
			},
			success: function(response) {
				Swal.fire('Berhasil!', response, 'success').then((result) => {
					if (result.isConfirmed || result.isDismissed) {
						location.reload();
					}
				});
			}
		})
	}
</script>
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
			text: 'Data tidak dapat diperoses (LJK Kosong)',
			icon: 'error',
			backdrop: 'rgba(0,0,0,0.7)',
			allowOutsideClick: false,
			allowEscapeKey: false,
		})
	</script>
<?php } ?>