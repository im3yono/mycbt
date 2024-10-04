<?php require_once 'server.php';
// function save_on($kon, $usr, $tok, $kd)
// {
// 	// UPDATE peserta_tes SET dt_on = '1' WHERE peserta_tes.id_tes = 1;
// 	$sql = "UPDATE peserta_tes SET rq_rst = 'Y', dt_on = '1' WHERE user = '$usr' AND kd_soal = '$kd' AND token = '$tok'";
// 	if (mysqli_query($kon, $sql)) {
// 		// echo '<script>window.location="on.php?info=on"</script>';
// 	}
// 	// return 0;
// }
?>

<script>
	// Fungsi untuk memperbarui status koneksi di halaman
	function updateStatus(isOnline) {
		if (isOnline) {
			setCookie("connectionStatus", "online", 2); // Set cookie untuk status online
			window.location = "on.php?info=on&<?php echo'tk='.$token.'&kds='.$kds.'&usr='.$userlg ?>";
		}
	}

	// Fungsi untuk membuat cookie
	function setCookie(name, value, hours) {
		const date = new Date();
		date.setTime(date.getTime() + (hours * 60 * 60 * 1000));
		const expires = "expires=" + date.toUTCString();
		document.cookie = name + "=" + value + ";" + expires + ";path=/";
	}

	// Fungsi untuk memeriksa apakah klien terhubung ke internet publik
	function checkInternetConnection() {
		fetch("https://www.google.com", {
				mode: 'no-cors'
			})
			.then(() => {
				updateStatus(true);
			})
			.catch(() => {
				updateStatus(false);
			});
	}

	// Mendeteksi perubahan status koneksi
	window.addEventListener('online', () => {
		checkInternetConnection();
		updateStatus(true);
	});

	window.addEventListener('offline', () => {
		updateStatus(false);
	});

	// Memeriksa koneksi saat halaman pertama kali dimuat
	checkInternetConnection();

	// Memeriksa koneksi secara berkala (opsional)
	setInterval(checkInternetConnection(), 5000);
</script>