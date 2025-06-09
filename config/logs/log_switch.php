<?php
require_once "../../config/server.php";

$data = json_decode(file_get_contents("php://input"), true);

//  Update status ke database
//  UPDATE `peserta_tes` SET `dt_out` = '1' WHERE `peserta_tes`.`id_tes` = 3;
$stmt = $koneksi->prepare("UPDATE peserta_tes SET dt_out = ? WHERE user = ? AND kd_soal = ? AND token = ?");
$stmt->bind_param(
	"isss",
	$data['switchCount'],
	$data['data']['user'], 
	$data['data']['kds'],
	$data['data']['token']
);
$stmt->execute();
$stmt->close();

// Update status tab
$log = sprintf(
	"[%s] - Tab/app ke-%d user: %s, kds: %s, token: %s \n",
	$data['timestamp'],
	$data['switchCount'],
	$data['data']['token'],
	$data['data']['kds'],
	$data['data']['user']
);

file_put_contents("switch_log.txt", $log, FILE_APPEND);
