<?php include 'templates/header.php'; ?>


<!-- Start main-content -->
  <div class="main-content">

    <!-- Section: inner-header -->
    <section class="inner-header divider parallax layer-overlay overlay-dark-5" data-stellar-background-ratio="0.5" data-bg-img="images/campaign/kids.jpg" style="height:350px;">      <div class="container pt-100 pb-50">
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
            <h3 class="heading-title heading-line-bottom pt-10 pb-10 visible-lg">Ganti Profile Picture</h3>
            <div class="row">
              <div class="col-sm-12">
			  <?php
				if(isset($_POST['btnUploadPicture'])){
					$ok_ext = array('jpg','png','jpeg'); // allow only these types of files
					$destination = "images/user/";
					$file = $_FILES['foto_profil'];
					$filename = explode(".", $file["name"]); 
					$file_name = $file['name']; // file original name
					$file_name_no_ext = isset($filename[0]) ? $filename[0] : null; // File name without the extension
					$file_extension = $filename[count($filename)-1];
					$file_weight = $file['size'];
					$file_type = $file['type'];
					// If there is no error
					if( $file['error'] == 0){
						// check if the extension is accepted
						if( in_array(strtolower($file_extension), $ok_ext)){
							// check if the size is not beyond expected size
							// rename the file
							$fileNewName = 'foto_'.str_replace(" ","",$_COOKIE['login_username']).'.'.$file_extension ;
							// and move it to the destination folder
							if( move_uploaded_file($file['tmp_name'], $destination.$fileNewName) ){
								$url_foto = $destination.$fileNewName;								
								$stmt = $mysqli->query("UPDATE tbl_user SET url_foto='".$url_foto."' WHERE id_user=".$_COOKIE['login_id']."");
								if($stmt){
									echo '		
									<div class="divider divider--xs"></div>
										<div class="alert alert-success" role="alert" align="center">
											<b>Foto Profil Anda Behasil Diubah</b>
										</div>
									';
								}else{
									echo '		
									<div class="divider divider--xs"></div>
										<div class="alert alert-danger" role="alert" align="center">
											<b>Gagal upload foto profil... !!</b>
										</div>
									';
								}
							}else{
								echo "can't upload file foto.";
							}
						}else{
							echo "File type is not supported.";
						}
					}
				}
			  ?>
                <form method="post" action="" enctype="multipart/form-data">
                  <div class="form-group">
                    <label for="picture">Pilih picture</label>
                    <input type="file" id="foto_profil" name="foto_profil">
                    <p class="help-block">Format file: jpg, dan png. Sebaiknya dengan Resolusi 250x250</p>
                  </div>
                  <div class="form-group">
                      <button type="submit" name="btnUploadPicture" class="btn btn-green btn-theme-colored">Save</button>
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
