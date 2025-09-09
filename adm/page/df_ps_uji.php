<?php

?>

<style>
	.dfsis {
		background-color: aqua;
	}
</style>
<meta http-equiv="refresh" content="30">
<div class="container-fluid mb-5 p-0">
	<div class="row p-2 border-bottom fs-3 mb-4 shadow-sm ">Daftar Peserta</div>
	<div class="row g-2 pb-3">
		<!-- <div class="col-12 col-md-8"> -->
		<!-- <div class="col-auto"><a href="?md=df_uji" class="btn btn-primary">Daftar Ujian</a></div> -->
		<div class="col-auto"><a href="?md=rst_uji" class="btn btn-danger">Request Reset</a></div>
		<div class="col-auto"><button type="button" class="btn btn-info" onclick="window.location.reload();"><i class="bi bi-arrow-clockwise"></i> Reload</button></div>
		<div class="col-auto"></div>
		<!-- </div> -->
	</div>
	<div class="table-responsive">
		<table class="table table-hover border-dark">
			<thead class="table-info text-center align-baseline">
				<tr class="align-middle">
					<th style="min-width: 5%;">No.</th>
					<th style="min-width: 100px;">No Peserta</th>
					<th style="min-width: 250px;">Nama</th>
					<!-- <th style="min-width: 10%;">Kelas | Jurusan</th> -->
					<th style="min-width: 50px;">Soal</th>
					<th style="min-width: 50px;">Ruang</th>
					<th style="min-width: 50px;">Sesi</th>
					<!-- <th style="min-width: 90px;">Login</th> -->
					<?= ($inf_set['optes'] == "on") ? '<th style="min-width: 50px;">Keluar Aplikasi</th>' : ''; ?>
					<th style="min-width: 150px;">IP</th>
					<th style="min-width: 120px;">Status</th>
					<!-- <th colspan="4" style="min-width: 25%;">Ujian</th> -->
					<!-- <th style="min-width: 100px;">Action</th> -->
				</tr>
			</thead>
			<tbody id="table">
				<?php
				$no = 1;

				// $qr_dtuj  = mysqli_query($koneksi, "SELECT pt.*, jd.sts AS jdsts, jd.jm_uji,jd.slsai_uji FROM peserta_tes pt INNER JOIN jdwl jd ON pt.id_ujian = jd.id_ujian WHERE jd.sts='Y' AND jd.tgl_uji=CURRENT_DATE AND jd.jm_uji<=CURRENT_TIME AND jd.slsai_uji >= CURRENT_TIME;");
				$qr_dtuj  = mysqli_query($koneksi, "SELECT 
																							pt.*, 
																							jd.sts AS jdsts, 
																							jd.jm_uji, 
																							jd.slsai_uji 
																						FROM 
																							peserta_tes pt 
																							INNER JOIN jdwl jd ON pt.id_ujian = jd.id_ujian 
																						WHERE 
																							jd.sts = 'Y'
																							AND jd.tgl_uji = CURRENT_DATE
																							AND (
																								-- Kasus normal (tidak melewati tengah malam)
																								(jd.jm_uji <= jd.slsai_uji AND CURRENT_TIME BETWEEN jd.jm_uji AND jd.slsai_uji)
																								OR
																								-- Kasus melewati tengah malam
																								(jd.jm_uji > jd.slsai_uji AND (CURRENT_TIME >= jd.jm_uji OR CURRENT_TIME <= jd.slsai_uji))
																							);
																						");
				while ($row = mysqli_fetch_array($qr_dtuj)) {
					if ($row['sts'] == "U") {
						$sts  = "Aktif";
					} elseif ($row['sts'] == "S") {
						$sts  = "Selesai";
					}
					$jwbs  = mysqli_fetch_array(mysqli_query($koneksi, "SELECT COUNT(*)AS jum FROM `cbt_ljk` WHERE user_jawab ='$row[user]' AND jwbn !='N' AND token = '$row[token]';"));
					if ($row['ip'] == "127.0.0.1") {
						$ip = "Server";
					} else {
						$ip  = $row['ip'];
					}
					if ($row['dt_on'] == "1") {
						$onl = "table-danger ";
						$btn_r = "btn-light";
						$wr_nm = "text-danger";
					} else {
						$onl = "";
						$btn_r = "btn-outline-danger";
						$wr_nm = "";
					}

					$btn_r = '';
					if ($row['rq_rst'] == 'Y') {
						$btn_r = "table-warning";
					}

					$dt_ps = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM `cbt_peserta` WHERE user ='$row[user]'"))

				?>
					<tr align="center" class="<?= $onl . ' ' . $btn_r ?>">
						<th><?= $no; ?></th>
						<td><i class="bi bi-check-circle-fill text-success" <?= $dt_ps['ischt'] == "Y" ? "" : "hidden"; ?>></i> <?= $row['user']; ?></td>
						<td class="<?= $wr_nm; ?> text-start">
							<input type="text" name="user" id="user" value="<?= $row['user']; ?>" hidden>
							<?= $dt_ps['nm']; ?>
						</td>
						<!-- <td>1|IPA</td> -->
						<td><?= $jwbs['jum'] . "/" . $row['jum_soal']; ?></td>
						<td><?= $row['ruang']; ?></td>
						<td><?= $row['sesi']; ?></td>
						<!-- <td>08:03:47</td> -->
						<?= ($inf_set['optes'] == "on") ? $row['dt_out'] : ''; ?>
						<td><?= $ip; ?></td>
						<td><?= $sts; ?></td>
						<!-- <td>
						<button class="btn <?= $btn_r ?> p-1" onclick="reset('<?= $row['user'] ?>','<?= $row['id_tes'] ?>','rq_reset')"><i class="bi bi-arrow-clockwise"></i> Reset</button>
					</td> -->
					</tr>
				<?php $no++;
				} ?>
			</tbody>
		</table>
	</div>
	<div class="row border-top border-dark-subtle p-4 mt-5">
		<div class="col-auto bg-info-subtle py-2 px-3" style="border-radius: 5px;">
			<h5>Catatan :</h5>
			<p>
				* Baris berwarna <b class="p-1" style="background-color: #f8d7da;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b> serta nama berwarna <b class="text-danger">Merah</b> menandakan siswa meiliki riwayat online (terhubung ke internet). <br>
				* Baris berwarna <b class="p-1" style="background-color: #fff3cd;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b> menandakan siswa telah mengajukan permintaan reset akun. <br>
			</p>
		</div>
	</div>
</div>

<script src="../node_modules/jquery/dist/jquery.min.js"></script>
<script>
	function reset(usr, id, aksi) {
		$.ajax({
			type: 'POST',
			url: './db/reset_lg.php', // Ganti dengan URL yang benar
			data: {
				usr: usr,
				id: id,
				ak: aksi,
			}, // Kirim ID data yang ingin dihapus
			success: function(response) {
				// Tampilkan pesan hasil hapus dari server
				// location.reload();
				Swal.fire('Berhasil!', response, 'success')
					.then((result) => {
						// Jika notifikasi ditutup, muat ulang halaman
						if (result.isConfirmed || result.isDismissed) {
							location.reload();
						}
					});
			},
			error: function() {
				Swal.fire('Error', 'An error occurred.', 'error');
			}
		});
	}
</script>

<script>
	// function reload() {
	// 	var container = document.getElementById("table");
	// 	var content = container.innerHTML;
	// 	container.innerHTML = content;

	// 	//this line is to watch the result in console , you can remove it later	

	// 	setInterval(console.log("Refreshed"),5000);
	// }
</script>