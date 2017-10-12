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
                    <h3 class="heading-title heading-line-bottom pt-10 pb-10 visible-lg">Mutasi</h3>
                    <div class="row">
                        <div class="col-sm-4 text-center">
                            <div class="icon-box iconbox-border">
                                <a class="icon icon-gray icon-circled icon-border-effect effect-circled" href="#">
                                    <img alt="" src="images/flat-color-icons-svg/currency_exchange.svg" title="currency_exchange.svg"/>
                                </a>
                                <h5 class="icon-box-title">Rp. 
								<?php 
									$stmt = getDataByCollumn("tbl_user","id_user",$_COOKIE['login_id']);
									echo setHarga($stmt->saldo_dompet); 
								?>
								</h5>
                                <p class="text-gray">Saldo Dompet Saya</p>
                            </div>
                        </div>
                    </div>
                    <h3 class="heading-title heading-line-bottom pt-10 pb-10 visible-lg">Berikut riwayat transaksi dompet kebaikan Anda : </h3>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="table-responsive">
                                <table class="table">
                                    <tr class="success">
                                        <th>No</th>
                                        <th>Jumlah</th>
                                        <th>Deskripsi</th>
                                        <th>Waktu</th>
                                        <th>Status</th>
                                    </tr>
									<?php
										if(isset($_GET['p'])){
											$posisi = (($_GET['p']-1)*4);
										}else{
											$posisi = 0;
										}
										$stmt = $mysqli->query("SELECT * FROM tbl_dompet_mutasi WHERE id_user=".$_COOKIE['login_id']." LIMIT ".$posisi.",10");
										if($stmt->num_rows > 0){
											$i=1;
											while($data = $stmt->fetch_object()){
												echo'
													<tr>
														<td>'.$i.'</td>
														<td><b>'.$data->tipe_mutasi.'</b> Rp'.setHarga($data->jumlah_mutasi).'</td>
														<td>'.$data->deskripsi_mutasi.'</td>
														<td>'.$data->tanggal_mutasi.'</td>
														<td>'.strtoupper($data->status_mutasi).'</td>
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
										$stmt = $mysqli->query("SELECT * FROM tbl_dompet_mutasi WHERE id_user=".$_COOKIE['login_id']." LIMIT ".$posisi.",10");
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
