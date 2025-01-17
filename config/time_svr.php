<?php
header('Content-Type: application/json');
echo json_encode(['server_time' => date('Y-m-d H:i:s')]);

// header('Content-Type: application/json');

// // Ambil waktu server dalam format ISO 8601
// $serverTime = gmdate('Y-m-d\TH:i:s\Z'); // UTC Time
// echo json_encode(['time' => $serverTime]);
