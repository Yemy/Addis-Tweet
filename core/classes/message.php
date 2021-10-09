<?php
  /**
   *
   */
  class Message extends User{

    function __construct($pdo)
    {
      $this->pdo = $pdo;
    }

    public function recentMessages($id){
      $stmt = $this->pdo->prepare("SELECT * FROM `messages` LEFT JOIN `users` ON `messageFrom` = `id` WHERE `messageTo` = :id");
      $stmt->bindParam(":id", $id, PDO::PARAM_INT);
      $stmt->execute();
      return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function getMessages($messageFrom, $id){
      $stmt = $this->pdo->prepare("SELECT * FROM `messages` LEFT JOIN `users` ON `messageFrom` = `id` WHERE `messageFrom` = :messageFrom AND `messageTo` = :id OR `messageTo` = :messageFrom AND `messageFrom` = :id");
      $stmt->bindParam(":messageFrom", $messageFrom, PDO::PARAM_INT);
      $stmt->bindParam(":id", $id, PDO::PARAM_INT);
      $stmt->execute();
      $messages =  $stmt->fetchAll(PDO::FETCH_OBJ);

      foreach ($messages as $message) {
        if ($message->messageFrom === $id) {
          echo '  <!-- Main message BODY RIGHT START -->
                  <div class="main-msg-body-right">
                  		<div class="main-msg">
                  			<div class="msg-img">
                  				<a href="#"><img src="'.BASE_URL.$message->profileimage.'"/></a>
                  			</div>
                  			<div class="msg">'.$message->message.'
                  				<div class="msg-time">
                  				  '.$this->timeAgo($message->messageOn).'
                  				</div>
                  			</div>
                  			<div class="msg-btn">
                  				<a><i class="fa fa-ban" aria-hidden="true"></i></a>
                  				<a class="deleteMsg" data-message="'.$message->messageID.'"><i class="fa fa-trash" aria-hidden="true"></i></a>
                  			</div>
                  		</div>
                  	</div> ';
        }else {
          echo ' <!--Main message BODY LEFT START-->
            		<div class="main-msg-body-left">
            			<div class="main-msg-l">
            				<div class="msg-img-l">
            					<a href="#"><img src="'.BASE_URL.$message->profileimage.'"/></a>
            				</div>
            				<div class="msg-l">'.$message->message.'
            					<div class="msg-time-l">
            					    '.$this->timeAgo($message->messageOn).'
            					</div>
            				</div>
            				<div class="msg-btn-l">
            					<a><i class="fa fa-ban" aria-hidden="true"></i></a>
            					<a class="deleteMsg" data-message="'.$message->messageID.'"><i class="fa fa-trash" aria-hidden="true"></i></a>
            				</div>
            			</div>
            		</div>  ';
        }
      }
    }

    public function deleteMsg($messageID, $id){
      $stmt = $this->pdo->prepare("DELETE FROM `messages` WHERE `messageID` = :messageID AND `messageFrom` = :id OR `messageID` = :messageID AND `messageTo` = :id");
      $stmt->bindParam(":id", $id, PDO::PARAM_INT);
      $stmt->bindParam(":messageID", $messageID, PDO::PARAM_INT);
      $stmt->execute();
    }

    public function getNotificationCount($id){
      $stmt = $this->pdo->prepare("SELECT COUNT(`messageID`) AS `totalM`, (SELECT COUNT(`ID`) FROM `notification` WHERE `notificationFor` = :id AND `status` = '0') AS `totalN` FROM `messages` WHERE `messageTo` = :id AND `status` = '0'");
      $stmt->bindParam(":id", $id, PDO::PARAM_INT);
      $stmt->execute();
      return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function messageViewed($id){
      $stmt = $this->pdo->prepare("UPDATE `messages` SET `status` = '1' WHERE `messageTo` = :id And `status` = '0'");
      $stmt->bindParam(":id", $id, PDO::PARAM_INT);
      $stmt->execute();
    }

    public function notificationViewed($id){
      $stmt = $this->pdo->prepare("UPDATE `notification` SET `status` = '1' WHERE `notificationFor` = :id And `status` = '0'");
      $stmt->bindParam(":id", $id, PDO::PARAM_INT);
      $stmt->execute();
    }

    public function notification($id){
      $stmt = $this->pdo->prepare("SELECT * FROM `notification` N
              LEFT JOIN `users`  U ON N.`notificationFrom` = U.`id`
              LEFT JOIN `tweets` T ON N.`target` = T.`tweetID`
              LEFT JOIN `likes`  L ON N.`target` = L.`likeOn`
              LEFT JOIN `follow` F ON N.`notificationFrom` = F.`sender` AND N.`notificationFor` = F.`receiver`
              WHERE N.`notificationFor` = :id AND N.`notificationFrom` != :id ORDER BY N.`time` DESC");
      $stmt->execute(array("id" => $id));
              return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function sendNotification($get_id, $id, $target, $type){
      $this->create('notification', array('notificationFrom' => $id, 'notificationFor' => $get_id, 'target' => $target, 'type' => $type, 'time' => date('Y-m-d H:i:s')));
    }

  }

 ?>
