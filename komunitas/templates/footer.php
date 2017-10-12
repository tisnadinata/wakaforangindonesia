<!-- Footer -->
<footer id="footer" class="footer bg-black-222">
    <div class="container pt-70 pb-40">
        <div class="row border-bottom-black">
            <div class="col-sm-6 col-md-3">
                <div class="widget dark">
                    <img class="mt-10 mb-20" alt="" src="images/logo-woi-sm.png">
                    <p>
						<?php
							$stmt = getPengaturan("alamat_perusahaan");
							echo $stmt;
						?>
					</p>
                    <ul class="list-inline mt-5">
                        <li class="m-0 pl-10 pr-10"> <i class="fa fa-phone text-theme-colored mr-5"></i> <a class="text-gray" href="#">
							<?php
								$stmt = getPengaturan("telepon");
								echo $stmt;
							?>
						</a> </li>
                        <li class="m-0 pl-10 pr-10"> <i class="fa fa-envelope-o text-theme-colored mr-5"></i> <a class="text-gray" href="mailto:contact@woi.or.id">
							<?php
								$stmt = getPengaturan("email");
								echo $stmt;
							?>
						</a> </li>
                        <li class="m-0 pl-10 pr-10"> <i class="fa fa-globe text-theme-colored mr-5"></i> <a class="text-gray" href="http://www.woi.or.id">
						www.woi.or.id
						</a> </li>
                    </ul>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="widget dark">
                    <h5 class="widget-title line-bottom">Take Action</h5>
                    <ul class="list angle-double-right list-border">
                        <li><a href="http://woi.or.id/login.php">Galang Wakaf</a></li>
                        <li><a href="http://woi.or.id/project-wakaf.php">Project Wakaf</a></li>
                        <li><a href="http://woi.or.id/tausyiah.php">Tausyiah</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="widget dark">
                    <h5 class="widget-title line-bottom">Learn More</h5>
                    <ul class="list angle-double-right list-border">
                        <li><a href="http://woi.or.id/term-conditions.php">Syarat dan Ketentuan</a></li>
                        <li><a href="http://woi.or.id/privacy-policy.php">Kebijakan Privasi</a></li>
                        <li><a href="http://woi.or.id/faq.php">Frequently Asked Question</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="widget dark">
                    <h5 class="widget-title line-bottom">Connect</h5>
                    <ul class="list angle-double-right list-border">
                        <li><a href="http://woi.or.id/tentang-kami.php">Siapa Kami?</a></li>
                        <li><a href="http://woi.or.id/tim-kami.php">Tim Kami</a></li>
                        <li><a href="http://woi.or.id/berita-wakaf.php">Berita Wakaf</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row mt-10">
            <div class="col-md-5">
                <div class="widget dark">
                    <h5 class="widget-title mb-10">Dapat Informasi Terkini</h5>
                    <!-- Mailchimp Subscription Form Starts Here -->
					<?php
						if(isset($_POST['btnSubscribe'])){
							$email = $_POST['emailSubscribe'];
							$cari = $mysqli->query("SELECT * FROM tbl_subscriber WHERE email_subscriber='$email'");
							if($cari->num_rows==0){
								$stmt = $mysqli->query("INSERT INTO tbl_subscriber(email_subscriber) VALUES('$email')");
								if($stmt){
									echo'<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Terimakasih, anda akan menerima informasi terbaru dari kami.</div>';
								}else{
									echo'<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Maaf, email anda tidak dapat di daftarkan.</div>';
								}								
							}else{
								echo'<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Maaf, email sudah terdaftar.</div>';								
							}
						}
					?>
                    <form action="" method="post">
                        <div class="input-group">
                            <input type="email" value="" name="emailSubscribe" placeholder="Email Anda" class="form-control input-lg font-16" data-height="45px" id="mce-EMAIL-footer" style="height: 45px;">
							<span class="input-group-btn">
							  <button data-height="45px" class="btn btn-colored btn-theme-colored btn-xs m-0 font-14" name="btnSubscribe" type="submit">Daftar</button>
							</span>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-3 col-md-offset-1">
                <div class="widget dark">
                    &nbsp;
                </div>
            </div>
            <div class="col-md-3">
                <div class="widget dark">
                    <h5 class="widget-title mb-10">Media Sosial</h5>
                    <ul class="social-icons icon-dark icon-circled icon-sm">
						<?php
							$fb = getPengaturan("url_facebook");
							$twitter = getPengaturan("url_twitter");
							echo '
								<li><a style="padding: 10px;" href="'.$fb.'" target="_blank"><i class="fa fa-facebook"></i></a></li>
								<li><a style="padding: 10px;" href="'.$twitter.'" target="_blank"><i class="fa fa-twitter"></i></a></li>
							';
						?>
<!--						
								<li><a href="#" target="_blank"><i class="fa fa-skype"></i></a></li>
								<li><a href="#" target="_blank"><i class="fa fa-youtube"></i></a></li>
								<li><a href="#" target="_blank"><i class="fa fa-instagram"></i></a></li>
								<li><a href="#" target="_blank"><i class="fa fa-pinterest"></i></a></li>
-->
					</ul>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom bg-black-333">
        <div class="container pt-20 pb-20">
            <div class="row">
                <div class="col-md-6">
                    <p class="font-11 text-black-777 m-0">Copyright &copy;2016 woi.or.id. All Rights Reserved</p>
                </div>
                <div class="col-md-6 text-right">
                    <div class="widget no-border m-0">
                        <ul class="list-inline sm-text-center mt-5 font-12">
                            <li>
                                <a href="#">Proyek Wakaf</a>
                            </li>
                            <li>|</li>
                            <li>
                                <a href="#">Blog</a>
                            </li>
                            <li>|</li>
                            <li>
                                <a href="#">Tausyiah</a>
                            </li>

                        </ul>
                    </div>
                </div>
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