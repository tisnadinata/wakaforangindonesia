<script language='javascript'>
function tandaPemisahTitik(){
	$('#txtTargetProyek').maskMoney({prefix:'Rp. ', thousands:'.', decimal:',', precision:0});
}
</script>
<article class="content item-editor-page">
<div class="title-block">
	<h3 class="title">Buat Proyek Wakaf Baru<span class="sparkline bar" data-type="bar"></span></h3>
</div>
	<?php
	$program_proyek = '';
	$nama_proyek = '';
	$headline_proyek = '';
	$deskripsi_proyek = '';
	$target_dana = '';
	$tanggal_akhir = '';
	
	if(isset($_POST['btnWakafBaru'])){
		proyekWakafBaru();
	}
	if(isset($_GET['edit'])){
		$stmt = $mysqli->query("select * from tbl_wakaf_proyek where id_wakaf_proyek=".$_GET['edit']."");
		if($stmt->num_rows > 0){
			$data_proyek = $stmt->fetch_object();
			$program_proyek = $data_proyek->id_kategori_wakaf;
			$nama_proyek =  $data_proyek->nama_proyek;
			$headline_proyek =  $data_proyek->headline_proyek;
			$deskripsi_proyek =  $data_proyek->deskripsi_proyek;
			$target_dana =  $data_proyek->target_dana;
			$tanggal_akhir =  $data_proyek->tanggal_akhir;
			$url_foto =  $data_proyek->url_foto;
			$url_video =  $data_proyek->url_video;
			
		}else{
			echo '		
				<div class="divider divider--xs"></div>
				<div class="alert alert-danger" role="alert" align="center">
					Data tidak ditemukan.
				</div>
			';			
		}
		if(isset($_POST['btnEditProyek'])){
			proyekEdit();
		}
	?>
		<form name="item" action="" method="post" enctype="multipart/form-data">
				  <input value="<?php echo $nama_proyek;?>" type="hidden" name="txtNamaProyekLast">
				  <input value="<?php echo $url_foto;?>" type="hidden" name="url_foto">
				  <input value="<?php echo $deskripsi_proyek;?>" type="hidden" name="txtDeskripsiProyekLast">
			<div class="card card-block">
				<div class="col-md-12">
					<label class="col-md-2"><b>Program Proyek : &nbsp </b></label>
					<div class="col-md-10">
					  <select class="form-control" name="txtKategoriProyek">
						<?php
							$stmt = $mysqli->query("SELECT * from tbl_kategori_wakaf where tipe_kategori='program'");
							while($data = $stmt->fetch_object()){
								if($program_proyek == $data->id_kategori_wakaf){
									echo "<option value='".$data->id_kategori_wakaf."|".$data->nama_kategori."' selected>".$data->deskripsi_kategori."</option>";
								}else{
									echo "<option value='".$data->id_kategori_wakaf."|".$data->nama_kategori."'>".$data->deskripsi_kategori."</option>";
								}
							}
						?>
					  </select>
					</div>
				</div>
				<div class="col-md-12">	&nbsp </div>
				<div class="col-md-12">
					<label class="col-md-2"><b>Nama Proyek : &nbsp </b></label>
					<div class="col-md-10">
					  <input value="<?php echo $nama_proyek;?>" type="text" name="txtNamaProyek" class="form-control" placeholder="nama proyek anda" style="width:100%;" required>
					</div>
				</div>
				<div class="col-md-12">	&nbsp </div>
				<div class="col-md-12">
					<label class="col-md-2"><b>Headline Proyek : &nbsp </b></label>
					<div class="col-md-10">
						<textarea class="form-control" rows="3" name="txtHeadlineProyek" id="comment"> <?php echo $headline_proyek;?></textarea>
					</div>
				</div>
				<div class="col-md-12">
					<label class="col-md-2"><b>Deskripsi Proyek : &nbsp </b></label>
					<div class="col-md-10">
						<textarea name="txtDeskripsiProyek" class="ckeditor"  required><?php echo $deskripsi_proyek;?></textarea>
					</div>
				</div>
				<div class="col-md-12">	&nbsp </div>
				<div class="col-md-12">
					<label class="col-md-2"><b>URL Video : &nbsp </b></label>
					<div class="col-md-10">
					  <input type="text"value='<?php echo $url_video;?>'  name="txtVideo" class="form-control" placeholder="Masukan kode embed video dari youtube" style="width:100%;">
					</div>
				</div>
				<div class="col-md-12">	&nbsp </div>				
				<div class="col-md-12">
					<label class="col-md-2"><b>Target Dana (Rp) :</b></label>
					<div class="col-md-7">
						<input type="text" value="<?php echo $target_dana;?>" name="txtTargetProyek" id="txtTargetProyek" onInput="tandaPemisahTitik()" class="form-control" placeholder="target uang terkumpul" required>
					</div>			
				</div>
				<div class="col-md-12">
				<br>
					<label class="col-md-2"><b>Tanggal Berakhir</b></label>
					<div class="col-md-4">
						<input type="date" name="txtBerakhirProyek" class="form-control" placeholder="tanggal berakhir proyek">
					</div>
					<b>*Format tanggal 31/12/2016</b>
				</div>
				<div class="col-md-12">	&nbsp </div>
				<div style="text-align:right;">
					<hr>	
					<input type="submit" name="btnEditProyek" class="btn btn-primary" value="Edit Proyek Wakaf">
				</div>
			</div>
		</form>
	<?php
	}else{
	?>
		
<form name="item" action="" method="post" enctype="multipart/form-data">
	<div class="card card-block">
		<div class="col-md-12">
			<label class="col-md-2"><b>Program Proyek : &nbsp </b></label>
			<div class="col-md-10">
			  <select class="form-control" name="txtKategoriProyek">
				<?php
					$stmt = $mysqli->query("SELECT * from tbl_kategori_wakaf where tipe_kategori='program'");
					while($data = $stmt->fetch_object()){
						echo "<option value='".$data->id_kategori_wakaf."|".$data->nama_kategori."'>".$data->deskripsi_kategori."</option>";
					}
				?>
			  </select>
			</div>
		</div>
		<div class="col-md-12">	&nbsp </div>
		<div class="col-md-12">
			<label class="col-md-2"><b>Nama Proyek : &nbsp </b></label>
			<div class="col-md-10">
			  <input type="text" name="txtNamaProyek" class="form-control" placeholder="nama proyek anda" style="width:100%;" required>
			</div>
		</div>
		<div class="col-md-12">	&nbsp </div>
		<div class="col-md-12">
			<label class="col-md-2"><b>Headline Proyek : &nbsp </b></label>
			<div class="col-md-10">
				<textarea class="form-control" rows="3" name="txtHeadlineProyek" id="comment"></textarea>
			</div>
		</div>
		<div class="col-md-12">
			<label class="col-md-2"><b>Deskripsi Proyek : &nbsp </b></label>
			<div class="col-md-10">
				<textarea name="txtDeskripsiProyek" class="ckeditor"  required></textarea>
			</div>
		</div>
		<div class="col-md-12">	&nbsp </div>
		<div class="col-md-12">
			<label class="col-md-2"><b>URL Video : &nbsp </b></label>
			<div class="col-md-10">
			  <input type="text" name="txtVideo" class="form-control" placeholder="Masukan kode embed video dari youtube" style="width:100%;">
			</div>
		</div>
		<div class="col-md-12">	&nbsp </div>
		<div class="col-md-12">
			<label class="col-md-2"><b>Gambar Utama : &nbsp </b></label>
			<div class="col-md-10">
				<input id="foto_post" type="file" name="foto_post" class="file">
			</div>
		</div>
		<div class="col-md-12">
			<label class="col-md-2"><b>Target Dana (Rp) :</b></label>
			<div class="col-md-7">
				<input type="text" name="txtTargetProyek" id="txtTargetProyek" onInput="tandaPemisahTitik(this.value)" class="form-control" placeholder="target uang terkumpul" required>
			</div>			
		</div>
		<div class="col-md-12">
		<br>
			<label class="col-md-2"><b>Tanggal Berakhir</b></label>
			<div class="col-md-4">
				<input type="date" name="txtBerakhirProyek" class="form-control" placeholder="tanggal berakhir proyek">
			</div>
			<b>*Format tanggal 31/12/2016</b>
		</div>
		<div class="col-md-12">	&nbsp </div>
		<div style="text-align:right;">
			<hr>	
			<input type="submit" name="btnWakafBaru" class="btn btn-primary" value="Buat Proyek Baru">
		</div>
	</div>
</form>
	<?php
	}
	?>
</article>
