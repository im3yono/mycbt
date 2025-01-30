<?php
require_once('../../../config/server.php');

$id   = $_POST['id'];
$opsi  = $_POST['opsi'];


if ($opsi == "jdwl") {
	$jdwl = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM jdwl WHERE id_ujian ='$id'"));
	$dtmpl  = mysqli_query($koneksi, "SELECT * FROM cbt_pktsoal WHERE sts = 'Y' AND kd_soal ='$jdwl[kd_soal]'");
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
				<table class="fw-normal caption-top">
					<caption class="fw-semibold text-decoration-underline">Info Paket Soal</caption>
					<tr valign="top">
						<td style="width: 170px;">Kode Soal</td>
						<td>: </td>
						<td class="fw-bold"><?php echo $jdwl['kd_soal'] ?>
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
						</td>
					</tr>
					<tr valign="top">
						<td>Jumlah Data Soal</td>
						<td>: </td>
						<td>
							<span class="<?= $ctek; ?>"><?= $jsl . ' data soal ' ?></span><?= ', ' . $dt['jum_soal'] . ' ditampilkan' ?>
						</td>
					</tr>
				</table>
			</div>
		</div>
		<div class="row mt-3 g-2">
			<div class="col-md-6 col-12">
				<div class="input-group">
					<label class="input-group-text bg-success-subtle" for="inputGroupSelect01">Pelaksanaan Tes</label>
					<select class="form-select" id="mode_uji" name="mode_uji">
						<option selected value="0">Offline</option>
						<option value="1">Online</option>
					</select>
				</div>
			</div>
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
						<option value="PH">Penilaian Harian</option>
						<option value="PTS">Penilaian Tengah Semester</option>
						<option value="PAS">Penilaian Akhir Semester</option>
						<option value="UA">Ujian Akhir</option>
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
			<label for=""></label>
			<label for=""></label>
		</div>
	</form>
<?php }
if ($opsi == "df_jdwl") { ?>
	<table class="table table-striped table-hover table-bordered">
		<thead class="text-center">
			<th>No</th>
			<th>Hari, Tanggal</th>
			<th>Waktu</th>
			<th>Nama Kelas | Kelas | Jurusan</th>
			<th>Token</th>
			<th>Hapus</th>
		</thead>
		<tbody>
			<?php
			$query = "SELECT * FROM jdwl WHERE kd_soal = '$id' AND sts='Y' ORDER BY tgl_uji DESC";
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
						<td>
							<button class="btn btn-sm btn-danger m-1" id="delete" onclick="deleteJdwl(<?= htmlspecialchars($dtjd['id_ujian']); ?>,'<?= $dtjd['token']; ?>')">
								<i class="bi bi-trash"></i>
							</button>
						</td>
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

// Daftar Jawaban Siswa
if ($opsi == "sis_jwbn") {
	$token 	= $_POST['token'];
	$kds		= $_POST['kds'];

	$qr_ljk	= mysqli_query($koneksi, "SELECT * FROM cbt_ljk WHERE user_jawab ='$id' AND token ='$token' AND kd_soal ='$kds' ORDER BY cbt_ljk.urut ASC;");
	while ($data = mysqli_fetch_array($qr_ljk)) {
		$d_soal		= mysqli_fetch_array(mysqli_query($koneksi, "SELECT * From cbt_soal WHERE kd_soal='$kds' AND no_soal ='$data[no_soal]'"));
		($data['nil_pg'] == 1) ? $jwb = "benar2.png" : $jwb = "salah.png";

		$bnr = isset($bnr) ? $bnr : 0;       // Inisialisasi $bnr jika belum ada
		$salah = isset($salah) ? $salah : 0; // Inisialisasi $salah jika belum ada

		($data['nil_pg'] == 1) ? $bnr++ : $salah++;

		$data['jns_soal']=="G" ? $jawaban ='<img src="../img/'.$jwb.'" alt="" srcset="" width="45px">':$jawaban=$data['es_jwb'];

	?>
		<tr>
			<th style="width: 30px;text-align: center;"><?= $data['urut']; ?></th>
			<td style="width: auto;text-align: start; vertical-align: text-top;"><?= $d_soal['tanya']; ?></td>
			<td style="max-width: 50%;text-align: start; vertical-align: text-top;"><?= $jawaban; ?></td>
		</tr>
	<?php } ?>
	<tr class="fw-bold">
		<td colspan="2" class="text-end">Benar</td>
		<td><?= $bnr; ?></td>
	</tr>
	<tr class="fw-bold">
		<td colspan="2" class="text-end">Salah</td>
		<td><?= $salah; ?></td>
	</tr>

<?php
}
?>