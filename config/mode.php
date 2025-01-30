<?php 

// Perbaikan
$dibaiki ='DALAM PROSES PERBAIKAN';
// $dibaiki ='';
if (!empty($dibaiki)) {
	setcookie('user', 'admin', time() + 5400, "/");
	setcookie('pass', 'admin', time() + 5400, "/");	
}
?>