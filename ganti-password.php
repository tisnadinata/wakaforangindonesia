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
            <h3 class="heading-title heading-line-bottom pt-10 pb-10 visible-lg">Ganti Password</h3>
            <div class="row">
              <div class="col-sm-12">
				<?php
					if(isset($_POST['btnGantiPassword'])){
						$password_lama = $_POST['pass-lama'];
						$password_baru = $_POST['pass-baru'];
						$password_baru_re = $_POST['pass-baru2'];
						if($password_baru == $password_baru_re){
							if($password_lama == $_COOKIE['login_password']){
								$stmt = $mysqli->query("UPDATE tbl_login SET password='".$password_baru."' WHERE username='".$_COOKIE['login_username']."' AND password='".$_COOKIE['login_password']."'");
								if($stmt){
									$_COOKIE['login_password'] = $password_baru;
									echo'	
										<div class="divider divider--xs"></div>
											<div class="alert alert-success" role="alert" align="center">
											<b>Password Berhasil Diubah</b>
										</div>
									';
								}else{
									echo '		
										<div class="divider divider--xs"></div>
											<div class="alert alert-danger" role="alert" align="center">
											<b>Gagal mengubah password</b>
										</div>
									';
								}
							}else{
							echo '		
								<div class="divider divider--xs"></div>
									<div class="alert alert-danger" role="alert" align="center">
									<b>Password lama anda salah... !!</b>
								</div>
							';
							}
						}else{
							echo '		
								<div class="divider divider--xs"></div>
									<div class="alert alert-danger" role="alert" align="center">
									<b>Password baru tidak cocok... !!</b>
								</div>
							';
						}
					}
				?>
                <form class="form-horizontal" action="" method="post">
                  <div class="form-group">
                    <label for="pass-lama" class="col-sm-3 control-label">Password Lama</label>
                    <div class="col-sm-9">
                      <input type="password" class="form-control" id="pass-lama" name="pass-lama" placeholder="Masukkan password lama Anda">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="pass-baru" class="col-sm-3 control-label">Password Baru</label>
                    <div class="col-sm-9">
                      <input type="password" class="form-control" id="pass-baru" name="pass-baru" placeholder="Masukkan password baru Anda">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="konfirmasi" class="col-sm-3 control-label">Konfirmasi Password</label>
                    <div class="col-sm-9">
                      <input type="password" class="form-control" id="pass-baru2" name="pass-baru2" placeholder="Ulangi password baru Anda">
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-9">
                      <button type="submit" name="btnGantiPassword" class="btn btn-green btn-theme-colored">Save</button>
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
