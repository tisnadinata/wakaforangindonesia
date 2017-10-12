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
              <h3 class="title text-white">Frequently Asked Question</h3>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section>
      <div class="container">
        <div class="row">
          <div class="col-md-9">
            <h4 class="widget-title title-dots mt-30"><span>Silahkan temukan jawaban pertanyaan Anda dibawah ini</span></h4>
            <div id="accordion1" class="panel-group accordion">
              <div class="panel">
                <div class="panel-title"> <a data-parent="#accordion1" data-toggle="collapse" href="#accordion11" class="" aria-expanded="true"> <span class="open-sub"></span> Siapa dan bagaimanakah WOI.OR.ID itu?</a> </div>
                <div id="accordion11" class="panel-collapse collapse" role="tablist" aria-expanded="true">
                  <div class="panel-content">
                    <p>Ut cursus massa at urnaaculis estie. Sed aliquamellus vitae ultrs condmentum leo massa mollis estiegittis miristum nulla.</p>
                  </div>
                </div>
              </div>
              <div class="panel">
                <div class="panel-title"> <a class="collapsed" data-parent="#accordion1" data-toggle="collapse" href="#accordion12" aria-expanded="false"> <span class="open-sub"></span> Apakah kami boleh datang ke kantor WOI.OR.ID?</a> </div>
                <div id="accordion12" class="panel-collapse collapse" role="tablist" aria-expanded="false" style="height: 0px;">
                  <div class="panel-content">
                    <p>Ut cursus massa at urnaaculis estie. Sed aliquamellus vitae ultrs condmentum leo massa mollis estiegittis miristum nulla.</p>
                  </div>
                </div>
              </div>
              <div class="panel">
                <div class="panel-title"> <a data-parent="#accordion1" data-toggle="collapse" href="#accordion13" class="collapsed" aria-expanded="false"> <span class="open-sub"></span> Apakah wakaf kami dapat dengan selamat ke penerimanya?</a> </div>
                <div id="accordion13" class="panel-collapse collapse" role="tablist" aria-expanded="false">
                  <div class="panel-content">
                    <p>Ut cursus massa at urnaaculis estie. Sed aliquamellus vitae ultrs condmentum leo massa mollis estiegittis miristum nulla.</p>
                  </div>
                </div>
              </div>
              <div class="panel">
                <div class="panel-title"> <a data-parent="#accordion1" data-toggle="collapse" href="#accordion14" class="collapsed" aria-expanded="false"> <span class="open-sub"></span> Dimanakah kantor WOI.OR.ID itu?</a> </div>
                <div id="accordion14" class="panel-collapse collapse" role="tablist" aria-expanded="false">
                  <div class="panel-content">
                    <p>Ut cursus massa at urnaaculis estie. Sed aliquamellus vitae ultrs condmentum leo massa mollis estiegittis miristum nulla.</p>
                  </div>
                </div>
              </div>
              <div class="panel">
                <div class="panel-title"> <a data-parent="#accordion1" data-toggle="collapse" href="#accordion15" class="collapsed" aria-expanded="false"> <span class="open-sub"></span> Siapakah owner dari WOI.OR.ID ?</a> </div>
                <div id="accordion15" class="panel-collapse collapse" role="tablist" aria-expanded="false">
                  <div class="panel-content">
                    <p>Ut cursus massa at urnaaculis estie. Sed aliquamellus vitae ultrs condmentum leo massa mollis estiegittis miristum nulla.</p>
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
						$stmt = $mysqli->query("select * from tbl_wakaf_proyek where status_proyek='proses' order by id_wakaf_proyek DESC LIMIT 0,5");
						while($data = $stmt->fetch_object()){
							echo'
							  <article class="post media-post clearfix pb-0 mb-10">
								<a class="post-thumb" href="#"><img src="'.$data->url_foto.'" width="75" height="75" alt=""></a>
								<div class="post-right">
								  <h5 class="post-title mt-0"><a href="detil-wakaf.php?wakaf='.str_replace(" ","-",$data->nama_proyek).'">'.$data->nama_proyek.'</a></h5>
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
      </div>
    </section>
  </div>
  <!-- end main-content -->

<?php include 'templates/footer.php'; ?>
