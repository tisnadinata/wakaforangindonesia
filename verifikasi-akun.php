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
            <h3 class="heading-title heading-line-bottom pt-10 pb-10 visible-lg">Verifikasi Akun Anda</h3>
            <div class="row">
              <div class="col-sm-12">
			  <?php
				if(isset($_POST['btnUploadPicture'])){
					$ok_ext = array('jpg','png','jpeg'); // allow only these types of files
					$destination = "images/user/";
					$file = $_FILES['foto_verifikasi'];
					$filename = explode(".", $file["name"]); 
					$file_name = $file['name']; // file original name
					$file_name_no_ext = isset($filename[0]) ? $filename[0] : null; // File name without the extension
					$file_extension = $filename[count($filename)-1];
					$file_weight = $file['size'];
					$file_type = $file['type'];
					//KTP
					$file2 = $_FILES['foto_ktp'];
					$filename2 = explode(".", $file2["name"]); 
					$file_name2 = $file['name']; // file original name
					$file_name_no_ext2 = isset($filename2[0]) ? $filename2[0] : null; // File name without the extension
					$file_extension2 = $filename2[count($filename2)-1];
					$file_weight2 = $file2['size'];
					$file_type2 = $file2['type'];
					// If there is no error
					if( $file['error'] == 0 AND $file2['error'] == 0 ){
						// check if the extension is accepted
						if( in_array(strtolower($file_extension), $ok_ext) AND in_array(strtolower($file_extension2), $ok_ext)){
							// check if the size is not beyond expected size
							// rename the file
							$fileNewName = 'verifikasi_'.str_replace(" ","",$_COOKIE['login_username']).'.'.$file_extension ;
							$fileNewName2 = 'ktp_'.str_replace(" ","",$_COOKIE['login_username']).'.'.$file_extension2 ;
							// and move it to the destination folder
							if( move_uploaded_file($file['tmp_name'], $destination.$fileNewName) ){
								if( move_uploaded_file($file2['tmp_name'], $destination.$fileNewName2) ){
									$url_verifikasi = $destination.$fileNewName;
									$url_ktp = $destination.$fileNewName2;					
									$stmt = $mysqli->query("UPDATE tbl_user_verifikasi SET url_ktp='".$url_ktp."',foto_verifikasi='".$url_verifikasi."' WHERE id_user=".$_COOKIE['login_id']."");
									if($stmt){
										echo '		
											<div class="divider divider--xs"></div>
											<div class="alert alert-success" role="alert" align="center">
.												<b>File anda berhasil di upload, tunggu konfirmasi selanjutnya dari admin.</b>
											</div>
										';
									}else{
										echo '		
											<div class="divider divider--xs"></div>
											<div class="alert alert-danger" role="alert" align="center">
												<b>File anda gagal di upload, silahkan hubungi customer service kami atau coba beberapa saat lagi... !!</b>
											</div>
										';
									}
								}else{
									echo "can't upload file ktp.";
								}
							}else{
								echo "can't upload file foto.";
							}
						}else{
							echo "File type is not supported.";
						}
					}else{
						echo "Error Uploading";
					}
				}
			  ?>
                <form method="post" enctype="multipart/form-data" action="">
                  <div class="form-group">
                    <label for="picture">Scan KTP/ID Lainnya</label>
                    <input type="file" id="foto_ktp" name="foto_ktp">
                    <p class="help-block">Format file: jpg, png, dan gif. Kualitas scan harus jelas dan dapat terbaca dengan baik, terutama pada bagian nama lengkap, foto, dan tanda tangan.</p>
                  </div>
                  <div class="form-group">
                    <label for="picture">Foto Verifikasi</label>
                    <input type="file" id="foto_verifikasi" name="foto_verifikasi">
                    <p class="help-block">Format file: jpg, png, dan gif. Mohon upload foto portrait anda dengan ketentuan sebagai berikut:</p>
                    <i class="fa fa-square" aria-hidden="true"></i> &nbsp; Foto portrait anda (setengah badan), harus asli, <strong>tanpa melalui proses editing</strong><br>
                    <i class="fa fa-square" aria-hidden="true"></i> &nbsp; Membawa kertas putih yang bertuliskan:   <br>
                    &nbsp; &nbsp; &nbsp;<i class="fa fa-check-circle-o" aria-hidden="true"></i> &nbsp; Nama lengkap Anda sesuai KTP <br>
                    &nbsp; &nbsp; &nbsp;<i class="fa fa-check-circle-o" aria-hidden="true"></i> &nbsp; Alamat email yang digunakan untuk login di Kitabisa.com <br>
                    &nbsp; &nbsp; &nbsp;<i class="fa fa-check-circle-o" aria-hidden="true"></i> &nbsp;  Ada tulisan "VERIFIED USER WOI.OR.ID" <br>
                    &nbsp; &nbsp; &nbsp;<i class="fa fa-check-circle-o" aria-hidden="true"></i> &nbsp; Tanda tangan Anda <br>
                    &nbsp; &nbsp; &nbsp;<i class="fa fa-check-circle-o" aria-hidden="true"></i> &nbsp; Tanggal hari ini <br><br>

                    <i class="fa fa-square" aria-hidden="true"></i> &nbsp; Seluruh tulisan diatas haruslah ditulis tangan, bukan hasil cetakan / print
                  </div>
                  <div class="form-group">
                    <label for="telepon" control-label">Nomor Telepon</label>
                    <input type="text" class="form-control" id="telepon" placeholder="08XXXXXXXXXX">
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
