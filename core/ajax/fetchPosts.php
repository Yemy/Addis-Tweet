<?php
  include '../init.php';
  	$getFromU->preventAccess($_SERVER['REQUEST_METHOD'], realPath(__FILE__), realPath($_SERVER['SCRIPT_FILENAME']));
  if (isset($_POST['fetchPosts']) && !empty($_POST['fetchPosts'])) {
    $id = $_SESSION['id'];
    $limit = (int) trim($_POST['fetchPosts']);
    $getFromT->tweets($id, $limit);
  }
 ?>
