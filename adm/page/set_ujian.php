<?php

?>

<style>
		#uj {
		display: flex;
	}
	.setuj {
		background-color: aqua;
	}
</style>

<div class="container-fluid mb-5 p-0">
	<div class="row p-2 border-bottom fs-3 mb-4 shadow-sm ">Setting Ujian</div>
	<div class="table-responsive">
		<table class="table table-hover table-striped table-bordered">
			<thead class="table-info text-center align-baseline">
				<tr>
					<th style="width: 5%;">No.</th>
					<th style="width: 10%;">Kode Soal</th>
					<th style="width: 35%;">Mata Pelajaran</th>
					<th style="width: 15%;">Kelas | Jurusan</th>
					<th style="width: 20%;">Alokasi Waktu</th>
					<!-- <th style="width: 5%;">Jumlah Soal </th> -->
					<th style="width: 5%;">Status Soal</th>
					<th style="width: 10%;">Jadwalkan</th>
				</tr>
			</thead>
			<tbody>
				<?php

				$batas = 10;
				$hal   = isset($_GET['pg']) ? (int)$_GET['pg'] : 1;
				$hal_awal = ($hal > 1) ? ($hal * $batas) - $batas : 0;

				$previous = $hal - 1;
				$next     = $hal + 1;

				$no = 1;
				$selectSQL = "SELECT * FROM cbt_pktsoal";
				$data = mysqli_query($koneksi, $selectSQL);
				$jml_data = mysqli_num_rows($data);
				$tot_hal = ceil($jml_data / $batas);

				$dtmpl  = mysqli_query($koneksi, "SELECT * FROM cbt_pktsoal WHERE cbt_pktsoal.sts = 'Y' ORDER BY id_pktsoal ASC limit $hal_awal,$batas");
				while ($dt = mysqli_fetch_array($dtmpl)) {
					// $dtt = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM kelas WHERE kd_kls ='$dt[kd_kls]';"));
				?>
					<tr>
						<th></th>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<!-- <td></td> -->
						<td class="text-center">
							<?php

							if ($dt['sts'] == "Y") {
								echo "<a href='./db/dbproses.php?pr=sts&dt=" . $dt['id_pktsoal'] . "' class='btn btn-sm btn-primary'>Aktif</a>";
							} else {
								echo "<a href='./db/dbproses.php?pr=sts&dt=" . $dt['id_pktsoal'] . "' class='btn btn-sm btn-info'>Modif</a>";
							}

							?>
						</td>
						<td class="text-center">
							<button class="btn btn-sm btn-info fs-6 mb-1"><i class="bi bi-gear"></i></button> 
							<!-- | <button class="btn btn-sm btn-warning fs-6 mb-1"><i class="bi bi-pencil-square"></i></button> |
							<button class="btn btn-sm btn-danger fs-6"><i class="bi bi-trash3"></i></button> -->
						</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>

<script>

</script>