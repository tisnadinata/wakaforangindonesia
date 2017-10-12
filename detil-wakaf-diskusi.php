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
              <h3 class="title text-white">Detil Wakaf</h3>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Section: Blog -->
    <section>
      <div class="container mt-30 mb-30 pt-30 pb-30">
        <div class="row">
          <div class="col-md-9">
            <div class="blog-posts single-post">
			<?php
				if(isset($_GET['wakaf'])){
					$judul_wakaf = str_replace("-"," ",$_GET['wakaf']);
					$stmt = $mysqli->query("select * from tbl_post where status_post='done' AND tipe_post='wakaf' AND judul_post='".$judul_wakaf."'");
					if($stmt->num_rows>0){
						$data = $stmt->fetch_object();
						$data_user = $mysqli->query("select * from tbl_user where id_user=".$data->id_user."");
						$data_user = $data_user->fetch_object();
						$data_komentar = $mysqli->query("select * from tbl_post_komentar where id_post=".$data->id_post."");
						$data_suka = $mysqli->query("select * from tbl_post_suka where id_post=".$data->id_post."");
						$tgl_publish= date("d",strtotime($data->tanggal_pembuatan));
						$bulan_publish= date("M",strtotime($data->tanggal_pembuatan));						
						echo'
						
						  <article class="post clearfix mb-0">
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
									<h4 class="entry-title text-white text-uppercase m-0"><a href="#">'.$data->judul_post.'</a></h4>
									<span class="mb-10 text-gray-darkgray mr-10 font-13"><i class="fa fa-commenting-o mr-5 text-theme-colored"></i> '.$data_komentar->num_rows.' Komentar</span>
									<span class="mb-10 text-gray-darkgray mr-10 font-13"><i class="fa fa-heart-o mr-5 text-theme-colored"></i> '.$data_suka->num_rows.' Suka</span>
								  </div>
								</div>
							  </div>
							  <p class="mb-15">
							  '.$data->isi_post.'
							  </p>
							  <p class="mb-15">';
							  if($data->url_video != '' OR $data->url_video !=NULL){
								  echo'
									  '.$data->url_video.'
								  ';
							  }
							  echo'
							  </p>
							  <div class="mt-30 mb-0">
								<h5 class="pull-left mt-10 mr-20 text-theme-colored">Share:</h5>
								<ul class="social-icons icon-circled m-0">
								  <li><a href="#" data-bg-color="#3A5795"><i class="fa fa-facebook text-white"></i></a></li>
								  <li><a href="#" data-bg-color="#55ACEE"><i class="fa fa-twitter text-white"></i></a></li>
								  <li><a href="#" data-bg-color="#A11312"><i class="fa fa-google-plus text-white"></i></a></li>
								</ul>
							  </div>
							</div>
						  </article>
						  
						  <div class="tagline p-0 pt-20 mt-5">
							<div class="row">
							  <div class="col-md-8">
								<div class="tags">
								  <p class="mb-0"><i class="fa fa-tags text-theme-colored"></i> <span>Tag:</span> '.$data->tag_post.'</p>
								</div>
							  </div>
							</div>
						  </div>
						  <div class="author-details media-post">
							<a href="#" class="post-thumb mb-0 pull-left flip pr-20"><img class="img-thumbnail" alt="" width="125" height="148" src="'.$data_user->url_foto.'"></a>
							<div class="post-right">
							  <h5 class="post-title mt-0 mb-0"><a href="#" class="font-18">'.$data_user->nama_lengkap.'</a></h5>
							  <p>'.$data_user->biografi.'</p>
							  <ul class="social-icons square-sm m-0">
								<li><a href="'.$data_user->url_facebook.'" target="_blank"><i class="fa fa-facebook"></i></a></li>
								<li><a href="'.$data_user->url_twitter.'" target="_blank"><i class="fa fa-twitter"></i></a></li>
								<li><a href="#"><i class="fa fa-google-plus"></i></a></li>
							  </ul>
							</div>
							<div class="clearfix"></div>
						  </div>
						';
					}else{
						echo "<h4>Data proyek tidak ditemukan</h4>";
					}
				}else{
					echo'<meta http-equiv="Refresh" content="0; URL=index.php">';
				}				
			?>
              <div class="comments-area">
                <h5 class="comments-title">Comments</h5>
                <ul class="comment-list">
					<?php
						if($data_komentar->num_rows == 0){
							echo "Belum ada komentar untuk postingan ini.";
						}else{							
							while($komentar = $data_komentar->fetch_object()){
								$data_user = getDataByCollumn("tbl_user","id_user",$komentar->id_user);
								$wakaf = "?wakaf=".$_GET['wakaf']."&";
								echo'
								  <li>
									<div class="media comment-author"> <a class="media-left pull-left flip" href="#"><img class="img-thumbnail" width="75" height="75" src="'.$data_user->url_foto.'" alt=""></a>
									  <div class="media-body">
										<h5 class="media-heading comment-heading">'.$data_user->nama_lengkap.' berkata:</h5>
										<div class="comment-date">'.$komentar->tanggal.'</div>
										<p>'.$komentar->isi_komentar.'</p>
										<a class="replay-icon pull-right text-theme-colored" href="'.$wakaf.'k='.$komentar->id_post_komentar.'"> <i class="fa fa-commenting-o text-theme-colored"></i> Replay</a>
										<div class="clearfix"></div>
										';
										$sub_komen = $mysqli->query("select * from tbl_post_komentar_sub where id_post_komentar=".$komentar->id_post_komentar."");
										while($data_sub = $sub_komen->fetch_object()){
											$data_user = getDataByCollumn("tbl_user","id_user",$data_sub->id_user);
											echo'
												<div class="media comment-author nested-comment"> <a href="#" class="media-left pull-left flip pt-20"><img alt="" width="75" height="75" src="'.$data_user->url_foto.'" class="img-thumbnail"></a>
												  <div class="media-body p-20 bg-lighter">
													<h5 class="media-heading comment-heading">'.$data_user->nama_lengkap.' berkata:</h5>
													<div class="comment-date">'.$data_sub->tanggal.'</div>
													<p>'.$data_sub->isi_komentar.'</p>
												  </div>
												</div>
											';
										}
										echo'
									  </div>
									</div>
								  <br>
								  </li>
								';
							}
						}
					?>
                </ul>
				<hr>
              </div>
              <div class="comment-box">
                <div class="row">
                  <div class="col-sm-12">
                    <h5>Beri Komentar</h5>
					<?php
						if(isset($_POST['btnPostKomentar'])){
							$id_post = getDataByCollumn("tbl_post","judul_post","'".$judul_wakaf."'");
							if(isset($_GET['k'])){
								$sql="insert into tbl_post_komentar_sub(id_post_komentar,id_user,isi_komentar) values(".$_GET['k'].",".$_COOKIE['login_id'].",'".$_POST['txtKomentar']."')";								
							}else{
								$sql="insert into tbl_post_komentar(id_post,id_user,isi_komentar) values(".$id_post->id_post.",".$_COOKIE['login_id'].",'".$_POST['txtKomentar']."')";								
							}
							$stmt = $mysqli->query($sql);
							if($stmt){
								echo'<meta http-equiv="Refresh" content="0; URL=?wakaf='.$_GET['wakaf'].'">';
								echo '		
								<div class="divider divider--xs"></div>
									<div class="alert alert-success" role="alert" align="center">
										<b>Terimakasih, komentar anda sudah kami simpan.</b>
									</div>
								';
							}else{
								echo '		
								<div class="divider divider--xs"></div>
									<div class="alert alert-danger" role="alert" align="center">
										<b>Maaf, komentar anda tidak dapat kami simpan</b>
									</div>
								';
							}
						}
					?>
                    <div class="row">
                      <form role="form" action="" method="post" id="comment-form">
                        <div class="col-sm-12">
                          <div class="form-group">
                            <textarea class="form-control"  name="txtKomentar" id="txtKomentar"  placeholder="Tinggalkan Pesan" rows="3" required></textarea>
                          </div>
                          <div class="form-group">
							<?php
								if(isset($_COOKIE['login_id'])){
									echo'<button type="submit" class="btn btn-dark btn-flat pull-right m-0" name="btnPostKomentar" >Submit</button>';
								}else{
									echo'*Silahkan login untuk memberi komentar.';
									echo'<button type="submit" class="btn btn-dark btn-flat pull-right m-0" disabled>Submit</button>';
								}
							?>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="sidebar sidebar-left mt-sm-30">
              <div class="widget">
                <h5 class="widget-title line-bottom">Kotak Search</h5>
                <div class="search-form">
                  <form action="" method="post">
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
                <h5 class="widget-title line-bottom">Kategori</h5>
                <div class="categories">
                  <ul class="list list-border angle-double-right">
					<?php
						$stmt = $mysqli->query("SELECT * FROM tbl_kategori_wakaf where tipe_kategori='program'");
						while($data = $stmt->fetch_object()){
							$kategori = str_replace("-","",$data->nama_kategori);
							$kategori = str_replace(" ","-",$kategori);
							$jum_post = getCountData("select * from tbl_wakaf_proyek where status_proyek='proses' AND id_kategori_wakaf = ".$data->id_kategori_wakaf." ");
							echo"
								<li><a href='wakaf.php?program=".$kategori."'>".$data->deskripsi_kategori."<span> (".$jum_post.")</span></a></li>
							";
						}
					?>
                  </ul>
                </div>
              </div>
              <div class="widget">
                <h5 class="widget-title line-bottom">Wakaf Terkini</h5>
                <div class="latest-posts">
					<?php
						$stmt = $mysqli->query("select * from tbl_wakaf_proyek where status_proyek='proses' AND tanggal_akhir>=now() order by id_wakaf_proyek DESC LIMIT 0,5");
						while($data = $stmt->fetch_object()){
							echo'
							  <article class="post media-post clearfix pb-0 mb-10">
								<a class="post-thumb" href="#"><img src="'.$data->url_foto.'" width="75" height="75" alt=""></a>
								<div class="post-right">
								  <h5 class="post-title mt-0"><a href="detil-wakaf-diskusi.php?wakaf='.str_replace(" ","-",$data->nama_proyek).'">'.$data->nama_proyek.'</a></h5>
								  <p>'.substr($data->headline_proyek,0,30).'...</p>
								</div>
							  </article>
							';
						}
					?>
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