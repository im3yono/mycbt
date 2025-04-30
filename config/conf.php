<?php
require("key.php");


class AES_Encryption
{
	private $key;
	private $iv;

	public function __construct($key)
	{
		$this->key = hash('sha256', $key, true); // Kunci 32 byte
		$this->iv = substr(hash('sha256', 'iv_secret', true), 0, 16); // IV 16 byte
	}

	public function encrypt($data)
	{
		return base64_encode(openssl_encrypt($data, 'AES-256-CBC', $this->key, OPENSSL_RAW_DATA, $this->iv));
	}

	public function decrypt($encryptedData)
	{
		return openssl_decrypt(base64_decode($encryptedData), 'AES-256-CBC', $this->key, OPENSSL_RAW_DATA, $this->iv);
	}
}


$key_mem	= new AES_Encryption('@Triyono68');
$mem			= $key_mem->decrypt($code_mem);

$key_code	= new AES_Encryption($mem);
$d_exp		= $key_code->decrypt($code);


function nmpt($nama)
{
	$kunci = new AES_Encryption('@Triyono68');
	return $kunci->encrypt($nama);
}

function file_key($file, $nm, $kd_aktif)
{
	$nm = nmpt($nm);
	file_put_contents($file, '');
	$data = "<?php\n";
	$data .= "\$code_mem = \"" . addslashes($nm) . "\";\n";
	$data .= "\$code = \"" . addslashes($kd_aktif) . "\";\n";
	$data .= "?>";

	if (file_put_contents($file, $data, FILE_APPEND)) {
		return '<meta http-equiv="refresh" content="3">';
	} else {
		$err = "<p style='color: red;'>Gagal menyimpan data!</p>";
	}
	return $err;
}

function cek_aktif($date, $exc, $date2 = null)
{
	if (empty($date2)) {
		$date2 = date('m/d/Y');
	} else {
		$date2 = date('Y-m-d', strtotime('+1 week'));
	}
	switch ($exc) {
		case '<':
			if (strtotime($date) < strtotime($date2)) {
				return true;
			}
			break;
		case '>':
			if (strtotime($date) > strtotime($date2)) {
				return true;
			}
			break;
		case '=':
			if (strtotime($date) == strtotime($date2)) {
				return true;
			}
			break;
		case '<=':
			if (strtotime($date) <= strtotime($date2)) {
				return true;
			}
			break;
		case '>=':
			if (strtotime($date) >= strtotime($date2)) {
				return true;
			}
			break;
	}
	return false;
}

function validateDate($date)
{
	$timestamp = strtotime($date);
	return ($timestamp !== false);
}


// Super user
class SU_Admin
{
	public $su_user = 'suadmin';
	public $su_pass = '@()$!(($';
}