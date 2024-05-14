<?php
require "../config/server.php";
require "../vendor/autoload.php";

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet\Row;

$start = 1;
?>
<div class="container-fluid mb-5 p-0">
	<div class="row p-2 border-bottom fs-3 mb-4 shadow-sm ">
		<div class="col-auto "><a href="?md=sis" class="btn btn-outline-dark"><i class="bi bi-arrow-left"></i> Kembali</a></div> Upload Data Peserta
	</div>
	<div class="row m-4 border-success border shadow" style="border-radius: 5px;">
		<div class="col-12 bg-success p-1 text-white fs-5 shadow-sm">Download File Excel (Template Peserta)</div>
		<div class="col-auto">
			<img src="../img/Ms_Excel.png" alt="" srcset="" style="max-width: 200px;" class="">
		</div>
		<div class="col p-3">
			<div class="row g-2">
				<div class="col-12">
					<p>
						Silahkan Masukkan jumlah peserta dan Klik tombol download template dibawah, untuk download file excel sesuai dengan Format yang disediakan.
						Jangan ada inputan apapun setelah nomer terakhir.
						Karena akan terbaca oleh sistem.</p>
				</div>
				<div class="col-auto">
					<form action="./db/f_peserta.php" method="post">
						<div class="input-group input-group-sm mb-2">
							<input for="" id="baris" name="baris" value="<?php echo $start ?>" hidden>
							<label class="input-group-text col-auto fw-semibold" id="upload">Jumlah Peserta</label>
							<input type="number" class="form-control" id="jml" name="jml" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" value="30" style="width: 70px;text-align: end;" required>
						</div>
						<button type="submit" class="btn btn-primary">Download Template Peserta</button>
					</form>
				</div>
				<!-- <div class="col-12"><a href="" class="btn btn-primary">Download Template Peserta</a></div> -->
			</div>
		</div>
	</div>
	<div class="row mt-5 pt-3 px-3 border-top">
		<div class="col-12">
			<h5 class="text-decoration-underline">Upload File</h5>
			<p>Pastikan file yang di upload sesuai dengan format yang telah di unduh agar tidak terjadi eror.</p>
		</div>
		<div class="col-auto">
			<form method="post" enctype="multipart/form-data" action="">
				<div class="input-group input-group-sm">
					<!-- <label class="input-group-text col-4" id="upload">Upload File</label> -->
					<input type="file" class="form-control" id="upload" name="upload" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" placeholder="" accept=".xlsx">
					<button type="submit" class="btn btn-primary" id="import" name="import">Upload File</button>
				</div>
			</form>
		</div>
		<div class="col-12">
			<?php
			$up = 0;
			$in = 0;
			$err = 0;
			if (isset($_POST['import'])) {
				$file_mimes = array('application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
				// $kds = $_GET['kds'];
				// $kmpl = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM cbt_pktsoal WHERE kd_soal = '$kds' GROUP BY kd_soal;"));


				if (isset($_FILES['upload']['name']) && in_array($_FILES['upload']['type'], $file_mimes)) {
					$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
					$reader->setLoadSheetsOnly("Data Peserta");
					$reader->setReadDataOnly(true);
					$spreadsheet = $reader->load($_FILES['upload']['tmp_name']);

					$Data = $spreadsheet->getActiveSheet()->ToArray();
					$baris = count($Data);
					for ($i = $start; $i < $baris; $i++) {
						$ipsv			= $Data[$i][0];
						$nis 			= $Data[$i][1];
						$nm 			= $Data[$i][2];
						$tmp_l 		= $Data[$i][3];
						$tgl_l 		= $Data[$i][4];
						$kd_kls 	= $Data[$i][5];
						$jns_kel 	= $Data[$i][6];
						$ft 			= $Data[$i][7];
						$usr 			= $Data[$i][8];
						$pas 			= $Data[$i][9];
						$ses 			= $Data[$i][10];
						$ruang 		= $Data[$i][11];

						$ck_dt = mysqli_query($koneksi, "SELECT * FROM cbt_peserta WHERE cbt_peserta.user='$usr'");

						$sql_in = "INSERT INTO cbt_peserta (id_peserta, ip_sv, nm, tmp_lahir, tgl_lahir, nis, kd_kls, jns_kel, ft, user, pass, sesi, ruang, sts) VALUES (NULL, '$ipsv', '$nm', '$tmp_l', '$tgl_l', '1234512', '$kd_kls', '$jns_kel', '$ft', '$usr', '$pas', '$ses', '$ruang', 'Y')";

						$sql_up = "UPDATE cbt_peserta SET ip_sv = '$ipsv', nm = '$nm', tmp_lahir = '$tmp_l', tgl_lahir = '$tgl_l', nis = '$nis', kd_kls = '$kd_kls', jns_kel = '$jns_kel', ft = '$ft', pass = '$pas', sesi = '$ses', ruang = '$ruang' WHERE cbt_peserta.user = '$usr'";

						if (empty(mysqli_num_rows($ck_dt))) {
							if (mysqli_query($koneksi, $sql_in)) {
								$in++;
							}
						} else {
							if (mysqli_query($koneksi, $sql_up)) {
								$up++;
							}
						}
					}
				}
			echo "Upload : " . $in."<br>";
			echo "Update : " . $up;
			}
			?>
		</div>
	</div>
	<div class="row"></div>
</div>