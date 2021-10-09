<?php
  include '../init.php';
  	$getFromU->preventAccess($_SERVER['REQUEST_METHOD'], realPath(__FILE__), realPath($_SERVER['SCRIPT_FILENAME']));
  if (isset($_GET['showNotification']) && !empty($_GET['showNotification'])) {
    $id = $_SESSION['id'];
    $data = $getFromM->getNotificationCount($id);
    echo json_encode(array('notification' => $data->totalN, 'messages' => $data->totalM ));

  }else {
    				header('Location: '.BASE_URL.'index.php');
  }
 ?>
