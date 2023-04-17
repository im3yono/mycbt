<?php 
if (isset($_REQUEST['md'])=="") {include_once("dashboard.php");}
elseif (($_REQUEST['md'])=="id") {include_once("identitas.php");}
elseif (($_REQUEST['md'])=="usr") {include_once("user.php");}
elseif (($_REQUEST['md'])=="kls") {include_once("kelas.php");}
elseif (($_REQUEST['md'])=="mpl") {include_once("mapel.php");}
elseif (($_REQUEST['md'])=="sis") {include_once("siswa.php");}
?>