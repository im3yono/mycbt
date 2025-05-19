<?php
require_once 'conf_db.php';
require_once 'conf.php';

// local server
$server = "localhost:3306";
$userdb = "root";
$passdb = "29041994";

// local database select
(empty(end($rw_db))) ? $db = "mytbk" : $db = end($rw_db);