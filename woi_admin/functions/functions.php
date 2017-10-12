<?php 
session_start();
	include '../emailLibrary/function.php';
//$mysqli = new mysqli("localhost","muata672_aditya","27april1996","muata672_woi");		
$mysqli = new mysqli("localhost","root","","db_woi");
//$mysqli = new mysqli("188.166.222.108","wakaf_admin","Wakaf1234","wakaf_woi");		
	
if (mysqli_connect_errno())
{
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
// getting the user IP address
function getIpCustomer(){
$ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
        $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'IP Tidak Dikenali';
 
    return $ipaddress;
}
function generateOTP(){
   $karakter = 'ABCDEFGHIJKLMNOPQRSTU1234567890';
   $string = '';
   for($i = 0; $i < 6; $i++) {
   $pos = rand(0, strlen($karakter)-1);
   $string .= $karakter{$pos};
   }
    return $string;
}
function kirimSMS($isi_sms,$nomor){
	$isi_pesan = $isi_sms;
	$userkeyanda = 'inxa3r';
	$passkeyanda = 'tisnadinata';
	$nohptujuan = $nomor;
	$url = "https://reguler.zenziva.net/apps/smsapi.php?userkey=$userkeyanda&passkey=$passkeyanda&nohp=$nohptujuan&pesan=$isi_pesan";
	$url = str_replace(" ","%20",$url);
	file_get_contents($url);
}
function kirimEmail($judul,$isi,$email){
    $to       = $email;
    $subject  = $judul;
    $message  = "<p>".$isi."</p>";
    smtp_mail($to, $subject, $message, '', '', 0, 0, true);
}
function enkripPassword($value){
	return sha1(md5($value));	
}
function setHarga($harga){
	return number_format($harga,0,",",".");
}
function getCountData($sql){
	global $mysqli;
	$stmt = $mysqli->query($sql);
	return $stmt->num_rows;
}
function getSumData($sql){
	global $mysqli;
	$stmt = $mysqli->query($sql);
	$row = $stmt->fetch_object();
	return $row->total;
}
function getDataByCollumn($table,$collumn,$value){
	global $mysqli;
	$stmt = $mysqli->query("select * from $table WHERE $collumn LIKE $value");
	if($stmt->num_rows > 0){
		return $stmt->fetch_object();		
	}else{
		return null;
	}
}
function cekUsername($username){
	global $mysqli;
	$stmt = $mysqli->query("select * from tbl_login where username='".$username."'");
	return $stmt->num_rows;
}
function getPengaturanUmum($nama_pengaturan){
	global $mysqli;
	$stmt = $mysqli->query("select * from tbl_pengaturan where nama_pengaturan='$nama_pengaturan' ")->fetch_object();
	return $stmt->value_pengaturan;
}
function pengaturanUmum(){
	global $mysqli;
	$stmt = $mysqli->query("select * from tbl_pengaturan");
	$i=0;
	while($row = $stmt->fetch_object()){
		$data[$row->id_pengaturan] = $row->value_pengaturan;
		$i++;
	}
	$stmt->close();
	if(isset($_POST['btnUbahPengaturan'])){
		$pengaturan = $_POST['pengaturan'];
		for($i=1;$i<=count($pengaturan);$i++){
			$mysqli->query("
				UPDATE tbl_pengaturan SET
				value_pengaturan = '".$pengaturan[$i]."'
				WHERE id_pengaturan = '$i'
			");
		}
		echo '		
			<div class="divider divider--xs"></div>
			<div class="alert alert-success" role="alert" align="center">
				Pengaturan berhasil diubah.
			</div>
			<meta http-equiv="Refresh" content="1; URL=">
		';					
	}
	echo'
		<form action="" role="form" method="post">
						<input type="hidden"name="pengaturan[4]" value="'.$data[4].'">
						<input type="hidden" name="pengaturan[5]" value="'.$data[5].'">
						<input type="hidden"name="pengaturan[11]" value="'.$data[11].'">
						<input type="hidden" name="pengaturan[13]" value="'.$data[13].'">
		<div class="row">
			<div class="col col-md-6">
				<h6>Data Perusahaan :</h6>
				<div class="form-group row">
					<label for="inputEmail3" class="col-sm-4 form-control-label">Nama Perusahaan</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" name="pengaturan[1]" placeholder="Nama Perusahaan" value="'.$data[1].'"></div>
				</div>
				<div class="form-group row">
					<label for="inputEmail3" class="col-sm-4 form-control-label">Deskripsi Perusahaan</label>
					<div class="col-sm-8">
						<textarea class="form-control" name="pengaturan[12]" rows="5" cols="28" width="100%" style="resize:none;" placeholder="Alamat Perusahaan Anda">'.$data[12].'</textarea>
					</div>
				</div>
				<div class="form-group row">
					<label for="inputEmail3" class="col-sm-4 form-control-label">Visi&Misi Perusahaan</label>
					<div class="col-sm-8">
						<textarea class="form-control" name="pengaturan[10]" rows="5" cols="28" width="100%" style="resize:none;" placeholder="Alamat Perusahaan Anda">'.$data[10].'</textarea>
					</div>
				</div>
				<div class="form-group row">
					<label for="inputEmail3" class="col-sm-4 form-control-label">Alamat Perusahaan</label>
					<div class="col-sm-8">
					<input type="text" class="form-control" name="pengaturan[3]" placeholder="Alamat Perusahaan" value="'.$data[3].'"></div>
				</div>
				<div class="form-group row">
					<label for="inputEmail3" class="col-sm-4 form-control-label">Nomor Telepon</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" name="pengaturan[9]" placeholder="Nomor telepon perusahaan/website" value="'.$data[9].'"></div>
				</div>
			</div>
			<div class="col col-md-6">
				<h6>Data Website :</h6>
				<div class="form-group row">
					<label for="inputEmail3" class="col-sm-4 form-control-label">Deskripsi Website</label>
					<div class="col-sm-8">
						<textarea class="form-control" name="pengaturan[2]" rows="5" cols="28" width="100%" style="resize:none;" placeholder="Alamat Perusahaan Anda">'.$data[2].'</textarea>
					</div>
				</div>
				<div class="form-group row">
					<label for="inputEmail3" class="col-sm-4 form-control-label">URL Facebook</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" name="pengaturan[6]" placeholder="Link/URL gambar website anda" value="'.$data[6].'"></div>
				</div>
				<div class="form-group row">
					<label for="inputEmail3" class="col-sm-4 form-control-label">URL Twitter</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" name="pengaturan[7]" placeholder="Link/URL gambar website anda" value="'.$data[7].'"></div>
				</div>
				<div class="form-group row">
					<label for="inputEmail3" class="col-sm-4 form-control-label">EMAIL Website</label>
					<div class="col-sm-8">
						<input type="email" class="form-control" name="pengaturan[8]" placeholder="Link/URL gambar website anda" value="'.$data[8].'"></div>
				</div>
				<h6>Data Website :</h6>
				<div class="form-group row">
					<label for="inputEmail3" class="col-sm-5 form-control-label">Komisi Akun AE/AR (%) </label>
					<div class="col-sm-4">
						<input type="number" class="form-control" name="pengaturan[14]" min="0" max="100" value="'.$data[14].'"></div>
					</div>
				</div>
				<br><hr><br>
				<div class="form-group row">
					<div class="col-sm-12">
						<button type="submit" name="btnUbahPengaturan" class="btn btn-primary col-sm-12 col-md-6 col-md-offset-3 pull-right">Ubah pengaturan</button>
					</div>
				</div>
			</div>
		</div>
	</form>
	';
}
function bankList($tipe){
	global $mysqli;
	
	$stmt = $mysqli->query("SELECT * from tbl_bank where tipe_bank='$tipe'");
	if($stmt->num_rows== 0){
		echo '<tr class=""><td colspan="8" class="center">Tidak ada data ditemukan.</td></tr>';
	}else{
		while($data = $stmt->fetch_object()){
			$data_user = getDataByCollumn("tbl_user","id_user",$data->id_user);
			echo'
				<tr class="">
					<td align="center">'.$data_user->nama_lengkap.'</td>
					<td>'.$data->nama_bank.'</td>
					<td>'.$data->atas_nama.'</td>
					<td>'.$data->rekening_bank.'</td>
					<td>'.$data->status_bank.'</td>
					<td align="center">
			';
				if($tipe=="admin"){
					echo'
						<a href="?page=bank&tipe=admin&edit='.$data->id_bank.'"><button class="btn btn-info fa fa-edit" title="EDIT DATA"></button></a>						
					';
				}
				if($tipe=="wakif" AND $data->status_bank="pending"){
					echo'
						<a href="?page=bank&tipe=admin&set=done-'.$data->id_bank.'"><button class="btn btn-success fa fa-check" title="VERIFIKASI BAKN"></button></a>						
					';
				}
			echo'
						<a href="?page=bank&tipe=admin&delete='.$data->id_bank.'"><button class="btn btn-danger fa fa-remove" title="HAPUS DATA"></button></a>						
					</td>
				</tr>
			';		
		}
	}
	
}

function bankTambah(){
	global $mysqli;
	
	$nama_bank = $_POST['nama_bank'];
	$atas_nama = $_POST['atas_nama'];
	$rekening_bank = $_POST['rekening_bank'];
	$stmt = $mysqli->query("insert into tbl_bank(nama_bank,atas_nama,rekening_bank,status_bank,tipe_bank) values('$nama_bank','$atas_nama','$rekening_bank','done','admin')");
	if($stmt){
		echo '		
			<div class="divider divider--xs"></div>
			<div class="alert alert-success" role="alert" align="center">
				Data Bank berhasil ditambah .
			</div>
		';
	}else{
		echo '		
			<div class="divider divider--xs"></div>
			<div class="alert alert-danger" role="alert" align="center">
				Data Bank gagal ditambah .
			</div>
		';
	}
	
}
function bankEdit(){
	global $mysqli;
	
	$nama_bank = $_POST['nama_bank'];
	$atas_nama = $_POST['atas_nama'];
	$rekening_bank = $_POST['rekening_bank'];
	$stmt = $mysqli->query("UPDATE tbl_bank SET nama_bank='$nama_bank', atas_nama='$atas_nama', rekening_bank='$rekening_bank' WHERE id_bank=".$_GET['edit']."");
	if($stmt){
		echo '		
			<div class="divider divider--xs"></div>
			<div class="alert alert-success" role="alert" align="center">
				Data Bank berhasil diubah .
			</div>
			<meta http-equiv="Refresh" content="1; URL=?page=bank&tipe=admin">
		';
	}else{
		echo '		
			<div class="divider divider--xs"></div>
			<div class="alert alert-danger" role="alert" align="center">
				Data Bank gagal diubah .
			</div>
		';
	}
	
}
function bankSet($set_status){
	global $mysqli;
	
	$set_status = explode("-",$set_status);
	$status = str_replace("_"," ",$set_status[0]);
	$id_pencairan = $set_status[1];
	
	$stmt = $mysqli->query("UPDATE tbl_bank SET status_bank = '$status' WHERE id_bank = $id_bank");
	if($stmt){
			$data_user = getDataByCollumn("tbl_user","id_user",$data_pencairan->id_user);
		if($status=="fail"){
			kirimSMS("Maaf, pencairan bank anda tidak dapat kami verifikasi",$data_user->telepon);
			if($stmt){			
			}
		}else if($status=="done"){
			kirimSMS("Selamat, bank anda berhasil sudah kami verifikasi",$data_user->telepon);
			
//			$data_email = getDataByCollumn("tbl_customer","id_customer",$data_peminjaman->id_customer);
//			kirimEmail("member",$data_pesan,$data_email->email);
		}
			echo '		
				<div class="divider divider--xs"></div>
				<div class="alert alert-success" role="alert" align="center">
					Status bank berhasil diubah.
				</div>
			';
	}else{
		echo '		
			<div class="divider divider--xs"></div>
			<div class="alert alert-danger" role="alert" align="center">
				Status bank gagal diubah, silahkan coba lagi.
			</div>
		';
	}
	echo'
		<meta http-equiv="Refresh" content="2; URL=?page=bank&tipe=member">
	';
}

function bankDelete($id_bank){
	global $mysqli;
	
	$stmt = $mysqli->query("delete from tbl_bank where id_bank = $id_bank");
	if($stmt){
		echo '		
			<div class="divider divider--xs"></div>
			<div class="alert alert-success" role="alert" align="center">
				Data berhasil dihapus.
			</div>
		';
	}else{
		echo '		
			<div class="divider divider--xs"></div>
			<div class="alert alert-danger" role="alert" align="center">
				Data gagal dihapus, silahkan coba lagi.
			</div>
		';
	}
}
function kategoriList(){
	global $mysqli;
	
	$stmt = $mysqli->query("SELECT * from tbl_kategori_wakaf");
	if($stmt->num_rows== 0){
		echo '<tr class=""><td colspan="8" class="center">Tidak ada data ditemukan.</td></tr>';
	}else{
		while($data = $stmt->fetch_object()){
			echo'
				<tr class="">
					<td align="center">'.$data->id_kategori_wakaf.'</td>
					<td>'.$data->nama_kategori.'</td>
					<td>'.$data->deskripsi_kategori.'</td>
					<td>'.$data->tipe_kategori.'</td>
					<td align="center">
						<a href="?page=daftar-kategori&edit='.$data->id_kategori_wakaf.'"><button class="btn btn-info fa fa-edit" title="EDIT DATA"></button></a>						
						<a href="?page=daftar-kategori&delete='.$data->id_kategori_wakaf.'"><button class="btn btn-danger fa fa-remove" title="HAPUS DATA"></button></a>						
					</td>
				</tr>
			';		
		}
	}
	
}

function kategoriTambah(){
	global $mysqli;
	
	$nama_kategori = $_POST['tag_program'];
	$deskripsi_kategori = $_POST['nama_program'];
	$tipe_kategori = $_POST['tipe_program'];
	$stmt = $mysqli->query("insert into tbl_kategori_wakaf(nama_kategori,deskripsi_kategori,tipe_kategori) values('$nama_kategori','$deskripsi_kategori','tipe_kategori')");
	if($stmt){
		echo '		
			<div class="divider divider--xs"></div>
			<div class="alert alert-success" role="alert" align="center">
				Program wakaf berhasil ditambah .
			</div>
		';
	}else{
		echo '		
			<div class="divider divider--xs"></div>
			<div class="alert alert-danger" role="alert" align="center">
				Program wakaf gagal ditambah .
			</div>
		';
	}
	
}
function kategoriEdit(){
	global $mysqli;
	
	$nama_kategori = $_POST['tag_program'];
	$deskripsi_kategori = $_POST['nama_program'];
	$tipe_kategori = $_POST['tipe_program'];
	$stmt = $mysqli->query("UPDATE tbl_kategori_wakaf SET nama_kategori='$nama_kategori', deskripsi_kategori='$deskripsi_kategori', tipe_kategori='$tipe_kategori' WHERE id_kategori_wakaf=".$_GET['edit']."");
	if($stmt){
		echo '		
			<div class="divider divider--xs"></div>
			<div class="alert alert-success" role="alert" align="center">
				Program wakaf berhasil diubah .
			</div>
			<meta http-equiv="Refresh" content="1; URL=?page=daftar-kategori">
		';
	}else{
		echo '		
			<div class="divider divider--xs"></div>
			<div class="alert alert-danger" role="alert" align="center">
				Program wakaf gagal diubah .
			</div>
		';
	}
	
}
function kategoriDelete($id_kategori_wakaf){
	global $mysqli;
	
	$stmt = $mysqli->query("delete from tbl_kategori_wakaf where id_kategori_wakaf = $id_kategori_wakaf");
	if($stmt){
		echo '		
			<div class="divider divider--xs"></div>
			<div class="alert alert-success" role="alert" align="center">
				Data berhasil dihapus.
			</div>
		';
	}else{
		echo '		
			<div class="divider divider--xs"></div>
			<div class="alert alert-danger" role="alert" align="center">
				Data gagal dihapus, silahkan coba lagi.
			</div>
		';
	}
}
function komunitasList($tipe){
	global $mysqli;
	if($tipe=="fail"){
		$cari = "status_komunitas='fail'";
	}else if($tipe=="pending"){
		$cari = "status_komunitas='pending'";
	}else if($tipe=="all"){
		$cari = "status_komunitas!='nol'";
	}
	$stmt = $mysqli->query("SELECT * from tbl_komunitas where $cari");
	if($stmt->num_rows == 0){
		echo '<tr class=""><td colspan="8" class="center">Tidak ada data ditemukan.</td></tr>';
	}else{
		while($data = $stmt->fetch_object()){
			$stmt2 = $mysqli->query("SELECT * FROM tbl_kategori_wakaf where id_kategori_wakaf=".$data->kategori_komunitas."");
			$data_kategori = $stmt2->fetch_object();
			echo'
				<tr class="">
					<td align="center">'.$data->id_komunitas.'</td>
					<td>'.$data_kategori->nama_kategori.'</td>
					<td>'.$data->nama_komunitas.'</td>
					<td>'.$data->deskripsi_komunitas.'</td>
					<td align="center">';
				if($tipe!="all"){
					echo'
						<a href="?page=daftar-komunitas&set=done-'.$data->id_komunitas.'"><button class="btn btn-success fa fa-check" title="VERIFIKASI KOMUNITAS"></button></a>						
					';
				}
				if($data->status_komunitas!="fail"){
					echo'
						<a href="?page=daftar-komunitas&set=fail-'.$data->id_komunitas.'"><button class="btn btn-warning fa fa-remove" title="TOLAK KOMUNITAS"></button></a>						
					';
				}
					echo'
						<a href="?page=daftar-komunitas&edit='.$data->id_komunitas.'"><button class="btn btn-info fa fa-edit" title="EDIT DATA"></button></a>						
						<a href="?page=daftar-komunitas&delete='.$data->id_komunitas.'"><button class="btn btn-danger fa fa-trash" title="HAPUS DATA"></button></a>						
					</td>
				</tr>
			';		
		}
	}
	
}
function komunitasSet($set_status){
	global $mysqli;
	
	$set_status = explode("-",$set_status);
	$status = str_replace("_"," ",$set_status[0]);
	$id_komunitas = $set_status[1];
	
	$stmt = $mysqli->query("UPDATE tbl_komunitas SET status_komunitas = '$status' WHERE id_komunitas = $id_komunitas");
	$data_komunitas = getDataByCollumn("tbl_komunitas","id_komunitas",$id_komunitas);
	$data_user = getDataByCollumn("tbl_user","id_user",$data_komunitas->owner_komunitas);	
	if($stmt){
		if($status=="fail"){
			kirimSMS("Maaf, komunitas wakaf anda kami tolak karena tidak sesuai syarat",$data_user->telepon);
			if($stmt){
				echo '		
					<div class="divider divider--xs"></div>
					<div class="alert alert-success" role="alert" align="center">
						Komintas sudah ditolak, notifikasi user telah dikirim.
					</div>
				';
			}else{
				echo '		
					<div class="divider divider--xs"></div>
					<div class="alert alert-danger" role="alert" align="center">
						Gagal menolak komunitas, silahkan coba lagi nanti.
					</div>
				';
			}
		}else if($status=="done"){
			kirimSMS("Selamat, dana komunitas wakaf anda sudah kami masukan ke saldo.",$data_user->telepon);
			$isi = "Selamat, komunitas wakaf anda dengan nama <b>".$data_komunitas->nama_komunitas."</b> sudah kami verifikasi, silahkan gunakan komunitas ini dengan bijak".
			kirimEmail("Komunitas Wakaf Orang Indonesia",$isi,$data_user->email);
		}
			echo '		
				<div class="divider divider--xs"></div>
				<div class="alert alert-success" role="alert" align="center">
					Status komunitas berhasil diubah, notifikasi user sudah dikirim.
				</div>
				<meta http-equiv="Refresh" content="2; URL=?page=daftar-komunitas">
			';
	}else{
		echo '		
			<div class="divider divider--xs"></div>
			<div class="alert alert-danger" role="alert" align="center">
				Status komunitas gagal diubah, silahkan coba lagi.
			</div>
		';
	}
}

function komunitasTambah(){
	global $mysqli;
	
	$nama_komunitas = $_POST['nama_komunitas'];
	$kategori_komunitas = $_POST['txtkomunitas'];
	$deskripsi_komunitas = $_POST['deskripsi_komunitas'];

	$ok_ext = array('jpg','png','jpeg'); // allow only these types of files
	$destination = "komunitas/images/";
	$file = $_FILES['file_foto'];
	$filename = explode(".", $file["name"]); 
	$file_name = $file['name']; // file original name
	$file_name_no_ext = isset($filename[0]) ? $filename[0] : null; // File name without the extension
	$file_extension = $filename[count($filename)-1];
	$file_weight = $file['size'];
	$file_type = $file['type'];
	// If there is no error
	if( $file['error'] == 0 ){
			// check if the extension is accepted
		if( in_array(strtolower($file_extension), $ok_ext)){
			// check if the size is not beyond expected size
			// rename the file
			$fileNewName = 'foto_'.str_replace(" ","",$nama_komunitas).'.'.$file_extension ;
			// and move it to the destination folder
			if( move_uploaded_file($file['tmp_name'], "../".$destination.$fileNewName) ){
				$url_foto = "images/".$fileNewName;
				$stmt = $mysqli->query("insert into tbl_komunitas(kategori_komunitas,nama_komunitas,deskripsi_komunitas,url_foto,status_komunitas) values('$kategori_komunitas','$nama_komunitas','$deskripsi_komunitas','$url_foto','done')");
				if($stmt){	
					echo '		
						<div class="divider divider--xs"></div>
						<div class="alert alert-success" role="alert" align="center">
							Komunitas <b> '.$nama_komunitas.' </b> berhasil ditambah .
						</div>
					';
				}else{
					echo '		
						<div class="divider divider--xs"></div>
						<div class="alert alert-danger" role="alert" align="center">
							Komunitas <b> '.$nama_komunitas.' </b> gagal ditambah .
						</div>
					';
				}
			}else{
				echo "can't upload file.";
			}
		}else{
			echo "File type is not supported.";
		}
	}
}
function komunitasEdit(){
	global $mysqli;
	
	$nama_komunitas = $_POST['nama_komunitas'];
	$kategori_komunitas = $_POST['txtkomunitas'];
	$deskripsi_komunitas = $_POST['deskripsi_komunitas'];
	$stmt = $mysqli->query("UPDATE tbl_komunitas SET nama_komunitas='$nama_komunitas', kategori_komunitas='$kategori_komunitas', deskripsi_komunitas='$deskripsi_komunitas' WHERE id_komunitas=".$_GET['edit']."");
	if($stmt){
		echo '		
			<div class="divider divider--xs"></div>
			<div class="alert alert-success" role="alert" align="center">
				Data Komunitas berhasil diubah .
			</div>
			<meta http-equiv="Refresh" content="1; URL=?page=daftar-komunitas">
		';
	}else{
		echo '		
			<div class="divider divider--xs"></div>
			<div class="alert alert-danger" role="alert" align="center">
				Data Komunitas gagal diubah .
			</div>
		';
	}
	
}
function komunitasDelete($id_komunitas){
	global $mysqli;
	
	$stmt = $mysqli->query("delete from tbl_komunitas where id_komunitas = $id_komunitas");
	if($stmt){
		echo '		
			<div class="divider divider--xs"></div>
			<div class="alert alert-success" role="alert" align="center">
				Data berhasil dihapus.
			</div>
		';
	}else{
		echo '		
			<div class="divider divider--xs"></div>
			<div class="alert alert-danger" role="alert" align="center">
				Data gagal dihapus, silahkan coba lagi.
			</div>
		';
	}
}

function adminInsert(){
	global $mysqli;
	$nama_lengkap = $_POST['txtNamaLengkap'];
	$jabatan = $_POST['txtJabatan'];
	$telepon = $_POST['txtTelepon'];
	$email = $_POST['txtEmail'];
	$facebook = $_POST['txtFacebook'];
	$twitter = $_POST['txtTwitter'];
	$username = $_POST['txtUsername'];
	$password = $_POST['txtPassword'];
	$tipe_admin = $_POST['tipe_admin'];

	if(cekUsername($username) == 0){
		$ok_ext = array('jpg','png','jpeg'); // allow only these types of files
		$destination = "images/user/";
		$file = $_FILES['foto_admin'];
		$filename = explode(".", $file["name"]); 
		$file_name = $file['name']; // file original name
		$file_name_no_ext = isset($filename[0]) ? $filename[0] : null; // File name without the extension
		$file_extension = $filename[count($filename)-1];
		$file_weight = $file['size'];
		$file_type = $file['type'];
		// If there is no error
		if( $file['error'] == 0 ){
			// check if the extension is accepted
			if( in_array(strtolower($file_extension), $ok_ext)){
				// check if the size is not beyond expected size
				// rename the file
				$fileNewName = 'foto_'.str_replace(" ","",$username).'.'.$file_extension ;
				// and move it to the destination folder
				if( move_uploaded_file($file['tmp_name'], "../".$destination.$fileNewName) ){
					$url_foto = "images/user/".$fileNewName;
					$stmt = $mysqli->query("INSERT into tbl_admin(username,nama_lengkap,jabatan,telepon,email,url_facebook,url_twitter,url_foto,tipe_admin) 
					VALUES('$username','$nama_lengkap','$jabatan','$telepon','$email','$facebook','$twitter','$url_foto','$tipe_admin')
					");
					$stmt2 = $mysqli->query("insert into tbl_login(username,email,password,hak_akses) values('$username','$email','$password','admin')");
					if($stmt AND $stmt2){
						echo '		
							<div class="divider divider--xs"></div>
								<div class="alert alert-success" role="alert" align="center">
									<b>Admin baru berhasil dibuat... !!</b>
								</div>
						';
					}else{
						echo '		
						<div class="divider divider--xs"></div>
							<div class="alert alert-danger" role="alert" align="center">
								<b>Admin baru gagal dibuat... !!</b>
							</div>
						';
					}
				}else{
					echo "can't upload file.";
				}
			}else{
				echo "File type is not supported.";
			}
		}
	}else{
		echo '		
			<div class="divider divider--xs"></div>
				<div class="alert alert-danger" role="alert" align="center">
				<b>Username sudah dipakai orang lain</b>
			</div>
		';
	}
}
function adminList($cari){
	global $mysqli;
	
	if($cari == "all" OR $cari == ""){
		$cari = "nama_lengkap != ''";
	}else{
		$cari = "nama_lengkap LIKE '%$cari%'";
	}
	$stmt = $mysqli->query("select * from tbl_admin where $cari GROUP BY id_admin");
	if($stmt->num_rows== 0){
		echo '<tr class=""><td colspan="8" class="center">Tidak ada data ditemukan.</td></tr>';
	}else{
		while($data = $stmt->fetch_object()){
			echo'
			<tr class="">
				<td>'.$data->id_admin.'</td>
				<td>'.$data->nama_lengkap.'</td>
				<td>'.$data->jabatan.'</td>
				<td>'.$data->telepon.'</td>
				<td>'.$data->email.'</td>
				<td>'.$data->tipe_admin.'</td>
				<td align="center">';
				if($data->tipe_admin == 'super admin'){
					echo'<a href="#"><button class="btn btn-danger fa fa-remove " disabled></button></a>';					
				}else{
					echo'<a href="?page=daftar-admin&delete='.$data->id_admin.'"><button class="btn btn-danger fa fa-remove "></button></a>';					
				}

			echo'</td>
			</tr>
				';						
		}
	}
}

function adminDelete($id_admin){
	global $mysqli;
	
	$data = getDataByCollumn("tbl_admin","id_admin",$id_admin);
	$stmt = $mysqli->query("delete from tbl_admin where id_admin = $id_admin");
	$stmt2 = $mysqli->query("delete from tbl_login where username = '".$data->username."'");
	if($stmt AND $stmt2){
		echo '		
			<div class="divider divider--xs"></div>
			<div class="alert alert-success" role="alert" align="center">
				Data berhasil dihapus.
			</div>
		';
	}else{
		echo '		
			<div class="divider divider--xs"></div>
			<div class="alert alert-danger" role="alert" align="center">
				Data gagal dihapus, silahkan coba lagi.
			</div>
		';
	}
}
function memberVerifikasi($id_user){
	global $mysqli;
	
	$data = getDataByCollumn("tbl_user_verifikasi","id_user",$id_user);
	$data_user = getDataByCollumn("tbl_user","id_user",$id_user);
	if($data_user->tipe_user=="wakif"){
		if($data->email_verifikasi==1){
			return "sudah";
		}else{
			return "belum";
		}
	}else{
		if($data->email_verifikasi==1 AND $data->url_ktp!=NULL){
			return "sudah";
		}else{
			return "belum";
		}
	}
}function memberAcc($id_user){
	global $mysqli;
	
	$data = getDataByCollumn("tbl_user_verifikasi","id_user",$id_user);
	$data_user = getDataByCollumn("tbl_user","id_user",$id_user);
	if($data->email_verifikasi==1 AND $data->url_ktp!=NULL){
		$stmt = $mysqli->query("UPDATE tbl_user_verifikasi SET status_verifikasi='sudah' WHERE id_user=$id_user");
		if($stmt){
			kirimSMS("Selamat, akun anda sudah kami verifikasi.",$data_user->telepon);
			echo '		
				<div class="divider divider--xs"></div>
				<div class="alert alert-success" role="alert" align="center">
					AKun berhasil di verifikasi.
				</div>
			';	
		}else{
			echo '		
				<div class="divider divider--xs"></div>
				<div class="alert alert-danger" role="alert" align="center">
					Gagal mengubah status member..
				</div>
			';
		}		
	}else{
		echo '		
			<div class="divider divider--xs"></div>
			<div class="alert alert-warning" role="alert" align="center">
				Member tersebut belum melakukan aktivasi akun email..
			</div>
		';
	}
}
function memberList($cari){
	global $mysqli;
	
	if($cari == "all" OR $cari == ""){
		$cari = "nama_lengkap != ''";
	}else{
		$cari = "nama_lengkap LIKE '%$cari%'";
	}
	if(isset($_SESSION['tipe'])){
		$tipe = "tipe_user='".$_SESSION['tipe']."'";
	}else{
		$tipe = "tipe_user!='nol'";
	}
	$stmt = $mysqli->query("select * from tbl_user where id_user != 0 AND $tipe AND $cari GROUP BY id_user DESC");
	if($stmt->num_rows== 0){
		echo '<tr class=""><td colspan="8" class="center">Tidak ada data ditemukan.</td></tr>';
	}else{
		while($data = $stmt->fetch_object()){
			if($data->tipe_user=='ae' OR $data->tipe_user=='ar'){			
				$data_verifikasi = getDataByCollumn("tbl_user_verifikasi","id_user",$data->id_user);
				$ktp ="../".$data_verifikasi->url_ktp;
				$verifikasi="../".$data_verifikasi->foto_verifikasi;
				$foto="../".$data->url_foto;
				if($ktp == "../"){
					$ktp="#";
				}
				if($verifikasi == "../"){
					$verifikasi="#";
				}
				if($foto == "../"){
					$foto="#";
				}
				echo'
				<tr class="">
					<td>'.$data->nama_lengkap.'</td>
					<td>'.$data->alamat.'</td>
					<td>'.$data->telepon.' / '.$data->email.'</td>
					<td align="right">Rp'.setHarga($data->saldo_dompet).'</td>
					<td><a href="'.$ktp.'" target="_blank">LIHAT</a></td>
					<td><a href="'.$verifikasi.'" target="_blank">LIHAT</a></td>
					<td><a href="'.$foto.'" target="_blank">LIHAT</a></td>
					<td align="center">
				';
					if($data_verifikasi->status_verifikasi == "belum"){
						echo'
							<a href="?page=daftar-member&acc='.$data->id_user.'"><button class="btn btn-success fa fa-check" title="Verifikasi Member"></button></a>
						';
					}
				echo'	<a href="?page=daftar-member&delete='.$data->id_user.'"><button class="btn btn-danger fa fa-remove  title="Hapus Member""></button></a>						
					</td>
				</tr>
				';						
			}else{
				echo'
				<tr class="">
					<td align="center">'.$data->id_user.'</td>
					<td>'.$data->nama_lengkap.'</td>
					<td>'.$data->alamat.'</td>
					<td>'.$data->telepon.' / '.$data->email.'</td>
					<td align="right">Rp'.setHarga($data->saldo_dompet).'</td>
					<td>'.memberVerifikasi($data->id_user).'</td>
					<td align="center">
						<a href="?page=daftar-member&delete='.$data->id_user.'"><button class="btn btn-danger fa fa-remove "></button></a>						
					</td>
				</tr>
				';						
			}
		}
	}
}

function memberDelete($id_user){
	global $mysqli;
	
	$data = getDataByCollumn("tbl_user","id_user",$id_user);
	$data_verifikasi = getDataByCollumn("tbl_user_verifikasi","id_user",$id_user);
	$stmt = $mysqli->query("delete from tbl_user where id_user = $id_user");
	if($data->url_foto != ''){
		unlink($data->url_foto);
	}
	if($data_verifikasi->url_ktp != ''){
		unlink($data_verifikasi->url_ktp);
	}
	if($data_verifikasi->foto_verifikasi != ''){
		unlink($data_verifikasi->foto_verifikasi);
	}
	if($stmt){
		echo '		
			<div class="divider divider--xs"></div>
			<div class="alert alert-success" role="alert" align="center">
				Data berhasil dihapus.
			</div>
		';
	}else{
		echo '		
			<div class="divider divider--xs"></div>
			<div class="alert alert-danger" role="alert" align="center">
				Data gagal dihapus, silahkan coba lagi.
			</div>
		';
	}
}
function mutasiSaldo($cari){
	global $mysqli;
	
	if($cari == "all" OR $cari == ""){
		$cari = "tbl_user.nama_lengkap != ''";
	}else{
		$cari = "tbl_user.nama_lengkap LIKE '%$cari%'";
	}
	$stmt = $mysqli->query("select * from tbl_dompet_mutasi,tbl_user where tbl_dompet_mutasi.id_user = tbl_user.id_user AND $cari");
	if($stmt->num_rows== 0){
		echo '<tr class=""><td colspan="9" class="center">Tidak ada data ditemukan.</td></tr>';
	}else{
		while($data = $stmt->fetch_object()){
			$data_user = getDataByCollumn("tbl_user","id_user",$data->id_user);
			echo'
				<tr class="">
					<td>'.$data->id_mutasi.'</td>
					<td>'.$data_user->nama_lengkap.'</td>
					<td align="right">Rp'.setHarga($data->jumlah_mutasi).'</td>
					<td>'.$data->deskripsi_mutasi.'</td>
					<td>'.$data->tanggal_mutasi.'</td>
					<td>'.$data->status_mutasi.'</td>
				</tr>
			';		
		}
	}
}

function mutasiSaldoDelete(){
	global $mysqli;
	
	$stmt = $mysqli->query("TRUNCATE tbl_dompet_mutasi");
	if($stmt){
		echo '		
			<div class="divider divider--xs"></div>
			<div class="alert alert-success" role="alert" align="center">
				Data Riwayat Mutasi Saldo berhasil di kosongkan.
			</div>
		';
	}else{
		echo '		
			<div class="divider divider--xs"></div>
			<div class="alert alert-danger" role="alert" align="center">
				Data gagal dihapus, silahkan coba lagi.
			</div>
		';
	}
}


function topupList($status_p,$cari){
	global $mysqli;
	
	$status = '';	
	if($status_p == "all" OR $status_p == ""){
		$status = "(tbl_dompet_topup.status_topup != '')";
	}else if($status_p == "pending" OR $status_p == "proses" OR $status_p == "done" OR $status_p == "fail"){
		$status = "(tbl_dompet_topup.status_topup = '$status_p')";
	}
	if($cari == "all" OR $cari == ""){
		$cari = "(tbl_user.nama_lengkap != '')";
	}else{
		$cari = "(tbl_user.nama_lengkap LIKE '%$cari%')";
	}
	$stmt = $mysqli->query("select * from tbl_dompet_topup,tbl_user where tbl_dompet_topup.id_user = tbl_user.id_user AND $cari AND $status");
	if($stmt->num_rows== 0){
		echo '<tr class=""><td colspan="8" class="center">Tidak ada data ditemukan.</td></tr>';
	}else{
		while($data = $stmt->fetch_object()){
			$data_user = getDataByCollumn("tbl_user","id_user",$data->id_user);
			echo'
					<tr class="">
					<td>'.$data->id_topup.'</td>
					<td>'.$data_user->nama_lengkap.'</td>
					<td align="right">Rp'.setHarga($data->jumlah_topup).'</td>
					<td>'.$data->kode_topup.'</td>
					<td>'.$data->tanggal_topup.'</td>
					<td align="center">
			';
				if($status_p == "done" OR $status_p == "fail"){
					echo '
						<a href="?page=topup&set=pending-'.$data->id_topup.'"><button class="btn btn-default btn-sm fa fa-refresh" title="SET PENDING"></button></a>
					';
				}
				if($status_p == "pending"){
					echo '
						<a href="?page=topup&set=done-'.$data->id_topup.'"><button class="btn btn-success btn-sm fa fa-check" title="SET FAIL"></button></a>
					';
				}
				if($status_p != "fail"){
					echo '
						<a href="?page=topup&set=fail-'.$data->id_topup.'"><button class="btn btn-warning btn-sm fa fa-remove" title="SET FAIL"></button></a>
					';
				}
			echo'		
						<a href="?page=topup&delete='.$data->id_topup.'"><button class="btn btn-danger btn-sm fa fa-trash" title="DELETE DATA"></button></a>
					</td>
				</tr>
			';		
		}
	}
}
function topupSet($set_status){
	global $mysqli;
	
	$set_status = explode("-",$set_status);
	$status = str_replace("_"," ",$set_status[0]);
	$id_topup = $set_status[1];
	
	$stmt = $mysqli->query("UPDATE tbl_dompet_topup SET status_topup = '$status' WHERE id_topup = $id_topup");
	if($stmt){
			$data_topup = getDataByCollumn("tbl_dompet_topup","id_topup",$id_topup);
			$data_user = getDataByCollumn("tbl_user","id_user",$data_topup->id_user);
		if($status=="fail"){
			kirimSMS("Maaf, topup saldo di woi.or.id gagal.",$data_user->telepon);
			$stmt2 = $mysqli->query("UPDATE tbl_dompet_mutasi SET status_mutasi='fail' where id_user=".$data_topup->id_user." AND jumlah_mutasi='".$data_topup->jumlah_topup."' ");
			if($stmt2){
				echo '		
					<div class="divider divider--xs"></div>
					<div class="alert alert-success" role="alert" align="center">
						Update data mutasi berhasil.
					</div>
				';
			}else{
				echo '		
					<div class="divider divider--xs"></div>
					<div class="alert alert-danger" role="alert" align="center">
						Update data mutasi gagal.
					</div>
				';
			}
		}else if($status=="pending"){
			kirimSMS("Permintaan topup saldo di woi.or.id sedang di proses",$data_user->telepon);
			$stmt2 = $mysqli->query("UPDATE tbl_dompet_mutasi SET status_mutasi='pending' where id_user=".$data_topup->id_user." AND jumlah_mutasi='".$data_topup->jumlah_topup."' ");
			if($stmt2){
				echo '		
					<div class="divider divider--xs"></div>
					<div class="alert alert-success" role="alert" align="center">
						Berhasil mencatat mutasi.
					</div>
				';
			}else{
				echo '		
					<div class="divider divider--xs"></div>
					<div class="alert alert-danger" role="alert" align="center">
						Gagal mencatat mutasi.
					</div>
				';
			}
		}else if($status=="done"){
			kirimSMS("Selamat, topup saldo di woi.or.id berhasil, saldo sudah ditambahkan",$data_user->telepon);
			$stmt = $mysqli->query("UPDATE tbl_dompet_mutasi SET status_mutasi='done' where id_user=".$data_topup->id_user." AND jumlah_mutasi='".$data_topup->jumlah_topup."' ");
			$stmt3 = $mysqli->query("UPDATE tbl_user SET saldo_dompet=(saldo_dompet+".$data_topup->jumlah_topup.") WHERE id_user='".$data_topup->id_user."'");
			if($stmt AND $stmt3){
				echo '		
					<div class="divider divider--xs"></div>
					<div class="alert alert-success" role="alert" align="center">
						Berhasil mencatat mutasi.
					</div>
				';
			}else{
				echo '		
					<div class="divider divider--xs"></div>
					<div class="alert alert-danger" role="alert" align="center">
						Gagal mencatat mutasi.
					</div>
				';
			}
//			$data_email = getDataByCollumn("tbl_customer","id_customer",$data_peminjaman->id_customer);
//			kirimEmail("member",$data_pesan,$data_email->email);
		}
			echo '		
				<div class="divider divider--xs"></div>
				<div class="alert alert-success" role="alert" align="center">
					Status topup berhasil diubah.
				</div>
			';
	}else{
		echo '		
			<div class="divider divider--xs"></div>
			<div class="alert alert-danger" role="alert" align="center">
				Status topup gagal diubah, silahkan coba lagi.
			</div>
		';
	}
	echo'
		<meta http-equiv="Refresh" content="2; URL=?page=mutasi-saldo">
	';
}

function topupDelete($id_topup){
	global $mysqli;
	
	$stmt = $mysqli->query("delete from tbl_dompet_topup where id_topup = $id_topup");
	if($stmt){
		echo '		
			<div class="divider divider--xs"></div>
			<div class="alert alert-success" role="alert" align="center">
				Data berhasil dihapus.
			</div>
		';
	}else{
		echo '		
			<div class="divider divider--xs"></div>
			<div class="alert alert-danger" role="alert" align="center">
				Data gagal dihapus, silahkan coba lagi.
			</div>
		';
	}
}

function topupDeleteAll($status_topup){
	global $mysqli;
	
	$stmt = $mysqli->query("delete from tbl_dompet_topup where status_topup = '$status_topup'");
	if($stmt){
		echo '		
			<div class="divider divider--xs"></div>
			<div class="alert alert-success" role="alert" align="center">
				Data berhasil dikosongkan.
			</div>
			<meta http-equiv="Refresh" content="2; URL=?page=mutasi-saldo">
		';
	}else{
		echo '		
			<div class="divider divider--xs"></div>
			<div class="alert alert-danger" role="alert" align="center">
				Data gagal dikosongkan, silahkan coba lagi.
			</div>
		';
	}
}

function pencairanList($status_p,$cari){
	global $mysqli;
	
	$status = '';	
	if($status_p == "all" OR $status_p == ""){
		$status = "(tbl_dompet_pencairan.status_pencairan != '')";
	}else if($status_p == "pending" OR $status_p == "proses" OR $status_p == "done" OR $status_p == "fail"){
		$status = "(tbl_dompet_pencairan.status_pencairan = '$status_p')";
	}
	if($cari == "all" OR $cari == ""){
		$cari = "(tbl_user.nama_lengkap != '')";
	}else{
		$cari = "(tbl_user.nama_lengkap LIKE '%$cari%')";
	}
	$stmt = $mysqli->query("select * from tbl_dompet_pencairan,tbl_user where tbl_dompet_pencairan.id_user = tbl_user.id_user AND $cari AND $status");
	if($stmt->num_rows== 0){
		echo '<tr class=""><td colspan="8" class="center">Tidak ada data ditemukan.</td></tr>';
	}else{
		while($data = $stmt->fetch_object()){
			$data_user = getDataByCollumn("tbl_user","id_user",$data->id_user);
			echo'
					<tr class="">
					<td>'.$data->id_pencairan.'</td>
					<td>'.$data_user->nama_lengkap.'</td>
					<td align="right">Rp'.setHarga($data->jumlah_pencairan).'</td>
					<td>'.$data->bank_tujuan.' / '.$data->bank_cabang.'</td>
					<td>'.$data->bank_pemilik.' / '.$data->bank_rekening.'</td>
					<td>'.$data->tanggal_pencairan.'</td>
					<td align="center">
			';
				if($status_p == "proses"){
					echo '
						<a href="?page=pencairan&set=done-'.$data->id_pencairan.'"><button class="btn btn-primary btn-sm fa fa-check" title="SET DONE"></button></a>
					';
				}
				if($status_p == "done" OR $status_p == "fail" OR $status_p == "pending" ){
					echo '
						<a href="?page=pencairan&set=proses-'.$data->id_pencairan.'"><button class="btn btn-info btn-sm fa fa-refresh" title="SET PROSES"></button></a>
					';
				}
				if($status_p != "fail"){
					echo '
						<a href="?page=pencairan&set=fail-'.$data->id_pencairan.'"><button class="btn btn-warning btn-sm fa fa-remove" title="SET FAIL"></button></a>
					';
				}
			echo'		
						<a href="?page=pencairan&delete='.$data->id_pencairan.'"><button class="btn btn-danger btn-sm fa fa-trash" title="DELETE DATA"></button></a>
					</td>
				</tr>
			';		
		}
	}
}
function pencairanSet($set_status){
	global $mysqli;
	
	$set_status = explode("-",$set_status);
	$status = str_replace("_"," ",$set_status[0]);
	$id_pencairan = $set_status[1];
	
	$stmt = $mysqli->query("UPDATE tbl_dompet_pencairan SET status_pencairan = '$status' WHERE id_pencairan = $id_pencairan");
	if($stmt){
			$data_pencairan = getDataByCollumn("tbl_dompet_pencairan","id_pencairan",$id_pencairan);
			$data_user = getDataByCollumn("tbl_user","id_user",$data_pencairan->id_user);
		if($status=="fail"){
			kirimSMS("Maaf, pencairan saldo di woi.or.id gagal, saldo sudah dikembalikan",$data_user->telepon);
			$stmt = $mysqli->query("UPDATE tbl_user SET saldo_dompet=(saldo_dompet+".$data_pencairan->jumlah_pencairan.") WHERE id_user='".$data_pencairan->id_user."'");
			$stmt2 = $mysqli->query("UPDATE tbl_dompet_mutasi SET status_mutasi='fail' where id_user=".$data_pencairan->id_user." AND jumlah_mutasi='".$data_pencairan->jumlah_pencairan."' ");
			$stmt3 = $mysqli->query("UPDATE tbl_dompet_pencairan SET status_pencairan='fail' where id_user=".$data_pencairan->id_user." AND jumlah_pencairan='".$data_pencairan->jumlah_pencairan."' ");
			if($stmt AND $stmt2 AND $stmt3){
				echo '		
					<div class="divider divider--xs"></div>
					<div class="alert alert-success" role="alert" align="center">
						Saldo berhasil dikembalikan.
					</div>
				';
			}else{
				echo '		
					<div class="divider divider--xs"></div>
					<div class="alert alert-danger" role="alert" align="center">
						Saldo gagal dikembalikan.
					</div>
				';
			}
		}else if($status=="proses"){
			kirimSMS("Permintaan pencairan saldo di woi.or.id sedang di proses",$data_user->telepon);
			$stmt1 = $mysqli->query("UPDATE tbl_dompet_pencairan SET status_pencairan='proses' where id_user=".$data_pencairan->id_user." AND jumlah_pencairan='".$data_pencairan->jumlah_pencairan."' ");
			$stmt2 = $mysqli->query("UPDATE tbl_dompet_mutasi SET status_mutasi='proses' where id_user=".$data_pencairan->id_user." AND jumlah_mutasi='".$data_pencairan->jumlah_pencairan."' ");
			if($stmt1 AND $stmt2){
				echo '		
					<div class="divider divider--xs"></div>
					<div class="alert alert-success" role="alert" align="center">
						Berhasil mencatat mutasi.
					</div>
				';
			}else{
				echo '		
					<div class="divider divider--xs"></div>
					<div class="alert alert-danger" role="alert" align="center">
						Gagal mencatat mutasi.
					</div>
				';
			}
		}else if($status=="done"){
			kirimSMS("Selamat, pencairan saldo di woi.or.id berhasil",$data_user->telepon);
			$stmt = $mysqli->query("UPDATE tbl_dompet_mutasi SET status_mutasi='done' where id_user=".$data_pencairan->id_user." AND jumlah_mutasi='".$data_pencairan->jumlah_pencairan."' ");
			$stmt2 = $mysqli->query("UPDATE tbl_dompet_pencairan SET status_pencairan='done' where id_user=".$data_pencairan->id_user." AND jumlah_pencairan='".$data_pencairan->jumlah_pencairan."' ");
			if($stmt AND $stmt2){
				echo '		
					<div class="divider divider--xs"></div>
					<div class="alert alert-success" role="alert" align="center">
						Berhasil mencatat mutasi.
					</div>
				';
			}else{
				echo '		
					<div class="divider divider--xs"></div>
					<div class="alert alert-danger" role="alert" align="center">
						Gagal mencatat mutasi.
					</div>
				';
			}
//			$data_email = getDataByCollumn("tbl_customer","id_customer",$data_peminjaman->id_customer);
//			kirimEmail("member",$data_pesan,$data_email->email);
		}
			echo '		
				<div class="divider divider--xs"></div>
				<div class="alert alert-success" role="alert" align="center">
					Status pencairan berhasil diubah.
				</div>
			';
	}else{
		echo '		
			<div class="divider divider--xs"></div>
			<div class="alert alert-danger" role="alert" align="center">
				Status pencairan gagal diubah, silahkan coba lagi.
			</div>
		';
	}
	echo'
		<meta http-equiv="Refresh" content="2; URL=?page=mutasi-saldo">
	';
}

function pencairanDelete($id_pencairan){
	global $mysqli;
	
	$stmt = $mysqli->query("delete from tbl_dompet_pencairan where id_pencairan = $id_pencairan");
	if($stmt){
		echo '		
			<div class="divider divider--xs"></div>
			<div class="alert alert-success" role="alert" align="center">
				Data berhasil dihapus.
			</div>
		';
	}else{
		echo '		
			<div class="divider divider--xs"></div>
			<div class="alert alert-danger" role="alert" align="center">
				Data gagal dihapus, silahkan coba lagi.
			</div>
		';
	}
}

function pencairanDeleteAll($status_pencairan){
	global $mysqli;
	
	$stmt = $mysqli->query("delete from tbl_dompet_pencairan where status_pencairan = '$status_pencairan'");
	if($stmt){
		echo '		
			<div class="divider divider--xs"></div>
			<div class="alert alert-success" role="alert" align="center">
				Data berhasil dikosongkan.
			</div>
			<meta http-equiv="Refresh" content="2; URL=?page=mutasi-saldo">
		';
	}else{
		echo '		
			<div class="divider divider--xs"></div>
			<div class="alert alert-danger" role="alert" align="center">
				Data gagal dikosongkan, silahkan coba lagi.
			</div>
		';
	}
}

function proyekWakafBaru(){
	global $mysqli;
	
	$id_user = 0;
	$kategori_wakaf = explode("|",$_POST['txtKategoriProyek']);
	$id_kategori_wakaf = $kategori_wakaf[0];
	$tag_kategori_wakaf = str_replace("'","",$kategori_wakaf[1]);
	$nama_proyek = str_replace("'","",$_POST['txtNamaProyek']);
	$headline_proyek = str_replace("'","",$_POST['txtHeadlineProyek']);
	$deskripsi_proyek = str_replace("'","",$_POST['txtDeskripsiProyek']);
	$url_video = $_POST['txtVideo'];
	$target_dana = explode("Rp",str_replace(".","",$_POST['txtTargetProyek']));
	if(count($target_dana)>1){
		$target_dana = $target_dana[1];
	}else{
		$target_dana = $target_dana[0];
	}
	if($_POST['txtBerakhirProyek'] != ''){
		$tanggal_akhir = $_POST['txtBerakhirProyek'];
	}else{
		$tanggal_akhir = "2099-12-12";
	}
	
	$ok_ext = array('jpg','png','jpeg'); // allow only these types of files
	$destination = "foto_post/";
	$file = $_FILES['foto_post'];
	$filename = explode(".", $file["name"]); 
	$file_name = $file['name']; // file original name
	$file_name_no_ext = isset($filename[0]) ? $filename[0] : null; // File name without the extension
	$file_extension = $filename[count($filename)-1];
	$file_weight = $file['size'];
	$file_type = $file['type'];
	// If there is no error
	if( $file['error'] == 0 ){
		// check if the extension is accepted
		if( in_array(strtolower($file_extension), $ok_ext)){
			// check if the size is not beyond expected size
			// rename the file
			$fileNewName = 'proyek_'.str_replace(" ","",$nama_proyek).'.'.$file_extension ;
			// and move it to the destination folder
			if( move_uploaded_file($file['tmp_name'], "../".$destination.$fileNewName) ){
				$url_foto = "foto_post/".$fileNewName;
				$stmt = $mysqli->query("INSERT INTO tbl_wakaf_proyek(id_kategori_wakaf,id_user,nama_proyek,headline_proyek,deskripsi_proyek,url_video,target_dana,tanggal_akhir,url_foto,status_proyek)
				VALUES($id_kategori_wakaf,$id_user,'$nama_proyek','$headline_proyek','$deskripsi_proyek','$url_video','$target_dana','$tanggal_akhir','$url_foto','proses')
				");
				if($stmt){
						$stmt = $mysqli->query("SELECT * FROM tbl_wakaf_proyek WHERE id_user=".$id_user." AND nama_proyek='".$nama_proyek."'"	);
						$data_proyek = $stmt->fetch_object();
						$stmt = $mysqli->query("insert into tbl_wakaf_verifikasi(id_wakaf_proyek,status_verifikasi) VALUES(".$data_proyek->id_wakaf_proyek.",'done')");
							echo '		
							<div class="divider divider--xs"></div>
								<div class="alert alert-success" role="alert" align="center">
									<b>Proyek Wakaf baru berhasil dibuat... !!</b>
								</div>
							';
						$sql = "INSERT INTO tbl_post(id_user,pemateri,judul_post,isi_post,tag_post,status_post,url_foto,url_video,tipe_post)
								VALUES('$id_user','Admin','$nama_proyek','$deskripsi_proyek','$tag_kategori_wakaf','done','$url_foto','$url_video','wakaf')";
						$stmt = $mysqli->query($sql);
						if($stmt){
							echo '		
							<div class="divider divider--xs"></div>
								<div class="alert alert-success" role="alert" align="center">
									<b>Berita Proyek Wakaf baru berhasil dibuat... !!</b>
								</div>
							';
							
						}else{
							echo '		
							<div class="divider divider--xs"></div>
								<div class="alert alert-danger" role="alert" align="center">
									<b>Berita Proyek Wakaf baru gagal dibuat... !!</b>
								</div>
							';
						}
				}else{
					echo '		
					<div class="divider divider--xs"></div>
						<div class="alert alert-danger" role="alert" align="center">
							<b>Proyek Wakaf baru gagal dibuat... !!</b>
						</div>
					';
				}
			}else{
				echo "can't upload file.";
			}
		}else{
			echo "File type is not supported.";
		}
	}
}
function proyekEdit(){
	global $mysqli;
	
	$id_proyek = $_GET['edit'];
	$nama_proyek_last = str_replace("'","",$_POST['txtNamaProyekLast']);
	$deskripsi_proyek_last = str_replace("'","",$_POST['txtDeskripsiProyekLast']);

	$id_user = 0;
	$kategori_wakaf = explode("|",$_POST['txtKategoriProyek']);
	$id_kategori_wakaf = $kategori_wakaf[0];
	$tag_kategori_wakaf = str_replace("'","",$kategori_wakaf[1]);
	$nama_proyek = str_replace("'","",$_POST['txtNamaProyek']);
	$url_foto = str_replace("'","",$_POST['url_foto']);
	$url_video = str_replace("'","",$_POST['txtVideo']);
	$headline_proyek = str_replace("'","",$_POST['txtHeadlineProyek']);
	$deskripsi_proyek = str_replace("'","",$_POST['txtDeskripsiProyek']);
	$target_dana = explode("Rp",str_replace(".","",$_POST['txtTargetProyek']));
	if(count($target_dana)>1){
		$target_dana = $target_dana[1];
	}else{
		$target_dana = $target_dana[0];
	}
	if($_POST['txtBerakhirProyek'] != ''){
		$tanggal_akhir = $_POST['txtBerakhirProyek'];
	}else{
		$tanggal_akhir = "2099-12-12";
	}
	
	$stmt = $mysqli->query("UPDATE tbl_wakaf_proyek SET
			id_kategori_wakaf=".$id_kategori_wakaf.",
			nama_proyek='".$nama_proyek."',
			headline_proyek='".$headline_proyek."',
			deskripsi_proyek='".$deskripsi_proyek."',
			url_video='".$url_video."',
			target_dana='".$target_dana."',
			tanggal_akhir='".$tanggal_akhir."'
			WHERE id_wakaf_proyek = ".$id_proyek."
			");	
	if($stmt){
		$sql = "delete from tbl_post where judul_post='$nama_proyek_last'";
		$stmt2 = $mysqli->query($sql);				
		if($stmt2){
			$sql = "INSERT INTO tbl_post(id_user,pemateri,judul_post,isi_post,tag_post,status_post,url_foto,url_video,tipe_post)
							VALUES('$id_user','Admin','$nama_proyek','$deskripsi_proyek','$tag_kategori_wakaf','done','$url_foto','$url_video','wakaf')";
			$stmt2 = $mysqli->query($sql);				
			if($stmt2){
				echo '		
				<div class="divider divider--xs"></div>
					<div class="alert alert-success" role="alert" align="center">
						<b>Berita & Data Proyek Wakaf berhasil diubah... !!</b><br>MUAT ULANG HALAMAN UNTUK MELIHAT
					</div>
				';
				
			}else{
				echo '		
				<div class="divider divider--xs"></div>
					<div class="alert alert-danger" role="alert" align="center">
						<b>Berita Proyek Wakaf gagal diubah... !!</b>
					</div>
				';
			}	
		}else{
			echo '		
			<div class="divider divider--xs"></div>
				<div class="alert alert-danger" role="alert" align="center">
					<b>Berita Proyek Wakaf gagal diubah... !!</b>
				</div>
			';
		}	
	}else{
		echo '		
		<div class="divider divider--xs"></div>
			<div class="alert alert-danger" role="alert" align="center">
				<b>Data Proyek Wakaf gagal diubah... !!</b>
			</div>
		';
	}		
}
function proyekList($status_p,$cari){
	global $mysqli;
	
	$status = '';
	if($status_p == "all" OR $status_p == ""){
		$status = "(tbl_wakaf_proyek.status_proyek != '')";
	}else if($status_p == "pending" OR $status_p == "proses" OR $status_p == "done" OR $status_p == "fail"){
		$status = "(tbl_wakaf_proyek.status_proyek = '$status_p')";
	}
	if($cari == "all" OR $cari == ""){
		$cari = "(tbl_user.nama_lengkap != '')";
	}else{
		$cari = "(tbl_user.nama_lengkap LIKE '%$cari%')";
	}
	$stmt = $mysqli->query("select * from tbl_wakaf_proyek,tbl_user where tbl_wakaf_proyek.id_user = tbl_user.id_user AND $cari AND $status");
	if($stmt->num_rows== 0){
		echo '<tr class=""><td colspan="8" class="center">Tidak ada data ditemukan.</td></tr>';
	}else{
		while($data = $stmt->fetch_object()){
			$data_user = getDataByCollumn("tbl_user","id_user",$data->id_user);
			$stmt2 = $mysqli->query("select sum(tbl_wakaf_donasi.jumlah_wakaf) as terkumpul from tbl_wakaf_donasi,tbl_wakaf_donasi_status WHERE
			tbl_wakaf_donasi.id_wakaf_proyek = ".$data->id_wakaf_proyek." AND tbl_wakaf_donasi.id_wakaf_donasi = tbl_wakaf_donasi_status.id_wakaf_donasi AND tbl_wakaf_donasi_status.status_wakaf='done'");
			$data_donasi = $stmt2->fetch_object();
			if($data->favorit == 1){
				$nama_proyek_r = '<span class="fa fa-star"></span>'.$data->nama_proyek;
			}else{
				$nama_proyek_r = $data->nama_proyek;
			}
			echo'
					<tr class="">
					<td>'.$data->id_wakaf_proyek.'</td>
					<td>'.$nama_proyek_r.'</td>
					<td>'.$data_user->nama_lengkap.'</td>
					<td align="right">Rp'.setHarga($data->target_dana).'</td>
					<td align="right">Rp'.setHarga($data_donasi->terkumpul).'</td>
					<td>'.$data->tanggal_pembuatan.'</td>
					<td>'.$data->tanggal_akhir.'</td>
					<td align="center" width="150px">
			';
				if($status_p == "proses"){
					echo '
						<a href="?page=proyek&set=done-'.$data->id_wakaf_proyek.'"><button class="btn btn-primary btn-sm fa fa-check" title="SET DONE"></button></a>
						<a href="?page=proyek-baru&edit='.$data->id_wakaf_proyek.'"><button class="btn btn-default btn-sm fa fa-edit" title="EDIT PROYEK"></button></a>
						<a href="?page=proyek&sub=proses&favorit='.$data->id_wakaf_proyek.'"><button class="btn btn-warning btn-sm fa fa-star" title="JADIKAN/TIDAK JADIKAN FAVORIT"></button></a>
					';
				}
				if($status_p == "done" OR $status_p == "fail" OR $status_p == "pending" ){
					echo '
						<a href="?page=proyek&set=proses-'.$data->id_wakaf_proyek.'"><button class="btn btn-info btn-sm fa fa-refresh" title="SET PROSES"></button></a>
					';
				}
			echo'		
						<a href="?page=proyek&set=fail-'.$data->id_wakaf_proyek.'"><button class="btn btn-warning btn-sm fa fa-remove" title="SET FAIL"></button></a>
						<a href="?page=proyek&delete='.$data->id_wakaf_proyek.'"><button class="btn btn-danger btn-sm fa fa-trash" title="DELETE DATA"></button></a>
					</td>
				</tr>
			';		
		}
	}
}
function proyekSet($set_status){
	global $mysqli;
	
	$set_status = explode("-",$set_status);
	$status = str_replace("_"," ",$set_status[0]);
	$id_wakaf_proyek = $set_status[1];
	
	$stmt = $mysqli->query("UPDATE tbl_wakaf_proyek SET status_proyek = '$status' WHERE id_wakaf_proyek = $id_wakaf_proyek");
	$data_proyek = getDataByCollumn("tbl_wakaf_proyek","id_wakaf_proyek",$id_wakaf_proyek);
	$data_user = getDataByCollumn("tbl_user","id_user",$data_proyek->id_user);
	
	if($stmt){
//			$data_user = getDataByCollumn("tbl_user","id_user",$data_pencairan->id_user);
		if($status=="fail"){
			kirimSMS("Maaf, proyek wakaf anda kami tolak karena tidak sesuai syarat",$data_user->telepon);
			$stmt = $mysqli->query("update tbl_post set status_post='fail' where judul_post='".$data_proyek->nama_proyek."'");
			if($stmt){
				echo '		
					<div class="divider divider--xs"></div>
					<div class="alert alert-success" role="alert" align="center">
						Berita proyek wakaf sudah di tolak.
					</div>
				';
			}else{
				echo '		
					<div class="divider divider--xs"></div>
					<div class="alert alert-danger" role="alert" align="center">
						Post Proyek Wakaf gagal diubah, silahkan ubah manual di menu "Blog & Tausyah".
					</div>
				';
			}
		}else if($status=="proses"){
			kirimSMS("Selamat, proyek wakaf anda sudah kami konfirmasi, proyek anda sudah kami publish.",$data_user->telepon);
			$stmt = $mysqli->query("update tbl_post set status_post='done' where judul_post='".$data_proyek->nama_proyek."'");
			if($stmt){
				echo '		
					<div class="divider divider--xs"></div>
					<div class="alert alert-success" role="alert" align="center">
						Berita proyek wakaf sudah di publish.
					</div>
				';
			}else{
				echo '		
					<div class="divider divider--xs"></div>
					<div class="alert alert-danger" role="alert" align="center">
						Berita proyek wakaf gagal di publish.
					</div>
				';
			}
		}else if($status=="done"){
			kirimSMS("Selamat, dana proyek wakaf anda sudah kami masukan ke saldo.",$data_user->telepon);
//			$data_email = getDataByCollumn("tbl_customer","id_customer",$data_peminjaman->id_customer);
//			kirimEmail("member",$data_pesan,$data_email->email);
		}
			echo '		
				<div class="divider divider--xs"></div>
				<div class="alert alert-success" role="alert" align="center">
					Status proyek wakaf berhasil diubah.
				</div>
				<meta http-equiv="Refresh" content="2; URL=?page=proyek&sub='.$set_status[0].'">
			';
	}else{
		echo '		
			<div class="divider divider--xs"></div>
			<div class="alert alert-danger" role="alert" align="center">
				Status proyek gagal diubah, silahkan coba lagi.
			</div>
		';
	}
}

function proyekDelete($id_wakaf_proyek){
	global $mysqli;
	
	$stmt = $mysqli->query("select * from tbl_wakaf_proyek where id_wakaf_proyek = $id_wakaf_proyek");
	$data = $stmt->fetch_object();	
	$stmt = $mysqli->query("delete from tbl_wakaf_proyek where id_wakaf_proyek = $id_wakaf_proyek");
	$stmt2 = $mysqli->query("delete from tbl_post where id_user = ".$data->id_user." AND judul_post='".$data->nama_proyek."'");
	if($stmt AND $stmt2){
		unlink("../".$data->url_foto);
		echo '		
			<div class="divider divider--xs"></div>
			<div class="alert alert-success" role="alert" align="center">
				Data berhasil dihapus.
			</div>
		';
	}else{
		echo '		
			<div class="divider divider--xs"></div>
			<div class="alert alert-danger" role="alert" align="center">
				Data gagal dihapus, silahkan coba lagi.
			</div>
		';
	}
}

function proyekDeleteAll($status_proyek){
	global $mysqli;
	
	$stmt = $mysqli->query("delete from tbl_wakaf_proyek where status_proyek = '$status_proyek'");
	if($stmt){
		echo '		
			<div class="divider divider--xs"></div>
			<div class="alert alert-success" role="alert" align="center">
				Data berhasil dikosongkan.
			</div>
			<meta http-equiv="Refresh" content="2; URL=?page=proyek&sub=pending">
		';
	}else{
		echo '		
			<div class="divider divider--xs"></div>
			<div class="alert alert-danger" role="alert" align="center">
				Data gagal dikosongkan, silahkan coba lagi.
			</div>
		';
	}
}

function donasiList($status_p,$cari){
	global $mysqli;
	
	$status = '';	
	if($status_p == "all" OR $status_p == ""){
		$status = "(tbl_wakaf_donasi_status.status_wakaf != '')";
	}else if($status_p == "pending" OR $status_p == "proses" OR $status_p == "done" OR $status_p == "fail"){
		$status = "(tbl_wakaf_donasi_status.status_wakaf = '$status_p')";
	}
	if($cari == "all" OR $cari == ""){
		$cari = "(tbl_wakaf_proyek.nama_proyek != '')";
	}else{
		$cari = "(tbl_wakaf_proyek.nama_proyek LIKE '%$cari%')";
	}
	$sql = "select * from tbl_wakaf_proyek,tbl_wakaf_donasi,tbl_wakaf_donasi_status,tbl_user 
			where tbl_wakaf_donasi.id_user = tbl_user.id_user AND tbl_wakaf_proyek.id_wakaf_proyek = tbl_wakaf_donasi.id_wakaf_proyek 
					AND tbl_wakaf_donasi.id_wakaf_donasi = tbl_wakaf_donasi_status.id_wakaf_donasi AND $cari AND $status";
	$stmt = $mysqli->query($sql);
	if($stmt->num_rows== 0){
		echo '<tr class=""><td colspan="8" class="center">Tidak ada data ditemukan.</td></tr>';
	}else{
		while($data = $stmt->fetch_object()){
			$data_proyek = getDataByCollumn("tbl_wakaf_proyek","id_wakaf_proyek",$data->id_wakaf_proyek);
			$data_proyek_donasi = getDataByCollumn("tbl_wakaf_donasi_option","id_wakaf_donasi",$data->id_wakaf_donasi);
			$data_proyek_status = getDataByCollumn("tbl_wakaf_donasi_status","id_wakaf_status",$data->id_wakaf_status);
			$data_user = getDataByCollumn("tbl_user","id_user",$data->id_user);
			echo'
					<tr class="">
					<td>'.$data_proyek->nama_proyek.'</td>
					<td>'.$data_user->nama_lengkap.'</td>
					<td align="right">Rp'.setHarga($data->jumlah_wakaf).'</td>
					<td>'.$data->kode_wakaf.'</td>
					<td>'.$data->metode_pembayaran.'</td>
					<td>'.$data_proyek_donasi->status_reward.'</td>
					<td>'.$data_proyek_donasi->status_baju.'</td>
					<td align="center">
			';
				if($status_p == "proses" OR $status_p == "all"){
					echo '
						<a href="?page=donasi-wakaf&set=done-'.$data->id_wakaf_donasi.'"><button class="btn btn-primary btn-sm fa fa-check" title="SET DONE"></button></a>
					';
				}
				if($status_p != "fail"){
					echo '
						<a href="?page=donasi-wakaf&set=fail-'.$data->id_wakaf_donasi.'"><button class="btn btn-warning btn-sm fa fa-remove" title="SET FAIL"></button></a>
					';
				}
			echo'		
						<a href="?page=donasi-wakaf&delete='.$data->id_wakaf_donasi.'"><button class="btn btn-danger btn-sm fa fa-trash" title="DELETE DATA"></button></a>
					</td>
				</tr>
			';		
		}
	}
}
function donasiSet($set_status){
	global $mysqli;
	
	$set_status = explode("-",$set_status);
	$status = str_replace("_"," ",$set_status[0]);
	$id_wakaf_status = $set_status[1];
	
	$stmt = $mysqli->query("UPDATE tbl_wakaf_donasi_status SET status_wakaf = '$status' WHERE id_wakaf_status = $id_wakaf_status");
	if($stmt){
			$data_donasi_status = getDataByCollumn("tbl_wakaf_donasi_status","id_wakaf_status",$id_wakaf_status);
			$data_donasi = getDataByCollumn("tbl_wakaf_donasi","id_wakaf_donasi",$data_donasi_status->id_wakaf_donasi);
			$data_user = getDataByCollumn("tbl_user","id_user",$data_donasi->id_user);

			// $stmt2 = $mysqli->query("select * from tbl_user where id_user=".$data_donasi->id_user."");
			// echo "select * from tbl_user where id_user=".$data_donasi->id_user."";
			// $data_user = $stmt2->fetch_object();
		if($status=="fail"){
			kirimSMS("Maaf, donasi wakaf anda kami tolak karena tidak sesuai syarat.",$data_user->telepon);
//			$data_email = getDataByCollumn("tbl_customer","id_customer",$data_peminjaman->id_customer);
//			kirimEmail("member",$data_pesan,$data_email->email);
		}
		if($status=="done"){
			$bonus_referal = ($data_donasi->jumlah_wakaf/100)*getPengaturanUmum("komisi_wakaf");
			$stmt4 = $mysqli->query("UPDATE tbl_user SET saldo_dompet = (saldo_dompet+$bonus_referal) WHERE id_user=".$data_user->referal."");
			$stmt5 = $mysqli->query("INSERT INTO tbl_dompet_mutasi(id_user,tipe_mutasi,jumlah_mutasi,deskripsi_mutasi,status_mutasi) 
			VALUES(".$data_user->referal.",'+',$bonus_referal,'Bonus dari wakaf affilaite/referal','done') ");
			kirimSMS("Selamat, donasi wakaf anda sudah kami terima.",$data_user->telepon);
//			$data_email = getDataByCollumn("tbl_customer","id_customer",$data_peminjaman->id_customer);
//			kirimEmail("member",$data_pesan,$data_email->email);
		}
			echo '		
				<div class="divider divider--xs"></div>
				<div class="alert alert-success" role="alert" align="center">
					Status donasi berhasil diubah.
				</div>
			';
//				<meta http-equiv="Refresh" content="2; URL=?page=donasi-wakaf&sub='.$set_status[0].'">
	}else{
		echo '		
			<div class="divider divider--xs"></div>
			<div class="alert alert-danger" role="alert" align="center">
				Status donasi gagal diubah, silahkan coba lagi.
			</div>
		';
	}
}

function donasiDelete($id_wakaf_donasi){
	global $mysqli;
	
	$stmt = $mysqli->query("delete from tbl_wakaf_donasi where id_wakaf_donasi = $id_wakaf_donasi");
	if($stmt){
		echo '		
			<div class="divider divider--xs"></div>
			<div class="alert alert-success" role="alert" align="center">
				Data berhasil dihapus.
			</div>
		';
	}else{
		echo '		
			<div class="divider divider--xs"></div>
			<div class="alert alert-danger" role="alert" align="center">
				Data gagal dihapus, silahkan coba lagi.
			</div>
		';
	}
}

function donasiDeleteAll($status_pencairan){
	global $mysqli;
	
	$stmt = $mysqli->query("delete from tbl_wakaf_donasi where status_pencairan = '$status_pencairan'");
	if($stmt){
		echo '		
			<div class="divider divider--xs"></div>
			<div class="alert alert-success" role="alert" align="center">
				Data berhasil dikosongkan.
			</div>
			<meta http-equiv="Refresh" content="2; URL=?page=mutasi-saldo">
		';
	}else{
		echo '		
			<div class="divider divider--xs"></div>
			<div class="alert alert-danger" role="alert" align="center">
				Data gagal dikosongkan, silahkan coba lagi.
			</div>
		';
	}
}

function blogList($cari,$tipe){
	global $mysqli;
	
	if($cari == "all" OR $cari == ""){
		$cari = "id_post != '0'";
	}else{
		$cari_post = $mysqli->query("select id_post from tbl_post where judul_post LIKE '%$cari%'");
		$cari = "id_post = '0'";
		while($data = $cari_post->fetch_object()){
			$cari = $cari." OR id_post = '".$data->id_post."'";
		}
	}
	if(isset($_GET['sub'])){
		$sub = $_GET['sub'];
	}else{
		$sub = $_SESSION['sub'];
	}
	$stmt = $mysqli->query("select * from tbl_post where tipe_post='$tipe' AND ($cari)");
	if($stmt->num_rows== 0){
		echo '<tr class=""><td colspan="8" class="center">Tidak ada data ditemukan.
		</td></tr>';
	}else{
		while($data = $stmt->fetch_object()){
			$data_user = getDataByCollumn("tbl_user","id_user",$data->id_user);
			echo'
				<tr class="">
					<td width="5%">'.$data->id_post.'</td>
					<td>'.$data_user->nama_lengkap.'</td>
					<td>'.$data->pemateri.'</td>
					<td>'.$data->judul_post.'</td>
					<td align="center" width="20%">'.$data->tanggal_pembuatan.'</td>
					<td>'.$data->tag_post.'</td>
					<td width="16%">
			';
			
			echo'
						<a href="?page=blog&sub='.$sub.'&edit='.$data->id_post.'"><button class="btn btn-primary btn-sm fa fa-edit" title="EDIT POST"></button></a>
						<a href="?page=blog&sub='.$sub.'&delete='.$data->id_post.'"><button class="btn btn-danger btn-sm fa fa-trash" title="DELETE DATA"></button></a>
						<a href="../detil-'.$sub.'.php?'.$sub.'='.str_replace(" ","-",$data->judul_post).'" target="_blank"><button class="btn btn-info btn-sm fa fa-eye" title="LIHAT POSTINGAN"></button></a>						
					</td>
				</tr>
			';		
		}
	}
}

function blogDelete($id_post){
	global $mysqli;
	
	$stmt = $mysqli->query("delete from tbl_post where id_post = $id_post");
	if($stmt){
		echo '		
			<div class="divider divider--xs"></div>
			<div class="alert alert-success" role="alert" align="center">
				Postingan berhasil dihapus.
			</div>
		';
	}else{
		echo '		
			<div class="divider divider--xs"></div>
			<div class="alert alert-danger" role="alert" align="center">
				Postingan gagal dihapus, silahkan coba lagi.
			</div>
		';
	}
}

function blogEdit($id_post){
	global $mysqli;
	
	if(isset($_POST['btnEditPost'])){
	$jumTag = $_POST['jumTag'];
	$tag_post = '';
	for($i=0;$i<$jumTag;$i++){
		if(isset($_POST['tagPost'.$i.''])){
			$tag_post .= $_POST['tagPost'.$i.''].",";
		}
	}
		$stmt = $mysqli->query("update tbl_post set
			tipe_post='".$_POST['txtTipePost']."',
			pemateri='".$_POST['txtNamaPemateri']."',
			judul_post='".$_POST['txtJudulPost']."',
			isi_post='".$_POST['txtIsiPost']."',
			url_video='".$_POST['txtVideo']."',
			tag_post='".$tag_post."'
				WHERE id_post='$id_post'
			");
		if($stmt){
			echo '		
				<div class="divider divider--xs"></div>
				<div class="alert alert-success" role="alert" align="center">
					Postingan anda berhasil di edit.
				</div>
			';
		}else{			
			echo '		
				<div class="divider divider--xs"></div>
				<div class="alert alert-danger" role="alert" align="center">
					Data gagal dihapus, silahkan coba lagi.
				</div>
			';
		}
	}
	$stmt = $mysqli->query("select * from tbl_post where id_post = $id_post");
	if($stmt->num_rows > 0){
		$data = $stmt->fetch_object();
		$video = str_replace('"','*',$data->url_video);
		$video = str_replace("*","'",$video);
		echo'
		<form name="item" action="" method="post"  enctype="multipart/form-data">
			<div class="card card-block">
				<div class="col-md-12">
					<label class="col-md-2"><b>Tipe Post : &nbsp </b></label>
					<div class="col-md-10">
					  <select class="form-control" name="txtTipePost">
				';
					if($data->tipe_post=="berita"){
						echo'<option value="berita">Blog Berita</option>';						
					}else{
						echo'<option value="tausyiah">tausyiah Dakwah</option>';						
					}
				echo'
						<option value="'.$data->tipe_post.'">--------------------</option>
						<option value="berita">Blog Berita</option>
						<option value="tausyiah">tausyiah Dakwah</option>
					  </select>
					</div>
				</div>
				<div class="col-md-12">	&nbsp </div>
				<div class="col-md-12">
					<label class="col-md-2"><b>Nama Pemateri : &nbsp </b></label>
					<div class="col-md-10">
					  <select class="form-control" name="txtNamaPemateri" required>';
					  if($data->pemateri == "Ustad Hari Mukti"){
						echo'
							<option value="Ustad Hari Mukti" selected>Ustad Hari Mukti</option>
							<option value="Ustad Felix Siauw">Ustad Felix Siauw</option>
						';
					  }else if($data->pemateri == "Ustad Felix Siauw"){
						echo'
							<option value="Ustad Hari Mukti">Ustad Hari Mukti</option>
							<option value="Ustad Felix Siauw" selected>Ustad Felix Siauw</option>
						';
					  } 
				echo'
					  </select>
					</div>
				</div>
				<div class="col-md-12">	&nbsp </div>
				<div class="col-md-12">
					<label class="col-md-2"><b>Judul Post : &nbsp </b></label>
					<div class="col-md-10">
					  <input type="text" name="txtJudulPost" class="form-control" placeholder="judul postingan" style="width:100%;" value="'.$data->judul_post.'" required>
					</div>
				</div>
				<div class="col-md-12">	&nbsp </div>
				<div class="col-md-12">
					<label class="col-md-2"><b>Isi Postingan : &nbsp </b></label>
					<div class="col-md-10">
						<textarea name="txtIsiPost" class="ckeditor"  required>'.$data->isi_post.'</textarea>
					</div>
				</div>
				<div class="col-md-12">	&nbsp </div>
				<div class="col-md-12">
					<label class="col-md-2"><b>URL Video <br>(embed code) : &nbsp </b></label>
					<div class="col-md-10">
					  <input type="text" name="txtVideo" class="form-control" placeholder="Masukan kode embed video dari youtube" style="width:100%;" value="'.$video.'">
					</div>
				</div>
				<div class="col-md-12">	&nbsp </div>
				<div class="col-md-12">
					<label class="col-md-2"><b>Tag Post : &nbsp </b></label>
					<div class="col-md-10">
							';
								$i=0;
								$stmt = $mysqli->query("SELECT * from tbl_kategori_wakaf ORDER BY nama_kategori DESC");
								while($data_kategori = $stmt->fetch_object()){
									$cari=strpos(",".$data->tag_post,$data_kategori->nama_kategori);
									if ($cari){
										echo '<label class="checkbox-inline">
											<input type="checkbox" id="tagPost'.$i.'" name="tagPost'.$i.'" value="'.$data_kategori->nama_kategori.'" checked>'.ucfirst($data_kategori->nama_kategori).'</input>
										</label>';
									}else {
										echo '<label class="checkbox-inline">
											<input type="checkbox" id="tagPost'.$i.'" name="tagPost'.$i.'" value="'.$data_kategori->nama_kategori.'">'.ucfirst($data_kategori->nama_kategori).'</input>
										</label>';
									}
									$i++;
								}
								echo "<input type='hidden' value='$i' name='jumTag'/>";
							echo'
					</div>
				</div>
				<div class="col-md-12">	&nbsp </div>
				<div style="text-align:right;">
					<hr>	
					<input type="submit" name="btnEditPost" class="btn btn-primary" value="Edit Postingan">
				</div>
			</div>
		</form>
		';
	}else{
		echo '		
			<div class="divider divider--xs"></div>
			<div class="alert alert-danger" role="alert" align="center">
				Data tidak ditemukan.
			</div>
		';
	}
}

function blogPosting(){
	global $mysqli;
	
	$id_user = 0;
	$data_user = getDataByCollumn("tbl_user","id_user",$id_user);
	$tipe_post = $_POST['txtTipePost'];
	$nama_pemateri = $_POST['txtNamaPemateri'];
	$judul_post = str_replace("'","",$_POST['txtJudulPost']);
	$isi_post = str_replace("'","",$_POST['txtIsiPost']);
	$url_video = $_POST['txtVideo'];
	$TagTambahan = str_replace("'","",$_POST['txtTag']);
	$jumTag = $_POST['jumTag'];
	if($TagTambahan != ''){
		$tag_post = ','.$TagTambahan.',';
	}else{
		$tag_post = ',';
	}
	for($i=0;$i<$jumTag;$i++){
		if(isset($_POST['tagPost'.$i.''])){
			$tag_post .= $_POST['tagPost'.$i.''];
		}
	}
	$tag_post .= ',';
	
	
	$ok_ext = array('jpg','png','jpeg','JPG','PNG','JPEG'); // allow only these types of files
	$destination = "foto_post/";
	$file = $_FILES['foto_post'];
	$filename = explode(".", $file["name"]); 
	$file_name = $file['name']; // file original name
	$file_name_no_ext = isset($filename[0]) ? $filename[0] : null; // File name without the extension
	$file_extension = $filename[count($filename)-1];
	$file_weight = $file['size'];
	$file_type = $file['type'];
	// If there is no error
	if( $file['error'] == 0 ){
		// check if the extension is accepted
		if( in_array(strtolower($file_extension), $ok_ext)){
			// check if the size is not beyond expected size
			// rename the file
			$fileNewName = $tipe_post.'_'.str_replace(" ","",$judul_post).'.'.$file_extension ;
			// and move it to the destination folder
			if( move_uploaded_file($file['tmp_name'], "../".$destination.$fileNewName) ){
				$url_foto = "foto_post/".$fileNewName;
				$sql = "INSERT INTO tbl_post(id_user,pemateri,judul_post,isi_post,tag_post,url_video,status_post,url_foto,tipe_post)
						VALUES('$id_user','$nama_pemateri','$judul_post','$isi_post','$tag_post','$url_video','done','$url_foto','$tipe_post')";
				$stmt = $mysqli->query($sql);
				if($stmt){
					kirimSMS("Selamat, postingan anda sudah kami publish.",$data_user->telepon);
					echo '		
					<div class="divider divider--xs"></div>
						<div class="alert alert-success" role="alert" align="center">
							<b>Postingan '.$tipe_post.'  baru berhasil dibuat... !!</b>
						</div>
					';
				}else{
					echo '		
					<div class="divider divider--xs"></div>
						<div class="alert alert-danger" role="alert" align="center">
							<b>Postingan '.$tipe_post.' gagal dibuat... !!</b>
						</div>
					';
				}
			}else{
				echo "can't upload file.";
			}
		}else{
			echo "File type is not supported.";
		}
	}	
}


?>


