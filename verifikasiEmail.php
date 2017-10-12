<?php 
	include 'templates/header.php';
?>
<div class="main-content">
    <!-- Section: inner-header -->
    <section class="inner-header divider parallax layer-overlay overlay-dark-5" data-stellar-background-ratio="0.5" data-bg-img="images/campaign/kids.jpg">
        <div class="container pt-100 pb-50">
            <!-- Section Content -->
            <div class="section-content pt-100">
                <div class="row">
                    <div class="col-md-12">
<?php	
	if(isset($_GET['e']) AND isset($_GET['u']) AND isset($_GET['p'])){
		$email = $_GET['e'];
		$username = $_GET['u'];
		$password = $_GET['p'];
		$stmt = $mysqli->query("select * from tbl_login where email='$email' AND username='$username' AND password='$password'");
		if($stmt->num_rows>0){
			$stmt = $mysqli->query("select * from tbl_user where username='$username'");
			$data_user = $stmt->fetch_object();
			$stmt = $mysqli->query("UPDATE tbl_user_verifikasi SET email_verifikasi=1 WHERE id_user=".$data_user->id_user."");
			if($stmt){
				echo '		
					<div class="divider divider--xs"></div>
					<div class="alert alert-success" role="alert" align="center">
						Verifikasi Email Sudah Berhasil, silahkan login.
					</div>
					<meta http-equiv="Refresh" content="5; URL=login.php">
				';			
			}else{
				echo '		
					<div class="divider divider--xs"></div>
					<div class="alert alert-success" role="alert" align="center">
						Verifikasi Email Gagal, silahkan coba lagi nanti.
					</div>
					<meta http-equiv="Refresh" content="5; URL=index.php">
				';			
			}
		}else{
			echo'<meta http-equiv="Refresh" content="0; URL=index.php">';	
		}
	}else{
		echo'<meta http-equiv="Refresh" content="0; URL=index.php">';	
	}
	
?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<?php
	include 'templates/footer.php'; 
?>