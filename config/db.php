<?php
require_once 'conf_db.php';
$server = "localhost:3306";
$userdb = "root";
$passdb = "29041994";
if (empty(end($rw_db))) {
  $db     = "mytbk";
} else {
  $db     = end($rw_db);
}
$code   = date("02/02/2020");
