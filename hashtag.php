<?php
  include 'core/init.php';
  if (isset($_GET['hashtag']) && !empty($_GET['hashtag'])) {
    $hashtag = $getFromU->checkInput($_GET['hashtag']);
    $id = @$_SESSION['id'];
    $user = $getFromU->userData($id);
    $tweets = $getFromT->getTweetByHash($hashtag);
    $accounts = $getFromT->getUserByHash($hashtag);
	$notify = $getFromM->getNotificationCount($id);
  }else {
    header('Location: '.BASE_URL.' index.php');
  }

 ?>
 <!doctype html>
 <html>
 	<head>
 		<title><?php echo '#', $hashtag. 'Hashtags On Addis Chat';?></title>
 		<meta charset="UTF-8" />
  		<link rel="stylesheet" href="<?php echo BASE_URL;?>assets/css/style-complete.css"/>
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
                <li><input type="text" placeholder="Search" class="search"/><i class="fa fa-search" aria-hidden="true"></i>
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

 <!--#hash-header-->
 <div class="hash-header">
 	<div class="hash-inner">
 		<h1>Tag #<?php echo $hashtag; ?></h1>
 	</div>
 </div>
 <!--#hash-header end-->

 <!--hash-menu-->
 <div class="hash-menu">
 	<div class="hash-menu-inner">
 		<ul>
  			<li><a href="<?php echo BASE_URL.'hashtag/'.$hashtag;?>">Latest</a></li>
 			<li><a href="<?php echo BASE_URL.'hashtag/'.$hashtag.'?f=users';?>">Accounts</a></li>
 			<li><a href="<?php echo BASE_URL.'hashtag/'.$hashtag.'?f=photos';?>">Photos</a></li>
   		</ul>
 	</div>
 </div>
 <!--hash-menu-->
 <!---Inner wrapper-->

 <div class="in-wrapper">
 	<div class="in-full-wrap">

 		<div class="in-left">
 			<div class="in-left-wrap">

 			   <!-- Who TO Follow -->
         <?php $getFromF->whoToFollow($id); ?>

 			   <!--TRENDS-->
         <?php $getFromT->trends(); ?>

 			</div>
 			<!-- in left wrap-->
 		</div>
 		<!-- in left end-->

 <!-- TWEETS IMAGES  -->
  <?php if(strpos($_SERVER['REQUEST_URI'], '?f=photos')): ?>
  <div class="hash-img-wrapper">
  	<div class="hash-img-inner">
      <?php foreach ($tweets as $tweet) {
        $likes = $getFromT->likes($id, $tweet->tweetID);
        $retweet = $getFromT->checkRetweet($tweet->tweetID, $id);
        $user = $getFromU->userData($tweet->retweetBy);
        if (!empty($tweet->tweetImage)) {
          echo '<div class="hash-img-flex">
            		 	<img src="'.BASE_URL.$tweet->tweetImage.'" class="imagePopup" data-tweet="'.$tweet->tweetID.'"/>
            		 	<div class="hash-img-flex-footer">
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
            		</div>';
        }
      } ?>

 	</div>
 </div>
   <!--TWEETS ACCOUTS-->
 <?php elseif(strpos($_SERVER['REQUEST_URI'], '?f=users')): ?>
 <div class="wrapper-following">
 <div class="wrap-follow-inner">
   <?php foreach($accounts as $users) : ?>
  <div class="follow-unfollow-box">
 	<div class="follow-unfollow-inner">
 		<div class="follow-background">
 			<img src="<?php echo BASE_URL.$users->profilecover;?>"/>
 		</div>
 		<div class="follow-person-button-img">
 			<div class="follow-person-img">
 			 	<img src="<?php echo BASE_URL.$users->profileimage;?>"/>
 			</div>
 			<div class="follow-person-button">
 			   <?php echo $getFromF->followBtn($users->id, $id);?>
 			</div>
 		</div>
 		<div class="follow-person-bio">
 			<div class="follow-person-name">
 				<a href="<?php echo BASE_URL.$users->username;?>"><?php echo $users->screenName;?></a>
 			</div>
 			<div class="follow-person-tname">
 				<a href="<?php echo BASE_URL.$users->username;?>">@<?php echo $users->username;?></a>
 			</div>
 			<div class="follow-person-dis">
 			    <?php echo $getFromT->getTweetLinks($users->bio);?>
 			</div>
 		</div>
 	</div>
 </div>
<?php endforeach;?>
 </div>
 </div>
 <!-- TWEETS ACCOUNTS -->
<?php else :?>
 	 <div class="in-center">
 		<div class="in-center-wrap">
 		<!-- TWEETS -->
    <?php
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
    												<span>'.$getFromU->timeAgo($tweet->postedOn).'</span>
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
    	} ?>
 		</div>
 	</div>

<?php endif; ?>
<div class="popupTweet"></div>
<script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/like.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/retweet.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/popupTweets.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/delete.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/comment.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/popupForm.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/fetch.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/search.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/hashtag.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/message.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/postMessage.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/notification.js"></script>
</div>
 	</div><!--in full wrap end-->
 </div><!-- in wrappper ends-->

 </div><!-- ends wrapper -->
</body>
</html>
