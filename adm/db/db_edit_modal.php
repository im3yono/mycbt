<?php
include_once("./../../config/server.php");
include_once("./../../config/time_date.php");

if (($_REQUEST['jdw']) == 'edit') {
	$kds			= $_POST['kds'];
	$mpel			= $_POST['kmpel'];
	$kkls			= $_POST['kkls'];
	$kls			= $_POST['kls'];
	$jur			= $_POST['jur'];
	$sesi			= $_POST['ses'];
	$tgl			= $_POST['tgl'];
	$jm_awal	= $_POST['jm_awal'];
	$jm_akhir	= $_POST['jm_akhir'];
	$durasi		= menitToJam($_POST['durasi'], '%02d:%02d:00');
	$telat		= menitToJam($_POST['telat'], '%02d:%02d:00');
	$token		= $_POST['token'];
	$ttoken		= $_POST['ttoken'];
	$nilai		= $_POST['nilai'];
	$md_uji		= $_POST['mode_uji'];
	$pl_media	= $_POST['pl_media'] ?? '0';
	$kd_ujian = $_POST['kdtes'];
	$author		= $_POST['author'];

	if (!empty($telat)) {
		$waktu_awal		= $jm_awal;
		$waktu_akhir	= $telat; // bisa juga waktu sekarang now()

		$awal  = strtotime(($waktu_awal));
		$akhir = strtotime(($waktu_akhir));
		// $awal  = strtotime("08:00:00");
		// $akhir = strtotime("02:00:00");
		$nol = strtotime("00:00:00");
		$diff  = ($awal - $nol) + ($akhir - $nol);

		$jam   = floor($diff / 3600);
		$menit = ($diff - ($jam * 3600)) / 60;
		$detik = $diff % 60;

		// $jmak  = floor(($akhir - $nol) / (60 * 60));
		// $minak = ($akhir - $nol) - ($jmak * (60 * 60));
		// $telat2 = ($jmak * 60) + floor($minak / 60);

		if ($jam < 10) {
			$jam = "0" . $jam;
		}
		if ($menit < 10) {
			$menit = "0" . $menit;
		}
		if ($detik < 10) {
			$detik = "0" . $detik;
		}
		$telat2 = $jam . ':' . $menit . ':' . $detik;
	} else {
		$telat2 = $jm_awal;
	}
	// echo $awal-$nol.', '.$akhir-$nol .'<br>';
	// echo $telat2 .'<br>';
	// echo $jam .'<br>';
	// echo $menit .'<br>';
	// echo $detik .'<br>';
	// echo $jam.':'.$menit.':'.$detik .'<br>';
	// echo $kds.'<br>'.$mpel.'<br>'.$kkls.'<br>'.$kls.'<br>'.$jur.'<br>'.$sesi.'<br>'.$tgl.'<br>'.$jm_awal.'<br>'.$durasi.'<br>'.$telat;
	// echo $telat2;
	$inqr	= "INSERT INTO jdwl (id_ujian, kd_ujian, smt, kls, kd_kls, jur, nm_kls, kd_mpel, kd_soal, jm_login, tgl_uji, jm_uji, slsai_uji, bts_login, lm_uji, token, author, thn_ajr, user, sesi, sts, sts_token, sts_nilai, md_uji, pl_m) VALUES (NULL, '$kd_ujian', '1', '$kls', '$kkls', '$jur', '', '$mpel', '$kds', '', '$tgl', '$jm_awal', '$jm_akhir', '$telat2', '$durasi', '$token', '$author', '$inf_ta', '$_COOKIE[user]', '$sesi', 'Y', '$ttoken', '$nilai', '$md_uji', '$pl_media');";

	$upqr	= "UPDATE jdwl SET kd_ujian = '$kd_ujian', kls = '$kls', kd_kls = '$kkls', jur = '$jur', nm_kls = '', kd_mpel = '$mpel', jm_login = '', tgl_uji = '$tgl', jm_uji = '$jm_awal',slsai_uji= '$jm_akhir', bts_login = '$telat2', lm_uji = '$durasi', author = '$author', thn_ajr = '$inf_ta', sesi = '$sesi', sts = 'Y', sts_token = '$ttoken', sts_nilai = '$nilai', md_uji ='$md_uji', pl_m ='$pl_media' WHERE jdwl.kd_soal = '$kds' AND jdwl.token = '$token';";

	$cek	= "SELECT * FROM jdwl WHERE kd_soal ='$kds' AND token = '$token'";

	if (empty(mysqli_num_rows(mysqli_query($koneksi, $cek)))) {
		if (mysqli_query($koneksi, $inqr)) { ?>
			<script>
				const Toast = Swal.mixin({
					toast: true,
					position: 'top-end',
					showConfirmButton: false,
					timer: 3000,
					timerProgressBar: true,
					didOpen: (toast) => {
						toast.addEventListener('mouseenter', Swal.stopTimer)
						toast.addEventListener('mouseleave', Swal.resumeTimer)
					}
				})

				Toast.fire({
					icon: 'success',
					title: 'Jadwal Berhasil disimpan'
				})
			</script>
		<?php
		}
	} else {
		if (mysqli_query($koneksi, $upqr)) { ?>
			<script>
				Swal.fire(
					'Berhasil',
					'Data berhasil dirubah',
					'success'
				).then((result) => {
					if (result.isConfirmed) {
						// Reload halaman setelah dialog ditutup
						location.reload();
					}
				});
			</script>

<?php
		}
	}
}

if (($_REQUEST['jdw']) == 'del') {
	if (isset($_POST['id']) && isset($_POST['token'])) {
		// Escape data untuk menghindari SQL Injection
		$id = mysqli_real_escape_string($koneksi, $_POST['id']);
		$token = mysqli_real_escape_string($koneksi, $_POST['token']);

		// Query untuk menghapus data dari tabel 'jdwl'
		$qr_jdwl = "DELETE FROM jdwl WHERE id_ujian = '$id'";
		if (mysqli_query($koneksi, $qr_jdwl)) {
			// Jika penghapusan dari 'jdwl' berhasil, lanjutkan ke 'peserta_tes'
			$qr_pstes = "DELETE FROM peserta_tes WHERE id_ujian = '$id' AND token= '$token'";
			if (!mysqli_query($koneksi, $qr_pstes)) {
				error_log("Error deleting peserta_tes: " . mysqli_error($koneksi));
			}

			// Query untuk menghapus data dari tabel 'cbt_ljk'
			$qr_token = "DELETE FROM cbt_ljk WHERE token = '$token'";
			if (!mysqli_query($koneksi, $qr_token)) {
				error_log("Error deleting cbt_ljk: " . mysqli_error($koneksi));
			}
		} else {
			error_log("Error deleting jdwl: " . mysqli_error($koneksi));
		}
	} else {
		error_log("Invalid request: Missing 'id' or 'token'");
	}
}
