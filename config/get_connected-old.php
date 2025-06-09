<?php require_once 'server.php'; ?>

<script src="node_modules/jquery/dist/jquery.min.js"></script>

<!-- Deteksi Online -->
<script>
	const token = "<?php echo $token; ?>";
	const kds = "<?php echo $kds; ?>";
	const userlg = "<?php echo $userlg; ?>";

	// Fungsi untuk membuat cookie
	function setCookie(name, value, hours) {
		const date = new Date();
		date.setTime(date.getTime() + (hours * 60 * 60 * 1000));
		const expires = "expires=" + date.toUTCString();
		document.cookie = `${name}=${value};${expires};path=/`;
	}
	// Fungsi untuk memperbarui status koneksi di halaman
	function updateStatus(isOnline) {
		if (isOnline == true) { // Periksa nilai boolean
			setCookie("connectionStatus", "online", 1); // Set cookie untuk status online
			// Berpindah ke halaman hanya jika online
			window.location = `on.php?info=on&tk=${token}&kds=${kds}&usr=${userlg}`;
		} else {
			setCookie("connectionStatus", "offline", 1); // Set cookie untuk status offline
		}
	}

	// Fungsi untuk memeriksa apakah klien terhubung ke internet publik
	function checkInternetConnection() {
		fetch("https://google.com", {
				mode: 'no-cors',
			})
			.then(() => {
				updateStatus(true); // Jika fetch berhasil
			})
			.catch(() => {
				updateStatus(false); // Jika fetch gagal
				console.log('offline');
			});
	}

	// Mendeteksi perubahan status koneksi
	window.addEventListener("online", () => {
		checkInternetConnection(); // Periksa ulang saat status online terdeteksi
		// updateStatus(true);
	});

	window.addEventListener("offline", () => {
		updateStatus(false); // Tetapkan status offline jika jaringan hilang
	});

	// Memeriksa koneksi saat halaman pertama kali dimuat
	checkInternetConnection();

	// Memeriksa koneksi secara berkala (opsional)
	setInterval(checkInternetConnection, 1500); // Interval dalam milidetik (15 detik)
</script>


<!-- Deteksi Meninggalkan Aplikasi Pindah Tab/Window -->
<script>
	let switchCount = 0;
	const maxSwitchAllowed = 3; // Ubah sesuai kebijakan

	// Fungsi ini dipicu saat tab tidak aktif
	document.addEventListener("visibilitychange", function() {
		if (document.hidden) {
			switchCount++;
			console.log("Perpindahan tab terdeteksi. Total:", switchCount);

			// Laporkan ke server
			fetch("logs/log_switch.php", {
				method: "POST",
				headers: {
					"Content-Type": "application/json"
				},
				body: JSON.stringify({
					switchCount: switchCount,
					data: {
						token: token,
						kds: kds,
						user: userlg
					},
					timestamp: new Date().toISOString()
				})
			});

			if (switchCount >= maxSwitchAllowed) {
				// alert("Kamu telah meninggalkan halaman terlalu sering. Ujian dibatalkan.");
				// Arahkan ke halaman pembatalan atau kirim otomatis jawaban
				// window.location.href = "batal_ujian.php";
				alert("Ujian akan dibatalkan jika kamu meninggalkan halaman lagi.");
			}
		}
	});
</script>