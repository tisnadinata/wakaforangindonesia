<?php
	include 'functions/functions.php';
	if(!isset($_SESSION['admin_login'])){
		echo'<meta http-equiv="Refresh" content="0; URL=login.php">';
	}else{
?>
<html class="" lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="x-ua-compatible" content="ie=edge">
<title>Dashboard Admin woi.or.id</title>
<meta name="description" content="">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="apple-touch-icon" href="apple-touch-icon.png">
<!-- Place favicon.ico in the root directory -->
<link rel="stylesheet" href="css/vendor.css">
<link rel="stylesheet" id="theme-style" href="css/app.css">
</head>
<body>
<div class="main-wrapper">
	<div class="app" id="app">
		<header class="header">
		<div class="header-block header-block-collapse hidden-lg-up">
			<button class="collapse-btn" id="sidebar-collapse-btn">
			<i class="fa fa-bars"></i>
			</button>
		</div>
		<div class="header-block header-block-nav">
			<ul class="nav-profile">
				<li class="profile dropdown">
					<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
					<span class="name">Selamat Datang, <i> <?php echo $_SESSION['admin_nama'];?></i> </span>
					</a>
					<div class="dropdown-menu profile-dropdown-menu" aria-labelledby="dropdownMenu1">
						<div class="dropdown-divider"></div>
						<a class="dropdown-item" href="logout.php"><i class="fa fa-power-off icon"></i> Logout </a>
					</div>
				</li>
			</ul>
		</div>
		</header>
		<aside class="sidebar">
		<div class="sidebar-container">
			<div class="sidebar-header">
				<div class="brand">
					 Dashboard Admin WOI
				</div>
			</div>
			<nav class="menu">
			<?php
				include_once 'menu.php';
			?>
			</nav>
		</div>
		</aside>
		<div class="sidebar-overlay" id="sidebar-overlay"></div>
		<?php
			if(isset($_GET['page'])){
				$page = str_replace("-","",$_GET['page']);
			}else{
				$page = "dashboard";
			}
			include_once $page.".php";
		?>
	</div>
</div>
</body>
<hr>
<!-- Reference block for JS -->
<footer class="footer">
<div class="modal fade" id="modal-media">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				<span class="sr-only">Close</span>
				</button>
				<h4 class="modal-title">Media Library</h4>
			</div>
			<div class="modal-body modal-tab-container">
				<ul class="nav nav-tabs modal-tabs" role="tablist">
					<li class="nav-item">
						<a class="nav-link" href="#gallery" data-toggle="tab" role="tab">Gallery</a>
					</li>
					<li class="nav-item">
						<a class="nav-link active" href="#upload" data-toggle="tab" role="tab">Upload</a>
					</li>
				</ul>
				<div class="tab-content modal-tab-content">
					<div class="tab-pane fade" id="gallery" role="tabpanel">
						<div class="images-container">
							<div class="row"></div>
						</div>
					</div>
					<div class="tab-pane fade active in" id="upload" role="tabpanel">
						<div class="upload-container">
							<div id="dropzone">
								<form action="/" method="POST" enctype="multipart/form-data" class="dropzone needsclick dz-clickable" id="demo-upload">
									<div class="dz-message-block">
										<div class="dz-message needsclick">Drop files here or click to upload.</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button><button type="button" class="btn btn-primary">Insert Selected</button>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<div class="modal fade" id="confirm-modal">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title"><i class="fa fa-warning"></i> Alert</h4>
			</div>
			<div class="modal-body">
				<p>
					 Are you sure want to do this?
				</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" data-dismiss="modal">Yes</button><button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<script type="text/javascript" src="ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="ckeditor/style.js"></script>
<script src="js/vendor.js"></script>
<script src="js/app.js"></script>
<script src="js/maskmoney.js"></script>
</footer>
</html>
<?php
	}
?>