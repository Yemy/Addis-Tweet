<?php
	include '../core/init.php';
	//to block php code access from the browser
	$getFromU->preventAccess($_SERVER['REQUEST_METHOD'], realPath(__FILE__), realPath($_SERVER['SCRIPT_FILENAME']));
	$getFromU->logout();
		if ($getFromU->loginCheck() === false) {
		header('Location: '.BASE_URL.'index.php');
	}else {
				header('Location: '.BASE_URL.'home.php');
	}
 ?>
