<script>
function cari(){		
	var value = $("#txtCari").val();
	var dataString = "cari_donasi="+value;
	$.ajax({
		type: "POST",
		url: "ajax.php",
		data: dataString,
		cache: false,
		success: function(html) {
			$("#daftar_donasi").html(html);
		}
	});
}
</script>
<article class="content dashboard-page">
	<div class="title-block">
		<h1 class="title col-md-4">
			Data Donasi Wakaf  
			<?php 
				if(isset($_GET['sub'])){
					echo ucfirst(str_replace("_"," ",($_GET['sub'])));
				}
			?>
		</h1>
		<span class="col-xs-12 col-md-1">&nbsp </span>
		<a href="?page=donasi-wakaf&reset=<?php echo $_GET['sub'];?>" onclick="return confirm('Yakin ingin menghapus semua data disini ?');">
			<button class="btn btn-danger col-xs-12 col-md-3 col-md-offset-4">KOSONGKAN DATA DONASI</button>
		</a>
    </div>
	<section class="section">
	<?php
		if(isset($_GET['set'])){
			donasiSet($_GET['set']);
		}else if(isset($_GET['delete'])){
			donasiDelete($_GET['delete']);
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
					$_SESSION['donasi'] = $page;
				?>
					<!--	LIST CUSTOMER -->
					<div class="form-group row">
						<label class="col-xs-3 col-md-1 col-md-offset-7 form-control-label">Cari :</label>
						<div class="col-xs-9 col-md-4">
							<input type="text" class="form-control" id="txtCari"  onInput="cari()" placeholder="Cari berdasarkan nama proyek">
						</div>
					</div>					
					<section class="example">
					<div class="table-flip-scroll table-responsive">
						<table class="table table-striped table-bordered table-hover flip-content">
						<thead class="flip-header">
						<tr>
							<th>Nama Proyek Wakaf</th>
							<th>Nama Wakif</th>
							<th>Jumlah Wakaf</th>
							<th>Kode Wakaf</th>
							<th>Metode Pembayaran</th>
							<th>Status Reward</th>
							<th>Status Baju</th>
							<th></th>
						</tr>
						</thead>
						<tbody id="daftar_donasi">
				<?php
					if($page == "pending"){
						donasiList("pending","all");
					}else if($page == "done"){
						donasiList("done","all");
					}else if($page == "fail"){
						donasiList("fail","all");
					}else{
						donasiList("all","all");
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