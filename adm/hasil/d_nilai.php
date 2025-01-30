<?php
include_once("../../config/server.php");
require "../../vendor/autoload.php";

function kls($idkls)
{
	if ($idkls == "1") {
		$flkls = 'Semua';
	} else {
		$flkls = $idkls;
	}
	return $flkls;
}
function jur($idjur)
{
	if ($idjur == "1") {
		$flkls = 'Semua';
	} else {
		$flkls = $idjur;
	}
	return $flkls;
}

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use \PhpOffice\PhpSpreadsheet\IOFactory;
use \PhpOffice\PhpSpreadsheet\Writer\IWriter;
use \PhpOffice\PhpSpreadsheet\Reader\IReader;

$kds = $_GET['kds'];
$token = $_GET['tkn'];


$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
function dataCell($sheet, int $kol, int $row, string $val, $for, int $wid = 0)
{
	if ($for == "head") {
		if ($wid == "0") {
			$sheet->setCellValue([$kol, $row], $val)->getColumnDimensionByColumn($kol)->setAutoSize(true);
		} else {
			$sheet->setCellValue([$kol, $row], $val)->getColumnDimensionByColumn($kol)->setWidth($wid);
		}
		$sheet->getStyle([$kol, $row])->getFont()->setBold(true);
		$sheet->getStyle([$kol, $row])
			->getAlignment()
			->setWrapText(true)
			->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER) // Atur horizontal alignment ke tengah
			->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER); // Atur vertical alignment ke tengah

		return $sheet;
	} elseif ($for == "data") {
		$sheet->setCellValue([$kol, $row], $val)
			->getStyle([$kol, $row])
			->getAlignment()
			->setWrapText(true)
			->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER) // Atur horizontal alignment ke tengah
			->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER); // Atur vertical alignment ke tengah

		return $sheet;
	}
};
// title
$qr_no = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM cbt_pktsoal WHERE kd_soal ='$kds'"));
// if ($qr_no['kd_kls'] == "1") {
// 	$kls = $qr_no['kls'] . " " . $qr_no['jur'];
// } else {
// 	$nm_kls = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM kelas WHERE kd_kls ='$qr_no[kd_kls]'"));
// 	$kls = $nm_kls['nm_kls'];
// }

$kls = kls($qr_no['kd_kls']) . '-' . jur($qr_no['jur']);

$qr_mpel = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM mapel WHERE kd_mpel ='$qr_no[kd_mpel]'"));
$sheet->mergeCells([1, 1, 2, 1]);
$sheet->mergeCells([1, 2, 2, 2]);
$sheet->mergeCells([1, 3, 2, 3]);
$sheet->setCellValue([1, 1], 'Mata Pelajaran');
$sheet->setCellValue([1, 2], 'Pembuat Soal');
$sheet->setCellValue([1, 3], 'Kelas');
$sheet->setCellValue([3, 1], $qr_mpel['nm_mpel'])->getStyle([3, 1])->getFont()->setBold(true);
$sheet->setCellValue([3, 2], $qr_no['author']);
$sheet->setCellValue([3, 3], $kls);
// Head
$hb = 5;
// $sheet->setCellValue([1, 1], 'DAFTAR NILAI');
dataCell($sheet, 1, $hb, 'No.', 'head', 5);
dataCell($sheet, 2, $hb, 'No. Peserta', 'head');
dataCell($sheet, 3, $hb, 'Nama', 'head', 40);
// $sheet->setCellValue([3, $hb], 'Nama');
dataCell($sheet, 4, $hb, 'Nilai', 'head');
dataCell($sheet, 5, $hb, 'Keterangan', 'head');

// Data
$no = 1;
$baris = 6;
$qr = mysqli_query($koneksi, "SELECT * FROM nilai WHERE kd_soal ='$kds' AND token ='$token'");

while ($data = mysqli_fetch_array($qr)) {
	$nm = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM cbt_peserta WHERE user='$data[user]'"));
	if ($data['kkm'] < $data['nilai']) {
		$ket = "Tuntas";
	} else {
		$ket = "Tidak Tuntas";
		$tex = "text-danger";
	};

	dataCell($sheet, 1, $baris, $no, 'data');
	dataCell($sheet, 2, $baris, $data['user'], 'data');
	$sheet->setCellValue([3, $baris], $nm['nm'])->getColumnDimensionByColumn(3)->setWidth(40);
	dataCell($sheet, 4, $baris, $data['nilai'], 'data');
	if ($_GET['ket'] == '2') {
		dataCell($sheet, 5, $baris, $ket, 'data');
	}
	$baris++;
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
$sheet->getStyle([1, $hb, 5, $hb + $no])->applyFromArray($styleArray);


// Demo
// $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
// $writer->save("demo.xlsx");

// Download
if ($qr_no['kd_kls'] == "1") {
	$flkls = $qr_no['kls'] . '-' . $qr_no['jur'];
} else {
	$flkls = $qr_no['kd_kls'] . '-' . $qr_no['jur'];
}

$spreadsheet->getActiveSheet()->setTitle('Nilai');
$spreadsheet->setActiveSheetIndex(0);
$nmfile = $kds . ' (' . $qr_mpel['nm_mpel'] . ')_' . $flkls . '-'.$token.'.xlsx';

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Nilai_' . $nmfile);
header('Cache-Control: max-age=0');

$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, "Xlsx");
$writer->save('php://output');
