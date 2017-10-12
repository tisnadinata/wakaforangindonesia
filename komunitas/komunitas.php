<?php 
	include 'templates/header.php'; 
	if(isset($_COOKIE['cari_komunitas'])){
		setcookie("cari_komunitas", $_POST['txtCariKomunitas'], time()-3600,"/");
		unset($_COOKIE['cari_komunitas']);
	}
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
    <!-- Section: Komunitas-wakaf-->
    <section id="komunitas-wakaf">
        <div class="container fullwidth" style="background-color: rgb(119, 119, 119);">
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
					<?php
						$data_ada = false;
						if(isset($_GET['komunitas'])){
							$nama_komunitas = str_replace("-"," ",$_GET['komunitas']);
							$stmt = $mysqli->query("select * from tbl_komunitas where nama_komunitas LIKE '".$nama_komunitas."'");
							if($stmt->num_rows >  0){
								$data_komunitas = $stmt->fetch_object();	
								$data_ada = true;
							}else{
								echo '		
									<div class="divider divider--xs"></div>
										<div class="alert alert-danger" role="alert" align="center">
										Tidak ada komunitas yang ditemukan, pastikan nama komunitas terdaftar.
									</div>
								';																	
							}
						}else{
							echo '		
								<div class="divider divider--xs"></div>
									<div class="alert alert-danger" role="alert" align="center">
									Tidak ada komunitas yang ditemukan, pastikan nama komunitas terdaftar.
								</div>
							';																	
						}
						if(isset($_POST['btnJoinKomunitas'])){
							$stmt = $mysqli->query("insert into tbl_komunitas_anggota(id_komunitas,id_user) values(".$data_komunitas->id_komunitas.",".$_COOKIE['login_id'].")");
							if($stmt){
								echo '		
									<div class="divider divider--xs"></div>
									<div class="alert alert-success" role="alert" align="center">
										Anda berhasil bergabung dengan komunitas <b>'.strtoupper($data_komunitas->nama_komunitas).'</b>
									</div>
								';										
							}else{
								echo '		
									<div class="divider divider--xs"></div>
									<div class="alert alert-danger" role="alert" align="center">
										Maaf, anda gagal bergabung dengan komunitas <b>'.strtoupper().'</b>
									</div>
								';										
							}
						}
						if(isset($_POST['btnKeluarKomunitas'])){
							$stmt = $mysqli->query("delete from tbl_komunitas_anggota where id_komunitas=".$data_komunitas->id_komunitas." AND id_user=".$_COOKIE['login_id']."");
							if($stmt){
								echo '		
									<div class="divider divider--xs"></div>
									<div class="alert alert-success" role="alert" align="center">
										Anda telah keluar dari komunitas <b>'.strtoupper($data_komunitas->nama_komunitas).'</b>, terimakasih atas partisipasinya
									</div>
								';										
							}else{
								echo '		
									<div class="divider divider--xs"></div>
									<div class="alert alert-danger" role="alert" align="center">
										Maaf, anda gagal menghapus data keanggotaan dari komunitas <b>'.strtoupper($data_komunitas->nama_komunitas).'</b>
									</div>
								';										
							}
						}
					?>
						<div class="list-pendiri-komunitas">
							<ul class="nav nav-tabs" role="tablist" style="background-color:#004922;">
								<li role="presentation" class="active"><a href="#detail-komunitas" aria-controls="detail-komunitas" role="tab" data-toggle="tab" class="text-uppercase font-weight-600" style="color:#f3f3f3;background-color:transparent;border-radius:0px">Tentang Komunitas</a></li>
								<li role="presentation"><a href="#daftar-anggota" aria-controls="daftar-anggota" role="tab" data-toggle="tab" class="text-uppercase font-weight-600" style="color:#f3f3f3;background-color:transparent;border-radius:0px">Member Komunitas <span class="badge"><?php echo getCountData("select * from tbl_komunitas_anggota where id_komunitas=".$data_komunitas->id_komunitas.""); ?></span> </a></li>
								<li role="presentation"><a href="#daftar-proyek" aria-controls="daftar-proyek" role="tab" data-toggle="tab" class="text-uppercase font-weight-600" style="color:#f3f3f3;background-color:transparent;border-radius:0px">Proyek Komunitas <span class="badge"><?php echo getCountData("select * from tbl_wakaf_proyek where status_proyek='proses' AND tanggal_akhir >= now() order by id_wakaf_proyek"); ?></span> </a></li>
							</ul>					
						</div>
						<div>
							<div class="tab-content" style="background-color: white;">
								<?php
									if($data_ada){
								?>
								<div role="tabpanel" class="tab-pane row active" id="detail-komunitas">
									<div class="col-md-7">
											<?php
												if(isset($_POST['btnPost'])){
													$isi_post = $_POST['txtPost'];
													$stmt = $mysqli->query("insert into tbl_komunitas_post(id_komunitas,id_user,isi_post) values(".$data_komunitas->id_komunitas.",".$_COOKIE['login_id'].",'".$isi_post."')");
													if($stmt){
														echo '		
															<div class="divider divider--xs"></div>
																<div class="alert alert-success" role="alert" align="center">
																Postingan pesan anda sudah kami simpan, terimakasih atas partisipasi anda.
															</div>
														';																	
													}else{
														echo '		
															<div class="divider divider--xs"></div>
																<div class="alert alert-danger" role="alert" align="center">
																Gagal menyimpan data pesan anda, silahkan coba beberapa saat lagi.
															</div>
														';																	
													}
												}
											?>
									<div class="comments-area">
										<h3 class="comments-title">Posting Terakhir : </h3>
										<label>Untuk menghindari spam, kami membatasi pesan yang ditampilkan hanya bagi yang pernah melakukan wakaf.</label>
										<hr>
										<ul class="comment-list">
										<?php
											$stmt = $mysqli->query("select * from tbl_komunitas_post where id_komunitas=".$data_komunitas->id_komunitas." LIMIT 0,5");
											if($stmt->num_rows>0){
												while($data_post = $stmt->fetch_object()){
													$data_user = getDataByCollumn("tbl_user","id_user",$data_post->id_user);
													$cek = $mysqli->query("select * from tbl_wakaf_donasi where id_user=".$data_user->id_user."");
													if($cek->num_rows > 0){
														if($data_user->hybridauth_provider_name == NULL){
															$foto = $url.'/'.$data_user->url_foto;
														}else{
															$foto = $data_user->url_foto;
														}
														echo'
														  <li>
															<div class="media comment-author"> <a class="media-left pull-left flip" href="#"><img class="img-thumbnail" width="75" height="75" src="'.$foto.'" alt=""></a>
															  <div class="media-body">
																<h5 class="media-heading comment-heading">'.$data_user->nama_lengkap.'</h5>
																<hr><p>'.$data_post->isi_post.'</p>
															  </div>
															</div>
														  </li>
														<hr>
														';
													}
												}
											}
										?>
										</ul>
									  </div>
									  <div class="col-md-12">											
											<form action="" method="post">
												<div class="form-group">
													<label for="txtPost">Posting Sesuatu :</label>
													<textarea class="form-control" id="txtPost" name="txtPost" rows="4" required></textarea>
												</div>
												<div class="form-group">
												<?php
												if(!isset($_COOKIE['login_id'])){
														echo'
															<label class="label label-warning">Silahkan login untuk men-posting</label>
															<button class="btn btn-success pull-right" disabled>POSTING</button>
														';
												}else{
													$cek_anggota = $mysqli->query("select * from tbl_komunitas_anggota where id_user=".$_COOKIE['login_id']." AND id_komunitas=".$data_komunitas->id_komunitas." ");
													if($cek_anggota->num_rows == 0){
														echo'
															<label class="label label-warning">Anda belum bergabung dengan komunitas ini.</label>
															<button class="btn btn-success pull-right" disabled>POSTING</button>
														';
													}else{
														echo'
															<button class="btn btn-success pull-right" name="btnPost" type="submit">POSTING</button>
														';
													}
												}
												?>
												
												</div>											
											</form>										  
									  </div>
									</div>
									<div class="col-md-5" style="border-left:1px solid #eeeeee;">										
									<?php
										if($data_komunitas->url_foto==''){
											$foto = "images/profile.png";
										}else{
											$foto = $data_komunitas->url_foto;											
										}										
										echo '
											<div class="col-md-5">										
												<img src="'.$foto.'" width="100%" />
											</div>
											<div class="col-md-7">
												<table>
													<tr>
														<th>Nama Komunitas :</th>
													</tr>
													<tr>
														<td>'.$data_komunitas->nama_komunitas.'</td>
													</tr>
													<tr>
														<td>&nbsp </td>
													</tr>
													<tr>
														<th>Terbentuk Sejak :</th>
													</tr>
													<tr>
														<td>'.$data_komunitas->tanggal_dibuat.'</td>
													</tr>
												</table>												
											</div>
											<div class="col-md-12">
												<h4>Tentang Kami :</h4>
												'.$data_komunitas->deskripsi_komunitas.'
											</div>
											<div style="margin:10px;">&nbsp </div>
											<div class="col-md-12">
											<center>
										';
										if(!isset($_COOKIE['login_id'])){
											echo'
													<a class="btn btn-success text-uppercase col-md-12" title="Login untuk bergabung" disabled>Gabung Komunitas</a>
													<br>
													<br>
													<label class="label label-warning">Silahkan login untuk bergabung komunitas</label>
											';
										}else{
											$cek_anggota = $mysqli->query("select * from tbl_komunitas_anggota where id_user=".$_COOKIE['login_id']." AND id_komunitas=".$data_komunitas->id_komunitas." ");
												echo'<form action="" method="post">';
											if($cek_anggota->num_rows == 0){
												echo'
														<input type="submit" name="btnJoinKomunitas" class="btn btn-success text-uppercase col-md-12" value="Bergabung dengan Komunitas"/>
												';
											}else{
												echo'
													<button class="btn btn-danger text-uppercase col-md-12" name="btnKeluarKomunitas" type="submit">Keluar Komunitas</button>
													<br>
													<br>
													<label class="label label-info">Anda sudah tergabung disini</label>
												';
											}
												echo'
													</form>
												';
										}
										echo'
											</center>
											</div>
										';
									?>
									</div>
								</div>
								<div role="tabpanel" class="tab-pane row " id="daftar-anggota">
									<?php
										$stmt_anggota = $mysqli->query("select * from tbl_komunitas_anggota where id_komunitas=".$data_komunitas->id_komunitas."");
										if($stmt_anggota->num_rows > 0){
											echo'
											<div class="col-md-12">
												<h4 class="heading-title"><a href="#">Daftar anggota komunitas ( '.$stmt_anggota->num_rows.' orang) : </a></h2>
													<hr>
											</div>
											';
											$i = 0;
											while($data_anggota = $stmt_anggota->fetch_object()){
												$listUser[$i] = $data_anggota->id_user;
												$i++;
												echo'
													<div class="col-md-2">
														<ul class="comment-list">
														';
															$data_user = getDataByCollumn("tbl_user","id_user",$data_anggota->id_user);
															if($data_user->hybridauth_provider_name == NULL){
																$foto = $url.'/'.$data_user->url_foto;
															}else{
																$foto = $data_user->url_foto;
															}
															echo'
															  <li>
																<div class="media comment-author text-center img-thumbnail"> 
																	<a class="" href="#">
																		<img class="" width="100%" height="75px" src="'.$foto.'" alt="">
																	</a>
																	'.$data_user->nama_lengkap.'
																</div>
															 </li>
															';
														echo'
														</ul>
													</div>
												';
											}
										}else{
											echo "
												<div class='col-md-12'>
													Belum ada anggota bergabung.
												</div>
											";
										}
									?>
								</div>
								<div role="tabpanel" class="tab-pane row " id="daftar-proyek">
									<div class="col-md-12">                        
									<?php
										echo'
										<div class="section-content">
											<div class="row mtli-row-clearfix">
										';
										if(isset($_GET['p'])){
											$posisi = (($_GET['p']-1)*4);
										}else{
											$posisi = 0;
										}
										$qUser = '';
										for($i=1;$i<count($listUser);$i++){
											$qUser .= "id_user = ".$listUser[$i]." OR ";
										}
											$qUser .= " id_user = 0";
										$stmt = $mysqli->query("select * from tbl_wakaf_proyek where status_proyek='proses' AND tanggal_akhir >= now() AND ($qUser) order by id_wakaf_proyek");
										$i=1;
										if($stmt->num_rows > 0){							
											while($data_proyek = $stmt->fetch_object()){
												$stmt2 = $mysqli->query("select sum(tbl_wakaf_donasi.jumlah_wakaf) as jum from tbl_wakaf_donasi,tbl_wakaf_donasi_status 
												WHERE tbl_wakaf_donasi.id_wakaf_proyek = ".$data_proyek->id_wakaf_proyek." AND tbl_wakaf_donasi.id_wakaf_donasi = tbl_wakaf_donasi_status.id_wakaf_donasi 
												AND tbl_wakaf_donasi_status.status_wakaf='done'");					
												$data_donasi = $stmt2->fetch_object();
												$sisa_waktu = getSisaWaktu($data_proyek->tanggal_akhir);
												$dana_terkumpul = $data_donasi->jum/$data_proyek->target_dana*100;
												echo'
													<div class="col-sm-6 col-md-4 col-lg-4" data-wow-duration="0.5s" data-wow-delay="0.3s">
														<div class="causes maxwidth500 mb-sm-50">
															<div class="thumb">
																<img class="img-fullwidth" alt="" width="265" height="195" src="'.$url.'/'.$data_proyek->url_foto.'">
															</div>
															<div class="causes-details clearfix">
																<div class="p-30 p-sm-15 bg-lighter" style="padding:15px !important;">
																	<h4><a href="#">'.$data_proyek->nama_proyek.'</a></h4>
																	<p>'.$data_proyek->headline_proyek.'</p>
																	<ul class="list-inline clearfix mt-20 mb-20">
																		<li class="pull-left flip pr-0">Terkumpul: <span class="font-weight-700">Rp. '.setHarga($data_donasi->jum).'</span></li>
																	</ul>
																	<ul class="list-inline clearfix mt-20 mb-20">
																		<li class="pull-left flip pr-0"><span class="font-weight-700">'.$dana_terkumpul.'%</span></li>
																		<li class="text-theme-colored pull-right flip pr-0">'.$sisa_waktu.' <span class="font-weight-700"> hari lagi</span></li>
																	</ul>
																	<a class="btn btn-dark btn-theme-colored btn-sm text-uppercase mt-10" href="wakaf-donasi.php?wakaf='.str_replace(" ","-",$data_proyek->nama_proyek).'">Wakaf</a> 
																	<a class="btn btn-dark btn-theme-colored btn-sm text-uppercase mt-10 pull-right" href="detil-wakaf.php?wakaf='.str_replace(" ","-",$data_proyek->nama_proyek).'">Pelajari</a>
																</div>
															</div>
														</div>
													</div>
												';
												if($i%2 ==  0){
													echo'
														</div>
														<br>
														<div class="row mtli-row-clearfix">
													';
												}
												$i++;
											}
										}else{
											echo "&nbsp &nbsp &nbsp Tidak ada proyek wakaf berjalan";
										}	
										echo'
											</div>
										</div>
										';
										?>
									</div>
								</div>
								<?php
									}
								?>
							</div>
						</div>
				</div>
            </div>
        </div>
    </section>
    <!-- End of Section Konfirmasi Wakaf -->

<?php include 'templates/footer.php'; ?>
