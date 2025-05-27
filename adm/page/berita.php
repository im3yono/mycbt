<?php

?>

<style>
	#pr {
		display: flex;
	}

	.berita {
		background-color: aqua;
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
		min-width: 150px;
		text-align: center;
		align-content: baseline;
	}

	.table-responsive th:nth-child(5),
	.table-responsive td:nth-child(5) {
		min-width: 150px;
		text-align: center;
		align-content: baseline;
	}

	.table-responsive th:nth-child(6),
	.table-responsive td:nth-child(6) {
		min-width: 200px;
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
		min-width: 100px;
		text-align: center;
		align-content: baseline;
	}
</style>

<div class="container-fluid mb-5 p-0">
	<div class="row p-2 border-bottom fs-3 mb-4 shadow-sm ">Berita Acara</div>

	<div class="row">
		<div class="col"></div>
	</div>
	<div class="table-responsive">
		<table class="table table-hover table-bordered table-striped border" id="tabel">
			<thead>
				<th>No</th>
				<th>Kode Soal</th>
				<th>Mata Pelajaran</th>
				<th>Hari, Tanggal</th>
				<th>Kelas | Jurusan</th>
				<th>Catatan</th>
				<th>Pegawas</th>
				<th>Opsi</th>
			</thead>
			<tbody id="dtable"></tbody>
		</table>
	</div>
</div>


<!-- Modal -->
<!-- Modal -->
<div class="modal fade" id="modalview" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h1 class="modal-title fs-5" id="exampleModalLabel">Berita Acara</h1>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div id="mld_brt"></div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary">Simpan</button>
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
			</div>
		</div>
	</div>
</div>


<!-- Javascript -->

<!-- Table -->
<script>
	document.addEventListener("DOMContentLoaded", function() {
		const dataTableElement = document.querySelector("#tabel");

		// Memuat data tabel menggunakan AJAX
		fetch("./page/content/tbl_berita.php")
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


<!-- Modal -->
<script>
	function opsi(id,kds) {
		$('#modalview').modal('show');

		$.ajax({
			type: 'POST',
			url: './page/content/mdl_brt.php',
			data: {
				id: id,
				kds: kds,
			},

			success: function(data) {
				$('#mld_brt').html(data);
				// if (typ == 'hs') {
				// 	$('#typ').text('Riwayat Ujian');
				// } else {
				// 	$('#typ').text('Daftar Jadwal Aktif');
				// }
			}
		});
	}
</script>