<?php
	if(isset($_SESSION['admin_login'])){
		echo'<meta http-equiv="Refresh" content="0; URL=index.php">';
	}else{
		include 'functions/functions.php';
?>
<html class="no-js" lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title> Admin Login woi.or.id</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="apple-touch-icon" href="apple-touch-icon.png">
        <!-- Place favicon.ico in the root directory -->
        <link rel="stylesheet" href="css/vendor.css">
        <!-- Theme initialization -->
        <script>
            var themeSettings = (localStorage.getItem('themeSettings')) ? JSON.parse(localStorage.getItem('themeSettings')) :
            {};
            var themeName = themeSettings.themeName || '';
            if (themeName)
            {
                document.write('<link rel="stylesheet" id="theme-style" href="css/app-' + themeName + '.css">');
            }
            else
            {
                document.write('<link rel="stylesheet" id="theme-style" href="css/app.css">');
            }
        </script>
    </head>

    <body>
        <div class="auth">
            <div class="auth-container">
                <div class="card">
                    <header class="auth-header">
                        <h1 class="auth-title">
        <div class="logo">
        	<span class="l l1"></span>
        	<span class="l l2"></span>
        	<span class="l l3"></span>
        	<span class="l l4"></span>
        	<span class="l l5"></span>
        </div>        Login Admin WOI.OR.ID
      </h1> 
	  </header>
                    <div class="auth-content">
					<?php
						if(isset($_POST['btnLoginAdmin'])){						
							$username=$_POST['username'];
							$password=$_POST['password'];
							$stmt = $mysqli->query("select * from tbl_login where (username='$username' OR email='$username') AND password='$password' and (hak_akses='admin' OR hak_akses='super admin' OR hak_akses='moderator')");
							if($stmt->num_rows>0){
								$data = $stmt->fetch_object();											
								$_SESSION['status_login']=$data->hak_akses;
								$stmt = $mysqli->query("select * from tbl_admin where username='$username' OR email='$username' ");
								$data_user = $stmt->fetch_object();
								$_SESSION['admin_id'] = $data_user->id_admin;
								$_SESSION['admin_login'] = "1";
								$_SESSION['admin_nama'] = $data_user->nama_lengkap;
								$url="index.php";
								echo'<meta http-equiv="Refresh" content="0; URL='.$url.'">';
							}else{
								echo '		
								<div class="divider divider--xs"></div>
									<div class="alert alert-danger" role="alert" align="center">
										<b>Gagal Login, username atau password salah !!</b>
									</div>
								';
							}
						}
					?>
                        <p class="text-xs-center"><b>LOGIN TO CONTINUE</b></p>
                        <form id="" action="" method="post">
                            <div class="form-group"> <label for="username">Username</label> <input type="text" class="form-control underlined" name="username" id="username" placeholder="Username Login" required> </div>
                            <div class="form-group"> <label for="password">Password</label> <input type="password" class="form-control underlined" name="password" id="password" placeholder="Password Login" required> </div>
                            <div class="form-group"> <button type="submit" name="btnLoginAdmin" class="btn btn-block btn-primary">Login</button> </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Reference block for JS -->
        <div class="ref" id="ref">
            <div class="color-primary"></div>
            <div class="chart">
                <div class="color-primary"></div>
                <div class="color-secondary"></div>
            </div>
        </div>
        <script src="js/vendor.js"></script>
        <script src="js/app.js"></script>
    </body>
</html>
<?php
	}
?>