<?php
	class Tweet extends User {
		function __construct($pdo){
			$this->pdo = $pdo;
		}
		public function tweets($id, $num){
			$stmt = $this->pdo->prepare("SELECT * FROM `tweets`LEFT JOIN `users` ON `tweetBy` = `id` WHERE `tweetBy` = :id AND `retweetID` = '0' OR `tweetBy` = `id` AND `retweetBy` != :id AND `tweetBy` IN(SELECT `receiver` FROM `follow` WHERE `sender` = :id) ORDER BY `tweetID` DESC LIMIT :num");
			$stmt->bindParam(":id", $id, PDO::PARAM_INT);
			$stmt->bindParam(":num", $num, PDO::PARAM_INT);
			$stmt->execute();
			$tweets = $stmt->fetchAll(PDO::FETCH_OBJ);

			foreach ($tweets as $tweet) {
				$likes = $this->likes($id, $tweet->tweetID);
				$retweet = $this->checkRetweet($tweet->tweetID, $id);
				$user = $this->userData($tweet->retweetBy);
				echo ' <div class="all-tweet">
								<div class="t-show-wrap">
								 <div class="t-show-inner">
								 '.(($retweet['retweetID'] === $tweet->retweetID OR $tweet->retweetID > 0 ) ? '
									<div class="t-show-banner">
										<div class="t-show-banner-inner">
											<span><i class="fa fa-retweet" aria-hidden="true"></i></span><span> Retweeted By '.$user->screenName.'</span>
										</div>
									</div> ' : '').'
									'.((!empty($tweet->retweetMsg) && $tweet->tweetID === $retweet['tweetID'] or $tweet->retweetID > 0) ?
									'<div class="t-show-popup" data-tweet="'.$tweet->tweetID.'">
									 <div class="t-show-head">
												<div class="t-show-img">
													<img src="'.BASE_URL.$user->profileimage.'"/>
												</div>
												<div class="t-s-head-content">
													<div class="t-h-c-name">
														<span><a href="'.BASE_URL.$user->username.'">'.$user->screenName.'</a></span>
														<span>@'.$user->username.'</span>
														<span>'.$this->timeAgo($retweet['postedOn']).'</span>
													</div>
													<div class="t-h-c-dis">
														'.$this->getTweetLinks($tweet->retweetMsg).'
													</div>
												</div>
											</div>
											<div class="t-s-b-inner">
												<div class="t-s-b-inner-in">
													<div class="retweet-t-s-b-inner">
													'.((!empty($tweet->tweetImage)) ? '
														<div class="retweet-t-s-b-inner-left">
															<img src="'.BASE_URL.$tweet->tweetImage.'"  class="imagePopup" data-tweet="'.$tweet->tweetID.'"/>
														</div> ' : '').'
														<div>
															<div class="t-h-c-name">
																<span><a href="'.BASE_URL.$tweet->username.'">'.$tweet->screenName.'</a></span>
																<span>@'.$tweet->username.'</span>
																<span>'.$this->timeAgo($tweet->postedOn).'</span>
															</div>
															<div class="retweet-t-s-b-inner-right-text">
																'.$this->getTweetLinks($tweet->status).'
															</div>
														</div>
													</div>
												</div>
											</div>
											 </div>' : '

									<div class="t-show-popup" data-tweet="'.$tweet->tweetID.'">
										<div class="t-show-head">
											<div class="t-show-img">
												<img src="'.$tweet->profileimage.'"/>
											</div>
											<div class="t-s-head-content">
												<div class="t-h-c-name">
													<span><a href="'.$tweet->username.'">'.$tweet->screenName.'</a></span>
													<span>@'.$tweet->username.'</span>
													<span>'.$this->timeAgo($tweet->postedOn).'</span>
												</div>
												<div class="t-h-c-dis">
													'.$this->getTweetLinks($tweet->status).'
												</div>
											</div>
										</div>'.
										((!empty($tweet->tweetImage)) ?
										 '<!--tweet show head end-->
										<div class="t-show-body">
										  <div class="t-s-b-inner">
										   <div class="t-s-b-inner-in">
										     <img src="'.$tweet->tweetImage.'" class="imagePopup" data-tweet="'.$tweet->tweetID.'" />
										   </div>
										  </div>
										</div>
										<!--tweet show body end-->
										' : '').'

									 </div> ').'
									<div class="t-show-footer">
										<div class="t-s-f-right">
											<ul>

											<li>'.(($likes['likeOn'] === $tweet->tweetID) ? '<button class="unlike-btn" data-tweet="'.$tweet->tweetID.'
											" data-user="'.$tweet->tweetBy.'"><i class="fa fa-thumbs-up" aria-hidden="true"></i><span class="likesCounter">
											'.$tweet->likesCount.'</span></button>' : '<button class="like-btn" data-tweet="'.$tweet->tweetID.'" data-user="'.$tweet->tweetBy.'">
											<i class="fa fa-thumbs-up" aria-hidden="true"></i><span class="likesCounter">'.(($tweet->likesCount > 0) ? $tweet->likesCount : '').'</span></button>').'</li>

											<li>'.(($likes['likeOn'] === $tweet->tweetID) ? '<button class="unlike-btn" data-tweet="'.$tweet->tweetID.'
											" data-user="'.$tweet->tweetBy.'"><i class="fa fa-heart" aria-hidden="true"></i><span class="likesCounter">
											'.$tweet->likesCount.'</span></button>' : '<button class="like-btn" data-tweet="'.$tweet->tweetID.'" data-user="'.$tweet->tweetBy.'">
											<i class="fa fa-heart-o" aria-hidden="true"></i><span class="likesCounter">'.(($tweet->likesCount > 0) ? $tweet->likesCount : '').'</span></button>').'</li>

											<!- to be change after finishing the main pro ->
											<li>'.(($likes['likeOn'] === $tweet->tweetID) ? '<button class="like-btn" data-tweet="'.$tweet->tweetID.'
											" data-user="'.$tweet->tweetBy.'"><i class="fa fa-thumbs-down" aria-hidden="true"></i><span class="likesCounter">
											'.$tweet->likesCount.'</span></button>' : '<button class="like-btn" data-tweet="'.$tweet->tweetID.'" data-user="'.$tweet->tweetBy.'">
											<i class="fa fa-thumbs-down" aria-hidden="true"></i><span class="likesCounter">'.(($tweet->likesCount > 0) ? 0 : '').'</span></button>').'</li>

												<li>'.(($tweet->tweetID === $retweet['retweetID']) ? '<button class="retweeted" data-tweet="'.$tweet->tweetID.'" data-user="'.$tweet->tweetBy.'"><i class="fa fa-retweet" aria-hidden="true"></i><span class="retweetsCount">'.$tweet->retweetCount.'</span></button>' : '<button class="retweet" data-tweet="'.$tweet->tweetID.'" data-user="'.$tweet->tweetBy.'"><i class="fa fa-retweet" aria-hidden="true"></i><span class="retweetsCount">'.(($tweet->retweetCount > 0) ? $tweet->retweetCount : '').'</span></button>' ).'</li>
												<li><button><i class="fa fa-share" aria-hidden="true"></i></button></li>

												'.(($tweet->tweetBy === $id) ? '
													<li>
													<a href="#" class="more"><i class="fa fa-ellipsis-h" aria-hidden="true"></i></a>
													<ul>
													  <li><label class="deleteTweet" data-tweet="'.$tweet->tweetID.'">Delete Tweet</label></li>
													</ul>
												</li> ' : '').'
											</ul>
										</div>
									</div>
								</div>
								</div>
								</div> ';
			}
		}

		public function getTrendByHash($hashtag){
			$stmt = $this->pdo->prepare("SELECT * FROM `trends` WHERE `hashtag` LIKE :hashtag");
			$stmt->bindValue(':hashtag', $hashtag.'%');
			$stmt->execute();
			return $stmt->fetchAll(PDO::FETCH_OBJ);
		}

		public function getTag($tag){
			$stmt = $this->pdo->prepare("SELECT `id`, `username`, `screenName`, `profileimage` FROM `users` WHERE `username` LIKE :tag Limit 50");
			$stmt->bindValue(':tag', $tag.'%');
			$stmt->execute();
			return $stmt->fetchAll(PDO::FETCH_OBJ);
		}

		public function addTrend($hashtag){
			preg_match_all("/#+([a-zA-Z0-9_]+)/i", $hashtag, $matchs);
			if ($matchs) {
				$result = array_values($matchs[1]);
			}
			$sql = "INSERT INTO `trends` (`hashtag`, `createdOn`) VALUES(:hashtag, CURRENT_TIMESTAMP)";
			foreach ($result as $trend) {
				if ($stmt = $this->pdo->prepare($sql)) {
					$stmt->execute(array(':hashtag' => $trend));
				}
			}
		}

		public function addMention($status, $id, $tweet_id){
			preg_match_all("/@+([a-zA-Z0-9_]+)/i", $status, $matchs);
			if ($matchs) {
				$result = array_values($matchs[1]);
			}
			$sql = "SELECT * FROM `users` WHERE `username` = :mention";
			foreach ($result as $trend) {
				if ($stmt = $this->pdo->prepare($sql)) {
					$stmt->execute(array(':mention' => $trend));
					$data = $stmt->fetch(PDO::FETCH_OBJ);
				}
			}
			if ($data->id != $id) {
				// Message::sendNotification($data->id, $id, $tweet_id, 'mention');
			}
		}

		public function trends(){
			$stmt = $this->pdo->prepare("SELECT *, COUNT(`tweetID`) AS `tweetCount` FROM `trends` INNER JOIN `tweets` ON `status` LIKE CONCAT('%#',`hashtag`,'%') OR `retweetMsg` LIKE CONCAT('%#',`hashtag`,'%') GROUP BY `hashtag` ORDER BY `tweetID`");
			$stmt->execute();
			$trends = $stmt->fetchAll(PDO::FETCH_OBJ);
			echo '<div class="trend-wrapper"><div class="trend-inner"><div class="trend-title"><h3>Trends</h3></div><!-- trend title end-->';
			foreach ($trends as $trend) {
				echo '<div class="trend-body">
									<div class="trend-body-content">
										<div class="trend-link">
											<a href="../hashtag/'.$trend->hashtag.'">#'.$trend->hashtag.'</a>
										</div>
										<div class="trend-tweets">
											'.$trend->tweetCount.' <span>tweets</span>
										</div>
									</div>
								</div>
								<!--Trend body end-->';
			}
			echo '</div></div>';
		}

		public function getTweetByHash($hashtag){
			$stmt = $this->pdo->prepare("SELECT * FROM `tweets` LEFT JOIN `users` ON `tweetBy` = `id` WHERE `status` LIKE :hashtag OR `retweetMsg` LIKE :hashtag");
			$stmt->bindValue(":hashtag", '%#'.$hashtag.'%', PDO::PARAM_STR);
			$stmt->execute();
			return $stmt->fetchAll(PDO::FETCH_OBJ);
		}

		public function getUserByHash($hashtag){
			$stmt = $this->pdo->prepare("SELECT DISTINCT * FROM `tweets` INNER JOIN `users` ON `tweetBy` = `id` WHERE `status` LIKE :hashtag OR `retweetMsg` LIKE :hashtag GROUP BY `id`");
			$stmt->bindValue(":hashtag", '%#'.$hashtag.'%', PDO::PARAM_STR);
			$stmt->execute();
			return $stmt->fetchAll(PDO::FETCH_OBJ);
		}

		public function getTweetLinks($tweet){
			$tweet = preg_replace("/(https?:\/\/)([\w]+.)([\w\.]+)/", "<a href='$0' target='_blink'>$0</a>", $tweet);
			$tweet = preg_replace("/#([\w]+)/", "<a href='".BASE_URL."hashtag/$1'>$0</a>", $tweet);
			$tweet = preg_replace("/@([\w]+)/", "<a href='".BASE_URL."$1'>$0</a>", $tweet);
			return $tweet;
		}

		public function getPopupTweet($tweet_id){
			$stmt = $this->pdo->prepare("SELECT * FROM `tweets`, `users` WHERE `tweetID` = :tweet_id AND `tweetBy` = `id`");
			$stmt->bindParam(":tweet_id", $tweet_id, PDO::PARAM_INT);
			$stmt->execute();
			return $stmt->fetch(PDO::FETCH_OBJ);
		}

		public function addLike($id, $tweet_id, $get_id){
			$stmt = $this->pdo->prepare("UPDATE `tweets` SET `likesCount` = `likesCount` +1 WHERE `tweetID` = :tweet_id");
			$stmt->bindParam(":tweet_id", $tweet_id, PDO::PARAM_INT);
			$stmt->execute();
			$this->create('likes', array('likedBy' => $id, 'likeOn' => $tweet_id));
			if ($get_id != $id) {
				Message::sendNotification($get_id, $id, $tweet_id, 'like');
			}
		}

		public function likes($id, $tweet_id){
			$stmt = $this->pdo->prepare("SELECT * FROM `likes` WHERE `likedBy` = :id AND `likeOn` = :tweet_id");
			$stmt->bindParam(":id", $id, PDO::PARAM_INT);
			$stmt->bindParam(":tweet_id", $tweet_id, PDO::PARAM_INT);
			$stmt->execute();
			return $stmt->fetch(PDO::FETCH_ASSOC);
		}

		public function unLike($id, $tweet_id, $get_id){
			$stmt = $this->pdo->prepare("UPDATE `tweets` SET `likesCount` = `likesCount` -1 WHERE `tweetID` = :tweet_id");
			$stmt->bindParam(":tweet_id", $tweet_id, PDO::PARAM_INT);
			$stmt->execute();
			// to be changed later by save to dislikes table by yemi
			// $this->create('likes', array('likedBy' => $id, 'likeOn' => $tweet_id));
			$stmt = $this->pdo->prepare("DELETE FROM `likes` WHERE `likedBy` = :id AND `likeOn` = :tweet_id");
			$stmt->bindParam(":id", $id, PDO::PARAM_INT);
			$stmt->bindParam(":tweet_id", $tweet_id, PDO::PARAM_INT);
			$stmt->execute();
		}

		public function retweet($tweet_id, $id, $get_id, $comment){
			$stmt = $this->pdo->prepare("UPDATE `tweets` SET `retweetCount` = `retweetCount` +1 WHERE `tweetID` = :tweet_id");
			$stmt->bindParam(":tweet_id", $tweet_id, PDO::PARAM_INT);
			$stmt->execute();

			$stmt = $this->pdo->prepare("INSERT INTO `tweets` (`status`,`tweetBy`,`retweetID`, `retweetBy`, `tweetImage`, `likesCount`, `retweetCount`, `postedOn`, `retweetMsg`) SELECT `status`, `tweetBy`, `tweetID`, :id, `tweetImage`, `likesCount`, `retweetCount`, `postedOn`, :retweetMsg FROM `tweets` WHERE `tweetID` = :tweet_id");
			$stmt->bindParam(":id", $id, PDO::PARAM_INT);
			$stmt->bindParam(":retweetMsg",$comment, PDO::PARAM_STR);
			$stmt->bindParam(":tweet_id", $tweet_id, PDO::PARAM_INT);
			$stmt->execute();
			Message::sendNotification($get_id, $id, $tweet_id, 'retweet');
		}

		public function checkRetweet($tweet_id, $id){
			$stmt = $this->pdo->prepare("SELECT * FROM `tweets` WHERE `retweetID` = :tweet_id AND `retweetBy` = :id OR `tweetID` = :tweet_id AND `retweetBy` = :id");
			$stmt->bindParam(":id", $id, PDO::PARAM_INT);
			$stmt->bindParam(":tweet_id", $tweet_id, PDO::PARAM_INT);
			$stmt->execute();
			return $stmt->fetch(PDO::FETCH_ASSOC);

		}

		public function comments($tweet_id){
			$stmt = $this->pdo->prepare("SELECT * FROM `comments` LEFT JOIN `users` ON `commentBy` = `id` WHERE `commentOn` = :tweet_id");
			$stmt->bindParam(":tweet_id", $tweet_id, PDO::PARAM_INT);
			$stmt->execute();
			return $stmt->fetchAll(PDO::FETCH_OBJ);
		}

		public function countTweets($id){
			$stmt = $this->pdo->prepare("SELECT COUNT(`tweetID`) AS `totalTweets` FROM `tweets` WHERE `tweetBy` = :id AND `retweetID` = '0' OR `retweetBy` = :id");
			$stmt->bindParam(":id", $id, PDO::PARAM_INT);
			$stmt->execute();
			$count =  $stmt->fetch(PDO::FETCH_OBJ);
			echo $count->totalTweets;
		}

		public function countLikes($id){
			$stmt = $this->pdo->prepare("SELECT COUNT(`likeID`) AS `totalLikes` FROM `likes` WHERE `likedBy` = :id ");
			$stmt->bindParam(":id", $id, PDO::PARAM_INT);
			$stmt->execute();
			$count =  $stmt->fetch(PDO::FETCH_OBJ);
			echo $count->totalLikes;
		}

		public function getUserTweets($id){
			$stmt = $this->pdo->prepare("SELECT * FROM `tweets` LEFT JOIN `users` ON `tweetBy` = `id` WHERE `tweetBy` = :id AND `retweetID` = '0' OR `retweetBy` = :id");
			$stmt->bindParam(":id", $id, PDO::PARAM_INT);
			$stmt->execute();
			return $stmt->fetchAll(PDO::FETCH_OBJ);
		}

		public function getAllPosts(){

		}
	}
 ?>
