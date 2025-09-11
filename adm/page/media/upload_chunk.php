<?php
$fl_img = "../../../images";
$fl_aud = "../../../audio";
$fl_vid = "../../../video";

if (!is_dir($fl_img)) mkdir($fl_img, 0777, true);
if (!is_dir($fl_aud)) mkdir($fl_aud, 0777, true);
if (!is_dir($fl_vid)) mkdir($fl_vid, 0777, true);

// $fileName = preg_replace('/[^A-Za-z0-9\.\-_]/', '_', $_POST['name']);
$fileName = preg_replace('/[^A-Za-z0-9\.\-\_\s]/', '', $_POST['name']);

$chunk = (int)$_POST['chunk'];
$total = (int)$_POST['total'];

$ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
if (in_array($ext, ['png','jpg','jpeg'])) {
	$targetFolder = $fl_img;
} elseif (in_array($ext, ['mp3','wav','ogg'])) {
	$targetFolder = $fl_aud;
} elseif (in_array($ext, ['mp4','avi','mkv'])) {
	$targetFolder = $fl_vid;
} else {
	http_response_code(400);
	echo json_encode(["status" => "error", "msg" => "Ekstensi tidak didukung"]);
	exit;
}

$tmpName = $_FILES['file']['tmp_name'];
$destFile = $targetFolder . "/" . $fileName . ".part";

$in = fopen($tmpName, "rb");
$out = fopen($destFile, $chunk === 0 ? "wb" : "ab");
while ($buff = fread($in, 4096)) {
	fwrite($out, $buff);
}
fclose($in);
fclose($out);

if ($chunk + 1 === $total) {
	$finalPath = $targetFolder . "/" . $fileName;
	rename($destFile, $finalPath);
	echo json_encode(["status" => "done", "file" => $fileName, "folder" => basename($targetFolder)]);
} else {
	echo json_encode(["status" => "chunk", "chunk" => $chunk + 1]);
}
