<?php
error_reporting(0); //hide error

if ($_GET['ed'] == "hapus") {
?>
	<script>
		Swal.fire({
			title: 'Are you sure?',
			text: "You won't be able to revert this!",
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Yes, delete it!'
		}).then((result) => {
			if (result.isConfirmed) {
				<?php

				?>
				Swal.fire(
					'Deleted!',
					'Your file has been deleted.',
					'success'
				)
			}
		})
	</script>
<?php
}

if ($_GET['ed'] == "add") {

?>
	<script>
		Swal.fire(
			'Tambah Data Berhasil',
			'Data berhasil di simpan',
			'success'
		)
	</script>
<?php
}
if ($_GET['ed'] == "edit") {

?>
	<script>
		Swal.fire(
			'Ruah Data Berhasil',
			'Data berhasil di Rubah',
			'success'
		)
	</script>
<?php
}
?>

<style>
	#adm {
		display: flow-root;
	}

	.sis {
		background-color: aqua;
	}
</style>

<div class="container-fluid mb-5 p-0">
	<div class="row p-2 border-bottom fs-3 mb-4 shadow-sm ">Daftar Peserta Ujian</div>
	<div class="row mb-3 mx-2">
		<div class="col-auto"><button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#tambah"><i class="bi bi-person-plus"></i> Tambah Peserta</button></div>
	</div>
	<div class="col table-responsive">
		<table class="table table-hover table-striped table-bordered">
			<thead class="table-info text-center align-baseline">
				<tr>
					<th style="width: 5%;">No.</th>
					<th style="width: 15%;">No Peserta/ NIS/NISN/ NIK</th>
					<th style="width: 15%;">Nama Peserta</th>
					<th style="width: 20%;">Kelas/ Jurusan/ Ruangan</th>
					<th style="width: 10%;">Status</th>
					<th style="width: 10%;">Edit | hapus</th>
				</tr>
			</thead>
			<tbody>
				<tr class="text-center">
					<th>1</th>
					<td class="fw-semibold">Mark</td>
					<td class="fw-semibold">Otto</td>
					<td class="fw-semibold">@mdo</td>
					<td>
						<button class="btn btn-sm btn-primary">Aktif</button>
						<button class="btn btn-sm btn-danger">Nonaktif</button>
					</td>
					<td>
						<button class="btn btn-sm fs-6 btn-warning" type="button" data-bs-toggle="modal" data-bs-target="#Edit"><i class="bi bi-pencil-square"></i></button> |
						<a href="?md=sis&ed=hapus" class="btn btn-sm fs-6 btn-danger"><i class="bi bi-trash3"></i></a>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
	<nav aria-label="Page navigation example">
		<ul class="pagination justify-content-end pagination-sm">
			<li class="page-item disabled">
				<a class="page-link">Previous</a>
			</li>
			<li class="page-item"><a class="page-link" href="#">1</a></li>
			<li class="page-item"><a class="page-link" href="#">2</a></li>
			<li class="page-item"><a class="page-link" href="#">3</a></li>
			<li class="page-item">
				<a class="page-link" href="#">Next</a>
			</li>
		</ul>
	</nav>
</div>


<!-- === Modal === -->
<!-- === Edit === -->
<div class="modal fade" id="Edit" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="EditLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h1 class="modal-title fs-5" id="EditLabel">Rubah Data User</h1>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<form action="" method="post">
				<div class="modal-body">
					Lorem ipsum, dolor sit amet consectetur adipisicing elit. Est reprehenderit veniam, iste sint neque ullam, ad aliquid explicabo aspernatur laborum quae dolor asperiores! Sunt tempora, beatae quis delectus molestiae ratione?
				</div>
				<div class="modal-footer">
					<a href="?md=sis&ed=edit" type="button" class="btn btn-primary" id="Edit" name="Edit">Simpan</a>
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
				</div>
			</form>
		</div>
	</div>
</div>

<!-- === Tambah === -->
<div class="modal fade" id="tambah" tabindex="-1" aria-labelledby="tambahLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h1 class="modal-title fs-5" id="tambahLabel">Tambah User</h1>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<form action="" method="post">
				<div class="modal-body">
					Lorem ipsum dolor sit amet consectetur adipisicing elit. Adipisci ipsam rerum dolorem fugit nam, provident quasi eum quas assumenda minus quia eligendi amet repellendus animi in ex placeat, quos minima?
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
					<a href="?md=sis&ed=add" type="button" class="btn btn-primary" id="tambah" name="tambah">Tambah</a>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- === Akhir Modal === -->
<script>

</script>

<script>

</script>