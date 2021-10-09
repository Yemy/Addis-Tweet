<?php
	include('database/connection.php');
	include('classes/user.php');
	include('classes/tweet.php');
	include('classes/follow.php');
	include('classes/message.php');
	// include '../admin/posts.php';

	global $pdo;

	session_start();

	$getFromU = new User($pdo);
	$getFromF = new Follow($pdo);
	$getFromT = new Tweet($pdo);
	$getFromM = new Message($pdo);

	// $getFromA = new Post($pdo);

	define("BASE_URL", "http://localhost/addischat/")

 ?>
