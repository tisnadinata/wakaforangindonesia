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
                    <h3 class="heading-title heading-line-bottom pt-10 pb-10 visible-lg">Donasi Saya</h3>
                    <div class="row">
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
                    <h3 class="heading-title heading-line-bottom pt-10 pb-10 visible-lg">&nbsp;</h3>
                    <div class="row">
                        <div class="col-sm-5">
                            <div class="widget">

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

                        </div>
                        <div class="col-sm-offset-4 col-sm-3">
                            <form class="form-inline" action="">
                                <div class="form-group">
                                    <label for="">Show</label>
                                    <select name="" id="" class="form-control">
                                        <option value="">10</option>
                                        <option value="">25</option>
                                        <option value="">50</option>
                                        <option value="">100</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="">Entries</label>

                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="table-responsive">
                                <table class="table">
                                    <tr class="success">
                                        <th>No</th>
                                        <th>Judul Campaign</th>
                                        <th>Nominal Donasi</th>
                                        <th>Tanggal Donasi</th>
                                        <th>Status</th>
                                    </tr>
									<?php
										if(isset($_GET['p'])){
											$posisi = (($_GET['p']-1)*4);
										}else{
											$posisi = 0;
										}
										$stmt = $mysqli->query("select * from tbl_wakaf_proyek,tbl_wakaf_donasi,tbl_wakaf_donasi_status 
										where tbl_wakaf_donasi.id_user=".$_COOKIE['login_id']." AND tbl_wakaf_donasi.id_wakaf_proyek = tbl_wakaf_proyek.id_wakaf_proyek 
										AND tbl_wakaf_donasi.id_wakaf_donasi = tbl_wakaf_donasi_status.id_wakaf_donasi ORDER BY tbl_wakaf_donasi_status.tanggal DESC LIMIT ".$posisi.",10");
										if($stmt->num_rows > 0){
											$i=1;
											$status_donasi = "UNKNOWN";
											while($data_donasi=$stmt->fetch_object()){
												if($data_donasi->status_wakaf=="pending"){
													$status_donasi = "WAIT TO PAID";
												}
												if($data_donasi->status_wakaf=="proses"){
													$status_donasi = "WAIT TO VERIFY";
												}
												if($data_donasi->status_wakaf=="done"){
													$status_donasi = "PAID";
												}
												if($data_donasi->status_wakaf=="fail"){
													$status_donasi = "REJECTED";
												}
												echo'
													<tr>
														<td>'.$i.'</td>
														<td>'.$data_donasi->nama_proyek.'</td>
														<td>Rp. '.setHarga($data_donasi->jumlah_wakaf).'</td>
														<td>'.$data_donasi->tanggal.'</td>
														<td>'.strtoupper($status_donasi).'</td>
													</tr>                                    
												';
												$i++;
											}
										}else{
											echo "<tr><td colspan='5'>Belum ada mutasi saldo</td></tr>";
										}
									?>
                                </table>
                            </div>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <nav class="pull-right">
                                <ul class="pagination theme-colored">
									<?php
										
										if(isset($_GET['p'])){
											$posisi = (($_GET['p']-1)*4);
										}else{
											$posisi = 0;
										}
										$stmt = $mysqli->query("select * from tbl_wakaf_proyek,tbl_wakaf_donasi,tbl_wakaf_donasi_status 
									where tbl_wakaf_donasi.id_user=".$_COOKIE['login_id']." AND tbl_wakaf_donasi.id_wakaf_proyek = tbl_wakaf_proyek.id_wakaf_proyek 
									AND tbl_wakaf_donasi.id_wakaf_donasi = tbl_wakaf_donasi_status.id_wakaf_donasi LIMIT ".$posisi.",10");
										$jmlData = $stmt->num_rows;
										$jmlHalaman = ceil($jmlData/10);
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
