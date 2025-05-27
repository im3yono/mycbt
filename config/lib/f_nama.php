<?php

function singkatNama($nama)
{
	$nama = ucwords(strtolower($nama)); // ubah menjadi huruf kecil dan kapitalisasi awal kata
	$kata = explode(' ', $nama);
	$jumlah = count($kata);

	if ($jumlah <= 3) {
		return $nama; // tidak disingkat
	}

	$singkat = implode(' ', array_slice($kata, 0, 3)) . ' ';

	// ambil inisial dari kata tengah
	for ($i = 3; $i < $jumlah - 1; $i++) {
		$singkat .= strtoupper(substr($kata[$i], 0, 1)) . '. ';
	}

	return $singkat;
}
