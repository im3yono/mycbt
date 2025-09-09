<?php include_once("../../../config/server.php") ?>
<div class="row g-2">
	<div class="col-12 col-lg-4">
		<div class="input-group">
			<span class="input-group-text" style="width: 120px;">Tanggal</span>
			<input type="date" name="tgl" id="tgl" class="form-control" value="<?= date('Y-m-d') ?>">
		</div>
	</div>
	<!-- </div>
<div class="row mt-1 g-2"> -->
	<div class="col-12 col-lg-4">
		<div class="input-group">
			<span class="input-group-text" style="width: 120px;">Waktu Mulai</span>
			<input type="time" name="jam" id="jam" class="form-control" value="<?= date('H:i', strtotime('-' . (isset($inf_set['drsi']) ? $inf_set['drsi'] : '0') . ' minute')) ?>">
		</div>
	</div>
	<div class="col-12 col-lg-4">
		<div class="input-group">
			<span class="input-group-text" style="width: 120px;">Waktu Selesai</span>
			<input type="time" name="jam2" id="jam2" class="form-control" value="<?= date('H:i') ?>">
		</div>
	</div>
	<div class="col-12">
		<div class="col-12 border p-2" style="border-radius: 5px;">
			<div class="input-group">
				<span class="input-group-text">No Peserta Tidak Hadir</span>
				<input type="search" id="noPeserta" class="form-control" placeholder="Masukkan No Peserta">
				<button class="btn btn-outline-primary" type="button" id="btnTambah">Tambah</button>
			</div>

			<table class="table table-bordered" id="tabelPeserta">
				<thead class="text-center">
					<tr>
						<th style="width: 50px;">No</th>
						<th>No Peserta</th>
						<th>Nama</th>
						<th>Keterangan</th>
					</tr>
				</thead>
				<tbody>
					<!-- <tr>
				<th style="text-align: center;">1</th>
				<td style="text-align: center;width: 150px;">25-29</td>
				<td>Udin</td>
				<td style="text-align: center;width: 200px;">Tidak Hadir</td>
			</tr> -->
				</tbody>
			</table>

			<script>
				document.getElementById("btnTambah").addEventListener("click", function() {
					const noPesertaInput = document.getElementById("noPeserta");
					const noPeserta = noPesertaInput.value.trim();

					if (noPeserta === "") {
						Swal.fire('', 'No Peserta tidak valid', 'error');
						return;
					}

					const tabel = document.getElementById("tabelPeserta").getElementsByTagName("tbody")[0];
					const rowCount = tabel.rows.length + 1;

					$.ajax({
						type: "POST",
						url: "./db/dbproses.php?pr=data",
						data: {
							user: noPeserta
						},
						success: function(data) {

							if (data != "0") {
								// buat baris baru
								const row = tabel.insertRow();

								// kolom No urut
								const cellNo = row.insertCell(0);
								cellNo.innerHTML = rowCount;
								cellNo.style.fontStyle = "bold";
								cellNo.style.textAlign = "center";

								// kolom No Peserta
								const cellNoPeserta = row.insertCell(1);
								cellNoPeserta.innerHTML = noPeserta;
								cellNoPeserta.style.textAlign = "center";

								// kolom Nama (default kosong atau bisa nanti diambil dari DB)
								const cellNama = row.insertCell(2);
								cellNama.innerHTML = data ? data : "-";

								// kolom Keterangan
								const cellKet = row.insertCell(3);
								cellKet.innerHTML = "Tidak Hadir";
								cellKet.style.textAlign = "center";

							} else {
								Swal.fire({
									icon: 'error',
									title: 'Oops...',
									text: 'Nomor peserta tidak ditemukan!'
								});
							}
						}
					})

					// reset input
					noPesertaInput.value = "";
				});
			</script>

		</div>
	</div>
	<div class="col-12">
		<div class="form-floating">
			<textarea name="ctt" id="ctt" class="form-control" placeholder="Catatan Pengawas" style="height: 100px;"></textarea>
			<label for="ctt">Catatan</label>
		</div>
	</div>
	<div class="col-12 col-sm-6">
		<div class="form-floating">
			<input type="text" name="pngws1" id="pngws1" class="form-control" placeholder="Nama Pengawas 1">
			<label for="pngws1">Nama Pengawas 1</label>
		</div>
	</div>
	<div class="col-12 col-sm-6">
		<div class="form-floating">
			<input type="text" name="pngws2" id="pngws2" class="form-control" placeholder="Nama Pengawas 2">
			<label for="pngws2">Nama Pengawas 2</label>
		</div>
	</div>
</div>
</div>