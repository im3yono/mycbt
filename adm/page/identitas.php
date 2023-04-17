<style>
#pf{
	display: flex;
}
.iden{
	background-color: aqua;
}
</style>
<div class="container-fluid mb-5 p-0">
	<div class="row p-2 border-bottom fs-3 mb-4 shadow-sm ">Logo dan Data Identitas Ujian </div>
	<div class="row gap-3 justify-content-evenly mb-5">
		<div class="accordion" id="identitas">
			<div class="accordion-item">
				<h2 class="accordion-header">
					<button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
						Gambar dan Logo
					</button>
				</h2>
				<div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#identitas">
					<div class="accordion-body">
						<div class="col-12 text-center p-2 mb-4 fs-4">syarat ukuran harus gambar 1:1</div>
						<div class="row gap-3 justify-content-evenly ">
							<div class="card text-center" style="max-width: 200px;">
								<img src="../img/tut.png" class="" alt="..." style="height: 170px; width: 170px;">
								<div class="card-body">
									<h6 class="card-title">Logo Dinas</h6>
									<input class="form-control form-control-sm" id="formFileSm" type="file">
								</div>
							</div>
							<div class="card text-center" style="max-width: 200px;">
								<img src="../img/fav.png" class="card-img-top" alt="..." style="height: 170px; width: 170px;">
								<div class="card-body">
									<h6 class="card-title">Logo Instansi</h6>
									<input class="form-control form-control-sm" id="formFileSm" type="file">
								</div>
							</div>
							<div class="card text-center" style="max-width: 200px;">
								<img src="../img/header-bg.png" class="card-img-top" alt="..." style="height: 170px; width: 170px;">
								<div class="card-body">
									<h6 class="card-title">Login admin</h6>
									<input class="form-control form-control-sm" id="formFileSm" type="file">
								</div>
							</div>
							<div class="card text-center" style="max-width: 200px;">
								<img src="../img/swirl_pattern.png" class="card-img-top" alt="..." style="height: 170px; width: 170px;">
								<div class="card-body">
									<h6 class="card-title">Login Siswa</h6>
									<input class="form-control form-control-sm" id="formFileSm" type="file">
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="accordion-item">
				<h2 class="accordion-header">
					<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
						Id Instansi/Server
					</button>
				</h2>
				<div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#identitas">
					<div class="accordion-body">
						<form action="" method="post" enctype="multipart/form-data">
							<div class="row">
								<div class="mb-3 col-sm-4 col">
									<label for="idpt" class="form-label">Id Instansi/Server</label>
									<input type="text" class="form-control" id="idpt" name="idpt">
								</div>
								<div class="mb-3 col-sm-4 col">
									<label for="nmpt" class="form-label">Nama Instansi</label>
									<input type="text" class="form-control" id="nmpt" name="nmpt">
								</div>
								<div class="mb-3 col-sm-4 col">
									<label for="nmkpt" class="form-label">Pimpinan Instansi</label>
									<input type="text" class="form-control" id="nmkpt" name="nmkpt">
								</div>
								<div class="mb-3 col-sm-4 col">
									<label for="nmkpt" class="form-label">Ketua Ujian</label>
									<input type="text" class="form-control" id="nmkpt" name="nmkpt">
								</div>
								<div class="mb-3 col-sm-4 col">
									<label for="adm" class="form-label">Admin</label>
									<input type="text" class="form-control" id="adm" name="adm">
								</div>
							</div>
							<button type="submit" class="btn btn-primary">Submit</button>
						</form>
					</div>
				</div>
			</div>
			<!-- <div class="accordion-item">
				<h2 class="accordion-header">
					<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
						Accordion Item #3
					</button>
				</h2>
				<div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#identitas">
					<div class="accordion-body">
						<strong>This is the third item's accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
					</div>
				</div>
			</div> -->
		</div>
	</div>
</div>