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
            <h3 class="heading-title heading-line-bottom pt-10 pb-10 visible-lg">Konfirmasi Pembayaran Donasi</h3>
            <div class="row">
              <div class="col-sm-12">
				<?php
					if(isset($_POST['btnKonfirmasi'])){
						$id_wakaf_donasi = $_POST['id_donasi'];
						$id_bank = $_POST['id_bank'];
						$nama_bank = $_POST['nama_bank'];
						$atas_nama = $_POST['atas_nama'];
						$rekening = $_POST['rekening'];
						$jumlah_transfer = $_POST['jumlah_transfer'];
						$stmt = $mysqli->query("INSERT INTO tbl_wakaf_donasi_konfirmasi(id_wakaf_donasi,id_bank,nama_bank,atas_nama,nomor_rekening,jumlah_dibayar) 
						VALUES($id_wakaf_donasi,$id_bank,'$nama_bank','$atas_nama','$rekening',$jumlah_transfer)");
						if($stmt){
							$mysqli->query("update tbl_wakaf_donasi_status set status_wakaf='proses' where id_wakaf_donasi=".$id_wakaf_donasi."");
							echo'	
								<div class="divider divider--xs"></div>
									<div class="alert alert-success" role="alert" align="center">
									<b>Pembayaran donasi anda berhasil di konfirmasi, menunggu verifikasi oleh admin</b>
								</div>
							';
						}else{
							echo '		
								<div class="divider divider--xs"></div>
									<div class="alert alert-danger" role="alert" align="center">
									<b>Gagal mengubah status pembayara, silahkan coba lagi nanti</b>
								</div>
						';
						}
					}
				?>
                <form class="form-horizontal" action="" method="post">
                  <div class="form-group">
                    <label for="pass-lama" class="col-sm-3 control-label">Pilih Donasi</label>
                    <div class="col-sm-9">
					<select name="id_donasi" id="id_donasi" class="form-control">
					<?php
						$stmt = $mysqli->query("select * from tbl_wakaf_proyek,tbl_wakaf_donasi,tbl_wakaf_donasi_status 
						where tbl_wakaf_donasi.id_user=".$_COOKIE['login_id']." AND tbl_wakaf_donasi.id_wakaf_donasi=tbl_wakaf_donasi_status.id_wakaf_donasi 
						AND tbl_wakaf_donasi_status.status_wakaf='pending' AND tbl_wakaf_proyek.id_wakaf_proyek=tbl_wakaf_donasi.id_wakaf_proyek");
						if($stmt->num_rows > 0){
							while($data = $stmt->fetch_object()){
								echo'<option value="'.$data->id_wakaf_donasi.'">'.$data->nama_proyek.' - Rp '.$data->jumlah_wakaf.'</option>';
							}
						}else{
							echo'<option>Tidak ada wakaf donasi yang menunggu pembayaran</option>';
						}
					?>
					</select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="pass-lama" class="col-sm-3 control-label">Tujuan Transfer(Bank WOI)</label>
                    <div class="col-sm-9">
                     <select name="id_bank" id="id_bank" class="form-control">
					<?php
						$stmt = $mysqli->query("select * from tbl_bank where id_user=0 and tipe_bank='admin'");
						while($data = $stmt->fetch_object()){
							echo'<option value="'.$data->id_bank.'">'.$data->nama_bank.' - '.$data->rekening_bank.' - '.$data->atas_nama.'</option>';
						}
					?>
					</select>
                    </div>
                  </div>
				  <hr>
                  <div class="form-group">
                    <label for="pass-baru" class="col-sm-3 control-label">Nama Bank</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="nama_bank" name="nama_bank" placeholder="Bank yang anda pakai untuk pembayaran">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="konfirmasi" class="col-sm-3 control-label">Atas Nama</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="atas_nama" name="atas_nama" placeholder="Atas nama pemilik rekening">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="konfirmasi" class="col-sm-3 control-label">Nomor Rekening</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="rekening" onKeyUp="validAngka(this)" name="rekening" placeholder="Nomor rekening bank">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="pass-baru" class="col-sm-3 control-label">Jumlah Transfer( Rp )</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="jumlah_transfer" onKeyUp="validAngka(this)" name="jumlah_transfer" placeholder="Jumlah yang di transfer">
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-9">
                      <button type="submit" name="btnKonfirmasi" class="btn btn-green btn-theme-colored pull-right">Konfirmasi Pembayaran</button>
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
