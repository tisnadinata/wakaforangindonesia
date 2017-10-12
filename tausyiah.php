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
                        <h3 class="title text-white">Tausyiah</h3>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container mt-30 mb-30 pt-30 pb-30">
            <div class="row ">
                <div class="col-md-9">
                    <div class="blog-posts">
                        <div class="col-md-12">
                            <div class="row list-dashed">
							<?php
								if(isset($_GET['k'])){
									$kategori = str_replace("-"," ",$_GET['k']);
									$cari = "tag_post LIKE '%".$kategori."%'";
								}else{
									$cari = "tag_post != 'nol'";
								}
								if(isset($_GET['pemateri'])){
									$pemateri = $_GET['pemateri'];
									$pemateri = "pemateri LIKE '%".$pemateri."%'";
								}else{
									$pemateri = "pemateri != 'nol'";
								}
								if(isset($_GET['p'])){
									$posisi = (($_GET['p']-1)*4);
								}else{
									$posisi = 0;
								}
								$stmt = $mysqli->query("select * from tbl_post where status_post='done' AND tipe_post='tausyiah' AND ".$cari." AND ".$pemateri." ORDER BY id_post DESC LIMIT ".$posisi.",4");
								if($stmt->num_rows>0){
									while($data = $stmt->fetch_object()){
										$data_komentar = $mysqli->query("select * from tbl_post_komentar where id_post=".$data->id_post."");
										$data_suka = $mysqli->query("select * from tbl_post_suka where id_post=".$data->id_post."");
										$tgl_publish= date("d",strtotime($data->tanggal_pembuatan));
										$bulan_publish= date("M",strtotime($data->tanggal_pembuatan));
										echo'
											<article class="post clearfix mb-30 bg-lighter">
												<div class="entry-header">
													<div class="post-thumb thumb">
														<img src="'.$data->url_foto.'" alt="" class="img-responsive img-fullwidth">
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
																<h4 class="entry-title text-white text-uppercase m-0 mt-5"><a href="detil-tausyiah.php?tausyiah='.str_replace(" ","-",$data->judul_post).'">'.$data->judul_post.'</a></h4>
																<span class="mb-10 text-gray-darkgray mr-10 font-13"><i class="fa fa-commenting-o mr-5 text-theme-colored"></i> '.$data_komentar->num_rows.' Komentar</span>
																<span class="mb-10 text-gray-darkgray mr-10 font-13"><i class="fa fa-heart-o mr-5 text-theme-colored"></i> '.$data_suka->num_rows.' Suka</span>
															</div>
														</div>
													</div>
													<p class="mt-10">
													'.substr($data->isi_post,0,225).';
													</p>
													<a href="detil-tausyiah.php?tausyiah='.str_replace(" ","-",$data->judul_post).'" class="btn-read-more">Selengkapnya</a>
													<div class="clearfix"></div>
												</div>
											</article>
										';
									}
								}else{
									echo "Maaf, belum ada postingan dengan kategori tersebut.";
								}
							?>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <nav>
                                <ul class="pagination theme-colored">
                                    
									<?php
										if(isset($_GET['k'])){
											$k= "k=".$_GET['k']."&";
											$kategori = str_replace("-"," ",$_GET['k']);
											$cari = "tag_post LIKE '%".$kategori."%'";
										}else{
											$k='';
											$cari = "tag_post != 'nol'";
										}
										if(isset($_GET['p'])){
											$posisi = (($_GET['p']-1)*4);
										}else{
											$posisi = 0;
										}
										$stmt = $mysqli->query("select * from tbl_post where status_post='done' AND tipe_post='tausyiah' AND ".$cari." ORDER BY id_post DESC");
										$jmlData = $stmt->num_rows;
										$jmlHalaman = ceil($jmlData/4);
										if($jmlHalaman<=1){
											echo'<li class="disabled"> <a aria-label="Previous" href="#"> <span aria-hidden="true">«</span> </a> </li>';
										}else{
											echo'<li> <a aria-label="Previous" href="?'.$k.'p='.($posisi/4).'"> <span aria-hidden="true">«</span> </a> </li>';											
										}
										for($i=1;$i<=$jmlHalaman;$i++){
											if( (($i-1)*4) == $posisi){
												echo'<li class="active"><a href="?'.$k.'p='.$i.'">'.$i.'</a></li>';
											}else{
												echo'<li><a href="?'.$k.'p='.$i.'">'.$i.'</a></li>';												
											}
										}
										if($jmlHalaman==($posisi/4+1)){
											echo'<li class="disabled"> <a aria-label="Next" href="#"> <span aria-hidden="true">»</span> </a> </li>';
										}else{
											echo'<li> <a aria-label="Next" href="?'.$k.'p='.($posisi/4+2).'"> <span aria-hidden="true">»</span> </a> </li>';
										}
									?>
                                    
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-3">
                    <div class="sidebar sidebar-right mt-sm-30">
                        <div class="widget">
                            <h5 class="widget-title line-bottom">Kategori</h5>
                            <ul class="list-divider list-border list check">
								<?php
									$stmt = $mysqli->query("SELECT * FROM tbl_kategori_wakaf where tipe_kategori='tausyiah'");
									while($data = $stmt->fetch_object()){
										$kategori = str_replace("-","",$data->nama_kategori);
										$kategori = str_replace(" ","-",$kategori);
										$jum_post = getCountData("select * from tbl_post where status_post='done' AND tag_post LIKE '%".$data->nama_kategori."%' ");
										echo"
											<li><a href='tausyiah.php?k=".$kategori."'>".$data->deskripsi_kategori."<span> (".$jum_post.")</span></a></li>
										";
									}
								?>
                            </ul>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- end main-content -->

<?php include 'templates/footer.php'; ?>
