<?php
include_once('../config/server.php');

$ip       = $_POST['ip'] ?? '';
$message  = $_POST['message'] ?? '';
$warning  = $_POST['warning'] ?? 0;
$final    = $_POST['final'] ?? 0;

if ($final != 0):

// 	mysqli_query($koneksi, "
//     INSERT INTO log_pelanggaran (
//         ip_address,
//         message,
//         warning_count,
//         is_final,
//         created_at
//     ) VALUES (
//         '$ip',
//         '$message',
//         '$warning',
//         '$final',
//         NOW()
//     )
// ");
// UPDATE `peserta_tes` SET `sts` = 'N' WHERE `peserta_tes`.`id_tes` = 4;

endif;

echo json_encode([
	"success" => true
]);
