<article class="content dashboard-page">
	<div class="title-block">
		<h1 class="title">
			Data Program Wakaf
		</h1>
    </div>
	<section class="section">
	<?php
		if(isset($_GET['delete'])){
			komunitasDelete($_GET['delete']);
		}
		if(isset($_GET['set'])){
			komunitasSet($_GET['set']);
		}
		if(isset($_POST['btnTambahKomunitas'])){
			komunitasTambah();
		}
		if(isset($_POST['btnEditKomunitas'])){
			komunitasEdit();
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
					<form action="" method="post" enctype="multipart/form-data">
						<div class="form-group row">
							<div class="col-xs-12 col-md-5">
								<label class="form-control-label">Nama Komunitas</label>
								<input type="text" class="form-control" name="nama_komunitas" placeholder="Nama Komunitas">
							</div>
							<div class="col-xs-12 col-md-7">
								<label class="form-control-label">Deskripsi</label>
								<input type="text" class="form-control" name="deskripsi_komunitas" placeholder="Deskripsi Komunitas">
							</div>
							<div class="col-xs-12 col-md-5">
								<label class="form-control-label">Kategori Komunitas</label>
								<select class="form-control" name="txtkomunitas" required>
								<?php
									$i=0;
									$stmt = $mysqli->query("SELECT * from tbl_kategori_wakaf ORDER BY tipe_kategori");
									while($data = $stmt->fetch_object()){
										echo '
											<option value='.$data->id_kategori_wakaf.'>'.$data->nama_kategori.'</option>
										';
									}
								?>
								</select>
							</div>
							<div class="col-xs-12 col-md-4">
								<label class="form-control-label">Logo/Foto Komunitas</label>
								<input type="file" class="form-control" name="file_foto">
							</div>
							<div class="col-xs-12 col-md-1">
								<label class="form-control-label">&nbsp  </label>
								<button type="submit" name="btnTambahKomunitas" class="btn btn-primary" >BUAT KOMUNITAS</button>
							</div>
						</div>		
					</form>
				<?php
					}else{
						$stmt = $mysqli->query("SELECT * FROM tbl_komunitas where id_komunitas=".$_GET['edit']."");
						$data = $stmt->fetch_object();
						echo'
							<form action="" method="post">
								<div class="form-group row">
									<div class="col-xs-12 col-md-3">
										<label class="form-control-label">Kategori Komunitas</label>
										<select class="form-control" name="txtkomunitas" required>
										';
											$i=0;
											$stmt = $mysqli->query("SELECT * from tbl_kategori_wakaf ORDER BY tipe_kategori");
											while($data_kategori = $stmt->fetch_object()){
												echo '
													<option value='.$data_kategori->id_kategori_wakaf.'>'.$data_kategori->nama_kategori.'</option>
												';
											}
										echo'
										</select>
									</div>
									<div class="col-xs-12 col-md-3">
										<label class="form-control-label">Nama Komunitas</label>
										<input type="text" class="form-control" name="nama_komunitas" placeholder="Nama Komunitas" value="'.$data->nama_komunitas.'">
									</div>
									<div class="col-xs-12 col-md-4">
										<label class="form-control-label">Deskripsi(75 karakter)</label>
										<input type="text" class="form-control" name="deskripsi_komunitas" placeholder="Deskripsi Komunitas" value="'.$data->deskripsi_komunitas.'">
									</div>
									<div class="col-xs-12 col-md-1">
										<label class="form-control-label">&nbsp  </label>
										<button type="submit" name="btnEditKomunitas" class="btn btn-info" >SIMPAN</button>
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
							<th>Kategori Komunitas</th>
							<th>Nama Komunitas</th>
							<th>Deskripsi Komunitas</th>
							<th width="13%"></th>
						</tr>
						</thead>
						<tbody id="daftar_member">
							<?php
								if(isset($_GET['tipe'])){
									if($_GET['tipe']=="pending"){
										komunitasList("pending");
									}else if($_GET['tipe']=="fail"){
										komunitasList("fail");
									}
								}else{
									komunitasList("all");
								}
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