<?php
include_once 'config/connect_db.php';

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

?>
