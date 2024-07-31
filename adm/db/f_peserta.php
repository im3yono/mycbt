<?php
include_once("../../config/server.php");
require "../../vendor/autoload.php";

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use \PhpOffice\PhpSpreadsheet\IOFactory;
use \PhpOffice\PhpSpreadsheet\Writer\IWriter;
use \PhpOffice\PhpSpreadsheet\Reader\IReader;
// use PhpOffice\PhpSpreadsheet\Worksheet\DataValidation;
// use \PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use \PhpOffice\PhpSpreadsheet\Cell\DataValidation;



$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$spreadsheet->getActiveSheet()->setTitle('Data Peserta');
$spreadsheet->setActiveSheetIndex(0);

$baris = $_POST['baris'];
// Head
$sheet->setCellValue([1, $baris], 'IP Server')->getColumnDimensionByColumn(1)->setAutoSize(true);
$sheet->setCellValue([2, $baris], 'NIS')->getColumnDimensionByColumn(2)->setAutoSize(true);
$sheet->setCellValue([3, $baris], 'Nama Peserta')->getColumnDimensionByColumn(3)->setAutoSize(true);
$sheet->setCellValue([4, $baris], 'Tempat Lahir')->getColumnDimensionByColumn(4)->setAutoSize(true);
$sheet->setCellValue([5, $baris], 'Tanggal Lahir dd/mm/yy')->getColumnDimensionByColumn(5)->setWidth(13);
$sheet->setCellValue([6, $baris], 'Kode Kelas')->getColumnDimensionByColumn(6)->setWidth(10);
$sheet->setCellValue([7, $baris], 'Jenis Kelamin')->getColumnDimensionByColumn(7)->setWidth(10);
$sheet->setCellValue([8, $baris], 'Nama File Foto')->getColumnDimensionByColumn(8)->setAutoSize(true);
$sheet->setCellValue([9, $baris], 'Username')->getColumnDimensionByColumn(9)->setAutoSize(true);
$sheet->setCellValue([10, $baris], 'Password')->getColumnDimensionByColumn(10)->setAutoSize(true);
$sheet->setCellValue([11, $baris], 'Sesi')->getColumnDimensionByColumn(11)->setAutoSize(true);
$sheet->setCellValue([12, $baris], 'Ruang')->getColumnDimensionByColumn(12)->setAutoSize(true);


$sheet->getStyle([1, $baris, 12, $baris])->getFont()->setBold(true);
$sheet->getStyle([1, $baris, 12, $baris])
	->getAlignment()
	->setWrapText(true)
	->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER) // Atur horizontal alignment ke tengah
	->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER); // Atur vertical alignment ke tengah



// body
$dt_kls = mysqli_query($koneksi, "SELECT * FROM `kelas`");

// Menyiapkan data validasi list (daftar pilihan)
$jml =  $_POST['jml'];
while ($data = mysqli_fetch_array($dt_kls)) {
	$pilihan[] = $data['kd_kls'];
}
// $pilihan = ['Pilihan 1', 'Pilihan 2', 'Pilihan 3'];
$jk = ['L', 'P'];
for ($i = 1; $i <= $jml; $i++) {
	// Menentukan sel atau rentang sel untuk data validasi list
	$sel = [6, $baris + $i];
	$sel2 = [7, $baris + $i];
	$sel3 = [10, $baris + $i];
	$sel4 = [8, $baris + $i];

	$sheet->getStyle([5, $baris + $i])->getNumberFormat()->setFormatCode('dd/mm/yy');
	// Membuat objek data validasi list
	$dv = $sheet->getCell($sel)->getDataValidation();
	$dv->setType(DataValidation::TYPE_LIST)
		->setErrorStyle(DataValidation::STYLE_STOP)
		->setAllowBlank(false)
		->setShowDropDown(true)
		->setShowInputMessage(true)
		->setShowErrorMessage(true)
		->setErrorTitle('Kesalahan Validasi')
		->setError('Harap pilih nilai dari daftar.')
		->setPromptTitle('Pilih dari Daftar')
		->setPrompt('Pilih salah satu dari daftar berikut.')
		->setFormula1('"' . implode(',', $pilihan) . '"');

	// Membuat objek data validasi list
	$dv2 = $sheet->getCell($sel2)->getDataValidation();
	$dv2->setType(DataValidation::TYPE_LIST)
		->setErrorStyle(DataValidation::STYLE_STOP)
		->setAllowBlank(false)
		->setShowDropDown(true)
		->setShowInputMessage(true)
		->setShowErrorMessage(true)
		->setErrorTitle('Kesalahan Validasi')
		->setError('Harap pilih nilai dari daftar.')
		->setPromptTitle('Pilih dari Daftar')
		->setPrompt('Pilih salah satu dari daftar berikut.')
		->setFormula1('"' . implode(',', $jk) . '"');

	$sheet->setCellValue($sel4, 'noavatar.png');
	$dv4 = $sheet->getCell($sel4)->getDataValidation();
	$dv4->setShowInputMessage(true)
		->setPromptTitle('Nama dan Format File')
		->setPrompt('Perhatikan nama dan format file jangan sampai tertiggal
		contoh format yg diterima.
		Gambar = JPG, JPEG, PNG');

	// $sheet->setCellValue($sel3, '=RANDBETWEEN(3000,9999)&"*"');
	$sheet->setCellValue($sel3, rand(1234,9999).'*');
	// $sheet->setCellValue($sel2, 'tes');
}

$styleArray = [
	'borders' => [
		'allBorders' => [
			'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
		],
	],
];
// $i = $i - 1;
$sheet->getStyle([1, $baris, 12, $baris + $jml])->applyFromArray($styleArray);

// Output
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Format_Peserta.xlsx');
header('Cache-Control: max-age=0');

$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, "Xlsx");
$writer->save('php://output');

// DEMO
// $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
// $writer->save("demo.xlsx");
