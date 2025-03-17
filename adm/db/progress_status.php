<?php
session_start();
header('Content-Type: application/json');

$progress = isset($_SESSION['progress']) ? $_SESSION['progress'] : 0;
echo json_encode(["progress" => $progress]);
?>
