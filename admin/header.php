<head>
    <title>Addis Chat Admin DashBoard</title>
    <meta charset="UTF-8" />
    <link rel="stylesheet" type="text/css" href="../../assets/css/font/css/font-awesome.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/font/css/font-awesome.min.css">

    <link rel="shortcut icon" type="image/ICO" href="../assets/images/favicon.ICO">

    <link rel="stylesheet" href="../assets/css/style-complete.css" />
    <!-- <link rel="stylesheet" href="../assets/css/bootstrap.min.css" /> -->

    <script src="../assets/js/jquery.min.js"></script>
    <script src="../assets/js/jquery.js"></script>

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
                            
                            <li><a href="../home.php"><i class="fa fa-home" aria-hidden="true"></i>Site</a></li>
                            <li><a href="home.php"><i class="fa fa-home" aria-hidden="true"></i>Home</a></li>
                            <li><a href="users.php"><i class="fa fa-user" aria-hidden="true"></i>Users</a></li>
                            <li><a href="#posts"><i class="fa fa-photo" aria-hidden="true"></i>Posts</a></li>
                            <li><a href="#issues"><i class="fa fa-bug" aria-hidden="true"></i>Issues</a></li>
                            <li><a href="#feedback"><i class="fa fa-comments-o" aria-hidden="true"></i>FeedBack</a></li>                                      
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
                           <!--  <li><label class="addTweetBtn">Post</label></li>
 -->
                            <li class="hover"><label class="drop-label" for="drop-wrap1"><img
                                        src="../<?php echo $user->profileimage ?>" /></label>
                                <input type="checkbox" id="drop-wrap1">
                                <div class="drop-wrap">
                                    <div class="drop-inner">
                                    <ul>
                                        <li><a href="<?php echo $user->username ?>"><?php echo $user->username ?></a>
                                            </li>
                                            <li><a href="settings/account">Settings</a></li>
                                            <li><a href="../includes/logout.php">Log out</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div><!-- nav right ends-->

                </div><!-- nav ends -->

            </div><!-- nav container ends -->

        </div><!-- header wrapper end -->

    <script src="../assets/js/jquery-3.5.1.js"></script>
    <script src="../assets/js/popper.min.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>

</body>