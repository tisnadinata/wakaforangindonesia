<article class="content item-editor-page">
<div class="title-block">
	<h3 class="title">Post Berita Baru<span class="sparkline bar" data-type="bar"></span></h3>
</div>
	<?php
	if(isset($_POST['btnPostBaru'])){
		blogPosting();
	}
	?>
<form name="item" action="" method="post"  enctype="multipart/form-data">
	<div class="card card-block">
		<div class="col-md-12">
			<label class="col-md-2"><b>Tipe Post : &nbsp </b></label>
			<div class="col-md-10">
			  <select class="form-control" name="txtTipePost" required>
				<option value='berita'>Blog Berita</option>
				<option value='tausyiah'>Tausyiah Dakwah</option>
			  </select>
			</div>
		</div>
		<div class="col-md-12">	&nbsp </div>
		<div class="col-md-12">
			<label class="col-md-2"><b>Nama Pemateri : &nbsp </b></label>
			<div class="col-md-10">
			  <select class="form-control" name="txtNamaPemateri" required>
				<option value='Ustad Hari Mukti'>Ustad Hari Mukti</option>
				<option value='Ustad Felix Siauw'>Ustad Felix Siauw</option>
			  </select>
			</div>
		</div>
		<div class="col-md-12">	&nbsp </div>
		<div class="col-md-12">
			<label class="col-md-2"><b>Judul Post : &nbsp </b></label>
			<div class="col-md-10">
			  <input type="text" name="txtJudulPost" class="form-control" placeholder="judul postingan" style="width:100%;" required>
			</div>
		</div>
		<div class="col-md-12">	&nbsp </div>
		<div class="col-md-12">
			<label class="col-md-2"><b>Isi Postingan : &nbsp </b></label>
			<div class="col-md-10">
				<textarea name="txtIsiPost" class="ckeditor"  required></textarea>
				
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
			<label class="col-md-2"><b>Tag Post : &nbsp </b></label>
			<div class="col-md-10">
			  <input type="text" name="txtTag" class="form-control" placeholder="Masukan tag anda sendiri jika tidak ada yang sesuai dengan tag dibawah" style="width:100%;">
					<?php
						$i=0;
						$stmt = $mysqli->query("SELECT * from tbl_kategori_wakaf ORDER BY tipe_kategori");
						while($data = $stmt->fetch_object()){
							echo '<label class="checkbox-inline">
								<input type="checkbox" id="tagPost'.$i.'" name="tagPost'.$i.'" value="'.$data->nama_kategori.'">'.ucfirst($data->nama_kategori).'</input>
							</label>';
							$i++;
						}
						echo "<input type='hidden' value='$i' name='jumTag'/>";
					?>
			</div>
		</div>
		<div class="col-md-12">	&nbsp </div>
		<div style="text-align:right;">
			<hr>	
			<input type="submit" name="btnPostBaru" class="btn btn-primary" value="Posting Berita/tausyiah">
		</div>
	</div>
</form>
</article>
