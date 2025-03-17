<?php
include_once('../config/server.php');
header('Content-Type: application/json');

// Direktori gambar
$directory = '../images/';

// Ambil semua file gambar dari folder (hanya jpg, jpeg, png, gif, webp)
// $photos = glob($directory . '*.{jpg,jpeg,png,gif,webp,JPG,PNG,JPEG}', GLOB_BRACE);
$photos = glob($directory . '*', GLOB_BRACE);
$photos_count = !empty($photos) ? count($photos) : 0;

// Buat daftar gambar dengan nama file & URL
$image_list = [];
foreach ($photos as $photo) {
    $filename = basename($photo);
    $image_url = rawurlencode($filename); // Mengganti spasi dengan %20 dan karakter khusus lainnya

    // Membuat URL lengkap dengan domain dan folder yang sesuai
    $image_list[] = [
        'filename' => $filename,
        'url' => $server_ms['ip_sv'] . '/' . $server_ms['fdr'] . '/images/' . $image_url // Sesuaikan dengan domain/server
    ];
}

// Kirim respons dalam format JSON
$response = [
    'status' => 'success',
    'message' => 'Jumlah dan daftar gambar berhasil diambil',
    'total_images' => $photos_count,
    'images' => $image_list
];

echo json_encode($response, JSON_PRETTY_PRINT);
?>

