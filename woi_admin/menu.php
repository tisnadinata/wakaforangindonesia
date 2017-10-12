<ul class="nav metismenu" id="sidebar-menu">
	<li>
		<a href="?page=dashboard"><i class="fa fa-home"></i> Dashboard </a>
	</li>
<?php
	if($_SESSION['status_login'] == "super admin"){
?>
	<li>
		<a href=""><i class="fa fa-user"></i> Data Admin<i class="fa arrow"></i></a>
		<ul>
			<li>
				<a href="?page=tambah-admin">Tambah Admin</a>
			</li>
			<li>
				<a href="?page=daftar-admin">Daftar Admin</a>
			</li>
		</ul>
	</li>
<?php		
	}
?>
<?php
	if($_SESSION['status_login'] == "super admin" OR $_SESSION['status_login'] == "admin"){
?>
	<li>
		<a href=""><i class="fa fa-user"></i> Data Member<i class="fa arrow"></i></a>
		<ul>
			<li>
				<a href="?page=daftar-member&tipe=wakif">Member Wakif</a>
			</li>
			<li>
				<a href="?page=daftar-member&tipe=ae">Member Executive</a>
			</li>
			<li>
				<a href="?page=daftar-member&tipe=ar">Member Representative</a>
			</li>
		</ul>
	</li>
	<li>
		<a href=""><i class="fa fa-users"></i> Data Komunitas<i class="fa arrow"></i></a>
		<ul>
			<li>
				<a href="?page=daftar-komunitas">Semua Komunitas</a>
			</li>
			<li>
				<a href="?page=daftar-komunitas&tipe=pending">Menunggu Persetujuan</a>
			</li>
			<li>
				<a href="?page=daftar-komunitas&tipe=fail">Komunitas Ditolak</a>
			</li>
		</ul>
	</li>
	<li>
		<a href=""><i class="fa fa-book"></i> Data Bank<i class="fa arrow"></i></a>
		<ul>
			<li>
				<a href="?page=bank&tipe=admin">Bank Admin/WOI</a>
			</li>
			<li>
				<a href="?page=bank&tipe=member">Bank Member</a>
			</li>
		</ul>
	</li>
	<li>
		<a href="?page=daftar-kategori"><i class="fa fa-list-ol"></i> Kategori&Program Wakaf</a>
	</li>
	<li>
		<a href=""><i class="fa fa-calendar-o"></i> Pencairan Saldo <i class="fa arrow"></i></a>
		<ul>
			<li>
				<a href="?page=mutasi-saldo">Mutasi Saldo Member</a>
			</li>
			<li>
				<a href="?page=pencairan&sub=pending">Permintaan Pencairan</a>
			</li>
			<li>
				<a href="?page=pencairan&sub=proses">Pencairan Dalam Proses</a>
			</li>
			<li>
				<a href="?page=pencairan&sub=done">Pencairan Sukses</a>
			</li>
			<li>
				<a href="?page=pencairan&sub=fail">Pencairan Gagal</a>
			</li>
		</ul>
	</li>
	<li>
		<a href=""><i class="fa fa-calendar-o"></i> Top Up Saldo <i class="fa arrow"></i></a>
		<ul>
			<li>
				<a href="?page=mutasi-saldo">Mutasi Saldo Member</a>
			</li>
			<li>
				<a href="?page=topup&sub=pending">Permintaan Topup</a>
			</li>
			<li>
				<a href="?page=topup&sub=done">Topup Sukses</a>
			</li>
			<li>
				<a href="?page=topup&sub=fail">Topup Gagal</a>
			</li>
		</ul>
	</li>
	<li>
		<a href=""><i class="fa fa-heart"></i> Data Proyek Wakaf <i class="fa arrow"></i></a>
		<ul>
			<li>
				<a href="?page=proyek-baru">Buat Proyek Baru</a>
			</li>
			<li>
				<a href="?page=proyek&sub=pending">Menunggu Verifikasi</a>
			</li>
			<li>
				<a href="?page=proyek&sub=proses">Proyek Wakaf Berjalan</a>
			</li>
			<li>
				<a href="?page=proyek&sub=done">Proyek Yang Selesai</a>
			</li>
			<li>
				<a href="?page=proyek&sub=fail">Proyek Wakaf Gagal</a>
			</li>
		</ul>
	</li>
	<li>
		<a href=""><i class="fa fa-money"></i> Data Donasi Wakaf <i class="fa arrow"></i></a>
		<ul>
			<li>
				<a href="?page=donasi-wakaf">Daftar Semua Wakaf</a>
			</li>
			<li>
				<a href="?page=donasi-wakaf&sub=proses">Donasi Wakaf Proses</a>
			</li>
			<li>
				<a href="?page=donasi-wakaf&sub=done">Donasi Wakaf Berhasil</a>
			</li>
			<li>
				<a href="?page=donasi-wakaf&sub=fail">Donasi Wakaf Gagal</a>
			</li>
		</ul>
	</li>
	<li>
		<a href="?page=pengaturan"><i class="fa fa-gears"></i> Pengaturan Umum</a>
	</li>
<?php		
	}
?>
<?php
	if($_SESSION['status_login'] == "super admin" OR $_SESSION['status_login'] == "moderator"){
?>
	<li>
		<a href=""><i class="fa fa-comment-o"></i> Blog & tausyiah <i class="fa arrow"></i></a>
		<ul>
			<li>
				<a href="?page=blog&sub=posting">Posting Baru</a>
			</li>
			<li>
				<a href="?page=blog&sub=berita">Daftar Blog</a>
			</li>
			<li>
				<a href="?page=blog&sub=tausyiah">Daftar tausyiah</a>
			</li>
		</ul>
	</li>
<?php		
	}
?>
</ul>