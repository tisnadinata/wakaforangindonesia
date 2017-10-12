<?php 
include 'templates/header.php'; 

?>
<script language='javascript'>
	function validAngka(obj){
		var pola = "^";
		pola += "[0-9]*";
		pola += "$";
		rx = new RegExp(pola);
	 
		if (!obj.value.match(rx)){
			if (obj.lastMatched){
				obj.value = obj.lastMatched;
			}else{
				obj.value = "";
			}
		}else{
			obj.lastMatched = obj.value;
		}
	}
</script>
<div class="main-content">
    <!-- Section: Konfirmasi Wakaf -->
    <section>
        <div class="boxed-layout">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="section-title">
                            <h2 class="mt-10 text-theme-colored font-weight-700 letter-space-1 text-uppercase text-center font-32 heading-title">Keranjang Wakaf Woi</h2>
                        </div>
                    </div>
                </div>
			<?php
				if(!isset($_POST['btnFinish'])){
			?>
                <div class="row">
                    <div class="col-md-8 col-md-offset-2 col-xs-12">
                        <div class="section-content">
                            <div class="horizontal-tab-centered text-center">
                                <ul class="nav nav-pills">
								<?php 
									if(isset($_POST['btnPrev']) OR !isset($_POST['btnNext'])){
										echo'<li class="active">';
									}else{
										echo'<li>';										
									}
								?>                                    
                                        <a class="text-center font-20 font-weight-600">1. KONFIRMASI WAKAF</a>
                                    </li>
								<?php 
									if(isset($_POST['btnNext'])){
										echo'<li class="active">';
									}else{
										echo'<li>';										
									}
								?>                                    
                                        <a class="text-center font-20 font-weight-600">2. PEMBAYARAN</a>
                                    </li>
                                </ul>
                            </div>

                            <!-- Tabs -->
                            <div class="tab-content" style="border : 3px solid #eee;border-radius:5px;">
								<?php
									if(isset($_COOKIE['login_id'])){
										$id_user = $_COOKIE['login_id'];									
									}else{
										$id_user = getIpCustomer();
									}
									$stmt = $mysqli->query("select * from tbl_wakaf_donasi_temp where id_user = '".$id_user."'");
									$total_wakaf = 0;
								?>
                                <!-- Tab Konfirmasi Wakaf -->
								<?php 
									if(isset($_POST['btnPrev']) OR !isset($_POST['btnNext'])){
										echo'<div class="tab-pane fade in active" id="tab-konfirmasi-wakaf">';
									}else{
										echo'<div class="tab-pane fade in" id="tab-konfirmasi-wakaf">';										
									}
								?>                                                                    
                                    <p class="text-theme-colored text-uppercase font-weight-600">KERANJANG WAKAF</p>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th class="text-theme-colored font-20 font-weight-700">Nama Proyek Wakaf</th>
                                                    <th class="text-theme-colored font-20 font-weight-700">Nominal Wakaf</th>
                                                    <th class="text-theme-colored font-20 font-weight-700" style="width:30%;">Tambahan Operasional BWA</th>
                                                </tr>
                                            </thead>
                                            <tbody>
												<?php
													$i=1;
													while($list_donasi = $stmt->fetch_object()){
														$data_proyek = getDataByCollumn("tbl_wakaf_proyek","id_wakaf_proyek",$list_donasi->id_wakaf_proyek);
														$biaya_operasional = ($list_donasi->jumlah_wakaf*$list_donasi->operasional/100);
														$total_biaya = $list_donasi->jumlah_wakaf+$biaya_operasional;
														echo'
															<tr>
																<td>'.$i.'. '.$data_proyek->nama_proyek.'</td>
																<td>Rp. '.setHarga($list_donasi->jumlah_wakaf).'</td>
																<td>Rp. '.setHarga($biaya_operasional).' ('.$list_donasi->operasional.'%)</td>
															</tr>
														';
														$total_wakaf = $total_wakaf+$total_biaya;
														$_SESSION['checkout_proyek'] = $list_donasi->id_wakaf_proyek;
														$i++;
														
													}
												?>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="2" class="bg-theme-colored text-uppercase text-white font-20 font-weight-700">Total Nominal Wakaf</td>
													<input type="hidden" name="txtTotalWakaf" value="<?php echo $total_wakaf;?>" >
                                                    <td class="bg-theme-colored text-uppercase text-white font-20 font-weight-700">Rp. <?php echo setHarga($total_wakaf);?></td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>

                                    <!-- Reward -->
                                    <div class="reward text-center">
                                        <p class="font-22 font-weight-700">Pilih Reward</p>

                                        <p class="text-theme-colored font-18 font-weight-500">Reward adalah apresiasi yang disediakan oleh Badan Wakaf Al-Quran pada event tertentu untuk anda.</p>
                                    </div>
									<form method="post" action="">
										<div class="table-responsive">
											<table class="table">
												<tbody>
													<tr>
														<td>
															<div class="radio">
																<label>
																	<input type="checkbox" name="txtReward" id="txtReward" value="Tanpa Reward">&nbsp Tanpa Reward
																</label>
															</div>

															<p>Saya hanya ingin berdonasi, tidak mengambil reward.</p>
														</td>
													</tr>
													<tr>
														<td>
															<div class="radio">
																<label>
																	<input type="checkbox" name="txtBaju" id="txtBaju" value="Pesan Baju">&nbsp Rp 100.000,00
																</label>
															</div>
															<div class="reward font-weight-700">
																<p>Kaos yang bertuliskan "KADO UNTUK IBU" yang dibuat oleh Badan Wakaf Al-Quran yang akan dikirimkan ke Wakif</p>
															</div>
														</td>
													</tr>
													<tr>
														<td class="text-center text-black bg-gray-lightgray">
															<label>
																<input type="checkbox" name="txtStatusWakif"><span class="font-weight-600">&nbsp Wakaf dengan Anonim</span>
															</label>
														</td>
													</tr>
												</tbody>
											</table>
										</div>
										<!-- End of Reward -->
										<!-- Payment Method -->
										<div class="payment-method table-responsive">
											<table class="table">
												<tbody>
													<tr>
														<td width="50%">
															<div class="radio">
																<label>
																	<input type="radio" name="transfer" id="transfer1" value="Transfer BCA" checked>Transfer BCA
																</label>
															</div>
														</td>
														<td>
															<div class="radio">
																<label>
																	<input type="radio" name="transfer" id="transfer2" value="Transfer BCA">Transfer BNI
																</label>
															</div>
														</td>
													</tr>
													<tr>
														<td>
															<div class="radio">
																<label>
																	<input type="radio" name="transfer" id="transfer3" value="Transfer Mandiri">Transfer Mandiri
																</label>
															</div>
														</td>
														<td>
															<div class="radio">
																<label>
																	<input type="radio" name="transfer" id="transfer4" value="PayPal" disabled>PayPal
																</label>
															</div>
														</td>
													</tr>
													<tr>
														<td>
															<div class="radio">
																<label>
																	<input type="radio" name="transfer" id="transfer5" value="Credit Card" disabled>Credit Card
																</label>
															</div>
														</td>
														<td>
															<div class="radio">
																<label>
																	<input type="radio" name="transfer" id="transfer6" value="Google Wallet" disabled>Google Wallet
																</label>
															</div>
														</td>
													</tr>
													<tr>
														<td colspan="2" class="text-black bg-gray-lightgray">
															<label>
																<input type="checkbox" name="kebijakan" id="kebijakan" required>&nbsp Saya setuju dengan Syarat & Ketentuan Wakaf di wor.or.id
															</label>
														</td>
													</tr>
													<tr>
														<td colspan="2" >
															<div class="lanjutkan-pembayaran text-center pull-right">
																<?php
																	if($total_wakaf == 0){
																		echo'
																			<button class="btn btn-colored btn-theme-colored font-18 font-weight-600" disabled>Lanjutkan Pembayaran  &nbsp ></button>
																		';
																	}else{
																		echo'
																			<button class="btn btn-colored btn-theme-colored font-18 font-weight-600" type="submit" id="btnNext" name="btnNext">Lanjutkan Pembayaran  &nbsp ></button>
																		';
																	}
																?>
															</div>
														</td>
													</tr>
												</tbody>
											</table>
										</div>
										<!-- End of Payment Method -->
                                </div>
								</form>
                                <!-- End of Tab Konfirmasi Wakaf -->
                                <!-- Tab Pembayaran -->
								<?php 
									if(isset($_POST['btnNext'])){
										echo'<div class="tab-pane fade in active" id="tab-pembayaran">';
										$_SESSION['checkout_kode'] = getKodeUnik();
										$_SESSION['checkout_sub'] = $total_wakaf;
										if(isset($_POST['txtReward'])){
											$_SESSION['checkout_reward'] = 0;
										}else{
											$_SESSION['checkout_reward'] = 100000;
										}
										if(!isset($_POST['txtBaju'])){
											$_SESSION['checkout_baju'] = 0;
										}else{
											$_SESSION['checkout_baju'] = 100000;
										}
										if(!isset($_POST['txtStatusWakif'])){
											$_SESSION['checkout_wakif'] = "normal";
										}else{
											$_SESSION['checkout_wakif'] = "anonim";
										}
										$_SESSION['checkout_total'] = $_SESSION['checkout_sub']+$_SESSION['checkout_kode']+$_SESSION['checkout_reward']+$_SESSION['checkout_baju'];
									}else{
										echo'<div class="tab-pane fade in" id="tab-pembayaran">';										
									}
								?>     
								<form action="" method="post">
								<div style="" class="row">
                                    <p class="text-theme-colored text-uppercase font-weight-600"> &nbsp DETAIL WAKAF</p>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <caption class="text-center font-weight-700 font-18">Ringkasan Transaksi Anda</caption>
                                            <tbody>
                                                <tr>
                                                    <td>Wakaf Anda</td>
                                                    <td>Rp. <?php echo setHarga($_SESSION['checkout_sub']);?></td>
                                                </tr>
                                                <tr>
                                                    <td>Kode Unik</td>
                                                    <td><?php echo $_SESSION['checkout_kode'];?></td>
                                                </tr>
                                                <tr>
                                                    <td>Reward Event</td>
                                                    <td>Rp. <?php echo setHarga($_SESSION['checkout_reward']);?></td>
                                                </tr>
                                                <tr>
                                                    <td>Pesan Baju</td>
                                                    <td>Rp. <?php echo setHarga($_SESSION['checkout_baju']);?></td>
                                                </tr>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td class="bg-white text-theme-colored font-24 font-weight-700">Total Yang Harus Dibayar</td>
                                                    <td class="bg-white text-theme-colored font-24 font-weight-700">Rp. <?php echo setHarga($_SESSION['checkout_total']);?></td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                    <div class="radio text-center">
                                        <label>
                                            <input type="radio">Ingatkan saya untuk berwakaf tiap bulan pada proyek ini
                                        </label>
                                    </div>
										<div style="" class="col-md-12">
											<p>Transfer tepat Rp. <?php echo setHarga($_SESSION['checkout_total']);?> (nominal donasi + kode unik) ke salah satu bank dibawah agar donasi Anda dapat terverifikasi secara mudah oleh kami.</p>
											<p>Detail Pembayaran :</p>
											<table class="table table-bordered">
												<tr style="background-color: #004922;color:white;">
													<th>ATAS NAMA</th>
													<th>NAMA BANK</th>
													<th>NOMOR REKENING</th>
												<tr>
											<?php
												$_SESSION['checkout_metode'] = $_POST['transfer'];
												$stmt2 = $mysqli->query("select * from tbl_bank where id_user=0 and tipe_bank ='admin'");
												while($data = $stmt2->fetch_object()){
													echo"
													<tr>
														<td>".$data->atas_nama."</td>
														<td>".$data->nama_bank."</td>
														<td>".$data->rekening_bank."</td>
													<tr>
													";
												}
												?>
											</table>											
											<?php
											echo"
											<input type='hidden' name='checkout_proyek' value='".$_SESSION['checkout_proyek']."' />
											<input type='hidden' name='checkout_total' value='".$_SESSION['checkout_total']."' />
											<input type='hidden' name='checkout_kode' value='".$_SESSION['checkout_kode']."' />
											<input type='hidden' name='checkout_metode' value='".$_SESSION['checkout_metode']."' />
											<input type='hidden' name='checkout_wakif' value='".$_SESSION['checkout_wakif']."' />
											";
											?>
										</div>
										<?php
											if(!isset($_COOKIE['login_id'])){
												echo'
												<div class="col-md-12 text-center">
													<h2>Identitas anda</h2>
													<p>Masuk atau tulis email Anda untuk mendapatkan laporan perkembangan dari proyek wakaf ini</p>

												<a href="login.php?provider=facebook&wakaf=1" class="btn btn-primary text-center btn-facebook text-uppercase"><i class="fa fa-facebook"></i>&nbsp Masuk dengan Facebook</a>
												<a href="login.php?provider=google&wakaf=1" class="btn btn-danger text-center btn-google-plus text-uppercase"><i class="fa fa-google-plus"></i>&nbsp Masuk dengan Google</a>

													<div class="mt-20 text-uppercase">Atau</div>
													<br>
														<div class="form-group col-md-5 col-md-offset-1 col-xs-12">
															<input type="text" name="txtNamaLengkap" class="input-nama form-control" placeholder="Nama Lengkap">
														</div>
														<div class="form-group col-md-5 col-xs-12">
															<input type="email" name="txtEmail" class="input-email form-control" placeholder="Email Address">
														</div>

														<div class="form-group col-md-12">
															<p>Pastikan nomor ini aktif untuk menerima SMS status donasi Anda:</p>
														</div>										
														<div class="form-group col-md-6 col-md-offset-3 col-xs-12">
															<input type="text" onKeyUp="validAngka(this)" name="txtTelepon" class="input-nohp form-control text-center" placeholder="Masukan Nomor HP Anda, angka saja.">
														</div>										
												</div>			
												';
											}
										?>
										<div style="" class="col-md-12">
										<hr>
										</div>			
										<div style="" class="col-md-3 col-xs-5">
											<button name="btnPrev" class="btn btn-colored btn-theme-colored text-uppercase border-bottom-2px fullwidth font-weight-700">< Kembali</button>
										</div>
										<div style="" class="col-md-3 col-xs-6 pull-right">
											<button name="btnFinish" class="btn btn-colored btn-theme-colored text-uppercase border-bottom-2px fullwidth font-weight-700">Bayar wakaf</button>
										</div>
                                </div>
                                </div>
								<form>
                                <!-- End of Tab Pembayaran -->
                            </div>
                            <!-- End of Tabs -->
                        </div>
                        <!-- End of Section Content -->
                    </div>
                </div>
			<?php		
				}else if(isset($_POST['btnFinish'])){
					if(!isset($_COOKIE['login_id'])){
						if(empty($_POST['txtNamaLengkap']) OR empty($_POST['txtEmail']) OR empty($_POST['txtTelepon'])){
							echo '		
							<div class="divider divider--xs"></div>
								<div class="alert alert-danger" role="alert" align="center">
									<b>Informasi kontak harus anda isi untuk mendapatkan info dari kami... !!</b>
								</div>
							';
						}else{
							$nama_lengkap = $_POST['txtNamaLengkap'];
							$email = $_POST['txtEmail'];
							$telepon = $_POST['txtTelepon'];
							$stmt = $mysqli->query("INSERT INTO tbl_user(username,nama_lengkap,email,telepon,tipe_user) VALUES('$email','$nama_lengkap','$email','$telepon','wakif')");
							$stmt2 = $mysqli->query("INSERT INTO tbl_login(username,email,password,hak_akses) VALUES('$email','$email','$email','wakif')");							
							if($stmt AND $stmt2 AND $stmt3){
								sleep(1);
								$stmt = $mysqli->query("select * from tbl_user where nama_lengkap='$nama_lengkap' AND email='$email' AND telepon='$telepon' AND tipe_user='wakif'");
								$data_user = $stmt->fetch_object();
								$stmt= $mysqli->query("UPDATE tbl_wakaf_donasi_temp SET id_user='".$data_user->id_user."' WHERE id_user='".getIpCustomer()."'");
								$id_user = $data_user->id_user;
								$mysqli->query("INSERT INTO tbl_user_verifikasi(id_user,email_verifikasi,status_verifikasi) VALUES('".$data_user->id_user."',1,'belum')");																		
							}
							finishCheckout($id_user);
						}
					}else{
						$email = $_COOKIE['login_email'];
						$telepon = $_COOKIE['login_telepon'];
						finishCheckout($id_user);
					}				
				}
			?>
            </div>
        </div>
    </section>
<br>
<?php 
function finishCheckout($id_user){
	global $mysqli;
	global $email;
	global $telepon;
					$checkout_proyek = $_POST['checkout_proyek'];
					$checkout_total = $_POST['checkout_total'];
					$checkout_kode = $_POST['checkout_kode'];
					$checkout_metode = $_POST['checkout_metode'];
					$checkout_wakif = $_POST['checkout_wakif'];
					$stmt = $mysqli->query("insert into tbl_wakaf_donasi(id_wakaf_proyek,id_user,jumlah_wakaf,kode_wakaf,metode_pembayaran,status_wakif) 
					VALUES(".$checkout_proyek.",'".$id_user."',".($checkout_total-$checkout_kode).",".$checkout_kode.",'".$checkout_metode."','".$checkout_wakif."')");
					// $stmt = $mysqli->query("insert into tbl_wakaf_donasi(id_wakaf_proyek,id_user,jumlah_wakaf,kode_wakaf,metode_pembayaran,status_wakif) 
					// VALUES(".$_SESSION['checkout_proyek'].",'".$id_user."',".($_SESSION['checkout_total']-$_SESSION['checkout_kode']).",".$_SESSION['checkout_kode'].",'".$_SESSION['checkout_metode']."','".$_SESSION['checkout_wakif']."')");
					if($stmt){
						$stmt = $mysqli->query("DELETE FROM tbl_wakaf_donasi_temp WHERE id_user='".$id_user."'");
						$cari_donasi = $mysqli->query("select * from tbl_wakaf_donasi where id_user='".$id_user."' ORDER BY id_wakaf_donasi DESC");
						$data_donasi = $cari_donasi->fetch_object();
						if($_SESSION['checkout_baju']>0){
							$status_baju = "Pesan Baju";
						}else{
							$status_baju = "Tidak Pesan";
						}
						if($_SESSION['checkout_reward']>0){
							$status_reward = "Reward";
						}else{
							$status_reward = "Tanpa Reward";
						}
						$stmt2 = $mysqli->query("insert into tbl_wakaf_donasi_option(id_wakaf_donasi,status_reward,status_baju) 
						VALUES(".$data_donasi->id_wakaf_donasi.",'".$status_reward."','".$status_baju."')");
						$stmt3 = $mysqli->query("insert into tbl_wakaf_donasi_status(id_wakaf_donasi,deskripsi_status,status_wakaf) 
						VALUES(".$data_donasi->id_wakaf_donasi.",'Menunggu Pembayaran','pending')");
						echo'
							<div class="panel panel-body panel-success col-md-12 text-center">
								<h4>TERIMAKASIH TELAH PERCAYA KEPADA KAMI, DONASI ANDA AKAN SANGAT BERMANFAAT <br> SILAHKAN LAKUKAN PEMBAYARAN PALING LAMBAT 4 JAM DARI SEKARANG</h4>
							</div>
						';
						if($stmt AND $stmt2 AND $stmt3){
							kirimSMS("Permintaan wakaf kami tersima. Silahkan lakukan pembayaran dan cek email anda untuk detail wakaf",$telepon);
							kirimEmail("Donasi Wakaf Orang Indonesia","Terimakasih, donasi anda sedang kami proses, silahkan lakukan pembayaran paling lambat 4 jam dari sekarang dan login dengan username & password menggunakan email untuk konfirmasi pembayaran. Untuk melihat detail wakaf anda silahkan login dibagian member area",$email);
							echo'
								<div class="panel panel-body panel-success col-md-12 text-center">
									<h4>KERANJANG WAKAF SUDAH KAMI KOSONGKAN.</h4>
								</div>
							';
						}else{
							echo'
								<div class="panel panel-body panel-danger col-md-12 text-center">
									<h4>GAGAL MENGOSONGKAN KERANJANG WAKAF ANDA</h4>
								</div>							
							';
						}
					}else{					
						echo'
							<div class="panel panel-body panel-danger col-md-12 text-center">
								MAAF, PERMINTAAN WAKAF ANDA GAGAL KAMI TERIMA.<BR> SILAHKAN LAKUKAN BEBERAPA SAAT LAGI
							</div>							
						';
					}	
}
include 'templates/footer.php'; ?>
