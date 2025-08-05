<?php
include_once('../config/server.php');

// $kds = $_POST['kds'];
// $usr = $_POST['usr'];
// $token = $_POST['tkn'];
 // Simulasi notifikasi untuk menghindari error
if ($_POST['notf'] == 'ok') {
mysqli_query($koneksi, "UPDATE psn SET psn = '', tgl = CURRENT_DATE, jam = CURRENT_TIME WHERE ke = '$_POST[usr]'");
}

if ($_POST['notf'] == 'intel') {
  $cht = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM psn WHERE ke = '$_POST[usr]'"));
  echo $cht['psn'];
  // echo "berhasil";
}