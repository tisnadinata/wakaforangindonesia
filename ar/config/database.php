<?php 
session_start();
//$mysqli = new mysqli("localhost","uicyhihu_kbuser","kasbon1234","uicyhihu_kasbon");
$mysqli = new mysqli("localhost","root","","db_woi");
	
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
function kirimSMS($tipe_sms,$data,$nomor){
	$isi_pesan = '';
	$data = explode("/",$data);
	if($tipe_sms == "register"){
		$isi_pesan = 'Selamat bergabung di kasbon.id, kode OTP anda adalah '.$data[0].', silahkan masukan pada halaman website yang muncul';
	}
	if($tipe_sms == "peminjaman"){
		$isi_pesan = 'Selamat peminjaman dari kasbon.id sebesar Rp.'.setHarga($data[0]).' telah dikirim ke nomor rekening '.$data[1].', terimakasih';
	}
	if($tipe_sms == "member"){
		$isi_pesan = 'Untuk pembayaran di kasbon.id silahkan login ke member area menggunakan password '.$data[0].' dan email di daftarkan.';
	}
	if($tipe_sms == "pencairan"){
		$isi_pesan = 'Saldo dari kasbon.id sebesar Rp.'.setHarga($data[0]).' telah dicairkan ke rekening '.$data[1].', terimakasih.';
	}
	$userkeyanda = 'inxa3r';
	$passkeyanda = 'kasbon123';
	$nohptujuan = $nomor;
	$url = "https://reguler.zenziva.net/apps/smsapi.php?userkey=$userkeyanda&passkey=$passkeyanda&nohp=$nohptujuan&pesan=$isi_pesan";
	$url = str_replace(" ","%20",$url);
	file_get_contents($url);
}
function kirimEmail($tipe_email,$data,$email){
	include '../../emailLibrary/function.php';
	$isi_pesan = '';
	$data = explode("/",$data);
	if($tipe_email == "register"){
		$isi_pesan = 'Selamat bergabung di kasbon.id, anda secara resmi sudah menjadi member di kasbon.id';
	}
	if($tipe_email == "peminjaman"){
		$isi_pesan = 'Selamat peminjaman dari kasbon.id sebesar <b>Rp.'.setHarga($data[0]).'</b> telah dikirim ke nomor rekening <b>'.$data[1].'</b>, terimakasih';
	}
	if($tipe_email == "member"){
		$isi_pesan = 'Untuk pembayaran di kasbon.id silahkan login ke member area menggunakan password <b>'.$data[0].'</b> dan email di daftarkan.';
	}
	if($tipe_email == "pencairan"){
		$isi_pesan = 'Saldo dari kasbon.id sebesar <b>Rp.'.setHarga($data[0]).'</b> telah dicairkan ke rekening <b>'.$data[1].'</b>, terimakasih.';
	}
    $to       = $email;
    $subject  = 'Kasbon.id Pinjaman Uang Cepat';
    $message  = "<p>".$isi_pesan."</p>";
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
		for($i=1;$i<=9;$i++){
			$stmt = $mysqli->query("
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
			<meta http-equiv="Refresh" content="2; URL=">
		';					
	}
	echo'
	<form action="" role="form" method="post">
		<h6>Perusahaan :</h6>
		<div class="form-group row">
			<label for="inputEmail3" class="col-sm-5 form-control-label">Nama Perusahaan</label>
			<div class="col-sm-7">
				<input type="text" class="form-control" name="pengaturan[1]" placeholder="Nama Perusahaan" value="'.$data[1].'"></div>
		</div>
		<div class="form-group row">
			<label for="inputEmail3" class="col-sm-5 form-control-label">Deskripsi Perusahaan</label>
			<div class="col-sm-7">
				<textarea class="form-control" name="pengaturan[2]" rows="5" cols="28" width="100%" style="resize:none;" placeholder="Alamat Perusahaan Anda">'.$data[2].'</textarea>
			</div>
		</div>
		<div class="form-group row">
			<label for="inputEmail3" class="col-sm-5 form-control-label">Alamat Perusahaan</label>
			<div class="col-sm-7">
<input type="text" class="form-control" name="pengaturan[3]" placeholder="Alamat Perusahaan" value="'.$data[3].'"></div>
		</div>
		<div class="form-group row">
			<label for="inputEmail3" class="col-sm-5 form-control-label">Nomor Telepon</label>
			<div class="col-sm-7">
				<input type="text" class="form-control" name="pengaturan[9]" placeholder="Nomor telepon perusahaan/website" value="'.$data[9].'"></div>
		</div>
		<h6>Website :</h6>
		<div class="form-group row">
			<label for="inputEmail3" class="col-sm-5 form-control-label">Logo Website Besar</label>
			<div class="col-sm-7">
				<input type="text" class="form-control" name="pengaturan[4]" placeholder="Link/URL gambar website anda" value="'.$data[4].'"></div>
		</div>
		<div class="form-group row">
			<label for="inputEmail3" class="col-sm-5 form-control-label">Logo Website Kecil</label>
			<div class="col-sm-7">
				<input type="text" class="form-control" name="pengaturan[5]" placeholder="Link/URL gambar website anda" value="'.$data[5].'"></div>
		</div>
		<div class="form-group row">
			<label for="inputEmail3" class="col-sm-5 form-control-label">URL Facebook</label>
			<div class="col-sm-7">
				<input type="text" class="form-control" name="pengaturan[6]" placeholder="Link/URL gambar website anda" value="'.$data[6].'"></div>
		</div>
		<div class="form-group row">
			<label for="inputEmail3" class="col-sm-5 form-control-label">URL Twitter</label>
			<div class="col-sm-7">
				<input type="text" class="form-control" name="pengaturan[7]" placeholder="Link/URL gambar website anda" value="'.$data[7].'"></div>
		</div>
		<div class="form-group row">
			<label for="inputEmail3" class="col-sm-5 form-control-label">EMAIL Website</label>
			<div class="col-sm-7">
				<input type="email" class="form-control" name="pengaturan[8]" placeholder="Link/URL gambar website anda" value="'.$data[8].'"></div>
		</div>
	<hr>
		<div class="form-group row">
			<div class="col-sm-12">
				<button type="submit" name="btnUbahPengaturan" class="btn btn-primary col-sm-12 col-md-6 col-md-offset-3 pull-right">Ubah pengaturan</button>
			</div>
		</div>
	</form>
	<hr>
	';
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
	$stmt = $mysqli->query("insert into tbl_kategori_wakaf(nama_kategori,deskripsi_kategori) values('$nama_kategori','$deskripsi_kategori')");
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
	$stmt = $mysqli->query("UPDATE tbl_kategori_wakaf SET nama_kategori='$nama_kategori', deskripsi_kategori='$deskripsi_kategori' WHERE id_kategori_wakaf=".$_GET['edit']."");
	if($stmt){
		echo '		
			<div class="divider divider--xs"></div>
			<div class="alert alert-success" role="alert" align="center">
				Program wakaf berhasil diubah .
			</div>
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
function memberVerifikasi($id_user){
	global $mysqli;
	
	$data = getDataByCollumn("tbl_user_verifikasi","id_user",$id_user);
	return $data->status_verifikasi;
}
function memberList($cari){
	global $mysqli;
	
	if($cari == "all" OR $cari == ""){
		$cari = "nama_lengkap != ''";
	}else{
		$cari = "nama_lengkap LIKE '%$cari%'";
	}
	$stmt = $mysqli->query("select * from tbl_user where $cari GROUP BY id_user");
	if($stmt->num_rows== 0){
		echo '<tr class=""><td colspan="8" class="center">Tidak ada data ditemukan.</td></tr>';
	}else{
		while($data = $stmt->fetch_object()){
			echo'
				<tr class="">
					<td align="center">'.$data->id_user.'</td>
					<td>'.$data->nama_lengkap.'</td>
					<td>'.$data->alamat.'</td>
					<td>'.$data->telepon.' / '.$data->email.'</td>
					<td>'.strtoupper($data->tipe_user).'</td>
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

function memberDelete($id_user){
	global $mysqli;
	
	$data = getDataByCollumn("tbl_user","id_user",$id_user);
	$stmt = $mysqli->query("delete from tbl_user where id_user = $id_user");
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
			echo'		
						<a href="?page=pencairan&set=fail-'.$data->id_pencairan.'"><button class="btn btn-warning btn-sm fa fa-remove" title="SET FAIL"></button></a>
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
			$stmt = $mysqli->query("UPDATE tbl_user SET saldo_dompet=(saldo_dompet+".$data_pencairan->jumlah_pencairan.") WHERE id_pencairan='".$id_pencairan."'");
			$stmt2 = $mysqli->query("INSERT INTO tbl_dompet_mutasi(id_user,jumlah_mutasi,deskripsi_mutasi,status_mutasi) VALUES('".$data_pencairan->id_user."','".$data_pencairan->jumlah_pencairan."','Pencairan Saldo','fail')");
			if($stmt AND $stmt2){
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
		}else if($status=="done"){
			$stmt = $mysqli->query("INSERT INTO tbl_dompet_mutasi(id_user,jumlah_mutasi,deskripsi_mutasi,status_mutasi) VALUES('".$data_pencairan->id_user."','".$data_pencairan->jumlah_pencairan."','Pencairan Saldo','done')");
			if($stmt){
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
//			kirimSMS("pencairan",$data_pesan,$data_affiliate->telepon);
//			$data_email = getDataByCollumn("tbl_customer","id_customer",$data_peminjaman->id_customer);
//			kirimEmail("member",$data_pesan,$data_email->email);
		}
			echo '		
				<div class="divider divider--xs"></div>
				<div class="alert alert-success" role="alert" align="center">
					Status pencairan berhasil diubah.
				</div>
				<meta http-equiv="Refresh" content="2; URL=?page=pencairan&sub='.$set_status[0].'">
			';
	}else{
		echo '		
			<div class="divider divider--xs"></div>
			<div class="alert alert-danger" role="alert" align="center">
				Status pencairan gagal diubah, silahkan coba lagi.
			</div>
		';
	}
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
	
	$id_user = $_SESSION['admin_id'];
	$kategori_wakaf = explode("|",$_POST['txtKategoriProyek']);
	$id_kategori_wakaf = $kategori_wakaf[0];
	$tag_kategori_wakaf = $kategori_wakaf[1];
	$nama_proyek = $_POST['txtNamaProyek'];
	$headline_proyek = $_POST['txtHeadlineProyek'];
	$deskripsi_proyek = $_POST['txtDeskripsiProyek'];
	$target_dana = $_POST['txtTargetProyek'];
	$tanggal_akhir = $_POST['txtBerakhirProyek'];
	
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
			if( move_uploaded_file($file['tmp_name'], $destination.$fileNewName) ){
				$url_foto = "foto_post/".$fileNewName;
				$stmt = $mysqli->query("INSERT INTO tbl_wakaf_proyek(id_kategori_wakaf,id_user,nama_proyek,headline_proyek,deskripsi_proyek,target_dana,tanggal_akhir,url_foto,status_proyek)
				VALUES($id_kategori_wakaf,$id_user,'$nama_proyek','$headline_proyek','$deskripsi_proyek','$target_dana','$tanggal_akhir','$url_foto','proses')
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
						$sql = "INSERT INTO tbl_post(id_user,pemateri,judul_post,isi_post,tag_post,status_post,url_foto,tipe_post)
								VALUES('$id_user','Admin','$nama_proyek','$deskripsi_proyek','$tag_kategori_wakaf','done','$url_foto','wakaf')";
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
			$data_wakaf = getDataByCollumn("tbl_wakaf_donasi","id_wakaf_proyek",$data->id_wakaf_proyek);
			echo'
					<tr class="">
					<td>'.$data->id_wakaf_proyek.'</td>
					<td>'.$data->nama_proyek.'</td>
					<td>'.$data_user->nama_lengkap.'</td>
					<td align="right">Rp'.setHarga($data->target_dana).'</td>
					<td align="right">Rp'.setHarga(00).'</td>
					<td>'.$data->tanggal_pembuatan.'</td>
					<td>'.$data->tanggal_akhir.'</td>
					<td align="center">
			';
				if($status_p == "proses"){
					echo '
						<a href="?page=proyek&set=done-'.$data->id_wakaf_proyek.'"><button class="btn btn-primary btn-sm fa fa-check" title="SET DONE"></button></a>
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
	if($stmt){
//			$data_user = getDataByCollumn("tbl_user","id_user",$data_pencairan->id_user);
		if($status=="fail"){
			echo "INI DIUBAH KE FAIL";
		}else if($status=="done"){
			echo "INI DIUBAH KE DONE";
//			kirimSMS("pencairan",$data_pesan,$data_affiliate->telepon);
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
		unlink($data->url_foto);
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
			$data_proyek_status = getDataByCollumn("tbl_wakaf_donasi_status","id_wakaf_status",$data->id_wakaf_status);
			$data_user = getDataByCollumn("tbl_user","id_user",$data->id_user);
			echo'
					<tr class="">
					<td>'.$data_proyek->nama_proyek.'</td>
					<td>'.$data_user->nama_lengkap.'</td>
					<td align="right">Rp'.setHarga($data->jumlah_wakaf).'</td>
					<td>'.$data->kode_wakaf.'</td>
					<td>'.$data->metode_pembayaran.'</td>
					<td>'.$data->status_wakif.'</td>
					<td>'.$data_proyek_status->status_wakaf.'</td>
					<td align="center">
			';
				if($status_p == "proses" OR $status_p == "all"){
					echo '
						<a href="?page=donasi-wakaf&set=done-'.$data->id_wakaf_donasi.'"><button class="btn btn-primary btn-sm fa fa-check" title="SET DONE"></button></a>
					';
				}
				if($status_p == "done" OR $status_p == "fail" OR $status_p == "pending" OR $status_p == "all"){
					echo '
						<a href="?page=donasi-wakaf&set=proses-'.$data->id_wakaf_donasi.'"><button class="btn btn-info btn-sm fa fa-refresh" title="SET PROSES"></button></a>
					';
				}
			echo'		
						<a href="?page=donasi-wakaf&set=fail-'.$data->id_wakaf_donasi.'"><button class="btn btn-warning btn-sm fa fa-remove" title="SET FAIL"></button></a>
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
	$id_pencairan = $set_status[1];
	
	$stmt = $mysqli->query("UPDATE tbl_wakaf_donasi SET status_pencairan = '$status' WHERE id_pencairan = $id_pencairan");
	if($stmt){
			$data_pencairan = getDataByCollumn("tbl_wakaf_donasi","id_pencairan",$id_pencairan);
			$data_user = getDataByCollumn("tbl_user","id_user",$data_pencairan->id_user);
		if($status=="fail"){
			$stmt = $mysqli->query("UPDATE tbl_user SET saldo_dompet=(saldo_dompet+".$data_pencairan->jumlah_pencairan.") WHERE id_pencairan='".$id_pencairan."'");
			$stmt2 = $mysqli->query("INSERT INTO tbl_dompet_mutasi(id_user,jumlah_mutasi,deskripsi_mutasi,status_mutasi) VALUES('".$data_pencairan->id_user."','".$data_pencairan->jumlah_pencairan."','Pencairan Saldo','fail')");
			if($stmt AND $stmt2){
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
		}else if($status=="done"){
			$stmt = $mysqli->query("INSERT INTO tbl_dompet_mutasi(id_user,jumlah_mutasi,deskripsi_mutasi,status_mutasi) VALUES('".$data_pencairan->id_user."','".$data_pencairan->jumlah_pencairan."','Pencairan Saldo','done')");
			if($stmt){
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
//			kirimSMS("pencairan",$data_pesan,$data_affiliate->telepon);
//			$data_email = getDataByCollumn("tbl_customer","id_customer",$data_peminjaman->id_customer);
//			kirimEmail("member",$data_pesan,$data_email->email);
		}
			echo '		
				<div class="divider divider--xs"></div>
				<div class="alert alert-success" role="alert" align="center">
					Status pencairan berhasil diubah.
				</div>
				<meta http-equiv="Refresh" content="2; URL=?page=pencairan&sub='.$set_status[0].'">
			';
	}else{
		echo '		
			<div class="divider divider--xs"></div>
			<div class="alert alert-danger" role="alert" align="center">
				Status pencairan gagal diubah, silahkan coba lagi.
			</div>
		';
	}
}

function donasiDelete($id_pencairan){
	global $mysqli;
	
	$stmt = $mysqli->query("delete from tbl_wakaf_donasi where id_pencairan = $id_pencairan");
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
						<a href="../blog/view.php?post='.$data->id_post.'" target="_blank"><button class="btn btn-info btn-sm fa fa-eye" title="LIHAT POSTINGAN"></button></a>						
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
						echo'<option value="tausyah">Tausyah Dakwah</option>';						
					}
				echo'
						<option value="'.$data->tipe_post.'">--------------------</option>
						<option value="berita">Blog Berita</option>
						<option value="tausyah">Tausyah Dakwah</option>
					  </select>
					</div>
				</div>
				<div class="col-md-12">	&nbsp </div>
				<div class="col-md-12">
					<label class="col-md-2"><b>Nama Pemateri : &nbsp </b></label>
					<div class="col-md-10">
					  <input type="text" name="txtNamaPemateri" class="form-control" placeholder="nama pemateri" style="width:100%;" value="'.$data->pemateri.'" required>
					</div>
				</div>
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
	
	$id_user = $_SESSION['admin_id'];
	$tipe_post = $_POST['txtTipePost'];
	$nama_pemateri = $_POST['txtNamaPemateri'];
	$judul_post = $_POST['txtJudulPost'];
	$isi_post = $_POST['txtIsiPost'];
	$jumTag = $_POST['jumTag'];
	$tag_post = '';
	for($i=0;$i<$jumTag;$i++){
		if(isset($_POST['tagPost'.$i.''])){
			$tag_post .= $_POST['tagPost'.$i.''].",";
		}
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
			$fileNewName = $tipe_post.'_'.str_replace(" ","",$judul_post).'.'.$file_extension ;
			// and move it to the destination folder
			if( move_uploaded_file($file['tmp_name'], $destination.$fileNewName) ){
				$url_foto = "foto_post/".$fileNewName;
				$sql = "INSERT INTO tbl_post(id_user,pemateri,judul_post,isi_post,tag_post,status_post,url_foto,tipe_post)
						VALUES('$id_user','Admin','$judul_post','$isi_post','$tag_post','done','$url_foto','$tipe_post')";
				$stmt = $mysqli->query($sql);
				if($stmt){
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


