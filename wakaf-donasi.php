
<?php include 'templates/header.php'; ?>
<script language='javascript'>
function tandaPemisahTitik(b){
	var _minus = false;
	if (b<0) _minus = true;
	b = b.toString();
	b=b.replace(".","");
	b=b.replace("-","");
	c = "";
	panjang = b.length;
	j = 0;
	for (i = panjang; i > 0; i--){
		j = j + 1;
		if (((j % 3) == 1) && (j != 1)){
			c = b.substr(i-1,1) + "." + c;
		} else {
			c = b.substr(i-1,1) + c;
		}
	}
	if (_minus) c = "-" + c ;
	return c;
}
function setTotalBayar(){
	var pola = "^";
	pola += "[0-9]*";
	pola += "$";
	rx = new RegExp(pola);
	obj = document.getElementById("txtDonasi");
	if (!obj.value.match(rx)){
		if (obj.lastMatched){
			obj.value = obj.lastMatched;
		}else{
			obj.value = "";
		}
	}else{
		obj.lastMatched = obj.value;
	}
	var donasi = parseInt(obj.value);
	var biayaOp = parseInt(document.getElementById("txtBiayaOperasional").value);
	var total = parseInt(donasi+(donasi*biayaOp/100));
	total = tandaPemisahTitik(total);
	document.getElementById("txtTotalBayar").value= "Rp "+total;
}
</script>
<!-- Start main-content -->
<div class="main-content">
    <!-- Section: Halaman -->
    <section class="halaman boxed-layout">
        <div class="container">
            <div class="row">
                <div class="col-sm-8 col-md-8">
                    <section class="content">
						<div class="col-xs-12 col-md-12"style="background-color:#f8f8f8;">
						<?php
							if(isset($_GET['wakaf'])){
								$link_wakaf = explode("*",$_GET['wakaf']);
								$referal = null;
								if(count($link_wakaf) > 1){
									$_SESSION['referal'] = $link_wakaf[1];
								}
								$judul_wakaf = str_replace("-"," ",$link_wakaf[0]);
								$stmt = $mysqli->query("select * from tbl_wakaf_proyek where status_proyek='proses' AND nama_proyek='".$judul_wakaf."'");
								if($stmt->num_rows>0){
									$data_proyek = $stmt->fetch_object();
									$stmt2 = $mysqli->query("select sum(tbl_wakaf_donasi.jumlah_wakaf) as jum from tbl_wakaf_donasi,tbl_wakaf_donasi_status 
									WHERE tbl_wakaf_donasi.id_wakaf_proyek = ".$data_proyek->id_wakaf_proyek." AND tbl_wakaf_donasi.id_wakaf_donasi = tbl_wakaf_donasi_status.id_wakaf_donasi 
									AND tbl_wakaf_donasi_status.status_wakaf='done'");					
									$data_donasi = $stmt2->fetch_object();
									$sisa_waktu = getSisaWaktu($data_proyek->tanggal_akhir);
									$dana_terkumpul = $data_donasi->jum/$data_proyek->target_dana*100;
									echo'
										<div class="content-title">
											<h2><a href="#">'.$data_proyek->nama_proyek.'</a></h2>
										</div>

										<div class="content-img">
											<img src="'.$data_proyek->url_foto.'" width="100%" height="350">
										</div>

										<div class="content-body mt-10">
											<p class="font-16 font-weight-600">
												'.$data_proyek->deskripsi_proyek.'
											</p>
										</div>
									';
								}
							}
						?>
						</div>
						<div class="col-xs-12 col-md-12">
							<hr>
						</div>
						<div class="col-xs-12 col-md-12">
							<!-- Form Donasi -->
							<form class="donasi" action="" method="post">
								<div class="form-group">
									<div class="col-md-8">
										<input type="number" id="txtDonasi" onInput="setTotalBayar()" name="txtDonasi" class="input-rp form-control" min="20000" value="20000" step="1000" placeholder="Rp" required>
										<p class="font-weight-700 text-donasi-wakaf1">Wakaf minimal Rp. 20.000 serta kelipatan ribuan <br>
										(misal: 50.000, 82.000, 105.000, dst.)</p>
									</div>
									<div class="col-md-4">
										<select class="form-control" name="txtBiayaOperasional" onChange="setTotalBayar()" id="txtBiayaOperasional" required>
										<?php										
											for($i=0;$i<=25;$i++){
												if($i==15){
													echo "<option value='$i' selected>$i %</option>";
												}else{
													echo "<option value='$i'>$i %</option>";
												}
											}
											
										?>
										</select>
										<p class="text-theme-colored text-donasi-wakaf2" title="ini untuk biaya operasional">Tambahan Untuk Operasional BWA ( 0-25% )</p>
									</div>
								</div>
								<div class="form-group">
									<p class="input-label-total text-theme-colored font-22 font-weight-600">Total yang dibayarkan</p>
									<input type="text" id="txtTotalBayar" name="txtTotalBayar" class="input-rp-total form-control text-center" value="Rp 23.000" placeholder="Rp" value="0" required readonly>
								</div>
								<div class="form-group pull-right">
									<button type="submit" name="btnMasukanKeranjang" class="btn btn-colored btn-theme-colored">Masukan Keranjang</button>
									<button type="submit" name="btnBayarSekarang" class="btn btn-colored btn-theme-colored">Bayar Sekarang</button>
								</div>
							</form>
						</div>
						<?php
							if(isset($_POST['btnMasukanKeranjang'])){
								$biaya_donasi = $_POST['txtDonasi'];
								$biaya_operasional = $_POST['txtBiayaOperasional'];
								$id_wakaf_proyek = $data_proyek->id_wakaf_proyek;
								if(isset($_COOKIE['login_id'])){
									$id_user = $_COOKIE['login_id'];									
								}else{
									$id_user = getIpCustomer();
								}
								$stmt = $mysqli->query("select * from tbl_wakaf_donasi_temp where id_wakaf_proyek=$id_wakaf_proyek AND id_user='$id_user'");
								if($stmt->num_rows > 0){
									$stmt2 = $mysqli->query("UPDATE tbl_wakaf_donasi_temp SET jumlah_wakaf=(jumlah_wakaf+$biaya_donasi),operasional=$biaya_operasional WHERE id_wakaf_proyek=$id_wakaf_proyek AND id_user=$id_user");
								}else{
									$stmt2 = $mysqli->query("INSERT INTO tbl_wakaf_donasi_temp(id_wakaf_proyek,id_user,jumlah_wakaf,operasional) VALUES($id_wakaf_proyek,'$id_user',$biaya_donasi,$biaya_operasional)");
								}
								if($stmt2){
									echo '		
										<div class="divider divider--xs"></div>
										<div class="alert alert-success" role="alert" align="center">
											Donasi wakaf sudah dimasukan ke Keranjang Wakaf anda.
										</div>
									';			
								}else{
									echo '		
										<div class="divider divider--xs"></div>
										<div class="alert alert-danger" role="alert" align="center">
											Gagal menambahkan donasi wakaf ke Keranjang Wakaf, silahkan coba lagi nanti.
										</div>
									';			
								}								
							}
							if(isset($_POST['btnBayarSekarang'])){
								$biaya_donasi = $_POST['txtDonasi'];
								$biaya_operasional = $_POST['txtBiayaOperasional'];
								$id_wakaf_proyek = $data_proyek->id_wakaf_proyek;
								if(isset($_COOKIE['login_id'])){
									$id_user = $_COOKIE['login_id'];									
								}else{
									$id_user = getIpCustomer();
								}
								$stmt = $mysqli->query("select * from tbl_wakaf_donasi_temp where id_wakaf_proyek=$id_wakaf_proyek AND id_user='$id_user'");
								if($stmt->num_rows > 0){
									$stmt2 = $mysqli->query("UPDATE tbl_wakaf_donasi_temp SET jumlah_wakaf=(jumlah_wakaf+$biaya_donasi),operasional=$biaya_operasional WHERE id_wakaf_proyek=$id_wakaf_proyek AND id_user='$id_user'");
								}else{
									$stmt2 = $mysqli->query("INSERT INTO tbl_wakaf_donasi_temp(id_wakaf_proyek,id_user,jumlah_wakaf,operasional) VALUES($id_wakaf_proyek,'$id_user',$biaya_donasi,$biaya_operasional)");
								}
								if($stmt2){
									echo '		
										<div class="divider divider--xs"></div>
										<div class="alert alert-success" role="alert" align="center">
											Donasi wakaf sudah dimasukan ke Keranjang Wakaf anda.
										</div>
										<meta http-equiv="Refresh" content="0; URL=konfirmasi-wakaf.php">
									';			
								}else{
									echo '		
										<div class="divider divider--xs"></div>
										<div class="alert alert-danger" role="alert" align="center">
											Gagal melakukan wakaf, silahkan coba lagi nanti.
										</div>
									';			
								}								
							}
						?>
                        <!-- End of Form Donasi -->
						<div class="col-xs-12 col-md-12">
							<hr>
						</div>
                        <!-- List Wakif -->
                        <div class="col-md-12 col-xs-12 list-wakif">
                            <h2 class="text-theme-colored font-weight-500">List Wakif</h2>
							<?php
								$stmt3 = $mysqli->query("select * from tbl_wakaf_donasi where id_wakaf_proyek=".$data_proyek->id_wakaf_proyek."");
								if($stmt3->num_rows>0){
									while($data_wakif = $stmt3->fetch_object()){
										if($data_wakif->status_wakif=="anonim"){
											$foto = "images/user/profile.png";
											$nama = "Hamba Allah";
										}else{
											$stmt4 = $mysqli->query("select * from tbl_user where id_user =".$data_wakif->id_user."");
											$user = $stmt4->fetch_object();
											$foto = $user->url_foto;
											$nama = $user->nama_lengkap;
										}
										echo'
											<div class="col-md-2 col-xs-4" style="padding:0px;height:125px;">
												<img src="'.$foto.'" class="img-responsive" width="75" height="75">
												'.substr($nama,0,15).'
											</div>
										';
									}
								}else{
									echo "Belum ada wakif yang berdonasi";
								}
							?>
                        </div>
                    </section>
                </div>
                <!-- End of List Wakif -->
						<div class="col-xs-12 col-md-4">
							<hr>
						</div>
                <!-- Sidebar -->
                <div class="col-xs-12 col-md-4">
                    <?php 
					echo'
                    <div class="heading-title">
                        <h2>Wakaf yang dibutuhkan <br> Rp.'.setHarga($data_proyek->target_dana).'</h2>
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" aria-valuenow="'.$dana_terkumpul.'" aria-valuemin="0" aria-valuemax="100" style="width: '.$dana_terkumpul.'%;">
                                <div class="percent">
                                    '.$dana_terkumpul.'
                                </div>
                            </div>
                        </div>
                        <p class="font-weight-600">Butuh Rp. '.setHarga($data_proyek->target_dana-$data_donasi->jum).' lagi</p>
                        <div class="btn-wakaf" align="center">
                            <a href="detil-wakaf.php?wakaf='.str_replace(" ","-",$data_proyek->nama_proyek).'" target="_blank" class="btn btn-colored btn-theme-colored font-weight-600">Detail</a>

                            <a href="#" class="btn btn-colored btn-theme-colored font-weight-600">Update</a>

                            <a href="detil-wakaf-diskusi.php?wakaf='.str_replace(" ","-",$data_proyek->nama_proyek).'" target="_blank" class="btn btn-colored btn-theme-colored font-weight-600">Diskusi</a>
                        </div>
					';
					
					$title = $data_proyek->nama_proyek;
					$summary = $data_proyek->deskripsi_proyek;
					$image = $data_proyek->url_foto;;
					$url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
					if(isset($_COOKIE['login_id'])){
						$url .= "*".$_COOKIE['login_tipe']."=".$_COOKIE['login_id'];
					}

					?>
						<hr>
                        <div class="btn-social">
                            <a id="button" onClick="window.open('http://www.facebook.com/sharer.php?s=100&amp;p[title]=<?php echo $title; ?>&amp;p[summary]=<?php echo $summary;?>&amp;p[url]=<?php echo $url; ?>&amp;&p[images][0]=<?php echo $image;?>', 'sharer', 'toolbar=0,status=0,width=550,height=400');" target="_parent" href="javascript: void(0)"	 class="col-md-12 col-xs-12 btn btn-primary"><i class="fa fa-facebook"></i> Share On Facebook</a>
							<br><br>
                            <a target="_blank" href="http://twitter.com/share?source=sharethiscom&text=<?php echo $title;?>&url=<?php echo $url; ?>" class="col-md-12 col-xs-12 btn btn-info"><i class="fa fa-twitter"></i> Share On Twitter</a>
							<br><br>
                            <a href="javascript:void(0);" onclick="popUp=window.open('https://plus.google.com/share?url=<?php echo $url; ?> ','popupwindow','scrollbars=yes,width=800,height=400');popUp.focus();return false" class="col-md-12 col-xs-12 btn btn-danger"><i class="fa fa-google-plus"></i> Share On Google+</a>
							<br><br>
<!--                            <a href="#" class="col-md-12 col-xs-12 btn btn-default"><i class="fa fa-instagram"></i> Share On Insgragram (Belum)</a>
							<br><br>
-->                            <a href="whatsapp://send?text=<?php echo $title;?>. <?php echo $url; ?>" data-action="share/whatsapp/share" class="col-md-12 col-xs-12 btn btn-success"><i class="fa fa-whatsapp"></i> Share On WhatsApp</a>
                        </div>						
						<hr><br>
                        <!-- Project Lain -->
						<div class="widget">
							<h5 class="widget-title line-bottom">Proyek Wakaf Lainnya</h5>
							<div class="latest-posts">
								<?php
									$stmt = $mysqli->query("select * from tbl_wakaf_proyek where status_proyek='proses' AND tanggal_akhir>=now() order by id_wakaf_proyek DESC LIMIT 0,5");
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
                        <!-- End of Project Lain -->
                    </div>
                </div>
            </div>
        </div>
    </scction>
    <!-- End of Section Halaman -->
</div>
<!-- end main-content -->

<?php include 'templates/footer.php'; ?>
