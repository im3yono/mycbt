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

// Head
$sheet->setCellValue([1, 1], 'IP Server')->getColumnDimensionByColumn(1)->setAutoSize(true);
$sheet->setCellValue([2, 1], 'Nama Peserta')->getColumnDimensionByColumn(2)->setAutoSize(true);
$sheet->setCellValue([3, 1], 'Tempat Lahir')->getColumnDimensionByColumn(3)->setAutoSize(true);
$sheet->setCellValue([4, 1], 'Tanggal Lahir')->getColumnDimensionByColumn(4)->setAutoSize(true);
$sheet->setCellValue([5, 1], 'NIS')->getColumnDimensionByColumn(5)->setAutoSize(true);
$sheet->setCellValue([6, 1], 'Kode Kelas')->getColumnDimensionByColumn(6)->setAutoSize(true);
$sheet->setCellValue([7, 1], 'Jenis Kelamin')->getColumnDimensionByColumn(7)->setAutoSize(true);
$sheet->setCellValue([8, 1], 'Nama File Foto')->getColumnDimensionByColumn(8)->setAutoSize(true);
$sheet->setCellValue([9, 1], 'Username')->getColumnDimensionByColumn(9)->setAutoSize(true);
$sheet->setCellValue([10, 1], 'Password')->getColumnDimensionByColumn(10)->setAutoSize(true);
$sheet->setCellValue([11, 1], 'Sesi')->getColumnDimensionByColumn(11)->setAutoSize(true);
$sheet->setCellValue([12, 1], 'Ruang')->getColumnDimensionByColumn(12)->setAutoSize(true);

$sheet->getStyle([1, 1, 12, 1])->getFont()->setBold(true);
$sheet->getStyle([1, 1, 12, 1])
	->getAlignment()
	->setWrapText(true)
	->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER) // Atur horizontal alignment ke tengah
	->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER); // Atur vertical alignment ke tengah



// Menyiapkan data validasi list (daftar pilihan)
$jml=1500;
$pilihan = ['Pilihan 1', 'Pilihan 2', 'Pilihan 3'];
for ($i = 1; $i < $jml; $i++) {
	// Menentukan sel atau rentang sel untuk data validasi list
	$sel = [6, 1 + $i];

	// Membuat objek data validasi list
	$dataValidation = $sheet->getCell($sel)->getDataValidation();
	$dataValidation->setType(DataValidation::TYPE_LIST)
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
}
$jk = ['L', 'P'];
for ($i = 1; $i < $jml; $i++) {
	// Menentukan sel atau rentang sel untuk data validasi list
	$sel = [7, 1 + $i];

	// Membuat objek data validasi list
	$dataValidation = $sheet->getCell($sel)->getDataValidation();
	$dataValidation->setType(DataValidation::TYPE_LIST)
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
}


$styleArray = [
  'borders' => [
    'allBorders' => [
      'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
    ],
  ],
];
$i = $i - 1;
$sheet->getStyle([1,1,12,$jml])->applyFromArray($styleArray);
// Output
// header('Content-Type: application/vnd.ms-excel');
// header('Content-Disposition: attachment;filename="Format_Peserta.xlsx');
// header('Cache-Control: max-age=0');

// $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, "Xlsx");
// $writer->save('php://output');

// DEMO
$writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
$writer->save("demo.xlsx");
