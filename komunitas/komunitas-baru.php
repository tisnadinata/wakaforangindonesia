<?php 
	if(!isset($_COOKIE['login_id'])){
		header("location:login.php");
	}
	include 'templates/header.php'; 
	$url=getUrlWeb();
?>
<script language='javascript'>
function filterKategori(obj){
	var value = obj.value;
	var dataString = "cari_komunitas="+value;
	$.ajax({
		type: "POST",
		url: "ajax.php",
		data: dataString,
		cache: false,
		success: function(html) {
			$("#daftar_komunitas").html(html);
		}
	});
}
function cari(){		
	var value = $("#txtCari").val();
	var dataString = "cari_member="+value;
	$.ajax({
		type: "POST",
		url: "ajax.php",
		data: dataString,
		cache: false,
		success: function(html) {
			$("#daftar_member").html(html);
		}
	});
}
</script>
<div class="main-content">
    <!-- Section: home -->
    <section id="home">
        <div class="fullwidth-carousel" data-nav="true">
					<div class="carousel-item bg-img-cover" data-bg-img="<?php echo $url;?>/images/campaign/kids.jpg">
						<div class="display-table">
							<div class="display-table-cell">
								<div class="container pt-150 pb-150">
									<div class="row">
										<div class="cont-paralax text-center">
											<div class="inline-block mt-40 pt-40  pb-40" data-bg-color="rgba(255,255,255, 0.8)">
												<h1 class="text-uppercase text-theme-colored font-raleway font-weight-800 mb-0 mt-0 font-42" >Wakaf<span class="text-theme-color-2">#amalanabadi</span></h1>
												<p class="font-16 text-black font-raleway letter-spacing-1 pl-40 pr-40 pt-10 pb-10">Kami terpercaya sebagai rekan Anda untuk berbagi dengan sesama, menggalang dana wakaf di negara Indonesia tercinta</p>
												<a class="btn btn-colored btn-theme-colored btn-trans" href="#">Gabung Komunitas</a>
												<a class="btn btn-colored btn-theme-colored btn-trans" href="<?php echo $url;?>/project-wakaf.php">Wakaf</a>
												<a class="btn btn-colored btn-theme-colored btn-trans" href="komunitas-baru.php">Buat Komunitas</a>
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
					<div class="carousel-item bg-img-cover" data-bg-img="../'.$foto_slide.'">
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
												<a class="btn btn-colored btn-theme-colored btn-trans" href="tentang-kami.php">Gabung Komunitas</a>
												<a class="btn btn-colored btn-theme-colored btn-trans" href="project-wakaf.php">Wakaf</a>
												<a class="btn btn-colored btn-theme-colored btn-trans" href="berita-wakaf.php">Buat Komunitas</a>
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
    <!-- End of Section: Home -->
    <!-- Section: Komunitas-wakaf-->
    <section id="komunitas-wakaf" style="margin-top:-40px;">
        <div class="container fullwidth">
            <div class="row">
                <div class="col-md-3">
                    <!-- Sidebar Left -->
                    <div class="sidebar-left">
                        <div class="sidebar-top">
                            <h4 class="sidebar-title text-theme-colored font-weight-700">Daftar Proyek Wakaf Komunitas Yang Berjalan</h4>
							<?php
								$stmt = $mysqli->query("select * from tbl_wakaf_proyek where status_proyek='proses' AND tanggal_akhir>=now()  AND id_user!=0 order by id_wakaf_proyek DESC LIMIT 0,5");
								if($stmt->num_rows>0){
									while($data = $stmt->fetch_object()){
										echo'
										  <article class="post media-post clearfix pb-0 mb-10">
											<a class="post-thumb" href="#"><img src="../'.$data->url_foto.'" width="75" height="75" alt=""></a>
											<div class="post-right">
											  <h5 class="post-title mt-0"><a href="detil-wakaf.php?wakaf='.str_replace(" ","-",$data->nama_proyek).'">'.$data->nama_proyek.'</a></h5>
											  <p>'.substr($data->headline_proyek,0,30).'...</p>
											</div>
										  </article>
										';
									}
								}else{
									echo "Belum ada data proyek.";
								}
							?>
						</div>

                        <div class="sidebar-bottom">
                            <h4 class="sidebar-title text-theme-colored font-weight-700">Daftar Proyek Wakaf Komunitas Yang Selesai</h4>
							<?php
								$stmt = $mysqli->query("select * from tbl_wakaf_proyek where status_proyek='done' AND tanggal_akhir>=now()  AND id_user!=0 order by id_wakaf_proyek DESC LIMIT 0,5");
								if($stmt->num_rows>0){
									while($data = $stmt->fetch_object()){
										echo'
										  <article class="post media-post clearfix pb-0 mb-10">
											<a class="post-thumb" href="#"><img src="../'.$data->url_foto.'" width="75" height="75" alt=""></a>
											<div class="post-right">
											  <h5 class="post-title mt-0"><a href="detil-wakaf.php?wakaf='.str_replace(" ","-",$data->nama_proyek).'">'.$data->nama_proyek.'</a></h5>
											  <p>'.substr($data->headline_proyek,0,30).'...</p>
											</div>
										  </article>
										';
									}
								}else{
									echo "Belum ada data proyek.";
								}
							?>
                        </div>
                    </div>
                    <!-- End of Sidebar Left -->
                </div>

                <div class="col-md-6">
                    <!-- Main Content -->
                    <div class="main-content">
                        <h1 class="font-weight-700 font-28">Buat Komunitas Anda Sendiri</h1>                        
                        <!-- Filter Cari Komunitas Wakaf -->
                        <div class="filter">

                            <!-- End of Filter Cari Komunitas Wakaf -->

                            <!-- Class Divider -->
                            <div class="divider"></div>
                            <!-- End of Class Divider -->

                            <!-- List Komunitas -->
                            <div class="komunitas-list" id="daftar_komunitas">								
							<div class="col-md-12" style="border-left:1px solid #eee;">
								<h4 class="text-gray">Isi Form Dibawah.</h4>				
								<form name="reg-form" class="register-form" method="post" enctype="multipart/form-data">
									<?php
										if(isset($_POST['btnTambahKomunitas'])){
											komunitasTambah();
										}
									?>
									<div class="row">
										<div class="form-group col-md-12">
											<label for="nama_komunitas">Nama Komunitas Anda</label>
											<input id="nama_komunitas" name="nama_komunitas" class="form-control" type="text" required>
										</div>
									</div>
									<div class="row">
										<div class="form-group col-md-12">
											<label for="deskripsi_komunitas">Deskripsi Komunitas Anda</label>
											<textarea id="deskripsi_komunitas" name="deskripsi_komunitas" class="form-control" rows="4" required></textarea>
										</div>
									</div>
									<div class="row">
										<div class="col-xs-12 col-md-12">
											<label class="form-control-label">Kategori Komunitas</label>
											<select class="form-control" name="txtkomunitas" required>
											<?php
												$i=0;
												$stmt = $mysqli->query("SELECT * from tbl_kategori_wakaf ORDER BY tipe_kategori");
												while($data = $stmt->fetch_object()){
													echo '
														<option value='.$data->id_kategori_wakaf.'>'.$data->nama_kategori.'</option>
													';
												}
											?>
											</select>
										</div>
									</div>									
									<hr>
									<h4 class="text-gray">Unggah foto/logo komunitas anda.</h4>	
									<div class="row">
										<div class="form-group col-md-4">
											<img src="images/profile.png" class="thumbnail" width="100%" />
										</div>
										<div class="form-group col-md-8">
											<label for="form_choose_username">Unggah foto anda (.jpg / .png) max : 2mb</label>
											<input id="foto_profil" type="file" name="file_foto" class="file form-control" required>
										</div>
									</div>
									<div class="row">
										<div class="form-group col-md-12">
											<input type="checkbox"required> Saya setuju dengan <a target="_blank" href="<?php $url."/term-conditions.php";?>" style="color:green;">Peraturan Komunitas</a> yang berlaku.
										</div>
									</div>
									<div class="form-group">
										<button class="btn btn-dark btn-lg btn-block mt-15" name="btnTambahKomunitas" type="submit">Buat Komunitas Saya Sekarang</button>
									</div>
								</form>
							</div>
                            </div>
                            <!-- End of List Komunitas -->

                        </div>
                    </div>
                    <!-- End of Main Content -->
                </div>

                <div class="col-md-3">
                    <!-- Sidebar Right -->
                    <div class="sidebar-right">
                        <div class="information-btn">
						<?php
							if(isset($_COOKIE['login_id'])){
								echo'
									<p><a class="btn btn-theme-colored font-weight-bold font-18 fullwidth" href="komunitas-baru.php">Buat Komunitas Anda</p></a>
									<p><a class="btn btn-theme-colored font-weight-bold font-18 fullwidth" href="komunitas-saya.php">Daftar Komunitas Anda</p></a>
								';								
							}else{
								echo'
									<p><a class="btn btn-theme-colored font-weight-bold font-18 fullwidth" href="login.php">Buat Komunitas anda</p></a>
								';								
							}
						?>

                            <p><a class="btn btn-theme-colored font-weight-bold font-18 fullwidth">Peraturan Komunitas WOI</p></a>
                        </div>

                        <!-- Class Divider -->
                        <div class="divider"></div>
                        <!-- End of Class Divider -->

                        <!-- List Pendiri Komunitas -->
                        <div class="list-pendiri-komunitas">
                            <h2 class="heading-title text-center font-weight-700 text-capitalize text-theme-colored">Daftar Pendiri Komunitas</h2>

                            <!-- Nav Tabs List Pendiri Komunitas -->
                            <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation" class="active"><a href="#this-month" aria-controls="this-month" role="tab" data-toggle="tab" class="text-uppercase font-weight-600">This Month</a></li>
                                <li role="presentation"><a href="#last-month" aria-controls="last-month" role="tab" data-toggle="tab" class="text-uppercase font-weight-600">Last Month</a></li>
                                <li role="presentation"><a href="#all-time" aria-controls="all-time" role="tab" data-toggle="tab" class="text-uppercase font-weight-600">All Month</a></li>
                            </ul>
                            <!-- End of Nav Tabs List Pendiri Komunitas -->

                            <!-- Tab panes List Pendiri Komunitas -->
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane active" id="this-month">
								<?php
									$stmt = $mysqli->query("select owner_komunitas, count(*) as jum_komunitas from tbl_komunitas where MONTH(tanggal_dibuat)=MONTH(NOW()) group by owner_komunitas order by jum_komunitas desc limit 0,6");
									if($stmt->num_rows>0){
										while($data_owner = $stmt->fetch_object()){
											$data_user = getDataByCollumn("tbl_user","id_user",$data_owner->owner_komunitas);
											echo'
												<div class="list-pendiri-komunitas-content">
													<img src="'.$url.'/'.$data_user->url_foto.'" class="img-responsive img-thumbnail">
													<h4 class="heading-title"><a href="#">'.substr($data_user->nama_lengkap,0,17).'..</a></h2>
													<div class="progress">
														<div class="progress-bar" role="progressbar" aria-valuenow="'.$data_owner->jum_komunitas.'" aria-valuemin="0" aria-valuemax="100" style="width: '.$data_owner->jum_komunitas.'%;">
															<div class="percent text-center ml-5 font-weight-600">
																'.setHarga($data_owner->jum_komunitas).'
															</div>
														</div>
													</div>
												</div>
											';
										}																				
									}else{
										echo "Tidak ada";
									}

								?>
                                </div>

                                <div role="tabpanel" class="tab-pane" id="last-month">
								<?php
									$stmt = $mysqli->query("select owner_komunitas, count(*) as jum_komunitas from tbl_komunitas where MONTH(tanggal_dibuat)=(MONTH(NOW())-1) group by owner_komunitas order by jum_komunitas desc limit 0,6");
									if($stmt->num_rows>0){
										while($data_owner = $stmt->fetch_object()){
											$data_user = getDataByCollumn("tbl_user","id_user",$data_owner->owner_komunitas);
											echo'
												<div class="list-pendiri-komunitas-content">
													<img src="../'.$data_user->url_foto.'" class="img-responsive img-thumbnail">
													<h4 class="heading-title"><a href="#">'.substr($data_user->nama_lengkap,0,17).'..</a></h2>
													<div class="progress">
														<div class="progress-bar" role="progressbar" aria-valuenow="'.$data_owner->jum_komunitas.'" aria-valuemin="0" aria-valuemax="100" style="width: '.$data_owner->jum_komunitas.'%;">
															<div class="percent text-left ml-5 font-weight-600">
																'.setHarga($data_owner->jum_komunitas).'
															</div>
														</div>
													</div>
												</div>
											';
										}																				
									}else{
										echo "Tidak ada";
									}
								?>
                                </div>

                                <div role="tabpanel" class="tab-pane" id="all-time">
								<?php
									$stmt = $mysqli->query("select owner_komunitas, count(*) as jum_komunitas from tbl_komunitas group by owner_komunitas order by jum_komunitas desc limit 0,6");
									if($stmt->num_rows>0){
										while($data_owner = $stmt->fetch_object()){
											$data_user = getDataByCollumn("tbl_user","id_user",$data_owner->owner_komunitas);
											echo'
												<div class="list-pendiri-komunitas-content">
													<img src="../'.$data_user->url_foto.'" class="img-responsive img-thumbnail">
													<h4 class="heading-title"><a href="#">'.substr($data_user->nama_lengkap,0,17).'..</a></h2>
													<div class="progress">
														<div class="progress-bar" role="progressbar" aria-valuenow="'.$data_owner->jum_komunitas.'" aria-valuemin="0" aria-valuemax="100" style="width: '.$data_owner->jum_komunitas.'%;">
															<div class="percent text-left ml-5 font-weight-600">
																'.setHarga($data_owner->jum_komunitas).'
															</div>
														</div>
													</div>
												</div>
											';
										}																				
									}else{
										echo "Tidak ada";
									}
								?>                                    
                                </div>
                            </div>
                            <!-- End of Tab panes List Pendiri Komunitas -->

                            <!-- Nav Tabs New Members -->
                            <h4 class="text-capitalize heading-title">Member Bergabung</h4>

                            <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation" class="active"><a href="#member-this-month" aria-controls="member-this-month" role="tab" data-toggle="tab" class="text-uppercase font-weight-600">This Month</a></li>
                                <li role="presentation"><a href="#member-last-month" aria-controls="member-last-month" role="tab" data-toggle="tab" class="text-uppercase font-weight-600">Last Month</a></li>
                                <li role="presentation"><a href="#member-all-time" aria-controls="member-all-time" role="tab" data-toggle="tab" class="text-uppercase font-weight-600">All Month</a></li>
                            </ul>
                            <!-- End of Nav Tabs New Members -->

                            <!-- Tab panes New Member -->
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane active" id="member-this-month">
								<?php
									$stmt = $mysqli->query("select id_komunitas, count(*) as jum_anggota from tbl_komunitas_anggota where MONTH(tanggal_gabung)=MONTH(NOW()) group by id_komunitas order by jum_anggota desc limit 0,6");
									if($stmt->num_rows>0){
										while($data_anggota = $stmt->fetch_object()){
											$data_komunitas = getDataByCollumn("tbl_komunitas","id_komunitas",$data_anggota->id_komunitas);
											echo'
												<div class="list-pendiri-komunitas-content">
													<img src="'.$data_komunitas->url_foto.'" class="img-responsive img-thumbnail">
													<h4 class="heading-title"><a href="#">'.substr($data_komunitas->nama_komunitas,0,17).'..</a></h2>
													<div class="progress">
														<div class="progress-bar" role="progressbar" aria-valuenow="'.$data_anggota->jum_anggota.'" aria-valuemin="0" aria-valuemax="100" style="width: '.$data_anggota->jum_anggota.'%;">
															<div class="percent text-left ml-5 font-weight-600">
																'.setHarga($data_anggota->jum_anggota).'
															</div>
														</div>
													</div>
												</div>
											';
										}																				
									}else{
										echo "Tidak ada";
									}
								?>
                                </div>

                                <div role="tabpanel" class="tab-pane" id="member-last-month">
                                   
 								<?php
									$stmt = $mysqli->query("select id_komunitas, count(*) as jum_anggota from tbl_komunitas_anggota where MONTH(tanggal_gabung)=(MONTH(NOW())-1) group by id_komunitas order by jum_anggota desc limit 0,6");
									if($stmt->num_rows>0){
										while($data_anggota = $stmt->fetch_object()){
											$data_komunitas = getDataByCollumn("tbl_komunitas","id_komunitas",$data_anggota->id_komunitas);
											echo'
												<div class="list-pendiri-komunitas-content">
													<img src="'.$data_komunitas->url_foto.'" class="img-responsive img-thumbnail">
													<h4 class="heading-title"><a href="#">'.substr($data_komunitas->nama_komunitas,0,17).'..</a></h2>
													<div class="progress">
														<div class="progress-bar" role="progressbar" aria-valuenow="'.$data_anggota->jum_anggota.'" aria-valuemin="0" aria-valuemax="100" style="width: '.$data_anggota->jum_anggota.'%;">
															<div class="percent text-left ml-5 font-weight-600">
																'.setHarga($data_anggota->jum_anggota).'
															</div>
														</div>
													</div>
												</div>
											';
										}																				
									}else{
										echo "Tidak ada";
									}
								?>
                                 </div>

                                <div role="tabpanel" class="tab-pane" id="member-all-time">
								<?php
									$stmt = $mysqli->query("select id_komunitas, count(*) as jum_anggota from tbl_komunitas_anggota group by id_komunitas order by jum_anggota desc limit 0,6");
									if($stmt->num_rows>0){
										while($data_anggota = $stmt->fetch_object()){
											$data_komunitas = getDataByCollumn("tbl_komunitas","id_komunitas",$data_anggota->id_komunitas);
											echo'
												<div class="list-pendiri-komunitas-content">
													<img src="'.$data_komunitas->url_foto.'" class="img-responsive img-thumbnail">
													<h4 class="heading-title"><a href="#">'.substr($data_komunitas->nama_komunitas,0,17).'..</a></h2>
													<div class="progress">
														<div class="progress-bar" role="progressbar" aria-valuenow="'.$data_anggota->jum_anggota.'" aria-valuemin="0" aria-valuemax="100" style="width: '.$data_anggota->jum_anggota.'%;">
															<div class="percent text-left ml-5 font-weight-600">
																'.setHarga($data_anggota->jum_anggota).'
															</div>
														</div>
													</div>
												</div>
											';
										}																				
									}else{
										echo "Tidak ada";
									}
								?>
                                 </div>
                            </div>
                            <!-- End of Tab panes New Member -->

                        </div>
                        <!-- End of List Pendiri Komunitas -->

                    </div>
                    <!-- End of Sidebar Right -->
                </div>

            </div>
        </div>
    </section>
    <!-- End of Section Konfirmasi Wakaf -->

<?php include 'templates/footer.php'; ?>
