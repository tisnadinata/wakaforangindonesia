<?php
// session_start();
// session_unset();
// session_destroy();
unset($_COOKIE["status_login"]);
unset($_COOKIE["login_id"]);
unset($_COOKIE["login_saldo"]);
unset($_COOKIE["login_tipe"]);
unset($_COOKIE["login_nama"]);
unset($_COOKIE["login_telepon"]);
unset($_COOKIE["login_email"]);
unset($_COOKIE["login_username"]);
unset($_COOKIE["login_password"]);

unset($_COOKIE["admin_id"]);
unset($_COOKIE["admin_login"]);
unset($_COOKIE["admin_nama"]);
	setcookie("status_login", "", time()-3600,"/");
	setcookie("login_id", "", time()-3600,"/");
	setcookie("login_saldo", "", time()-3600,"/");
	setcookie("login_tipe","", time()-3600,"/");
	setcookie("login_nama", "", time()-3600,"/");
	setcookie("login_telepon", "", time()-3600,"/");
	setcookie("login_email", "", time()-3600,"/");
	setcookie("login_username", "", time()-3600,"/");
	setcookie("login_password", "", time()-3600,"/");
	setcookie("admin_id", "", time()-3600,"/");
	setcookie("admin_login", "0");
	setcookie("admin_nama", "", time()-3600,"/");
	
													
	echo'
			<meta http-equiv="Refresh" content="0; URL=index.php">
		';

?>