<?php
	include 'core/init.php';
	$id =  $_SESSION['id'];
	$user = $getFromU->userData($id);
	$notify = $getFromM->getNotificationCount($id);
	if ($getFromU->loginCheck() === false) {
		header('Location: index.php');
	}

	if (isset($_POST['tweet'])) {
		# at codecademy by yemane birhane
		$status = $getFromU->checkInput($_POST['status']);
		$tweetImage = '';
		if (!empty($status) or !empty($_FILES['file']['name'][0])) {
			if (!empty($_FILES['file']['name'][0])) {
				$tweetImage = $getFromU->uploadImage($_FILES['file']);
			}
			if (strlen($status) > 1000) {
				$error = 'you wrote too much.Please write a short description';
			}
		$tweet_id = 	$getFromU->create('tweets', array('status' => $status, 'tweetBy' => $id, 'tweetImage' => $tweetImage, 'postedOn' => date('Y-m-d H:i:s')));
			preg_match_all("/#+([a-zA-Z0-9_]+)/i", $status, $hashtag);
			if (!empty($hashtag)) {
				$getFromT->addTrend($status);
			}
			$getFromT->addMention($status, $id, $tweet_id);
		}else{
			$error = 'Please type any text or image to tweet!';
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

    <link rel="stylesheet" href="assets/css/style-complete.css" />
    <!-- <link rel="stylesheet" href="assets/css/bootstrap.min.css" /> -->

    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/jquery.js"></script>

</head>
<!-- yemi's Helvetica Neue-->

<body>
    <div class="wrapper">
        <!-- header wrapper -->
        <div class="header-wrapper">

            <div class=" bg-dark nav-container">
                <!-- Nav -->
                <div class="nav">

                    <div class="nav-left">
                        <ul>
                            
                            <li><a href="home.php"><i class="fa fa-home" aria-hidden="true"></i>Home</a></li>
                            <li><a href="<?php echo $user->username ?>"><i class="fa fa-user" aria-hidden="true"></i>Profile</a></li>

                            <li><a href="i/notifications"><i class="fa fa-bell" aria-hidden="true"></i>Notifications
                                    <span
                                        id="notification"><?php if($notify->totalN > 0){echo '<span class="span-i">'.$notify->totalN.'</span>';} ?></span>
                                </a></li>
                            <li id="messagePopup"><i class="fa fa-envelope" aria-hidden="true"></i>Messages <span
                                    id="messages"><?php if($notify->totalM > 0){echo '<span class="span-i">'.$notify->totalM.'</span>';} ?></span>
                            </li>
                        </ul>
                    </div><!-- nav left ends-->

                    <div class="nav-right">
                        <ul>
                            <li>
                                <input type="text" placeholder="Search" class="search" />
                                <i style="margin-left: -5px; color: black;" class="fa fa-search" aria-hidden="true"></i>
                                <div class="search-result">
                                </div>
                            </li>
                            <li><label class="addTweetBtn">Post</label></li>

                            <li class="hover"><label class="drop-label" for="drop-wrap1"><img
                                        src="<?php echo $user->profileimage ?>" /></label>
                                <input type="checkbox" id="drop-wrap1">
                                <div class="drop-wrap">
                                    <div class="drop-inner">
                                    <ul>
                                        <li><a href="<?php echo $user->username ?>"><?php echo $user->username ?></a>
                                            </li>
                                            <li><a href="settings/account">Settings</a></li>
                                            <li><a href="includes/logout.php">Log out</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </li>
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
                                        <img src="<?php echo $user->profilecover; ?>" />
                                    </div><!-- info in head end -->
                                    <div class="info-in-body">
                                        <div class="in-b-box">
                                            <div class="in-b-img">
                                                <!-- PROFILE-IMAGE -->
                                                <img src="<?php echo $user->profileimage; ?>" />
                                            </div>
                                        </div><!--  in b box end-->
                                        <div class="info-body-name">
                                            <div class="in-b-name">
                                                <div><a
                                                        href="<?php echo BASE_URL.$user->username ?>"><?php echo $user->username;?></a>
                                                </div>
                                                <span><small><a
                                                            href="<?php echo $user->username ?>"><?php echo $user->email;?></a></small></span>
                                            </div><!-- in b name end-->
                                        </div><!-- info body name end-->
                                    </div><!-- info in body end-->
                                    <div class="info-in-footer">
                                        <div class="number-wrapper">
                                            <div class="num-box">
                                                <div class="num-head">
                                                    TWEETS
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
                            <!--TWEET WRAPPER-->
                            <div class="tweet-wrap">
                                <div class="tweet-inner">
                                    <div class="tweet-h-left">
                                        <div class="tweet-h-img">
                                            <!-- PROFILE-IMAGE -->
                                            <img src="<?php echo $user->profileimage ?>" />
                                        </div>
                                    </div>
                                    <div class="tweet-body">
                                        <form method="post" enctype="multipart/form-data">
                                            <textarea class="status" name="status" placeholder="Type Something here!"
                                                rows="4" cols="50"></textarea>
                                            <div class="hash-box">
                                                <ul>
                                                </ul>
                                            </div>
                                    </div>
                                    <div class="tweet-footer">
                                        <div class="t-fo-left">
                                            <ul>
                                                <input type="file" name="file" id="file" />
                                                <li><label for="file"><i class="fa fa-camera"
                                                            aria-hidden="true"></i></label>
                                                    <span class="tweet-error"><?php if (isset($error)) {
						 				echo $error;
						 			}else if (isset($imageError)) {
						 				echo $imageError;
						 			} ?></span>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="t-fo-right">
                                            <span id="count">1000</span>
                                            <input type="submit" name="tweet" value="Post" />
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--TWEET WRAP END-->


                            <!--Tweet SHOW WRAPPER-->
                            <div class="tweets">
                                <?php $getFromT->tweets($id,4); ?>
                            </div>
                            <!--TWEETS SHOW WRAPPER-->

                            <div class="loading-div">
                                <img id="loader" src="assets/images/loading.svg" style="display: none;" />
                            </div>
                            <div class="popupTweet"></div>
                            <!--Tweet END WRAPER-->
                            <script type="text/javascript" src="assets/js/search.js"></script>
                            <script type="text/javascript" src="assets/js/hashtag.js"></script>
                            <script type="text/javascript" src="assets/js/like.js"></script>
                            <script type="text/javascript" src="assets/js/retweet.js"></script>
                            <script type="text/javascript" src="assets/js/popupTweets.js"></script>
                            <script type="text/javascript" src="assets/js/delete.js"></script>
                            <script type="text/javascript" src="assets/js/comment.js"></script>
                            <script type="text/javascript" src="assets/js/popupForm.js"></script>
                            <script type="text/javascript" src="assets/js/fetch.js"></script>
                            <script type="text/javascript" src="assets/js/message.js"></script>
                            <script type="text/javascript" src="assets/js/postMessage.js"></script>
                            <script type="text/javascript" src="assets/js/notification.js"></script>

                        </div><!-- in left wrap-->
                    </div><!-- in center end -->

                    <div class="in-right">
                        <div class="in-right-wrap">
                            <?php $getFromF->whoToFollow($id);?>
                        </div><!-- in left wrap-->
                    </div><!-- in right end -->
                    <script type="text/javascript" src="assets/js/follow.js"></script>
                </div>
                <!--in full wrap end-->

            </div><!-- in wrappper ends-->
        </div><!-- inner wrapper ends-->
    </div><!-- ends wrapper -->


    <script src="assets/js/jquery-3.5.1.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>

</body>

</html>