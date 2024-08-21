<?php

function is_connected(){
	$connected = @fsockopen("www.google.com", 80);
	//website, port  (try 80 or 443)
	if ($connected) {
		$is_conn = true; //action when connected
		fclose($connected);
	} else {
		$is_conn = false; //action in connection failure
	}
	return $is_conn;
}


// 		// =============== CEK STATUS INTERNET =============== //
// if (is_connected() == true) {
// 	// echo "terhubung internet";
// 	if ($_REQUEST['info']!="on") {
// 	echo '<script>window.location="on.php?info=on"</script>';
// 	}
	
// // } else {
// 	// echo "tidak ada internet";
// }

function get_ip(){
	$ipaddress = '';
	if (isset($_SERVER['HTTP_CLIENT_IP']))
		$ipaddress = $_SERVER['HTTP_CLIENT_IP'];
	else if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
		$ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
	else if (isset($_SERVER['HTTP_X_FORWARDED']))
		$ipaddress = $_SERVER['HTTP_X_FORWARDED'];
	else if (isset($_SERVER['HTTP_FORWARDED_FOR']))
		$ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
	else if (isset($_SERVER['HTTP_FORWARDED']))
		$ipaddress = $_SERVER['HTTP_FORWARDED'];
	else if (isset($_SERVER['REMOTE_ADDR']))
		$ipaddress = $_SERVER['REMOTE_ADDR'];
	else
		$ipaddress = 'IP tidak dikenali';
	return $ipaddress;
}
// echo get_ip();
?>
<!-- <script>
	setInterval(checkInternetConnection, 5000);
</script> -->