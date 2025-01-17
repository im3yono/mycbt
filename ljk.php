<!-- SELECT * FROM `cbt_ljk` WHERE user_jawab ='XA-01' AND token='JL8BL' AND kd_soal='MTK' GROUP BY urut 
ORDER BY `cbt_ljk`.`urut` ASC; -->
<!-- DELETE FROM cbt_ljk WHERE `cbt_ljk`.`id` = 1 -->

<!-- 
DELETE FROM cbt_ljk
WHERE id NOT IN (
    SELECT id FROM (
        SELECT MIN(id) AS id
        FROM cbt_ljk
        WHERE user_jawab = 'XA-01' AND kd_soal = 'MTK'
        GROUP BY urut
    ) AS temp
)
AND user_jawab = 'XA-01' AND kd_soal = 'MTK';


SELECT * FROM `cbt_ljk` WHERE user_jawab='XA-01' AND kd_soal='MTK';
-->
<?php
require_once('config/server.php');

$usr		= $_POST['user'];
$kds		= $_POST['kds'];
$token	= $_POST['token'];

// $qr_over	= "SELECT * FROM `cbt_ljk` WHERE user_jawab ='XA-01' AND token='JL8BL' AND kd_soal='MTK' GROUP BY urut GROUP BY urut HAVING COUNT(*)>1;";
$qr_over	= mysqli_query($koneksi, "SELECT * FROM `cbt_ljk` WHERE user_jawab ='$usr' AND token='$token' AND kd_soal='$kds' GROUP BY urut HAVING COUNT(*)>1;");
while ($data = mysqli_fetch_array($qr_over)) {
	mysqli_query($koneksi,"DELETE FROM cbt_ljk WHERE `cbt_ljk`.`id` =$data[id]");
}

?>