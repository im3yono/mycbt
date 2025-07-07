<?php
require_once('../../../config/server.php');

$id   = $_POST['id'];
$opsi  = $_POST['opsi'];

// Jadwal Ujian
if ($opsi == "jdwl") {
	$jdwl = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM jdwl WHERE id_ujian ='$id'"));
	$dtmpl  = mysqli_query($koneksi, "SELECT * FROM cbt_pktsoal WHERE kd_soal ='$jdwl[kd_soal]'");
	$dt = mysqli_fetch_array($dtmpl);
	$mpel = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM mapel WHERE kd_mpel ='$jdwl[kd_mpel]'"));
	$jsl  = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM cbt_soal WHERE kd_soal ='$jdwl[kd_soal]'"));
	$pkt	= mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM cbt_pktsoal WHERE kd_soal ='$jdwl[kd_soal]'"));

	if ($jdwl['kd_kls'] == "1") {
		$kkelas = "";
	} else {
		$kkelas = $jdwl['kd_kls'] . '_';
	}
	if ($jdwl['kls'] == "1") {
		$kelas = "Semua";
	} else {
		$kelas = $jdwl['kls'];
	}
	if ($jdwl['jur'] == "1") {
		$jurusan = "Semua";
	} else {
		$jurusan = $jdwl['jur'];
	}

	if ($jsl < $pkt['jum_soal']) {
		$ctek = "text-danger";
	} elseif ($jsl == $pkt['jum_soal']) {
		$ctek = "fw-semibold";
	} else {
		$ctek = "text-success";
	}
?>
	<form method="post" id="jdwl">
		<div class="row">
			<div class="col-12 m-0 border-bottom">
				<table class="fw-normal caption-top text-black">
					<caption class="fw-semibold text-decoration-underline">Info Paket Soal</caption>
					<tr valign="top">
						<td style="width: 250px;">Kode Soal</td>
						<td>: </td>
						<td class="fw-bold" style="width: 80%;"><?php echo $jdwl['kd_soal'] ?>
							<input type="text" hidden id="kds" name="kds" value="<?php echo $jdwl['kd_soal'] ?>">
						</td>
					</tr>
					<tr valign="top">
						<td style="width: 170px;">Mata Pelajaran</td>
						<td>: </td>
						<td class="fw-bold"><?php echo $mpel['nm_mpel'] ?>
							<input type="text" hidden id="kmpel" name="kmpel" value="<?php echo $mpel['kd_mpel'] ?>">
						</td>
					</tr>
					<tr valign="top">
						<td>Pembuat Soal</td>
						<td>: </td>
						<td>
							<h5><?php echo $dt['author'] ?></h5>
							<input type="text" name="author" id="author" value="<?= $dt['author']; ?>" hidden>
						</td>
					</tr>
					<tr valign="top">
						<td>Jumlah Data Soal</td>
						<td>: </td>
						<td>
							<span class="<?= $ctek; ?>"><?= $jsl . ' data soal ' ?></span><?= ', ' . $dt['jum_soal'] . ' ditampilkan' ?>
						</td>
					</tr>
					<?php if (!empty($jdwl['pl_m'])) { ?>
						<tr>
							<td colspan="3">
								<div class="fw-semibold fs-6 pt-3 alert alert-danger">Soal ini memiliki file media. Harap sesuaikan pengulangan media sesuai kebutuhan.</div>
							</td>
						</tr>
					<?php } ?>
				</table>
			</div>
		</div>
		<div class="row mt-3 g-2">
			<div class="col-md-6 col-12">
				<div class="input-group">
					<label class="input-group-text bg-success-subtle" for="inputGroupSelect01">Sifat Tes</label>
					<select class="form-select" id="mode_uji" name="mode_uji">
						<option value="0" <?= $jdwl['md_uji'] == '0' ? "selected" : ""; ?>>Terbuka</option>
						<option value="1" <?= $jdwl['md_uji'] == '1' ? "selected" : ""; ?>>Tertutup</option>
					</select>
				</div>
			</div>
			<?php if (!empty($jdwl['pl_m'])) { ?>
				<div class="col-md-6 col-12">
					<div class="input-group">
						<label class="input-group-text bg-success-subtle" for="inputGroupSelect01">Pengulangan Media</label>
						<select class="form-select" id="pl_media" name="pl_media" required>
							<option value="0">Pilih</option>
							<option value="1" <?= $jdwl['pl_m'] == '1' ? "selected" : ""; ?>>1 Kali</option>
							<option value="2" <?= $jdwl['pl_m'] == '2' ? "selected" : ""; ?>>2 Kali</option>
							<option value="3" <?= $jdwl['pl_m'] == '3' ? "selected" : ""; ?>>3 Kali</option>
							<option value="4" <?= $jdwl['pl_m'] == '4' ? "selected" : ""; ?>>4 Kali</option>
							<option value="5" <?= $jdwl['pl_m'] == '5' ? "selected" : ""; ?>>5 Kali</option>
						</select>
					</div>
				</div>
			<?php } ?>
		</div>
		<div class="row mt-3 g-2">
			<div class="col-md-6 col-12">
				<div class="input-group">
					<span for="kkls" class="input-group-text bg-dark-subtle" style="width: 115px;">Nama Kelas</span>
					<select name="kkls" id="kkls" class="form-select">
						<option value="1">Semua</option>
						<?php
						$dtt = (mysqli_query($koneksi, "SELECT * FROM kelas"));
						while ($row = mysqli_fetch_array($dtt)) { ?>
							<option value="<?= $row['kd_kls']; ?>" <?= ($jdwl['kd_kls'] == $row['kd_kls'] ? "selected" : "") ?>><?= $row['nm_kls']; ?></option>
						<?php } ?>
					</select>
				</div>
			</div>
			<div class="col-md-6 col-12">
				<div class="input-group">
					<span for="kls" class="input-group-text bg-dark-subtle" style="width: 115px;">Kelas</span>
					<select name="kls" id="kls" class="form-select">
						<option value="1">Semua</option>
						<?php
						$dtt = (mysqli_query($koneksi, "SELECT * FROM kelas GROUP BY kls"));
						while ($row = mysqli_fetch_array($dtt)) { ?>
							<option value="<?= $row['kls']; ?>" <?= ($jdwl['kls'] == $row['kls'] ? "selected" : "") ?>><?= $row['kls']; ?></option>
						<?php } ?>
					</select>
				</div>
			</div>
			<div class="col-md-6 col-12">
				<div class="input-group">
					<span for="jur" class="input-group-text bg-dark-subtle" style="width: 115px;">Jurusan</span>
					<select name="jur" id="jur" class="form-select">
						<option value="1">Semua</option>
						<?php
						$dtt = (mysqli_query($koneksi, "SELECT * FROM kelas GROUP BY jur"));
						while ($row = mysqli_fetch_array($dtt)) { ?>
							<option value="<?= $row['jur']; ?>" <?= ($jdwl['jur'] == $row['jur'] ? "selected" : "") ?>><?= $row['jur']; ?></option>
						<?php } ?>
					</select>
				</div>
			</div>
			<div class="col-md-6 col-12">
				<div class="input-group">
					<span for="ses" class="input-group-text bg-dark-subtle" style="width: 115px;">Sesi</span>
					<select name="ses" id="ses" class="form-select">
						<?php
						$dtt = (mysqli_query($koneksi, "SELECT * FROM kelas"));
						for ($i = 0; $i <= 7; $i++) { ?>
							<option value="<?= $i; ?>" <?= ($jdwl['sesi'] == $i ? "selected" : "") ?>><?= ($i == 0) ? "Semua" : $i ?></option>
						<?php } ?>
					</select>
				</div>
			</div>
		</div>
		<div class="row mt-3 g-2">
			<div class="col-md-6 col-12">
				<div class="input-group">
					<span class="input-group-text bg-primary-subtle" id="basic-addon1" style="width: 115px;">Jenis Tes</span>
					<select class=" form-select" name="kdtes" id="kdtes">
						<option value="PH" <?= ($jdwl['kd_ujian'] == "PH") ? 'selected' : '' ?>>Penilaian Harian</option>
						<option value="PTS" <?= ($jdwl['kd_ujian'] == "PTS") ? 'selected' : '' ?>>Penilaian Tengah Semester</option>
						<option value="PAS" <?= ($jdwl['kd_ujian'] == "PAS") ? 'selected' : '' ?>>Penilaian Akhir Semester</option>
						<option value="UA" <?= ($jdwl['kd_ujian'] == "UA") ? 'selected' : '' ?>>Ujian Akhir</option>
					</select>
				</div>
			</div>
			<div class="col-md-6 col-12">
				<div class="input-group">
					<span class="input-group-text bg-info-subtle" id="basic-addon1" style="width: 115px;">Tanggal</span>
					<input type="date" id="tgl" name="tgl" class="form-control" value="<?= date(($jdwl['tgl_uji'])); ?>">
				</div>
			</div>
		</div>
		<div class="row mt-auto g-2">
			<div class="col-md-6 col-12">
				<div class="input-group">
					<span class="input-group-text bg-dark-subtle" id="basic-addon1" style="width: 115px;">Jam Mulai</span>
					<input type="time" id="jm_awal" name="jm_awal" class="form-control" value="<?= date('H:i', strtotime($jdwl['jm_uji'])); ?>" required>
				</div>
			</div>
			<div class="col-md-6 col-12">
				<div class="input-group">
					<span class="input-group-text bg-dark-subtle" id="basic-addon1" style="width: 115px;">Jam Akhir</span>
					<input type="time" id="jm_akhir" name="jm_akhir" class="form-control" value="<?= date('H:i', strtotime($jdwl['slsai_uji'])); ?>" required>
				</div>
			</div>
			<div class="col-md-6 col-12">
				<div class="input-group">
					<span class="input-group-text bg-dark-subtle" id="basic-addon1" style="width: 115px;">Durasi</span>
					<input type="number" id="durasi" min="" name="durasi" class="form-control" value="<?= db_JamToMenit($jdwl['lm_uji']); ?>" required placeholder="Menit">
				</div>
			</div>
			<div class="col-md-6 col-12">
				<div class="input-group">
					<span class="input-group-text bg-dark-subtle" id="basic-addon1" style="width: 115px;">Telat Login</span>
					<input type="number" id="telat" name="telat" class="form-control" value="<?= selisihJamToMenit($jdwl['jm_uji'], $jdwl['bts_login']); ?>" required placeholder="Menit">
				</div>
			</div>
			<div class="col-md-6 col-12">
				<div class="input-group">
					<span class="input-group-text bg-dark-subtle" id="basic-addon1" style="width: 115px;">Token</span>
					<input type="text" id="token" name="token" class="form-control" value="<?= $jdwl['token']; ?>" readonly>
					<select class=" form-select" name="ttoken" id="ttoken">
						<option value="T" <?= ($jdwl['sts_token'] == 'T') ? 'selected' : ''; ?>>Tidak Tampil</option>
						<option value="Y" <?= ($jdwl['sts_token'] == 'Y') ? 'selected' : ''; ?>>Tampil</option>
					</select>
				</div>
			</div>
			<div class="col-md-6 col-12">
				<div class="input-group">
					<span class="input-group-text bg-dark-subtle" id="basic-addon1" style="width: 115px;">Nilai</span>
					<select class="form-select" name="nilai" id="nilai">
						<option value="T" <?= ($jdwl['sts_nilai'] == 'T') ? 'selected' : ''; ?>>Tidak Tampil</option>
						<option value="Y" <?= ($jdwl['sts_nilai'] == 'Y') ? 'selected' : ''; ?>>Tampil</option>
					</select>
				</div>
			</div>
		</div>
	</form>
<?php }


// Daftar Jadwal Ujian
if ($opsi == "df_jdwl") { ?>
	<table class="table table-striped table-hover table-bordered">
		<thead class="text-center">
			<th>No</th>
			<th>Hari, Tanggal</th>
			<th>Waktu</th>
			<th>Nama Kelas | Kelas | Jurusan</th>
			<th>Token</th>
			<?php if ($_POST['tm'] == "vw") { ?>
				<th>Hapus</th>
			<?php } ?>
		</thead>
		<tbody>
			<?php
			if ($_POST['tm'] == "hs") {
				$st = 'H';
			} elseif ($_POST['tm'] == "vw") {
				$st = 'Y';
			}
			$query = "SELECT * FROM jdwl WHERE kd_soal = '$id' AND sts='$st' ORDER BY tgl_uji DESC";
			$result = $koneksi->query($query);
			$no = 1;

			if ($result->num_rows > 0) {
				while ($dtjd = $result->fetch_assoc()) {
					$mpl = $koneksi->query("SELECT * FROM mapel WHERE kd_mpel = '{$dtjd['kd_mpel']}'")->fetch_assoc();
					$kls = $koneksi->query("SELECT * FROM kelas WHERE kd_kls = '{$dtjd['kd_kls']}'")->fetch_assoc();
					$rng = $koneksi->query("SELECT ruang FROM cbt_peserta WHERE kd_kls = '{$dtjd['kd_kls']}'")->fetch_assoc();
					$status = ($dtjd['tgl_uji'] < date('Y-m-d')) ? 'Selesai' : 'Aktif';
			?>
					<tr class="text-center">
						<th><?= $no++; ?></th>
						<td><?= tgl_hari($dtjd['tgl_uji']); ?></td>
						<td><?= date('H:i', strtotime($dtjd['jm_uji'])) . " - " . date('H:i', strtotime($dtjd['slsai_uji'])); ?></td>
						<td>
							<?= ($dtjd['kd_kls'] == 1 ? 'Semua' : $kls['nm_kls']) . " | " . ($dtjd['kls'] == 1 ? 'Semua' : $dtjd['kls']) . " | " . ($dtjd['jur'] == 1 ? 'Semua' : $dtjd['jur']); ?>
						</td>
						<td><?= htmlspecialchars($dtjd['token']); ?></td>
						<?php if ($_POST['tm'] == "vw") { ?>
							<td>
								<button class="btn btn-sm btn-danger m-1" id="delete" onclick="deleteJdwl(<?= htmlspecialchars($dtjd['id_ujian']); ?>,'<?= $dtjd['token']; ?>')">
									<i class="bi bi-trash"></i>
								</button>
							</td>
						<?php } ?>
					</tr>
			<?php
				}
			} else {
				// Tampilkan pesan jika tidak ada data
				echo '<tr><td colspan="6" class="text-center">Data Tidak Tersedia</td></tr>';
			}
			?>

		</tbody>
	</table>
	<?php if ($_POST['tm'] == "vw") { ?>
		<div class="col-auto px-3 alert-success alert">
			<h5>Catatan :</h5>
			<table class="text-dark">
				<tr>
					<td style="width: 50px;"><a class="btn btn-sm btn-danger"><i class="bi bi-trash3"></i> </a></td>
					<td style="text-align: justify;">Menghapus jadwal ketika sedang dalam pelaksanaan akan berakibat <i class="fw-bold">siswa keluar dan jawaban akan di hapus dari sistem</i>.</td>
				</tr>
				<!-- <tr>
				<td><a class="btn btn-sm btn-primary"><i class="bi bi-gear"></i> </a></td>
				<td>Hindari perubahan jadwal ketika sedang pelaksanaan, kecuali siswa tidak mengerjakan.</td>
			</tr> -->
		</div>
		<?php }
}


// Daftar Jawaban Siswa
if ($opsi == "sis_jwbn") {
	echo '
				<table class="table table-hover table-bordered border-dark">
					<thead class=" table-info">
						<tr class="text-center">
							<th style="width: 30px;text-align: center;">No</th>
							<th>Soal</th>
							<th>Jawaban</th>
							<!-- <td>Opsi</td> -->
						</tr>
					</thead>
					<tbody>';
	$token 	= $_POST['token'];
	$kds		= $_POST['kds'];

	$no = 0;
	$jml_soal  = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM cbt_pktsoal WHERE kd_soal='$kds'"));
	$qr_ljk	= (mysqli_query($koneksi, "SELECT * FROM cbt_ljk WHERE user_jawab ='$id' AND token ='$token' AND kd_soal ='$kds';"));
	$bnr = isset($bnr) ? $bnr : 0;       // Inisialisasi $bnr jika belum ada
	$salah = isset($salah) ? $salah : 0; // Inisialisasi $salah jika belum ada
	if (mysqli_num_rows($qr_ljk) == 0) {
		// echo '<tr><td colspan="3" class="text-center"><div class="text-danger">Data tidak ditemukan</div></td></tr>';
		for ($i = 1; $i <= $jml_soal['jum_soal']; $i++) { ?>
			<tr class="table-danger" id="rw<?= $i; ?>">
				<th style="width: 30px;text-align: center;"><?= $i ?></th>
				<td style="width: auto;text-align: start;">
					<div id="add<?= $i ?>">
						<div class="text-danger">Soal tidak lengkap</div>
						<select name="nos" id="nos_<?= $i ?>" class="form-select form-select-sm" style="width: 100px;display: inline-block;">
							<option value="0" selected disabled>Pilih No Soal</option>
							<?php for ($n = 1; $n <= $jml_soal['jum_soal']; $n++) { ?>
								<option value="<?= $n; ?>"><?= $n; ?></option>
							<?php } ?>
						</select>
						<button type="button" class="btn btn-primary btn-sm " onclick="opsiAdd('<?= $i ?>','nos_<?= $i ?>','<?= $id; ?>','<?= $kds; ?>','<?= $token; ?>')"><i class="bi bi-plus-lg"></i> Tambah</button>
					</div>
				</td>
				<td style="max-width: 50%;text-align: center;">-</td>
			</tr>
			<?php
		}
		// return;
	} else {
		while ($nd = mysqli_fetch_array($qr_ljk)) {
			$n_sis[] = $nd['no_soal'];
		}
		// $d_ns = range(1, $jml_soal['jum_soal']);
		$d_ns = range(1, $jml_soal['jum_soal']);
		$n0 = array_diff($d_ns, $n_sis);
		$nodt = count($n0);

		$qr_ljk2	= (mysqli_query($koneksi, "SELECT  MAX(urut) AS mak FROM cbt_ljk WHERE user_jawab ='$id' AND token ='$token' AND kd_soal ='$kds';"));
		$jml_soal_ov = mysqli_fetch_array($qr_ljk2);

		if ($jml_soal_ov['mak'] > $jml_soal['jum_soal']) {
			$max = $jml_soal_ov['mak'];
		} else {
			$max = $jml_soal['jum_soal'];
		}
		// while ($data = mysqli_fetch_array($qr_ljk2)) {
		for ($i = 1; $i <= $max; $i++) {
			$data = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM cbt_ljk WHERE user_jawab ='$id' AND token ='$token' AND kd_soal ='$kds' AND urut = '$i';"));
			if (!$data) {
				// continue; // Skip if no data found for this iteration
			?>
				<tr class="table-danger" id="rw<?= $i; ?>">
					<th style="width: 30px;text-align: center;"><?= $i ?></th>
					<td style="width: auto;text-align: start;">
						<div id="add<?= $i ?>">
							<div class="text-danger">Soal tidak lengkap</div>
							<select name="nos" id="nos_<?= $i ?>" class="form-select form-select-sm" style="width: 100px;display: inline-block;">
								<option value="0" selected disabled>Pilih No Soal</option>
								<?php foreach ($n0 as $n) { ?>
									<option value="<?= $n; ?>"><?= $n; ?></option>
								<?php } ?>
							</select>
							<button type="button" class="btn btn-primary btn-sm " onclick="opsiAdd('<?= $i ?>','nos_<?= $i ?>','<?= $id; ?>','<?= $kds; ?>','<?= $token; ?>')"><i class="bi bi-plus-lg"></i> Tambah</button>
						</div>
					</td>
					<td style="max-width: 50%;text-align: center;">-</td>
				</tr>
			<?php
				continue;
			}
			$d_soal		= mysqli_fetch_array(mysqli_query($koneksi, "SELECT * From cbt_soal WHERE kd_soal='$kds' AND no_soal ='$data[no_soal]'"));
			if ($data['nil_pg'] == 1 && $data['nil_jwb'] != 0) {
				$jwb = '<img src="../img/sbenar2.png" alt="" srcset="" width="45px">';
			} elseif ($data['nil_pg'] == 0 && $data['nil_jwb'] == 0) {
				$jwb = "-";
			} else {
				$jwb = '<img src="../img/salah.png" alt="" srcset="" width="45px">';
			}


			($data['nil_pg'] == 1) ? $bnr++ : $salah++;
			$bnr > $jml_soal['jum_soal'] ? $bnr = $jml_soal['jum_soal'] : $bnr;
			$salah > $jml_soal['jum_soal'] ? $salah = $jml_soal['jum_soal'] : $salah;

			$data['jns_soal'] == "G" ? $jawaban = $jwb : $jawaban = $data['es_jwb'];

			?>
			<tr id="rw<?= $i; ?>">
				<th style="width: 30px;text-align: center;"><?= $data['urut'] ?></th>
				<td style="width: auto;text-align: start;">

					<?php
					if (!empty($d_soal['tanya']) && $data['urut'] <= $jml_soal['jum_soal']) {
						echo $d_soal['tanya'];
					} elseif ($data['urut'] >= $jml_soal['jum_soal']) { ?>
						<div class="text-danger">Soal Lebih</div>
					<?php } else { ?>
						<div id="edit<?= $data['urut'] ?>">
							<div class="text-danger">Data Tidak ditemukan</div>

							<select name="nos" id="nos_<?= $data['urut']; ?>" class="form-select form-select-sm" style="width: 100px;display: inline-block;">
								<option value="0" selected disabled>Pilih No Soal</option>
								<?php foreach ($n0 as $n) { ?>
									<option value="<?= $n; ?>"><?= $n; ?></option>
								<?php } ?>
							</select>
							<button type="button" class="btn btn-info btn-sm" onclick="opsiEdit('<?= $data['urut'] ?>','nos_<?= $data['urut']; ?>','<?= $id; ?>','<?= $kds; ?>','<?= $token; ?>')"><i class="bi bi-pencil-square"></i> Perbaiki</button>
						</div>
					<?php
					}
					?>
				</td>
				<td style="max-width: 50%;text-align: center;">
					<?php if (!empty($d_soal['tanya']) && $data['urut'] <= $jml_soal['jum_soal']) {
						echo $jawaban;
					} elseif ($data['urut'] >= $jml_soal['jum_soal']) { ?>
						<button type="button" class="btn btn-danger  btn-sm " onclick="opsiDel('<?= $i ?>','<?= $id; ?>','<?= $kds; ?>','<?= $token; ?>')"><i class="bi bi-trash3"></i> Hapus</button>
					<?php } else {
						echo '-';
					} ?>
				</td>
				<!-- <td><?= !empty($d_soal['tanya']) ? '' : '<button class="btn btn-primary btn-sm "><i class="bi bi-gear"></i></button>' ?></td> -->
			</tr>
	<?php $no++;
		}
	}
	?>

	<tr class="fw-bold">
		<td colspan="2" class="text-end">Benar</td>
		<td><?= $bnr; ?></td>
	</tr>
	<tr class="fw-bold">
		<td colspan="2" class="text-end">Salah</td>
		<td><?= $salah; ?></td>
	</tr>
	</tbody>
	</table>
	<script>
		function opsiEdit(nos, nou, usr, kds, tk) {
			const selectedNo = document.getElementById(nou).value;
			if (selectedNo != "0") {
				// Lakukan aksi untuk mengedit soal berdasarkan nomor yang dipilih
				// Misalnya, bisa membuka modal atau mengirim data ke server
				console.log(`Mengedit soal dengan nomor: ${selectedNo}`);
				// Tambahkan logika untuk mengedit soal di sini
				$.ajax({
					type: 'POST',
					url: './db/dbproses.php?pr=uj_edt_ljk',
					data: {
						nou: selectedNo,
						nos: nos,
						kds: kds,
						usr: usr,
						tk: tk
					},
					success: function(response) {
						$('#edit' + nos).html(response);
						// Tampilkan hasil atau lakukan sesuatu dengan response
						Swal.fire({
							icon: 'success',
							title: 'Berhasil',
							// text: response,
						});
					}
				})
			} else {
				alert("Silakan pilih nomor soal yang valid.");
			}
		}

		function opsiAdd(nos, nou, usr, kds, tk) {
			const selectedNo = document.getElementById(nou).value;
			if (selectedNo != "0") {
				// Lakukan aksi untuk mengedit soal berdasarkan nomor yang dipilih
				// Misalnya, bisa membuka modal atau mengirim data ke server
				console.log(`Mengedit soal dengan nomor: ${selectedNo}`);
				// Tambahkan logika untuk mengedit soal di sini
				$.ajax({
					type: 'POST',
					url: './db/dbproses.php?pr=uj_add_ljk',
					data: {
						nou: selectedNo,
						nos: nos,
						kds: kds,
						usr: usr,
						tk: tk
					},
					success: function(response) {
						$('#add' + nos).html(response);
						$('#rw' + nos).removeClass('table-danger');
						// Tampilkan hasil atau lakukan sesuatu dengan response
						Swal.fire({
							icon: 'success',
							title: 'Berhasil',
							// text: response,
						});
					}
				})
			} else {
				alert("Silakan pilih nomor soal yang valid.");
			}
		}

		function opsiDel(nos, usr, kds, tk) {
			// Tambahkan logika untuk mengedit soal di sini
			Swal.fire({
				title: 'Yakin ingin menghapus data ini?',
				text: "Data yang dihapus tidak dapat dikembalikan.",
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#d33',
				cancelButtonColor: '#3085d6',
				confirmButtonText: 'Ya, hapus!',
				cancelButtonText: 'Batal'
			}).then((result) => {
				if (result.isConfirmed) {
					$.ajax({
						type: 'POST',
						url: './db/dbproses.php?pr=uj_del_ljk',
						data: {
							nos: nos,
							kds: kds,
							usr: usr,
							tk: tk
						},
						success: function(response) {
							$('#rw' + nos).html('');
							Swal.fire({
								icon: 'success',
								title: 'Berhasil',
								// text: response,
							});
						}
					});
				}
			});
		}
	</script>

<?php
}


// Pesan
if ($opsi == "pesan") {
	$to_user = $_POST['id'];
	$pesan = mysqli_fetch_array(mysqli_query($koneksi, "SELECT psn AS pesan FROM psn WHERE ke = '$to_user'"))
?>
	<form action="" method="post" id="pesan_form">
		<div class="col">
			<!-- <label for="pesan" class="form-label">Kirim Pesan </label> -->
			<textarea name="pesan" id="pesan" class="form-control" rows="5" placeholder="Ketik pesan disini..."><?= !empty($pesan['pesan']) ? $pesan['pesan'] : ''; ?></textarea>
			<input type="text" name="t_user" id="t_user" value="<?= $to_user; ?>" hidden>
			<input type="text" name="f_user" id="f_user" value="<?= $_COOKIE['user']; ?>" hidden>
		</div>
	</form>
<?php
}


// Tambah Waktu Ujian
if ($opsi == "tmbh_waktu") {
	# code...
}
?>