<?php include 'templates/header.php'; 
if(!isset($_COOKIE["login_id"])){
	echo'<meta http-equiv="Refresh" content="0; URL=login.php">';
}
?>
<!-- Start main-content -->
<div class="main-content">

    <!-- Section: inner-header -->
    <section class="inner-header divider parallax layer-overlay overlay-dark-5" data-stellar-background-ratio="0.5" data-bg-img="images/campaign/kids.jpg" style="height:350px;">
        <div class="container pt-100 pb-50">
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
                    <h3 class="heading-title heading-line-bottom pt-10 pb-10 visible-lg">Overview</h3>
                    <div class="row">
                        <div class="col-sm-4 text-center">
                            <div class="icon-box iconbox-border">
                                <a class="icon icon-gray icon-circled icon-border-effect effect-circled" href="#">
                                    <img alt="" src="images/flat-color-icons-svg/advertising.svg" title="advertising.svg"/>
                                </a>
                                <h5 class="icon-box-title">
								<?php
									$stmt = $mysqli->query("select * from tbl_wakaf_proyek where id_user=".$_COOKIE['login_id']."");
									echo $stmt->num_rows;
								?>
								</h5>
                                <p class="text-gray">Campaign</p>
                            </div>
                        </div>
                        <div class="col-sm-4 text-center">
                            <div class="icon-box iconbox-border">
                                <a class="icon icon-gray icon-circled icon-border-effect effect-circled" href="#">
                                    <img alt="" src="images/flat-color-icons-svg/donate.svg" title="donate.svg"/>
                                </a>
                                <h5 class="icon-box-title">
								<?php
									$stmt = $mysqli->query("select * from tbl_wakaf_donasi,tbl_wakaf_donasi_status 
									where tbl_wakaf_donasi.id_user=".$_COOKIE['login_id']." AND tbl_wakaf_donasi.id_wakaf_donasi = tbl_wakaf_donasi_status.id_wakaf_donasi
									AND tbl_wakaf_donasi_status.status_wakaf != 'fail'");
									echo $stmt->num_rows;
								?>
								</h5>
                                <p class="text-gray">Wakaf</p>
                            </div>
                        </div>
                        <div class="col-sm-4 text-center">
                            <div class="icon-box iconbox-border">
                                <a class="icon icon-gray icon-circled icon-border-effect effect-circled" href="#">
                                    <img alt="" src="images/flat-color-icons-svg/currency_exchange.svg" title="currency_exchange.svg"/>
                                </a>
                                <h5 class="icon-box-title">Rp. 
								<?php
									$stmt = $mysqli->query("select sum(tbl_wakaf_donasi.jumlah_wakaf) as jum from tbl_wakaf_donasi,tbl_wakaf_donasi_status 
									where tbl_wakaf_donasi.id_user=".$_COOKIE['login_id']." AND tbl_wakaf_donasi.id_wakaf_donasi = tbl_wakaf_donasi_status.id_wakaf_donasi
									AND tbl_wakaf_donasi_status.status_wakaf != 'fail'");
									$data_donasi = $stmt->fetch_object();
									echo setHarga($data_donasi->jum);
								?>
								</h5>
                                <p class="text-gray">Total Wakaf Saya</p>
                            </div>
                        </div>
                    </div>
                    <h3 class="heading-title heading-line-bottom pt-10 pb-10 visible-lg">Update</h3>
                    <div class="row">
                        <div class="row list-dashed pl-30 pr-30">
							<?php
								$stmt = $mysqli->query("select * from tbl_post where tipe_post='wakaf' AND status_post='done' order by id_post DESC");
								$data_post = $stmt->fetch_object();
								$tgl_publish= date("d",strtotime($data_post->tanggal_pembuatan));
								$bulan_publish= date("M",strtotime($data_post->tanggal_pembuatan));						
								echo'
									<article class="post clearfix mb-50 pb-30 bg-lighter">
										<div class="clearfix"></div>
										<div class="entry-content p-20 pr-10">
											<div class="entry-meta media mt-0 no-bg no-border">
												<div class="entry-date media-left text-center flip bg-theme-colored pt-5 pr-15 pb-5 pl-15">
													<ul>
														<li class="font-16 text-white font-weight-600">'.$tgl_publish.'</li>
														<li class="font-12 text-white text-uppercase">'.$bulan_publish.'</li>
													</ul>
												</div>
												<div class="media-body pl-15">
													<div class="event-content pull-left flip">
														<h4 class="entry-title text-white text-uppercase m-0 mt-5"><a href="#">'.$data_post->judul_post.'</a></h4>
														<span class="mb-10 text-gray-darkgray mr-10 font-13"><i class="fa fa-calendar mr-5 text-theme-colored"></i> '.$data_post->tanggal_pembuatan.'</span>
													</div>
												</div>
											</div>
											<p class="mt-10">
											'.substr($data_post->isi_post,0,250).' ...
											</p>
											<a target="_blank" href="detil-wakaf.php?wakaf='.str_replace(" ","-",$data_post->judul_post).'" class="btn-read-more">Selengkapnya</a>
											<div class="clearfix"></div>
										</div>
									</article>
								';
							?>
                        </div>
                    </div>
                </div>



            </div>
    </section>
</div>
<!-- end main-content -->

<?php include 'templates/footer.php'; ?>
