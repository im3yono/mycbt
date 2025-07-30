<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
document.addEventListener('DOMContentLoaded', function () {
  const pages = {
    "": "dashboard.php",
    "addsoal": "t_soal.php",
    "anls": "analisa.php",
    "dbup": "db/dbupdate.php",
    "df_uji": "daftar_uji.php",
    "dfps_uji": "df_ps_uji.php",
    "dfu_ps": "df_uji_peserta.php",
    "edtsoal": "e_soal.php",
    "esoal": "edt_soal.php",
    "f_soal": "file_soal.php",
    "id": "identitas.php",
    "imsoal": "db/impor_soal.php",
    "jmp": "jdwl_ujian.php",
    "kls": "kelas.php",
    "mpl": "mapel.php",
    "nilai": "nilai.php",
    "pr_brita": "berita.php",
    "pr_hadir": "d_hadir.php",
    "pr_kartu": "kartu.php",
    "priksa_esai": "hasil/cek_esai.php",
    "puser": "p_user.php",
    "rst_uji": "reset_uji.php",
    "setting": "setting.php",
    "sis": "siswa.php",
    "soal": "soal.php",
    "sync": "sync.php",
    "synccl": "sync_cl.php",
    "uj_jdwl": "jdwl_ujian.php",
    "uj_rwyt": "riwayat.php",
    "uj_set": "set_ujian.php",
    "up_img": "media/up_img.php",
    "up_peserta": "db/up_peserta.php",
    "usr": "user.php",
    "dsh": "dashboard-n.php"
  };

  const messages = {
    "add": ["Berhasil", "Data berhasil disimpan", "success"],
    "edit": ["Berhasil", "Data berhasil dirubah", "success"],
    "gagal": ["Gagal", "Proses Data Tidak Berhasil, Coba Lagi!", "error"]
  };

  // Ambil parameter dari URL
  const params = new URLSearchParams(window.location.search);
  const pageKey = params.get("md") || "";
  const pesanKey = params.get("pesan");

  // Load konten dinamis
  const warper = document.getElementById("warper");
  if (pages.hasOwnProperty(pageKey)) {
    fetch(`page/${pages[pageKey]}`)
      .then(response => {
        if (!response.ok) throw new Error("Gagal memuat halaman");
        return response.text();
      })
      .then(html => {
        warper.innerHTML = html;
      })
      .catch(err => {
        warper.innerHTML = `<div class="error">Gagal memuat halaman: ${err.message}</div>`;
      });
  }

  // Tampilkan alert jika ada pesan
  if (pesanKey && messages.hasOwnProperty(pesanKey)) {
    const [title, text, icon] = messages[pesanKey];
    Swal.fire(title, text, icon);
  }
});
