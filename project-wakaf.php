<?php include 'templates/header.php'; ?>

<!-- Start main-content -->
<div class="main-content">
    <!-- Section: inner-header -->
    <section class="inner-header divider parallax layer-overlay overlay-dark-5" data-stellar-background-ratio="0.5" data-bg-img="images/campaign/kids.jpg">
        <div class="container pt-100 pb-50">
            <!-- Section Content -->
            <div class="section-content pt-100">
                <div class="row">
                    <div class="col-md-12">
                        <h3 class="title text-white">Proyek Wakaf</h3>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="container">
            <div class="section-title">
                <div class="row">
                    <div class="col-md-9">
                        <h2 class="mt-0 font-28"><span class="text-theme-colored text-uppercase font-weight-400">Proyek | </span><span class="font-20">Berikut ini adalah proyek badan wakaf Al-qur'an.</span></h2>
                        <div class="icon">
                            <i class="fa fa-hospital-o"></i>
                        </div>
                    </div>
                    <div class="col-md-3 text-right pt-15"> <a class="text-theme-colored" href="#">Beranda</a> &nbsp; <span class="text-theme-colored">></span>  &nbsp; <a class="text-theme-colored" href="#">Proyek</a></div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <div class="sidebar sidebar-left mt-sm-30">
                        <div class="widget">
                            <h5 class="widget-title line-bottom">Kotak Search</h5>
                            <div class="search-form">
                                <form>
                                    <div class="input-group">
                                        <input type="text" placeholder="Cari disini" class="form-control search-input">
                                        <span class="input-group-btn">
                      <button type="submit" class="btn search-button"><i class="fa fa-search"></i></button>
                      </span>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="widget">
                            <h5 class="widget-title line-bottom">Kategori Proyek Wakaf</h5>
                            <div class="categories">
                                <ul class="list list-border angle-double-right">
									<?php
										$stmt = $mysqli->query("SELECT * FROM tbl_kategori_wakaf where tipe_kategori='program'");
										while($data = $stmt->fetch_object()){
											$kategori = str_replace("-","",$data->nama_kategori);
											$kategori = str_replace(" ","-",$kategori);
											$jum_post = getCountData("select * from tbl_wakaf_proyek where status_proyek='proses' AND id_kategori_wakaf = ".$data->id_kategori_wakaf." ");
											echo'
												<li><label class="checkbox-inline"><input type="checkbox">'.$data->deskripsi_kategori.' ('.$jum_post.')</label></li>
											';
										}
									?>
                                </ul>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-md-9">
                    <!-- Works Filter -->
                    <div class="project-filter font-alt align-center" id="myTab20">
                        <a class="active" href="#home" data-toggle="tab">Home</a>
                        <a href="#update" data-toggle="tab">Update</a>
                    </div>
                    <!-- End Works Filter -->

                    <div id="myTabContent20" class="tab-content">
                        <div class="tab-pane fade in active" id="home">
                            <!-- Portfolio Gallery Grid -->
							<?php
							echo'
                            <div class="section-content">
                                <div class="row mtli-row-clearfix">
							';
							if(isset($_GET['p'])){
								$posisi = (($_GET['p']-1)*4);
							}else{
								$posisi = 0;
							}
							$stmt = $mysqli->query("select * from tbl_wakaf_proyek where status_proyek='proses' AND tanggal_akhir >= now() order by id_wakaf_proyek LIMIT ".$posisi.",4");
							$i=1;
							if($stmt->num_rows > 0){							
								while($data_proyek = $stmt->fetch_object()){
									$stmt2 = $mysqli->query("select sum(tbl_wakaf_donasi.jumlah_wakaf) as jum from tbl_wakaf_donasi,tbl_wakaf_donasi_status 
									WHERE tbl_wakaf_donasi.id_wakaf_proyek = ".$data_proyek->id_wakaf_proyek." AND tbl_wakaf_donasi.id_wakaf_donasi = tbl_wakaf_donasi_status.id_wakaf_donasi 
									AND tbl_wakaf_donasi_status.status_wakaf='done'");					
									$data_donasi = $stmt2->fetch_object();
									$sisa_waktu = getSisaWaktu($data_proyek->tanggal_akhir);
									$dana_terkumpul = $data_donasi->jum/$data_proyek->target_dana*100;
									echo'
										<div class="col-sm-6 col-md-6 col-lg-6 wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.3s">
											<div class="causes maxwidth500 mb-sm-50">
												<div class="thumb">
													<img class="img-fullwidth" alt="" width="265" height="195" src="'.$data_proyek->url_foto.'">
												</div>
												<div class="causes-details clearfix">
													<div class="p-30 p-sm-15 bg-lighter">
														<h4><a href="detil-wakaf.php?wakaf='.str_replace(" ","-",$data_proyek->nama_proyek).'">'.$data_proyek->nama_proyek.'</a></h4>
														<p>'.$data_proyek->headline_proyek.'</p>
														<ul class="list-inline clearfix mt-20 mb-20">
															<li class="pull-left flip pr-0">Terkumpul: <span class="font-weight-700">Rp. '.setHarga($data_donasi->jum).'</span></li>
														</ul>
														<ul class="list-inline clearfix mt-20 mb-20">
															<li class="pull-left flip pr-0"><span class="font-weight-700">'.$dana_terkumpul.'%</span></li>
															<li class="text-theme-colored pull-right flip pr-0">'.ceil($sisa_waktu).' <span class="font-weight-700"> hari lagi</span></li>
														</ul>
														<a class="btn btn-dark btn-theme-colored btn-sm text-uppercase mt-10" href="wakaf-donasi.php?wakaf='.str_replace(" ","-",$data_proyek->nama_proyek).'">Wakaf</a> 
														<a class="btn btn-dark btn-theme-colored btn-sm text-uppercase mt-10 pull-right" href="detil-wakaf.php?wakaf='.str_replace(" ","-",$data_proyek->nama_proyek).'">Pelajari</a>
													</div>
												</div>
											</div>
										</div>
									';
									if($i%2 ==  0){
										echo'
											</div>
											<br>
											<div class="row mtli-row-clearfix">
										';
									}
									$i++;
								}
							}else{
								echo "&nbsp &nbsp &nbsp Tidak ada proyek wakaf berjalan";
							}	
							echo'
                                </div>
                            </div>
							';
							?>
                            <!-- End Portfolio Gallery Grid -->
                        </div>

                        <div class="tab-pane" id="update">
                            <!-- Portfolio Gallery Grid -->
                            <div class="blog-posts single-post">
								<?php
									$stmt = $mysqli->query("select * from tbl_wakaf_proyek where status_proyek='proses' AND tanggal_akhir >= now() order by id_wakaf_proyek DESC");
									if($stmt->num_rows > 0){							
										$data_wakaf_proyek = $stmt->fetch_object();
										$stmt2 = $mysqli->query("select * from tbl_post where judul_post = '".$data_wakaf_proyek->nama_proyek."'");
										$data_post = $stmt2->fetch_object();
										$data_user = $mysqli->query("select * from tbl_user where id_user=".$data_post->id_user."");
										$data_user = $data_user->fetch_object();
										$data_komentar = $mysqli->query("select * from tbl_post_komentar where id_post=".$data_post->id_post."");
										$data_suka = $mysqli->query("select * from tbl_post_suka where id_post=".$data_post->id_post."");
										$tgl_publish= date("d",strtotime($data_post->tanggal_pembuatan));
										$bulan_publish= date("M",strtotime($data_post->tanggal_pembuatan));
										$publish= date("d M Y",strtotime($data_post->tanggal_pembuatan));
										echo '
											<article class="post clearfix mb-0">
												<div class="entry-header">
													<div class="post-thumb thumb"> <img width="1920" height="1280" src="'.$data_post->url_foto.'" alt="" class="img-responsive img-fullwidth"> </div>
												</div>
												<div class="entry-content">
													<div class="entry-meta media no-bg no-border mt-15 pb-20">
														<div class="entry-date media-left text-center flip bg-theme-colored pt-5 pr-15 pb-5 pl-15">
															<ul>
																<li class="font-16 text-white font-weight-600">'.$tgl_publish.'</li>
																<li class="font-12 text-white text-uppercase">'.$bulan_publish.'</li>
															</ul>
														</div>
														<div class="media-body pl-15">
															<div class="event-content pull-left flip">
																<h4 class="entry-title text-white text-uppercase m-0"><a href="#">'.$data_post->judul_post.'</a></h4>
																<span class="mb-10 text-gray-darkgray mr-10 font-13"><i class="fa fa-calendar mr-5 text-theme-colored"></i> '.$publish.'</span>
																<span class="mb-10 text-gray-darkgray mr-10 font-13"><i class="fa fa-user mr-5 text-theme-colored"></i>'.$data_user->nama_lengkap.'</span>
															</div>
														</div>
													</div>
													<p class="mb-15">'.$data_post->isi_post.'</p>
												</div>
											</article>
										';
									}else{
										echo "Tidak ada update";
									}
								?>
                            </div>
                        </div>
                        <!-- End Portfolio Gallery Grid -->
                    </div>

                    <nav class="pull-right">
                        <ul class="pagination theme-colored">
                            <?php								
								if(isset($_GET['p'])){
									$posisi = (($_GET['p']-1)*4);
								}else{
									$posisi = 0;
								}
								$stmt = $mysqli->query("select * from tbl_post where status_post='done' AND tipe_post='tausyiah' ORDER BY id_post DESC LIMIT ".$posisi.",4");
								$jmlData = $stmt->num_rows;
								$jmlHalaman = ceil($jmlData/4);
								if($jmlHalaman<=1){
									echo'<li class="disabled"> <a aria-label="Previous" href="#"> <span aria-hidden="true">«</span> </a> </li>';
								}else{
									echo'<li> <a aria-label="Previous" href="?p='.($posisi/4).'"> <span aria-hidden="true">«</span> </a> </li>';											
								}
								for($i=1;$i<=$jmlHalaman;$i++){
									if( (($i-1)*4) == $posisi){
										echo'<li class="active"><a href="?p='.$i.'">'.$i.'</a></li>';
									}else{
										echo'<li><a href="?p='.$i.'">'.$i.'</a></li>';												
									}
								}
								if($jmlHalaman==($posisi/4+1)){
									echo'<li class="disabled"> <a aria-label="Next" href="#"> <span aria-hidden="true">»</span> </a> </li>';
								}else{
									echo'<li> <a aria-label="Next" href="?p='.($posisi/4+2).'"> <span aria-hidden="true">»</span> </a> </li>';
								}					
							?>
                        </ul>
                    </nav>

                </div>
            </div>
        </div>
    </section>
</div>
<!-- end main-content -->

<?php include 'templates/footer.php'; ?>

