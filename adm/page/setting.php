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
			if ($tbl_null == 1) {
				// echo '<div class="alert alert-success">Tabel kosong</div>';
				require_once '../config/db_impor.php';
				echo '<meta http-equiv="refresh" content="3; url=../logout.php">';
			} else {
				// echo '<div class="alert alert-success">Tabel ada</div>';
				mysqli_connect($server, $userdb, $passdb, $_POST["nm_db"]);
				echo '<meta http-equiv="refresh" content="3; url=../logout.php">';
			}
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
	.sett{
		background-color: aqua;
	}
</style>
<div class="mb-0 p-0">
	<div class="row px-2 pt-3 pb-0 border-bottom fs-6 mb-4 shadow-sm text-uppercase">
		<?php if ($db_null == 0 && $tbl_null == 0): ?>
			<ul class="nav nav-tabs" id="myTab" role="tablist">
				<li class="nav-item" role="presentation">
					<button class="nav-link active" id="set-app" data-bs-toggle="tab" data-bs-target="#set-app-pane" type="button" role="tab" aria-controls="set-app-pane" aria-selected="true">
						<span class="bi bi-database text-black"> Database</span>
					</button>
				</li>
				<li class="nav-item" role="presentation">
					<button class="nav-link" id="tampilan-tab" data-bs-toggle="tab" data-bs-target="#tampilan-tab-pane" type="button" role="tab" aria-controls="tampilan-tab-pane" aria-selected="false">
						<span class="bi bi-columns-gap text-black"> Aplikasi</span>
					</button>
				</li>
				<li class="nav-item" role="presentation">
					<button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact-tab-pane" type="button" role="tab" aria-controls="contact-tab-pane" aria-selected="false">
						<span class="bi bi-info-circle text-black"> Tetang</span>
					</button>
				</li>
				<!-- <li class="nav-item" role="presentation">
				<button class="nav-link" id="disabled-tab" data-bs-toggle="tab" data-bs-target="#disabled-tab-pane" type="button" role="tab" aria-controls="disabled-tab-pane" aria-selected="false" disabled>Disabled</button>
			</li> -->
			</ul>
		<?php endif; ?>
	</div>
	<div class="tab-content" id="myTabContent">
		<div class="tab-pane fade show active" id="set-app-pane" role="tabpanel" aria-labelledby="set-app" tabindex="0">
			<?php include_once('content/setting_app.php') ?>
		</div>
		<div class="tab-pane fade" id="tampilan-tab-pane" role="tabpanel" aria-labelledby="tampilan-tab" tabindex="0">
			<div id="tampilan-content">Memuat...</div>
			<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
			<script>
				$(document).ready(function() {
					$('#tampilan-tab').on('click', function() {
						$('#tampilan-content').load('./page/content/setting_view.php');
					});
				});
			</script>
		</div>
		<div class="tab-pane fade" id="contact-tab-pane" role="tabpanel" aria-labelledby="contact-tab" tabindex="0">
			<div id="kontak">Memuat...</div>
			<script>
				$(document).ready(function() {
					$('#contact-tab').on('click', function() {
						$('#kontak').load('../config/author.php');
					});
				});
			</script>
		</div>
		<div class="tab-pane fade" id="disabled-tab-pane" role="tabpanel" aria-labelledby="disabled-tab" tabindex="0">Tahap Pengembangan</div>
	</div>
</div>