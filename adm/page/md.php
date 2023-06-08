<?php

if (isset($_REQUEST['md'])=="") {include_once("dashboard.php");}
elseif (($_REQUEST['md'])=="id") {include_once("identitas.php");}
elseif (($_REQUEST['md'])=="usr") {include_once("user.php");}
elseif (($_REQUEST['md'])=="kls") {include_once("kelas.php");}
elseif (($_REQUEST['md'])=="mpl") {include_once("mapel.php");}
elseif (($_REQUEST['md'])=="sis") {include_once("siswa.php");}
elseif (($_REQUEST['md'])=="soal") {include_once("soal.php");}
elseif (($_REQUEST['md'])=="f_soal") {include_once("file_soal.php");}
elseif (($_REQUEST['md'])=="pr_hadir") {include_once("d_hadir.php");}
elseif (($_REQUEST['md'])=="pr_kartu") {include_once("kartu.php");}
elseif (($_REQUEST['md'])=="pr_brita") {include_once("berita.php");}
elseif (($_REQUEST['md'])=="uj_set") {include_once("set_ujian.php");}
elseif (($_REQUEST['md'])=="uj_jdwl") {include_once("jdwl_ujian.php");}
elseif (($_REQUEST['md'])=="uj_rwyt") {include_once("riwayat.php");}
elseif (($_REQUEST['md'])=="df_uji") {include_once("daftar_uji.php");}
elseif (($_REQUEST['md'])=="rst_uji") {include_once("reset_uji.php");}
elseif (($_REQUEST['md'])=="nilai") {include_once("nilai.php");}
elseif (($_REQUEST['md'])=="rekap") {include_once("rekap.php");}
elseif (($_REQUEST['md'])=="anls") {include_once("analisa.php");}
// elseif (($_REQUEST['md'])=="anls") {include_once("analisa.php");}



// === Alert (Pesan) === //
if (isset($_REQUEST['pesan'])== ""){}
elseif ($_REQUEST['pesan'] == "add") {

?>
	<script>
		Swal.fire(
			'Berhasil',
			'Data berhasil disimpan',
			'success'
		)
	</script>
<?php
}
elseif ($_REQUEST['pesan'] == "edit") {

?>
	<script>
		Swal.fire(
			'Berhasil',
			'Data berhasil dirubah',
			'success'
		)
	</script>
<?php
}
elseif ($_REQUEST['pesan'] == "gagal") {

?>
	<script>
		Swal.fire(
			'Gagal',
			'Proses Data Tidak Berhasil, Coba Lagi!',
			'error'
		)
	</script>
<?php
}
// === Akhir Alert (Pesan) === //


?>