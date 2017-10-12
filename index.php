<?php 
	include 'templates/header.php'; 
if(isset($_GET['ref'])){
	$_SESSION['referal'] = $_GET['ref'];
}
?>

<!-- Start main-content -->
<div class="main-content">
    <!-- Section: home -->
    <section id="home">
        <div class="fullwidth-carousel" data-nav="true">
					<div class="carousel-item bg-img-cover" data-bg-img="images/campaign/kids.jpg">
						<div class="display-table">
							<div class="display-table-cell">
								<div class="container pt-150 pb-150">
									<div class="row">
										<div class="cont-paralax text-center">
											<div class="inline-block mt-40 pt-40  pb-40" data-bg-color="rgba(255,255,255, 0.8)">
												<h1 class="text-uppercase text-theme-colored font-raleway font-weight-800 mb-0 mt-0 font-42" >Wakaf<span class="text-theme-color-2">#amalanabadi</span></h1>
												<p class="font-16 text-black font-raleway letter-spacing-1 pl-40 pr-40 pt-10 pb-10">Kami terpercaya sebagai rekan Anda untuk berbagi dengan sesama, menggalang dana wakaf di negara Indonesia tercinta</p>
												<a class="btn btn-colored btn-theme-colored btn-trans" href="tentang-kami.php">Pelajari</a><a class="btn btn-colored btn-theme-colored btn-trans" href="project-wakaf.php">Wakaf</a><a class="btn btn-colored btn-theme-colored btn-trans" href="berita-wakaf.php">Berita Wakaf</a>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
		<?php
			$stmt = $mysqli->query("select * from tbl_kategori_wakaf where tipe_kategori='program'");
			while($data = $stmt->fetch_object()){
				$stmt2 = $mysqli->query("select * from tbl_wakaf_proyek where id_kategori_wakaf=".$data->id_kategori_wakaf." ORDER BY rand()");
				if($stmt2->num_rows>0){
					$image_slide = $stmt2->fetch_object();
					$foto_slide = $image_slide->url_foto;
				}else{
					$foto_slide = "";
				}
				echo'
					<div class="carousel-item bg-img-cover" data-bg-img="'.$foto_slide.'">
						<div class="display-table">
							<div class="display-table-cell">
								<div class="container pt-150 pb-150">
									<div class="row">
										<div class="cont-paralax text-center">
											<div class="inline-block mt-40 pt-40  pb-40" data-bg-color="rgba(255,255,255, 0.8)">
												<h1 class="text-uppercase text-theme-colored font-raleway font-weight-800 mb-0 mt-0 font-42" >Wakaf<span class="text-theme-color-2">#'.str_replace(" ","",strtoupper($data->nama_kategori)).'</span></h1>
												<p class="font-16 text-black font-raleway letter-spacing-1 pl-40 pr-40 pt-10 pb-10">Kami terpercaya sebagai rekan Anda untuk berbagi dengan sesama, menggalang dana wakaf di negara Indonesia tercinta
												melalui program '.ucfirst($data->deskripsi_kategori).'
												</p>
												<a class="btn btn-colored btn-theme-colored btn-trans" href="tentang-kami.php">Pelajari</a><a class="btn btn-colored btn-theme-colored btn-trans" href="project-wakaf.php">Wakaf</a><a class="btn btn-colored btn-theme-colored btn-trans" href="berita-wakaf.php">Berita Wakaf</a>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				';
			}
		?>
        </div>
    </section>

    <!-- Section: Causes -->
    <section>
        <div class="container" style="background-color:#f8f8f8;">
            <div class="section-title" style="margin-bottom:0px !important">
                <div class="row">
                    <div class="col-md-6">
                        <h5 class="font-weight-300 m-0">Pilih dan salurkan Wakaf untuk program yang berarti bagi Anda.</h5>
                        <h2 class="mt-0 text-uppercase font-28">Program Wakaf <span class="text-theme-colored font-weight-400">Pilihan </span> <span class="font-30 text-theme-colored">.</span></h2>
                        <div class="icon">
                            <i class="fa fa-gift"></i>
                        </div>
                    </div>
                    <div class="col-md-6"> <p>
					<?php
						$deskripsi = getPengaturan("deskripsi_website");
						echo $deskripsi;
					?>
					</p></div>
                </div>
            </div>
            <div class="section-content">
                <div class="row">
                    <div class="col-sm-12 col-md-6 pb-30">
                        <h4 class="widget-title title-dots mt-30"><span>Wakaf Terfavorit</span></h4>
						<?php
							$stmt = $mysqli->query("select * from tbl_wakaf_proyek where status_proyek='proses' AND tanggal_akhir>=now() AND favorit=1 order by id_wakaf_proyek DESC LIMIT 0,5");
							if($stmt->num_rows > 0){
								while($data = $stmt->fetch_object()){
									$data_kategori = getDataByCollumn("tbl_kategori_wakaf","id_kategori_wakaf",$data->id_kategori_wakaf);								
									echo'
										<div class="team maxwidth400 bg-lighter mb-20">
											<div class="row">
												<div class="col-sm-6 col-md-6 xs-text-center pb-sm-20" valign="center">
													<div class="thumb"><img class="img-fullwidth" src="'.$data->url_foto.'" alt=""></div>
												</div>
												<div class="col-sm-6 col-md-6 xs-text-center pb-sm-20 pt-20 pr-20">
													<div class="content mr-20">
														<h4 class="author text-theme-colored">'.$data->nama_proyek.'</h4>
														<h6 class="title text-dark">Wakaf '.ucfirst($data_kategori->nama_kategori).'</h6>
														<p>'.substr($data->headline_proyek,0,100).'</p>
														<a class="btn btn-dark btn-theme-colored btn-sm text-uppercase mt-10" href="wakaf-donasi.php?wakaf='.str_replace(" ","-",$data->nama_proyek).'">Wakaf</a> 
														<a class="btn btn-dark btn-theme-colored btn-sm text-uppercase mt-10 pull-right" href="detil-wakaf.php?wakaf='.str_replace(" ","-",$data->nama_proyek).'">Pelajari</a>
													</div>
												</div>
											</div>
										</div>
									';
								}
							}else{
								echo "<h3>Belum ada Wakaf terfavorit<h3>";
							}
						?>
                    </div>
                    <div class="col-sm-12 col-md-6 bd-left pb-30">
                        <h4 class="widget-title title-dots mt-30"><span>Wakaf Terbaru</span></h4>
						<?php
							$stmt = $mysqli->query("select * from tbl_wakaf_proyek where status_proyek='proses' AND tanggal_akhir>=now() order by id_wakaf_proyek DESC LIMIT 0,5");
							if($stmt->num_rows > 0){
								while($data = $stmt->fetch_object()){
									$data_kategori = getDataByCollumn("tbl_kategori_wakaf","id_kategori_wakaf",$data->id_kategori_wakaf);								
									echo'
										<div class="team maxwidth400 bg-lighter mb-20">
											<div class="row">
												<div class="col-sm-6 col-md-6 xs-text-center pb-sm-20" valign="center">
													<div class="thumb"><img class="img-fullwidth" src="'.$data->url_foto.'" alt=""></div>
												</div>
												<div class="col-sm-6 col-md-6 xs-text-center pb-sm-20 pt-20 pr-20">
													<div class="content mr-20">
														<h4 class="author text-theme-colored">'.$data->nama_proyek.'</h4>
														<h6 class="title text-dark">Wakaf '.ucfirst($data_kategori->nama_kategori).'</h6>
														<p>'.substr($data->headline_proyek,0,100).'</p>
														<a class="btn btn-dark btn-theme-colored btn-sm text-uppercase mt-10" href="wakaf-donasi.php?wakaf='.str_replace(" ","-",$data->nama_proyek).'">Wakaf</a> 
														<a class="btn btn-dark btn-theme-colored btn-sm text-uppercase mt-10 pull-right" href="detil-wakaf.php?wakaf='.str_replace(" ","-",$data->nama_proyek).'">Pelajari</a>
													</div>
												</div>
											</div>
										</div>
									';
								}
							}else{
								echo "<h3>Belum ada Wakaf terfavorit<h3>";
							}
						?>
                    </div>
                </div>
                <hr>
            </div>
        </div>
    </section>

    <!-- Section: Tausyiah -->
    <section style="margin-top:25px;">
        <div class="container" style="background-color:#f8f8f8;">
            <div class="section-title">
                <div class="row">
                    <div class="col-md-6">
                        <h5 class="font-weight-300 m-0">Mari simak bersama, pahami dan praktekan</h5>
                        <h2 class="mt-0 text-uppercase font-28">Tausyiah  <span class="text-theme-colored font-weight-400">Terbaru </span> <span class="font-30 text-theme-colored">.</span></h2>
                        <div class="icon">
                            <i class="fa fa-bullhorn"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="section-content">
                <div class="row">
                    <div class="col-md-12">
                        <h4 class="widget-title title-dots mt-30"><span>Trending in Indonesia Ustad Hari Mukti</span></h4>
                    </div>
                    <div class="col-md-3">
                        <div class="col-xs-12 col-md-12"> <a href="#" class="thumbnail"> <img class="img-fullwidth" src="images/ustad-hari-mukti.jpg" alt="..."> </a> </div>
                    </div>
                    <div class="col-md-9">
						<?php
							$stmt = $mysqli->query("SELECT * FROM tbl_post WHERE pemateri='Ustad Hari Mukti' AND status_post='done' ORDER BY tanggal_pembuatan DESC LIMIT 0,6");
							while($data = $stmt->fetch_object()){
								$data_user = getDataByCollumn("tbl_user","id_user",$data->id_user);
								$penulis = explode(" ",$data_user->nama_lengkap);
								$penulis = $penulis[0];
								$headline=substr($data->isi_post,0,75);
								$publish= date("d M Y",strtotime($data->tanggal_pembuatan));
								echo'
									<div class="col-xs-12 col-sm-4 col-md-4">
										<article class="post media-post clearfix pb-0 mb-5" style="background-color:white;padding:5px;">
											<a class="post-thumb" href="#"><img width="70px" height="70px" src="'.$data->url_foto.'" alt=""></a>
											<div class="post-right">
												<h5 class="post-title mt-0"><a href="detil-tausyiah.php?tausyiah='.str_replace(" ","-",$data->judul_post).'">'.$data->judul_post.'</a></h5>
												<p class="post-date mb-10 font-12">Oleh '.$penulis.', '.$publish.'</p>
												<p>'.$headline.'...</p>
											</div>
										</article>
									</div>                        
								';
							}
						?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="container" style="background-color:#f8f8f8;">
            <div class="section-content">
                <div class="row">
                    <div class="col-md-12">
                        <h4 class="widget-title title-dots mt-30 text-right"><span>The Big Picture Ustad Felix Siauw</span></h4>
                    </div>
                    <div class="col-md-9">
						<?php
							$stmt = $mysqli->query("SELECT * FROM tbl_post WHERE pemateri='Ustad Felix Siauw' AND status_post='done' ORDER BY tanggal_pembuatan DESC LIMIT 0,6");
							while($data = $stmt->fetch_object()){
								$data_user = getDataByCollumn("tbl_user","id_user",$data->id_user);
								$penulis = explode(" ",$data_user->nama_lengkap);
								$penulis = $penulis[0];
								$headline=substr($data->isi_post,0,75);
								$publish= date("d M Y",strtotime($data->tanggal_pembuatan));
								echo'
									<div class="col-xs-12 col-sm-4 col-md-4">
										<article class="post media-post clearfix pb-0 mb-5" style="background-color:white;padding:5px;">
											<a class="post-thumb" href="#"><img width="70px" height="70px" src="'.$data->url_foto.'" alt=""></a>
											<div class="post-right">
												<h5 class="post-title mt-0"><a href="detil-tausyiah.php?tausyiah='.str_replace(" ","-",$data->judul_post).'">'.$data->judul_post.'</a></h5>
												<p class="post-date mb-10 font-12">Oleh '.$penulis.', '.$publish.'</p>
												<p>'.$headline.'...</p>
											</div>
										</article>
									</div>                        
								';
							}
						?>
                    </div>
                    <div class="col-md-3">
                        <div class="col-xs-12 col-md-12"> <a href="#" class="thumbnail"> <img class="img-fullwidth" src="images/ustad-felix-siauw.jpg" alt="..."> </a> </div>
                    </div>
                </div>
                <hr>
            </div>
        </div>
    </section>
    <!-- Section: story -->
    <section>
        <div class="container pt-20 pb-20">
            <div class="section-title">
                <div class="row">
                    <div class="col-md-6">
                        <h5 class="font-weight-300 m-0">Beragam cerita kebaikan yang terwujud karena Wakaf Anda.</h5>
                        <h2 class="mt-0 text-uppercase font-28">Blog  <span class="font-weight-400"><img src="images/logo-woi-bigger.png" alt="" /> </span> </h2>
                        <div class="icon">
                            <i class="fa fa-archive"></i>
                        </div>
                    </div>
                    <div class="col-md-6"> <p>
					<?php
						$deskripsi = getPengaturan("deskripsi_website");
						echo $deskripsi;
					?>
					</p></div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-9 bg-blog">
                    <div class="tab-content">
					<?php
						$stmt = $mysqli->query("select * from tbl_post where status_post='done' AND tipe_post='berita' order by id_post DESC LIMIT 0,3");
						$x=0;
						while($data = $stmt->fetch_object()){

							$foto[$x] = $data->url_foto;
							$judul[$x] = $data->judul_post;
							$post[$x] = $data->isi_post;							
							$x++;
						}
						if($stmt->num_rows>0){
							echo'
								<div class="tab-pane fade pl-30 in active" id="tab16">
									<div class="row">
										<div class="col-md-12"> <img class="pull-left pr-20" width="300" src="'.$foto[0].'" alt="">
											<h4 class="entry-title text-white m-0 mt-5 title-blog"><a href="detil-berita.php?berita='.str_replace(" ","-",$judul[0]).'">'.$judul[0].'</h4>
											<p>'.$post[0].'</p>
										</div>
									</div>
								</div>
							';
							if($stmt->num_rows>1){
								for($i=1;$i<$x;$i++){							
									echo'
										<div class="tab-pane fade pl-30" id="tab'.(16+$i).'">
											<div class="row">
												<div class="col-md-12"> <img class="pull-left pr-20" width="300" src="'.$foto[$i].'" alt="">
													<h4 class="entry-title text-white m-0 mt-5 title-blog"><a href="detil-berita.php?berita='.str_replace(" ","-",$judul[$i]).'">'.$judul[$i].'</h4>
													<p>'.$post[$i].'</p>
												</div>
											</div>
										</div>
									';
								}							
							}
						}else{
							echo "<h4>Belum ada proyek wakaf yang selesai.</h4>";
						}
					?>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="vertical-tab">
                        <ul class="nav nav-tabs">
						<?php
							if($stmt->num_rows>0){
								echo'<li class="active"><a class="at-blog" href="#tab16" data-toggle="tab">'.$judul[0].'</a></li>';
								if($stmt->num_rows>1){
									for($i=1;$i<$x;$i++){							
										echo'<li><a class="at-blog" href="#tab'.(16+$i).'" data-toggle="tab">'.$judul[$i].'</a></li>';
									}							
								}
							}
						?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- end main-content -->

<?php include 'templates/footer.php'; ?>
