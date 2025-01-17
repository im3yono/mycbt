  // Fungsi untuk mengambil waktu server dari PHP
  async function fetchServerTime() {
    try {
      const response = await fetch('../config/time_svr.php');
      const data = await response.json();
      return new Date(data.serverTime);
    } catch (error) {
      console.error('Gagal mengambil waktu server:', error);
    }
  }

  // Fungsi untuk memperbarui waktu di halaman
  async function updateTime() {
    const serverDate = await fetchServerTime();

    if (serverDate) {
      const timeElement = document.getElementById('jam');

      // Update waktu setiap detik
      setInterval(() => {
        serverDate.setSeconds(serverDate.getSeconds() + 1);
        timeElement.textContent = serverDate.toLocaleTimeString();
      }, 1000);
    }
  }

  // Panggil fungsi saat halaman dimuat
  updateTime();