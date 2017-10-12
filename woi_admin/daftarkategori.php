<article class="content dashboard-page">
	<div class="title-block">
		<h1 class="title">
			Data Program Wakaf
		</h1>
    </div>
	<section class="section">
	<?php
		if(isset($_GET['delete'])){
			kategoriDelete($_GET['delete']);
		}
		if(isset($_POST['btnTambahKategori'])){
			kategoriTambah();
		}
		if(isset($_POST['btnEditKategori'])){
			kategoriEdit();
		}
	?>
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-block">
				<?php
					if(!isset($_GET['detail'])){
				?>
					<!--	LIST CUSTOMER -->
				<?php
					if(!isset($_GET['edit'])){
				?>
					<form action="" method="post">
						<div class="form-group row">
							<div class="col-xs-12 col-md-3">
								<label class="form-control-label">Tag Kategori/Program</label>
								<input type="text" class="form-control" name="tag_program"  placeholder="Tag Program">
							</div>
							<div class="col-xs-12 col-md-5">
								<label class="form-control-label">Nama Kategori/Program Wakaf</label>
								<input type="text" class="form-control" name="nama_program" placeholder="Nama Program Wakaf">
							</div>
							<div class="col-xs-12 col-md-2">
								<label class="form-control-label">Tipe</label>
								<input type="text" class="form-control" name="tipe_program"  placeholder="program/tausyiah">
							</div>
							<div class="col-xs-12 col-md-1">
								<label class="form-control-label">&nbsp  </label>
								<button type="submit" name="btnTambahKategori" class="btn btn-primary" >TAMBAH</button>
							</div>
						</div>		
					</form>
				<?php
					}else{
						$stmt = $mysqli->query("SELECT * FROM tbl_kategori_wakaf where id_kategori_wakaf=".$_GET['edit']."");
						$data = $stmt->fetch_object();
						echo'
							<form action="" method="post">
								<div class="form-group row">
									<div class="col-xs-12 col-md-3">
										<label class="form-control-label">Tag Program</label>
										<input type="text" class="form-control" name="tag_program"  placeholder="Tag Program" value="'.$data->nama_kategori.'">
									</div>
									<div class="col-xs-12 col-md-5">
										<label class="form-control-label">Nama Program Wakaf</label>
										<input type="text" class="form-control" name="nama_program"  placeholder="Nama Program Wakaf" value="'.$data->deskripsi_kategori.'">
									</div>
									<div class="col-xs-12 col-md-2">
										<label class="form-control-label">Tipe</label>
										<input type="text" class="form-control" name="tipe_program"  placeholder="Nama Program Wakaf" value="'.$data->tipe_kategori.'">
									</div>
									<div class="col-xs-12 col-md-1">
										<label class="form-control-label">&nbsp  </label>
										<button type="submit" name="btnEditKategori" class="btn btn-info" >SIMPAN</button>
									</div>
								</div>		
							</form>
						';
						
					}
				?>
					<hr>
					<section class="example">
					<div class="table-flip-scroll table-responsive">
						<table class="table table-striped table-bordered table-hover flip-content">
						<thead class="flip-header">
						<tr>
							<th>ID</th>
							<th>Tag Kategori/Program</th>
							<th>Nama Kategori/Program Wakaf</th>
							<th>Tipe</th>
							<th width="13%"></th>
						</tr>
						</thead>
						<tbody id="daftar_member">
							<?php
								kategoriList("all");
							?>
						</tbody>
						</table>
					</div>
					</section>
				<?php		
					}
				?>
				</div>
			</div>
		</div>
	</div>
	</section>
</article>