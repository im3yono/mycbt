<?php
include_once ("db.php");
include_once ("get_ip.php");
date_default_timezone_set('Asia/Makassar');
// echo date_default_timezone_get();

// koneksi
$koneksi = @$GLOBALS["___mysqli_ston"] = mysqli_connect($server, $userdb, $passdb);
// pilih db
$db_select = mysqli_select_db($koneksi, $db);
// cek data DB
if (!empty($db_select)) {
  $inf   = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM info"));
  $sv   = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM svr WHERE id_sv ='$inf[id_sv]'"));
  $inf_id   = $inf["idpt"];
  $inf_nm   = $inf["nmpt"];
  $inf_almt   = $inf["almtpt"];
  $inf_kep   = $inf["nmkpt"];
  $inf_kpn   = $inf["nmpnpt"];
  $inf_fav   = $inf["fav"];
  $inf_lgdns   = $inf["lg_dinas"];
  $inf_ftadm   = $inf["ft_adm"];
  $inf_ftsis   = $inf["ft_sis"];
  $inf_head   = $inf["head"];
  $inf_head2   = $inf["head2"];
  
  $sv_ip	= $sv["ip_sv"];
  $sv_nm	= $sv["nm_sv"];
  $sv_fdr	= $sv["fdr"];
}
