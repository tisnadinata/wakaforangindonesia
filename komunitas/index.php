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
	var dataString = "filter_komunitas="+value;
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
function sortKategori(obj){	
	var value = obj.value;
	var dataString = "urut_komunitas="+value;
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
</script>
<div class="main-content">
    <!-- End of Section: Home -->
    <!-- Section: Komunitas-wakaf-->
    <section id="komunitas-wakaf" style="margin-top:-25px;">
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

                <div class="col-md-6" style="background-color: f8f8f8;">
                    <!-- Main Content -->
                    <div class="main-content">
                        <h1 class="font-weight-700 font-28">Komunitas Wakaf Orang Indonesia</h1>

                        <p class="font-weight-700">Komunitas ini adalah sebuah grup yang didirikan oleh Wakif WOI berdasarkan dengan Fokus Wakaf, sekolah ataupun lokasi. Siapapun wakif WOI dapat mendirikan komunitas dengan mengikuti peraturan pendirian komunitas.</p>

                        <p class="font-weight-700">Anda dapat bergabung lebih dari satu komunitas sesuai dengan minat anda. Silahkan pilih komunitas yang sesuai dengan anda</p>

                        <!-- Form Cari Komunitas Wakaf -->
                        <div class="cari-komunitas bg-theme-colored-lighter4">
                            <form action="" method="post">
                                <div class="form-group">
                                    <input type="text" class="input-cari-komunitas form-control" name="txtCariKomunitas" placeholder="&#xf002 Cari Komunitas dengan nama atau kata kunci">
                                    <div class="form-group-btn text-center">
                                        <button type="submit" name="btnCariKomunitas" class="btn btn-theme-colored btn-cari-komunitas font-weight-600">Cari Komunitas</button>
                                        <button type="reset" class="btn btn-theme-colored btn-reset-cari-komunitas font-weight-600" value="Hapus">Hapus</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- End of Form Cari Komunitas Wakaf -->

                        <div class="page-header">
                            <h2>List Komunitas Wakaf Orang Indonesia <br><small>148 komunitas yang telah hadir di seluruh kategori </small></h2>
                        </div>

                        <!-- Filter Cari Komunitas Wakaf -->
                        <div class="filter">
                            <select class="select-categori form-control" onChange="filterKategori(this)">
                                <option>-- Kategori / Komunitas --</option>
								<?php
									$stmt = $mysqli->query("select * from tbl_kategori_wakaf");
									while($data_kategori = $stmt->fetch_object()){
										echo'<option value="'.$data_kategori->nama_kategori.'">'.ucfirst($data_kategori->nama_kategori).'</option>';
									}
								?>                                
                            </select>
                            <label class="label-sort-by" for="select-sort">
                                &nbsp &nbsp &nbsp Urutkan :
                            </label>
                            <select class="select-categori form-control" name="select-sort"  onChange="sortKategori(this)">
                                <option value="tanggal">Tanggal Dibuat</option>
                                <option value="member">Jumlah Member</option>
                            </select>
                            <!-- End of Filter Cari Komunitas Wakaf -->

                            <!-- Class Divider -->
                            <div class="divider"></div>
                            <!-- End of Class Divider -->

                            <!-- List Komunitas -->
                            <div class="komunitas-list" id="daftar_komunitas">								
								<?php
								if(isset($_POST['btnJoinKomunitas'])){
									$stmt = $mysqli->query("insert into tbl_komunitas_anggota(id_komunitas,id_user) values(".$_POST['txtJoinKomunitas'].",".$_COOKIE['login_id'].")");
									if($stmt){
										echo '		
											<div class="divider divider--xs"></div>
											<div class="alert alert-success" role="alert" align="center">
												Anda berhasil bergabung dengan komunitas <b>'.strtoupper($_POST['txtNamaKomunitas']).'</b>
											</div>
										';										
									}else{
										echo '		
											<div class="divider divider--xs"></div>
											<div class="alert alert-danger" role="alert" align="center">
												Maaf, anda gagal bergabung dengan komunitas <b>'.strtoupper($_POST['txtNamaKomunitas']).'</b>
											</div>
										';										
									}
								}
								if(!isset($_POST['btnCariKomunitas'])){
									if(isset($_GET['p'])){
										$posisi = (($_GET['p']-1)*6);
									}else{
										$posisi = 0;
									}
									$stmt = $mysqli->query("select * from tbl_komunitas where status_komunitas='done' ORDER BY id_komunitas DESC LIMIT ".$posisi.",6");
									if($stmt->num_rows > 0){
										while($data_komunitas = $stmt->fetch_object()){
											if($data_komunitas->url_foto==''){
												$foto = "images/profile.png";
											}else{
												$foto = $data_komunitas->url_foto;											
											}
											$data_kategori = getDataByCollumn("tbl_kategori_wakaf","id_kategori_wakaf",$data_komunitas->kategori_komunitas);
											$stmt2 = $mysqli->query("select * from tbl_komunitas_anggota WHERE id_komunitas = ".$data_komunitas->id_komunitas."");
											$jum_anggota = $stmt2->num_rows;
											$jum_wakaf = 0;
											$jum_donasi = 0;
											while($data_anggota = $stmt2->fetch_object()){
												$stmt3 = $mysqli->query("select * from tbl_wakaf_donasi where id_user=".$data_anggota->id_user."");
												while($data_donasi = $stmt3->fetch_object()){
													$jum_donasi = $jum_donasi + $data_donasi->jumlah_wakaf;
													$jum_wakaf++;
												}
											}
											echo'
												<form action="" method="post">
												<div class="komunitas-detail col-md-12">
													<div class="komunitas-img">
														<img width="125" height="125" src="'.$foto.'" class="img-responsive img-thumbnail">
													</div>
													<div class="komunitas-title">
														<input type="hidden" name="txtJoinKomunitas" value="'.$data_komunitas->id_komunitas.'" />
														<input type="hidden" name="txtNamaKomunitas" value="'.$data_komunitas->nama_komunitas.'" />
														<h2 class="heading-title"><a href="komunitas.php?komunitas='.str_replace(" ","-",$data_komunitas->nama_komunitas).'">'.$data_komunitas->nama_komunitas.'</a></h2>
														<p class="komunitas-meta">'.setHarga($jum_anggota).' anggota. Telah mengirim Rp. '.setHarga($jum_donasi).' dalam '.setHarga($jum_wakaf).' wakaf</p>
														<p class="komunitas-tag">Category '.ucfirst($data_kategori->nama_kategori).' | Team since: '.$data_komunitas->tanggal_dibuat.'</p>
														<p class="komunitas-body font-weight-700">'.substr($data_komunitas->deskripsi_komunitas,0,120).'...</p>
														
													</div>
													<div class="komunitas-join">';
											if(!isset($_COOKIE['login_id'])){
												echo'
													<a class="btn btn-success col-md-4 col-xs-12 pull-right text-uppercase" title="Login untuk bergabung" disabled>Gabung Komunitas</a>
													<label class="label label-warning col-md-6 col-xs-12">Silahkan login untuk bergabung di komunitas</label>
												';
											}else{
												$cek_anggota = $mysqli->query("select * from tbl_komunitas_anggota where id_user=".$_COOKIE['login_id']." AND id_komunitas=".$data_komunitas->id_komunitas." ");
												if($cek_anggota->num_rows == 0){
													echo'
														<button type="submit" name="btnJoinKomunitas" class="btn btn-success col-md-4 col-xs-12 pull-right text-uppercase">Gabung Komunitas</button>
													';
												}else{
													echo'
														<a class="btn btn-info col-md-4 col-xs-12 pull-right text-uppercase">Sudah Bergabung</a>
													';
												}
											}
											echo'	</div>
												</div>
												</form>
											';
										}									
									}else{
										echo '		
											<div class="divider divider--xs"></div>
											<div class="alert alert-info" role="alert" align="left">
												Tidak ada data ditemukan.
											</div>
										';
									}
								}else{
									$_SESSION['cari_komunitas'] = $_POST['txtCariKomunitas'];
									$cari = $_POST['txtCariKomunitas'];
									echo '		
										<div class="divider divider--xs"></div>
										<div class="alert alert-info" role="alert" align="left">
											Hasil Pencarian : <b>'.strtoupper($cari).'</b>
										</div>
									';

									$stmt = $mysqli->query("select * from tbl_komunitas where status_komunitas='done' AND nama_komunitas LIKE '%$cari%' ");
									while($data_komunitas = $stmt->fetch_object()){
										if($data_komunitas->url_foto==''){
											$foto = "images/profile.png";
										}else{
											$foto = $data_komunitas->url_foto;											
										}
										$data_kategori = getDataByCollumn("tbl_kategori_wakaf","id_kategori_wakaf",$data_komunitas->kategori_komunitas);
										$stmt2 = $mysqli->query("select * from tbl_komunitas_anggota WHERE id_komunitas = ".$data_komunitas->id_komunitas."");
										$jum_anggota = $stmt2->num_rows;
										$jum_wakaf = 0;
										$jum_donasi = 0;
										while($data_anggota = $stmt2->fetch_object()){
											$stmt3 = $mysqli->query("select * from tbl_wakaf_donasi where id_user=".$data_anggota->id_user."");
											while($data_donasi = $stmt3->fetch_object()){
												$jum_donasi = $jum_donasi + $data_donasi->jumlah_wakaf;
												$jum_wakaf++;
											}
										}
										echo'
											<div class="komunitas-detail">
												<div class="komunitas-img">
													<img width="125" height="125" src="'.$foto.'" class="img-responsive img-thumbnail">
												</div>
												<div class="komunitas-title">
													<h2 class="heading-title"><a href="#">'.$data_komunitas->nama_komunitas.'</a></h2>
													<p class="komunitas-meta">'.setHarga($jum_anggota).' anggota. Telah mengirim Rp. '.setHarga($jum_donasi).' dalam '.setHarga($jum_wakaf).' wakaf</p>
													<p class="komunitas-tag">Category '.ucfirst($data_kategori->nama_kategori).' | Team since: '.$data_komunitas->tanggal_dibuat.'</p>
													<p class="komunitas-body font-weight-700">'.substr($data_komunitas->deskripsi_komunitas,0,120).'...</p>
												</div>
												<div class="komunitas-join">
													<a href="#" class="btn btn-default btn-gray">Join Team</a>
												</div>
											</div>
										';
									}	
								}
								?>
                                <div class="komunitas-pagination text-center">
                                    <nav>
										<ul class="pagination theme-colored">
											
											<?php				
												if(!isset($_POST['btnCariKomunitas'])){
													if(isset($_GET['p'])){
														$posisi = (($_GET['p']-1)*6);
													}else{
														$posisi = 0;
													}
													$stmt = $mysqli->query("select * from tbl_komunitas where status_komunitas='done' ORDER BY id_komunitas DESC");
													$jmlData = $stmt->num_rows;
													$jmlHalaman = ceil($jmlData/6);
													if($jmlHalaman<=1){
														echo'<li class="disabled"> <a aria-label="Previous" href="#"> <span aria-hidden="true">«</span> </a> </li>';
													}else{
														echo'<li> <a aria-label="Previous" href="?p='.($posisi/6).'"> <span aria-hidden="true">«</span> </a> </li>';											
													}
													for($i=1;$i<=$jmlHalaman;$i++){
														if( (($i-1)*6) == $posisi){
															echo'<li class="active"><a href="?p='.$i.'">'.$i.'</a></li>';
														}else{
															echo'<li><a href="?p='.$i.'">'.$i.'</a></li>';												
														}
													}
													if($jmlHalaman==($posisi/6+1)){
														echo'<li class="disabled"> <a aria-label="Next" href="#"> <span aria-hidden="true">»</span> </a> </li>';
													}else{
														echo'<li> <a aria-label="Next" href="?p='.($posisi/6+2).'"> <span aria-hidden="true">»</span> </a> </li>';
													}
												}
											?>
											
										</ul>
									</nav>
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
											if($data_user->hybridauth_provider_name == NULL){
												$foto = $url.'/'.$data_user->url_foto;
											}else{
												$foto = $data_user->url_foto;
											}
											echo'
												<div class="list-pendiri-komunitas-content">
													<img src="'.$foto.'" class="img-responsive img-thumbnail">
													<h4 class="heading-title"><a href="#">'.substr($data_user->nama_lengkap,0,17).'..</a></h4>
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
											if($data_user->hybridauth_provider_name == NULL){
												$foto = $url.'/'.$data_user->url_foto;
											}else{
												$foto = $data_user->url_foto;
											}
											echo'
												<div class="list-pendiri-komunitas-content">
													<img src="'.$foto.'" class="img-responsive img-thumbnail">
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
											if($data_user->hybridauth_provider_name == NULL){
												$foto = $url.'/'.$data_user->url_foto;
											}else{
												$foto = $data_user->url_foto;
											}
											echo'
												<div class="list-pendiri-komunitas-content">
													<img src="'.$foto.'" class="img-responsive img-thumbnail">
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
