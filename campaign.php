<?php include 'templates/header.php'; ?>


<!-- Start main-content -->
  <div class="main-content">

    <!-- Section: inner-header -->
    <section class="inner-header divider parallax layer-overlay overlay-dark-5" data-stellar-background-ratio="0.5" data-bg-img="images/campaign/kids.jpg">
      <div class="container pt-100 pb-50">
        <!-- Section Content -->
        <div class="section-content pt-100">
          <div class="row"> 
            <div class="col-md-12">
              <h3 class="title text-white">Area Wakif</h3>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- Section: Blog -->
    <section>
      <div class="container mt-30 mb-30 pt-30 pb-30">
        <div class="row">
          <div class="col-md-9 pull-right flip sm-pull-none">
            <h3 class="heading-title heading-line-bottom pt-10 pb-10 visible-lg">Tambah/Edit Campaign</h3>
            <div class="row">
              <div class="col-sm-12">
			  <?php
				if(isset($_POST['btnSaveProyek'])){
					proyekWakafBaru();
				}
				if(isset($_POST['btnEditProyek'])){
					proyekWakafEdit();
				}
				$judul = "";
				$kategori = "";
				$headline = "";
				$deskripsi = "";
				$target_dana = "";
				$tanggal_pembuatan = "";					
				$url_foto =  "";
				$url_video =  "";	
				if(isset($_GET['edit'])){
					$stmt = $mysqli->query("select * from tbl_wakaf_proyek where id_wakaf_proyek=".$_GET['edit']." AND id_user = ".$_COOKIE['login_id']." ");
					if($stmt->num_rows>0){
						$data = $stmt->fetch_object();
						$judul = $data->nama_proyek;
						$kategori = $data->id_kategori_wakaf;
						$headline = $data->headline_proyek;
						$deskripsi = $data->deskripsi_proyek;
						$target_dana = $data->target_dana;
						$tanggal_pembuatan = $data->tanggal_pembuatan;					
						$url_foto =  $data->url_foto;
						$url_video =  $data->url_video;
						$status_proyek =  $data->status_proyek;
					}
				}				
			  ?>
                <form class="form-horizontal" action="" method="post"  enctype="multipart/form-data">
				  <input value="<?php echo $judul;?>" type="hidden" name="txtNamaProyekLast">
				  <input value="<?php echo $url_foto;?>" type="hidden" name="url_foto">
				  <input value="<?php echo $deskripsi;?>" type="hidden" name="txtDeskripsiProyekLast">
				  <input value="<?php echo $status_proyek;?>" type="hidden" name="txtStatusLast">
                  <div class="form-group">
                    <label for="judul" class="col-sm-3 control-label">Judul Campaign</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="txtNamaProyek" name="txtNamaProyek" placeholder="" value="<?php echo $judul;?>">
                    </div>
                  </div>
                  <div class="form-group">
                     <label for="kategori" class="col-sm-3 control-label">Kategori Campaign</label>
                    <div class="col-sm-9">
                      <select name="txtKategoriProyek" id="txtKategoriProyek" class="form-control">
						<?php
							if(isset($_GET['edit'])){
								$data_kategori = getDataByCollumn("tbl_kategori_wakaf","id_kategori_wakaf",$kategori);
								echo "<option value='".$data_kategori->id_kategori_wakaf."|".$data_kategori->nama_kategori."'>".$data_kategori->deskripsi_kategori."</option>";
							}else{
								echo "<option>Pilih Program Wakaf</option>";
							}
							echo "<option></option>";
							$stmt = $mysqli->query("SELECT * from tbl_kategori_wakaf where tipe_kategori='program'");
							while($data = $stmt->fetch_object()){
								echo "<option value='".$data->id_kategori_wakaf."|".$data->nama_kategori."'>".$data->deskripsi_kategori."</option>";
							}
						?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="deskripsi" class="col-sm-3 control-label">Headline</label>
                    <div class="col-sm-9">
                      <textarea name="txtHeadlineProyek" id="txtHeadlineProyek" class="form-control" cols="30" rows="3"><?php echo $headline;?></textarea>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="deskripsi" class="col-sm-3 control-label">Deskripsi</label>
                    <div class="col-sm-9">
                      <textarea name="txtDeskripsiProyek" id="txtDeskripsiProyek" class="form-control" cols="30" rows="10"><?php echo $deskripsi;?></textarea>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="deskripsi" class="col-sm-3 control-label">URL Video</label>
                    <div class="col-sm-9">
                      <input type="text" name="txtVideo" class="form-control" placeholder="Masukan kode embed video dari youtube" value='<?php echo $url_video;?>'>
                    </div>
                  </div>         
				  <?php
					if(!isset($_GET['edit'])){
						echo'
					<div class="form-group">
						<label for="deskripsi" class="col-sm-3 control-label">Gambar Utama</label>
						<div class="col-sm-9">
							<input id="foto_post" type="file" name="foto_post" class="file form-control">
						</div>
					</div>
						';
					}
				  ?>
                  <div class="form-group">
                    <label for="deskripsi" class="col-sm-3 control-label">Target Dana (Rp)</label>
                    <div class="col-sm-3">
						<input type="number" name="txtTargetProyek" class="form-control" placeholder="target uang terkumpul" value="<?php echo $target_dana;?>" required>
                    </div>
                    <label for="deskripsi" class="col-sm-3 control-label">Tanggal Akhir(optional)</label>
                    <div class="col-sm-3">
						<input type="date" name="txtBerakhirProyek" class="form-control" placeholder="tanggal berakhir proyek">
                    </div>
                  </div>
				  <hr>
                  <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-9">
						<?php
							if(isset($_GET['edit'])){
								echo'
									<button type="submit" name="btnEditProyek" class="btn btn-green btn-theme-colored">Edit</button> &nbsp;
								';
							}else{
								echo'
									<button type="submit" name="btnSaveProyek" class="btn btn-green btn-theme-colored">Save</button> &nbsp; 
								';
							}
						?>
					  <a href="campaign-saya.php" class="btn btn-green btn-theme-colored">Batal</a>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
		  <?php
			include 'menu_wakif.php';
		  ?>
        </div>
      </div>
    </section>
  </div>
  <!-- end main-content -->

  <?php include 'templates/footer.php'; ?>
