<?php
include_once("../../config/server.php");

$kds = $_GET['kds'];
$mpl = $_GET['mpl'];
$sqls = (mysqli_query($koneksi, "SELECT * FROM cbt_soal WHERE kd_soal='$kds' AND kd_mapel = '$mpl' ORDER BY cbt_soal.no_soal ASC"));


// header("Content-type: application/vnd-ms-excel");
// header("Content-Disposition: attachment; filename=Data Pegawai.xls");
?>

<style>
  table,
  th,
  td {
    border: 1px solid black;
    border-collapse: collapse;
  }
</style>
<table>
  <thead align="center">
    <tr>
      <th rowspan="2">No. Soal</th>
      <th rowspan="2">Jenis Soal</th>
      <th rowspan="2">Kategori</th>
      <th colspan="2">Acak</th>
      <th rowspan="2" style="min-width: 15cm; max-width: 20cm; word-wrap: break-word;">Deskripsi</th>
      <th rowspan="2" style="min-width: 15cm; max-width: 20cm; word-wrap: break-word;">Pertanyaan</th>
      <th rowspan="2">Gambar Tanya</th>
      <th rowspan="2">Audio Tanya</th>
      <th rowspan="2">Video Tanya</th>
      <th rowspan="2">Opsi 1</th>
      <th rowspan="2">Opsi 2</th>
      <th rowspan="2">Opsi 3</th>
      <th rowspan="2">Opsi 4</th>
      <th rowspan="2">Opsi 5</th>
      <th rowspan="2">IMG 1</th>
      <th rowspan="2">IMG 2</th>
      <th rowspan="2">IMG 3</th>
      <th rowspan="2">IMG 4</th>
      <th rowspan="2">IMG 5</th>
      <th rowspan="2">Kunci</th>
    </tr>
    <tr>
      <th>Soal</th>
      <th>Opsi</th>
    </tr>
  </thead>
  <tbody>
    <?php $a = 1;
    while ($dt = mysqli_fetch_array($sqls)) {
    ?>
      <tr valign="top">
        <td><?php echo $a ?></td>
        <td><?php echo $dt['jns_soal'] ?></td>
        <td><?php echo $dt['lev_soal'] ?></td>
        <td><?php echo $dt['ack_soal'] ?></td>
        <td><?php echo $dt['ack_opsi'] ?></td>
        <td><?php if (!empty($dt['cerita'])) {
              echo htmlspecialchars($dt['cerita']);
            } else {
              if ($dt['kd_crta'] != 0) {
                echo "<div align=center>$dt[kd_crta]</div>";
              }
            } ?></td>
        <td><?php echo htmlspecialchars($dt['tanya'])  ?></td>
        <td><?php echo $dt['img'] ?></td>
        <td><?php echo $dt['audio'] ?></td>
        <td><?php echo $dt['vid'] ?></td>
        <td><?php echo htmlspecialchars($dt['jwb1']) ?></td>
        <td><?php echo htmlspecialchars($dt['jwb2']) ?></td>
        <td><?php echo htmlspecialchars($dt['jwb3']) ?></td>
        <td><?php echo htmlspecialchars($dt['jwb4']) ?></td>
        <td><?php echo htmlspecialchars($dt['jwb5']) ?></td>
        <td><?php echo $dt['img1'] ?></td>
        <td><?php echo $dt['img2'] ?></td>
        <td><?php echo $dt['img3'] ?></td>
        <td><?php echo $dt['img4'] ?></td>
        <td><?php echo $dt['img5'] ?></td>
        <td><?php echo $dt['knci_pilgan'] ?></td>
      </tr>
    <?php $a++;
    } ?>
  </tbody>
</table>
<?php
// header("Pragma: public");
// header("Expires: 0");
// header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
// header("Content-Type: application/force-download");
// header("Content-Type: application/octet-stream");
// header("Content-Type: application/download");;
// header("Content-Disposition: attachment;filename=DATA KRKARYAWAN.xls");
// header("Content-Transfer-Encoding: binary ");
?>