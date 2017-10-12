<?php
	include 'templates/header.php'; 
	$url=getUrlWeb();
?>
<script language='javascript'>
		function kirimOtp(){
			var nama = document.getElementById("telepon").value;			
			var dataString = "kirim_otp="+nama;
			$.ajax({
				type: "POST",
				url: "ajax.php",	
				data: dataString,
				cache: false,
				success: function(html) {
					document.getElementById("kode_otp").setAttribute("value",html);						
				}
			});	
		}
		function validAngka(obj)
		{
			var pola = "^";
			pola += "[0-9]*";
			pola += "$";
			rx = new RegExp(pola);
		 
			if (!obj.value.match(rx))
			{
				if (obj.lastMatched)
				{
					obj.value = obj.lastMatched;
				}
				else
				{
					obj.value = "";
				}
			}
			else
			{
				obj.lastMatched = obj.value;
			}
		}
	</script>
<!-- Start main-content -->
<div class="main-content">
    <!-- Section: inner-header -->
    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-8">
					<div class="col-md-12 col-xs-12 panel" style="background-color:#f8f8f8;padding-botto: 25px;">
						<div class="icon-box mb-0 p-0">                            
							<h4 class="text-gray pt-10 mt-0 mb-30">List Project Wakaf Terbaru</h4>
						</div>
						<?php
							$stmt = $mysqli->query("select * from tbl_wakaf_proyek where status_proyek='proses' AND tanggal_akhir >= now() order by id_wakaf_proyek LIMIT 0,8");
							echo'
								<div class="row">
							';
							$i=1;
							while($data = $stmt->fetch_object()){
								echo'
									<div class="col-xs-6 col-md-3">
										<div class="team-member" style="border: 1px solid beige;">
											<div class="volunteer-thumb"> <img width="100%" src="'.$url.'/'.$data->url_foto.'" alt="" class="img-responsive" style="height:150px"> </div>
											<div class="bg-lighter text-center pt-20" style="background: #004922 !important;">
												<div class="member-biography">
													<h6 class="mt-0"><a href="'.$url.'/detil-wakaf.php?wakaf='.str_replace(" ","-",$data->nama_proyek).'" style="padding:5px;color:white !important">'.substr($data->nama_proyek,0,30).'</a></h6>
												</div>									
											</div>
										</div>
									</div>
								';
								if($i%4 == 0){
									echo'
										</div>
										<br>
										<div class="row">
									';
								}
								$i++;
							}
							echo'
								</div>
							';
						?>
					</div>
					<div class="col-md-12 col-xs-12 panel" style="background-color:#f8f8f8;padding-botto: 25px;">
						<div class="icon-box mb-0 p-0">                            
							<h4 class="text-gray pt-10 mt-0 mb-30">List Anggota AE/AR Terbaru</h4>
						</div>
						<?php
							$stmt = $mysqli->query("select * from tbl_wakaf_proyek where status_proyek='proses' AND tanggal_akhir >= now() order by id_wakaf_proyek LIMIT 0,8");
							echo'
								<div class="row">
							';
							$i=1;
							while($data = $stmt->fetch_object()){
								echo'
									<div class="col-xs-6 col-md-2" style="padding-left:0px;">
										<div class="team-member" style="border: 1px solid beige;">
											<div class="volunteer-thumb"> <img width="100%" src="'.$url.'/'.$data->url_foto.'" alt="" class="img-responsive" style="height:75px"> </div>
											<div class="bg-lighter text-center pt-20" style="background: #004922 !important;">
												<div class="member-biography" style="padding:3px;color:white !important">
													<p style="font-size:0.8em;" >'.substr($data->nama_proyek,0,15).'</p>
												</div>									
											</div>
										</div>
									</div>
								';
								if($i%4 == 0){
									echo'
										</div>
										<br>
										<div class="row">
									';
								}
								$i++;
							}
							echo'
								</div>
							';
						?>
					</div>
					<div class="col-md-12 col-xs-12 panel" style="background-color:#f8f8f8;padding-botto: 25px;">
						<div class="icon-box mb-0 p-0">                            
							<h4 class="text-gray pt-10 mt-0 mb-30">List Tausyah Terbaru</h4>
						</div>
						<?php
							$stmt = $mysqli->query("SELECT * FROM tbl_post WHERE pemateri='Ustad Hari Mukti' AND status_post='done' ORDER BY tanggal_pembuatan DESC LIMIT 0,6");
							while($data = $stmt->fetch_object()){
								$data_user = getDataByCollumn("tbl_user","id_user",$data->id_user);
								$penulis = explode(" ",$data_user->nama_lengkap);
								$penulis = $penulis[0];
								$headline=substr($data->isi_post,0,75);
								$publish= date("d M Y",strtotime($data->tanggal_pembuatan));
								echo'
									<div class="col-xs-12 col-sm-6 col-md-6" style="margin-bottom:20px;">
										<article class="post media-post clearfix pb-0 mb-5" style="background-color:white;padding:15px;">
											<a class="post-thumb" href="#"><img width="70px" height="70px" src="'.$url.'/'.$data->url_foto.'" alt=""></a>
											<div class="post-right">
												<h5 class="post-title mt-0"><a href="detil-tausyiah.php?tausyiah='.str_replace(" ","-",$data->judul_post).'">'.$data->judul_post.'</a></h5>
												<p class="post-date mb-10 font-12">Oleh '.$penulis.', '.$publish.'</p>
												<p>'.$headline.'...</p>
											</div>
										</article>
									</div>                        
								';
							}
						?>
						<hr>
					</div>					
				</div>
                <div class="col-md-4 hidden-xs">
				<div class="panel"style="background-color:#f8f8f8;">
					<?php
						if(isset($_POST['btnDaftar'])){
							if($_POST['otp'] ==  $_POST['kode_otp']){
								$_SESSION['telepon'] = $_POST['telepon'];
								echo '		
									<div class="divider divider--xs"></div>
										<div class="alert alert-success" role="alert" align="center">
										<b>Mohon tunggu, sedang dialihkan...</b>
									</div>
									<meta http-equiv="Refresh" content="2; URL=register.php">
								';
							}else{
								echo '		
									<div class="divider divider--xs"></div>
										<div class="alert alert-danger" role="alert" align="center">
										<b>Kode registrasi anda salah... !!</b>
									</div>
								';
							}
						}
					?>
						<form action="login.php" method="post">
							<div class="row" style="padding:0px 10px 0px 10px;">
								<div class="col-md-12">
									<label for="form_choose_username"><h3>Masuk Ke Account Anda</h3></label>
								</div>
								<div class="col-md-12">
									<label for="username">Username / Email</label>
									<input name="username" class="form-control" type="text">
								</div>
								<div class="col-md-12">
									<label for="password">Password</label>
									<input name="password" class="form-control" type="password">
								</div>
								<div class="col-md-12">
									<div class="col-md-4 col-xs-12">
									<br>
										<input name="btnLogin" class="form-control btn-success" type="submit" value="MASUK">
									</div>
									<div class="col-md-8 col-xs-12">
									<br>
										<label style="font-size: 0.94em;margin-top: 10px;"><a href="#">Lupa Username / Kata Sandi ?</a></label>									
									</div>
								</div>    
							</div>    
						</form>
						<hr>
						<form action="" method="post">
							<div class="row" style="padding:0px 10px 0px 10px;">
								<div class="col-md-12">
									<label for="form_choose_username"><h3>Daftar Menjadi AE/AR</h3></label>
								</div>
								<div class="col-md-12">
									<label for="telepon">Nomor Handphone Anda</label>
									<input id="telepon" name="telepon" class="form-control" onKeyUp="validAngka(this)"  placeholder="08123456789" type="text">
								</div>
								<div class="col-md-12">
									<label for="otp">Kode Registrasi Anda</label>
									<input id="otp" name="otp" class="form-control" type="text">
									<input type="hidden" name="kode_otp" id="kode_otp" value=""/>
								</div>
								<div class="col-md-12">
									<div class="col-md-4 col-xs-12">
									<br>
										<input name="btnDaftar" class="form-control btn-success" type="submit" value="DAFTAR">
									</div>
									<div class="col-md-8 col-xs-12">
									<br>
										<label style="font-size: 0.94em;margin-top: 10px;"><a href="#" onclick="kirimOtp()">Kirim Ulang Kode Registrasi</a></label>									
									</div>
								</div>    
							</div>    
						</form>
					</div>
				</div>
                <div class="col-md-4 visible-xs" style="margin-top: 457%;">
					<div class="panel"style="background-color:#f8f8f8;">
						<form action="">
							<div class="row" style="padding:0px 10px 0px 10px;">
								<div class="col-md-12">
									<label for="form_choose_username"><h3>Masuk Ke Account Anda</h3></label>
								</div>
								<div class="col-md-12">
									<label for="username">Username / Email</label>
									<input name="username" class="form-control" type="text">
								</div>
								<div class="col-md-12">
									<label for="password">Password</label>
									<input name="password" class="form-control" type="password">
								</div>
								<div class="col-md-12">
									<div class="col-md-4 col-xs-12">
									<br>
										<input name="btnLogin" class="form-control btn-success" type="submit" value="MASUK">
									</div>
									<div class="col-md-8 col-xs-12">
									<br>
										<label style="font-size: 0.94em;margin-top: 10px;"><a href="#">Lupa Username / Kata Sandi ?</a></label>									
									</div>
								</div>    
							</div>    
						</form>
						<hr>
						<form action="">
							<div class="row" style="padding:0px 10px 0px 10px;">
								<div class="col-md-12">
									<label for="form_choose_username"><h3>Daftar Menjadi AE/AR</h3></label>
								</div>
								<div class="col-md-12">
									<label for="telepon">Nomor Handphone Anda</label>
									<input id="telepon" name="telepon" class="form-control" onKeyUp="validAngka(this)"  placeholder="08123456789" type="text">
								</div>
								<div class="col-md-12">
									<label for="otp">Kode Registrasi Anda</label>
									<input id="otp" name="otp" class="form-control" type="text">
									<input type="hidden" id="kode_otp" value=""/>
								</div>
								<div class="col-md-12">
									<div class="col-md-4 col-xs-12">
									<br>
										<input name="btnDaftar" class="form-control btn-success" type="submit" value="DAFTAR">
									</div>
									<div class="col-md-8 col-xs-12">
									<br>
										<label style="font-size: 0.94em;margin-top: 10px;"><a href="#" onclick="kirimOtp()">Kirim Ulang Kode Registrasi</a></label>									
									</div>
								</div>    
							</div>    
						</form>
					</div>
				</div>
            </div>
        </div>
    </section>
</div>  <!-- end main-content -->

<?php include 'templates/footer.php'; ?>

