<?php 
require_once('../../../config/server.php');

$no		= 1;
$qr		= mysqli_query($koneksi,"SELECT * FROM `svr` WHERE id_sv != 0 ");
while ($data=mysqli_fetch_array($qr)) {
	$sts = $data['sts'];
	if ($sts=="Y") {
		$sts = "bi-unlock";
		$btn =  "btn-info";
	} else {
		$sts = "bi-lock";
		$btn =  "btn-danger";
	}
?>
<tr>
	<th><?= $no++; ?></th>
	<td><?= $data['idpt']; ?></td>
	<td><?= $data['nm_sv']; ?></td>
	<td><?= $data['ip_sv']; ?></td>
	<!-- <td><?= $data['sync']; ?></td>
	<td><?= $data['upload']; ?></td> -->
	<td>
		<button class="btn btn-sm <?= $btn; ?> fs-6 mb-1" onclick="lockSts('<?= $data['id_sv']; ?>')" id="btn_sts<?= $data['id_sv']; ?>">
			<i class="bi <?= $sts; ?>" id="icn_sts<?= $data['id_sv']; ?>"></i>
		</button>
		<button class="btn btn-sm btn-secondary fs-6 mb-1" onclick="editClient('<?= $data['id_sv']; ?>','<?= $data['idpt']; ?>','<?= $data['nm_sv']; ?>','<?= $data['ip_sv']; ?>')">
			<i class="bi bi-gear"></i>
		</button>
		<button class="btn btn-sm btn-outline-danger fs-6 mb-1" onclick="delClient('<?= $data['idpt']; ?>')">
			<i class="bi bi-trash3"></i>
		</button>
	</td>
</tr>
<?php } ?>