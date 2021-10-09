<?php
	include 'core/init.php';
	$id = $_SESSION['id'];
	$user = $getFromU->userData($id);
	$notify = $getFromM->getNotificationCount($id);
	if ($getFromU->loginCheck() === false) {
	header('Location: '.BASE_URL.'index.php');
	}
	if (isset($_POST['submit'])) {
		$currentPwd = $_POST['currentPwd'];
		$newPassword = $_POST['newPassword'];
		$rePassword = $_POST['rePassword'];
		$error = array();
		if (!empty($currentPwd) && !empty($newPassword) && !empty($rePassword)) {
			if ($getFromU->checkPassword($currentPwd) === true) {
				if (strlen($newPassword < 6)) {
					$error['newPassword'] = 'new password is too short';
				}else if ($newPassword != $rePassword) {
					$error['rePassword'] = 'password does not match';
				}else{
					$getFromU->update('users', $id, array('password' => md5($newPassword)));
					header('Location: '.BASE_URL.$user->username);
				}
			}else{
				$error['currentPwd'] = 'incorrect password';
			}
		}else{
			$error['fields'] = 'please fill out all the fields';
		}
	}
 ?>

<html>
	<head>
		<title>Account settings page</title>
		<meta charset="UTF-8" />
		<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.css"/> -->
		<link rel="shortcut icon" type="image/ICO" href="assets/images/favicon.ICO">
		<link rel="stylesheet" type="text/css" href="<?php echo BASE_URL;?>assets/css/font/css/font-awesome.css">
    	<link rel="stylesheet" type="text/css" href="<?php echo BASE_URL;?>assets/css/font/css/font-awesome.min.css">
		<!-- <script src="https://code.jquery.com/jquery-1.10.2.js"></script> -->
		<script src="<?php echo BASE_URL;?>assets/js/jquery.min.js"></script>
   		<script src="<?php echo BASE_URL;?>assets/js/jquery.js"></script>
		<link rel="stylesheet" href="<?php echo BASE_URL;?>assets/css/style-complete.css"/>
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
      	      <li>
                <input type="text" placeholder="Search" class="search" />
                                <i style="margin-left: -5px; color: black;" class="fa fa-search" aria-hidden="true"></i>
                <div class="search-result">
                </div></li>
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
	<script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/popupForm.js"></script>
	<script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/search.js"></script>
	<script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/hashtag.js"></script>
	<script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/delete.js"></script>
	<script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/message.js"></script>
	<script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/notification.js"></script>

	<div class="container-wrap">
		<div class="lefter">
			<div class="inner-lefter">

				<div class="acc-info-wrap">
					<div class="acc-info-bg">
						<!-- PROFILE-COVER -->
						<img src="<?php echo BASE_URL.$user->profilecover;?>"/>
					</div>
					<div class="acc-info-img">
						<!-- PROFILE-IMAGE -->
						<img src="<?php echo BASE_URL.$user->profileimage;?>"/>
					</div>
					<div class="acc-info-name">
						<h3><?php echo $user->screenName;?></h3>
						<span><a href="<?php echo BASE_URL.$user->username;?>">@<?php echo $user->username;?></a></span>
					</div>
				</div><!--Acc info wrap end-->

				<div class="option-box">
					<ul>
						<li>
							<a href="<?php echo BASE_URL;?>settings/account" class="bold">
							<div>
								Account
								<span><i class="fa fa-angle-right" aria-hidden="true"></i></span>
							</div>
							</a>
						</li>
						<li>
							<a href="<?php echo BASE_URL;?>settings/password">
							<div>
								Password
								<span><i class="fa fa-angle-right" aria-hidden="true"></i></span>
							</div>
							</a>
						</li>
					</ul>
				</div>

			</div>
		</div><!--LEFTER ENDS-->

	<div class="righter">
		<div class="inner-righter">
			<div class="acc">
				<div class="acc-heading">
					<h2>Password</h2>
					<h3>Change your password or recover your current one.</h3>
				</div>
				<form method="POST">
				<div class="acc-content">
					<div class="acc-wrap">
						<div class="acc-left">
							Current password
						</div>
						<div class="acc-right">
							<input type="password" name="currentPwd"/>
							<span>
								<?php if (isset($error['currentPwd'])) {
										echo $error['currentPwd'];
									} ?>
							</span>
						</div>
					</div>

					<div class="acc-wrap">
						<div class="acc-left">
							New password
						</div>
						<div class="acc-right">
							<input type="password" name="newPassword" />
							<span>
								<?php if (isset($error['newPassword'])) {
										echo $error['newPassword'];
									} ?>
							</span>
						</div>
					</div>

					<div class="acc-wrap">
						<div class="acc-left">
							Verify password
						</div>
						<div class="acc-right">
							<input type="password" name="rePassword"/>
							<span>
								<?php if (isset($error['rePassword'])) {
										echo $error['rePassword'];
									} ?>
							</span>
						</div>
					</div>
					<div class="acc-wrap">
						<div class="acc-left">
						</div>
						<div class="acc-right">
							<input type="Submit" name="submit" value="Save changes"/>
						</div>
						<div class="settings-error">
							<?php if (isset($error['fields'])) {
										echo $error['fields'];
									} ?>
 						</div>
					</div>
				 </form>
				</div>
			</div>
			<div class="content-setting">
				<div class="content-heading">

				</div>
				<div class="content-content">
					<div class="content-left">

					</div>
					<div class="content-right">

					</div>
				</div>
			</div>
		</div>
	</div>
	<!--RIGHTER ENDS-->
	<div class="popupTweet">
						<script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/postMessage.js"></script>
	</div>
</div>
<!--CONTAINER_WRAP ENDS-->
</div>
<!-- ends wrapper -->
</body>
</html>
