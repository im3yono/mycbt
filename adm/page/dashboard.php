<style>
	.border-cs {
		height: 140px;
		border-radius: 10px;
		/* background-color: aqua; */
		background: rgb(175, 242, 255);
		background: linear-gradient(280deg, rgba(175, 242, 255, 1) 0%, rgba(216, 249, 255, 1) 40%, rgba(255, 255, 255, 1) 80%);
	}

	.atas {
		height: 75%;
	}

	.kiri {
		width: 30%;
	}

	.kanan {
		width: 70%;
	}

	.bawah {
		height: 25%;
	}

	.cl {
		background: rgb(227, 227, 227);
		background: linear-gradient(90deg, rgba(227, 227, 227, 1) 0%, rgba(236, 236, 236, 1) 26%, rgba(251, 251, 251, 1) 81%);
	}

	.dsh {
		background-color: aqua;
		z-index: 2;
	}
</style>
<div class="container-fluid mb-5 p-0">
	<div class="row p-2 border-bottom fs-3 mb-4 shadow-sm ">
		Beranda admin
	</div>
	<div class="row gap-3 justify-content-evenly mb-5">
		<div class="col-lg-3 col-md-4 col-sm-6 col-12 border border-cs">
			<div class="atas border-bottom row">
				<div class="kiri col-auto"><i class="bi bi-person-lines-fill display-1 text-info-emphasis"></i></div>
				<div class="kanan col-auto p-2 text-end">
					<h3>Peserta</h3>
					<h2>512</h2>
				</div>
			</div>
			<div class="bawah col-auto text-end fs-5 ">Daftar Peserta <i class="bi bi-arrow-right-circle text-info-emphasis"></i></div>
		</div>
		<div class="col-lg-3 col-md-4 col-sm-6 col-12 border border-cs">
			<div class="atas border-bottom row">
				<div class="kiri col-auto"><i class="bi bi-list-ol display-1 text-info-emphasis"></i></div>
				<div class="kanan col-auto p-2 text-end">
					<h3>Mapel</h3>
					<h2>60</h2>
				</div>
			</div>
			<div class="bawah col-auto text-end fs-5 ">Daftar Mapel <i class="bi bi-arrow-right-circle text-info-emphasis"></i></div>
		</div>
		<div class="col-lg-3 col-md-4 col-sm-6 col-12 border border-cs">
			<div class="atas border-bottom row">
				<div class="kiri col-auto"><i class="bi bi-database-fill display-1 text-info-emphasis"></i></div>
				<div class="kanan col-auto p-2 text-end">
					<h3>Soal</h3>
					<h2>150</h2>
				</div>
			</div>
			<div class="bawah col-auto text-end fs-5 ">Daftar Soal <i class="bi bi-arrow-right-circle text-info-emphasis"></i></div>
		</div>
		<!-- <div class="col-lg-3 col-md-4 col-sm-6 col-12 border border-cs">2</div> -->
	</div>
	<div class="row px-4 gap-4">
		<div class="col-md col-12 bg-info" style="border-radius: 5px;">
			<div class="col-12 p-2 py-4 h1 text-white">SERVER LOCAL</div>
			<div class="col-12 p-3 bg-light" style="border-radius: 8px;">CBTSync Lokal terhubung sebagai Server PUSAT</div>
			<div class="col-12 py-3 fs-3">Server ID : <span class="h3 badge bg-primary">1233333345x</span></div>
		</div>
		<div class="col-md col-12 p-0">
			<div class="col cl p-3 mb-2 fs-3" style="border-radius: 5px;">Selamat Datang Admin</div>
			<div class="col px-4 py-2 cl" style="border-radius: 5px;">Saat ini anda masuk sebagai Admin serta anda dapat mengakses atau menggunakan seluruh fitur-fitur yang ada.</div>
		</div>
	</div>
	<div class="row p-2 mt-3">
		<div class="col-12 fs-3">Jadwal Ujian</div>
		<div class="col table-responsive">
			<table class="table table-hover table-striped table-bordered">
				<thead class="table-info text-center">
					<tr>
						<th style="width: 5%;">No.</th>
						<th style="width: 15%;">Hari/Tanggal/</th>
						<th style="width: 15%;">Jam Mulai/Akhir</th>
						<th style="width: 20%;">Mapel</th>
						<th style="width: 20%;">Kelas/Ruang</th>
						<th style="width: 10%;">Status</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<th scope="row">1</th>
						<td>Mark</td>
						<td>Otto</td>
						<td>@mdo</td>
						<td>Jacob</td>
						<td>Thornton</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>















<!-- === JavaScript === -->
<script>

</script>