<script>
function cari(){		
	var value = $("#txtCari").val();
	var dataString = "cari_proyek="+value;
	$.ajax({
		type: "POST",
		url: "ajax.php",
		data: dataString,
		cache: false,
		success: function(html) {
			$("#daftar_proyek").html(html);
		}
	});
}
</script>
<article class="content dashboard-page">
	<div class="title-block">
		<h1 class="title col-md-4">
			Data Proyek Wakaf
			<?php 
				if(isset($_GET['sub'])){
					echo ucfirst(str_replace("_"," ",($_GET['sub'])));
				}
			?>
		</h1>
		<span class="col-xs-12 col-md-1">&nbsp </span>
		<a href="?page=proyek&reset=<?php echo $_GET['sub'];?>" onclick="return confirm('Yakin ingin menghapus semua data disini ?');">
			<button class="btn btn-danger col-xs-12 col-md-3 col-md-offset-4">KOSONGKAN DATA PROYEK</button>
		</a>
    </div>
	<section class="section">
	<?php
		if(isset($_GET['set'])){
			proyekSet($_GET['set']);
		}else if(isset($_GET['delete'])){
			proyekDelete($_GET['delete']);
		}else if(isset($_GET['reset'])){
			proyekDeleteAll($_GET['reset']);
		}
		if(isset($_GET['favorit'])){
			$stmt = $mysqli->query("UPDATE tbl_wakaf_proyek SET favorit=((favorit-1)*-1) WHERE id_wakaf_proyek=".$_GET['favorit']." ");
			if($stmt){
			echo '		
				<div class="divider divider--xs"></div>
				<div class="alert alert-success" role="alert" align="center">
					Berhasil mengubah stus proyek favorit.
				</div>
			';			
			}else{
			echo '		
				<div class="divider divider--xs"></div>
				<div class="alert alert-danger" role="alert" align="center">
					Gagal mengubah stus proyek favorit.
				</div>
			';			
			}			
		}
	?>
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-block">
				<?php
					if(isset($_GET['sub'])){
						$page = str_replace("_"," ",$_GET['sub']);
					}else{
						$page = "all";
					}
					$_SESSION['proyek'] = $page;
				?>
					<!--	LIST CUSTOMER -->
					<div class="form-group row">
						<div class="col-md-5">
						<b>Keterangan :</b><br>
						<span class="fa fa-star"></span> : Proyek wakaf favorit
						</div>
						<label class="col-xs-3 col-md-1 col-md-offset-2 form-control-label">Cari :</label>
						<div class="col-xs-9 col-md-4">
							<input type="text" class="form-control" id="txtCari"  onInput="cari()" placeholder="Cari berdasarkan nama pemilik proyek">
						</div>
					</div>					
					<section class="example">
					<div class="table-flip-scroll table-responsive">
						<table class="table table-striped table-bordered table-hover flip-content">
						<thead class="flip-header">
						<tr>
							<th>ID</th>
							<th>Nama Proyek</th>
							<th>Pemilik Proyek</th>
							<th>Target proyek</th>
							<th>Dana Terkumpul</th>
							<th>Tanggal Mulai</th>
							<th>Tanggal Selesai</th>
							<th></th>
						</tr>
						</thead>
						<tbody id="daftar_proyek">
						<?php
							if($page == "pending"){								
								proyekList("pending","all");
							}else if($page == "proses"){
								proyekList("proses","all");
							}else if($page == "done"){
								proyekList("done","all");
							}else if($page == "fail"){
								proyekList("fail","all");
							}else{
								proyekList("all","all");
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