<?php
// include_once("./config/server.php");


?>


<style>
	#pf {
		display: flex;
	}

	.iden {
		background-color: aqua;
	}
</style>
<div class="container-fluid mb-5 p-0 pb-5">
	<div class="row p-2 border-bottom fs-3 mb-4 shadow-sm text-uppercase fw-semibold">Identitas</div>
	<div class="row gap-3 px-3 mb-5">
		<div class="col-12 col-md-4 py-2 border" style="border-radius: 7px;">
			<div class="col-12 text-center px-2 mb-4 fs-4">syarat ukuran gambar harus 1:1 (contoh 400px : 400px)</div>
			<div class="row gap-3 justify-content-evenly ">
				<div class="card text-center" style="max-width: 200px;">
					<img src="../img/<?php if ($inf_lgdns != null) {
															echo $inf_lgdns;
														} else {
															echo "tut.png";
														} ?>" class="" alt="..." style="height: 170px; width: 170px;">
					<div class="card-body">
						<h6 class="card-title">Logo Dinas</h6>
						<form action="./db/upload.php?up=lgdnas" method="post" enctype="multipart/form-data">
							<input class="form-control form-control-sm" id="lgdns" name="lgdns" type="file" onchange="this.form.submit()">
						</form>
					</div>
				</div>
				<div class="card text-center" style="max-width: 200px;">
					<img src="../img/<?php if ($inf_fav != null) {
															echo "$inf_fav";
														} else {
															echo "fav.png";
														} ?>" class="" alt="..." style="height: 170px; width: 170px;">
					<div class="card-body">
						<h6 class="card-title">Logo Instansi</h6>
						<form action="./db/upload.php?up=lgsek" method="post" enctype="multipart/form-data">
							<input class="form-control form-control-sm" id="lgsek" name="lgsek" type="file" onchange="this.form.submit()">
						</form>
					</div>
				</div>
				<div class="card text-center" style="max-width: 200px;">
					<img src="../img/<?php if ($inf_ttdp != null) {
															echo $inf_ttdp;
														} else {
															echo "no-image.png";
														} ?>" class="card-img-top" alt="..." style="height: 170px; width: auto;">
					<div class="card-body">
						<h6 class="card-title">TTD Pimpinan</h6>
						<form action="./db/upload.php?up=lgadm" method="post" enctype="multipart/form-data">
							<input class="form-control form-control-sm" id="lgadm" name="lgadm" type="file" onchange="this.form.submit()">
						</form>
					</div>
				</div>
				<div class="card text-center" style="max-width: 200px;">
					<img src="../img/<?php if ($inf_ttdk != null) {
															echo $inf_ttdk;
														} else {
															echo "no-image.png";
														} ?>" class="card-img-top" alt="..." style="height: 170px; width: auto;">
					<div class="card-body">
						<h6 class="card-title">TTD Ketua</h6>
						<form action="./db/upload.php?up=lgsis" method="post" enctype="multipart/form-data">
							<input class="form-control form-control-sm" id="lgsis" name="lgsis" type="file" onchange="this.form.submit()">
						</form>
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg col-12 p-3 border" style="border-radius: 7px;">
			<form action="./db/dbproses.php?pr=up" method="post" enctype="multipart/form-data" id="fr">
				<div class="row">
					<div class="mb-3 col-sm-4 col">
						<label for="idpt" class="form-label">Id Instansi/Server</label>
						<input type="text" class="form-control" id="idpt" name="idpt" value="<?php echo $inf_id ?>">
					</div>
				</div>
				<div class="row">
					<div class="mb-3 col-sm-6 col-12">
						<label for="nmpt" class="form-label">Nama Instansi</label>
						<input type="text" class="form-control" id="nmpt" name="nmpt" value="<?php echo $inf_nm ?>" readonly>
					</div>
					<div class="mb-3 col-sm-6 col-12">
						<label for="nmpt" class="form-label">Alamat</label>
						<input type="text" class="form-control" id="almt" name="almt" value="<?php echo $inf_almt ?>">







						<!-- <select id="form_prov">
										<option value="">Pilih Provinsi</option>
										<?php
										// $daerah = mysqli_query($koneksi, "SELECT * FROM lok_provinces ORDER BY prov_name");
										// while ($d = mysqli_fetch_array($daerah)) {
										// 
										?>
										// 	<option value="<?php echo $d['prov_id']; ?>"><?php echo $d['prov_name']; ?></option>
										// <?php
												// }
												?>
									</select>

									<select id="form_kab"></select>

									<select id="form_kec"></select>

									<select id="form_des"></select> -->










					</div>
					<div class="mb-3 col-sm-6 col-12">
						<label for="nmkpt" class="form-label">Pimpinan Instansi</label>
						<input type="text" class="form-control" id="nmkpt" name="nmkpt" value="<?php echo $inf_kep ?>">
					</div>
					<div class="mb-3 col-sm-6 col-12">
						<label for="nmkpt" class="form-label">Ketua Ujian</label>
						<input type="text" class="form-control" id="nmpnpt" name="nmpnpt" value="<?php echo $inf_kpn ?>">
					</div>
					<!-- <div class="mb-3 col-sm-4 col">
									<label for="adm" class="form-label">Admin</label>
									<input type="text" class="form-control" id="adm" name="adm">
									<select class="form-select f" id="adm" name="adm">
										<option value="1">One</option>
										<option value="2">Two</option>
										<option value="3">Three</option>
									</select>
								</div> -->
				</div>
				<button type="submit" class="btn btn-primary">Simpan</button>
			</form>
		</div>
	</div>
</div>

<!-- <script src="../../node_modules/jquery/dist/jquery.js"></script> -->
<script>
	$(document).ready(function() {

		// sembunyikan form kabupaten, kecamatan dan desa
		// $("#form_kab").hide();
		// $("#form_kec").hide();
		// $("#form_des").hide();

		// ambil data kabupaten ketika data memilih provinsi
		$('#form_prov').change(function() {
			var id = $(this).val();
			var data = "id=" + id + "&data=kabupaten";
			$.ajax({
				type: 'POST',
				url: "get_daerah.php",
				data: data,
				success: function(hasil) {
					$("#form_kab").html(hasil);
					// $("#form_kab").show();
					// $("#form_kec").hide();
					// $("#form_des").hide();
				}
			});
		});

		// ambil data kecamatan/kota ketika data memilih kabupaten
		$('#form_kab').change(function() {
			var id = $(this).val();
			var data = "id=" + id + "&data=kecamatan";
			$.ajax({
				type: 'POST',
				url: "get_daerah.php",
				data: data,
				success: function(hasil) {
					$("#form_kec").html(hasil);
					// $("#form_kec").show();
					// $("#form_des").hide();
				}
			});
		});

		// ambil data desa ketika data memilih kecamatan/kota
		$('#form_kec').change(function() {
			var id = $(this).val();
			var data = "id=" + id + "&data=desa";
			$.ajax({
				type: 'POST',
				url: "get_daerah.php",
				data: data,
				success: function(hasil) {
					$("#form_des").html(hasil);
					// $("#form_des").show();
				}
			});
		});


	});
</script>