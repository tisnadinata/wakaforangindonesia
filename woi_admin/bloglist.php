<script>
function cari(){		
	var value = $("#txtCari").val();
	var tipe = $("#tipe_posting").val();
	var dataString = "cari_posting="+value+"&tipe_posting="+tipe;
	$.ajax({
		type: "POST",
		url: "ajax.php",
		data: dataString,
		cache: false,
		success: function(html) {
			$("#daftar_posting").html(html);
		}
	});
}
</script>
<article class="content dashboard-page">
	<div class="title-block">
		<h1 class="title">
			Data Posting Blog
			<?php 
				$_SESSION['sub'] = $_GET['sub'];
				if(isset($_GET['sub'])){
					echo ucfirst(str_replace("_"," ",($_GET['sub'])));
				}
			?>
		</h1>
    </div>
	<section class="section">
	<?php
		if(isset($_GET['delete'])){
			blogDelete($_GET['delete']);
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
					if(isset($_GET['edit'])){
						blogEdit($_GET['edit']);
					}else{
				?>
					<!--	LIST CUSTOMER -->
					<div class="form-group row">
						<label class="col-xs-3 col-md-1 col-md-offset-7 form-control-label">Cari :</label>
						<div class="col-xs-9 col-md-4">
							<input type="text" class="form-control" id="txtCari"  onInput="cari()" placeholder="Cari berdasarkan judul post">
						</div>
					</div>					
					<section class="example">
					<div class="table-flip-scroll table-responsive">
						<table class="table table-striped table-bordered table-hover flip-content">
						<thead class="flip-header">
						<tr>
							<th>ID</th>
							<th>Pembuat Post</th>
							<th>Pemateri Post</th>
							<th>Judul Posting</th>
							<th>Tanggal Posting</th>
							<th>Tag Post</th>
							<th></th>
						</tr>
						</thead>
						<input type="hidden" value="<?php echo $_GET['sub'];?>" id="tipe_posting">
						<tbody id="daftar_posting">
						<?php
							blogList("all",$_GET['sub']);
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