<?php 
require_once('../config/get_ip.php');
header('Content-Type: application/json');

$response = [
  // 'status' => 'success',
  'ip_address' => get_ip()
];

echo json_encode($response);
?>