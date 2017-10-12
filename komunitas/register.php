<?php 
include 'templates/header.php'; 
	$url = getUrlWeb();
/**
	LOGIN OAUTH
**/
/*
* We need this function cause I'm lazy
**/
function mysqli_query_excute( $sql ){
	global $mysqli;
	$stmt = $mysqli->query($sql); 
	if($stmt){
		return $stmt;
	}else{
		return false;
	}
}
 
/*
* get the user data from database by provider name and provider user id
**/
function get_user_by_provider_and_id( $provider_name, $provider_user_id, $email ){
	global $mysqli;
	$sql = "SELECT * FROM tbl_user WHERE (hybridauth_provider_name = '$provider_name' AND hybridauth_provider_uid = '$provider_user_id') OR email = '$email'";
	$stmt = $mysqli->query($sql); 
	if($stmt->num_rows > 0){
		return true;
	}else{
		return false;
	}
}
 
/*
* get the user data from database by provider name and provider user id
**/
function create_new_hybridauth_user( $email, $first_name, $last_name, $url_foto, $provider_name, $provider_user_id ){
	global $mysqli;
	// let generate a random password for the user
	$password = md5( str_shuffle( "0123456789abcdefghijklmnoABCDEFGHIJ" ) );
	$username = explode("@",$email);
	$username = $username[0];
	$nama_lengkap = $first_name.' '.$last_name;
	$sql_login = "INSERT INTO tbl_login(username,email,password,hak_akses) 
		VALUES('$username','$email','$email','wakif')";
	mysqli_query_excute($sql_login);
	$sql_user = "INSERT INTO tbl_user(username,nama_lengkap,email,url_foto,tipe_user,hybridauth_provider_name,hybridauth_provider_uid) 
		VALUES('$username','$nama_lengkap','$email','$url_foto','wakif','$provider_name','$provider_user_id')";
	mysqli_query_excute($sql_user);
	$sql = "SELECT * FROM tbl_user WHERE hybridauth_provider_name = '$provider_name' AND hybridauth_provider_uid = '$provider_user_id'";
	$stmt2 = $mysqli->query($sql); 
	if($stmt2->num_rows > 0){
		$id_user = $stmt2->fetch_object();
		$sql_verifikasi = "INSERT INTO tbl_user_verifikasi(id_user,email_verifikasi,status_verifikasi) 
			VALUES(".$id_user->id_user.",1,'belum')";
		mysqli_query_excute($sql_verifikasi);
	}
}
/**
	LOGIN OAUTH
**/
if(isset($_COOKIE["login_id"])){
	echo'<meta http-equiv="Refresh" content="0; URL='.$url.'/area-wakif.php">';
}
if( isset( $_GET["provider"] ) ){
	// the selected provider
	$provider_name = $_GET["provider"];
	try
	{
		// inlcude HybridAuth library
		// change the following paths if necessary
		$config   = dirname(__FILE__) . '/oauth/config.php';
		require_once( "oauth/Hybrid/Auth.php" );
										 
		// initialize Hybrid_Auth class with the config file
		$hybridauth = new Hybrid_Auth( $config );
										 
		// try to authenticate with the selected provider
		$adapter = $hybridauth->authenticate( $provider_name );
										 
		// then grab the user profile
		$user_profile = $adapter->getUserProfile();
									 
		// check if the current user already have authenticated using this provider before
		$user_exist = get_user_by_provider_and_id( $provider_name, $user_profile->identifier,$user_profile->email);
											 
		// if the used didn't authenticate using the selected provider before
		// we create a new entry on database.users for him
		if( !$user_exist ){
			create_new_hybridauth_user(
				$user_profile->email,
				$user_profile->firstName,
				$user_profile->lastName,
				$user_profile->photoURL,
				$provider_name,
				$user_profile->identifier
			);
		}
		$sql = "SELECT * FROM tbl_user WHERE (hybridauth_provider_name = '".$provider_name."' AND hybridauth_provider_uid = '".$user_profile->identifier."') OR email = '".$user_profile->email."'";
		$stmt2 = $mysqli->query($sql); 
		if($stmt2->num_rows > 0){
			$data_user = $stmt2->fetch_object();
			$stmt = $mysqli->query("select * from tbl_login where username='".$data_user->username."' AND email='".$data_user->email."'");
			if($stmt->num_rows>0){
				$data = $stmt->fetch_object();																																				
				setcookie("status_login", $data->hak_akses, time()+3600,"/");
				setcookie("login_id", $data_user->id_user, time()+3600,"/");
				setcookie("login_nama", $data_user->nama_lengkap, time()+3600,"/");
				setcookie("login_saldo", $data_user->saldo_dompet, time()+3600,"/");
				setcookie("login_tipe",$data_user->tipe_user, time()+3600,"/");
				setcookie("login_telepon", $data_user->telepon, time()+3600,"/");
				setcookie("login_email", $data_user->email, time()+3600,"/");
				setcookie("login_referal", $data_user->referal, time()+3600,"/");
				setcookie("login_username", $data->username, time()+3600,"/");
				setcookie("login_password", $data->password, time()+3600,"/");
				$_SESSION["user_connected"] = true;											 
			}
		}
		
		if( !$user_exist ){		
			$isi = "Selamat anda sudah bergabung dengan kami di woi.or.id, silahkan lengkapi biodata anda di <a href='".$url."/area-wakif.php' target='_blank'>Halaman Member</a>";
			kirimEmail("Registrasi woi.or.id",$isi,$data_user->email);
		}

		echo'<meta http-equiv="Refresh" content="0; URL=index.php">';
		
		// set the user as connected and redirect him
	}catch( Exception $e ){
		echo "Ooophs, we got an error: " . $e->getMessage();
		echo " Error code: " . $e->getCode();
		echo'<meta http-equiv="Refresh" content="0; URL='.$url.'/login.php">';
	}	
}

?>
<script>
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
    <!-- Section: home -->
    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-9 col-md-offset-1">
					<div class="icon-box mb-0 p-0">						
						<h4 class="text-gray pt-10 mt-0 mb-30">Sudah punya akun? <a href="login.php" style="color:green;">Masuk di sini</a>.</h4>
                    </div>
				</div>
                <div class="col-md-3 col-md-offset-1">
					<h4 class="text-gray">Daftar dengan akun lain.</h4>
					<p class="text-gray">Daftar dengan mudah melalui akun Facebook atau Google anda.</p>				
					<a href="?provider=facebook" class="btn btn-primary text-center btn-facebook text-uppercase col-xs-12"><i class="fa fa-facebook"></i>&nbsp Daftar dengan Facebook</a>
					<h4 class="text-gray text-center"><br><br>ATAU</h4>
					<a href="?provider=google" class="btn btn-danger text-center btn-google-plus text-uppercase col-xs-12"><i class="fa fa-google-plus"></i>&nbsp Daftar dengan Google</a>
				</div>
                <div class="col-md-6" style="border-left:1px solid #eee;">
					<h4 class="text-gray">Isi Form Dibawah.</h4>				
						<?php
							if(isset($_POST['lanjutRegister'])){
								$nama1=$_POST['form_name'];
								$nama2=$_POST['form_name2'];
								$nama = $nama1." ".$nama2;
								$email=$_POST['form_email'];
								$telepon=$_POST['telepon'];
								$username=$_POST['form_choose_username'];
								$password=$_POST['form_choose_password'];
								$repassword=$_POST['form_re_enter_password'];
								if(cekUsername($username) == 0){
									if(($password == $repassword)){
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
										// If there is no error
										if( $file['error'] == 0){
											// check if the extension is accepted
											if( in_array(strtolower($file_extension), $ok_ext)){
												// check if the size is not beyond expected size
												// rename the file
												$fileNewName = 'foto_'.str_replace(" ","",$username).'.'.$file_extension ;
												// and move it to the destination folder
												if( move_uploaded_file($file['tmp_name'], "../".$destination.$fileNewName) ){
														$url_foto = $destination.$fileNewName;
														$stmt = $mysqli->query("INSERT INTO tbl_user(username,nama_lengkap,email,url_foto,tipe_user) VALUES('".$username."','".$nama."','".$email."','images/user/profile.png','wakif')");
														$stmt2 = $mysqli->query("INSERT INTO tbl_login(username,password,email,hak_akses) VALUES('".$username."','".$password."','".$email."','wakif')");
														if($stmt){
															$url_verifikasi=$url."/verifikasiEmail.php?u=$username&p=$password&e=$email";
															$isi = "Selamat anda sudah bergabung dengan kami di woi.or.id, untuk aktivasi akun anda silahkan klik link berikut <a href='$url_verifikasi' target='_blank'>Aktivasi Akun</a>";
															kirimEmail("Registrasi woi.or.id",$isi,$email);
															$id_user = getDataByCollumn("tbl_user","username","'".$username."'");
															$stmt3 = $mysqli->query("INSERT INTO tbl_user_verifikasi(id_user,status_verifikasi) VALUES('".$id_user->id_user."','belum')");
															echo '		
															<div class="divider divider--xs"></div>
																<div class="alert alert-success" role="alert" align="center">
																	<b>Pendaftaran berhasil, akun anda sudah diverifikasi</b>
																</div>
															';
														}else{
															echo '		
															<div class="divider divider--xs"></div>
																<div class="alert alert-danger" role="alert" align="center">
																	<b>Gagal mendaftar, tidak dapat menyimpan data... !!</b>
																</div>
															';
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
												<b>Password atau Email tidak cocok.</b>
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
						<?php
							if(isset($_POST['btnRegister']) AND cekEmail($_POST['form_email']) == 0 ){
								$nama1=$_POST['form_name'];
								$nama2=$_POST['form_name2'];
								$email=$_POST['form_email'];
								$telepon=$_POST['telepon'];
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
									<hr>
									<h4 class="text-gray">Orang menyukai untuk melihat siapa anda.</h4>	
									<div class="row">
										<div class="form-group col-md-4">
											<img src="images/profile.png" class="thumbnail" width="100%" />
										</div>
										<div class="form-group col-md-8">
											<label for="form_choose_username">Unggah foto anda (.jpg / .png) max : 2mb</label>
											<input id="foto_profil" type="file" name="foto_profil" class="file form-control" required>
										</div>
									</div>
									<div class="form-group">
										<button class="btn btn-dark btn-lg btn-block mt-15" id="lanjutRegister" name="lanjutRegister" type="submit" disabled	>Lanjutkan Registrasi</button>
									</div>
								<input type="hidden" id="kode_otp" value="'.generateOTP().'-'.$_SESSION['otp'].'-'.generateOTP().'"/>
								<input type="hidden" name="form_name" value="'.$nama1.'" />
								<input type="hidden" name="form_name2" value="'.$nama2.'" />
								<input type="hidden" name="form_email" value="'.$email.'" />
								<input type="hidden" id="telepon" name="telepon" value="'.$telepon.'" />
								<input type="hidden" name="form_choose_username" value="'.$username.'" />
								<input type="hidden" name="form_choose_password" value="'.$password.'" />
								<input type="hidden" name="form_re_enter_password" value="'.$repassword.'" />
								</form>
								';
							}else{
								if(isset($_POST['btnRegister']) AND cekEmail($_POST['form_email']) != 0 ){
									echo '		
										<div class="divider divider--xs"></div>
											<div class="alert alert-danger" role="alert" align="center">
											<b>Email <b>'.$_POST['form_email'].'</b> sudah dipakai, gunakan email lain</b>
										</div>
									';
								}
						?>
						<form name="reg-form" class="register-form" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="form_name">Nama Depan</label>
                                <input id="form_name" name="form_name" class="form-control" type="text" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Nama Belakang</label>
                                <input id="form_name" name="form_name2" class="form-control" type="text" required>
                            </div>
                        </div>
						<div class="row">
                            <div class="form-group col-md-6">
                                <label for="form_email">Email</label>
                                <input id="form_email" name="form_email" class="form-control" type="email required">
                            </div>
                            <div class="form-group col-md-6">
								<label for="form_name">Telepon/Handphone</label>
								<input id="form_name" name="telepon" class="form-control" onKeyUp="validAngka(this)"  placeholder="08123456789" type="text">
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
                                <input id="form_choose_password" name="form_choose_password" class="form-control" type="password" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Ulangi Password</label>
                                <input id="form_re_enter_password" name="form_re_enter_password"  class="form-control" type="password" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12">
								<input type="checkbox"required> Saya setuju dengan <a href="<?php $url."/term-conditions.php";?>" style="color:green;">Syarat & Ketentuan</a> dan <a href="<?php $url."/privacy-policy.php";?>" style="color:green;">Kebijakan Privasi</a> yang berlaku
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
