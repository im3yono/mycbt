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
elseif (isset($_REQUEST["du"]) && isset($_REQUEST["dp"])) {
	include_once("konfirmasi.php");
}
else {
	include_once("login.php");
	// header('Location: /tbk/login.php');
}
?>

<!-- <style>
#myBtn {
  position: fixed;
  bottom: 30px;
  right: 20px;
  z-index: 99;
  font-size: 18px;
  border: none;
  outline: none;
  background-color: whitesmoke;
  color: white;
  cursor: pointer;
  padding: 7px;
  border-radius: 50%;
}

#myBtn:hover {
  background-color: white;
}
</style>
<button onclick="topFunction()" id="myBtn" title="Go to top"><img src="img/refresh.svg" alt="" srcset=""></button>
<script>
  function topFunction() {
    document.body.scrollTop = 0;
    document.documentElement.scrollTop = 0;
  }
  </script> -->