<?php
include_once("../config/server.php");

$kds	= $_GET['kds'];
$dt = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM cbt_pktsoal WHERE cbt_pktsoal.kd_soal ='$kds'"));
?>

<div class="container-fluid mb-5 p-0">

	<div class="row p-2 border-bottom fs-3 mb-4 shadow-sm "> <div class="col-auto "><a href="?md=esoal&ds=<?php echo $dt[0]; ?>" class="btn btn-outline-dark"><i class="bi bi-arrow-left"></i> Kembali</a></div> Upload File soal</div>
	<div class="row m-4 border-success border shadow" style="border-radius: 5px;">
		<div class="col-12 bg-success p-1 text-white fs-5 shadow-sm">Download File Excel (Template Soal)</div>
		<div class="col-auto">
			<img src="../img/Ms_Excel.png" alt="" srcset="" style="max-width: 200px;" class="">
		</div>
		<div class="col p-3">
			<div class="row g-2">
				<div class="col-12">
					<p>
						Silahkan Klik tombol template dibawah, untuk download file excel template soal sesuai dengan pilihannya.
						Jangan ada inputan apapun setelah nomer terakhir.
						Karena akan dibaca dan diacak oleh sistem.</p>
				</div>
				<div class="col-12"><a href="../File/F_Soal.xlsx" class="btn btn-primary">Download Template Soal</a></div>
			</div>
		</div>
	</div>
	<div class="row border border-dark"></div>

	<?php
	include_once("../config/server.php");
	require '../vendor/autoload.php';

	use PhpOffice\PhpSpreadsheet\Spreadsheet;
	use PhpOffice\PhpSpreadsheet\Reader\xls;
	use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
	use PhpOffice\PhpSpreadsheet\Worksheet\Row;

	if (isset($_POST['import'])) {
		$file_mimes = array('application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		$kds = $_GET['kds'];
		$kmpl = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM cbt_pktsoal WHERE kd_soal = '$kds' GROUP BY kd_soal;"));
		$ds		= $kmpl[0];
		$err	= 0;
		$rc		= 0;
		$urc	= 0;

		if (isset($_FILES['berkas_excel']['name']) && in_array($_FILES['berkas_excel']['type'], $file_mimes)) {

			$arr_file = explode('.', $_FILES['berkas_excel']['name']);
			$extension = end($arr_file);

			if ('xls' == $extension) {
				$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
			} else {
				$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
			}
			$reader->setLoadSheetsOnly("DataSoal");
			$reader->setReadDataOnly(true);
			$spreadsheet = $reader->load($_FILES['berkas_excel']['tmp_name']);

			// $Data = $spreadsheet->getActiveSheet()->toArray();
			$Data = $spreadsheet->getActiveSheet()->ToArray();
			$baris = count($Data);
			for ($i = 2; $i < $baris; $i++) {

				$nos		= $Data[$i]['0'];
				$jns		= $Data[$i]['1'];
				$ktg		= $Data[$i]['2'];
				$asoal	= $Data[$i]['3'];
				$aopsi	= $Data[$i]['4'];
				$des		= $Data[$i]['5'];
				$tanya	= $Data[$i]['6'];
				$timg		= $Data[$i]['7'];
				$taud		= $Data[$i]['8'];
				$tvid		= $Data[$i]['9'];
				$opsi1	= $Data[$i]['10'];
				$opsi2	= $Data[$i]['11'];
				$opsi3	= $Data[$i]['12'];
				$opsi4	= $Data[$i]['13'];
				$opsi5	= $Data[$i]['14'];
				$opimg1	= $Data[$i]['15'];
				$opimg2	= $Data[$i]['16'];
				$opimg3	= $Data[$i]['17'];
				$opimg4	= $Data[$i]['18'];
				$opimg5	= $Data[$i]['19'];
				$key		= $Data[$i]['20'];

				if (strlen($des) <= 3) {
					$kd_crt = $des;
					$des		= "";
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

				$inup = "INSERT INTO cbt_soal (id_soal, kd_soal, kd_mapel, jns_soal, lev_soal, no_soal, cerita, kd_crta, tanya, img, audio, vid, jwb1, jwb2, jwb3, jwb4, jwb5, img1, img2, img3, img4, img5, knci_pilgan, ack_soal, ack_opsi) VALUES (NULL, '$kds', '$kmpl[kd_mpel]', '$jns', '$ktg', '$nos', '$des', '$kd_crt', '$tanya', '$timg', '$taud', '$tvid', '$opsi1', '$opsi2', '$opsi3', '$opsi4', '$opsi5', '$opimg1', '$opimg2', '$opimg3', '$opimg4', '$opimg5', '$key', '$asoal', '$aopsi');";
				$upup = "UPDATE cbt_soal SET kd_soal = '$kds', kd_mapel = '$kmpl[kd_mpel]', jns_soal = '$jns', lev_soal = '$ktg', cerita = '$des', tanya = '$tanya', img = '$timg', audio = '$taud', vid = '$tvid', jwb1 = '$opsi1', jwb2 = '$opsi2', jwb3 = '$opsi3', jwb4 = '$opsi4', jwb5 = '$opsi5', img1 = '$opimg1', img2 = '$opimg2', img3 = '$opimg3', img4 = '$opimg4', img5 = '$opimg5', knci_pilgan = '$key', ack_soal = '$asoal', ack_opsi = '$aopsi' WHERE cbt_soal.no_soal = '$nos';";
				// INSERT INTO cbt_soal (id_soal, kd_soal, kd_mapel, jns_soal, lev_soal, no_soal, cerita, kd_crta, tanya, img, audio, vid, jwb1, jwb2, jwb3, jwb4, jwb5, img1, img2, img3, img4, img5, knci_pilgan, ack_soal, ack_opsi) VALUES (NULL, 'XM_NTK', 'MTK', 'G', '1', '$nos', 'Soal Uji coba bentuk Cerita', '1', 'Pertanyaan nomor 2/Soal<br>di beri Br', 'i', 'a', 'v', 'Jawab A', 'Jawab B', 'Jawab C', 'Jawab D', 'Jawab E', 'i1', 'i2', 'i3', 'i4', 'i5', '1', 'Y', 'Y');

				// UPDATE cbt_soal SET kd_soal = '', kd_mapel = 'PPKn', jns_soal = 'E', lev_soal = '2', no_soal = '3', cerita = 'Soal 2 Uji coba bentuk Cerita', tanya = 'Pertanyaan nomor 3/Soal<br>di beri Br', img = 'ia', audio = 'aa', vid = 'va', jwb1 = 'Jawab Aa', jwb2 = 'Jawab Ba', jwb3 = 'Jawab Ca', jwb4 = 'Jawab Da', jwb5 = 'Jawab Ea', img1 = 'i1a', img2 = 'i2a', img3 = 'i3a', img4 = 'i4aa', img5 = 'i5a', knci_pilgan = '2', ack_soal = 'N', ack_opsi = 'N' WHERE cbt_soal.id_soal = 2;
				// mysqli_query($koneksi, "insert into mahasiswa (id,nim,nama,ipk,jurusan) values ('','$nim','$nama','$ipk','$jurusan')");
				if ((!empty($nos && $jns && $ktg && $key) === true)) {
					if ($jns != "G" && "E") {
						$err++;
					} else if ($ktg > 3) {
						$err++;
					} elseif ($key > 5) {
						$err++;
					} elseif (!empty(mysqli_num_rows($ckno))) {
						if (mysqli_query($koneksi, $upup)) {		//simpan
							$urc++;
						}
					} else {
						if (mysqli_query($koneksi, $inup)) {		//update
							$rc++;
						}
					}
				}
				if (empty($jns && $ktg && $key) === true) {
					$err++;
				}
			}
			//header("Location: form_upload.html"); 
			// echo "Soal Tidak Falid : " . $ss;
			if ($err or $urc > 0) {
				echo "<br>Soal Tidak Falid     : " . $err
					. "<br>Soal Berhasil Upload : " . $rc
					. "<br>Soal di Update       : " . $urc;
			} else {
				echo '
				<div class="alert alert-success mt-3" role="alert">Data berhasil di upload!</div>
				';
				echo '<meta http-equiv="refresh" content="3;url=./?md=esoal&ds=' . $ds . '">';
			}
		}
	}
	?>
	<div class="row my-5 mx-2">
		<div class="col-auto">
			<form method="post" enctype="multipart/form-data" action="">
				<!-- <div class="form-group">
					<label for="exampleInputFile">Upload File soal</label>
					<input type="file" name="berkas_excel" class="form-control" id="exampleInputFile">
				</div>
				<input type="submit" class="btn btn-primary mt-2" value="Import" name="import" /> -->

				<div class="input-group">
					<input type="file" class="form-control" name="berkas_excel" id="exampleInputFile" aria-describedby="inputGroupFileAddon04" aria-label="Upload">
					<button type="submit" class="btn btn-primary" name="import">Upload</button>
				</div>
			</form>
		</div>

	</div>
</div>