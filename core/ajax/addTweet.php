<?php
include '../init.php';
	$getFromU->preventAccess($_SERVER['REQUEST_METHOD'], realPath(__FILE__), realPath($_SERVER['SCRIPT_FILENAME']));
if (isset($_POST) && !empty($_POST)) {
  $status = $getFromU->checkInput($_POST['status']);
  $id = $_SESSION['id'];
  $tweetImage = '';

  if (!empty($status) or !empty($_FILES['file']['name'][0])) {
    if (!empty($_FILES['file']['name'][0])) {
      $tweetImage = $getFromU->uploadImage($_FILES['file']);
    }
    if (strlen($status) > 1000) {
      $error = 'You wrote too much.Please write a short description';
    }
    $tweet_id = $getFromU->create('tweets', array('status' => $status, 'tweetBy' => $id, 'tweetImage' => $tweetImage, 'postedOn' => date('Y-m-d H:i:s')));
    preg_match_all("/#+([a-zA-Z0-9_]+)/i", $status, $hashtag);
    if (!empty($hashtag)) {
      $getFromT->addTrend($status);
    }
    $getFromT->addMention($status, $id, $tweet_id);

    $result['success'] = 'Your Post is successfully uploaded.';
    echo json_encode($result);
  }else{
    $error = 'Please type any text or image to tweet!';
  }
  if (isset($error)) {
    $result['error'] = $error;
    echo json_encode($result);
  }
}
 ?>
