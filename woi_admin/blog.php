<?php
	if(isset($_GET['sub'])){
		if($_GET['sub'] == "posting"){
			include_once 'blogposting.php';
		}else if($_GET['sub'] == "tausyiah" OR $_GET['sub'] == "berita"){
			include_once 'bloglist.php';
		}
	}else{
		include_once 'blogposting.php';
	}
?>