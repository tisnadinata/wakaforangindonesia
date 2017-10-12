<?php
session_start();
session_unset();
session_destroy();

		echo'
			<meta http-equiv="Refresh" content="0; URL=login.php">
		';

?>