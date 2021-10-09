<?php
  include '../init.php';
  	$getFromU->preventAccess($_SERVER['REQUEST_METHOD'], realPath(__FILE__), realPath($_SERVER['SCRIPT_FILENAME']));
   if (isset($_POST['unfollow']) && !empty($_POST['unfollow'])) {
     $id = $_SESSION['id'];
     $followID = $_POST['unfollow'];
     $getFromF->unfollow($followID, $id);
   }
   if (isset($_POST['follow']) && !empty($_POST['follow'])) {
     $id = $_SESSION['id'];
     $followID = $_POST['follow'];
     $getFromF->follow($followID, $id);
   }
 ?>
