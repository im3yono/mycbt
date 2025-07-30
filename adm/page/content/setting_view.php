<?php
include_once("../../../config/server.php");
?>
<div class="row p-3 g-3 bg-secondary-subtle" style="border-radius: 10px;">
	<?php if ($_SERVER["SERVER_NAME"] == "mylocalhost.com") { ?>
		<div class="col-12">
			<div class="form-check form-switch">
				<input class="form-check-input" type="checkbox" role="switch" id="pass" onchange="saveOto('pass')" value="<?= $inf_set['pass'] == "on" ? "off" : "on"; ?>" <?= $inf_set['pass'] == "on" ? "checked" : ""; ?>>
				<label class="form-check-label" for="pass">Aktifkan Pesan Password Admin</label>
			</div>
		</div>
	<?php } ?>
	<div class="col-12 col-md-4">
		<div class="input-group mb-3">
			<label class="input-group-text w-50 bg-info" for="thm">Tema Aplikasi</label>
			<select class="form-select" id="thm" name="thm" onchange="saveOto('thm')">
				<option value="df" <?= $inf_set['thm'] == "df" ? "selected" : ""; ?>>Default</option>
				<option value="alte" <?= $inf_set['thm'] == "alte" ? "selected" : ""; ?>>AdminLTE</option>
			</select>
		</div>
		<div class="form-check form-switch mb-3">
			<input class="form-check-input" type="checkbox" role="switch" id="lgadm" onchange="saveOto(this.id)" <?= $inf_set['lgadm'] == "on" ? "checked" : ""; ?>>
			<label class="form-check-label" for="lgadm">Aktifkan Akses User biasa</label>
		</div>
		<div class="form-check form-switch mb-3">
			<input class="form-check-input" type="checkbox" role="switch" id="lgsis" onchange="saveOto('lgsis')" value="<?= $inf_set['lgsis'] == "on" ? "off" : "on"; ?>" <?= $inf_set['lgsis'] == "on" ? "checked" : ""; ?>>
			<label class="form-check-label" for="lgsis">Aktifkan Akses Peserta</label>
		</div>
		<div class="form-check form-switch mb-3">
			<input class="form-check-input" type="checkbox" role="switch" id="optes" onchange="saveOto(this.id)" <?= $inf_set['optes'] == "on" ? "checked" : ""; ?>>
			<label class="form-check-label" for="optes">Aktifkan Keamanan Tes</label>
		</div>
		<div class="input-group mb-3">
			<input type="number" class="form-control" placeholder="Durasi Tes Global (Menit)" aria-label="time">
			<span class="input-group-text bg-info">/</span>
			<input type="number" class="form-control" placeholder="Telat Login Global (Menit)" aria-label="Server">
		</div>
		<div class="input-group mb-3">
			<span class="input-group-text w-50 bg-info" id="media">Putar Ulang Media Global</span>
			<select class="form-select" id="media">
				<option value="0" selected>Pilih</option>
				<option value="1">1 Kali</option>
				<option value="2">2 Kali</option>
				<option value="3">3 Kali</option>
				<option value="4">4 Kali</option>
				<option value="5">5 Kali</option>
			</select>
		</div>
	</div>
	<div class="col-12 col-md-4">
	</div>
</div>

<script>
	function saveOto(id) {
		let el = document.getElementById(id);
		let val;

		// Tentukan nilai berdasarkan tipe elemen
		if (el.type === "checkbox") {
			val = el.checked ? "on" : "off";
		} else if (el.type === "radio") {
			// Untuk radio, ambil radio dengan nama yang sama dan status checked
			let checkedRadio = document.querySelector(`input[name="${el.name}"]:checked`);
			val = checkedRadio ? checkedRadio.value : "";
		} else {
			val = el.value;
		}

		$.post("../adm/db/setting_up.php", {
			opsi: id,
			value: val,
			nm: id
		}, function(data) {
			const success = (data == 'ok' || data == 'ok1');
			swal.fire({
				title: success ? 'Berhasil' : 'Gagal',
				text: success ? 'Pengaturan berhasil disimpan' : 'Pengaturan gagal disimpan: ' + data,
				icon: success ? 'success' : 'error',
				confirmButtonText: 'OK'
			}).then((result) => {
				if (data == 'ok' && result.isConfirmed) {
					location.reload();
				}
			});
		});
	}
</script>