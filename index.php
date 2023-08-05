<?php
if ($_SERVER['REQUEST_METHOD'] == "POST") {
	if (isset($_POST["login"])) {
	include_once("konfirmasi.php");
	}else
	if (isset($_POST["konf"])) {
	include_once("mulai.php");
	}else
	if (isset($_POST["mulai"])) {
	include_once("ujian.php");
	}
}
elseif (isset($_COOKIE['user']) && isset($_COOKIE['pass'])) {
	include_once("konfirmasi.php");
}
else {
	include_once("login.php");
}
