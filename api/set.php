<?php 
require_once('../config/conf_db.php');
header('Content-Type: application/json');

echo(empty(end($rw_db))) ? $db = "mytbk" : $db = end($rw_db);

// $response = [
//   // 'status' => 'success',
//   'acc' => $acc
// ];

// echo json_encode($response);
?>