<?php
include_once('../config/server.php');

$token = $_POST['token'];
$kds   = $_POST['kds'];

// Ambil data jadwal
$dtjdwl = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM jdwl WHERE token='$token' AND kd_soal='$kds'"));

// Ambil nilai yang dibutuhkan
$tgl_uji = $dtjdwl['tgl_uji'];     // Format: YYYY-MM-DD
$jm_uji  = $dtjdwl['jm_uji'];      // Jam mulai ujian
$lm_uji  = $dtjdwl['lm_uji'];    // Durasi awal
$jm_tmbh = $dtjdwl['jm_tmbh'];     // Tambahan waktu (format: HH:MM:SS)

// Hanya proses jika ada waktu tambahan
if ($jm_tmbh != "00:00:00") {
  // Hitung waktu awal + durasi ujian
  $waktu_awal = tambahJam($jm_uji, $lm_uji);
  // Tambahkan waktu tambahan
  $waktu_akhir = tambahJam($waktu_awal, $jm_tmbh);

  // Gabungkan dengan tanggal untuk dikirim ke JS
  echo $tgl_uji . ' ' . $waktu_akhir; // Format: Y-m-d H:i:s
} else {
  echo '0';
}
