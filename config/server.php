<?php 
include_once "db.php";

// koneksi
$koneksi = @$GLOBALS["___mysqli_ston"]= mysqli_connect($server,$user,$pass);
// pilih db
$db_select = mysqli_select_db($koneksi,$db);
// cek data DB
if (!empty($db_select)) {
  $inf   = mysqli_fetch_array(mysqli_query($koneksi,"SELECT * FROM info"));
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
//   $sckep   = $inf["kep"];
//   $sckepf   = $inf["ftk"];
//   $scno   = $inf["notlp"];
//   $scem   = $inf["email"];
//   $scsbt   = $inf["smbtn"];
//   $scsej   = $inf["sej"];
//   $scvis   = $inf["visimisi"];
}
?>