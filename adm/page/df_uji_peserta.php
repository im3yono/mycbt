<?php
include_once("../config/server.php");

$qr_dtuj  = mysqli_query($koneksi, "SELECT * FROM jdwl WHERE sts ='Y';");
?>

<div class="container-fluid mb-5 p-0">
	<div class="row p-2 border-bottom fs-3 mb-4 shadow-sm ">Daftar Peserta Ujian</div>
	<div class="row g-2 pb-3">
		<div class="col-12 col-md-8">
			<div class="col-auto"><a href="?md=df_uji" class="btn btn-outline-dark"><i class="bi bi-arrow-left"></i> Kembali</a></div>
			<div class="col-auto"></div>
			<div class="col-auto"></div>
		</div>
		<div class="col col-md-4">
			<div class="row justify-content-end me-2">
				<div class="col-auto">
					<span class="d-inline-block" tabindex="0" data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-content="Selesaikan Semua Peserta" data-bs-placement="bottom">
						<button class="btn btn-outline-primary p-1" onclick="reset('Semua','<?php echo $_GET['tk'] ?>','s_all')"><i class="bi bi-check2"></i></button> Selesai
					</span>
				</div>
				<div class="col-auto"><span class="d-inline-block" tabindex="0" data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-content="Reset Semua Peserta" data-bs-placement="bottom">
						<button class="btn btn-outline-warning p-1" onclick="reset('Semua','<?php echo $_GET['tk'] ?>','s_reset')"><i class="bi bi-arrow-clockwise"></i></button> Reset</span>
				</div>
				<div class="col-auto"><span class="d-inline-block" tabindex="0" data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-content="Aktif Semua Peserta" data-bs-placement="bottom">
						<button class="btn btn-outline-info p-1" onclick="reset('Semua','<?php echo $_GET['tk'] ?>','s_on')"><i class="bi bi-check2-circle"></i></button> Aktif</span>
				</div>
			</div>
		</div>
	</div>
	<div class="table-responsive">
		<table class="table table-hover table-striped table-bordered">
			<thead class="table-info text-center align-baseline">
				<tr class="align-middle">
					<th style="min-width: 5%;">No.</th>
					<th style="min-width: 100px;">NIS/ No Peserta</th>
					<th style="min-width: 250px;">Nama</th>
					<!-- <th style="min-width: 10%;">Kelas | Jurusan</th> -->
					<th style="min-width: 50px;">Soal</th>
					<th style="min-width: 50px;">Ruang</th>
					<th style="min-width: 50px;">Sesi</th>
					<!-- <th style="min-width: 90px;">Login</th> -->
					<th style="min-width: 150px;">IP</th>
					<th style="min-width: 120px;">Status</th>
					<!-- <th colspan="4" style="min-width: 25%;">Ujian</th> -->
					<th style="min-width: 100px;">Action</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$no = 1;
				$qr_dtuj  = mysqli_query($koneksi, "SELECT * FROM peserta_tes WHERE token='$_GET[tk]' ORDER by jm_lg DESC");
				while ($row = mysqli_fetch_array($qr_dtuj)) {
					if ($row['sts'] == "U") {
						$sts  = '<div class="text-danger fw-semibold">Aktif</div>';
					} elseif ($row['sts'] == "S") {
						$sts  = '<div class="text-success fw-semibold">Selesai</div>';
					}
					$jwbs  = mysqli_fetch_array(mysqli_query($koneksi, "SELECT COUNT(*)AS jum FROM cbt_ljk WHERE user_jawab ='$row[user]' AND jwbn !='N' AND token='$_GET[tk]';"));
					if ($row['ip'] == "127.0.0.1") {
						$ip = "Server";
					} else {
						$ip  = $row['ip'];
					}

				?>
					<tr align="center">
						<th><?php echo $no; ?></th>
						<td><?php echo $row['nis']; ?></td>
						<td class="text-start">
							<input type="text" name="user" id="user" value="<?php echo $row['user']; ?>" hidden>
							<?php echo $row['user']; ?>
						</td>
						<!-- <td>1|IPA</td> -->
						<td><?php echo $jwbs['jum'] . "/" . $row['jum_soal']; ?></td>
						<td><?php echo $row['ruang']; ?></td>
						<td><?php echo $row['sesi']; ?></td>
						<!-- <td>08:03:47</td> -->
						<td><?php echo $ip; ?></td>
						<td><?php echo $sts; ?></td>
						<td>
							<?php if ($row['sts'] == "U") { ?>
								<button class="btn btn-outline-primary p-1" name="selesai" id="selesai" onclick="reset('<?php echo $row['user'] ?>','<?php echo $row['id_tes'] ?>','selesai')"><i class="bi bi-check2"></i></button>
							<?php } else { ?>
								<button class="btn btn-outline-info p-1" name="online" id="online" onclick="reset('<?php echo $row['user'] ?>','<?php echo $row['id_tes'] ?>','online')"><i class="bi bi-check2-circle"></i></button>
							<?php }
							if (!empty($ip)) { ?>
								<button class="btn btn-outline-warning p-1" name="reset" id="reset" onclick="reset('<?php echo $row['user'] ?>','<?php echo $row['id_tes'] ?>','reset')"><i class="bi bi-arrow-clockwise"></i></button>
							<?php } ?>
						</td>
					</tr>
				<?php $no++;
				} ?>
			</tbody>
		</table>
	</div>
</div>

<script src="../node_modules/jquery/dist/jquery.min.js"></script>
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
<script>
	const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]')
	const popoverList = [...popoverTriggerList].map(popoverTriggerEl => new bootstrap.Popover(popoverTriggerEl))
</script>