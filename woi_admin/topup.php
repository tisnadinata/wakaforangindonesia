<script>
function cari(){		
	var value = $("#txtCari").val();
	var dataString = "cari_pencairan="+value;
	$.ajax({
		type: "POST",
		url: "ajax.php",
		data: dataString,
		cache: false,
		success: function(html) {
			$("#daftar_pencairan").html(html);
		}
	});
}
</script>
<article class="content dashboard-page">
	<div class="title-block">
		<h1 class="title col-md-4">
			Data Top Up
			<?php 
				if(isset($_GET['sub'])){
					echo ucfirst(str_replace("_"," ",($_GET['sub'])));
				}
			?>
		</h1>
		<span class="col-xs-12 col-md-1">&nbsp </span>
		<a href="?page=pencairan&reset=<?php echo $_GET['sub'];?>" onclick="return confirm('Yakin ingin menghapus semua data disini ?');">
			<button class="btn btn-danger col-xs-12 col-md-3 col-md-offset-4">KOSONGKAN DATA TOP UP</button>
		</a>
    </div>
	<section class="section">
	<?php
		if(isset($_GET['set'])){
			topupSet($_GET['set']);
		}else if(isset($_GET['delete'])){
			topupDelete($_GET['delete']);
		}else if(isset($_GET['reset'])){
			topupDeleteAll($_GET['reset']);
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
					$_SESSION['pencairan'] = $page;
				?>
					<!--	LIST CUSTOMER -->
					<div class="form-group row">
						<label class="col-xs-3 col-md-1 col-md-offset-7 form-control-label">Cari :</label>
						<div class="col-xs-9 col-md-4">
							<input type="text" class="form-control" id="txtCari"  onInput="cari()" placeholder="Cari berdasarkan nama peminjam">
						</div>
					</div>					
					<section class="example">
					<div class="table-flip-scroll table-responsive">
						<table class="table table-striped table-bordered table-hover flip-content">
						<thead class="flip-header">
						<tr>
							<th>ID</th>
							<th>Nama Member</th>
							<th>Jumlah Topup</th>
							<th>Kode TopUp</th>
							<th>Metode Pembayaran</th>
							<th></th>
						</tr>
						</thead>
						<tbody id="daftar_pencairan">
						<?php
							if($page == "pending"){								
								topupList("pending","all");
							}else if($page == "proses"){
								topupList("proses","all");
							}else if($page == "done"){
								topupList("done","all");
							}else if($page == "fail"){
								topupList("fail","all");
							}else{
								topupList("all","all");
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