<?php
include_once("../../config/server.php");
$kds  = $_GET['kds'];
$kmpl = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM cbt_pktsoal WHERE kd_soal = '$kds' GROUP BY kd_soal;"));
if ($_SERVER['REQUEST_METHOD'] = "POST") {
	function spasi($data)
	{
		return ($data == "<p>&nbsp;</p>") ? '' : $data;
	}
	$nos		= $_POST['nos'];
	$jns		= $_POST['jns_soal'];
	$ktg		= $_POST['ktg'];
	$asoal	= $_POST['asoal'];
	$kd_crt = empty($_POST['crt']) ? "0" : $_POST['des'];
	$des		= spasi(addslashes($_POST['crt']));
	$tanya	= spasi(addslashes($_POST['tny']));
	$taud		= "";
	$tvid		= "";
	$opsi1	= spasi(addslashes($_POST['opsi1']));
	// $opimg1l = $_POST['img1jw'];
	$opsi2	= spasi(addslashes($_POST['opsi2']));
	// $opimg2l = $_POST['img2jw'];
	$opsi3	= spasi(addslashes($_POST['opsi3']));
	// $opimg3l = $_POST['img3jw'];
	$opsi4	= spasi(addslashes($_POST['opsi4']));
	// $opimg4l = $_POST['img4jw'];
	$opsi5	= spasi(addslashes($_POST['opsi5']));
	// $opimg5l = $_POST['img5jw'];


	if ($jns == 'J') {
		$opsi1 = $opsi1 . '|||' . spasi(addslashes($_POST['jdh1']));
		$opsi2 = $opsi2 . '|||' . spasi(addslashes($_POST['jdh2']));
		$opsi3 = $opsi3 . '|||' . spasi(addslashes($_POST['jdh3']));
		$opsi4 = $opsi4 . '|||' . spasi(addslashes($_POST['jdh4']));
		$opsi5 = $opsi5 . '|||' . spasi(addslashes($_POST['jdh5']));
	}


	if ($jns == "E") {
		$key = "";
		$aopsi  = "";
	} elseif ($jns == "X") {
		$aopsi  = "";
	} else {
		if (empty($_POST['keyopsi'])) {
			$key = '';
		} else {
			$key = $_POST['keyopsi'];
		}
		$aopsi  = $_POST['aopsi'];
	}
	// if ($kd_crt=="0") {
	// 	$des    = $_POST['crt'];
	// }else{$des    = "";}

	$format = array('png', 'jpg', 'PNG', 'JPG', 'jpeg', 'JPEG');
	$dft0   = explode('.', $_FILES['img_s']['name']);
	$dft1   = explode('.', $_FILES['imgjw1']['name']);
	$dft2   = explode('.', $_FILES['imgjw2']['name']);
	$dft3   = explode('.', $_FILES['imgjw3']['name']);
	$dft4   = explode('.', $_FILES['imgjw4']['name']);
	$dft5   = explode('.', $_FILES['imgjw5']['name']);
	$exe0   = strtolower(end($dft0));
	$exe1   = strtolower(end($dft1));
	$exe2   = strtolower(end($dft2));
	$exe3   = strtolower(end($dft3));
	$exe4   = strtolower(end($dft4));
	$exe5   = strtolower(end($dft5));
	// $size      = $_FILES['lgdns']['size'];
	$file_tmp0  = $_FILES['img_s']['tmp_name'];
	$file_tmp1  = $_FILES['imgjw1']['tmp_name'];
	$file_tmp2  = $_FILES['imgjw2']['tmp_name'];
	$file_tmp3  = $_FILES['imgjw3']['tmp_name'];
	$file_tmp4  = $_FILES['imgjw4']['tmp_name'];
	$file_tmp5  = $_FILES['imgjw5']['tmp_name'];

	if (empty(end($dft0))) {
		$ft0  = $_POST['img_sl'];
	} else {
		$ft0  = $_POST['img_sl'] . "." . end($dft0);
	}
	if (empty(end($dft1))) {
		$ft1  = $_POST['img1jw'];
	} else {
		$ft1  = $_POST['img1jw'] . "." . end($dft1);
	}
	if (empty(end($dft2))) {
		$ft2  = $_POST['img2jw'];
	} else {
		$ft2  = $_POST['img2jw'] . "." . end($dft2);
	}
	if (empty(end($dft3))) {
		$ft3  = $_POST['img3jw'];
	} else {
		$ft3  = $_POST['img3jw'] . "." . end($dft3);
	}
	if (empty(end($dft4))) {
		$ft4  = $_POST['img4jw'];
	} else {
		$ft4  = $_POST['img4jw'] . "." . end($dft4);
	}
	if (empty(end($dft5))) {
		$ft5  = $_POST['img5jw'];
	} else {
		$ft5  = $_POST['img5jw'] . "." . end($dft5);
	}


	// Audio extensions
	$f_media_audio = ['mp3', 'wav', 'aac', 'wma', 'ogg'];
	// Video extensions
	$f_media_video = ['mp4', 'webm', '3gp', 'avi', 'mpeg', 'mpg', 'flv', 'mkv'];
	// Gabungkan untuk kompatibilitas kode lama
	
	$f_media = array_merge($f_media_audio, $f_media_video);
	$fl_audio = explode('.', $_FILES['audio']['name']);
	$fl_video = explode('.', $_FILES['video']['name']);
	$exeaud = strtolower(end($fl_audio));
	$exevid = strtolower(end($fl_video));
	$file_tmpa = $_FILES['audio']['tmp_name'];
	$file_tmpv = $_FILES['video']['tmp_name'];

	if (empty(end($fl_audio))) {
		$taud  = $_POST['nm_audio'];
	} else {
		$taud  = $_POST['nm_audio'] . "." . end($fl_audio);
	}
	if (empty(end($fl_video))) {
		$tvid  = $_POST['nm_video'];
	} else {
		$tvid  = $_POST['nm_video'] . "." . end($fl_video);
	}


	$ckno = mysqli_query($koneksi, "SELECT * FROM cbt_soal WHERE no_soal ='$nos' AND kd_soal ='$kds';");

	$inup = "INSERT INTO cbt_soal (id_soal, kd_soal, kd_mapel, jns_soal, lev_soal, no_soal, cerita, kd_crta, tanya, img, audio, vid, jwb1, jwb2, jwb3, jwb4, jwb5, img1, img2, img3, img4, img5, knci_pilgan, ack_soal, ack_opsi) VALUES (NULL, '$kds', '$kmpl[kd_mpel]', '$jns', '$ktg', '$nos', '$des', '$kd_crt', '$tanya', '$ft0', '$taud', '$tvid', '$opsi1', '$opsi2', '$opsi3', '$opsi4', '$opsi5', '$ft1', '$ft2', '$ft3', '$ft4', '$ft5', '$key', '$asoal', '$aopsi');";

	$upup = "UPDATE cbt_soal SET kd_mapel = '$kmpl[kd_mpel]', jns_soal = '$jns', lev_soal = '$ktg', kd_crta='$kd_crt', cerita = '$des', tanya = '$tanya', img = '$ft0', audio = '$taud', vid = '$tvid', jwb1 = '$opsi1', jwb2 = '$opsi2', jwb3 = '$opsi3', jwb4 = '$opsi4', jwb5 = '$opsi5', img1 = '$ft1', img2 = '$ft2', img3 = '$ft3', img4 = '$ft4', img5 = '$ft5', knci_pilgan = '$key', ack_soal = '$asoal', ack_opsi = '$aopsi' WHERE cbt_soal.no_soal = '$nos' AND cbt_soal.kd_soal = '$kds';";




	if ((!empty($nos) == true)) {
		if (in_array($exe0, $format) == true) {
			move_uploaded_file($file_tmp0, '../../images/' . $ft0);
		}
		if (in_array($exe1, $format) == true) {
			move_uploaded_file($file_tmp1, '../../images/' . $ft1);
		}
		if (in_array($exe2, $format) == true) {
			move_uploaded_file($file_tmp2, '../../images/' . $ft2);
		}
		if (in_array($exe3, $format) == true) {
			move_uploaded_file($file_tmp3, '../../images/' . $ft3);
		}
		if (in_array($exe4, $format) == true) {
			move_uploaded_file($file_tmp4, '../../images/' . $ft4);
		}
		if (in_array($exe5, $format) == true) {
			move_uploaded_file($file_tmp5, '../../images/' . $ft5);
		}
		if (in_array($exeaud, $f_media) == true) {
			move_uploaded_file($file_tmpa, '../../audio/' . $taud);
		}
		if (in_array($exevid, $f_media) == true) {
			move_uploaded_file($file_tmpv, '../../video/' . $tvid);
		}
		if (!empty(mysqli_num_rows($ckno))) {
			if (mysqli_query($koneksi, $upup)) {    //update
				echo '<meta http-equiv="refresh" content="0;url=../?md=esoal&ds=' . $kmpl['id_pktsoal'] . '&pesan=add">';
			}
		} else {
			if (mysqli_query($koneksi, $inup)) {    //simpan
				echo '<meta http-equiv="refresh" content="0;url=../?md=addsoal&kds=' . $kds . '&pesan=add">';
			}
		}
	}
}
