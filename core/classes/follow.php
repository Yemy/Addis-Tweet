<?php
	class Follow extends User {
		function __construct($pdo){
			$this->pdo = $pdo;
		}

		public function checkFollow($followID, $id){
			$stmt = $this->pdo->prepare("SELECT * FROM `follow` WHERE `sender` = :id AND `receiver` = :followID");
			$stmt->bindParam(":id", $id, PDO::PARAM_INT);
			$stmt->bindParam(":followID", $followID, PDO::PARAM_INT);
			$stmt->execute();
			return $stmt->fetch(PDO::FETCH_ASSOC);
		}

			public function followBtn($profileId, $id){
				$data = $this->checkFollow($profileId, $id);
				if ($this->loginCheck() === true) {
					if ($profileId != $id) {
						if ($data['receiver'] == $profileId) {
							return "<button class='f-btn following-btn follow-btn' data-follow='".$profileId."'>Following</button>";
						}else {
							return "<button class='f-btn follow-btn' data-follow='".$profileId."'><i class='fa fa-user-plus'></i>Follow </button>";
						}
					}else {
					return "<button class='f-btn' onclick=location.href='editProfile.php'>Edit Your Profile</button>";
					}
				}else {
					return "<button class='f-btn' onclick=location.href=.BASE_URL.'index.php'><i class='fa fa-user-plus'></i>Follow</button>";
				}
			}

		public function follow($followID, $id){
			$this->create('follow', array('sender' => $id, 'receiver' => $followID, 'followOn' => date('Y-m-d H:i:s')));
			$this->addFollowCount($followID, $id);
			$stmt = $this->pdo->prepare("SELECT * FROM `users` WHERE `id` = :followID");
			$stmt->execute(array("followID" => $followID));
			$data = $stmt->fetch(PDO::FETCH_ASSOC);
			echo json_encode($data);
			Message::sendNotification($followID, $id, $followID, 'follow');
		}

		public function addFollowCount($followID, $id){
			$stmt = $this->pdo->prepare("UPDATE `users` SET `following` = `following` + 1 WHERE `id` = :id;UPDATE `users` SET `followers` = `followers` + 1 WHERE `id` = :followID");
			$stmt->execute(array("id" => $id, "followID" => $followID));
		}

		public function unfollow($followID, $id){
			$this->delete('follow', array('sender' => $id, 'receiver' => $followID));
			$this->removeFollowCount($followID, $id);
			$stmt = $this->pdo->prepare("SELECT * FROM `users` WHERE `id` = :followID");
			$stmt->execute(array("followID" => $followID));
			$data = $stmt->fetch(PDO::FETCH_ASSOC);
			echo json_encode($data);
		}

		public function removeFollowCount($followID, $id){
			$stmt = $this->pdo->prepare("UPDATE `users` SET `following` = `following` - 1 WHERE `id` = :id;UPDATE `users` SET `followers` = `followers` - 1 WHERE `id` = :followID");
			$stmt->execute(array("id" => $id, "followID" => $followID));
		}

		public function followingList($profileId, $id){
				$stmt = $this->pdo->prepare("SELECT * FROM `users` LEFT JOIN `follow` ON `receiver` = `id` AND CASE WHEN `sender` = :id THEN `receiver` = `id` END WHERE `sender` IS NOT NULL");
				$stmt->bindParam(":id", $profileId, PDO::PARAM_INT);
				$stmt->execute();
				$followings = $stmt->fetchAll(PDO::FETCH_OBJ);
				foreach ($followings as $following) {
					echo ' <div class="follow-unfollow-box">
										<div class="follow-unfollow-inner">
											<div class="follow-background">
												<img src="'.BASE_URL.$following->profilecover.'"/>
											</div>
											<div class="follow-person-button-img">
												<div class="follow-person-img">
												 	<img src="'.BASE_URL.$following->profileimage.'"/>
												</div>
												<div class="follow-person-button">
													 <!-- FOLLOW BUTTON -->
													 '.$this->followBtn($following->id, $id, $profileId).'

											    </div>
											</div>
											<div class="follow-person-bio">
												<div class="follow-person-name">
													<a href="'.BASE_URL.$following->username.'">'.$following->screenName.'</a>
												</div>
												<div class="follow-person-tname">
													<a href="'.BASE_URL.$following->username.'">'.$following->username.'</a>
												</div>
												<div class="follow-person-dis">
													<!-- BIO -->
													'.$following->bio.'
												</div>
											</div>
										</div>
									</div> ';
											}
		}

		public function followersList($profileId, $id){
				$stmt = $this->pdo->prepare("SELECT * FROM `users` LEFT JOIN `follow` ON `sender` = `id` AND CASE WHEN `receiver` = :id THEN `sender` = `id` END WHERE `receiver` IS NOT NULL");
				$stmt->bindParam(":id", $profileId, PDO::PARAM_INT);
				$stmt->execute();
				$followings = $stmt->fetchAll(PDO::FETCH_OBJ);
				foreach ($followings as $following) {
					echo ' <div class="follow-unfollow-box">
										<div class="follow-unfollow-inner">
											<div class="follow-background">
												<img src="'.BASE_URL.$following->profilecover.'"/>
											</div>
											<div class="follow-person-button-img">
												<div class="follow-person-img">
												 	<img src="'.BASE_URL.$following->profileimage.'"/>
												</div>
												<div class="follow-person-button">
													 <!-- FOLLOW BUTTON -->
													 '.$this->followBtn($following->id, $id, $profileId).'

											    </div>
											</div>
											<div class="follow-person-bio">
												<div class="follow-person-name">
													<a href="'.BASE_URL.$following->username.'">'.$following->screenName.'</a>
												</div>
												<div class="follow-person-tname">
													<a href="'.BASE_URL.$following->username.'">'.$following->username.'</a>
												</div>
												<div class="follow-person-dis">
													<!-- BIO -->
													'.$following->bio.'
												</div>
											</div>
										</div>
									</div> ';
											}
						}
		public function whoToFollow($id){
			$stmt = $this->pdo->prepare("SELECT * FROM `users` WHERE `id` != :id AND `id` NOT IN (SELECT `receiver` FROM `follow` WHERE `sender` = :id) ORDER BY rand() LIMIT 5");
			$stmt->bindParam(":id", $id, PDO::PARAM_INT);
			$stmt->execute();
			$data = $stmt->fetchAll(PDO::FETCH_OBJ);

			echo '<div class="follow-wrap"><div class="follow-inner"><div class="follow-title"><h3>People You May Want To Follow</h3></div>';
				foreach ($data as $user) {
					echo '<div class="follow-body">
										<div class="follow-img">
										  <img src="'.BASE_URL.$user->profileimage.'"/>
									    </div>
										<div class="follow-content">
											<div class="fo-co-head">
												<a href="'.BASE_URL.$user->username.'">'.$user->screenName.'</a><span>@'.$user->username.'</span>
											</div>
											<!-- FOLLOW BUTTON -->
											'.$this->followBtn($user->id, $id).'
										</div>
									</div>';
				}
			echo '</div></div>';
		}
	}
 ?>
