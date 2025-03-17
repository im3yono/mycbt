<?php
include_once("../config/server.php");

$kds	= $_GET['kds'];
$dt = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM cbt_pktsoal WHERE cbt_pktsoal.kd_soal ='$kds'"));
?>

<div class="container-fluid mb-5 p-0">

	<div class="row p-2 border-bottom fs-3 mb-4 shadow-sm ">
		<div class="col-auto "><a href="?md=esoal&ds=<?php echo $dt[0]; ?>" class="btn btn-outline-dark"><i class="bi bi-arrow-left"></i> Kembali</a></div> Upload File soal
	</div>
	<div class="row m-4 border-success border shadow" style="border-radius: 5px;">
		<div class="col-12 bg-success p-1 text-white fs-5 shadow-sm px-2">Download File Excel (Template Soal)</div>
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
	<div class="row m-4 border-warning border shadow" style="border-radius: 5px;">
		<div class="col-12 bg-warning p-1 text-white fs-5 shadow-sm px-2">Perhatian!</div>
		<div class="col p-2">
			<li>File yang di upload harus sesuai dengan format yang telah di unduh pada tombol diatas.</li>
			<li>Pastikan file yang akan di upload, pengisian sudah benar agar ketika proses upload tidak bermasalah.</li>
			<li>Untuk file soal yang terdapat Jenis Soal Pilihan Ganda dan Esai dalam satu file maka jumlah upload akan sesuai dengan data bank soal. </li>
		</div>
	</div>
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
		$j_es	= $kmpl['esai'];
		$j_pg	= $kmpl['pilgan'];
		$j_pex = 0;
		$err	= 0;
		$rc		= 0;
		$urc	= 0;
		$es		= 0;
		$pg		= 0;

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
				$des		= addslashes($Data[$i]['5']);
				$tanya	= addslashes($Data[$i]['6']);
				$timg		= addslashes($Data[$i]['7']);
				$taud		= $Data[$i]['8'];
				$tvid		= $Data[$i]['9'];
				if ($jns == "G") {
					$aopsi	= addslashes($Data[$i]['4']);
					$opsi1	= addslashes($Data[$i]['10']);
					$opsi2	= addslashes($Data[$i]['11']);
					$opsi3	= addslashes($Data[$i]['12']);
					$opsi4	= addslashes($Data[$i]['13']);
					$opsi5	= addslashes($Data[$i]['14']);
					$opimg1	= addslashes($Data[$i]['15']);
					$opimg2	= addslashes($Data[$i]['16']);
					$opimg3	= addslashes($Data[$i]['17']);
					$opimg4	= addslashes($Data[$i]['18']);
					$opimg5	= addslashes($Data[$i]['19']);
					$key		= addslashes($Data[$i]['20']);
				} else {
					$aopsi	= "";
					$opsi1	= "";
					$opsi2	= "";
					$opsi3	= "";
					$opsi4	= "";
					$opsi5	= "";
					$opimg1	= "";
					$opimg2	= "";
					$opimg3	= "";
					$opimg4	= "";
					$opimg5	= "";
					$key		= "";
				}

				if (is_numeric($des)) {
					$kd_crt = $des;
					$des		= "";
				} else {
					$kd_crt = "0";
				}
				if (empty($asoal)) {
					$asoal = "Y";
				}
				if (empty($aopsi)) {
					if ($jns == "E") {
						$aopsi = "";
					} else {
						$aopsi = "Y";
					}
				}
				$ckno = mysqli_query($koneksi, "SELECT * FROM cbt_soal WHERE no_soal ='$nos' AND kd_soal ='$kds';");

				// Insert
				$inup = "INSERT INTO cbt_soal (id_soal, kd_soal, kd_mapel, jns_soal, lev_soal, no_soal, cerita, kd_crta, tanya, img, audio, vid, jwb1, jwb2, jwb3, jwb4, jwb5, img1, img2, img3, img4, img5, knci_pilgan, ack_soal, ack_opsi) VALUES (NULL, '$kds', '$kmpl[kd_mpel]', '$jns', '$ktg', '$nos', '$des', '$kd_crt', '$tanya', '$timg', '$taud', '$tvid', '$opsi1', '$opsi2', '$opsi3', '$opsi4', '$opsi5', '$opimg1', '$opimg2', '$opimg3', '$opimg4', '$opimg5', '$key', '$asoal', '$aopsi');";

				// Update
				$upup = "UPDATE cbt_soal SET jns_soal = '$jns', lev_soal = '$ktg', cerita = '$des',kd_crta = '$kd_crt' , tanya = '$tanya', img = '$timg', audio = '$taud', vid = '$tvid', jwb1 = '$opsi1', jwb2 = '$opsi2', jwb3 = '$opsi3', jwb4 = '$opsi4', jwb5 = '$opsi5', img1 = '$opimg1', img2 = '$opimg2', img3 = '$opimg3', img4 = '$opimg4', img5 = '$opimg5', knci_pilgan = '$key', ack_soal = '$asoal', ack_opsi = '$aopsi' 
				WHERE no_soal = '$nos' AND kd_soal = '$kds' AND kd_mapel = '$kmpl[kd_mpel]';";


				// if ($j_es === "0") {
				// 	if ($jns == "G") {
				// 		if ((!empty($nos && $jns && $ktg && $key) === true)) {
				// 			if ($ktg > 3) {
				// 				$err++;
				// 			} elseif ($key > 5) {
				// 				$err++;
				// 			} elseif (!empty(mysqli_num_rows($ckno))) {
				// 				if (mysqli_query($koneksi, $upup)) {		//update
				// 					$urc++;
				// 				}
				// 			} else {
				// 				if (mysqli_query($koneksi, $inup)) {		//simpan
				// 					$rc++;
				// 				}
				// 			}
				// 		}
				// 	// } elseif ($jns == "E") {
				// 	// 	if ((!empty($nos && $jns && $ktg) === true)) {
				// 	// 		if ($ktg > 3) {
				// 	// 			$err++;
				// 	// 		} elseif (!empty(mysqli_num_rows($ckno))) {
				// 	// 			if (mysqli_query($koneksi, $upup)) {		//update
				// 	// 				$urc++;
				// 	// 			}
				// 	// 		} else {
				// 	// 			if (mysqli_query($koneksi, $inup)) {		//simpan
				// 	// 				$rc++;
				// 	// 			}
				// 	// 		}
				// 	// 	}
				// 	} else {
				// 		$err++;
				// 	}
				// } else {
				if (($jns == "G" && $j_pg > $pg) || ($jns == "E" && $j_es > $es)) {
					if (!empty($nos && $jns && $ktg) && ($jns != "G" || $key)) {
						if ($ktg > 3 || ($jns == "G" && $key > 5)) {
							$err++;
						} elseif (!empty(mysqli_num_rows($ckno))) {
							if (mysqli_query($koneksi, $upup)) { // Update
								$urc++;
							}
						} else {
							if (mysqli_query($koneksi, $inup)) { // Simpan
								$rc++;
							}
						}
					}
					$jns == "G" ? $pg++ : $es++;
				} elseif ($j_pg <= $pg || $j_es <= $es) {
					$j_pex++;
				} else {
					$err++;
				}

				// }
				// if (empty($jns && $ktg && $key) === true) {
				// 	$err++;
				// }
			}
			//header("Location: form_upload.html"); 
			// echo "Soal Tidak Falid : " . $ss;
			if ($err or $urc > 0) {
				echo '<div class="row my-1 mx-2"><div class="col-auto">';
				if ($j_es === "0") {
					echo '<table>
									<tr>
										<td style="width: 180px;">Soal Tidak Falid</td>
										<td>: ' . $err
						. '</td>
									</tr>
									<tr>
										<td>Soal Tidak di Upload</td>
										<td>: ' . $j_pex
						. '</td>
									</tr>
									<tr>
										<td>Soal Berhasil Upload</td>
										<td>: ' . $rc
						. '</td>
									</tr>
									<tr>
										<td>Soal di Update</td>
										<td>: ' . $urc
						. '</td>
									</tr>
								</table>';
				} else {
					echo '<table>
									<tr>
										<td style="width: 180px;">Soal Tidak Falid</td>
										<td>: ' . $err
						. '</td>
									</tr>
									<tr>
										<td>Soal Tidak di Upload</td>
										<td>: ' . $j_pex
						. '</td>
									</tr>
									<tr>
										<td>Soal Berhasil Upload</td>
										<td>: ' . $rc
						. '</td>
									</tr>
									<tr>
										<td>Soal di Update</td>
										<td>: ' . $urc
						. '</td>
									</tr>
								</table>';
				}
				echo '</div></div>';
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
					<input type="file" class="form-control" name="berkas_excel" id="exampleInputFile" aria-describedby="inputGroupFileAddon04" aria-label="Upload" accept=".xlsx">
					<button type="submit" class="btn btn-primary" name="import">Upload</button>
				</div>
			</form>
		</div>
	</div>
</div>