<?php
include_once 'functions/functions.php';
	
if(isset($_POST['cari_member'])){
	$cari = $_POST['cari_member'];
	memberList($cari);
}
if(isset($_POST['cari_admin'])){
	$cari = $_POST['cari_admin'];
	adminList($cari);
}
if(isset($_POST['cari_bank'])){
	$cari = $_POST['cari_bank'];
	bankList($cari);
}

if(isset($_POST['cari_mutasi'])){
	$cari = $_POST['cari_mutasi'];
	mutasiSaldo($cari);
}

if(isset($_POST['cari_proyek'])){
	$cari = $_POST['cari_proyek'];
	proyekList($_SESSION['proyek'],$cari);
}

if(isset($_POST['cari_peminjaman'])){
	$cari = $_POST['cari_peminjaman'];
	peminjamanList($_SESSION['peminjaman'],$cari);
}

if(isset($_POST['cari_pembayaran'])){
	$cari = $_POST['cari_pembayaran'];
	pembayaranList($_SESSION['pembayaran'],$cari);
}

if(isset($_POST['cari_posting'])){
	$cari = $_POST['cari_posting'];
	blogList($cari,$_POST['tipe_posting']);
}
?>
