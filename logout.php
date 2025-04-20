<?php
setcookie('user', '',time() - 3600, '/');
setcookie('pass', '',time() - 3600, '/');
setcookie('connectionStatus', '',time() - 3600, '/');
setcookie('n_soal', '',time() - 3600, '/');
$fld = $_SERVER['SCRIPT_NAME'];
$fld= explode('/',$fld);
if ($fld[2]=="adm") {
	header('location:/'.$_GET['fld'].'/');
}else{
if (!empty($_GET['info'])) {
  header('location:/'.$fld[1].'/?login=' . $_GET['info']);
} else {
	header('location:/'.$fld[1]);
}
}

?>