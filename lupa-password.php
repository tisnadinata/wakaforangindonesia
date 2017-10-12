<!DOCTYPE html>
<?php
	include 'config/connect_db.php';
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
                                <div class="text-center mb-60"><a href="index.php" class=""><img alt="" src="images/logo-woi-60-dark.png"></a></div>
                                <p><b>Masukan Username dan Email.</b></p>
								<?php
									if(isset($_POST['btnLupaPassword'])){
										$username=$_POST['form_username'];
										$email=$_POST['form_email'];
										$stmt = $mysqli->query("select * from tbl_login where username='$username' AND email='$email'");
										if($stmt->num_rows>0){
											$data = $stmt->fetch_object();																						
											$isi = "Password anda adalah ".$data->password.", silahkan login.";
											kirimEmail("Lupa Password woi.or.id",$isi,$email);
											echo '		
											<div class="divider divider--xs"></div>
												<div class="alert alert-success" role="alert" align="center">
													<b>Password sudah dikirim ke email anda.</b>
												</div>
											';
										}else{
											echo '		
											<div class="divider divider--xs"></div>
												<div class="alert alert-danger" role="alert" align="center">
													<b>Tidak ada akun terdaftar dengan data tersebut... !!</b>
												</div>
											';
										}
									}
								?>
                                <form name="login-form" class="clearfix" action="" method="post">
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <label for="form_username_email">Username</label>
                                            <input id="form_username" name="form_username" class="form-control" type="text" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <label for="form_password">Email</label>
                                            <input id="form_email" name="form_email" class="form-control" type="email" required>
                                        </div>
                                    </div>
                                    <div class="form-group pull-right mt-10">
                                        <button type="submit" name="btnLupaPassword" class="btn btn-dark btn-sm">Kirim Password</button>
                                    </div>                                                                       
                                </form>
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