<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$ok = 0;

	// Kelas
	if (isset($_POST["kls"])) {
		# code...TRUNCATE TABLE mytbk_asli.kelas
		$qsql = "TRUNCATE TABLE kelas";
		if (mysqli_query($koneksi, $qsql)) {
			$ok = 1;
		}
	}

	// Mata Pelajaran
	if (isset($_POST["mpel"])) {
		$qsql = "TRUNCATE TABLE mapel";
		if (mysqli_query($koneksi, $qsql)) {
			$ok = 1;
		}
	}

	// Jadwal Ujian
	if (isset($_POST["jdwl"]) || isset($_POST["mpel"])) {
		$qsql = "TRUNCATE TABLE jdwl";
		if (mysqli_query($koneksi, $qsql)) {
			$ok = 1;
		}
	}

	// Siswa
	if (isset($_POST["sis"]) || isset($_POST["kls"])) {
		# code...TRUNCATE TABLE mytbk1.cbt_peserta
		$qsql = "TRUNCATE TABLE cbt_peserta";
		if (mysqli_query($koneksi, $qsql)) {
			$ok = 1;
			$files    = glob('../pic_sis/*');
			foreach ($files as $file) {
				if (is_file($file)) {
					unlink($file); // hapus file
					$ok = 1;
				}
			}
		}
	}

	// Peserta Ujian
	if (isset($_POST["uji"]) || isset($_POST["sis"]) || isset($_POST["kls"]) || isset($_POST["jdwl"])) {
		$qsql = "TRUNCATE TABLE peserta_tes";
		if (mysqli_query($koneksi, $qsql)) {
			$ok = 1;
		}
	}

	// Lembar Jawaban
	if (isset($_POST["ljk"]) || isset($_POST["sis"]) || isset($_POST["kls"]) || isset($_POST["jdwl"]) || isset($_POST["uji"])) {
		$qsql = "TRUNCATE TABLE cbt_ljk";
		if (mysqli_query($koneksi, $qsql)) {
			$ok = 1;
		}
	}

	// Nilai
	if (isset($_POST["nil"]) || isset($_POST["sis"]) || isset($_POST["kls"])) {
		$qsql = "TRUNCATE TABLE nilai";
		if (mysqli_query($koneksi, $qsql)) {
			$ok = 1;
		}
	}

	// Paket Soal
	if (isset($_POST["pkt"]) || isset($_POST["mpel"])) {
		$qsql = "TRUNCATE TABLE cbt_pktsoal";
		if (mysqli_multi_query($koneksi, $qsql)) {
			$ok = 1;
		}
	}

	// Soal
	if (isset($_POST["soal"]) || isset($_POST["pkt"]) || isset($_POST["mpel"])) {
		$qsql = "TRUNCATE TABLE cbt_soal";
		if (mysqli_query($koneksi, $qsql)) {
			$ok = 1;
		}
	}

	// File Pendukung
	if (isset($_POST["file"]) || isset($_POST["soal"]) || isset($_POST["pkt"]) || isset($_POST["mpel"])) {
		$files    = glob('../images/*');
		foreach ($files as $file) {
			if (is_file($file)) {
				unlink($file); // hapus file
				$ok = 1;
			}
		}
	}

	// Refresh
	if ($ok == 1) {
		echo '<meta http-equiv="refresh" content="0;url=./?md=setting">';
	}
}
