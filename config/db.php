<?php
require_once 'conf_db.php';
// if (!file_exists('conf.php') && !file_exists('key.php')) {
	require_once 'conf.php';
// } else {
// 	die('The required file conf.php does not exist.');
// }
// local server
$server = "localhost:3306";
$userdb = "root";
$passdb = "29041994";

// local database select
(empty(end($rw_db))) ? $db = "mytbk" : $db = end($rw_db);

// Server Master
$user_sm = "mytbk";
$pass_sm = "admintbk";
