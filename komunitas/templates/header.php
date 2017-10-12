<?php
	include 'config/connect_db.php';
	$url=getUrlWeb();
?>
<html dir="ltr" lang="en">
<head>

    <!-- Meta Tags -->
    <meta name="viewport" content="width=device-width,initial-scale=1.0"/>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
    <meta name="description" content=" " />
    <meta name="keywords" content=" " />
    <meta name="author" content="  " />

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
    <link href="css/style.css" rel="stylesheet" type="text/css">

    <!-- CSS | Theme Color -->
    <link href="css/theme-skin-green.css" rel="stylesheet" type="text/css">

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

<!-- Header -->
    <header id="header" class="header">
        <div class="header-top sm-text-center">
            <div class="container">
                <div class="row">                    
                    <div class="col-md-6">
                        <div class="widget m-0 mt-5 no-border">
                            <ul class="list-inline text-left sm-text-center">
                                <li class="pl-10 pr-10 mb-0 pb-0">
                                    <div class="header-widget"> Jadwal Sholat hari ini :</div>
                                </li>
                            </ul>
                        </div>
                    </div>
					<?php
						if(isset($_COOKIE['login_id'])){
							$id_user = $_COOKIE['login_id'];									
						}else{
							$id_user = getIpCustomer();
						}
						$stmt = $mysqli->query("select sum(jumlah_wakaf) as jum from tbl_wakaf_donasi_temp where id_user='".$id_user."' ");
						$data = $stmt->fetch_object();
						$wakaf = $data->jum;
							echo'
								<div class="col-md-3 flip sm-text-center">
									<div class="widget m-0"><span class="cart-icons icon-sm">
										<a href="'.$url.'/konfirmasi-wakaf.php"><i class="fa fa-shopping-cart">
											</i> &nbsp; Wakaf Anda: <em>Rp. '.setHarga($wakaf).'</em>
										</a></span>
									</div>
								</div>
							';
						if(!isset($_COOKIE['login_id'])){
							echo'
								<div class="col-md-3 sm-text-center">
									<nav>
										<ul class="list-inline sm-text-center text-left flip mt-5 pull-right">
											<li> <a href="login.php">Login</a> </li>
											<li>|</li>
											<li> <a href="register.php">Daftar</a> </li>
										</ul>
									</nav>
								</div>
							';
						}
					?>

                </div>
            </div>
        </div>
        <div class="header-nav">
            <div class="header-nav-wrapper navbar-scrolltofixed  bg-theme-colored">
                <div class="container">
                    <nav id="menuzord-right" class="menuzord default no-bg"> <a class="menuzord-brand pull-left flip text-white" href="<?php echo $url;?>"><img src="images/logo-woi-60.png" alt="" /><span class="addon-logo"> member of &nbsp; &nbsp;<img src="images/bwa-logo-60.png" alt="" /> &nbsp;&nbsp; family</span></a>
                        <ul class="menuzord-menu">
                            <li class="active"><a class="text-white" href="index.php#home">Beranda</a></li>
                            <li><a class="text-white" href="#">Program</a>
                                <ul class="dropdown">
									<?php
										$stmt = $mysqli->query("SELECT * FROM tbl_kategori_wakaf where tipe_kategori='program'");
										while($data = $stmt->fetch_object()){
											$kategori = str_replace("-","",$data->nama_kategori);
											$kategori = str_replace(" ","-",$kategori);
											echo"
												<li><a href='".$url."/wakaf.php?program=".$kategori."'>".$data->deskripsi_kategori."</a></li>
											";
										}
									?>
                                </ul>
                            </li>
                            <li><a class="text-white" href="<?php echo $url;?>/project-wakaf.php">Proyek</a></li>
                            <li><a class="text-white" href="#">Tausyiah </a> 
								<ul class="dropdown">
									<li><a href='<?php echo $url;?>/tausyiah.php?pemateri=Ustad Hari Mukti'>Ustad Hari Moekti</a></li>
									<li><a href='<?php echo $url;?>/tausyiah.php?pemateri=Ustad Felix Siauw'>Ustad Feilx Siauw</a></li>
                                </ul>
							</li>
                            <li><a class="text-white" href="#home">Connect Us</a>
                                <ul class="dropdown">
                                    <li><a href="<?php echo $url;?>/tentang-kami.php">Siapa Kami?</a></li>
                                    <li><a href="<?php echo $url;?>/tim-kami.php">Tim Kami</a></li>
                                    <li><a href="<?php echo $url;?>/faq.php">Frequently Asked Question</a></li>
                                    <li><a href="#">Blog</a>
                                        <ul class="dropdown">
                                            <li><a href="<?php echo $url;?>/berita-wakaf.php">Berita Wakaf</a></li>
                                            <li><a href="<?php echo $url;?>/inspirasi.php">Inspirasi</a></li>
                                            <li><a href="<?php echo $url;?>/dan-lain-lain.php">Dan Lain-Lain</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
							<?php
								if(isset($_COOKIE['login_id'])){
									$nama = explode(" ",$_COOKIE["login_nama"]);
									$nama = $nama[0];
									echo'
										<li><a class="text-white" href="'.$url.'/area-wakif.php"><i class="fa fa-user" aria-hidden="true"></i> '.$nama.' </a>
											<ul class="dropdown">
												<li><a href="'.$url.'/area-wakif.php">Area Member</a></li>
												<li><a href="logout.php">Logout</a></li>
											</ul>
										</li>
									';
								}
							?>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </header>