<?php
include_once('../config/server.php');

// $kds = $_POST['kds'];
// $usr = $_POST['usr'];
// $token = $_POST['tkn'];

mysqli_query($koneksi, "UPDATE psn SET psn = '', tgl = CURRENT_DATE, jam = CURRENT_TIME WHERE ke = '$_POST[usr]'");
