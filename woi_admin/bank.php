<script>
function cari(){		
	var value = $("#txtCari").val();
	var dataString = "cari_bank="+value;
	$.ajax({
		type: "POST",
		url: "ajax.php",
		data: dataString,
		cache: false,
		success: function(html) {
			$("#daftar_bank").html(html);
		}
	});
}
</script>
<article class="content dashboard-page">
	<div class="title-block">
		<h1 class="title">
			Data Akun Bank
			<?php 
				if(isset($_GET['sub'])){
					echo ucfirst(str_replace("_"," ",($_GET['sub'])));
				}
			?>
		</h1>
    </div>
	<section class="section">
	<?php
		if(isset($_GET['set'])){
			bankSet($_GET['set']);
		}else if(isset($_GET['delete'])){
			bankDelete($_GET['delete']);
		} 
		if(isset($_POST['btnTambahBank'])){
			bankTambah();
		}
		if(isset($_POST['btnEditBank'])){
			bankEdit();
		}
	?>
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-block">
				<?php
					if(isset($_GET['tipe'])){
						$page = str_replace("_"," ",$_GET['tipe']);
					}else{
						$page = "all";
					}
					$_SESSION['bank'] = $page;
				?>
					<!--	LIST CUSTOMER
					<div class="form-group row">
						<label class="col-xs-3 col-md-1 col-md-offset-7 form-control-label">Cari :</label>
						<div class="col-xs-9 col-md-4">
							<input type="text" class="form-control" id="txtCari"  onInput="cari()" placeholder="Cari berdasarkan nama peminjam">
						</div>
					</div>			 -->	
				<?php
					if($page == "admin"){
						if(!isset($_GET['edit'])){
				?>
						<form action="" method="post">
							<div class="form-group row">
								<div class="col-xs-12 col-md-3">
									<label class="form-control-label">Nama Bank</label>
									<input type="text" class="form-control" name="nama_bank"  placeholder="BANK WOI">
								</div>
								<div class="col-xs-12 col-md-4">
									<label class="form-control-label">Atas Nama</label>
									<input type="text" class="form-control" name="atas_nama" placeholder="Nama Pemilik">
								</div>
								<div class="col-xs-12 col-md-3">
									<label class="form-control-label">Nomor Rekening</label>
									<input type="text" class="form-control" name="rekening_bank"  placeholder="Nomor Rekening">
								</div>
								<div class="col-xs-12 col-md-1">
									<label class="form-control-label">&nbsp  </label>
									<button type="submit" name="btnTambahBank" class="btn btn-primary" >TAMBAH</button>
								</div>
							</div>		
						</form>
				<?php
						}else{
							$stmt = $mysqli->query("SELECT * FROM tbl_bank where id_bank=".$_GET['edit']."");
							$data = $stmt->fetch_object();
							echo'
								<form action="" method="post">
									<div class="form-group row">
										<div class="col-xs-12 col-md-3">
											<label class="form-control-label">Nama Bank</label>
											<input type="text" class="form-control" name="nama_bank"  placeholder="BANK WOI" value="'.$data->nama_bank.'">
										</div>
										<div class="col-xs-12 col-md-4">
											<label class="form-control-label">Atas Nama</label>
											<input type="text" class="form-control" name="atas_nama" placeholder="Nama Pemilik" value="'.$data->atas_nama.'">
										</div>
										<div class="col-xs-12 col-md-3">
											<label class="form-control-label">Nomor Rekening</label>
											<input type="text" class="form-control" name="rekening_bank"  placeholder="Nomor Rekening" value="'.$data->rekening_bank.'">
										</div>
										<div class="col-xs-12 col-md-1">
											<label class="form-control-label">&nbsp  </label>
											<button type="submit" name="btnEditBank" class="btn btn-primary" >SIMPAN</button>
										</div>
									</div>		
								</form>
							';
							
						}
					}
				?>					
					<section class="example">
					<div class="table-flip-scroll table-responsive">
						<table class="table table-striped table-bordered table-hover flip-content">
						<thead class="flip-header">
						<tr>
							<th>Nama Member</th>
							<th>Nama Bank</th>
							<th>Pemilik</th>
							<th>Nomor Rekening</th>
							<th>Status Bank</th>
							<th></th>
						</tr>
						</thead>
						<tbody id="daftar_bank">
				<?php
					if($page == "admin"){
						bankList("admin");
					}else if($page == "member"){
						bankList("wakif");
					}else{
						bankList("all");
					} 
				?>
						</tbody>
						</table>
					</div>
					</section>
				</div>
			</div>
		</div>
	</div>
	</section>
</article>