<?php
include_once("../config/server_m.php");
?>

<style>
	#hasil {
		display: flex;
	}

	.up_hasil {
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
		min-width: 100px;
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
		min-width: 100px;
		text-align: center;
		align-content: baseline;
	}

	.table-responsive th:nth-child(5),
	.table-responsive td:nth-child(5) {
		min-width: 300px;
		text-align: center;
		align-content: center;
		vertical-align: middle;
	}

	.table-responsive th:nth-child(6),
	.table-responsive td:nth-child(6) {
		min-width: 100px;
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
	<div class="row p-2 border-bottom fs-3 mb-4 shadow-sm text-uppercase">Upload Hasil TES</div>
	<div class="row">
		<div class="table-responsive">
			<table class="table table-hover" id="jsdata">
				<thead>
					<th>No.</th>
					<th>Kode Bank Soal</th>
					<th>Mata Pelajaran</th>
					<th>Data</th>
					<th>Progres</th>
					<th>Status</th>
					<th>Opsi</th>
				</thead>
				<tbody>
					<?php
					$no = 1;
					$qr_dt = mysqli_query($koneksi, "SELECT *, COUNT(*) AS jml FROM `nilai` GROUP BY kd_soal;");


					while ($row = mysqli_fetch_array($qr_dt)) {
						$d_mpel = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM `mapel` WHERE kd_mpel ='$row[kd_mpel]';"));
						$sm_dnil = mysqli_fetch_array(mysqli_query($sm_kon, "SELECT *, COUNT(*) AS jml  FROM `nilai` WHERE kd_soal ='$row[kd_soal]';"));
						$prg = round(($sm_dnil['jml']/$row['jml']) * 100);
					?>
						<tr>
							<th><?= $no++; ?></th>
							<td><?= $row['kd_soal']; ?></td>
							<td><?= $d_mpel['nm_mpel']; ?></td>
							<td><?= $sm_dnil['jml'] . '/' . $row['jml']; ?></td>
							<td>
								<div>
									<div class="progress" role="progressbar" aria-label="Animated striped example" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="height: 20px;">
										<div class="progress-bar progress-bar-striped progress-bar-animated" style="width: <?= $prg; ?>%"><?= $prg; ?>%</div>
									</div>
								</div>
							</td>
							<td><?= $row['jml'] == $sm_dnil['jml'] ? "Selesai" : "Siap Upload"; ?></td>
							<td>
								<button type="button" class="btn btn-primary"><i class="bi bi-upload"></i> Upload</button>
							</td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
</div>




<!-- Javascript -->

<script>
	document.addEventListener("DOMContentLoaded", function() {
		// Inisialisasi Simple-DataTables pada tabel
		var dataTable = new simpleDatatables.DataTable("#jsdata", {
			perPageSelect: [5, 10, 25, 50, 'All'],
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