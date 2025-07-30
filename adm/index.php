<?php
require_once('../config/server.php');

if ($db_null == 1 || $tbl_null == 1) {
	include_once('df.php');
} else {
	if ($inf_set['thm'] == "alte") {
		include_once('alte.php');
	} else {
		include_once('df.php');
	}
}

if ($_COOKIE['pass'] == 'admin' && $inf_set['pass'] == "on" ) { ?>
	<script>
		alert("Password 'admin' terlalu mudah di tebak. Silakan ganti password Anda.");
	</script>
<?php
}
