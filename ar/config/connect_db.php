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
function getUrlWeb(){
	global $mysqli;
	$stmt = $mysqli->query("select value_pengaturan from tbl_pengaturan where nama_pengaturan='url_web'");
	$data=$stmt->fetch_object();
	return $data->value_pengaturan;
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
?>