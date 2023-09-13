<?php 
// include_once("config/server.php");
// if (empty($_COOKIE['user'])) {
// 	header('location:/tbk/');
// } else {
// 	$userlg = $_COOKIE['user'];
// 	$token	= $_POST['kt'];
// 	$id		  = $_POST['id'];

// 	// echo $userlg." ".$token." ".$kds;
// }
// UPDATE cbt_ljk SET jwbn = 'A', nil_jwb = '1', nil_pg = '1', jam = CURRENT_TIME WHERE cbt_ljk.id = 108;
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["data"])) {
echo $_POST["data"];
}
?>