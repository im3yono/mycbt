<?php 
setcookie('user', '');
setcookie('pass', '');
header('location:/tbk/?login='.$_GET['info']);
?>