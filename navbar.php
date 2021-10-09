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
                <li><input type="text" placeholder="Search" class="search"/><i class="fa fa-search" aria-hidden="true"></i>
                    <div class="search-result">
                    </div>
                </li>
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
                <li><label for="pop-up-tweet" class="addTweetBtn">Post</label></li>
            <?php }else{
                echo '<li><a href="'.BASE_URL.'index.php">I Have account, Sign in</a></li>';
            } ?>
            </ul>
        </div><!-- nav right ends-->

    </div><!-- nav ends -->
    </div><!-- nav container ends -->
</div><!-- header wrapper end -->