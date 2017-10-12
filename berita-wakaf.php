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
                        <h3 class="title text-white">Berita Wakaf</h3>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="row multi-row-clearfix">
                <div class="blog-posts">
					<?php
						$stmt = $mysqli->query("select * from tbl_post where tipe_post='berita'");
						while($data = $stmt->fetch_object()){
							$data_komentar = $mysqli->query("select * from tbl_post_komentar where id_post=".$data->id_post."");
							$data_suka = $mysqli->query("select * from tbl_post_suka where id_post=".$data->id_post."");
							$tgl_publish= date("d",strtotime($data->tanggal_pembuatan));
							$bulan_publish= date("M",strtotime($data->tanggal_pembuatan));
							echo'
								<div class="col-md-6">
									<article class="post clearfix mb-30 bg-lighter">
										<div class="entry-header">
											<div class="post-thumb thumb">
												<img width="330" height="225" src="'.$data->url_foto.'" alt="" class="img-responsive img-fullwidth">
											</div>
										</div>
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
														<h4 class="entry-title text-white text-uppercase m-0 mt-5"><a href="detil-berita.php?berita='.str_replace(" ","-",$data->judul_post).'">'.$data->judul_post.'</a></h4>
														<span class="mb-10 text-gray-darkgray mr-10 font-13"><i class="fa fa-commenting-o mr-5 text-theme-colored"></i> '.$data_komentar->num_rows.' Komentar</span>
														<span class="mb-10 text-gray-darkgray mr-10 font-13"><i class="fa fa-heart-o mr-5 text-theme-colored"></i> '.$data_suka->num_rows.' Suka</span>
													</div>
												</div>
											</div>
											<p class="mt-10">'.substr($data->isi_post,0,200).'</p>
											<a href="detil-berita.php?berita='.str_replace(" ","-",$data->judul_post).'" class="btn-read-more">Selengkapnya</a>
											<div class="clearfix"></div>
										</div>
									</article>
								</div>
							';
						}
					?>
                    <div class="col-md-12">
                        <nav>
                            <ul class="pagination theme-colored">
                                <?php
									if(isset($_GET['p'])){
										$posisi = (($_GET['p']-1)*4);
									}else{
										$posisi = 0;
									}
									$stmt = $mysqli->query("select * from tbl_post where status_post='done' AND tipe_post='berita' ORDER BY id_post DESC LIMIT ".$posisi.",4");
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
        </div>
    </section>
</div>
<!-- end main-content -->

<?php include 'templates/footer.php'; ?>
