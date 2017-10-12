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
                <div class="col-md-3">
                    <div class="sidebar sidebar-left mt-sm-30">
                        <div class="thumbnail"> <a href="#"><img class="img-fullwidth" src="https://placehold.it/250x250" alt="..."></a>
                            <div class="caption" align="center">
                                <p><a data-toggle="collapse" href="#toggle14" href="#" class="btn btn-green btn-theme-colored" role="button">Edit Profile</a> </p>
                            </div>
                        </div>
                        <div class="panel-group toggle">
                            <div class="panel">
                                <div class="panel-heading">
                                    <div class="panel-title"> <a href="area-wakif.php"><span class="open-sub"></span>Overview </a> </div>
                                </div>
                            </div>
                            <div class="panel">
                                <div class="panel-heading">
                                    <div class="panel-title"> <a href="campaign-saya.php"><span class="open-sub"></span>Campaign Saya </a> </div>
                                </div>
                            </div>
                            <div class="panel">
                                <div class="panel-heading">
                                    <div class="panel-title"> <a href="donasi-saya.php"><span class="open-sub"></span>Donasi Saya </a> </div>
                                </div>
                            </div>
                            <div class="panel">
                                <div class="panel-heading">
                                    <div class="panel-title"> <a data-toggle="collapse" href="#toggle14"><span class="open-sub"></span>Setting </a> </div>
                                </div>
                                <div id="toggle14" class="panel-collapse collapse widget">
                                    <div class="panel-body categories">
                                        <ul class="list list-border angle-double-right">
                                            <li><a href="info-personal.php">Informasi Personal</a></li>
                                            <li><a href="ganti-password.php">Ganti Password</a></li>
                                            <li><a href="ganti-picture.php">Ganti Profile Picture</a></li>
                                            <li><a href="verifikasi-akun.php">Verifikasi Akun</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="panel">
                                <div class="panel-heading">
                                    <div class="panel-title"> <a data-toggle="collapse" href="#toggle15"><span class="open-sub"></span>Dompet Kebaikan </a> </div>
                                </div>
                                <div id="toggle15" class="panel-collapse collapse widget">
                                    <div class="panel-body categories">
                                        <ul class="list list-border angle-double-right">
                                            <li><a href="mutasi.php">Mutasi</a></li>
                                            <li><a href="tambah-deposit.php">Tambah Deposit</a></li>
                                            <li><a href="pencairan-dana.php">Pencairan Dana</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-md-9">
                    <h3 class="heading-title heading-line-bottom pt-10 pb-10 visible-lg">Pencairan Dana</h3>
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
						if(isset($_POST['btnPencairanSaldo'])){
							if($_POST['cair'] > $stmt->saldo_dompet){
								echo '
								<div class="divider divider--xs"></div>
									<div class="alert alert-warning" role="alert" align="center">
									<b>Maaf, saldo anda kurang dari '.$_POST['cair'].'</b>
								</div>											
								';
							}else{
								$jumlah_pencairan = $_POST['cair'];
								$bank_tujuan = $_POST['bank'];
								$bank_cabang = $_POST['cabang'];
								$bank_pemilik = $_POST['nama'];
								$bank_rekening = $_POST['rekening'];
								$stmt = $mysqli->query("INSERT INTO tbl_dompet_pencairan(id_user,jumlah_pencairan,bank_tujuan,bank_cabang,bank_pemilik,bank_rekening,status_pencairan) 
								VALUES(".$_COOKIE['login_id'].",".$jumlah_pencairan.",'".$bank_tujuan."','".$bank_cabang."','".$bank_pemilik."','".$bank_rekening."','pending')");
								if($stmt){
									$stmt = $mysqli->query("insert into tbl_dompet_mutasi(id_user,tipe_mutasi,jumlah_mutasi,deskripsi_mutasi,status_mutasi) 
									values(".$_COOKIE['login_id'].",'-',".$jumlah_pencairan.",'Pencairan Saldo','pending')");
									$stmt2 = $mysqli->query("update tbl_user SET saldo_dompet=(saldo_dompet-$jumlah_pencairan) WHERE id_user=".$_COOKIE['login_id']."");
									if($stmt AND $stmt2){
										echo '
										<div class="divider divider--xs"></div>
											<div class="alert alert-success" role="alert" align="center">
											<b>Riwayat mutasi saldo sudha diperbaharui</b>
										</div>											
										';
									}else{
									echo '
										<div class="divider divider--xs"></div>
											<div class="alert alert-danger" role="alert" align="center">
											<b>Gagal memperbaharui riwayat mutasi saldo</b>
										</div>											
										';										
									}
									echo '
									<div class="divider divider--xs"></div>
										<div class="alert alert-success" role="alert" align="center">
										<b>Pencairan saldo sebesar Rp '.setHarga($_POST['cair']).' sudah kami terima, silahkan tunggu konfirmasi admin</b>
									</div>											
									';
								}else{
									echo '
									<div class="divider divider--xs"></div>
										<div class="alert alert-warning" role="alert" align="center">
										<b>Gagal melakukan permintaan pencaira, silahkan coba lagi nanti</b>
									</div>											
									';
								}								
							}
						}
					?>
                            <form class="form-horizontal" action="" method="post">
                                <div class="form-group">
                                    <label for="cair" class="col-sm-3 control-label">Jumlah Pencairan Dana</label>
                                    <div class="col-sm-9">
                                        <input type="number" class="form-control" id="cair" name="cair" placeholder="Minimum Pencairan Dana Rp. 100.000 ">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="bank" class="col-sm-3 control-label">Nama Bank Tujuan</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="bank" name="bank" placeholder="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="cabang" class="col-sm-3 control-label">Kantor Cabang</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="cabang" name="cabang" placeholder="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="nama" class="col-sm-3 control-label">Nama Pemilik Rekening</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="nama" name="nama" placeholder="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="rekening" class="col-sm-3 control-label">Nomor Rekening</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="rekening" name="rekening" placeholder="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-offset-3 col-sm-9">
                                        <button type="submit" name="btnPencairanSaldo" class="btn btn-green btn-theme-colored">Cairkan Dana</button>
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
