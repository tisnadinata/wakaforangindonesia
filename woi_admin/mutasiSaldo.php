<script>
function cari(){		
	var value = $("#txtCari").val();
	var dataString = "cari_mutasi="+value;
	$.ajax({
		type: "POST",
		url: "ajax.php",
		data: dataString,
		cache: false,
		success: function(html) {
			$("#daftar_mutasi").html(html);
		}
	});
}
</script>
<article class="content dashboard-page">
	<div class="title-block">
		<h1 class="title col-md-4">
			Riwayat Mutasi Member
		</h1>
		<span class="col-xs-12 col-md-1">&nbsp </span>
		<a href="?page=mutasi-saldo&delete=all" onclick="return confirm('Yakin ingin menghapus semua data riwayat mutasi saldo ?');">
			<button class="btn btn-danger col-xs-12 col-md-3 col-md-offset-4">KOSONGKAN DATA MUTASI</button>
		</a>
    </div>
	<section class="section">
	<?php
		if(isset($_GET['delete'])){
			mutasiSaldoDelete($_GET['delete']);
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
							<th>Nama Member</th>
							<th>Jumlah Mutasi</th>
							<th>Deskripsi Mutasi</th>
							<th>Tanggal Mutasi</th>
							<th>Status Mutasi</th>
						</tr>
						</thead>
						<tbody id="daftar_mutasi">
							<?php
								mutasiSaldo("all");
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
	</section>
</article>