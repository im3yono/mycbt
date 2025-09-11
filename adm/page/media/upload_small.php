<?php
$fl_img = "../../../images";
$fl_aud = "../../../audio";

if (!is_dir($fl_img)) mkdir($fl_img, 0777, true);
if (!is_dir($fl_aud)) mkdir($fl_aud, 0777, true);

$allowed_img = ['png','jpg','jpeg'];
$allowed_aud = ['mp3','wav','ogg'];

if (!empty($_FILES['file'])) {
    $nm = preg_replace('/[^A-Za-z0-9\.\-_]/', '_', $_FILES['file']['name']);
    $tmp = $_FILES['file']['tmp_name'];

    $ext = strtolower(pathinfo($nm, PATHINFO_EXTENSION));
    if (in_array($ext, $allowed_img)) {
        $folder = $fl_img;
    } elseif (in_array($ext, $allowed_aud)) {
        $folder = $fl_aud;
    } else {
        http_response_code(400);
        echo json_encode(["status" => "error", "msg" => "Format tidak didukung"]);
        exit;
    }

    move_uploaded_file($tmp, $folder . "/" . $nm);
    echo json_encode(["status" => "ok", "file" => $nm]);
}
