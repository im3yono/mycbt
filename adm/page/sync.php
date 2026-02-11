<style>
	.sync {
		background-color: aqua;
		z-index: 2;
	}

	/* Gaya tabel */
	.table-responsive th:nth-child(1),
	.table-responsive td:nth-child(1) {
		max-width: 45px;
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
		min-width: 350px;
		text-align: center;
		align-content: baseline;
	}

	.table-responsive th:nth-child(4),
	.table-responsive td:nth-child(4) {
		max-width: 150px;
		text-align: center;
		align-content: baseline;
	}

	.table-responsive th:nth-child(5),
	.table-responsive td:nth-child(5) {
		max-width: 150px;
		text-align: center;
		align-content: baseline;
	}

	.table-responsive th:nth-child(6),
	.table-responsive td:nth-child(6) {
		max-width: 150px;
		text-align: center;
		align-content: baseline;
	}

	.table-responsive th:nth-child(7),
	.table-responsive td:nth-child(7) {
		min-width: 100px;
		text-align: center;
		align-content: baseline;
	}
</style>

<div class="container-fluid mb-5 p-0">
	<div class="row p-2 border-bottom fs-3 mb-4 shadow-sm text-uppercase">Server Client</div>
	<div class="row">
		<div class="col-auto">
			<p class="bg-success-subtle p-2 fs-6" style="border-radius: 7px;">Catatan : <br>
				1. Pastikan sebelum melakukan Sinkronisasi <b>IP dan database Server Master</b> sudah di setting pada pengaturan Server Client agar proses berjalan dengan lancar. <br>
				2. Buat izin akses sinkronisasi pada Server Master dengan menekan tombol <b>Izinkan Akses Sinkron</b> dan <br> 3. Tambahkan Server Client dengan menekan tombol <b>Tambah Server Client.</b>
			</p>

		</div>
	</div>
	<div class="row">
		<div id="status_izin"></div>
	</div>
	<div class="row justify-content-around p-2" <?= ($server_ms['lev_svr'] == "C") ? 'style="display: none;"' : ''; ?>>
		<?php
		$sv_cl = $koneksi->prepare("SELECT ip_sv, COUNT(*) AS jml FROM cbt_peserta GROUP BY ip_sv;");
		$sv_cl->execute();
		$dsv_cl = $sv_cl->get_result();
		while ($rw = $dsv_cl->fetch_assoc()) { ?>
			<div class='col-auto me-3 mb-2 p-3'>
				<div class="card text-bg-info">
					<div class="card-body text-center">
						<h4><?= $rw['ip_sv']; ?></h4><br>Peserta <?= $rw['jml']; ?>
					</div>
				</div>
			</div>
		<?php } ?>
	</div>
	<div class="row pt-3">
		<div class="col-12 mb-3 border-bottom pb-2 shadow-sm">
			<!-- <button type="button" class="btn btn-outline-primary" onclick="izinAkses()"><i class="bi bi-arrow-down-up"></i> Izinkan Akses Sinkron</button> -->
			<button type="button" class="btn btn-primary" onclick="addClient()"><i class="bi bi-plus"></i> Tambah Server Client</button>
		</div>
		<div class="table-responsive">
			<table class="table table-hover table-striped table-bordered border" id="jsdata">
				<thead>
					<th>No</th>
					<th>ID Server</th>
					<th>Nama Server</th>
					<th>IP Server</th>
					<!-- <th>Sync</th>
					<th>Upload</th> -->
					<th>Opsi</th>
				</thead>
				<tbody id="dtable"></tbody>
			</table>
		</div>
	</div>
</div>


<!-- Modal -->
<div class="modal fade" id="addSVC" tabindex="-1" aria-labelledby="addSVCLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h1 class="modal-title fs-5" id="addSVCLabel"></h1>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<form action="" method="post" id="formSVC">
					<div class="mb-3">
						<label for="nmSVC" class="form-label">ID Server</label>
						<input type="text" name="id_sv" id="id_sv" hidden>
						<input type="text" class="form-control" id="idSVC" name="idSVC" placeholder="ID Instansi/Server" required>
					</div>
					<div class="mb-3">
						<label for="usrSVC" class="form-label">Nama Server</label>
						<input type="text" class="form-control" id="nmSVC" name="nmSVC" placeholder="Nama Server" required>
					</div>
					<div class="mb-3">
						<label for="ipSVC" class="form-label">IP Server</label>
						<input type="text" class="form-control" id="ipSVC" name="ipSVC" placeholder="192.168.xxx.xxx" required>
					</div>
					<!-- <div class="mb-3">
						<label for="pwdSVC" class="form-label">Username</label>
						<input type="password" class="form-control" id="pwdSVC" name="pwdSVC" required>
					</div>
					<div class="mb-3">
						<label for="dbSVC" class="form-label">Password</label>
						<input type="text" class="form-control" id="dbSVC" name="dbSVC" required>
					</div> -->
				</form>
				<div id="tes"></div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" onclick="saveClient()">Simpan</button>
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
			</div>
		</div>
	</div>
</div>

<!-- Table -->
<script>
	document.addEventListener("DOMContentLoaded", function() {
		const dataTableElement = document.querySelector("#jsdata");


		// Memuat data tabel menggunakan AJAX
		fetch("./page/content/tbl_sync.php")
			.then((response) => response.text())
			.then((data) => {
				const tableBody = document.querySelector("#dtable");
				if (tableBody) {
					tableBody.innerHTML = data;

					// Inisialisasi ulang DataTable setelah data dimuat
					if (dataTableElement) {
						new simpleDatatables.DataTable(dataTableElement, {
							perPageSelect: [5, 10, 25, 50, "All"],
							perPage: 10,
							labels: {
								placeholder: "Cari...",
								perPage: " Data per halaman",
								noRows: "Tidak ada data yang ditemukan",
								info: "Menampilkan {start}/{end} dari {rows} Data",
							},
						});
					}
				}
				const element = document.querySelector("tbody"); // Pilih elemen berdasarkan kelas
				if (element) {
					element.id = "dtable"; // Tambahkan atribut id
				}
			})
			.catch((error) => console.error("Gagal memuat data tabel:", error));
	});
</script>
<!-- Akhir Table -->

<script>
	function lockSts(id) {
		// var icon = button.querySelector("i");
		var icon = document.getElementById('icn_sts' + id);

		$.ajax({
			type: 'POST',
			url: 'db/pr_sync.php',
			data: {
				pr: "add",
				id: id
			},

			success: function(resp) {
				if (icon.classList.contains("bi-unlock")) {
					icon.classList.remove("bi-unlock");
					icon.classList.add("bi-lock");
					$('#btn_sts' + id).removeClass("btn-info");
					$('#btn_sts' + id).addClass("btn-danger");

				} else {
					icon.classList.remove("bi-lock");
					icon.classList.add("bi-unlock");
					$('#btn_sts' + id).removeClass("btn-danger");
					$('#btn_sts' + id).addClass("btn-info");
				}
			}
		})
	}
</script>
<script>
	function addClient() {
		$('#addSVC').modal('show');
		$('#id_sv').val('');
		$('#idSVC').val('');
		$('#nmSVC').val('');
		$('#ipSVC').val('');
		$('#addSVCLabel').text('Tambahkan Server Client');
	}

	function editClient(id, idpt, nm, ip) {
		$('#addSVC').modal('show');
		$('#id_sv').val(id);
		$('#idSVC').val(idpt);
		$('#nmSVC').val(nm);
		$('#ipSVC').val(ip);
		$('#addSVCLabel').text('Edit Server Client');
	}

	function saveClient() {
		var formData = $('#formSVC').serialize();

		$.ajax({
			type: 'POST',
			url: 'db/pr_sync.php',
			data: formData + '&pr=save',
			success: function(response) {
				Swal.fire('Berhasil!', response, 'success')
					.then((result) => {
						if (result.isConfirmed || result.isDismissed) {
							location.reload();
						}
					});
			},
			error: function() {
				Swal.fire('Error', 'Terjadi kesalahan saat menyimpan data.', 'error');
			}
		});
	}

	function delClient(id) {
		Swal.fire({
			title: 'Apakah Anda yakin?',
			text: "Data ini akan dihapus secara permanen!",
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Ya, hapus!',
			cancelButtonText: 'Batal'
		}).then((result) => {
			if (result.isConfirmed) {
				$.ajax({
					type: 'POST',
					url: 'db/pr_sync.php',
					data: {
						pr: "del",
						id: id
					},
					success: function(response) {
						Swal.fire('Berhasil!', response, 'success')
							.then((result) => {
								if (result.isConfirmed || result.isDismissed) {
									location.reload();
								}
							});
					},
					error: function() {
						Swal.fire('Error', 'Terjadi kesalahan saat menghapus data.', 'error');
					}
				});
			}
		});
	}
</script>
<!-- <script>
	function izinAkses() {
		// var statusKoneksi = document.getElementById("status_izin");

		// statusKoneksi.innerHTML = "Menghubungkan...";

		// fetch("../config/m_db.php?sm=izin", 
		$.ajax({
			type: 'POST',
			url: '../config/m_db.php?sm=izin', // Ganti dengan URL yang benar
			// data: {
			// 	del_bkp: del_bkp
			// }, // Kirim ID data yang ingin dihapus
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