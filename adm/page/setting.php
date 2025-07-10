<?php
// require_once '../config/db.php';
require '../config/server.php';
require_once '../config/conf_db.php';

// set awal
// if ($db_null == 1 && $_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["nm_db"]) && isset($_POST["btn_sdb"])) {
// 	$usdb =  $_POST["userdb"];
// 	$psdb =  $_POST["passdb"];
// 	$nmdb =  $_POST["nm_db"];
// 	$db_get = $_POST['db_get'];
// 	$file = "db.php";
// 	if (file_put_contents("../config/" . $file, '$rw_db[$n++] = "' . $data . '";', FILE_APPEND | LOCK_EX) !== false) {
// 			echo '<meta http-equiv="refresh" content="3">';
// 	} else {
// 		echo "Terjadi kesalahan saat menyimpan data.";
// 	}
// }


// Rubah Databaase
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["nm_db"]) && isset($_POST["btn_sdb"])) {
	$data 	=  $_POST["nm_db"];
	$db_get = $_POST['db_get'];
	$file 	= "conf_db.php";
	if (file_put_contents("../config/" . $file, '$rw_db[$n++] = "' . $data . '";' . "\n", FILE_APPEND | LOCK_EX) !== false) {
		try {
			mysqli_connect($server, $userdb, $passdb, $_POST["nm_db"]);
			echo '<meta http-equiv="refresh" content="3; url=../logout.php">';
		} catch (Exception $e) {
			echo "Terjadi kesalahan koneksi database: " . $e->getMessage();
			require_once '../config/db_impor.php';
			echo '<meta http-equiv="refresh" content="3">';
		}
	} else {
		echo "Terjadi kesalahan saat menyimpan data.";
	}
	// }
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["btn_hdb"])) {
	$file = "conf_db.php";
	if (file_put_contents("../config/" . $file, '<?php' . "\n" . '$n = 0;' . "\n" . '$rw_db = [];' . "\n") !== false) {
		echo '<meta http-equiv="refresh" content="3">';
	} else {
		echo "Terjadi kesalahan saat menghapus data.";
	}
} else {
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["aktif"]) && isset($_POST["nm_pt"]) && isset($_POST["kd_aktif"])) {
	$nm = ($_POST['nm_pt']);
	$kd_aktif 	= $_POST['kd_aktif'];
	$file 	= '../config/key.php';

	// Pastikan nilai tidak kosong
	if (empty($nm) || empty($kd_aktif)) {
		echo "<p style='color: red;'>Data tidak boleh kosong!</p>";
		exit;
	}

	$err = file_key($file, $nm, $kd_aktif);
}
?>


<style>
	.bg-akt {
		/* background: rgb(0,255,255);
background: radial-gradient(circle, rgba(0,255,255,0.5018382352941176) 0%, rgba(153,153,153,0.4009978991596639) 100%); */
		border-radius: 7px;
	}
</style>
<div class="container-fluid mb-0 p-0">
	<div class="row p-2 border-bottom fs-6 mb-4 shadow-sm text-uppercase">
		<ul class="nav nav-tabs" id="myTab" role="tablist">
			<li class="nav-item" role="presentation">
				<button class="nav-link active" id="set-app" data-bs-toggle="tab" data-bs-target="#set-app-pane" type="button" role="tab" aria-controls="set-app-pane" aria-selected="true">
					<span class="bi bi-gear text-black"> Pengaturan Aplikasi</span>
				</button>
			</li>
			<li class="nav-item" role="presentation">
				<button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">
					<span class="bi bi-columns-gap text-black"> Tampilan</span>
				</button>
			</li>
			<li class="nav-item" role="presentation">
				<button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact-tab-pane" type="button" role="tab" aria-controls="contact-tab-pane" aria-selected="false">
					<span class="bi bi-person-vcard text-black"> Kontak</span>
				</button>
			</li>
			<!-- <li class="nav-item" role="presentation">
				<button class="nav-link" id="disabled-tab" data-bs-toggle="tab" data-bs-target="#disabled-tab-pane" type="button" role="tab" aria-controls="disabled-tab-pane" aria-selected="false" disabled>Disabled</button>
			</li> -->
		</ul>
	</div>
	<div class="tab-content" id="myTabContent">
		<div class="tab-pane fade show active" id="set-app-pane" role="tabpanel" aria-labelledby="set-app" tabindex="0">
			<?php include_once('content/setting_app.php') ?>
		</div>
		<div class="tab-pane fade" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">Tahap Pengembangan
		</div>
		<div class="tab-pane fade" id="contact-tab-pane" role="tabpanel" aria-labelledby="contact-tab" tabindex="0">Tahap Pengembangan</div>
		<div class="tab-pane fade" id="disabled-tab-pane" role="tabpanel" aria-labelledby="disabled-tab" tabindex="0">Tahap Pengembangan</div>
	</div>
</div>