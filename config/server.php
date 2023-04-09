<?php 
include_once "db.php";

// koneksi
$koneksi = @$GLOBALS["___mysqli_ston"]= mysqli_connect($server,$user,$pass);
// pilih db
$db_select = mysqli_select_db($koneksi,$db);
?>