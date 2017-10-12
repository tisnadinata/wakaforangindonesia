<?php include 'templates/header.php'; ?>

<!-- Start main-content -->
<div class="main-content">

    <section class="inner-header divider parallax layer-overlay overlay-dark-5" data-stellar-background-ratio="0.5" data-bg-img="images/campaign/kids.jpg" style="height:350px;">    <!-- Section: inner-header -->
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
				<?php
					include 'menu_wakif.php';
				?>
                <div class="col-md-9">
                    <h3 class="heading-title heading-line-bottom pt-10 pb-10 visible-lg">Mutasi</h3>
                    <div class="row">
                        <div class="col-sm-4 text-center">
                            <div class="icon-box iconbox-border">
                                <a class="icon icon-gray icon-circled icon-border-effect effect-circled" href="#">
                                    <img alt="" src="images/flat-color-icons-svg/currency_exchange.svg" title="currency_exchange.svg"/>
                                </a>
                                <h5 class="icon-box-title">Rp. 
								<?php 
									$stmt = getDataByCollumn("tbl_user","id_user",$_COOKIE['login_id']);
									echo setHarga($stmt->saldo_dompet); 
								?>
								</h5>
                                <p class="text-gray">Saldo Dompet Saya</p>
                            </div>
                        </div>
                    </div>
                    <h3 class="heading-title heading-line-bottom pt-10 pb-10 visible-lg">&nbsp; </h3>
                    <div class="row">
                        <div class="col-sm-12">
							<?php
								if(isset($_POST['btnTopup'])){
									$jumlah_topup = $_POST['txtNominal'];
									$metode_pembayaran = $_POST['metode_pembayaran'];
									$kode_topup = getKodeUnik();
									
									$stmt = $mysqli->query("INSERT INTO tbl_dompet_topup(id_user,jumlah_topup,kode_topup,metode_pembayaran) 
									VALUES(".$_COOKIE['login_id'].",$jumlah_topup,$kode_topup,'$metode_pembayaran')");
									if($stmt){
										echo '		
										<div class="divider divider--xs"></div>
											<div class="alert alert-success" role="alert" align="center">
												<b>Permintaan topup kami terima, silahkan lakukan pembayaran dengan detail berikut.<br>Kami sarankan simpan rekening transfer dibawah</b>
											</div>											
										';
										echo'
											<form class="form-horizontal" action="" method="post">                            
												<div class="form-group">
													<label for="tambah" class="col-sm-2 control-label">NAMA BANK</label>
													<div class="col-sm-4">
														<input type="text" class="form-control" placeholder="BANK MANDIRI" disabled>
													</div>
													<label for="tambah" class="col-sm-2 control-label">ATAS NAMA</label>
													<div class="col-sm-4">
														<input type="text" class="form-control" placeholder="MUHAMMAD ADITYA TISNADINATA" disabled>
													</div>
												</div>
												<div class="form-group">
													<label for="tambah" class="col-sm-2 control-label">REKENING</label>
													<div class="col-sm-4">
														<input type="text" class="form-control" placeholder="12345678901234" disabled>
													</div>
													<label for="tambah" class="col-sm-2 control-label">TOTAL BIAYA</label>
													<div class="col-sm-4">
														<input type="text" class="form-control" placeholder="RP '.setHarga($jumlah_topup+$kode_topup).'" disabled>
													</div>
												</div>
											</form>
										';
									}else{
										echo '		
										<div class="divider divider--xs"></div>
											<div class="alert alert-danger" role="alert" align="center">
												<b>Permintaan topup ditolak... !!</b>
											</div>
										';
									}								}
							?>
							<br><hr>
                            <form class="form-horizontal" action="" method="post">
                                <div class="form-group">
                                    <label for="tambah" class="col-sm-3 control-label">Jumlah Penambahan Deposit</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="txtNominal" id="txtNominal" placeholder="Minimum Penambahan Deposit Rp. 50.000 ">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="lokasi" class="col-sm-3 control-label">Pilih Metode Pembayaran</label>
                                    <div class="col-sm-9">
                                        <select name="metode_pembayaran" id="metode_pembayaran" class="form-control">
                                            <option value="TRANSFER BCA">Transfer BCA</option>
                                            <option value="TRANSFER BNI">Transfer BNI</option>
                                            <option value="TRANSFER BRI">Transfer BRI</option>
                                            <option value="TRANSFER MANDIRI">Transfer Mandiri</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-offset-3 col-sm-9">
                                        <button type="submit" name="btnTopup" class="btn btn-green btn-theme-colored">Tambah Deposit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>



            </div>
    </section>
</div>
<!-- end main-content -->

<?php include 'templates/footer.php'; ?>
