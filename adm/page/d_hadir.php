<?php

?>

<style>
		#pr {
		display: flex;
	}
	.hadir {
		background-color: aqua;
	}
</style>

<div class="container-fluid mb-5 p-0">
	<div class="row p-2 border-bottom fs-3 mb-4 shadow-sm ">Daftar Hadir</div>
	<form action="print/c_hadir.php" method="post" id="form" target="prt">
		<div class="row p-2 border-bottom g-2">
			<div class="col-auto">
				<div class="input-group">
					<label for="kelas" class="input-group-text bg-info">Kertas</label>
					<select class="form-control" name="page" id="page">
						<option value="1">A4</option>
						<option value="2">F4</option>
					</select>
				</div>
			</div>
			<div class="col-auto">
				<div class="input-group">
					<label for="kelas" class="input-group-text bg-info">Kelas</label>
					<select class="form-control" name="kls" id="kls">
						<option value="">Pilih Kelas</option>
						<?php
						$qrkls = (mysqli_query($koneksi, "SELECT * FROM kelas GROUP BY nm_kls;"));
						while ($dkls = mysqli_fetch_array($qrkls)) {
							echo '<option value="' . $dkls['kd_kls'] . '">' . $dkls['nm_kls'] . '</option>';
						}
						?>
					</select>
				</div>
			</div>
			<!-- <div class="col-auto">
				<div class="input-group">
					<input type="search" class="form-control" placeholder="Cari Nama" name="crnm" id="crnm">
				</div>
			</div> -->
			<div class="col-auto">
				<button type="submit" id="Submit" class="btn btn-primary">Terapkan</button>
			</div>
	</form>
			<div class="col-auto">
				<button type="button" class="btn btn-outline-danger" onclick="frames['prt'].print();"><i class="bi bi-printer"></i> Print</button>
			</div>
	</div>
	<div class="row">
	<iframe src="print/c_hadir.php" name="prt" id="prt" style="display: yes; width: 100%;height: 80vh;"></iframe>
	<!-- <div id="tampil"></div> -->
	</div>
</div>

<script>

</script>