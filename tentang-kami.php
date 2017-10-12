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
                        <h3 class="title text-white">Siapakah Kami?</h3>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section: -->
    <section>
        <div class="container">
            <div class="section-content">
                <div class="row">
                    <div class="col-md-8">
                        <h3 class="text-uppercase font-28 letter-space-3">Tentang <span class="text-theme-colored">Woi.or.id</span> </h3>
                        <h5 class="text-uppercase font-weight-400"><span class="text-theme-colored">Our Mission:</span><?php echo getPengaturan("visi_perusahaan");?></h5>

                        <div class="row">
                            <div class="col-md-12">
                                <p><?php echo getPengaturan("deskripsi_perusahaan");?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="thumb">
                            <img alt="" width="350" height="300" src="<?php echo getPengaturan("foto_perusahaan");?>" class="img-fullwidth">
                        </div>
                    </div>
                </div>
                <div class="row mt-40">
                    <div class="col-md-4">
                        <div class="icon-box p-0">
                            <a class="icon-border-effect effect-circled  icon icon-circled mb-0 mr-0 pull-left icon-lg" href="#">
                                <i class="flaticon-charity-donation-box text-theme-colored font-54"></i>
                            </a>
                            <div class="ml-120">
                                <h5 class="icon-box-title mt-15 mb-10 text-uppercase">Dana</h5>
                                <p class="text-gray">
								<?php
									$stmt = $mysqli->query("select sum(tbl_wakaf_donasi.jumlah_wakaf) as jum_wakaf from tbl_wakaf_donasi,tbl_wakaf_donasi_status 
									WHERE tbl_wakaf_donasi.id_wakaf_donasi = tbl_wakaf_donasi_status.id_wakaf_donasi AND tbl_wakaf_donasi_status.status_wakaf='done'");
									$dana = $stmt->fetch_object();
									echo setHarga($dana->jum_wakaf/1000000);
								?> 
								Juta telah terkumpul
								</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="icon-box p-0">
                            <a class="icon-border-effect effect-circled  icon icon-circled mb-0 mr-0 pull-left icon-lg" href="#">
                                <i class="flaticon-charity-person-inside-a-heart text-theme-colored font-54"></i>
                            </a>
                            <div class="ml-120">
                                <h5 class="icon-box-title mt-15 mb-10 text-uppercase">Wakif</h5>
                                <p class="text-gray">
								<?php
									$stmt = $mysqli->query("select count(*) as jum from tbl_wakaf_donasi");
									$wakif = $stmt->fetch_object();
									echo setHarga($wakif->jum);
								?> 
								orang telah berwakaf.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="icon-box p-0">
                            <a class="icon-border-effect effect-circled  icon icon-circled mb-0 mr-0 pull-left icon-lg" href="#">
                                <i class="flaticon-charity-world-in-your-hands text-theme-colored font-54"></i>
                            </a>
                            <div class="ml-120">
                                <h5 class="icon-box-title mt-15 mb-10 text-uppercase">Nazhir</h5>
                                <p class="text-gray">
								<?php
									$stmt = $mysqli->query("select count(*) as jum from tbl_wakaf_proyek where status_proyek='done'");
									$wakif = $stmt->fetch_object();
									echo setHarga($wakif->jum);
								?> 
								wakaf telah terealisasikan</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section: Divider call -->
    <section class="divider parallax layer-overlay overlay-dark-8" data-bg-img="http://placehold.it/1920x1280">
        <div class="container pt-0 pb-0">
            <div class="row">
                <div class="call-to-action">
                    <div class="col-md-9">
                        <h2 class="text-white font-opensans font-30">Saatnya untuk bertindak</h2>
                        <h3 class="text-white font-opensans font-24">Tunjukkan aksi konkrit Anda dengan berwakaf atau menggalang wakaf.</h3>
                    </div>
                    <div class="col-md-3 mt-30">
                        <a href="#" class="btn btn-default btn-circled btn-lg">Buat Campaign</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>
<!-- end main-content -->

<?php include 'templates/footer.php'; ?>
