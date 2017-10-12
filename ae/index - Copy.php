<?php
	include 'templates/header.php'; 
	$url=getUrlWeb();
?>
<script language='javascript'>
		function kirimOtp(){
			var nama = document.getElementById("telepon").value;			
			var dataString = "kirim_otp="+nama;
			$.ajax({
				type: "POST",
				url: "<?php echo getUrlWeb();?>/ajax.php",	
				data: dataString,
				cache: false,
				success: function(html) {
					document.getElementById("kode_otp").setAttribute("value",html);						
				}		
			});	
		}
		function cekOtp(){
			var nama = document.getElementById("otp").value;			
			var otp = document.getElementById("kode_otp").value;			
			var dataString = "cek_otp="+nama+"-"+otp;
			$.ajax({
				type: "POST",
				url: "<?php echo getUrlWeb();?>/ajax.php",	
				data: dataString,
				cache: false,
				success: function(html) {
					if(html == "success"){
						document.getElementById("result_cek_otp").innerHTML = "<label class='label label-success'>KODE OTP COCOK</label> <br>";
						document.getElementById("lanjutRegister").removeAttribute("disabled");
						document.getElementById("otp").setAttribute("readonly","");						
					}else{
						document.getElementById("result_cek_otp").innerHTML = "<label class='label label-danger'>KODE OTP TIDAK COCOK</label> <br>";
					}
				}		
			});	
		}
		function cekUsername(){
			var nama = document.getElementById("form_choose_username").value;			
			var dataString = "cek_username="+nama;
			$.ajax({
				type: "POST",
				url: "<?php echo getUrlWeb();?>/ajax.php",	
				data: dataString,
				cache: false,
				success: function(html) {
					document.getElementById("result_cek_username").innerHTML = html;
				}		
			});	
		}
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
    <section class="inner-header divider parallax layer-overlay overlay-dark-5" style="height:auto !important;" data-stellar-background-ratio="0.5" data-bg-img="../images/campaign/kids.jpg">
        <div class="container pt-100 pb-50">
            <!-- Section Content -->
            <div class="section-content pt-100">
                <div class="row">
                    <div class="col-md-12">
                        <h3 class="title text-white">Buat Akun Executive</h3>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-md-push-3">
                        <div class="icon-box mb-0 p-0">
                            <a href="#" class="icon icon-bordered icon-rounded icon-sm pull-left mb-0 mr-10">
                                <i class="pe-7s-users"></i>
                            </a>
                            <h4 class="text-gray pt-10 mt-0 mb-30">Buat akun executive mu sekarang.</h4>
                        </div>
                        <hr>
						<?php
							if(isset($_POST['lanjutRegister'])){
								$nama_lengkap=$_POST['nama_lengkap'];
								$alamat=$_POST['alamat'];
								$email=$_POST['email'];
								$url_facebook=$_POST['facebook'];
								$url_twitter=$_POST['twitter'];
								$telepon=$_POST['telepon'];
								$biografi=$_POST['biografi_singkat'];
								$username=$_POST['form_choose_username'];
								$password=$_POST['form_choose_password'];
								$repassword=$_POST['form_re_enter_password'];								
								if(cekUsername($username) == 0){
									if($password == $repassword){
										//UPLOAD FOTO
										$ok_ext = array('jpg','png','jpeg'); // allow only these types of files
										$destination = "images/user/";
										$file = $_FILES['foto_profil'];
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
												$fileNewName = 'foto_'.str_replace(" ","",$username).'.'.$file_extension ;
												$fileNewName2 = 'ktp_'.str_replace(" ","",$username).'.'.$file_extension2 ;
												// and move it to the destination folder
												if( move_uploaded_file($file['tmp_name'], "../".$destination.$fileNewName) ){
													if( move_uploaded_file($file2['tmp_name'], "../".$destination.$fileNewName2) ){
														$url_foto = $destination.$fileNewName;
														$url_ktp = $destination.$fileNewName2;
														
														$stmt = $mysqli->query("INSERT INTO tbl_user(username,nama_lengkap,alamat,email,url_facebook,url_twitter,telepon,biografi,url_foto,tipe_user) VALUES('".$username."','".$nama_lengkap."','".$alamat."','".$email."','".$url_facebook."','".$url_twitter."','".$telepon."','".$biografi."','".$url_foto."','ae')");
														$stmt2 = $mysqli->query("INSERT INTO tbl_login(username,password,email,hak_akses) VALUES('".$username."','".$password."','".$email."','wakif')");
														if($stmt){
															$url_verifikasi=$url."/verifikasiEmail.php?u=$username&p=$password&e=$email";
															$isi = "Selamat anda sudah bergabung dengan kami di woi.or.id, untuk aktivasi akun anda silahkan klik link berikut <a href='$url_verifikasi' target='_blank'>Aktivasi Akun</a>";
															kirimEmail("Registrasi woi.or.id",$isi,$email);
															kirimSMS("Anda berhasil daftar sebagai executive, menunggu konfirmasi admin",$telepon);
															$id_user = getDataByCollumn("tbl_user","username","'".$username."'");
															$stmt3 = $mysqli->query("INSERT INTO tbl_user_verifikasi(id_user,url_ktp,email_verifikasi,status_verifikasi) VALUES('".$id_user->id_user."','".$url_ktp."',1,'belum')");
															echo '		
															<div class="divider divider--xs"></div>
																<div class="alert alert-success" role="alert" align="center">
																	<b>Pendaftaran berhasil, akun anda sudah diverifikasi. Menunggu konfirmasi dari admin</b>
																</div>
															';
														}else{
															echo '		
															<div class="divider divider--xs"></div>
																<div class="alert alert-danger" role="alert" align="center">
																	<b>Gagal Login, username atau password salah... !!</b>
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
										}
									}else{
										echo '		
										<div class="divider divider--xs"></div>
											<div class="alert alert-danger" role="alert" align="center">
												<b>Password tidak cocok.</b>
											</div>
										';
									}
								}else{
									echo '		
										<div class="divider divider--xs"></div>
											<div class="alert alert-danger" role="alert" align="center">
											<b>Username sudah dipakai orang lain</b>
										</div>
									';
								}
							}
						?>
                        <p class="text-gray">Dapatkan kemudahan dalam melakukan wakaf atau donasi dengan menjadi member kami, anda akan mendapat notifikasi proyek wakaf dan donasi. Serta anda akan dapat melihat jumlah wakaf yang sudah anda donasi kan dan juga riwayat mutasi donasi anda.</p>
						<hr>
						<?php
							if(isset($_POST['btnRegister']) AND cekEmail($_POST['email']) == 0 ){
								$nama_lengkap=$_POST['nama_lengkap'];
								$alamat=$_POST['alamat'];
								$email=$_POST['email'];
								$url_facebook=$_POST['facebook'];
								$url_twitter=$_POST['twitter'];
								$telepon=$_POST['telepon'];
								$biografi=$_POST['biografi_singkat'];
								$username=$_POST['form_choose_username'];
								$password=$_POST['form_choose_password'];
								$repassword=$_POST['form_re_enter_password'];								
								$_SESSION['otp'] = generateOTP();
								kirimSMS("Kode OTP Registrasi woi.or.id anda : ".$_SESSION['otp'],$telepon);
								echo'
								<form name="reg-form" class="register-form" method="post" enctype="multipart/form-data">
									<div class="row">
										<div class="form-group col-md-7">
											<label for="otp">OTP dikirim melalui sms ( <a href="#" onclick="kirimOtp()" style="color:green;"><b>kirim ulang</b></a> ).</label>
											<input id="otp" name="otp" class="form-control" type="text" placeholder="Masukan OTP pada sms di telepon anda">
										</div>                            
										<div class="form-group col-md-5" align="center">
											<label for="cek_username" id="result_cek_otp"><label class="label label-info">VERIFIKASI OTP ANDA</label> <br></label>
											<a id="cek_username" onclick="cekOtp()" class="form-control btn btn-success"><label style="font-size:1.5em;">VERIFIKASI OTP</label></a>
										</div>                            
									</div>
									<div class="row">
										<div class="form-group col-md-12">
											<label for="form_choose_username">Data Pribadi :</label>
										</div>
									</div>
									<div class="row">
										<div class="form-group col-md-6">
											<label for="form_choose_username">Foto Profil</label>
											<input id="foto_profil" type="file" class="form-control" name="foto_profil" class="file" required>
										</div>
										<div class="form-group col-md-6">
											<label for="form_choose_username">Foto KTP</label>
											<input id="foto_ktp" type="file" class="form-control" name="foto_ktp" class="file" required>
										</div>
									</div>
									<div class="form-group">
										<button class="btn btn-dark btn-lg btn-block mt-15" id="lanjutRegister" name="lanjutRegister" type="submit" disabled	>Lanjutkan Registrasi</button>
									</div>
								<input type="hidden" id="kode_otp" value="'.generateOTP().'-'.$_SESSION['otp'].'-'.generateOTP().'"/>
								<input type="hidden" name="nama_lengkap" value="'.$nama_lengkap.'" />
								<input type="hidden" name="alamat" value="'.$alamat.'" />
								<input type="hidden" name="email" value="'.$email.'" />
								<input type="hidden" name="facebook" value="'.$url_facebook.'" />
								<input type="hidden" name="twitter" value="'.$url_twitter.'" />
								<input type="hidden" id="telepon" name="telepon" value="'.$telepon.'" />
								<input type="hidden" name="biografi_singkat" value="'.$biografi.'" />
								<input type="hidden" name="form_choose_username" value="'.$username.'" />
								<input type="hidden" name="form_choose_password" value="'.$password.'" />
								<input type="hidden" name="form_re_enter_password" value="'.$repassword.'" />
								</form>
								';
							}else{
								if(isset($_POST['btnRegister']) AND cekEmail($_POST['email']) != 0 ){
									echo '		
										<div class="divider divider--xs"></div>
											<div class="alert alert-danger" role="alert" align="center">
											<b>Email <b>'.$_POST['email'].'</b> sudah dipakai , gunakan email lain</b>
										</div>
									';
								}
						?>
						
                    <form name="reg-form" class="register-form" method="post"  enctype="multipart/form-data">
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="form_choose_username">Data Pribadi :</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="form_name">Nama Lengkap</label>
                                <input id="form_name" name="nama_lengkap" class="form-control" type="text">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="form_name">Alamat Lengkap</label>
                                <input id="form_name" name="alamat" class="form-control" type="text">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="form_name">Telepon</label>
                                <input id="form_name" name="telepon" class="form-control" onKeyUp="validAngka(this)"  placeholder="08123456789" type="text">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Email</label>
                                <input id="form_email" name="email" class="form-control"  placeholder="email@woi.or.id" type="email">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="form_name">Facebook</label>
                                <input id="form_name" name="facebook" class="form-control" placeholder="http://www.facebook.com/profil" type="text">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Twtiter</label>
                                <input id="form_email" name="twitter" class="form-control" placeholder="http://www.twitter.com/profil" type="text">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="form_choose_username">Biografi Singkat</label>
								<textarea class="form-control" name="biografi_singkat" rows="5" cols="28" width="100%" style="resize:none;" placeholder="Biografi singkat yang menjelaskan diri anda"></textarea>
                            </div>
                        </div>
						<hr>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="form_choose_username">Data Login :</label>
                            </div>
                        </div>
                       <div class="row">
                            <div class="form-group col-md-8">
                                <label for="form_choose_username">Username</label>
                                <input id="form_choose_username" name="form_choose_username" class="form-control" type="text" placeholder="Username untuk login">
                            </div>
                            <div class="form-group col-md-4" align="center">
                                <label for="cek_username" id="result_cek_username"> <label class='label label-info'>CEK USERNAME ANDA</label> <br></label>
                                <a id="cek_username" onclick="cekUsername()" class="form-control btn btn-success"><label style="font-size:1.5em;">CEK</label></a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="form_choose_password">Password</label>
                                <input id="form_choose_password" name="form_choose_password" class="form-control" type="password">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Ulangi Password</label>
                                <input id="form_re_enter_password" name="form_re_enter_password"  class="form-control" type="password">
                            </div>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-dark btn-lg btn-block mt-15" name="btnRegister" type="submit">Daftar Sekarang</button>
                        </div>
                    </form>
						<?php								
							}					
						?>
                </div>
            </div>
        </div>
    </section>
</div>  <!-- end main-content -->

<?php include 'templates/footer.php'; ?>

