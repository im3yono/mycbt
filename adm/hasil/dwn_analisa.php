<?php
include_once("../../config/server.php");
require "../../vendor/autoload.php";
// include_once("../config/server.php");
// require "../vendor/autoload.php";

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use \PhpOffice\PhpSpreadsheet\IOFactory;
use \PhpOffice\PhpSpreadsheet\Writer\IWriter;
use \PhpOffice\PhpSpreadsheet\Reader\IReader;


$kds = $_GET['kds'];
// $kds = $_POST['field1'];
// $kd_kls = $_POST['kls'];
$qr_no = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM cbt_pktsoal WHERE kd_soal ='$kds'"));
if ($qr_no['kd_kls'] == "1") {
	$kls = $qr_no['kls'] . " " . $qr_no['jur'];
} else {
	$nm_kls = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM `kelas` WHERE kd_kls ='$qr_no[kd_kls]'"));
	$kls = $nm_kls['nm_kls'];
}

$qr_mpel = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM mapel WHERE kd_mpel ='$qr_no[kd_mpel]'"));


$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Header
$sheet->mergeCells('A1:A2');
$sheet->setCellValue('A1', 'No.')->getColumnDimensionByColumn(1)->setAutoSize(true);
$sheet->mergeCells('B1:B2');
$sheet->setCellValue('B1', 'No. Peserta')->getColumnDimensionByColumn(2)->setAutoSize(true);
$sheet->mergeCells('C1:C2');
$sheet->setCellValue('C1', 'Nama Peserta')->getColumnDimensionByColumn(3)->setAutoSize(true);

// $qr_no = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM cbt_pktsoal WHERE kd_soal ='$kds'"));
$qr_jmlno = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM cbt_soal WHERE kd_soal ='$kds'"));
if (!empty($qr_jmlno)) {
	$jml_soal = $qr_jmlno;
} else {
	$jml_soal = 0;
}

for ($i = 1; $i <= $jml_soal; $i++) {
	$sheet->setCellValue([3 + $i, 1], $i)->getColumnDimensionByColumn(3 + $i)->setWidth(3);
	$sheet->getRowDimension(2)->setRowHeight(15);

	$qr_key = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM cbt_soal WHERE kd_soal = '$kds' AND no_soal='$i';"));
	// while ($qr_key = mysqli_fetch_array($qrs)) {
	if (!empty($qr_key)) {
		if ($qr_key['jns_soal'] == "G") {
			if ($qr_key['knci_pilgan'] == "1") {
				$jwopsi = "A";
			} elseif ($qr_key['knci_pilgan'] == "2") {
				$jwopsi = "B";
			} elseif ($qr_key['knci_pilgan'] == "3") {
				$jwopsi = "C";
			} elseif ($qr_key['knci_pilgan'] == "4") {
				$jwopsi = "D";
			} elseif ($qr_key['knci_pilgan'] == "5") {
				$jwopsi = "E";
			} else {
				$jwopsi = "";
			}
			$bg_key = "FFFF00";
		} elseif ($qr_key['jns_soal'] == "E") {
			$jwopsi = "ES";
			$bg_key = "FFFFFF";
		}
	} else {
		$jwopsi = "X";
	}
	// echo '<td class="text-center" style="width: 5mm;">' . $jwopsi . ' </td>';
	$sheet->setCellValue([3 + $i, 2], $jwopsi)->getStyle([3 + $i, 2])->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB($bg_key);
}
$i = $i - 1;
// [kolom,baris,kolom,baris]
$sheet->mergeCells([4 + $i, 1, 5 + $i, 1]);
$sheet->setCellValue([4 + $i, 1], 'PilGan')->getColumnDimensionByColumn(4 + $i)->setAutoSize(true);
$sheet->getStyle([4 + $i, 1])->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('90EE90');
$sheet->setCellValue([4 + $i, 2], 'Benar')->getColumnDimensionByColumn(4 + $i)->setAutoSize(true);
$sheet->getStyle([4 + $i, 2])->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('90EE90');
$sheet->setCellValue([5 + $i, 2], 'Salah')->getColumnDimensionByColumn(5 + $i)->setAutoSize(true);
$sheet->getStyle([5 + $i, 2])->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FF6347');

$sheet->mergeCells([6 + $i, 1, 6 + $i, 2]);
$sheet->setCellValue([6 + $i, 1], 'Esai')->getColumnDimensionByColumn(6 + $i)->setAutoSize(true);
$sheet->mergeCells([7 + $i, 1, 7 + $i, 2]);
$sheet->setCellValue([7 + $i, 1], 'Nilai')->getColumnDimensionByColumn(7 + $i)->setAutoSize(true);
$sheet->mergeCells([8 + $i, 1, 8 + $i, 2]);
$sheet->setCellValue([8 + $i, 1], 'Ket')->getColumnDimensionByColumn(8 + $i)->setAutoSize(true);


$sheet->getStyle([1, 1, 8 + $i, 2])->getFont()->setBold(true);
$sheet->getStyle([1, 1, 8 + $i, 2])
	->getAlignment()
	->setWrapText(true)
	->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER) // Atur horizontal alignment ke tengah
	->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER); // Atur vertical alignment ke tengah


// Data Tabel
$no = 0;
$qr_opsi = mysqli_query($koneksi, "SELECT * FROM nilai WHERE kd_soal='$kds'");
while ($data = mysqli_fetch_array($qr_opsi)) {
	$user = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM cbt_peserta WHERE user ='$data[user]'"));
	if ($data['nilai'] >= $data['kkm']) {
		$ket = "TUNTAS";
	} else {
		$ket = "TIDAK TUNTAS";
	}
	$sheet->setCellValue([1, 3 + $no], 1 + $no);
	$sheet->setCellValue([2, 3 + $no], $data['user']);
	$sheet->setCellValue([3, 3 + $no], $user['nm']);

	$opsi = explode(",", $data['jwb']);
	for ($j = 1; $j <= $jml_soal; $j++) {
		foreach ($opsi  as $a) {
			$b = $a;
		}
		if (!empty($b[$j - 1])) {
			$sheet->setCellValue([3 + $j, 3 + $no], $b[$j - 1]);
		}
	}

	$sheet->setCellValue([4 + $i, 3 + $no], $data['nil_pg']);
	$sheet->setCellValue([5 + $i, 3 + $no], $qr_no['pilgan'] - $data['nil_pg']);
	if (!empty($qr_no['esai'])) {
		$es = $data['nil_es'];
	} else {
		$es = "";
	}
	$sheet->setCellValue([6 + $i, 3 + $no], $es);
	$sheet->setCellValue([7 + $i, 3 + $no], $data['nilai']);
	$sheet->setCellValue([8 + $i, 3 + $no], $ket);


	$sheet->getStyle([4, 3, 8 + $i,  3 + $no])
		->getAlignment()
		->setWrapText(true)
		->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER) // Atur horizontal alignment ke tengah
		->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER); // Atur vertical alignment ke tengah


	$no++;
}


// Border Table
$styleArray = [
	'borders' => [
		'allBorders' => [
			'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
		],
	],
];
// $i = $i - 1;
$sheet->getStyle([1, 1, 8 + $i, 3 + $no])->applyFromArray($styleArray);

// Download
if ($qr_no['kd_kls'] == "1") {
	$flkls = $qr_no['kls'] . '-' . $qr_no['jur'];
} else {
	$flkls = $qr_no['kd_kls'] . '-' . $qr_no['jur'];
}

$spreadsheet->getActiveSheet()->setTitle('Analisa');
$spreadsheet->setActiveSheetIndex(0);
$nmfile = $kds.' ('.$qr_mpel['nm_mpel'] . ')_' . $flkls . '.xlsx';

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Analisa_' . $nmfile);
header('Cache-Control: max-age=0');

$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, "Xlsx");
$writer->save('php://output');

exit;
