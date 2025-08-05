<?php
require_once('../config/server.php');

if ($db_null == 1 || $tbl_null == 1) {
	include_once('df.php');
} else {
	if ($inf_set['thm'] == "alte") {
		include_once('alte.php');
	} else {
		include_once('df.php');
	}
}

if ($_COOKIE['pass'] == 'admin' && $inf_set['pass'] == "on") { ?>
	<style>
		.custom-alert {
			position: fixed;
			top: 50px;
			left: 50%;
			transform: translateX(-50%);
			background-color: #ff4d4d;
			color: white;
			padding: 16px 24px;
			border-radius: 8px;
			box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
			font-family: sans-serif;
			font-size: 16px;
			z-index: 9999;
			animation: fadeInOut 5s forwards;
		}

		@keyframes fadeInOut {
			0% {
				opacity: 0;
				top: 0;
			}

			10% {
				opacity: 1;
				top: 50px;
			}

			90% {
				opacity: 1;
				top: 50px;
			}

			100% {
				opacity: 0;
				top: 0;
			}
		}
	</style>
	<div id="alertBox" class="custom-alert" style="display: none;">
		Password <strong>'admin'</strong> terlalu mudah ditebak. Silakan ganti password Anda.
	</div>

	<script>
		window.onload = function() {
			const alertBox = document.getElementById("alertBox");
			alertBox.style.display = "block";

			// Hapus setelah selesai animasi (7 detik)
			setTimeout(() => {
				alertBox.style.display = "none";
			}, 7000);
		};
	</script>
<?php
}


?>
<script src="../config/lib/funct.js"></script>

<!-- Backdrop tidak ada aktivitas -->
<?php if ($inf_set['ad_notif'] == "on"): ?>
	<script>
		let timeout;
		let logoutTimeout;
		let alertShown = false; // Pastikan hanya muncul sekali dalam satu periode tidak aktif
		var st = 5; // Waktu diam satuan Menit
		var tm = 15; // Waktu logout satuan Menit

		function showAlert() {
			if (!alertShown) {
				alertShown = true;
				Swal.fire({
					title: "Apakah Anda masih di sana?",
					icon: "info",
					html: "Anda akan logout otomatis dalam <b></b>.",
					timer: tm * 60 * 1000 + 100,
					timerProgressBar: true,
					didOpen: () => {
						const timer = Swal.getPopup().querySelector("b");
						let interval = setInterval(() => {
							const swalTimer = Swal.getTimerLeft();
							if (timer && swalTimer !== undefined) {
								let totalSeconds = Math.floor(swalTimer / 1000);
								let hours = Math.floor(totalSeconds / 3600);
								let minutes = Math.floor((totalSeconds % 3600) / 60);
								let seconds = totalSeconds % 60;
								let timeStr =
									(hours > 0 ? String(hours).padStart(2, '0') + ":" : "") +
									String(minutes).padStart(2, '0') + ":" +
									String(seconds).padStart(2, '0');
								timer.textContent = timeStr;
							}
						}, 100);
						Swal.getPopup().addEventListener('close', () => clearInterval(interval));
					},
					allowOutsideClick: false,
					allowEscapeKey: false,
					backdrop: 'rgba(0, 0, 0, 0.9)',
				}).then(() => {
					// Setelah ditutup, mulai deteksi interaksi lagi
					alertShown = false;
					resetTimer();
					clearTimeout(logoutTimeout);
				});
				// Set logout otomatis 10 menit setelah alert muncul
				logoutTimeout = setTimeout(function() {
					window.location = ('../logout.php?fld=<?php echo $fd_root; ?>');
				}, tm * 60 * 1000);
			}
		}

		function resetTimer() {
			clearTimeout(timeout);
			clearTimeout(logoutTimeout);
			timeout = setTimeout(showAlert, st * 60 * 1000); // 7 menit tanpa interaksi
		}

		document.addEventListener("mousemove", resetTimer);
		document.addEventListener("keydown", resetTimer);
		document.addEventListener("click", resetTimer);

		resetTimer(); // Mulai deteksi saat halaman dimuat
	</script>
<?php endif; ?>