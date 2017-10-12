<script>
function cari(){		
	var value = $("#txtCari").val();
	var dataString = "cari_admin="+value;
	$.ajax({
		type: "POST",
		url: "ajax.php",
		data: dataString,
		cache: false,
		success: function(html) {
			$("#daftar_admin").html(html);
		}
	});
}
</script>
<article class="content dashboard-page">
	<div class="title-block">
		<h1 class="title">
			Data Tim / Admin
		</h1>
    </div>
	<section class="section">
	<?php
		if(isset($_GET['delete'])){
			adminDelete($_GET['delete']);
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
					<div class="form-group row">
						<label class="col-xs-3 col-md-1 col-md-offset-7 form-control-label">Cari :</label>
						<div class="col-xs-9 col-md-4">
							<input type="text" class="form-control" id="txtCari"  onInput="cari()" placeholder="Cari berdasarkan nama">
						</div>
					</div>					
					<section class="example">
					<div class="table-flip-scroll table-responsive">
						<table class="table table-striped table-bordered table-hover flip-content">
						<thead class="flip-header">
						<tr>
							<th>ID</th>
							<th>Nama Lengkap</th>
							<th>Jabatan</th>
							<th>Telepon</th>
							<th>E-Mail</th>
							<th>TIPE</th>
							<th></th>
						</tr>
						</thead>
						<tbody id="daftar_admin">
							<?php								
								adminList("all");
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