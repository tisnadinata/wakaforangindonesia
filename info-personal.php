<?php include 'templates/header.php'; ?>
<script language='javascript'>
		function validAngka(obj)
		{
			var pola = "^";
			pola += "[0-9]*";
			pola += "$";
			rx = new RegExp(pola);
		 
			if (!obj.value.match(rx))
			{
				if (obj.lastMatched)
				{
					obj.value = obj.lastMatched;
				}
				else
				{
					obj.value = "";
				}
			}
			else
			{
				obj.lastMatched = obj.value;
			}
		}
	</script>

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
            <h3 class="heading-title heading-line-bottom pt-10 pb-10 visible-lg">Informasi Personal</h3>
            <div class="row">
              <div class="col-sm-12">
			  <?php
				if(isset($_POST['btnEditProfil'])){
					$nama_lengkap = $_POST['nama_lengkap'];
					$email = $_POST['email'];
					$telpon = $_POST['telpon'];
					$alamat = $_POST['alamat'];
					$biografi = $_POST['biografi'];
					
					$stmt = $mysqli->query("UPDATE tbl_user SET nama_lengkap='".$nama_lengkap."',email='".$email."',
					telepon=".$telpon.",alamat='".$alamat."',biografi='".$biografi."' WHERE id_user=".$_COOKIE['login_id']." ");
					if($stmt){
						echo'	
							<div class="divider divider--xs"></div>
								<div class="alert alert-success" role="alert" align="center">
								<b>Informasi Akun Berhasil Diubah</b>
							</div>
						';
					}else{
						echo '		
							<div class="divider divider--xs"></div>
								<div class="alert alert-danger" role="alert" align="center">
								<b>Gagal mengubah informasi akun</b>
							</div>
						';
					}
				}
				$stmt = $mysqli->query("select * from tbl_user where id_user=".$_COOKIE['login_id']."");
				$data_user = $stmt->fetch_object();
			  ?>
                <form class="form-horizontal" action="" method="post">
                  <div class="form-group">
                    <label for="nama" class="col-sm-3 control-label">Nama Lengkap</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" placeholder="" value="<?php echo $data_user->nama_lengkap; ?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="email" class="col-sm-3 control-label">Email</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="email" name="email" placeholder="" value="<?php echo $data_user->email; ?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="telpon" class="col-sm-3 control-label">Nomor Telpon</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="telpon"name="telpon" onKeyUp="validAngka(this)" placeholder="" value="<?php echo $data_user->telepon; ?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="telpon" class="col-sm-3 control-label">Alamat Lengkap</label>
                    <div class="col-sm-9">
                      <textarea name="alamat" id="alamat" class="form-control" cols="30" rows="3"><?php echo $data_user->alamat; ?></textarea>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="biografi" class="col-sm-3 control-label">Biografi Anda</label>
                    <div class="col-sm-9">
                      <textarea name="biografi" id="biografi" class="form-control" cols="30" rows="10"><?php echo $data_user->biografi; ?></textarea>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-9">
                      <button type="submit" name="btnEditProfil" class="btn btn-green btn-theme-colored">Save</button>
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
