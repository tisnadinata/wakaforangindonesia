<script>
function cari(){		
	var value = $("#txtCari").val();
	var dataString = "cari_member="+value;
	$.ajax({
		type: "POST",
		url: "ajax.php",
		data: dataString,
		cache: false,
		success: function(html) {
			$("#daftar_member").html(html);
		}
	});
}
</script>
<article class="content dashboard-page">
	<div class="title-block">
		<h1 class="title">
			Data Lengkap Member
		</h1>
    </div>
	<section class="section">
	<?php
		if(isset($_GET['delete'])){
			memberDelete($_GET['delete']);
		}
		if(isset($_GET['acc'])){
			memberAcc($_GET['acc']);
		}
	?>
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-block">
				<?php
					if(isset($_GET['tipe'])){
						$_SESSION['tipe'] = $_GET['tipe'];
					}
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
							<?php
								if($_SESSION['tipe'] == "wakif"){
									echo"
										<th>ID</th>
										<th>Nama Lengkap</th>
										<th>Alamat Lengkap</th>
										<th>Telepon/E-Mail</th>
										<th>Saldo</th>
										<th>Verifikasi</th>
										<th></th>
									";
								}else if($_SESSION['tipe'] == "ae" OR $_SESSION['tipe'] == "ar"){
									echo"
										<th>Nama Lengkap</th>
										<th>Alamat Lengkap</th>
										<th>Telepon/E-Mail</th>
										<th>Saldo</th>
										<th>KTP</th>
										<th>VERIFIKASI</th>
										<th>PROFIL</th>
										<th></th>
									";
								}
							?>
						</tr>
						</thead>
						<tbody id="daftar_member">
							<?php								
								memberList("all");
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