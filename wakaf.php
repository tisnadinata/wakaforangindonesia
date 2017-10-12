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
                        <h3 class="title text-white">
						<?php
							if(isset($_GET['program'])){
								$nama_program = str_replace("-"," ",$_GET['program']);
								$data_program = getDataByCollumn("tbl_kategori_wakaf","nama_kategori","'".$nama_program."'");
							}else{
								echo'<meta http-equiv="Refresh" content="0; URL=index.php">';
							}							
							echo "Wakaf $nama_program";
						?>						 
						</h2>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section: Causes -->
    <section>
        <div class="container">
            <div class="section-title">
                <div class="row">
                    <div class="col-md-6">
                        <h5 class="font-weight-300 m-0">Pilih dan salurkan Wakaf untuk program yang berarti bagi Anda.</h5>
                        <h2 class="mt-0 text-uppercase font-28">Program <span class="text-theme-colored font-weight-400"><?php echo $data_program->deskripsi_kategori; ?></span> <span class="font-30 text-theme-colored">.</span></h2>
                        <div class="icon">
                            <i class="fa fa-hospital-o"></i>
                        </div>
                    </div>
                    <div class="col-md-6"> <p><?php echo getPengaturan("deskripsi_website"); ?></p></div>
                </div>
            </div>
			<?php
				$stmt = $mysqli->query("SELECT * FROM tbl_wakaf_proyek WHERE status_proyek='proses' AND tanggal_akhir>=now() AND id_kategori_wakaf=".$data_program->id_kategori_wakaf."");
				$i=1;
				echo'
					<div class="section-content">
						<div class="row mtli-row-clearfix">
				';
				if($stmt->num_rows>0){
					while($data_proyek = $stmt->fetch_object()){
						$stmt2 = $mysqli->query("select sum(tbl_wakaf_donasi.jumlah_wakaf) as jum from tbl_wakaf_donasi,tbl_wakaf_donasi_status 
						WHERE tbl_wakaf_donasi.id_wakaf_proyek = ".$data_proyek->id_wakaf_proyek." AND tbl_wakaf_donasi.id_wakaf_donasi = tbl_wakaf_donasi_status.id_wakaf_donasi 
						AND tbl_wakaf_donasi_status.status_wakaf='done'");					
						$data_donasi = $stmt2->fetch_object();
						$sisa_waktu = getSisaWaktu($data_proyek->tanggal_akhir);
						$dana_terkumpul = $data_donasi->jum/$data_proyek->target_dana*100;
						echo '
							<div class="col-sm-4 col-md-4 col-lg-4 wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.3s">
								<div class="causes maxwidth500 mb-sm-50">
									<div class="thumb">
										<img class="img-fullwidth" alt="" width="265" height="195" src="'.$data_proyek->url_foto.'">
									</div>
									<div class="causes-details clearfix">
										<div class="p-30 p-sm-15 bg-lighter bg-high">
											<h4><a href="detil-wakaf.php">'.$data_proyek->nama_proyek.'</a></h4>
											<p>'.$data_proyek->headline_proyek.'</p>
											<ul class="list-inline clearfix mt-20 mb-20">
												<li class="pull-left flip pr-0">Terkumpul: <span class="font-weight-700">Rp. '.setHarga($data_donasi->jum).'</span></li>
											</ul>
											<ul class="list-inline clearfix mt-20 mb-20">
												<li class="pull-left flip pr-0"><span class="font-weight-700">'.$dana_terkumpul.'%</span></li>
												<li class="text-theme-colored pull-right flip pr-0">'.$sisa_waktu.' <span class="font-weight-700"> hari lagi</span></li>
											</ul>
											<a class="btn btn-dark btn-theme-colored btn-sm text-uppercase mt-10" href="login.php">Wakaf</a> 
											<a class="btn btn-dark btn-theme-colored btn-sm text-uppercase mt-10 pull-right" href="detil-wakaf.php?wakaf='.str_replace(" ","-",$data_proyek->nama_proyek).'">Pelajari</a>
										</div>
									</div>
								</div>
							</div>
						';
						if($i%3==0){
							echo'
									</div>
								</div>
								<br>
								<div class="section-content">
									<div class="row mtli-row-clearfix">
							';
						}
						$i++;
					}					
				}else{
					echo "Belum ada wakaf dengan program tersebut";
				}
				echo'
						</div>
					</div>
				';
			?>
        </div>
    </section>


</div>


<!-- end main-content -->

<?php include 'templates/footer.php'; ?>
