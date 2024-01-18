<?php

include_once("../../config/server.php");

// UPDATE cbt_ljk SET nil_esai = '100' WHERE cbt_ljk.id = 6;
if ($_GET['act']=="nil") {
$nil = $_POST['nil'];
$usr = $_POST['usr'];
$kds = $_POST['kds'];
$nos = $_POST['nos'];

$sql =  "UPDATE cbt_ljk SET nil_esai = '$nil' WHERE user_jawab = '$usr' AND kd_soal='$kds' AND no_soal='$nos';";

if (mysqli_query($koneksi, $sql)) {
	echo "Data berhasil disimpan";
} else {
	echo "Error: " . $sql . "<br>" . $conn->error;
}
}

if ($_GET['act']=="prs") {
	
}