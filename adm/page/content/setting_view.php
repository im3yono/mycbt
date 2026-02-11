<?php
include_once("../../../config/server.php");
?>
<div class="card p-2">
	<div class="card-body">
		<div class="row p-3 g-3 justify-content-around">
			<?php if ($_SERVER["SERVER_NAME"] == "mylocalhost.com") { ?>
				<div class="col-12 col-md-6 col-xl-4">
					<div class="row justify-content-between bg-dark-subtle p-1" style="border-radius: 5px;">
						<div class="col-auto">
							<div class="form-check form-switch">
								<input class="form-check-input" type="checkbox" role="switch" id="mode" onchange="saveOto(this.id)" <?= isset($inf_set['mode']) && $inf_set['mode'] == "on" ? "checked" : ""; ?>>
								<label class="form-check-label" for="pass">Perbaikan</label>
							</div>
						</div>
						<div class="col-auto">
							<div class="form-check form-switch">
								<input class="form-check-input" type="checkbox" role="switch" id="pass" onchange="saveOto('pass')" <?= isset($inf_set['pass']) && $inf_set['pass'] == "on" ? "checked" : ""; ?>>
								<label class="form-check-label" for="pass">Pesan Password Admin</label>
							</div>
						</div>
					</div>
				</div>
			<?php }
			if (get_ip() == "127.0.0.1" || get_ip() == "::1" && $_COOKIE['user'] == "admin") { ?>
				<div class="col-12 col-md-6 col-xl-4 text-center">
					<!-- <label class="input-group-text bg-body-secondary" for="app_update">Upload File Update</label> -->
					<a class="btn btn-outline-primary" href="../adm/update/"><i class="bi bi-upload"></i> Upload File Update</a>
				</div>
			<?php } ?>
		</div>
		<div class="row p-3 g-3 justify-content-around">
			<div class="col-12 col-md-5 col-xl-4 border p-3" style="border-radius: 5px;">
				<h5 class="mb-3">Pengaturan Aplikasi</h5>
				<div class="input-group mb-3">
					<label class="input-group-text w-50 bg-info" for="thm">Tema Aplikasi</label>
					<select class="form-select" id="thm" name="thm" onchange="saveOto('thm')">
						<option value="df" <?= isset($inf_set['thm']) && $inf_set['thm'] == "df" ? "selected" : ""; ?>>Default</option>
						<option value="alte" <?= isset($inf_set['thm']) && $inf_set['thm'] == "alte" ? "selected" : ""; ?>>AdminLTE</option>
					</select>
				</div>
				<div class="form-check form-switch mb-3">
					<input class="form-check-input" type="checkbox" role="switch" id="ad_notif" onchange="saveOto(this.id)" <?= isset($inf_set['ad_notif']) && $inf_set['ad_notif'] == "on" ? "checked" : ""; ?>>
					<label class="form-check-label" for="ad_notif">Notifikasi Admin diam</label>
				</div>
				<div class="form-check form-switch mb-3">
					<input class="form-check-input" type="checkbox" role="switch" id="lgadm" onchange="saveOto(this.id)" <?= isset($inf_set['lgadm']) && $inf_set['lgadm'] == "on" ? "checked" : ""; ?>>
					<label class="form-check-label" for="lgadm">Akses User biasa</label>
				</div>
				<div class="form-check form-switch mb-3">
					<input class="form-check-input" type="checkbox" role="switch" id="lgsis" onchange="saveOto('lgsis')" <?= isset($inf_set['lgsis']) && $inf_set['lgsis'] == "on" ? "checked" : ""; ?>>
					<label class="form-check-label" for="lgsis">Akses Peserta</label>
				</div>
			</div>
			<div class="col-12 col-md-5 col-xl-4 border p-3" style="border-radius: 5px;">
				<h5 class="mb-3">Pengaturan Default Tes</h5>
				<div class="form-check form-switch mb-3">
					<input class="form-check-input" type="checkbox" role="switch" id="optes" onchange="saveOto(this.id)" <?= isset($inf_set['optes']) && $inf_set['optes'] == "on" ? "checked" : ""; ?>>
					<label class="form-check-label" for="optes">Keamanan Tes</label>
				</div>
				<div class="form-check form-switch mb-3">
					<input class="form-check-input" type="checkbox" role="switch" id="aplk" onchange="saveOto(this.id)" <?= isset($inf_set['aplk']) && $inf_set['aplk'] == "on" ? "checked" : ""; ?>>
					<label class="form-check-label" for="aplk">Akses Wajib Aplikasi MyTBK/SEB</label>
				</div>
				<div class="form-check form-switch mb-3">
					<input class="form-check-input" type="checkbox" role="switch" id="token" onchange="saveOto(this.id)" <?= isset($inf_set['token']) && $inf_set['token'] == "on" ? "checked" : ""; ?>>
					<label class="form-check-label" for="token">Tampilkan Token</label>
				</div>
				<div class="form-check form-switch mb-3">
					<input class="form-check-input" type="checkbox" role="switch" id="hasil" onchange="saveOto(this.id)" <?= isset($inf_set['hasil']) && $inf_set['hasil'] == "on" ? "checked" : ""; ?>>
					<label class="form-check-label" for="hasil">Tampilkan Hasil</label>
				</div>
				<div class="input-group mb-3">
					<input type="number" class="form-control" placeholder="Durasi Tes (Menit)" aria-label="time" id="drsi" onchange="saveOto(this.id)" value="<?= $inf_set['drsi'] ?? ""; ?>">
					<span class="input-group-text bg-info">/</span>
					<input type="number" class="form-control" placeholder="Telat Login (Menit)" aria-label="Server" id="tltlg" onchange="saveOto(this.id)" value="<?= $inf_set['tltlg'] ?? ""; ?>">
				</div>
				<div class="input-group mb-3">
					<span class="input-group-text w-50 bg-info" id="media">Jenis Pelaksanaan</span>
					<select class="form-select" id="jnst" onchange="saveOto(this.id)">
						<option value="" selected>Pilih</option>
						<option value="PH" <?= isset($inf_set['jnst']) && $inf_set['jnst'] == "PH" ? "selected" : ""; ?>>Harian</option>
						<option value="PTS" <?= isset($inf_set['j;-nst']) && $inf_set['jnst'] == "PTS" ? "selected" : ""; ?>>Tengah Semester</option>
						<option value="PAS" <?= isset($inf_set['jnst']) && $inf_set['jnst'] == "PAS" ? "selected" : ""; ?>>Akhir Semester</option>
						<option value="UA" <?= isset($inf_set['jnst']) && $inf_set['jnst'] == "UA" ? "selected" : ""; ?>>Ujian Akhir</option>
						<!-- <option value="5" <?= isset($inf_set['jnst']) && $inf_set['jnst'] == "5" ? "selected" : ""; ?>>Lainnya</option> -->
					</select>
				</div>
				<div class="input-group mb-3">
					<span class="input-group-text w-50 bg-info" id="media">Putar Ulang Media</span>
					<select class="form-select" id="mdpl" onchange="saveOto(this.id)">
						<option value="0" selected>Pilih</option>
						<option value="1" <?= isset($inf_set['mdpl']) && $inf_set['mdpl'] == "1" ? "selected" : ""; ?>>1 Kali</option>
						<option value="2" <?= isset($inf_set['mdpl']) && $inf_set['mdpl'] == "2" ? "selected" : ""; ?>>2 Kali</option>
						<option value="3" <?= isset($inf_set['mdpl']) && $inf_set['mdpl'] == "3" ? "selected" : ""; ?>>3 Kali</option>
						<option value="4" <?= isset($inf_set['mdpl']) && $inf_set['mdpl'] == "4" ? "selected" : ""; ?>>4 Kali</option>
						<option value="5" <?= isset($inf_set['mdpl']) && $inf_set['mdpl'] == "5" ? "selected" : ""; ?>>5 Kali</option>
					</select>
				</div>
			</div>
		</div>
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