<?php
include_once("../config/server.php");

$qr_dtuj  = mysqli_query($koneksi, "SELECT * FROM jdwl WHERE sts ='Y';");
?>

<style>
	/* Image deskipri */
	.image img {
		max-width: 100%;
		/* Gambar tidak lebih lebar dari elemen induknya */
		height: auto;
		/* Jaga rasio aspek gambar */
		max-height: 7cm;
		/* Batasi tinggi maksimum gambar jika diperlukan */
		aspect-ratio: 1 / 1;
		/* Rasio aspek opsional, default 1:1 */
		object-fit: contain;
		/* Pastikan gambar tetap berada di dalam area tanpa memotong */
	}

	p .image_resized {
		max-width: 100%;
		/* Gambar menyesuaikan dengan lebar kontainer */
		height: auto;
		/* Pertahankan rasio aspek */
		max-height: 200px;
		/* Tinggi maksimum */
		aspect-ratio: 1 / 1;
		/* Rasio aspek opsional */
		object-fit: cover;
		/* Isi elemen dengan gambar, potong jika diperlukan */
	}


	/* Gaya tabel */
	.table-responsive th:nth-child(1),
	.table-responsive td:nth-child(1) {
		min-width: 25px;
		text-align: center;
		align-content: baseline;
	}

	.table-responsive th:nth-child(2),
	.table-responsive td:nth-child(2) {
		min-width: 150px;
		text-align: center;
	}

	.table-responsive th:nth-child(3),
	.table-responsive td:nth-child(3) {
		width: auto;
		min-width: 200px;
		text-align: left;
	}

	.table-responsive th:nth-child(4),
	.table-responsive td:nth-child(4) {
		min-width: 300px;
		/* text-align: center; */
		align-content: baseline;
	}

	.table-responsive th:nth-child(5),
	.table-responsive td:nth-child(5) {
		min-width: 70px;
		text-align: center;
		align-content: baseline;
	}

	.table-responsive th:nth-child(6),
	.table-responsive td:nth-child(6) {
		min-width: 70px;
		text-align: center;
		align-content: baseline;
	}

	.table-responsive th:nth-child(7),
	.table-responsive td:nth-child(7) {
		min-width: 70px;
		text-align: center;
		align-content: baseline;
	}

	.table-responsive th:nth-child(8),
	.table-responsive td:nth-child(8) {
		min-width: 150px;
		text-align: center;
		align-content: baseline;
	}

	.table-responsive th:nth-child(9),
	.table-responsive td:nth-child(9) {
		min-width: 100px;
		text-align: center;
		align-content: baseline;
	}

	.table-responsive th:nth-child(10),
	.table-responsive td:nth-child(10) {
		min-width: 80px;
		text-align: center;
		align-content: baseline;
	}
</style>
<div class="container-fluid mb-5 p-0">
	<div class="row p-2 border-bottom fs-3 mb-4 shadow-sm ">Daftar Peserta Ujian : <?= $_GET['tk']; ?></div>
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
						<button class="btn btn-outline-primary p-1" onclick="reset('Semua','<?php echo $_GET['tk'] ?>','s_all')"><i class="bi bi-check2-all"></i></button> Selesai
					</span>
				</div>
				<div class="col-auto"><span class="d-inline-block" tabindex="0" data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-content="Aktif Semua Peserta" data-bs-placement="bottom">
						<button class="btn btn-outline-warning p-1" onclick="reset('Semua','<?php echo $_GET['tk'] ?>','s_on')"><i class="bi bi-check2-circle"></i></button> Aktif</span>
				</div>
				<div class="col-auto"><span class="d-inline-block" tabindex="0" data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-content="Reset Semua Peserta" data-bs-placement="bottom">
						<button class="btn btn-outline-danger p-1" onclick="reset('Semua','<?php echo $_GET['tk'] ?>','s_reset')"><i class="bi bi-arrow-clockwise"></i></button> Reset</span>
				</div>
			</div>
		</div>
	</div>
	<div class="table-responsive">
		<table class="table table-hover table-striped table-bordered border" id="jsdata">
			<thead class="table-info text-center align-baseline">
				<tr class="align-middle">
					<th style="min-width: 5%;">No.</th>
					<th style="min-width: 100px;">NIS/ No Peserta</th>
					<th style="min-width: 150px;">Username</th>
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
				$jml_soal  = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM cbt_pktsoal WHERE kd_soal='$_GET[kds]'"));
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
					$nm_ps = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `cbt_peserta` WHERE user ='$row[user]'"));

				?>
					<tr align="center">
						<th><?php echo $no; ?></th>
						<td>
							<?= $row['nis']; ?>
						</td>
						<td class="text-start">
							<input type="text" name="user" id="user" value="<?php echo $row['user']; ?>" hidden>
							<?= $row['user']; ?>
						</td>
						<td class="text-start">
							<!-- <input type="text" name="user" id="user" value="<?php echo $row['user']; ?>" hidden> -->
							<?php echo $nm_ps['nm']; ?>
						</td>
						<!-- <td>1|IPA</td> -->
						<td>
							<button type="button" onclick="opsiModal('<?= $row['user']; ?>','<?= $_GET['tk']; ?>','<?= $row['kd_soal']; ?>','<?= $nm_ps['nm']; ?>')" class="btn btn-outline-dark fw-semibold" href="#"><?php echo $jwbs['jum'] . "/" . $jml_soal['jum_soal']; ?></button>
						</td>
						<td><?php echo $row['ruang']; ?></td>
						<td><?php echo $row['sesi']; ?></td>
						<!-- <td>08:03:47</td> -->
						<td><?php echo $ip; ?></td>
						<td><?php echo $sts; ?></td>
						<td>
							<?php if ($row['sts'] == "U") { ?>
								<button class="btn btn-outline-primary p-1 btn-sm" name="selesai" id="selesai" onclick="reset('<?php echo $row['user'] ?>','<?php echo $row['id_tes'] ?>','selesai')"><i class="bi bi-check2-all"></i></button>
							<?php } else { ?>
								<button class="btn btn-outline-warning p-1 btn-sm" name="online" id="online" onclick="reset('<?php echo $row['user'] ?>','<?php echo $row['id_tes'] ?>','online')"><i class="bi bi-check2-circle"></i></button>
							<?php }
							if (!empty($ip)) { ?>
								<button class="btn btn-outline-danger p-1 btn-sm" name="reset" id="reset" onclick="reset('<?php echo $row['user'] ?>','<?php echo $row['id_tes'] ?>','reset')"><i class="bi bi-arrow-clockwise"></i></button>
							<?php } ?>
							<button class="btn btn-outline-dark p-1 btn-sm" name="pesan" id="pesan" onclick="pesan()"><i class="bi bi-chat-left-text"></i></button>
						</td>
					</tr>
				<?php $no++;
				} ?>
			</tbody>
		</table>
	</div>
</div>

<div class="row px-2">
	<div class="col-12 bg-success-subtle p-3 text-black" style="border-radius: 7px;">
		<h5>Catatan :</h5>
		<p class="">
			<small class="text-muted">* Peserta yang sudah selesai ujian akan ditandai dengan warna <span class="badge bg-success">Selesai</span> pada kolom status.</small>
			<br>
			<small class="text-muted">* Peserta yang sedang aktif ujian akan ditandai dengan warna <span class="badge bg-danger">Aktif</span> pada kolom status.</small>
			<br>
			<small class="text-muted">* Untuk mengakhiri ujian peserta, klik tombol <button class="btn btn-outline-primary p-1 btn-sm"><i class="bi bi-check2-all"></i></button> selesai.</small>
			<br>
			<small class="text-muted">* Untuk mengaktifkan kembali peserta yang sudah selesai, klik tombol <button class="btn btn-outline-warning p-1 btn-sm"><i class="bi bi-check2-circle"></i></button> aktif.</small>
			<br>
			<small class="text-muted">* Untuk mengatur ulang peserta, klik tombol <button class="btn btn-outline-danger p-1 btn-sm"><i class="bi bi-arrow-clockwise"></i></button> reset.</small>
			<br>
			<small class="text-muted">* Untuk melihat jawaban peserta, klik pada jumlah soal yang telah dijawab.</small>
		</p>
	</div>
</div>

<!-- Modal -->
<div class="modal fade modal-lg" tabindex="-1" id="modalOpsi">
	<div class="modal-dialog modal-dialog-scrollable">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Jawaban <b id="nma"></b></h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<table class="table table-hover table-bordered border-dark">
					<thead class=" table-info">
						<tr class="text-center">
							<th style="width: 30px;text-align: center;">No</th>
							<th>Soal</th>
							<th>Jawaban</th>
							<!-- <td>Opsi</td> -->
						</tr>
					</thead>
					<tbody id="viewopsi"></tbody>
				</table>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
				<!-- <button type="button" class="btn btn-primary">Save changes</button> -->
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	function opsiModal(id, token, kds, nama) {
		$('#modalOpsi').modal('show');
		var dOpsi, dId, dId2, dId3;
		dOpsi = 'sis_jwbn';
		dId = id;
		dId2 = token;
		dId3 = kds;

		$.ajax({
			type: 'POST',
			url: './page/content/edit_mdal.php',
			data: {
				opsi: dOpsi,
				id: dId,
				token: dId2,
				kds: dId3
			},

			success: function(data) {
				$('#viewopsi').html(data);
				$('#nma').text(nama);
				inisialisasiSelectNos();
			}
		});
	}

	function pesan(){
		$('#modalOpsi').modal('show');
	}
</script>

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
<script>
	document.addEventListener("DOMContentLoaded", function() {
		// Inisialisasi Simple-DataTables pada tabel
		var dataTable = new simpleDatatables.DataTable("#jsdata", {
			perPageSelect: [5, 10, 25, 50, 'All'],
			perPage: 20,
			labels: {
				placeholder: "Cari...",
				perPage: " Data per halaman",
				noRows: "Tidak ada data yang ditemukan",
				info: "Menampilkan {start}/{end} dari {rows} Data",
			}
		});
	});
</script>
<script>
	function inisialisasiSelectNos() {
		const slct = document.querySelectorAll('select[name="nos"]');
		slct.forEach(select => {
			const opt0 = select.querySelector('option[value="0"]');
			if (opt0) opt0.disabled = true;

			select.addEventListener('change', function() {
				const selectedValues = Array.from(slct).map(s => s.value);
				slct.forEach(s => {
					const currentValue = s.value;
					Array.from(s.options).forEach(opt => {
						if (opt.value === "0") {
							opt.disabled = true;
						} else if (selectedValues.includes(opt.value) && opt.value !== currentValue) {
							opt.disabled = true;
							opt.style.display = 'none';
						} else {
							opt.disabled = false;
							opt.style.display = 'block';
						}
					});
				});
			});
		});
	}
</script>