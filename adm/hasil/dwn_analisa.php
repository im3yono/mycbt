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

// include_once("../config/server.php");
// require "../vendor/autoload.php";

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use \PhpOffice\PhpSpreadsheet\IOFactory;
use \PhpOffice\PhpSpreadsheet\Writer\IWriter;
use \PhpOffice\PhpSpreadsheet\Reader\IReader;


$kds = $_GET['kds'];
$token = $_GET['tkn'];
// $kds = $_POST['field1'];
// $kd_kls = $_POST['kls'];
$qr_pktsoal = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM cbt_pktsoal WHERE kd_soal ='$kds'"));
if ($qr_pktsoal['kd_kls'] == "1") {
	$kls = $qr_pktsoal['kls'] . " " . $qr_pktsoal['jur'];
} else {
	$nm_kls = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM kelas WHERE kd_kls ='$qr_pktsoal[kd_kls]'"));
	$kls = $nm_kls['nm_kls'];
}

$qr_mpel = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM mapel WHERE kd_mpel ='$qr_pktsoal[kd_mpel]'"));
// if ($qr_pktsoal['kd_kls'] == "1") {
// 	$flkls = $qr_pktsoal['kls'] . '-' . $qr_pktsoal['jur'];
// } else {
// 	$flkls = $qr_pktsoal['kd_kls'] . '-' . $qr_pktsoal['jur'];
// }
$flkls = kls($qr_pktsoal['kd_kls']) . '-' . jur($qr_pktsoal['jur']);


$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Set table
$brs_head		= 6;
$d_baris 	= $brs_head + 2;

// $qr_pktsoal = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM cbt_pktsoal WHERE kd_soal ='$kds'"));
$qr_jmlno = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM cbt_soal WHERE kd_soal ='$kds'"));
if (!empty($qr_jmlno)) {
	$jml_soal = $qr_jmlno;
} else {
	$jml_soal = 0;
}

// head
$sheet->mergeCells([1, 1, 8 + $jml_soal, 1])
	->setCellValue([1, 1, 8 + $jml_soal, 1], 'ANALISA HASIL TES BERBASIS KOMPUTER ' . $inf_ta)->getStyle([1, 1, 8 + $jml_soal, 1])
	->getFont()->setBold(true);
$sheet->getStyle([1, 1, 8 + $jml_soal, 1])
	->getAlignment()
	->setWrapText(true)
	->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER) // Atur horizontal alignment ke tengah
	->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER); // Atur vertical alignment ke tengah

$sheet->mergeCells([1, 3, 2, 3])->setCellValue([1, 3], 'Nama Matapelajaran');
$sheet->mergeCells([1, 4, 2, 4])->setCellValue([1, 4], 'Kelas');

$sheet->setCellValue([3, 3], ': ' . $qr_mpel['nm_mpel'] . ' (' . $kds . ')-' . $token);
$sheet->setCellValue([3, 4], ': ' . $flkls);

// Header table
$sheet->mergeCells([1, $brs_head, 1, $brs_head + 1]);
$sheet->setCellValue([1, $brs_head], 'No.')->getColumnDimensionByColumn(1)->setAutoSize(true);
$sheet->mergeCells([2, $brs_head, 2, $brs_head + 1]);
$sheet->setCellValue([2, $brs_head], 'No. Peserta')->getColumnDimensionByColumn(2)->setAutoSize(true);
$sheet->mergeCells([3, $brs_head, 3, $brs_head + 1]);
$sheet->setCellValue([3, $brs_head], 'Nama Peserta')->getColumnDimensionByColumn(3)->setAutoSize(true);


for ($i = 1; $i <= $jml_soal; $i++) {
	$sheet->setCellValue([3 + $i, $brs_head], $i)->getColumnDimensionByColumn(3 + $i)->setWidth(4);
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
	$sheet->setCellValue([3 + $i, $brs_head + 1], $jwopsi)->getStyle([3 + $i, $brs_head + 1])->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB($bg_key);
}
$i = $i - 1;
// [kolom,baris,kolom,baris]
$sheet->mergeCells([4 + $i, $brs_head, 5 + $i, $brs_head]);
$sheet->setCellValue([4 + $i, $brs_head], 'PilGan')->getColumnDimensionByColumn(4 + $i)->setAutoSize(true);
$sheet->getStyle([4 + $i, $brs_head])->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('90EE90');
$sheet->setCellValue([4 + $i, $brs_head + 1], 'Benar')->getColumnDimensionByColumn(4 + $i)->setAutoSize(true);
$sheet->getStyle([4 + $i, $brs_head + 1])->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('90EE90');
$sheet->setCellValue([5 + $i, $brs_head + 1], 'Salah')->getColumnDimensionByColumn(5 + $i)->setAutoSize(true);
$sheet->getStyle([5 + $i, $brs_head + 1])->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FF6347');

$sheet->mergeCells([6 + $i, $brs_head, 6 + $i, $brs_head + 1]);
$sheet->setCellValue([6 + $i, $brs_head], 'Esai')->getColumnDimensionByColumn(6 + $i)->setAutoSize(true);
$sheet->mergeCells([7 + $i, $brs_head, 7 + $i, $brs_head + 1]);
$sheet->setCellValue([7 + $i, $brs_head], 'Nilai')->getColumnDimensionByColumn(7 + $i)->setAutoSize(true);
$sheet->mergeCells([8 + $i, $brs_head, 8 + $i, $brs_head + 1]);
$sheet->setCellValue([8 + $i, $brs_head], 'Ket')->getColumnDimensionByColumn(8 + $i)->setAutoSize(true);


$sheet->getStyle([1, $brs_head, 8 + $i, $brs_head + 1])->getFont()->setBold(true);
$sheet->getStyle([1, $brs_head, 8 + $i, $brs_head + 1])
	->getAlignment()
	->setWrapText(true)
	->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER) // Atur horizontal alignment ke tengah
	->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER); // Atur vertical alignment ke tengah


// Data Tabel
$no = 0;
$qr_opsi = mysqli_query($koneksi, "SELECT * FROM nilai WHERE kd_soal='$kds' AND token ='$token'");
while ($data = mysqli_fetch_array($qr_opsi)) {
	$user = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM cbt_peserta WHERE user ='$data[user]'"));
	if ($data['nilai'] >= $data['kkm']) {
		$ket = "TUNTAS";
	} else {
		$ket = "TIDAK TUNTAS";
	}
	$sheet->setCellValue([1, $d_baris + $no], 1 + $no);
	$sheet->getStyle([1, $d_baris + $no])
		->getAlignment()
		// ->setWrapText(true)
		->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER) // Atur horizontal alignment ke tengah
		->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER); // Atur vertical alignment ke tengah
	$sheet->setCellValue([2, $d_baris + $no], $data['user']);
	$sheet->setCellValue([3, $d_baris + $no], $user['nm']);

	$opsi = explode(",", $data['jwb']);
	$nos	= explode(",", $data['no_soal']);
	$k = 0;

	for ($j = 1; $j <= $jml_soal; $j++) {
		if (in_array($j, $nos)) {
			if (!empty($opsi[$k])) {
				$sheet->setCellValue([3 + $j, $d_baris + $no], $opsi[$k]);
			} else {
				$sheet->setCellValue([3 + $j, $d_baris + $no], '');
			}
			$k++;
		} else {
			$sheet->setCellValue([3 + $j, $d_baris + $no], '');
			$k - 1;
		}
	}

	$sheet->setCellValue([4 + $i, $d_baris + $no], $data['nil_pg']);
	$sheet->setCellValue([5 + $i, $d_baris + $no], $qr_pktsoal['pilgan'] - $data['nil_pg']);
	if (!empty($qr_pktsoal['esai'])) {
		$es = $data['nil_es'];
	} else {
		$es = "";
	}
	$sheet->setCellValue([6 + $i, $d_baris + $no], $es);
	$sheet->setCellValue([7 + $i, $d_baris + $no], $data['nilai']);
	if ($_GET['ket'] == '2') {
		$sheet->setCellValue([8 + $i, $d_baris + $no], $ket);
	}

	$sheet->getStyle([4, $d_baris, 8 + $i,  $d_baris + $no])
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
$sheet->getStyle([1, $brs_head, 8 + $i, $d_baris + $no])->applyFromArray($styleArray);

// Download

$spreadsheet->getActiveSheet()->setTitle('Analisa');
$spreadsheet->setActiveSheetIndex(0);
$nmfile = $kds . ' (' . $qr_mpel['nm_mpel'] . ')_' . $flkls . '-' . $token . '.xlsx';

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Analisa_' . $nmfile . '"');
header('Cache-Control: max-age=0');

$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, "Xlsx");
$writer->save('php://output');

exit;
