<?php
  include '../init.php';
  	$getFromU->preventAccess($_SERVER['REQUEST_METHOD'], realPath(__FILE__), realPath($_SERVER['SCRIPT_FILENAME']));
  if (isset($_POST['search']) && !empty($_POST['search'])) {
    $id = $_SESSION['id'];
    $search = $getFromU->checkInput($_POST['search']);
    $result = $getFromU->search($search);

    echo '<h4>People</h4><div class="message-recent"> ';
    foreach ($result as $user) {
      if (($user->id) != $id) {
        echo '<div class="people-message" data-user="'.$user->id.'">
                	<div class="people-inner">
                		<div class="people-img">
                			<img src="'.BASE_URL.$user->profileimage.'"/>
                		</div>
                		<div class="name-right">
                			<span><a>'.$user->screenName.'</a></span><span>@'.$user->username.'</span>
                		</div>
                	</div>
                 </div>';
      }
    }
    echo '</div>';
  }

 ?>
