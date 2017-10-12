<?php include 'templates/header.php'; ?>

<!-- Start main-content -->
<div class="main-content">

    <!-- Section: inner-header -->
    <section class="inner-header divider parallax layer-overlay overlay-dark-5" data-stellar-background-ratio="0.5" data-bg-img="images/campaign/kids.jpg" style="height:350px;">        <div class="container pt-100 pb-50">
            <!-- Section Content -->
            <div class="section-content pt-100">
                <div class="row">
                    <div class="col-md-12">
                        <h3 class="title text-white">Area Wakif</h3>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Section: Blog -->
    <section>
        <div class="container mt-30 mb-30 pt-30 pb-30">
            <div class="row">
				<?php
					include 'menu_wakif.php';
				?>
                <div class="col-md-9">
                    <h3 class="heading-title heading-line-bottom pt-10 pb-10 visible-lg">Campaign Saya</h3>
                    <div class="row">
						<div class="col-sm-8">
						<?php
							$stmt = $mysqli->query("select * from tbl_wakaf_proyek where id_user=".$_COOKIE['login_id']."");
							if($stmt->num_rows > 0){
								while($data = $stmt->fetch_object()){
									$data_kategori = getDataByCollumn("tbl_kategori_wakaf","id_kategori_wakaf",$data->id_kategori_wakaf);
									echo'
											<div class="team bg-lighter mb-20">
												<div class="row">
													<div class="col-sm-6 col-md-6 xs-text-center pb-sm-20">
														<div class="thumb"><img class="img-fullwidth" width="250" height="250" src="'.$data->url_foto.'" alt=""></div>
													</div>
													<div class="col-sm-6 col-md-6 xs-text-center pb-sm-20 pt-20 pr-20">
														<div class="content mr-20">
															<h4 class="author text-theme-colored">'.$data->nama_proyek.'</h4>
															<h6 class="title text-dark">'.ucfirst($data_kategori->nama_kategori).'</h6>
															<p>'.substr($data->deskripsi_proyek,0,85).' . . .</p>';
															if($data->status_proyek != 'pending'){
																echo'
																	<a class="btn btn-dark btn-theme-colored btn-sm text-uppercase mt-10" href="detil-wakaf.php?wakaf='.str_replace(" ","-",$data->nama_proyek).'">Lihat</a> 
																';															
															}else{
																echo'
																	<a class="btn btn-dark btn-theme-colored btn-sm text-uppercase mt-10" title="Proyek anda belum di verifikasi" disabled>Lihat</a> 
																';															
															}
									echo'
															<a class="btn btn-dark btn-theme-colored btn-sm text-uppercase mt-10 pull-right" href="campaign.php?edit='.$data->id_wakaf_proyek.'">Edit</a>
														</div>
													</div>
												</div>
											</div>
									';	
								}
							}else{
								echo "Anda belum mempunyai kampanye/proyek wakfa.";
							}					
						?>
						</div>                        
                        <div class="col-sm-4 text-center">
                            <div class="icon-box iconbox-border pb-50 pt-70">
                                    <a class="icon icon-gray icon-circled icon-border-effect effect-circled" href="campaign.php">
                                        <img alt="" src="images/flat-color-icons-svg/add_database.svg" title="currency_exchange.svg"/>
                                    </a>
                                    <h5 class="icon-box-title">Buat Campaign Baru</h5>
                            </div>
                        </div>
                    </div>
                </div>



            </div>
    </section>
</div>
<!-- end main-content -->

<?php include 'templates/footer.php'; ?>
