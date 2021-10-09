<?php
	include 'core/init.php';
	if ($getFromU->loginCheck() === false) {
		header('Location: index.php');
	}
	$id = $_SESSION['id'];
	$user = $getFromU->userData($id);
	$notify = $getFromM->getNotificationCount($id);
	if (isset($_POST['screenName'])) {
		if (!empty($_POST['screenName'])) {
			$screenName = $getFromU->checkInput($_POST['screenName']);
			$profilebio = $getFromU->checkInput($_POST['bio']);
			$country = $getFromU->checkInput($_POST['country']);
			$website = $getFromU->checkInput($_POST['website']);
			if (strlen($screenName) > 25) {
				$error = 'User Name is too Long!';
			}else if (strlen($bio) > 200){
				$error = 'Bio is too long!';
			}else{
				$getFromU->update('users', $id, array('screenName' => $screenName, 'bio' => $profilebio, 'country'=> $country, 'website' => $website ));
				header('Location: profile.php?username='.$user->username);
			}
		}else{
			$error = "User Name can't Be Empty";
		}
	}
	if (isset($_FILES['profileimage'])) {
		if (!empty($_FILES['profileimage']['name'][0])) {
			$fileRoot = $getFromU->uploadImage($_FILES['profileimage']);
			$getFromU->update('users', $id, array('profileimage' => $fileRoot));
			header('Location: profile.php?username='.$user->username);
		}
	}
	if (isset($_FILES['profilecover'])) {
		if (!empty($_FILES['profilecover']['name'][0])) {
			$fileRoot = $getFromU->uploadImage($_FILES['profilecover']);
			$getFromU->update('users', $id, array('profilecover' => $fileRoot));
			header('Location: profile.php?username='.$user->username);
		}
	}
 ?>

 <!doctype html>
<html>
<head>
	<title>Addis Chat</title>
	<meta charset="UTF-8" />
	<link rel="stylesheet" type="text/css" href="assets/css/font/css/font-awesome.css">
    <link rel="stylesheet" type="text/css" href="assets/css/font/css/font-awesome.min.css">
	<link rel="shortcut icon" type="image/ICO" href="assets/images/favicon.ICO">
	<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.css"/>   -->
    <link rel="stylesheet" href="assets/css/style-complete.css"/>
	<!-- <script src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>  -->
   <script src="assets/js/jquery.min.js"></script>
   <script src="assets/js/jquery.js"></script>
</head>
<!--Helvetica Neue-->
<body>
<div class="wrapper">
<div class="header-wrapper">
	<div class="nav-container">
    	<div class="nav">
		<div class="nav-left">
			<ul>
				
				<li><a href="home.php"><i class="fa fa-home" aria-hidden="true"></i>Home</a></li>
                <li><a href="<?php echo $user->username ?>"><i class="fa fa-user" aria-hidden="true"></i>Profile</a></li>

				<?php if ($getFromU->loginCheck() === true) { ?>
                <li><a href="i/notifications"><i class="fa fa-bell" aria-hidden="true"></i>Notifications
                    <span id="notification"><?php if($notify->totalN > 0){echo '<span class="span-i">'.$notify->totalN.'</span>';} ?></span> </a></li>
				<li id="messagePopup" rel="user_id"><i class="fa fa-envelope" aria-hidden="true"></i>Messages<span id="messages"><?php if($notify->totalM > 0){echo '<span class="span-i">'.$notify->totalM.'</span>';} ?></span></li>
			<?php }else {
				echo 'please login first';
			} ?>
			</ul>
		</div><!-- nav left ends-->
		<div class="nav-right">
			<ul>
				<li><input type="text" placeholder="Search" class="search"/><i style="margin-left: -5px; color: black;" class="fa fa-search" aria-hidden="true"></i>
					<div class="search-result">
					</div>
				</li>
				<li><label for="pop-up-tweet" class="addTweetBtn">Post</label></li>
				
				<?php if ($getFromU->loginCheck() === true) { ?>
				<li class="hover"><label class="drop-label" for="drop-wrap1"><img src="<?php echo BASE_URL.$user->profileimage; ?>"/></label>
				<input type="checkbox" id="drop-wrap1">
				<div class="drop-wrap">
					<div class="drop-inner">
						<ul>
							<li><a href="<?php echo BASE_URL.$user->username; ?>"><?php echo  $user->username; ?></a></li>
							<li><a href="<?php echo BASE_URL; ?>settings/account">Settings</a></li>
							<li><a href="<?php echo BASE_URL; ?>includes/logout.php">Log out</a></li>
						</ul>
					</div>
				</div>
				</li>
			<?php }else{
				echo '<li><a href="'.BASE_URL.'index.php">I Have account, Sign in</a></li>';
			} ?>
			</ul>
		</div><!-- nav right ends-->

	</div><!-- nav ends -->
	</div><!-- nav container ends -->
</div><!-- header wrapper end -->

<!--Profile cover-->
<div class="profile-cover-wrap">
<div class="profile-cover-inner">
	<div class="profile-cover-img">
	   <!-- PROFILE-COVER -->
		<img src="<?php echo $user->profilecover;?>"/>

		<div class="img-upload-button-wrap">
			<div class="img-upload-button1">
				<label for="cover-upload-btn">
					<i class="fa fa-camera" aria-hidden="true"></i>
				</label>
				<span class="span-text1">
					Change your cover photo
				</span>
				<input id="cover-upload-btn" type="checkbox"/>
				<div class="img-upload-menu1">
					<span class="img-upload-arrow"></span>
					<form method="post" enctype="multipart/form-data">
						<ul>
							<li>
								<label for="file-up">
									Upload photo
								</label>
								<input type="file" name="profilecover" onchange="this.form.submit();" id="file-up" />
							</li>
								<li>
								<label for="cover-upload-btn">
									Cancel
								</label>
							</li>
						</ul>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="profile-nav">
	<div class="profile-navigation">
		<ul>
			<li>
				<a href="#">
					<div class="n-head">
						Posts
					</div>
					<div class="n-bottom">
						<?php $getFromT->countTweets($id); ?>
					</div>
				</a>
			</li>
			<li>
				<a href="<?php echo BASE_URL.$user->username.'/following';?>">
					<div class="n-head">
						FOLLOWINGS
					</div>
					<div class="n-bottom">
						<?php echo $user->following;?>
					</div>
				</a>
			</li>
			<li>
				<a href="<?php echo BASE_URL.$user->username.'/followers';?>">
					<div class="n-head">
						FOLLOWERS
					</div>
					<div class="n-bottom">
						<?php echo $user->followers;?>
					</div>
				</a>
			</li>
			<li>
				<a href="#">
					<div class="n-head">
						LIKES
					</div>
					<div class="n-bottom">
						<?php $getFromT->countLikes($id); ?>
					</div>
				</a>
			</li>

		</ul>
		<div class="edit-button">
			<span>
				<button class="f-btn" type="button" value="Cancel">Cancel</button>
			</span>
			<span>
				<input type="submit" id="save" onclick="window.location.href='<?php echo 'profile.php?username='.$user->username; ?>'" value="Save Changes">
			</span>

		</div>
	</div>
</div>
</div><!--Profile Cover End-->

<div class="in-wrapper">
<div class="in-full-wrap">
  <div class="in-left">
	<div class="in-left-wrap">
		<!--PROFILE INFO WRAPPER END-->
<div class="profile-info-wrap">
	<div class="profile-info-inner">
		<div class="profile-img">
			<!-- PROFILE-IMAGE -->
			<img src="<?php echo $user->profileimage;?>"/>
 			<div class="img-upload-button-wrap1">
			 <div class="img-upload-button">
				<label for="img-upload-btn">
					<i class="fa fa-camera" aria-hidden="true"></i>
				</label>
				<span class="span-text">
					Change your profile photo
				</span>
				<input id="img-upload-btn" type="checkbox"/>
				<div class="img-upload-menu">
				 <span class="img-upload-arrow"></span>
					<form method="post" enctype="multipart/form-data">
						<ul>
							<li>
								<label for="profileimage">
									Upload profile picture
								</label>
								<input id="profileimage" type="file" onchange="this.form.submit();" name="profileimage"/>
							</li>

							<li><a href="#">Remove</a></li>
							<li>
								<label for="img-upload-btn">
									Cancel
								</label>
							</li>
						</ul>
					</form>
				</div>
			  </div>
			  <!-- img upload end-->
			</div>
		</div>

	    <form id="editForm" method="post" enctype="multipart/Form-data">
		<div class="profile-name-wrap">
			<?php
				if (isset($imageError)) {
					echo '			<ul>
					 <li class="error-li">
				 	 <div class="span-pe-error">'.$imageError.'</div>
				 </li>
			 </ul> ';
				}
			 ?>
			<div class="profile-name">
				<input type="text" name="screenName" value="<?php echo $user->screenName;?>"/>
			</div>
			<div class="profile-tname">
				@<?php echo $user->username;?>
			</div>
		</div>
		<div class="profile-bio-wrap">
			<div class="profile-bio-inner">
				<textarea class="status" name="bio"><?php echo $user->bio;?></textarea>
				<div class="hash-box">
			 		<ul>
			 		</ul>
			 	</div>
			</div>
		</div>
			<div class="profile-extra-info">
			<div class="profile-extra-inner">
				<ul>
					<li>
						<div class="profile-ex-location">
							<input id="cn" type="text" name="country" placeholder="Country" value="<?php echo $user->country;?>" />
						</div>
					</li>
					<li>
						<div class="profile-ex-location">
							<input type="text" name="website" placeholder="Website" value="<?php echo $user->website;?>"/>
						</div>
					</li>
			<?php
				if (isset($error)) {
					echo '
					 <li class="error-li">
				 	 <div class="span-pe-error">'.$error.'</div>
				 </li> ';
				}
			 ?>
				</form>
			 	<script type="text/javascript">
					$('#save').click(function(){
						$('#editForm').submit();
					})
				</script>
						</ul>
					</div>
				</div>
				<div class="profile-extra-footer">
					<div class="profile-extra-footer-head">
						<div class="profile-extra-info">
							<ul>
								<li>
									<div class="profile-ex-location-i">
										<i class="fa fa-camera" aria-hidden="true"></i>
									</div>
									<div class="profile-ex-location">
										<a href="#">0 Photos and videos </a>
									</div>
								</li>
							</ul>
						</div>
					</div>
					<div class="profile-extra-footer-body">
						<ul>
						  <!-- <li><img src="#"></li> -->
						</ul>
					</div>
				</div>
			</div>
			<!--PROFILE INFO INNER END-->
		</div>
		<!--PROFILE INFO WRAPPER END-->
	</div>
	<!-- in left wrap-->
</div>
<!-- in left end-->

<div class="in-center">
	<div class="in-center-wrap">
		<?php
			$tweets = $getFromT->getUserTweets($id);
			foreach ($tweets as $tweet) {
				$likes = $getFromT->likes($id, $tweet->tweetID);
				$retweet = $getFromT->checkRetweet($tweet->tweetID, $id);
				$user = $getFromU->userData($tweet->retweetBy);
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
														<span>'.$getFromU->timeAgo($retweet['postedOn']).'</span>
													</div>
													<div class="t-h-c-dis">
														'.$getFromT->getTweetLinks($tweet->retweetMsg).'
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
																<span>'.$getFromU->timeAgo($tweet->postedOn).'</span>
															</div>
															<div class="retweet-t-s-b-inner-right-text">
																'.$getFromT->getTweetLinks($tweet->status).'
															</div>
														</div>
													</div>
												</div>
											</div>
											 </div>' : '

									<div class="t-show-popup" data-tweet="'.$tweet->tweetID.'">
										<div class="t-show-head">
											<div class="t-show-img">
												<img src="'.BASE_URL.$tweet->profileimage.'"/>
											</div>
											<div class="t-s-head-content">
												<div class="t-h-c-name">
													<span><a href="'.$tweet->username.'">'.$tweet->screenName.'</a></span>
													<span>@'.$tweet->username.'</span>
													<span>'.$getFromU->timeAgo($tweet->postedOn).'</span>
												</div>
												<div class="t-h-c-dis">
													'.$getFromT->getTweetLinks($tweet->status).'
												</div>
											</div>
										</div>'.
										((!empty($tweet->tweetImage)) ?
										 '<!--tweet show head end-->
										<div class="t-show-body">
											<div class="t-s-b-inner">
											 <div class="t-s-b-inner-in">
												 <img src="'.BASE_URL.$tweet->tweetImage.'" class="imagePopup" data-tweet="'.$tweet->tweetID.'" />
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

												<li>'.(($tweet->tweetID === $retweet['retweetID'] OR $id == $retweet['retweetBy']) ? '<button class="retweeted" data-tweet="'.$tweet->tweetID.'" data-user="'.$tweet->tweetBy.'"><i class="fa fa-retweet" aria-hidden="true"></i><span class="retweetsCount">'.$tweet->retweetCount.'</span></button>' : '<button class="retweet" data-tweet="'.$tweet->tweetID.'" data-user="'.$tweet->tweetBy.'"><i class="fa fa-retweet" aria-hidden="true"></i><span class="retweetsCount">'.(($tweet->retweetCount > 0) ? $tweet->retweetCount : '').'</span></button>' ).'</li>
												<li><button><i class="fa fa-share" aria-hidden="true"></i></button></li>

												'.(($tweet->tweetBy === $id) ? '
													<li>
													<a href="#" class="more"><i class="fa fa-ellipsis-h" aria-hidden="true"></i></a>
													<ul>
														<li><label class="deleteTweet" data-tweet="'.$tweet->tweetID.'">Delete Post</label></li>
													</ul>
												</li> ' : '').'
											</ul>
										</div>
									</div>
								</div>
								</div>
								</div> ';
			}
		 ?>
	</div>
	<!-- in left wrap-->
   <div class="popupTweet"></div>
 <script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/like.js"></script>
 	<script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/retweet.js"></script>
 	<script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/popupTweets.js"></script>
 	<script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/delete.js"></script>
 	<script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/comment.js"></script>
 	<script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/popupForm.js"></script>
 	<script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/search.js"></script>
 	<script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/hashtag.js"></script>
	<script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/message.js"></script>
	<script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/postMessage.js"></script>
	<script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/notification.js"></script>
</div>
<!-- in center end -->

<div class="in-right">
	<div class="in-right-wrap">
		<!--==WHO TO FOLLOW==-->
	   <?php $getFromF->whoToFollow($id);?>
	 	<!--==TRENDS==-->
				<?php $getFromT->trends();?>
	</div>
	<!-- in left wrap-->
</div>
	<script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/follow.js"></script>
<!-- in right end -->

   </div>
   <!--in full wrap end-->

  </div>
  <!-- in wrappper ends-->

</div>
<!-- ends wrapper -->
</body>
</html>
