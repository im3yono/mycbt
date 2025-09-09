<?php

$pages = [
	"" 						=> "dsh_a.php",
	"dsh" 				=> "dashboard.php",
	"addsoal" 		=> "t_soal.php",
	"anls" 				=> "analisa.php",
	"dbup" 				=> "db/dbupdate.php",
	"df_uji" 			=> "daftar_uji.php",
	"dfps_uji" 		=> "df_ps_uji.php",
	"dfu_ps" 			=> "df_uji_peserta.php",
	"edtsoal" 		=> "e_soal.php",
	"esoal" 			=> "edt_soal.php",
	"f_soal" 			=> "file_soal.php",
	"id" 					=> "identitas.php",
	"imsoal" 			=> "db/impor_soal.php",
	"jmp" 				=> "jdwl_ujian.php",
	"kls" 				=> "kelas.php",
	"mpl" 				=> "mapel.php",
	"nilai" 			=> "nilai.php",
	"pr_brita" 		=> "berita.php",
	"pr_hadir" 		=> "d_hadir.php",
	"pr_kartu" 		=> "kartu.php",
	"priksa_esai" => "hasil/cek_esai.php",
	"puser" 			=> "p_user.php",
	"rst_uji" 		=> "reset_uji.php",
	"setting" 		=> "setting.php",
	"sis" 				=> "siswa.php",
	"soal" 				=> "soal.php",
	"sync" 				=> "sync.php",
	"synccl" 			=> "sync_cl.php",
	"uj_jdwl" 		=> "jdwl_ujian.php",
	"uj_rwyt" 		=> "riwayat.php",
	"uj_set" 			=> "set_ujian.php",
	"up_img" 			=> "media/up_img.php",
	"up_peserta" 	=> "db/up_peserta.php",
	"usr"					=> "user.php"
];

$page = $_REQUEST['md'] ?? "";
if (isset($pages[$page])) {
	if (empty($_REQUEST['md']) && (!isset($inf_set['thm']) || $inf_set['thm'] == 'df')) {
		include_once("dashboard.php");
	} else {
		include_once($pages[$page]);
	}
}
// elseif (($_REQUEST['md'])=="anls") {include_once("analisa.php");}



// === Alert (Pesan) === //
if (!empty($_REQUEST['pesan'])) {
	$messages = [
		"add" => ["Berhasil", "Data berhasil disimpan", "success"],
		"edit" => ["Berhasil", "Data berhasil dirubah", "success"],
		"gagal" => ["Gagal", "Proses Data Tidak Berhasil, Coba Lagi!", "error"]
	];

	if (isset($messages[$_REQUEST['pesan']])) {
		[$title, $text, $icon] = $messages[$_REQUEST['pesan']];
?>
		<script>
			Swal.fire('<?= $title ?>', '<?= $text ?>', '<?= $icon ?>');
		</script>
<?php
	}
}
// === Akhir Alert (Pesan) === //


?>