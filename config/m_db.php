<?php
require_once 'server.php';

if ($_GET['sm'] == "teskon") {
	$ip = $_POST["ip"] ?? "";
	$db = $_POST["db"] ?? "";

	$dsn = "mysql:host=$ip;dbname=$db;charset=utf8mb4";

	try {
		$pdo = new PDO($dsn, $user_sm, $pass_sm, [
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
		]);
		echo "<span class='badge fs-6 fw-normal bg-success-subtle' style='color:green;'>Koneksi berhasil!</span>";
	} catch (PDOException $e) {
		echo "Koneksi gagal <br><span style='color:red;'>" . $e->getMessage() . "</span>";
	}
} elseif ($_GET['sm'] == "modeSV") {
	include 'acc_mdb.php';
	// UPDATE svr SET lev_svr = 'C' WHERE svr.id_sv = 0;
	$cek = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM svr WHERE id_sv=0;"));
	// if ($_POST['mode'] == "C") {
	if ($cek['lev_svr'] == "C") {
		mysqli_query($koneksi, "UPDATE svr SET lev_svr = 'M' WHERE id_sv = 0;");
	} else {
		mysqli_query($koneksi, "UPDATE svr SET lev_svr = 'C' WHERE id_sv = 0;");
	}
} elseif ($_GET['sm'] == "savekon") {
	// UPDATE `svr` SET `ip_sv` = '192.168.100.1', `lev_svr` = 'M', `db_svr` = 'mytbk_v1-', `nm_sv` = 'Master_Server1', `fdr` = 'tbk1', `sync` = '1' WHERE `svr`.`id_sv` = 0;
	$ip = $_POST["ip"] ?? "";
	$db = $_POST["db"] ?? "";

	$qr = "UPDATE `svr` SET `ip_sv` = '$ip', `db_svr` = '$db' WHERE `svr`.`id_sv` = 0;";
	if (mysqli_query($koneksi, $qr)) {
		echo "<span style='color:green;'>Data berhasil disimpan!</span>";
	} else {
		echo "<span style='color:red;'>Data gagal disimpan!</span>";
	}
} elseif ($_GET['sm'] == "sync") {
	$ip = $_POST["ip"] ?? "";
	$db = $_POST["db"] ?? "";
	$idsv = $_POST["sv"] ?? "";


	$dsn = "mysql:host=$ip;dbname=$db;charset=utf8mb4";

	try {
		$pdo = new PDO($dsn, $user_sm, $pass_sm, [
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
		]);


		$url = $ip . '/' . $server_ms['fdr'] . '/api/my_ip.php';

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$json_data = curl_exec($ch);
		curl_close($ch);

		// Decode JSON ke array
		$response = json_decode($json_data, true);

		$my_ip = $response['ip_address'] ?? 0;
		// $my_ip = '192.168.100.175';

		
		// Query menggunakan PDO untuk keamanan tambahan
		$stmt = $pdo->prepare("SELECT * FROM `svr` WHERE idpt = :idsv AND ip_sv = :ip AND lev_svr = 'C' AND sts = 'Y'");
		$stmt->bindParam(":idsv", $idsv, PDO::PARAM_STR);
		$stmt->bindParam(":ip", $my_ip, PDO::PARAM_STR);
		$stmt->execute();

		if ($stmt->rowCount() > 0) {
			echo "?md=synccl"; // Redirect jika sukses
		} else {
			echo '<span class="alert alert-danger p-1" role="alert">IP Perangkat : ' . $my_ip . ' Tidak Memiliki Izin Akses</span>';
		}
	} catch (PDOException $e) {
		echo "Kesalahan <br><span style='color:red;'>" . $e->getMessage() . "</span>";
	}
}
