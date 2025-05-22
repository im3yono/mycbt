<style>
	#uj {
		display: flex;
	}

	.jdwluj {
		background-color: aqua;
	}

	.time {
		font-weight: bold;
	}


	/* Gaya tabel */
	.table-responsive th:nth-child(1),
	.table-responsive td:nth-child(1) {
		min-width: 20px;
		text-align: center;
		align-content: baseline;
		font-weight: bolder;
	}

	.table-responsive th:nth-child(2),
	.table-responsive td:nth-child(2) {
		min-width: 100px;
		text-align: center;
		align-content: baseline;
	}

	.table-responsive th:nth-child(3),
	.table-responsive td:nth-child(3) {
		width: auto;
		min-width: 100px;
		text-align: center;
		align-content: baseline;
	}

	.table-responsive th:nth-child(4),
	.table-responsive td:nth-child(4) {
		min-width: 100px;
		text-align: center;
		align-content: baseline;
	}

	.table-responsive th:nth-child(5),
	.table-responsive td:nth-child(5) {
		min-width: 100px;
		text-align: center;
		align-content: baseline;
	}

	.table-responsive th:nth-child(6),
	.table-responsive td:nth-child(6) {
		min-width: 100px;
		text-align: center;
		align-content: baseline;
		font-weight: bolder;
	}

	.table-responsive th:nth-child(7),
	.table-responsive td:nth-child(7) {
		min-width: 80px;
		text-align: center;
		align-content: baseline;
		font-weight: bolder;
	}

	.table-responsive th:nth-child(8),
	.table-responsive td:nth-child(8) {
		min-width: 120px;
		text-align: center;
		align-content: baseline;
	}

	.table-responsive th:nth-child(9),
	.table-responsive td:nth-child(9) {
		min-width: 80px;
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
	<div class="row p-2 border-bottom fs-3 mb-4 shadow-sm ">Jadwal Ujian</div>
	<div class="col table-responsive">
		<table class="table table-hover table-bordered table-striped border" id="jstable">
			<thead class="table-info text-center align-baseline">
				<tr>
					<th>No.</th>
					<th>Hari, Tanggal</th>
					<th>Token</th>
					<th>Waktu Pelaksanaan</th>
					<th>Lama Ujian</th>
					<th>Mata Pelajaran</th>
					<th>Pembuat</th>
					<th>Nama Kelas | Kelas | Jurusan</th>
					<th>Status</th>
					<th>Opsi</th>
				</tr>
			</thead>
			<tbody class="text-center align-items-baseline">
				<?php
				$query = "SELECT * FROM jdwl WHERE sts = 'Y' ORDER BY tgl_uji DESC";
				$result = $koneksi->query($query);
				$no = 1;

				while ($dtjd = $result->fetch_assoc()) {
					$mpl = $koneksi->query("SELECT * FROM mapel WHERE kd_mpel = '{$dtjd['kd_mpel']}'")->fetch_assoc();
					$kls = $koneksi->query("SELECT * FROM kelas WHERE kd_kls = '{$dtjd['kd_kls']}'")->fetch_assoc();
					$rng = $koneksi->query("SELECT ruang FROM cbt_peserta WHERE kd_kls = '{$dtjd['kd_kls']}'")->fetch_assoc();
					$status = ($dtjd['tgl_uji'] < date('Y-m-d')) ? 'Selesai' : 'Aktif';
				?>
					<tr>
						<td><?= $no++; ?></td>
						<td><?= tgl_hari($dtjd['tgl_uji']); ?></td>
						<td><?= htmlspecialchars($dtjd['token']); ?></td>
						<td><?= date('H:i', strtotime($dtjd['jm_uji'])) . " - " . date('H:i', strtotime($dtjd['slsai_uji'])); ?></td>
						<td><?= db_JamToMenit($dtjd['lm_uji'])  . ' menit'; ?></td>
						<td><?= $mpl['nm_mpel'] ?? '<span class="text-danger">Belum Ditentukan</span>'; ?></td>
						<td><?= $dtjd['author']; ?></td>
						<td>
							<?= ($dtjd['kd_kls'] == 1 ? 'Semua' : $kls['nm_kls']) . " | " . ($dtjd['kls'] == 1 ? 'Semua' : $dtjd['kls']) . " | " . ($dtjd['jur'] == 1 ? 'Semua' : $dtjd['jur']); ?>
						</td>
						<td class="<?= $status === 'Selesai' ? 'text-success' : ''; ?>">
							<?= $status; ?>
						</td>
						<td>
							<button class="btn btn-sm btn-primary m-1" id="opsi" onclick="opsiModal(<?= $dtjd['id_ujian']; ?>)"><i class="bi bi-gear"></i></button>
							<button class="btn btn-sm btn-danger m-1" id="delete" onclick="deleteJdwl(<?= $dtjd['id_ujian']; ?>,'<?= $dtjd['token']; ?>')"><i class="bi bi-trash"></i></button>
						</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>

	<div class="col-auto px-3 alert-success alert">
		<h5>Catatan :</h5>
		<table class="text-dark">
			<tr>
				<td style="width: 50px;"><a class="btn btn-sm btn-danger"><i class="bi bi-trash3"></i> </a></td>
				<td>Menghapus jadwal ketika sedang dalam pelaksanaan akan berakibat <i class="fw-bold">siswa keluar dan jawaban akan di hapus dari sistem</i>.</td>
			</tr>
			<tr>
				<td><a class="btn btn-sm btn-primary"><i class="bi bi-gear"></i> </a></td>
				<td>Hindari perubahan jadwal ketika sedang pelaksanaan, kecuali siswa tidak mengerjakan.</td>
			</tr>
		</table>
	</div>
</div>

<div id="tes"></div>

<!-- Modal -->
<div class="modal modal-lg fade" id="modalOpsi" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h1 class="modal-title fs-5" id="exampleModalLabel">Perbaiki Jadwal Ujian</h1>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div id="viewopsi"></div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" onclick="saveData()">Simpan</button>
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
			</div>
		</div>
	</div>
</div>

<script src="../node_modules/jquery/dist/jquery.min.js"></script>
<script>
	document.addEventListener("DOMContentLoaded", function() {
		// Inisialisasi DataTables
		new simpleDatatables.DataTable("#jstable", {
			perPageSelect: [5, 10, 25, 50, 100],
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

<script type="text/javascript">
	function opsiModal(id) {
		$('#modalOpsi').modal('show');
		var dOpsi, dId;
		dOpsi = 'jdwl';
		dId = id;

		$.ajax({
			type: 'POST',
			url: './page/content/edit_mdal.php',
			data: {
				opsi: dOpsi,
				id: dId
			},

			success: function(data) {
				$('#viewopsi').html(data);
			}
		});
	}
</script>

<script type="text/javascript">
	function saveData() {
		// Mengambil elemen form dengan id 'jdwl'
		var formElement = document.querySelector('#jdwl');

		// Membuat objek FormData dari elemen form
		var formData = new FormData(formElement);

		// Memulai permintaan AJAX
		$.ajax({
			url: './db/db_edit_modal.php?jdw=edit', // Ganti dengan URL tujuan
			type: 'POST',
			data: formData,
			contentType: false,
			processData: false,

			success: function(data) {
				// Reload halaman jika data berhasil disimpan
				// window.location.reload();
				$('#tes').html(data);
			},

			error: function(xhr, status, error) {
				// Menampilkan pesan error jika permintaan gagal
				console.error('Error:', error);
				alert('Gagal menyimpan data. Silakan coba lagi.');
			}
		});
	}
</script>
<script type="text/javascript">
	function deleteJdwl(id,token) {
		// Menampilkan konfirmasi menggunakan SweetAlert2
		Swal.fire({
			title: 'Apakah Anda yakin?',
			text: "Data yang dihapus tidak dapat dikembalikan!",
			icon: 'warning',
			showCancelButton: true,
			confirmButtonText: 'Hapus',
			cancelButtonText: 'Batal',
		}).then((result) => {
			// Jika user menekan tombol 'Hapus'
			if (result.isConfirmed) {
				// Melakukan permintaan AJAX untuk menghapus data
				$.ajax({
					url: './db/db_edit_modal.php?jdw=del', // Ganti dengan URL untuk menghapus data
					type: 'POST',
					data: {
						id: id,token:token
					}, // Mengirimkan id data yang akan dihapus
					success: function(data) {
						// Menampilkan notifikasi sukses jika data berhasil dihapus
						Swal.fire(
							'Terhapus!',
							'Data telah berhasil dihapus.',
							'success'
						).then((result) => {
							if (result.isConfirmed) {
								// Reload halaman setelah dialog ditutup
								location.reload();
							}
						});
					},
					error: function(xhr, status, error) {
						// Menampilkan pesan error jika permintaan AJAX gagal
						console.error('Error:', error);
						Swal.fire(
							'Gagal!',
							'Data gagal dihapus. Silakan coba lagi.',
							'error'
						);
					}
				});
			}
		});
	}
</script>