<?php
  include '../init.php';
	$getFromU->preventAccess($_SERVER['REQUEST_METHOD'], realPath(__FILE__), realPath($_SERVER['SCRIPT_FILENAME']));
  if (isset($_POST['like']) && !empty($_POST['like'])) {
    $user_id = $_SESSION['id'];
    $tweet_id = $_POST['like'];
    $get_id = $_POST['user_id'];
    $getFromT->addLike($user_id, $tweet_id, $get_id);
  }

  if (isset($_POST['unlike']) && !empty($_POST['unlike'])) {
    $user_id = $_SESSION['id'];
    $tweet_id = $_POST['unlike'];
    $get_id = $_POST['user_id'];
    $getFromT->unLike($user_id, $tweet_id, $get_id);
  }

 ?>
