<?php
require_once('../../config/server.php');

if ($_POST['pr'] == "add") {
	// UPDATE `svr` SET `sts` = 'N' WHERE `svr`.`id_sv` = 1;
	$id = $_POST['id'];
	$ck_dt = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM `svr` WHERE id_sv = '$id' "));
	if ($ck_dt['sts'] == "Y") {
		mysqli_query($koneksi, "UPDATE `svr` SET `sts` = 'N' WHERE `svr`.`id_sv` = '$id' ");
	} else {
		mysqli_query($koneksi, "UPDATE `svr` SET `sts` = 'Y' WHERE `svr`.`id_sv` = '$id' ");
	}
}
if ($_POST['pr'] == "save") {
	$idpt = $_POST['idSVC'];
	$nm_sv = $_POST['nmSVC'];
	$ip_sv = $_POST['ipSVC'];

	// INSERT INTO `svr` (`id_sv`, `idpt`, `ip_sv`, `lev_svr`, `db_svr`, `nm_sv`, `fdr`, `sync`, `upload`, `sts`) VALUES (NULL, '123', '192.168.100.172', 'C', '', 'Client_Server', '', '', '', 'Y');

	$ck_dt = mysqli_fetch_array(mysqli_query($koneksi,"SELECT * FROM `svr` WHERE idpt = '$idpt' "));
	if (!empty($ck_dt['idpt'])) {
	  mysqli_query($koneksi,"UPDATE `svr` SET `nm_sv` = '$nm_sv', `ip_sv` = '$ip_sv' WHERE `svr`.`idpt` = '$ck_dt[id_sv]' ");
	  echo "Data berhasil diubah.";
	} else {
	  mysqli_query($koneksi,"INSERT INTO `svr` (`id_sv`, lev_svr, `idpt`, `nm_sv`, `ip_sv`, `sts`) VALUES (NULL, 'C', '$idpt', '$nm_sv', '$ip_sv', 'N')");
	  echo "Data berhasil disimpan.";
	}
	// echo "Data berhasil disimpan.";
}

// Delete
if ($_POST['pr'] == "del") {
	$id = $_POST['id'];
	mysqli_query($koneksi, "DELETE FROM `svr` WHERE `svr`.`idpt` = '$id' ");
	echo "Data berhasil dihapus.";
}