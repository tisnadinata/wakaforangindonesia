<?php
include 'config/connect_db.php';
$url_web =getUrlWeb();
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
	echo'<meta http-equiv="Refresh" content="0; URL=area-wakif.php">';
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
		$user_exist = get_user_by_provider_and_id( $provider_name, $user_profile->identifier, $user_profile->email );
											 
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
		$sql = "SELECT * FROM tbl_user WHERE (hybridauth_provider_name = '$provider_name' AND hybridauth_provider_uid = '$provider_user_id') OR email = '$email'";
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
			}
		}
		
		if( !$user_exist ){		
			$isi = "Selamat anda sudah bergabung dengan kami di woi.or.id, silahkan lengkapi biodata anda di <a href='".$url."/area-wakif.php' target='_blank'>Halaman Member</a>";
			kirimEmail("Registrasi woi.or.id",$isi,$data_user->email);
		}

		$_SESSION["user_connected"] = true;											 
		if(isset($_GET['wakaf'])){
			$update_keranjang = $mysqli->query("update tbl_wakaf_donasi_temp set id_user='".$data_user->id_user."' where id_user='".getIpCustomer()."'");
			if($update_keranjang){
				header("Location: ".$url_web."/konfirmasi-wakaf.php");
			}else{
				header("Location: ".$url_web."/index.php");
			}
		}else if(isset($_GET['komunitas'])){
			header("Location: ".$url_web."/komunitas/");
		}else{
			header("Location: ".$url_web."/index.php");
		}
		// set the user as connected and redirect him
	}catch( Exception $e ){
		echo "Ooophs, we got an error: " . $e->getMessage();
		echo " Error code: " . $e->getCode();
		header("Location: ".$url_web."/login.php");
	}	
}

?>
<html dir="ltr" lang="en">
<head>

    <!-- Meta Tags -->
    <meta name="viewport" content="width=device-width,initial-scale=1.0"/>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <meta name="author" content="" />

    <!-- Page Title -->
    <title>Wakaf Orang Indonesia - Amalan Abadi</title>

    <!-- Favicon and Touch Icons -->
    <link href="images/favicon.png" rel="shortcut icon" type="image/png">
    <link href="images/apple-touch-icon.png" rel="apple-touch-icon">
    <link href="images/apple-touch-icon-72x72.png" rel="apple-touch-icon" sizes="72x72">
    <link href="images/apple-touch-icon-114x114.png" rel="apple-touch-icon" sizes="114x114">
    <link href="images/apple-touch-icon-144x144.png" rel="apple-touch-icon" sizes="144x144">

    <!-- Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="css/jquery-ui.min.css" rel="stylesheet" type="text/css">
    <link href="css/animate.css" rel="stylesheet" type="text/css">
    <link href="css/css-plugin-collections.css" rel="stylesheet"/>
    <!-- CSS | menuzord megamenu skins -->
    <link id="menuzord-menu-skins" href="css/menuzord-skins/menuzord-boxed.css" rel="stylesheet"/>
    <!-- CSS | Main style file -->
    <link href="css/style-main.css" rel="stylesheet" type="text/css">
    <!-- CSS | Preloader Styles -->
    <link href="css/preloader.css" rel="stylesheet" type="text/css">
    <!-- CSS | Custom Margin Padding Collection -->
    <link href="css/custom-bootstrap-margin-padding.css" rel="stylesheet" type="text/css">
    <!-- CSS | Responsive media queries -->
    <link href="css/responsive.css" rel="stylesheet" type="text/css">
    <!-- CSS | Style css. This is the file where you can place your own custom css code. Just uncomment it and use it. -->
    <!-- <link href="css/style.css" rel="stylesheet" type="text/css"> -->

    <!-- CSS | Theme Color -->
    <link href="css/theme-skin-blue-green.css" rel="stylesheet" type="text/css">

    <!-- external javascripts -->
    <script src="js/jquery-2.2.0.min.js"></script>
    <script src="js/jquery-ui.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <!-- JS | jquery plugin collection for this theme -->
    <script src="js/jquery-plugin-collection.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="">
<div id="wrapper" class="clearfix">
    <!-- preloader -->
    <div id="preloader">
        <div id="spinner">
            <div class="preloader-dot-loading">
                <div class="cssload-loading"><i></i><i></i><i></i><i></i></div>
            </div>
        </div>
        <div id="disable-preloader" class="btn btn-default btn-sm">Disable Preloader</div>
    </div>

    <!-- start main-content -->
    <div class="main-content">
        <!-- Section: home -->
        <section id="home" class="divider fullscreen bg-lighter">
            <div class="display-table">
                <div class="display-table-cell">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-6 col-md-push-3">
                                <div class="text-center mb-60"><a href="#" class=""><img alt="" src="images/logo-woi-60-dark.png"></a></div>
                                <p><b>Anda bisa login menggunakan Username atau Email.</b></p>
								<?php
									if(isset($_POST['btnLogin'])){
										$username=$_POST['username'];
										$password=$_POST['password'];
										$stmt = $mysqli->query("select * from tbl_login where (username='$username' OR email='$username') AND password='$password' ");
										if($stmt->num_rows>0){
											$data = $stmt->fetch_object();											
											if($data->hak_akses=="wakif"){												
												$stmt = $mysqli->query("select * from tbl_user where username='$username' OR email='$username' ");
												$data_user = $stmt->fetch_object();
												if(memberVerifikasi($data_user->id_user) == "sudah"){
													setcookie("status_login", $data->hak_akses, time()+3600,"/");
													setcookie("login_id", $data_user->id_user, time()+3600,"/");
													setcookie("login_nama", $data_user->nama_lengkap, time()+3600,"/");
													setcookie("login_saldo", $data_user->saldo_dompet, time()+3600,"/");
													setcookie("login_tipe",$data_user->tipe_user, time()+3600,"/");
													setcookie("login_telepon", $data_user->telepon, time()+3600,"/");
													setcookie("login_email", $data_user->email, time()+3600,"/");
													setcookie("login_referal", $data_user->referal, time()+3600,"/");
													setcookie("login_username", $username, time()+3600,"/");
													setcookie("login_password", $password, time()+3600,"/");
													
													// $_COOKIE['status_login']=$data->hak_akses;
													// $_COOKIE['login_id'] = $data_user->id_user;
													// $_COOKIE['login_saldo'] = $data_user->saldo_dompet;
													// $_COOKIE['login_tipe'] = $data_user->tipe_user;
													// $_COOKIE['login_nama'] = $data_user->nama_lengkap;
													// $_COOKIE['login_telepon'] = $data_user->telepon;
													// $_COOKIE['login_email'] = $data_user->email;
													// $_COOKIE['login_username'] = $username;
													// $_COOKIE['login_password'] = $password;
													echo '															
													<div class="divider divider--xs"></div>
														<div class="alert alert-success" role="alert" align="center">
															<b>Berhasil login, login sebagai '.$data_user->nama_lengkap.', anda akan dialihkan...</b>
														</div>
													';
													$url = "index.php";													
													echo'<meta http-equiv="Refresh" content="2; URL='.$url.'">';
												}else{
													echo '		
													<div class="divider divider--xs"></div>
														<div class="alert alert-danger" role="alert" align="center">
															<b>Gagal Login, akun anda belum di verifikasi email/admin... !!</b>
														</div>
													';
												}
											}else if($data->hak_akses=="super admin" OR $data->hak_akses=="admin" OR $data->hak_akses=="moderator"){
												$stmt = $mysqli->query("select * from tbl_admin where username='$username' OR email='$username' ");
												$data_user = $stmt->fetch_object();
													setcookie("status_login", $data->hak_akses, time()+3600,"/","/");
												setcookie("admin_id", $data_user->id_admin, time()+3600,"/");
												setcookie("admin_login", "1");
												setcookie("admin_nama", $data_user->nama_lengkap, time()+3600,"/");

												// $_COOKIE['status_login']=$data->hak_akses;
												// $_COOKIE['admin_id'] = $data_user->id_admin;
												// $_COOKIE['admin_login'] = "1";
												// $_COOKIE['admin_nama'] = $data_user->nama_lengkap;
												echo '		
													<div class="divider divider--xs"></div>
														<div class="alert alert-success" role="alert" align="center">
															<b>Berhasil login, anda akan dialihkan...</b>
														</div>
													';
												$url="woi_admin/";
												echo'<meta http-equiv="Refresh" content="2; URL='.$url.'">';
											}
										}else{
											echo '		
											<div class="divider divider--xs"></div>
												<div class="alert alert-danger" role="alert" align="center">
													<b>Gagal Login, username atau password salah... !!</b>
												</div>
											';
										}
									}
									?>
                                <form name="login-form" class="clearfix" action="" method="post">
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <label for="form_username_email">Username/Email</label>
                                            <input id="form_username_email" name="form_username_email" class="form-control" type="text" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <label for="form_password">Password</label>
                                            <input id="form_password" name="form_password" class="form-control" type="password" required>
                                        </div>
                                    </div>
                                    <div class="checkbox pull-left mt-15">
                                        <label for="form_checkbox">
                                            <input id="form_checkbox" name="form_checkbox" type="checkbox">
                                            Ingat saya </label>
                                    </div>
                                    <div class="form-group pull-right mt-10">
                                        <button type="submit" name="btnLogin" class="btn btn-dark btn-sm">Login</button>
                                    </div>
                                    <div class="clear text-center pt-10">
                                        <a class="text-theme-colored font-weight-600 font-12" href="lupa-password.php">Lupa password?</a>
                                    </div>
                                </form>
                                    <div class="clear text-center pt-10">
										<a href="?provider=facebook" class="btn btn-primary text-center btn-facebook text-uppercase"><i class="fa fa-facebook"></i>&nbsp Masuk dengan Facebook</a>
										<a href="?provider=google" class="btn btn-danger text-center btn-google-plus text-uppercase"><i class="fa fa-google-plus"></i>&nbsp Masuk dengan Google</a>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <!-- end main-content -->

    <!-- Footer -->
    <footer id="footer" class="footer text-center">
        <div class="container pt-15 pb-15">
            <div class="row">
                <div class="col-md-12">
                    <p class="mb-0">Copyright ©2016 woi.or.id. All Rights Reserved</p>
                </div>
            </div>
        </div>
    </footer>
    <a class="scrollToTop" href="#"><i class="fa fa-angle-up"></i></a>
</div>
<!-- end wrapper -->

<!-- Footer Scripts -->
<!-- JS | Custom script for all pages -->
<script src="js/custom.js"></script>

</body>
</html>
