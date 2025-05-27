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
			<input type="time" name="jam" id="jam" class="form-control" value="<?= date('H:i', strtotime('-2 hours')) ?>">
		</div>
	</div>
	<div class="col-12 col-lg-4">
		<div class="input-group">
			<span class="input-group-text" style="width: 120px;">Waktu Selesai</span>
			<input type="time" name="jam2" id="jam2" class="form-control" value="<?= date('H:i') ?>">
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