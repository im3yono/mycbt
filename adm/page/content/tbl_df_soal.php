<!-- <link rel="stylesheet" href="../vendor/simple-datatables/style.css"> -->


<?php
require_once('../../../config/server.php');

// $batas = 10;
// $hal   = isset($_GET['pg']) ? (int)$_GET['pg'] : 1;
// $hal_awal = ($hal > 1) ? ($hal * $batas) - $batas : 0;

// $previous = $hal - 1;
// $next     = $hal + 1;

// $selectSQL = "SELECT * FROM cbt_pktsoal";
// $data = mysqli_query($koneksi, $selectSQL);
// $jml_data = mysqli_num_rows($data);
// $tot_hal = ceil($jml_data / $batas);
$usrlg = isset($_GET['user']) ? htmlspecialchars($_GET['user']) : '';
if ( $usrlg != '1') {
	$uslg = " WHERE author = '$usrlg' ";
} else {
	$uslg = "";
}

$no = 1;
$dtmpl  = mysqli_query($koneksi, "SELECT * FROM cbt_pktsoal $uslg ORDER BY id_pktsoal ASC");
while ($dt = mysqli_fetch_array($dtmpl)) {
	$dtmp = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM mapel WHERE kd_mpel ='$dt[kd_mpel]';"));
	$dtjs = mysqli_fetch_array(mysqli_query($koneksi, "SELECT COUNT(*) AS dtsoal FROM cbt_soal WHERE kd_soal ='$dt[kd_soal]';"));

	if ($dt['kls'] == "1") {
		$kls	= "Semua";
	} else {
		$kls	= $dt['kls'];
	}

?>
	<tr class="text-center">
		<th><?php echo $no++ ?></th>
		<td><?php echo $dt['kd_soal'] ?></td>
		<td><?php echo $dtmp['nm_mpel'] ?></td>
		<td><?php echo $dt['author'] ?></td>
		<td><?php if (!empty($dt['kd_kls'])) {
					echo $kls;
				} else {
					echo "<div class='text-danger'>Silahkan Pilih Kelas</div>";
				} ?></td>
		<td><?php echo $dtjs['dtsoal'] . "/" . $dt['jum_soal'] ?></td>
		<td><?php echo $dt['kkm'] ?></td>
		<td>
			<?php
			if ($dt['sts'] === "Y") {
				echo '<button type="button" class="btn btn-primary" id="sts' . $dt['id_pktsoal'] . '" onclick="statusSoal(' . $dt['id_pktsoal'] . ')">Aktif</button>';
			} else {
				echo '<button type="button" class="btn btn-outline-dark" id="sts' . $dt['id_pktsoal'] . '" onclick="statusSoal(' . $dt['id_pktsoal'] . ')">Modif</button>';
			}
			?>
		</td>
		<td class="text-center">
			<button class="btn btn-sm btn-primary fs-6" type="button" data-bs-toggle="modal" data-bs-target="#Edit<?php echo $dt[0]; ?>"><i class="bi bi-gear"></i></button> |
			<a href="?md=esoal&ds=<?php echo $dt[0]; ?>" class="btn btn-sm btn-info fs-6"><i class="bi bi-pencil-square"></i></a> |
			<a href="./print/c_soal.php?kds=<?php echo $dt['kd_soal'] ?>" target="_blank" class="btn btn-warning fs-6 btn-sm"><i class="bi bi-printer"></i> </a>
			<?php if ($dtjs['dtsoal'] == 0) {
				echo ' | <a href="?md=soal&pesan=hapus&us=' . $dt["id_pktsoal"] . '" class="btn btn-sm btn-danger fs-6 alert_notif"><i class="bi bi-trash3"></i></a>';
			} ?>
		</td>
	</tr>
<?php } ?>



<!-- Javascript -->
<!-- <script src="./../node_modules/jquery/dist/jquery.js"></script>
<script src="./../vendor/simple-datatables/simple-datatables.js"></script> -->