<?php
	// if ($getFromU->loginCheck() === false) {
	// 	header('Location: index.php');
	// }

	if (isset($_GET['username']) === true && empty($_GET['username']) === false) {
		include 'core/init.php';
		$username = $getFromU->checkInput($_GET['username']);
		$profileId = $getFromU->idByUser($username);
		$profileData = $getFromU->userData($profileId);
		$id = $_SESSION['id'];
		$user = $getFromU->userData($id);
			$notify = $getFromM->getNotificationCount($id);
		if ($getFromU->loginCheck() === false) {
			header('Location:'.BASE_URL.'index.php');
		}
		if (!$profileData) {
				header('Location:'.BASE_URL.'index.php');
		}
	}else {
			header('Location:'.BASE_URL.'index.php');
	}
 ?>

 <!doctype html>
 <html>
 	<head>
 		<title>Addis Chat peoples followed by <?php echo $profileData->screenName. ' (@'.$profileData->username.')'; ?></title>
 		<meta charset="UTF-8" />
  		<link rel="stylesheet" href=" <?php echo BASE_URL;?>assets/css/style-complete.css"/>
  		<link rel="shortcut icon" type="image/ICO" href="assets/images/favicon.ICO">
  		<link rel="stylesheet" type="text/css" href="<?php echo BASE_URL;?>assets/css/font/css/font-awesome.css">
     	<link rel="stylesheet" type="text/css" href="<?php echo BASE_URL;?>assets/css/font/css/font-awesome.min.css">
    		<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.css"/>   -->
 		<!-- <script src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>   -->
 	   <script src="<?php echo BASE_URL;?>assets/js/jquery.min.js"></script>
	   <script src="<?php echo BASE_URL;?>assets/js/jquery.js"></script>

     </head>
 <!--Helvetica Neue-->
 <body>
 <div class="wrapper">
 <div class="header-wrapper">
	<div class="nav-container">
    	<div class="nav">
		<div class="nav-left">
			<ul>
				
				<li><a href="../home.php"><i class="fa fa-home" aria-hidden="true"></i>Home</a></li>
                <li><a href="../<?php echo $user->username ?>"><i class="fa fa-user" aria-hidden="true"></i>Profile</a></li>

				<?php if ($getFromU->loginCheck() === true) { ?>
                <li><a href="../i/notifications"><i class="fa fa-bell" aria-hidden="true"></i>Notifications
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
 		<img src="<?php echo BASE_URL.$profileData->profilecover; ?>"/>
 	</div>
 </div>
 <div class="profile-nav">
  <div class="profile-navigation">
 	<ul>
 		<li>
  <a href="<?php echo BASE_URL.$profileData->username; ?>">
 		<div class="n-head">
 			TWEETS
 		</div>
 		<div class="n-bottom">
 		  <?php $getFromT->countTweets($profileId); ?>
 		</div>
 		</li>
 		<li>
 			<a href="<?php echo BASE_URL.$profileData->username; ?>/following">
 				<div class="n-head">
 					<a href="<?php echo BASE_URL.$profileData->username; ?>/following">FOLLOWING</a>
 				</div>
 				<div class="n-bottom">
 					<span class="count-following"><?php echo $profileData->following; ?></span>
 				</div>
 			</a>
 		</li>
 		<li>
 		 <a href="<?php echo BASE_URL.$profileData->username; ?>/followers">
 				<div class="n-head">
 					FOLLOWERS
 				</div>
 				<div class="n-bottom">
 					<span class="count-followers"><?php echo $profileData->followers; ?></span>
 				</div>
 			</a>
 		</li>
 		<li>
 			<a href="#">
 				<div class="n-head">
 					LIKES
 				</div>
 				<div class="n-bottom">
 					<?php $getFromT->countLikes($profileId); ?>
 				</div>
 			</a>
 		</li>
 	</ul>
 	<div class="edit-button">
 		<span>
 			<?php echo $getFromF->followBtn($profileId, $id); ?>
 		</span>
 	</div>
     </div>
 </div>
 </div><!--Profile Cover End-->

 <!---Inner wrapper-->
 <div class="in-wrapper">
  <div class="in-full-wrap">
    <div class="in-left">
      <div class="in-left-wrap">
 	<!--PROFILE INFO WRAPPER END-->
 	<div class="profile-info-wrap">
 	 <div class="profile-info-inner">
 	 <!-- PROFILE-IMAGE -->
 		<div class="profile-img">
 			<img src="<?php echo BASE_URL.$profileData->profileimage; ?>"/>
 		</div>

 		<div class="profile-name-wrap">
 			<div class="profile-name">
 				<a href="<?php echo BASE_URL.$profileData->username; ?>"><?php echo $profileData->username; ?></a>
 			</div>
 			<div class="profile-tname">
 				@<span class="username"><?php echo $profileData->screenName; ?></span>
 			</div>
 		</div>

 		<div class="profile-bio-wrap">
 		 <div class="profile-bio-inner">
 			<?php echo $profileData->bio; ?>
 		 </div>
 		</div>

 <div class="profile-extra-info">
 	<div class="profile-extra-inner">
 		<ul>
 		<?php if (!empty($profileData->country)) { ?>
 			<li>
 				<div class="profile-ex-location-i">
 					<i class="fa fa-map-marker" aria-hidden="true"></i>
 				</div>
 				<div class="profile-ex-location">

 					<?php echo $profileData->country; ?>
 				</div>
 			</li>
 		<?php } ?>
 		<?php if (!empty($profileData->website)) { ?>
 			<li>
 				<div class="profile-ex-location-i">
 					<i class="fa fa-link" aria-hidden="true"></i>
 				</div>
 				<div class="profile-ex-location">
 					<a href="<?php echo $profileData->website;?>" target="_blink"><?php echo $profileData->website; ?></a>
 				</div>
 			</li>
 		<?php } ?>
 			<li>
 				<div class="profile-ex-location-i">
 					<!-- <i class="fa fa-calendar-o" aria-hidden="true"></i> -->
 				</div>
 				<div class="profile-ex-location">
  				</div>
 			</li>
 			<li>
 				<div class="profile-ex-location-i">
 					<!-- <i class="fa fa-tint" aria-hidden="true"></i> -->
 				</div>
 				<div class="profile-ex-location">
 				</div>
 			</li>
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
 			 <!-- <li><img src="#"/></li> -->
 		</ul>
 	</div>
  <!-- who to follow -->
				<?php $getFromF->whoToFollow($id);?>
  <!-- trends  -->
			<?php $getFromT->trends();?>
 </div>

 	 </div>
 	<!--PROFILE INFO INNER END-->

 	</div>
 	<!--PROFILE INFO WRAPPER END-->


		<div class="popupTweet"></div>
		</div>
		<!-- in left wrap-->
	</div>
	<!-- in left end-->
		<!--FOLLOWING OR FOLLOWER FULL WRAPPER-->
		<div class="wrapper-following">
			<div class="wrap-follow-inner">
            <h3>Following</h3>
						<?php $getFromF->followingList($profileId, $id, $profileData->id);?>
			</div><!-- wrap follo inner end-->
		</div><!--FOLLOWING OR FOLLOWER FULL WRAPPER END-->
				<script type="text/javascript" src="<?php echo BASE_URL;?>/assets/js/follow.js"></script>
				<script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/search.js"></script>
				<script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/like.js"></script>
				<script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/retweet.js"></script>
				<script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/popupTweets.js"></script>
				<script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/comment.js"></script>
				<script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/popupForm.js"></script>
				<script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/search.js"></script>
				<script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/hashtag.js"></script>
				<script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/message.js"></script>
				<script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/postMessage.js"></script>
				<script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/notification.js"></script>
	</div><!--in full wrap end-->
</div>
<!-- in wrappper ends-->

</div><!-- ends wrapper -->
</body>
</html>
