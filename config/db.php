<?php
require_once 'conf_db.php';
// if (!file_exists('conf.php') && !file_exists('key.php')) {
	require_once 'conf.php';
// } else {
// 	die('The required file conf.php does not exist.');
// }
$server = "localhost:3306";
$userdb = "root";
$passdb = "29041994";

// Server Master
$user_sm = "mytbk";
$pass_sm = "admintbk";

if (empty(end($rw_db))) {
	$db		= "mytbk";
} else {
	$db		= end($rw_db);
}
