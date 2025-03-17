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
<script src="node_modules/jquery/dist/jquery.min.js"></script>
<script>
    const token = "<?php echo $token; ?>";
    const kds = "<?php echo $kds; ?>";
    const userlg = "<?php echo $userlg; ?>";
</script>

<script>
	// Fungsi untuk memperbarui status koneksi di halaman
function updateStatus(isOnline) {
    if (isOnline = true) { // Periksa nilai boolean
        setCookie("connectionStatus", "online", 2); // Set cookie untuk status online
				// Berpindah ke halaman hanya jika online
				window.location = `on.php?info=on&tk=${token}&kds=${kds}&usr=${userlg}`;
    } else {
        setCookie("connectionStatus", "offline", 2); // Set cookie untuk status offline
    }
}

// Fungsi untuk membuat cookie
function setCookie(name, value, hours) {
    const date = new Date();
    date.setTime(date.getTime() + (hours * 60 * 60 * 1000));
    const expires = "expires=" + date.toUTCString();
    document.cookie = `${name}=${value};${expires};path=/`;
}

// Fungsi untuk memeriksa apakah klien terhubung ke internet publik
function checkInternetConnection() {
    fetch("https://www.google.com", {
        mode: 'no-cors',
    })
        .then(() => {
            updateStatus(true); // Jika fetch berhasil
        })
        .catch(() => {
            updateStatus(false); // Jika fetch gagal
        });
}

// Mendeteksi perubahan status koneksi
window.addEventListener("online", () => {
    checkInternetConnection(); // Periksa ulang saat status online terdeteksi
});

window.addEventListener("offline", () => {
    updateStatus(false); // Tetapkan status offline jika jaringan hilang
});

// Memeriksa koneksi saat halaman pertama kali dimuat
checkInternetConnection();

// Memeriksa koneksi secara berkala (opsional)
setInterval(checkInternetConnection, 7000); // Interval dalam milidetik (15 detik)

</script>