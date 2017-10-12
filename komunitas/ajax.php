<?php
include 'config/connect_db.php';

if(isset($_POST['cek_username'])){
	$cari = $_POST['cek_username'];
	if(cekUsername($cari) == 0){
		echo "<label class='label label-success'>TERSEDIA</label> <br>";
	}else if($_POST['cek_username']== ''){
		echo "<label class='label label-warning'>ISI USERNAME</label> <br>";
	}else{
		echo "<label class='label label-danger'>TIDAK TERSEDIA</label> <br>";
	}
}

if(isset($_POST['cek_username'])){
	$cari = $_POST['cek_username'];
	if(cekUsername($cari) == 0){
		echo "<label class='label label-success'>TERSEDIA</label> <br>";
	}else if($_POST['cek_username']== ''){
		echo "<label class='label label-warning'>ISI USERNAME</label> <br>";
	}else{
		echo "<label class='label label-danger'>TIDAK TERSEDIA</label> <br>";
	}
}
if(isset($_POST['cek_otp'])){
	$data = explode("-",$_POST['cek_otp']);
	$cari = $data[0];
	$otp = $data[2];
	if(strtoupper($cari) == strtoupper($otp)){
		echo "success";
	}else{
		echo "fail";
	}
}
if(isset($_POST['kirim_otp'])){
	$telepon = $_POST['kirim_otp'];
	$otp = generateOTP();
	kirimSMS("[woi.or.id] Kode OTP : ".$otp,$telepon);
	echo generateOTP()."-".$otp."-".generateOTP();
}

if(isset($_POST['filter_komunitas'])){
	$filter = "AND tbl_kategori_wakaf.nama_kategori='".$_POST['filter_komunitas']."' ";	
	$sort = '';
	$cari = '';
	$_SESSION['filter_komunitas'] = $filter;
	if(isset($_SESSION['cari_komunitas'])){
		$cari = $_SESSION['cari_komunitas'];		
	}else{
		$cari = '';
	}
	if(isset($_SESSION['urut_komunitas'])){
		if($_SESSION['urut_komunitas'] == 'member'){
			$sort = '';
		}else if($_SESSION['urut_komunitas'] == 'tanggal'){
			$sort = "ORDER BY tanggal_dibuat DESC";		
		}
	}else{
		$sort = '';
	}
	$sql = "select * from tbl_komunitas,tbl_kategori_wakaf where tbl_komunitas.status_komunitas='done' AND 
	tbl_komunitas.nama_komunitas LIKE '%$cari%' AND tbl_komunitas.kategori_komunitas=tbl_kategori_wakaf.id_kategori_wakaf $filter $sort";
	$stmt = $mysqli->query($sql);
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
				<div class="komunitas-detail">
					<div class="komunitas-img">
						<img width="125" height="125" src="'.$foto.'" class="img-responsive img-thumbnail">
					</div>
					<div class="komunitas-title">
						<h2 class="heading-title"><a href="komunitas.php?komunitas='.str_replace(" ","-",$data_komunitas->nama_komunitas).'">'.$data_komunitas->nama_komunitas.'</a></h2>
						<p class="komunitas-meta">'.setHarga($jum_anggota).' anggota. Telah mengirim Rp. '.setHarga($jum_donasi).' dalam '.setHarga($jum_wakaf).' wakaf</p>
						<p class="komunitas-tag">Category '.ucfirst($data_kategori->nama_kategori).' | Team since: '.$data_komunitas->tanggal_dibuat.'</p>
						<p class="komunitas-body font-weight-700">'.$data_komunitas->deskripsi_komunitas.'</p>
					</div>
					<div class="komunitas-join">
						<a href="#" class="btn btn-default btn-gray">Join Team</a>
					</div>
				</div>
			';
		}
	}else{
		echo '		
			<div class="divider divider--xs"></div>
			<div class="alert alert-warning" role="alert" align="center">
				Belum ada data untuk kategori <b>'.strtoupper($_POST['filter_komunitas']).'</b>
			</div>
		';
	}
}

if(isset($_POST['urut_komunitas'])){
	if($_POST['urut_komunitas'] == 'member'){
		$sort = '';
	}else if($_POST['urut_komunitas'] == 'tanggal'){
		$sort = "ORDER BY tanggal_dibuat DESC";		
	}
	$_SESSION['urut_komunitas'] = $sort;
	$filter = '';
	$cari = '';
	if(isset($_SESSION['cari_komunitas'])){
		$cari = $_SESSION['cari_komunitas'];		
	}else{
		$cari = '';
	}
	if(isset($_SESSION['filter_komunitas'])){
		$filter = $_SESSION['filter_komunitas'];		
	}else{
		$filter = '';
	}
	$sql = "select * from tbl_komunitas,tbl_kategori_wakaf where tbl_komunitas.status_komunitas='done' AND 
	tbl_komunitas.nama_komunitas LIKE '%$cari%' AND tbl_komunitas.kategori_komunitas=tbl_kategori_wakaf.id_kategori_wakaf $filter $sort";
	$stmt = $mysqli->query($sql);
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
				<div class="komunitas-detail">
					<div class="komunitas-img">
						<img width="125" height="125" src="'.$foto.'" class="img-responsive img-thumbnail">
					</div>
					<div class="komunitas-title">
						<h2 class="heading-title"><a href="komunitas.php?komunitas='.str_replace(" ","-",$data_komunitas->nama_komunitas).'">'.$data_komunitas->nama_komunitas.'</a></h2>
						<p class="komunitas-meta">'.setHarga($jum_anggota).' anggota. Telah mengirim Rp. '.setHarga($jum_donasi).' dalam '.setHarga($jum_wakaf).' wakaf</p>
						<p class="komunitas-tag">Category '.ucfirst($data_kategori->nama_kategori).' | Team since: '.$data_komunitas->tanggal_dibuat.'</p>
						<p class="komunitas-body font-weight-700">'.$data_komunitas->deskripsi_komunitas.'</p>
					</div>
					<div class="komunitas-join">
						<a href="#" class="btn btn-default btn-gray">Join Team</a>
					</div>
				</div>
			';
		}
	}else{
		echo '		
			<div class="divider divider--xs"></div>
			<div class="alert alert-warning" role="alert" align="center">
				Tidak dapat mengurutkan berdasarkan <b>'.strtoupper($_POST['urut_komunitas']).'</b>
			</div>
		';
	}
}

?>
