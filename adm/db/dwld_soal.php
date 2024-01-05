<?php
include_once("../../config/server.php");
require '../../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use \PhpOffice\PhpSpreadsheet\IOFactory;
use \PhpOffice\PhpSpreadsheet\Writer\IWriter;
use \PhpOffice\PhpSpreadsheet\Reader\IReader;


$kds = $_GET['kds'];
$mpl = $_GET['mpl'];
$sqls = (mysqli_query($koneksi, "SELECT * FROM cbt_soal WHERE kd_soal='$kds' AND kd_mapel = '$mpl' ORDER BY cbt_soal.no_soal ASC"));


$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->mergeCells('A1:A2');
$sheet->setCellValue('A1', 'No. Soal')->getColumnDimension('A')->setWidth(5);
$sheet->mergeCells('B1:B2');
$sheet->setCellValue('B1', 'Jenis Soal')->getColumnDimension('B')->setWidth(5);
$sheet->mergeCells('C1:C2');
$sheet->setCellValue('C1', 'Kategori')->getColumnDimension('C')->setWidth(5);
$sheet->mergeCells('D1:E1');
$sheet->setCellValue('D1', 'Acak');
$sheet->setCellValue('D2', 'Soal')->getColumnDimension('D')->setWidth(5);
$sheet->setCellValue('E2', 'Opsi')->getColumnDimension('E')->setWidth(5);
$sheet->mergeCells('F1:F2');
$sheet->setCellValue('F1', 'Deskripsi');
$sheet->mergeCells('G1:G2');
$sheet->setCellValue('G1', 'Pertanyaan');
$sheet->mergeCells('H1:H2');
$sheet->setCellValue('H1', 'Gambar Tanya');
$sheet->mergeCells('I1:I2');
$sheet->setCellValue('I1', 'Audio Tanya');
$sheet->mergeCells('J1:J2');
$sheet->setCellValue('j1', 'Video Tanya');
$sheet->mergeCells('K1:K2');
$sheet->setCellValue('K1', 'Opsi 1');
$sheet->mergeCells('L1:L2');
$sheet->setCellValue('L1', 'Opsi 2');
$sheet->mergeCells('M1:M2');
$sheet->setCellValue('M1', 'Opsi 3');
$sheet->mergeCells('N1:N2');
$sheet->setCellValue('N1', 'Opsi 4');
$sheet->mergeCells('O1:O2');
$sheet->setCellValue('O1', 'Opsi 5');
$sheet->mergeCells('P1:P2');
$sheet->setCellValue('P1', 'IMG 1');
$sheet->mergeCells('Q1:Q2');
$sheet->setCellValue('Q1', 'IMG 2');
$sheet->mergeCells('R1:R2');
$sheet->setCellValue('R1', 'IMG 3');
$sheet->mergeCells('S1:S2');
$sheet->setCellValue('S1', 'IMG 4');
$sheet->mergeCells('T1:T2');
$sheet->setCellValue('T1', 'IMG 5');
$sheet->mergeCells('U1:U2');
$sheet->setCellValue('U1', 'Kunci')->getColumnDimension('U')->setWidth(8);

$sheet->getStyle('A1:U2')
  ->getAlignment()
  ->setWrapText(true)
  ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER) // Atur horizontal alignment ke tengah
  ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER); // Atur vertical alignment ke tengah

$no = 1;
$i  = 3;
while ($dt = mysqli_fetch_array($sqls)) {
  if (!empty($dt['cerita'])) {
    $des = ($dt['cerita']);
  } else {
    if ($dt['kd_crta'] != 0) {
      $des = $dt['kd_crta'];
    }
  }
  $sheet->setCellValue('A' . $i, $no++);
  $sheet->setCellValue('B' . $i, $dt['jns_soal']);
  $sheet->setCellValue('C' . $i, $dt['lev_soal']);
  $sheet->setCellValue('D' . $i, $dt['ack_soal']);
  $sheet->setCellValue('E' . $i, $dt['ack_opsi']);
  $sheet->setCellValue('F' . $i, $des);
  $sheet->setCellValue('G' . $i, ($dt['tanya']));
  $sheet->setCellValue('H' . $i, $dt['img']);
  $sheet->setCellValue('I' . $i, $dt['audio']);
  $sheet->setCellValue('J' . $i, $dt['vid']);
  $sheet->setCellValue('K' . $i, ($dt['jwb1']));
  $sheet->setCellValue('L' . $i, ($dt['jwb2']));
  $sheet->setCellValue('M' . $i, ($dt['jwb3']));
  $sheet->setCellValue('N' . $i, ($dt['jwb4']));
  $sheet->setCellValue('O' . $i, ($dt['jwb5']));
  $sheet->setCellValue('P' . $i, $dt['img1']);
  $sheet->setCellValue('Q' . $i, $dt['img2']);
  $sheet->setCellValue('R' . $i, $dt['img3']);
  $sheet->setCellValue('S' . $i, $dt['img4']);
  $sheet->setCellValue('T' . $i, $dt['img5']);
  $sheet->setCellValue('U' . $i, $dt['knci_pilgan']);

  $sheet->getStyle('A' . $i.':E' . $i)
  ->getAlignment()
  ->setWrapText(true)
  ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER) // Atur horizontal alignment ke tengah
  ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER); // Atur vertical alignment ke tengah

  $sheet->getStyle('U' . $i)
  ->getAlignment()
  ->setWrapText(true)
  ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER) // Atur horizontal alignment ke tengah
  ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER); // Atur vertical alignment ke tengah

  $i++;
}
?>
<?php
// header("Pragma: public");
// header("Expires: 0");
// header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
// header("Content-Type: application/force-download");
// header("Content-Type: application/octet-stream");
// header("Content-Type: application/download");;
// header("Content-Disposition: attachment;filename=DATA KRKARYAWAN.xls");
// header("Content-Transfer-Encoding: binary ");

$styleArray = [
  'borders' => [
    'allBorders' => [
      'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
    ],
  ],
];
$i = $i - 1;
$sheet->getStyle('A1:U' . $i)->applyFromArray($styleArray);
$spreadsheet->getActiveSheet()->setTitle('DataSoal');
$spreadsheet->setActiveSheetIndex(0);
$nmsoal = $kds . '_' . $mpl . '.xlsx';


header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Soal_' . $nmsoal);
header('Cache-Control: max-age=0');

$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, "Xlsx");
$writer->save('php://output');

exit;

?>