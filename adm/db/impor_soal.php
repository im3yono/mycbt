<?php
include_once("../config/server.php");
require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

if (isset($_POST['import'])) {
	$file_mimes = array('application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	$kds = $_GET['kds'];
	$kmpl = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM cbt_pktsoal WHERE kd_soal = '$kds' GROUP BY kd_soal;"));
	$err = 0;

	if (isset($_FILES['berkas_excel']['name']) && in_array($_FILES['berkas_excel']['type'], $file_mimes)) {

		$arr_file = explode('.', $_FILES['berkas_excel']['name']);
		$extension = end($arr_file);

		if ('csv' == $extension) {
			$reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
		} else {
			$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
		}
		$reader->setLoadSheetsOnly("DataSoal");
		$spreadsheet = $reader->load($_FILES['berkas_excel']['tmp_name']);

		$sheetData = $spreadsheet->getActiveSheet()->toArray();
		for ($i = 2; $i < count($sheetData); $i++) {
			$nos		= $sheetData[$i]['0'];
			$jns		= $sheetData[$i]['1'];
			$ktg		= $sheetData[$i]['2'];
			$asoal	= $sheetData[$i]['3'];
			$aopsi	= $sheetData[$i]['4'];
			$des		= $sheetData[$i]['5'];
			$tanya	= $sheetData[$i]['6'];
			$timg		= $sheetData[$i]['7'];
			$taud		= $sheetData[$i]['8'];
			$tvid		= $sheetData[$i]['9'];
			$opsi1	= $sheetData[$i]['10'];
			$opsi2	= $sheetData[$i]['11'];
			$opsi3	= $sheetData[$i]['12'];
			$opsi4	= $sheetData[$i]['13'];
			$opsi5	= $sheetData[$i]['14'];
			$opimg1	= $sheetData[$i]['15'];
			$opimg2	= $sheetData[$i]['16'];
			$opimg3	= $sheetData[$i]['17'];
			$opimg4	= $sheetData[$i]['18'];
			$opimg5	= $sheetData[$i]['19'];
			$key		= $sheetData[$i]['20'];

			if (strlen($des) <= 3) {
				$kd_crt = $des;
			} else {
				$kd_crt = null;
			}
			if (empty($asoal)) {
				$asoal = "Y";
			}
			if (empty($aopsi)) {
				$aopsi = "Y";
			}
			$ckno = mysqli_query($koneksi, "SELECT * FROM cbt_soal WHERE no_soal ='$nos' AND kd_soal ='$kds';");

			// INSERT INTO cbt_soal (id_soal, kd_soal, kd_mapel, jns_soal, lev_soal, no_soal, cerita, kd_crta, tanya, img, audio, vid, jwb1, jwb2, jwb3, jwb4, jwb5, img1, img2, img3, img4, img5, knci_pilgan, ack_soal, ack_opsi) VALUES (NULL, 'XM_NTK', 'MTK', 'G', '1', '$nos', 'Soal Uji coba bentuk Cerita', '1', 'Pertanyaan nomor 2/Soal<br>di beri Br', 'i', 'a', 'v', 'Jawab A', 'Jawab B', 'Jawab C', 'Jawab D', 'Jawab E', 'i1', 'i2', 'i3', 'i4', 'i5', '1', 'Y', 'Y');

			// UPDATE cbt_soal SET kd_soal = '', kd_mapel = 'PPKn', jns_soal = 'E', lev_soal = '2', no_soal = '3', cerita = 'Soal 2 Uji coba bentuk Cerita', tanya = 'Pertanyaan nomor 3/Soal<br>di beri Br', img = 'ia', audio = 'aa', vid = 'va', jwb1 = 'Jawab Aa', jwb2 = 'Jawab Ba', jwb3 = 'Jawab Ca', jwb4 = 'Jawab Da', jwb5 = 'Jawab Ea', img1 = 'i1a', img2 = 'i2a', img3 = 'i3a', img4 = 'i4aa', img5 = 'i5a', knci_pilgan = '2', ack_soal = 'N', ack_opsi = 'N' WHERE cbt_soal.id_soal = 2;
			// mysqli_query($koneksi, "insert into mahasiswa (id,nim,nama,ipk,jurusan) values ('','$nim','$nama','$ipk','$jurusan')");
			if (($jns == "G" || "E") && ($ktg == 1 || 2 || 3) && (!empty($key))) {
				if (!empty(mysqli_num_rows($ckno))) {
					mysqli_query($koneksi, "UPDATE cbt_soal SET kd_soal = '$kds', kd_mapel = '$kmpl[kd_mpel]', jns_soal = '$jns', lev_soal = '$ktg', cerita = '$des', tanya = '$tanya', img = '$timg', audio = '$taud', vid = '$tvid', jwb1 = '$opsi1', jwb2 = '$opsi2', jwb3 = '$opsi3', jwb4 = '$opsi4', jwb5 = '$opsi5', img1 = '$opimg1', img2 = '$opimg2', img3 = '$opimg3', img4 = '$opimg4', img5 = '$opimg5', knci_pilgan = '$key', ack_soal = '$asoal', ack_opsi = '$aopsi' WHERE cbt_soal.no_soal = '$nos';");
				} else {
					mysqli_query($koneksi, "INSERT INTO cbt_soal (id_soal, kd_soal, kd_mapel, jns_soal, lev_soal, no_soal, cerita, kd_crta, tanya, img, audio, vid, jwb1, jwb2, jwb3, jwb4, jwb5, img1, img2, img3, img4, img5, knci_pilgan, ack_soal, ack_opsi) VALUES (NULL, '$kds', '$kmpl[kd_mpel]', '$jns', '$ktg', '$nos', '$des', '$kd_crt', '$tanya', '$timg', '$taud', '$tvid', '$opsi1', '$opsi2', '$opsi3', '$opsi4', '$opsi5', '$opimg1', '$opimg2', '$opimg3', '$opimg4', '$opimg5', '$key', '$asoal', '$aopsi');");
				}
			} else {
				$err++;
			}
		}
		//header("Location: form_upload.html"); 
		// echo "Soal Tidak Falid : " . $ss;
		echo "<br>Soal Tidak Falid : " . $err++;
		echo "<br><b style='color :red;'>Data berhasil di upload!</b>";
		echo '<meta http-equiv="refresh" content="3;url=./?md=soal&pesan=add">';
	}
}
?>





<form method="post" enctype="multipart/form-data" action="">
	<div class="form-group">
		<label for="exampleInputFile">File Upload</label>
		<input type="file" name="berkas_excel" class="form-control" id="exampleInputFile">
	</div>
	<input type="submit" class="btn btn-primary" value="Import" name="import" />
</form>