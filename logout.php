<?php
setcookie('user', '');
setcookie('pass', '');
if (!empty($_GET['info'])) {
  header('location:/tbk/?login=' . $_GET['info']);
} else {
?><script>
    window.location.replace('/tbk/?');
  </script>
<?php
}


?>