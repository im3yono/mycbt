<?php
require_once 'conf_db.php';
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
$code		= date("06/01/2026");
