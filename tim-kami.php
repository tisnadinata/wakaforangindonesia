<?php include 'templates/header.php'; ?>

<!-- Start main-content -->
<div class="main-content">

    <!-- Section: inner-header -->
    <section class="inner-header divider parallax layer-overlay overlay-dark-5" data-bg-img="images/campaign/kids.jpg">
        <div class="container pt-90 pb-50">
            <!-- Section Content -->
            <div class="section-content pt-100">
                <div class="row">
                    <div class="col-md-12">
                        <h3 class="title text-white">Tim Kami</h3>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section: Team -->
    <section>
        <div class="container pt-30" style="padding:0px !important;">
            <div class="section-content pt-30" style="padding:0px !important;">

                <div class="mb-30  text-center">
                    <div class="heading-line-bottom">
                        <h2 class="heading-title">WOI Behind The Screen</h2>
						<p>"Jika seseorang meninggal dunia, maka terputuslah amalannya kecuali tiga perkara (yaitu): <br> sedekah jariyah, ilmu yang dimanfaatkan, atau do’a anak yang shalih"</p>
                    </div>
                </div>
				<div class="row" style="margin-bottom:50px;">
					<div class="col-md-6 col-xs-12"	style="border-right: 3px solid green;">
						<div class="col-md-12 col-xs-12">
						<?php
							$stmt = $mysqli->query("select * from tbl_admin where tipe_admin = 'tim'");
							echo'
								<div class="row">
								<h3>Pendiri :</h3>
							';
							$i=1;
							while($data = $stmt->fetch_object()){
								echo'
									<div class="col-xs-6 col-md-3">
										<div class="team-member" style="border: 1px solid beige;">
											<div class="volunteer-thumb"> <img width="100%" src="'.$data->url_foto.'" alt="" class="img-responsive"> </div>
											<div class="bg-lighter text-center pt-20">
												<div class="member-biography">
													<h4 class="mt-0">'.$data->nama_lengkap.'</h4>
												</div>
									<!--			<ul class="social-icons icon-theme-colored icon-circled pt-5">
													<li><a target="_blank" href="'.$data->url_facebook.'"><i class="fa fa-facebook"></i></a></li>
													<li><a target="_blank" href="'.$data->url_twitter.'"><i class="fa fa-twitter"></i></a></li>
													<li><a target="_blank" href="#"><i class="fa fa-dribbble"></i></a></li>
												</ul> -->
											</div>
										</div>
									</div>
								';
								if($i%4 == 0){
									echo'
										</div>
										<br>
										<div class="row">
									';
								}
								$i++;
							}
							echo'
								</div>
							';
						?>
						<hr>
						</div>
						<div class="col-md-12 col-xs-12">
						<?php
							$stmt = $mysqli->query("select * from tbl_admin where tipe_admin = 'admin'");
							echo'
								<div class="row">
								<h3>Admin :</h3>
							';
							$i=1;
							while($data = $stmt->fetch_object()){
								echo'
									<div class="col-xs-6 col-md-3">
										<div class="team-member" style="border: 1px solid beige;">
											<div class="volunteer-thumb"> <img width="100%" src="'.$data->url_foto.'" alt="" class="img-responsive"> </div>
											<div class="bg-lighter text-center pt-20">
												<div class="member-biography">
													<h4 class="mt-0">'.$data->nama_lengkap.'</h4>
												</div>
									<!--			<ul class="social-icons icon-theme-colored icon-circled pt-5">
													<li><a target="_blank" href="'.$data->url_facebook.'"><i class="fa fa-facebook"></i></a></li>
													<li><a target="_blank" href="'.$data->url_twitter.'"><i class="fa fa-twitter"></i></a></li>
													<li><a target="_blank" href="#"><i class="fa fa-dribbble"></i></a></li>
												</ul> -->
											</div>
										</div>
									</div>
								';
								if($i%4 == 0){
									echo'
										</div>
										<br>
										<div class="row">
									';
								}
								$i++;
							}
							echo'
								</div>
							';
						?>
						<hr>
						</div>
						<div class="col-md-12 col-xs-12">
						<?php
							$stmt = $mysqli->query("select * from tbl_admin where tipe_admin = 'moderator'");
							echo'
								<div class="row">
								<h3>Moderator :</h3>
							';
							$i=1;
							while($data = $stmt->fetch_object()){
								echo'
									<div class="col-xs-6 col-md-3">
										<div class="team-member" style="border: 1px solid beige;">
											<div class="volunteer-thumb"> <img width="100%" src="'.$data->url_foto.'" alt="" class="img-responsive"> </div>
											<div class="bg-lighter text-center pt-20">
												<div class="member-biography">
													<h4 class="mt-0">'.$data->nama_lengkap.'</h4>
												</div>
									<!--			<ul class="social-icons icon-theme-colored icon-circled pt-5">
													<li><a target="_blank" href="'.$data->url_facebook.'"><i class="fa fa-facebook"></i></a></li>
													<li><a target="_blank" href="'.$data->url_twitter.'"><i class="fa fa-twitter"></i></a></li>
													<li><a target="_blank" href="#"><i class="fa fa-dribbble"></i></a></li>
												</ul> -->
											</div>
										</div>
									</div>
								';
								if($i%4 == 0){
									echo'
										</div>
										<br>
										<div class="row">
									';
								}
								$i++;
							}
							echo'
								</div>
							';
						?>
						<hr>
						</div>
					</div>
					<div class="col-md-6 col-xs-12">
						<div class="col-md-12 col-xs-12">
						<?php
							$stmt = $mysqli->query("select * from tbl_user where tipe_user = 'ar'");
							echo'
								<div class="row">
								<h3>Staff AR :</h3>
							';
							$i=1;
							while($data = $stmt->fetch_object()){
								echo'
									<div class="col-xs-6 col-md-3">
										<div class="team-member" style="border: 1px solid beige;">
											<div class="volunteer-thumb"> <img width="100%" src="'.$data->url_foto.'" alt="" class="img-responsive"> </div>
											<div class="bg-lighter text-center pt-20">
												<div class="member-biography">
													<h4 class="mt-0">'.$data->nama_lengkap.'</h4>
												</div>
									<!--			<ul class="social-icons icon-theme-colored icon-circled pt-5">
													<li><a target="_blank" href="'.$data->url_facebook.'"><i class="fa fa-facebook"></i></a></li>
													<li><a target="_blank" href="'.$data->url_twitter.'"><i class="fa fa-twitter"></i></a></li>
													<li><a target="_blank" href="#"><i class="fa fa-dribbble"></i></a></li>
												</ul> -->
											</div>
										</div>
									</div>
								';
								if($i%4 == 0){
									echo'
										</div>
										<br>
										<div class="row">
									';
								}
								$i++;
							}
							echo'
								</div>
							';
						?>
						<hr>
						</div>
						<div class="col-md-12 col-xs-12">
						<?php
							$stmt = $mysqli->query("select * from tbl_user where tipe_user = 'ae'");
							echo'
								<div class="row">
								<h3>Staff AE :</h3>
							';
							$i=1;
							while($data = $stmt->fetch_object()){
								echo'
									<div class="col-xs-6 col-md-3">
										<div class="team-member" style="border: 1px solid beige;">
											<div class="volunteer-thumb"> <img width="100%" src="'.$data->url_foto.'" alt="" class="img-responsive"> </div>
											<div class="bg-lighter text-center pt-20">
												<div class="member-biography">
													<h4 class="mt-0">'.$data->nama_lengkap.'</h4>
												</div>
									<!--			<ul class="social-icons icon-theme-colored icon-circled pt-5">
													<li><a target="_blank" href="'.$data->url_facebook.'"><i class="fa fa-facebook"></i></a></li>
													<li><a target="_blank" href="'.$data->url_twitter.'"><i class="fa fa-twitter"></i></a></li>
													<li><a target="_blank" href="#"><i class="fa fa-dribbble"></i></a></li>
												</ul> -->
											</div>
										</div>
									</div>
								';
								if($i%4 == 0){
									echo'
										</div>
										<br>
										<div class="row">
									';
								}
								$i++;
							}
							echo'
								</div>
							';
						?>
						<hr>
						</div>
					</div>
				</div>
            </div>
        </div>
</div>
</section>
</div>
<!-- end main-content -->

<?php include 'templates/footer.php'; ?>
