<?php require_once 'server.php'; ?>

<script src="node_modules/jquery/dist/jquery.min.js"></script>


<!-- _____________________Deteksi Online_____________________ -->
<!-- http  -->
<script>
	const token = "<?= $token; ?>";
	const kds = "<?= $kds; ?>";
	const userlg = "<?= $userlg; ?>";

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

<!-- https -->
<!-- <script>
	const token = "<?= $token; ?>";
	const kds = "<?= $kds; ?>";
	const userlg = "<?= $userlg; ?>";

	// Fungsi untuk membuat cookie
	function setCookie(name, value, hours) {
		const date = new Date();
		date.setTime(date.getTime() + (hours * 60 * 60 * 1000));
		const expires = "expires=" + date.toUTCString();
		document.cookie = `${name}=${value};${expires};path=/`;
	}

	// Fungsi untuk memperbarui status koneksi di halaman
	function updateStatus(isOnline) {
		if (isOnline === true) {
			setCookie("connectionStatus", "online", 1);
			// Berpindah ke halaman hanya jika online
			window.location = `on.php?info=on&tk=${token}&kds=${kds}&usr=${userlg}`;
		} else {
			setCookie("connectionStatus", "offline", 1);
			// console.log('Offline - Tidak berpindah halaman.');
		}
	}

	// Fungsi untuk memverifikasi koneksi lewat ping ringan (fallback)
	function checkInternetConnection() {
		if (!navigator.onLine) {
			updateStatus(false); // Tidak perlu fetch jika jelas offline
			return;
		}

		// Verifikasi ulang koneksi internet via fetch
		fetch("https://www.google.com/generate_204", {
			method: 'GET',
			mode: 'no-cors',
		})
		.then(() => updateStatus(true))
		.catch(() => updateStatus(false));
	}

	// Cek awal saat halaman dimuat
	window.addEventListener("load", () => {
		checkInternetConnection();
	});

	// Mendeteksi perubahan status koneksi
	window.addEventListener("online", () => {
		console.log("Terdeteksi online");
		checkInternetConnection(); // Verifikasi ulang untuk memastikan
	});

	window.addEventListener("offline", () => {
		console.log("Terdeteksi offline");
		updateStatus(false);
	});

	// Opsional: periksa koneksi ulang setiap beberapa detik
	// setInterval(checkInternetConnection, 1500); // Setiap 1.5 detik
</script> -->

<!-- __________________Akhir Deteksi Online__________________ -->


<!-- _________________Deteksi Keluar Halaman_________________ -->
<script>
	let switchCount = 0;
	const maxSwitchAllowed = 3; // Ubah sesuai kebijakan

	// Fungsi ini dipicu saat tab tidak aktif
	document.addEventListener("visibilitychange", function() {
		if (document.hidden) {
			switchCount++;
			console.log("Perpindahan tab terdeteksi. Total:", switchCount);

			// Laporkan ke server
			fetch("config/logs/log_switch.php", {
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
				alert("Jangan tinggalkan halaman ujian!");
			}
		}
	});
</script>


<!-- __________________________Copas_________________________ -->
<script>
	document.addEventListener("contextmenu", e => e.preventDefault());    // Nonaktif klik kanan
	document.addEventListener("keydown", e => {
		if (e.ctrlKey && ["c", "x", "v", "u","s"].includes(e.key) ||
			e.key === "F12" || (e.ctrlKey && e.shiftKey && ["I", "J", "C"].includes(e.key))) {
			e.preventDefault();
		}
	});
	document.addEventListener("selectstart", e => e.preventDefault());
</script>