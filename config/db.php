<?php
require_once 'conf_db.php';
require_once 'conf.php';
require_once "db_acc.php";

// local server
$server = "localhost:3306";
$userdb = $usdb;
$passdb = $psdb;

// Server Master
// $user_sm = "mytbk";
// $pass_sm = "admintbk";

// local database select
(empty(end($rw_db))) ? $db = "mytbk" : $db = end($rw_db);

// table database
$dbtbl = array('brt', 'cbt_ljk', 'cbt_peserta', 'cbt_pktsoal', 'cbt_soal', 'info', 'jdwl', 'kelas', 'mapel', 'nilai', 'peserta_tes', 'psn', 'qr_lg', 'svr', 'user');
