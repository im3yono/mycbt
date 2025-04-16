<?php
include_once("db.php");
include_once("get_ip.php");
include_once("time_date.php");
date_default_timezone_set('Asia/Makassar');
// echo date_default_timezone_get();

// koneksi
$koneksi = @($GLOBALS["___mysqli_ston"] = mysqli_connect($server, $userdb, $passdb));

// pilih db
try {
	$db_select = mysqli_select_db($koneksi, $db);
	$db_null = 0;
} catch (Exception $e) {
	// echo "Terjadi kesalahan koneksi database: " . $e->getMessage();
	$db_null 	= 1;
	$inf_fav 	= "fav.png";
	$inf_nm 	= "MyTBK";
}

if ($db_null != 1) {
	// cek data DB
	if (!empty($db_select)) {
		$inf		= mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM info"));
		$sv			= mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM svr WHERE id_sv ='$inf[id_sv]'"));
		$inf_id	= $inf["idpt"];
		$inf_nm	= $mem == null ? $inf["nmpt"] : $mem;
		$inf_almt	= $inf["almtpt"];
		$inf_kep	= $inf["nmkpt"];
		$inf_kpn	= $inf["nmpnpt"];
		$inf_fav	= $inf["fav"];
		$inf_lgdns	= $inf["lg_dinas"];
		$inf_ttdp		= $inf["ft_adm"];
		$inf_ttdk		= $inf["ft_sis"];
		$inf_head		= $inf["head"];
		$inf_head2	= $inf["head2"];
		$sv_ip	= $sv["ip_sv"];
		$sv_nm	= $sv["nm_sv"];
		$sv_fdr	= $sv["fdr"];
		// Tahun Ajaran
		if (date('m') <= 6) $inf_ta = date('Y') - 1 . '/' . date('Y');
		else $inf_ta = date('Y') . '/' . date('Y') + 1;
	}


	$fd_root	= $_SERVER['SCRIPT_NAME'];
	$fd_root	= explode('/', $fd_root);
	$fd_root	= $fd_root[1];


	// Status Server Master
	$server_ms		= mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM `svr` WHERE id_sv = 0 "));
}


