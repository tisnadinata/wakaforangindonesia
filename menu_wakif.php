					<div class="col-md-3">
						<div class="divider divider--xs"></div>
						<div class="alert alert-danger" role="alert" align="center">
							<h5>BONUS <?php echo getPengaturan("komisi_wakaf");?>% PER WAKAF DARI MEMBER AFFILIATE ANDA</h5>
								<br>
								<b style="font-size:0.9em;"><?php echo getUrlWeb()."?ref=".$_COOKIE["login_id"];?></b>
						</div>
                    <div class="sidebar sidebar-left mt-sm-30">
						<?php
							$data_user = getDataByCollumn("tbl_user","id_user",$_COOKIE['login_id']);
							if($data_user){
								if($data_user->url_foto != ''){
									$foto_profil = $data_user->url_foto;
								}else{
									$foto_profil = "images/user/profile.png";
								}
							}else{
									$foto_profil = "images/user/profile.png";
							}
							
						?>
                        <div class="thumbnail"> <a href="#"><img class="img-fullwidth" width="250" height="250" src="<?php echo $foto_profil; ?>" alt="..."></a>
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
							<?php
								if($_COOKIE['login_tipe']=="ae" OR $_COOKIE['login_tipe']=="ar"){
									echo'
										<div class="panel">
											<div class="panel-heading">
												<div class="panel-title"> <a href="campaign-saya.php"><span class="open-sub"></span>Campaign Saya </a> </div>
											</div>
										</div>
										<div class="panel">
											<div class="panel-heading">
												<div class="panel-title"> <a href="bank-saya.php"><span class="open-sub"></span>Bank Saya </a> </div>
											</div>
										</div>
									';
								}
							?>
                            <div class="panel">
                                <div class="panel-heading">
                                    <div class="panel-title"> <a data-toggle="collapse" href="#toggleDonasi"><span class="open-sub"></span>Donasi Saya </a> </div>
                                </div>
                                <div id="toggleDonasi" class="panel-collapse collapse widget">
                                    <div class="panel-body categories">
                                        <ul class="list list-border angle-double-right">
                                            <li><a href="donasi-saya.php">Daftar Donasi</a></li>
                                            <li><a href="konfirmasi-donasi.php">Konfirmasi Pembayaran Donasi</a></li>
                                        </ul>
                                    </div>
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