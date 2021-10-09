<?php
  include '../init.php';
  	$getFromU->preventAccess($_SERVER['REQUEST_METHOD'], realPath(__FILE__), realPath($_SERVER['SCRIPT_FILENAME']));
  if (isset($_POST['deleteComment']) && !empty($_POST['deleteComment'])) {
    $id = $_SESSION['id'];
    $commentID = $_POST['deleteComment'];
    $getFromU->delete('comments', array('commentID' => $commentID, 'commentBy' => $id));
  }
 ?>
