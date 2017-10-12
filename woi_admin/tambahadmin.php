<article class="content item-editor-page">
<div class="title-block">
	<h3 class="title">Tambahkan Admin/Tim Baru<span class="sparkline bar" data-type="bar"></span></h3>
</div>
	<?php
	if(isset($_POST['btnTambahAdmin'])){
		adminInsert();
	}
	?>
<form name="item" action="" method="post"  enctype="multipart/form-data">
	<div class="card card-block">
		<div class="col-md-12">
			<label class="col-md-2"><b>Nama Lengkap : &nbsp </b></label>
			<div class="col-md-10">
			  <input type="text" name="txtNamaLengkap" class="form-control" placeholder="Nama Lengkap" style="width:100%;" required>
			</div>
		</div>
		<div class="col-md-12">	&nbsp </div>
		<div class="col-md-12">
			<label class="col-md-2"><b>Jabatan : &nbsp </b></label>
			<div class="col-md-10">
			  <input type="text" name="txtJabatan" class="form-control" placeholder="Jabatan " style="width:100%;" required>
			</div>
		</div>
		<div class="col-md-12">	&nbsp </div>
		<div class="col-md-12">
			<label class="col-md-2"><b>Telepon : &nbsp </b></label>
			<div class="col-md-10">
			  <input type="text" name="txtTelepon" class="form-control" placeholder="Nomor telepon aktif" style="width:100%;" required>
			</div>
		</div>
		<div class="col-md-12">	&nbsp </div>
		<div class="col-md-12">
			<label class="col-md-2"><b>Email : &nbsp </b></label>
			<div class="col-md-10">
			  <input type="email" name="txtEmail" class="form-control" placeholder="Email Aktif" style="width:100%;" required>
			</div>
		</div>
		<div class="col-md-12">	&nbsp </div>
		<div class="col-md-12">
			<label class="col-md-2"><b>Facebook : &nbsp </b></label>
			<div class="col-md-10">
			  <input type="text" name="txtFacebook" class="form-control" placeholder="http://www.facebook.com/abc" style="width:100%;" required>
			</div>
		</div>
		<div class="col-md-12">	&nbsp </div>
		<div class="col-md-12">
			<label class="col-md-2"><b>Twitter : &nbsp </b></label>
			<div class="col-md-10">
			  <input type="text" name="txtTwitter" class="form-control" placeholder="http://www.twitter.com/abc" style="width:100%;" required>
			</div>
		</div>
		<div class="col-md-12">	&nbsp </div>
		<div class="col-md-12">
			<label class="col-md-2"><b>Foto : &nbsp </b></label>
			<div class="col-md-10">
				<input id="foto_admin" type="file" name="foto_admin" class="file">
			</div>
		</div>
		<div class="col-md-12">	&nbsp </div>
		<div class="col-md-12">
			<label class="col-md-2"><b>Username Login : &nbsp </b></label>
			<div class="col-md-10">
			  <input type="text" name="txtUsername" class="form-control" placeholder="" style="width:100%;" required>
			</div>
		</div>
		<div class="col-md-12">	&nbsp </div>
		<div class="col-md-12">
			<label class="col-md-2"><b>Password Login : &nbsp </b></label>
			<div class="col-md-10">
			  <input type="text" name="txtPassword" class="form-control" placeholder="" style="width:100%;" required>
			</div>
		</div>
		<div class="col-md-12">	&nbsp </div>
		<div class="col-md-12">
			<label class="col-md-2"><b>Tipe Admin : &nbsp </b></label>
			<div class="col-md-10">
				<select name="tipe_admin" id="tipe_admin" class="form-control" required>
					<option value="tim">Anggota Tim</option>
					<option value="super admin">Super Admin - HAK AKSES PENUH ATAS SEMUA DATA</option>
					<option value="admin">Admin - HAK AKSES PENUH TERKECUALI POSTING DAN BERITA/TAUSYAH</option>
					<option value="moderator">Moderator - HAK AKSES HANYA POSTING DAN BERITA/TAUSYAH</option>
				</select>
			</div>
		</div>
		<div class="col-md-12">	&nbsp </div>
		<div style="text-align:right;">
			<hr>	
			<input type="submit" name="btnTambahAdmin" class="btn btn-primary" value="Tambah TIM/ADMIN">
		</div>
	</div>
</form>
</article>
