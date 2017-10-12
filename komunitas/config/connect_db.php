<?php
ini_set('session.cookie_domain', '.woi.or.id' );
session_start();
include 'emailLibrary/function.php';
	
//$mysqli = new mysqli("localhost","muata672_aditya","27april1996","muata672_woi");		
$mysqli = new mysqli("localhost","root","","db_woi");		
//$mysqli = new mysqli("188.166.222.108","wakaf_admin","Wakaf1234","wakaf_woi");		

if (mysqli_connect_errno())
{
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
function getPengaturan($nama_pengaturan){	
	global $mysqli;
	$stmt = $mysqli->query("SELECT * FROM tbl_pengaturan WHERE nama_pengaturan = '$nama_pengaturan'");
	$data = $stmt->fetch_object();
	return $data->value_pengaturan;
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
function getUrlWeb(){
	global $mysqli;
	$stmt = $mysqli->query("select value_pengaturan from tbl_pengaturan where nama_pengaturan='url_web'");
	$data=$stmt->fetch_object();
	return $data->value_pengaturan;
}
function getKodeUnik(){
	global $mysqli;
	$stmt = $mysqli->query("select * from tbl_wakaf_donasi_status where status_wakaf='pending'");
	return $stmt->num_rows+500;
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
function getSisaWaktu($tgl_akhir){
	$sisa_waktu = ((abs(strtotime ($tgl_akhir) - strtotime (date('Y-m-d'))))/(60*60*24));
	return $sisa_waktu;
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
function cekEmail($email){
	global $mysqli;
	$stmt = $mysqli->query("select * from tbl_login where email='".$email."'");
	return $stmt->num_rows;
}
function cekUsername($username){
	global $mysqli;
	$stmt = $mysqli->query("select * from tbl_login where username='".$username."'");
	return $stmt->num_rows;
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
}

function proyekWakafBaru(){
	global $mysqli;
	
	$id_user = $_SESSION['login_id'];
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
				VALUES($id_kategori_wakaf,$id_user,'$nama_proyek','$headline_proyek','$deskripsi_proyek','$target_dana','$tanggal_akhir','$url_foto','pending')
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
								VALUES('$id_user','".$_SESSION['login_nama']."','$nama_proyek','$deskripsi_proyek','$tag_kategori_wakaf','done','$url_foto','wakaf')";
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

function proyekWakafEdit(){
	global $mysqli;
	
	$id_wakaf_proyek = $_GET['edit'];
	$kategori_wakaf = explode("|",$_POST['txtKategoriProyek']);
	$id_kategori_wakaf = $kategori_wakaf[0];
	$tag_kategori_wakaf = $kategori_wakaf[1];
	$nama_proyek = $_POST['txtNamaProyek'];
	$headline_proyek = $_POST['txtHeadlineProyek'];
	$deskripsi_proyek = $_POST['txtDeskripsiProyek'];
	$target_dana = $_POST['txtTargetProyek'];
	$tanggal_akhir = $_POST['txtBerakhirProyek'];
	$data_proyek = getDataByCollumn("tbl_wakaf_proyek","id_wakaf_proyek",$id_wakaf_proyek);
	
	$ok_ext = array('jpg','png','jpeg'); // allow only these types of files
	$destination = "foto_post/";
	$file = $_FILES['foto_post'];
	$filename = explode(".", $file["name"]); 
	$file_name = $file['name']; // file original name
	$file_name_no_ext = isset($filename[0]) ? $filename[0] : null; // File name without the extension
	$file_extension = $filename[count($filename)-1];
	$file_weight = $file['size'];
	$file_type = $file['type'];
	if($file['name'] != null){
		// If there is no error
		if( $file['error'] == 0 ){		
			// check if the extension is accepted
			if( in_array(strtolower($file_extension), $ok_ext)){
				// check if the size is not beyond expected size
				// rename the file
				$fileNewName = 'proyek_'.str_replace(" ","",$nama_proyek).'.'.$file_extension ;
				// and move it to the destination folder
				if( move_uploaded_file($file['tmp_name'], $destination.$fileNewName) ){
					unlink($data_proyek->url_foto);
					$url_foto = "foto_post/".$fileNewName;					
				}else{
					echo "can't upload file.";
				}
			}else{
				echo "File type is not supported.";
			}
		}else{
			echo "File error";
		}		
	}else{
		$url_foto = $data_proyek->url_foto;					
	}
	$sql = "UPDATE tbl_wakaf_proyek SET id_kategori_wakaf=".$id_kategori_wakaf.", nama_proyek='".$nama_proyek."', headline_proyek='".$headline_proyek."',
	deskripsi_proyek='".$deskripsi_proyek."', target_dana=".$target_dana.", tanggal_akhir='".$tanggal_akhir."', url_foto='".$url_foto."' WHERE id_wakaf_proyek=".$id_wakaf_proyek." ";
	$stmt = $mysqli->query($sql);
	if($stmt){
		echo '		
			<div class="divider divider--xs"></div>
			<div class="alert alert-success" role="alert" align="center">
				<b>Proyek Wakaf berhasil diubah... !!</b>
			</div>
		';
		$sql = "UPDATE tbl_post SET judul_post='".$nama_proyek."', isi_post='".$deskripsi_proyek."', url_foto='".$url_foto."', tag_post='".$tag_kategori_wakaf."' 
		WHERE judul_post='".$data_proyek->nama_proyek."' ";
		$stmt = $mysqli->query($sql);
		if($stmt){
			echo '		
			<div class="divider divider--xs"></div>
				<div class="alert alert-success" role="alert" align="center">
					<b>Berita Proyek Wakaf berhasil diubah... !!</b>
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
				<b>Proyek Wakaf gagal diubah... !!</b>
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
				$stmt = $mysqli->query("insert into tbl_komunitas(owner_komunitas,kategori_komunitas,nama_komunitas,deskripsi_komunitas,url_foto,status_komunitas) values(".$_COOKIE['login_id'].",'$kategori_komunitas','$nama_komunitas','$deskripsi_komunitas','$url_foto','pending')");
				if($stmt){
					$stmt = $mysqli->query("select * from tbl_komunitas where owner_komunitas='".$_COOKIE['login_id']."' AND nama_komunitas='$nama_komunitas'")->fetch_object();
					$mysqli->query("insert into tbl_komunitas_anggota(id_komunitas,id_user) values(".$stmt->id_komunitas.",".$_COOKIE['login_id'].")");
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

?>