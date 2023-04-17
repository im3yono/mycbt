<style>
	#pf {
		display: flex;
	}

	.usr {
		background-color: aqua;
		z-index: 2;
	}
</style>

<div class="container-fluid mb-5 p-0">
	<div class="row p-2 border-bottom fs-3 mb-4 shadow-sm ">Managemen User</div>
	<div class="row mb-3 mx-2">
		<div class="col-auto"><button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#tambah"><i class="bi bi-person-plus"></i> Tambah User</button></div>
	</div>
	<div class="col table-responsive">
		<table class="table table-hover table-striped table-bordered">
			<thead class="table-info text-center">
				<tr>
					<th style="width: 5%;">No.</th>
					<th style="width: 15%;">Nama</th>
					<th style="width: 15%;">Username</th>
					<th style="width: 20%;">No Telepon</th>
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
						<button class="btn btn-sm fs-6 btn-danger"><i class="bi bi-trash3"></i></button>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>


<!-- === Modal === -->
<!-- === Tambah === -->
<!-- === Edit === -->
<!-- Button trigger modal -->
<!-- Modal -->
<div class="modal fade" id="Edit" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="EditLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="EditLabel">Rubah User</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary">Simpan</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="tambah" tabindex="-1" aria-labelledby="tambahLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="tambahLabel">Tambah User</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary">Tambah</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
      </div>
    </div>
  </div>
</div>