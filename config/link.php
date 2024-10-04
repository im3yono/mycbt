<?php
function encrypt($s)
{
	$cryptKey    = 'd8578edf8458ce06fbc5bb76a58c5ca4';
	$qEncoded    = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($cryptKey), $s, MCRYPT_MODE_CBC, md5(md5($cryptKey))));
	return ($qEncoded);
}
function decrypt($s)
{
	$cryptKey    = 'd8578edf8458ce06fbc5bb76a58c5ca4';
	$qDecoded    = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($cryptKey), base64_decode($s), MCRYPT_MODE_CBC, md5(md5($cryptKey))), "\0");
	return ($qDecoded);
}


function en_url($string)
{
	$key = "IW_979805"; //key to encrypt and decrypts.
	$result = '';
	$test = "";
	for ($i = 0; $i < strlen($string); $i++) {
		$char = substr($string, $i, 1);
		$keychar = substr($key, ($i % strlen($key)) - 1, 1);
		$char = chr(ord($char) + ord($keychar));
		$test[$char] = ord($char) + ord($keychar);
		$result .= $char;
	}
	return urlencode(base64_encode($result));
}
function de_url($string)
{
	$key = "IW_979805"; //key to encrypt and decrypts.
	$result = '';
	$string = base64_decode(urldecode($string));
	for ($i = 0; $i < strlen($string); $i++) {
		$char = substr($string, $i, 1);
		$keychar = substr($key, ($i % strlen($key)) - 1, 1);
		$char = chr(ord($char) - ord($keychar));
		$result .= $char;
	}
	return $result;
}
