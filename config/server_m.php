<?php
require_once 'acc_mdb.php';
require_once 'server.php';


// // Status Server Master
// $server_ms		= mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM `svr` WHERE id_sv = 0 "));

// // Koneksi Server Master
// if (mysqli_connect($server_ms['ip_sv'], $user_sm, $pass_sm, $db)) {
// $sm_kon = mysqli_connect($server_ms['ip_sv'], $user_sm, $pass_sm, $db);
// }else{
// $sm_kon = 0;
// require_once 'acc_mdb.php';
// }




// function pingServer($ipsm)
// {
// 	$output = shell_exec("ping -c 1 -w 2 $ipsm");
// 	if (strpos($output, '1 received') !== false) {
// 		return 1;
// 	} else {
// 		return 0;
// 	}
// }


// Cek koneksi ke Server Master
$sm_kon = @mysqli_connect($server_ms['ip_sv'], $user_sm, $pass_sm, $server_ms['db_svr']);
