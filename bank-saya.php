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
				if(isset($_GET['delete'])){
					$stmt = $mysqli->query("DELETE FROM tbl_bank WHERE id_bank=".$_GET['delete']." AND id_user =".$_COOKIE['login_id']." ");
					if($stmt){
						echo'	
							<div class="divider divider--xs"></div>
								<div class="alert alert-success" role="alert" align="center">
								<b>Berhasil menghapus data bank</b>
							</div>
						';
					}else{
						echo '		
							<div class="divider divider--xs"></div>
								<div class="alert alert-danger" role="alert" align="center">
								<b>Kesalahan saat menghapus bank, silahkan coba lagi nanti</b>
							</div>
						';
					}
				}
				if(isset($_POST['btnEditBank'])){
					$nama_bank = $_POST['nama_bank'];
					$atas_nama = $_POST['atas_nama'];
					$rekening = $_POST['rekening'];
					
					$sql = "UPDATE tbl_bank SET nama_bank='".$nama_bank."',atas_nama='".$atas_nama."',rekening_bank='".$rekening."' WHERE id_bank=".$_GET['edit']." AND id_user =".$_COOKIE['login_id']." ";
					$stmt = $mysqli->query($sql);
					if($stmt){
						echo'	
							<div class="divider divider--xs"></div>
								<div class="alert alert-success" role="alert" align="center">
								<b>Berhasil mengubah data bank.</b>
							</div>
						';
					}else{
						echo '		
							<div class="divider divider--xs"></div>
								<div class="alert alert-danger" role="alert" align="center">
								<b>Gagal mengubah data bank</b>
							</div>
						';
					}
				}
				if(isset($_POST['btnTambahBank'])){
					$nama_bank = $_POST['nama_bank'];
					$atas_nama = $_POST['atas_nama'];
					$rekening = $_POST['rekening'];
					
					$stmt = $mysqli->query("INSERT INTO tbl_bank(id_user,nama_bank,atas_nama,rekening_bank,status_bank,tipe_bank)
					VALUES(".$_COOKIE['login_id'].",'".$nama_bank."','".$atas_nama."','".$rekening."','pending','wakif')");
					if($stmt){
						echo'	
							<div class="divider divider--xs"></div>
								<div class="alert alert-success" role="alert" align="center">
								<b>Berhasil menambah bank, menunggu verifikasi dari admin</b>
							</div>
						';
					}else{
						echo '		
							<div class="divider divider--xs"></div>
								<div class="alert alert-danger" role="alert" align="center">
								<b>Gagal menambahkan akun bank</b>
							</div>
						';
					}
				}
				if(!isset($_GET['edit'])){
					echo'
						<form class="form-horizontal" action="" method="post">
						  <div class="form-group">
							<label for="nama" class="col-sm-3 control-label">Nama Bank</label>
							<div class="col-sm-9">
							  <input type="text" class="form-control" id="nama_bank" name="nama_bank" placeholder="" >
							</div>
						  </div>
						  <div class="form-group">
							<label for="email" class="col-sm-3 control-label">Atas Nama/Pemilik</label>
							<div class="col-sm-9">
							  <input type="text" class="form-control" id="atas_nama" name="atas_nama" placeholder="" >
							</div>
						  </div>
						  <div class="form-group">
							<label for="telpon" class="col-sm-3 control-label">Nomor Rekening</label>
							<div class="col-sm-9">
							  <input type="text" class="form-control" id="rekening" name="rekening" onKeyUp="validAngka(this)" placeholder="" >
							</div>
						  </div>                  
						  <div class="form-group">
							<div class="col-sm-offset-3 col-sm-9">
							  <button type="submit" name="btnTambahBank" class="btn btn-green btn-theme-colored pull-right">Tambah Bank</button>
							</div>
						  </div>
						</form>
					';
				}else{
					$stmt = $mysqli->query("select * from tbl_bank where id_bank=".$_GET['edit']." AND id_user = ".$_COOKIE['login_id']."");
					if($stmt->num_rows > 0){
						$data_bank = $stmt->fetch_object();
						echo'
							<form class="form-horizontal" action="" method="post">
							  <div class="form-group">
								<label for="nama" class="col-sm-3 control-label">Nama Bank</label>
								<div class="col-sm-9">
								  <input type="text" class="form-control" id="nama_bank" name="nama_bank" placeholder="" value="'.$data_bank->nama_bank.'">
								</div>
							  </div>
							  <div class="form-group">
								<label for="email" class="col-sm-3 control-label">Atas Nama/Pemilik</label>
								<div class="col-sm-9">
								  <input type="text" class="form-control" id="atas_nama" name="atas_nama" placeholder="" value="'.$data_bank->atas_nama.'" >
								</div>
							  </div>
							  <div class="form-group">
								<label for="telpon" class="col-sm-3 control-label">Nomor Rekening</label>
								<div class="col-sm-9">
								  <input type="text" class="form-control" id="rekening" name="rekening" onKeyUp="validAngka(this)" placeholder="" value="'.$data_bank->rekening_bank.'" >
								</div>
							  </div>                  
							  <div class="form-group">
								<div class="col-sm-offset-3 col-sm-9">
								  <button type="submit" name="btnEditBank" class="btn btn-green btn-theme-colored pull-right">Tambah Bank</button>
								</div>
							  </div>
							</form>
						';
					}else{
						echo '		
							<div class="divider divider--xs"></div>
								<div class="alert alert-danger" role="alert" align="center">
								<b>Maaf, data bank tidak ditemukan</b>
							</div>
						';
						echo'
						<form class="form-horizontal" action="" method="post">
						  <div class="form-group">
							<label for="nama" class="col-sm-3 control-label">Nama Bank</label>
							<div class="col-sm-9">
							  <input type="text" class="form-control" id="nama_bank" name="nama_bank" placeholder="" >
							</div>
						  </div>
						  <div class="form-group">
							<label for="email" class="col-sm-3 control-label">Atas Nama/Pemilik</label>
							<div class="col-sm-9">
							  <input type="text" class="form-control" id="atas_nama" name="atas_nama" placeholder="" >
							</div>
						  </div>
						  <div class="form-group">
							<label for="telpon" class="col-sm-3 control-label">Nomor Rekening</label>
							<div class="col-sm-9">
							  <input type="text" class="form-control" id="rekening" name="rekening" onKeyUp="validAngka(this)" placeholder="" >
							</div>
						  </div>                  
						  <div class="form-group">
							<div class="col-sm-offset-3 col-sm-9">
							  <button type="submit" name="btnTambahBank" class="btn btn-green btn-theme-colored pull-right">Tambah Bank</button>
							</div>
						  </div>
						</form>
					';
					}
				}
			  ?>
              </div>
            </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="table-responsive">
                                <table class="table">
                                    <tr class="success">
                                        <th>No</th>
                                        <th>Nama Bank</th>
                                        <th>Atas Nama/Pemilik</th>
                                        <th>Nomor Rekening</th>
                                        <th>Status</th>
                                        <th></th>
                                    </tr>
									<?php
										if(isset($_GET['p'])){
											$posisi = (($_GET['p']-1)*4);
										}else{
											$posisi = 0;
										}
										$stmt = $mysqli->query("select * from tbl_bank where id_user = ".$_COOKIE['login_id']."");
										if($stmt->num_rows > 0){
											$i=1;
											$status_bank = "UNKNOWN";
											while($data_bank=$stmt->fetch_object()){
												if($data_bank->status_bank=="pending"){
													$status_bank = "MENUNGGU VERIFIKASI";
												}
												if($data_bank->status_bank=="done"){
													$status_bank = "TERVERIFIKASI";
												}
												if($data_bank->status_bank=="fail"){
													$status_bank = "DITOLAK";
												}
												echo'
													<tr>
														<td>'.$i.'</td>
														<td>'.$data_bank->nama_bank.'</td>
														<td>'.$data_bank->atas_nama.'</td>
														<td>'.$data_bank->rekening_bank.'</td>
														<td>'.strtoupper($status_bank).'</td>
														<td>
															<b>
															<a href="?edit='.$data_bank->id_bank.'"><span class="fa fa-edit" style="color:blue;" title="EDIT POST"></span></a> | 
															<a href="?delete='.$data_bank	->id_bank.'"><span class="fa fa-trash" style="color:red;" title="DELETE DATA"></span></a>															
															</b>
														</td>
													</tr>                                    
												';
												$i++;
											}
										}else{
											echo "<tr><td colspan='5'>Belum ada mutasi saldo</td></tr>";
										}
									?>
                                </table>
                            </div>

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
