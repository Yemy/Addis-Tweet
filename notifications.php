<?php
	include 'core/init.php';
	$id =  $_SESSION['id'];
	$user = $getFromU->userData($id);
	$getFromM->notificationViewed($id);
	$notify = $getFromM->getNotificationCount($id);

	if ($getFromU->loginCheck() === false) {
		header('Location: index.php');
	}

	$notification = $getFromM->notification($id);

 ?>

<!doctype html>
 <html>
	<head>
		<title>Addid Chat/Notifications</title>
		  <meta charset="UTF-8" />
		  <link rel="stylesheet" type="text/css" href="<?php echo BASE_URL;?>assets/css/font/css/font-awesome.css">
		  <link rel="shortcut icon" type="image/ICO" href="assets/images/favicon.ICO">
		  <link rel="stylesheet" type="text/css" href="<?php echo BASE_URL;?>assets/css/font/css/font-awesome.min.css">
		  <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.css"/>   -->
 	  	  <link rel="stylesheet" href="<?php echo BASE_URL;?>assets/css/style-complete.css"/>
   		  <!-- <script src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>  -->
   		  <script src="<?php echo BASE_URL;?>assets/js/jquery.min.js"></script>
 		  <script src="<?php echo BASE_URL;?>assets/js/jquery.js"></script>

	</head>
	<!-- yemi's Helvetica Neue-->
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
<!---Inner wrapper-->
<br>
<div class="inner-wrapper">
<div class="in-wrapper">
	<div class="in-full-wrap">
		<div class="in-left">
			<div class="in-left-wrap">
		<div class="info-box">
			<div class="info-inner">
				<div class="info-in-head">
					<!-- PROFILE-COVER-IMAGE -->
					<img src="<?php echo BASE_URL.$user->profilecover; ?>"/>
				</div><!-- info in head end -->
				<div class="info-in-body">
					<div class="in-b-box">
						<div class="in-b-img">
						<!-- PROFILE-IMAGE -->
							<img src="<?php echo BASE_URL.$user->profileimage; ?>"/>
						</div>
					</div><!--  in b box end-->
					<div class="info-body-name">
						<div class="in-b-name">
							<div><a href="<?php echo BASE_URL.$user->username ?>"><?php echo $user->username;?></a></div>
							<span><small><a href="<?php echo BASE_URL.$user->username ?>"><?php echo $user->email;?></a></small></span>
						</div><!-- in b name end-->
					</div><!-- info body name end-->
				</div><!-- info in body end-->
				<div class="info-in-footer">
					<div class="number-wrapper">
						<div class="num-box">
							<div class="num-head">
								Posts
							</div>
							<div class="num-body">
								<?php $getFromT->countTweets($id); ?>
							</div>
						</div>
						<div class="num-box">
							<div class="num-head">
								FOLLOWING
							</div>
							<div class="num-body">
								<span class="count-following"><?php echo $user->following; ?></span>
							</div>
						</div>
						<div class="num-box">
							<div class="num-head">
								FOLLOWERS
							</div>
							<div class="num-body">
								<span class="count-followers"><?php echo $user->followers; ?></span>
							</div>
						</div>
					</div><!-- mumber wrapper-->
				</div><!-- info in footer -->
			</div><!-- info inner end -->
		</div><!-- info box end-->

	<!--==TRENDS==-->
		<?php $getFromT->trends();?>

</div><!-- in left wrap-->
	</div><!-- in left end-->
	<div class="in-center">
		<div class="in-center-wrap">
        <!--NOTIFICATION WRAPPER FULL WRAPPER-->
        <div class="notification-full-wrapper">

        <div class="notification-full-head">
         <div>
           <a href="#">All</a>
         </div>
         <div>
           <a href="#">Mention</a>
         </div>
         <div>
           <a href="#">settings</a>
         </div>
        </div>
        <?php foreach($notification as $data) :?>
          <?php if($data->type == 'follow') :?>
        <!-- Follow Notification -->
        <!--NOTIFICATION WRAPPER-->
        <div class="notification-wrapper">
        <div class="notification-inner">
         <div class="notification-header">
           <div class="notification-img">
             <span class="follow-logo">
               <i class="fa fa-child" aria-hidden="true"></i>
             </span>
           </div>
           <div class="notification-name">
             <div>
                <img src="<?php echo BASE_URL.$data->profileimage;?>"/>
             </div>
           </div>
           <div class="notification-tweet">
           <a href="<?php echo BASE_URL.$data->username;?>" class="notifi-name"><?php echo $data->screenName;?></a><span> Followed You on - <span><?php echo $getFromU->timeAgo($data->time);?></span>
           </div>
         </div>
        </div>
        <!--NOTIFICATION-INNER END-->
        </div>
        <!--NOTIFICATION WRAPPER END-->
        <!-- Follow Notification -->
      <?php endif; ?>
      <?php if($data->type == 'like') :?>
        <!-- Like Notification -->
        <!--NOTIFICATION WRAPPER-->
        <div class="notification-wrapper">
        <div class="notification-inner">
         <div class="notification-header">
           <div class="notification-img">
             <span class="heart-logo">
               <i class="fa fa-heart" aria-hidden="true"></i>
             </span>
           </div>
           <div class="notification-name">
             <div>
                <img src="<?php echo BASE_URL.$data->profileimage;?>"/>
             </div>
           </div>
         </div>
         <div class="notification-tweet">
           <a href="<?php echo BASE_URL.$data->username;?>" class="notifi-name"><?php echo $data->screenName;?></a><span> Liked Your <?php if($data->tweetBy === $user->id){echo 'Post';}else{echo 'Retweet';} ?> On <span><?php echo $getFromU->timeAgo($data->time);?></span>
         </div>
         <div class="notification-footer">
           <div class="noti-footer-inner">
             <div class="noti-footer-inner-left">
               <div class="t-h-c-name">
                 <span><a href="<?php echo BASE_URL.$user->username;?>"><?php echo $user->screenName;?></a></span>
                 <span>@<?php echo $user->username;?></span>
                 <span><?php echo $getFromU->timeAgo($data->postedOn);?></span>
               </div>
               <div class="noti-footer-inner-right-text">
                 <?php echo $getFromT->getTweetLinks($data->status);?>
               </div>
             </div>
             <?php if (!empty($data->tweetImage)) : ?>
             <div class="noti-footer-inner-right">
               <img src="<?php echo BASE_URL.$data->tweetImage;?>"/>
             </div>
           <?php endif ?>
           </div><!--END NOTIFICATION-inner-->
         </div>
        </div>
        </div>
        <!--NOTIFICATION WRAPPER END-->
        <!-- Like Notification -->
      <?php endif; ?>
      <?php if($data->type == 'retweet') :?>
        <!-- Retweet Notification -->
        <!--NOTIFICATION WRAPPER-->
        <div class="notification-wrapper">
        <div class="notification-inner">
         <div class="notification-header">
           <div class="notification-img">
             <span class="retweet-logo">
               <i class="fa fa-retweet" aria-hidden="true"></i>
             </span>
           </div>
         <div class="notification-tweet">
           <a href="<?php echo BASE_URL.$data->username;?>" class="notifi-name"><?php echo $data->screenName;?></a>Retweet Your<?php if($data->tweetBy === $user->id){echo 'Post';}else{echo 'Retweet';} ?> On <span><?php echo $getFromU->timeAgo($data->time);?></span>
         </div>
         <div class="notification-footer">
           <div class="noti-footer-inner">

             <div class="noti-footer-inner-left">
               <div class="t-h-c-name">
                 <span><a href="<?php echo BASE_URL.$user->username;?>"><?php echo $user->screenName;?></a></span>
                 <span>@<?php echo $user->username;?></span>
                 <span><?php echo $getFromU->timeAgo($data->postedOn);?></span>
               </div>
               <div class="noti-footer-inner-right-text">
                 <?php echo $getFromT->getTweetLinks($data->status);?>
               </div>
             </div>
						 <?php if (!empty($data->tweetImage)) : ?>
             <div class="noti-footer-inner-right">
               <img src="<?php echo BASE_URL.$data->tweetImage;?>"/>
             </div>
           <?php endif ?>
           </div><!--END NOTIFICATION-inner-->
         </div>
         </div>
        </div>
        </div>
        <!--NOTIFICATION WRAPPER END-->
        <!-- Retweet Notification -->
      <?php endif;?>
      <?php if($data->type == 'mention') :?>
				<?php
				$tweet = $data;
				$likes = $getFromT->likes($id, $tweet->tweetID);
				$retweet = $getFromT->checkRetweet($tweet->tweetID, $id);
				echo ' <div class="all-tweet-inner">
								<div class="t-show-wrap">
								 <div class="t-show-inner">
									<div class="t-show-popup" data-tweet="'.$tweet->tweetID.'">
										<div class="t-show-head">
										<div class="notification-img">
											<span class="retweet-logo">
												<i class="fa fa-retweet" aria-hidden="true"></i>
											</span>
										</div>
											<div class="t-show-img">
												<img src="'.BASE_URL.$tweet->profileimage.'"/>
											</div>
											<div class="t-s-head-content">
												<div class="t-h-c-name">
													<span><a href="'.$tweet->username.'">'.$tweet->screenName.'</a> Mentioned You On </span>
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

									 </div>
									<div class="t-show-footer">
										<div class="t-s-f-right">
											<ul>
											'.(($getFromU->loginCheck() === true) ? '
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
												' : '									<li>'.(($likes['likeOn'] === $tweet->tweetID) ? '<button class="unlike-btn" data-tweet="'.$tweet->tweetID.'
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
		').'
											</ul>
										</div>
									</div>
								</div>
								</div>
								</div> ';
				 ?>
      <?php endif;?>

      <?php endforeach;?>
        </div>
        <!--NOTIFICATION WRAPPER FULL WRAPPER END-->
	    	<div class="loading-div">
	    		<img id="loader" src="<?php echo BASE_URL;?>assets/images/loading.svg" style="display: none;"/>
	    	</div>
			<div class="popupTweet"></div>
				<!--Tweet END WRAPER-->
        <script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/search.js"></script>
        <script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/hashtag.js"></script>
        <script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/like.js"></script>
        <script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/retweet.js"></script>
        <script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/popupTweets.js"></script>
        <script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/delete.js"></script>
        <script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/comment.js"></script>
        <script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/popupForm.js"></script>
        <script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/fetch.js"></script>
        <script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/message.js"></script>
        <script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/postMessage.js"></script>
        <script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/notification.js"></script>

			</div><!-- in left wrap-->
		</div><!-- in center end -->

		<div class="in-right">
			<div class="in-right-wrap">
			<?php $getFromF->whoToFollow($id);?>
 			</div><!-- in left wrap-->
		</div><!-- in right end -->
		<script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/follow.js"></script>
	</div><!--in full wrap end-->

</div><!-- in wrappper ends-->
</div><!-- inner wrapper ends-->
</div><!-- ends wrapper -->
</body>

</html>
