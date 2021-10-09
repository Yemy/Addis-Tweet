<?php 
	$dsn = 'mysql:host=localhost; dbname=addischat';
	$user = 'root';
	$pass = '';
	try {
		$pdo = new PDO($dsn, $user, $pass);
	}
	 catch (PDOException $e) {
		echo "Connection Unsuccesful! " . $e->getMessage();
	}
 ?>