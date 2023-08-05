<?php 
include_once("server.php");
// error_reporting(0); //hide error

// if ($_SERVER['REQUEST_METHOD'] == "POST") {
//   // setcookie('user', $_POST['username']);
//   // setcookie('pass', $_POST['password']);
//   // $user = $_POST['user'];
//   // $pass = $_POST['pass'];

// if (isset($_COOKIE['user']) && isset($_COOKIE['pass'])) {
//   $user = $_COOKIE['user'];
//   $pass = $_COOKIE['pass'];
// }
// else {
//   setcookie('user', $_REQUEST['username'],time()+36000);
//   setcookie('pass', $_REQUEST['password'],time()+36000);
//   $user = $_REQUEST['user'];
//   $pass = $_REQUEST['pass'];
// }
// echo"lck";
session_start();

$user = "$_POST[username]";
$pass = "$_POST[password]";
$qrsis    = mysqli_query($koneksi,"SELECT * FROM cbt_peserta WHERE user ='$user' AND pass='$pass' AND sts='Y';");
$qradm    = mysqli_query($koneksi,"SELECT * FROM user WHERE username='$user' AND pass=md5('$pass') AND sts='Y';");
$ceksis    = mysqli_num_rows($qrsis);
$cekadm    = mysqli_num_rows($qradm);
if ($cekadm >0) {
  $data = mysqli_fetch_assoc($qradm);
  if ($data['lvl']=="A") {
    $_SESSION['user']=$user;               // username
    $_SESSION['lvl']="A";                     // level
    header("location:adm/?");          // halaman tujuan
  } elseif ($data['lvl']=="U") {
    $_SESSION['user']=$user;               // username
    $_SESSION['lvl']="U";                     // level
    header("location:adm/?");          // halaman tujuan
  } elseif ($data['lvl']=="X") {
    $_SESSION['user']=$user;               // username
    $_SESSION['lvl']="X";                     // level
    header("location:adm/?");          // halaman tujuan
  }
}elseif ($ceksis>0) {
  $_SESSION['username']=$user;
  header("location:index.php/konfirmasi.php");
}
// }
?>