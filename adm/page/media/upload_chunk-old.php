<?php
$fl_vid = "../../../video";
if (!is_dir($fl_vid)) {
    mkdir($fl_vid, 0777, true);
}

$fileName = preg_replace('/[^A-Za-z0-9\.\-_]/', '_', $_POST['name']); // bersihkan nama
$chunk = (int)$_POST['chunk'];
$total = (int)$_POST['total'];

$tmpName = $_FILES['file']['tmp_name'];
$destFile = $fl_vid . "/" . $fileName . ".part";

// Simpan tiap chunk
$in = fopen($tmpName, "rb");
$out = fopen($destFile, $chunk === 0 ? "wb" : "ab"); // append
while ($buff = fread($in, 4096)) {
    fwrite($out, $buff);
}
fclose($in);
fclose($out);

// Kalau sudah semua, rename ke final
if ($chunk + 1 === $total) {
    rename($destFile, $fl_vid . "/" . $fileName);
    echo json_encode(["status" => "done", "file" => $fileName]);
} else {
    echo json_encode(["status" => "chunk", "chunk" => $chunk + 1]);
}
