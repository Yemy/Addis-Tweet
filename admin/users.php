
<?php 
    include '../core/init.php';
    // $users = $getFromU->getAllList();
    if ($getFromU->loginCheck() === false) {
    header('Location: '.BASE_URL.'index.php');
    }
?>


<!DOCTYPE html>
<html>
<head>
    <title>Addis Chat Admin DashBoard</title>
    <meta charset="UTF-8" />
    <link rel="stylesheet" type="text/css" href="../../assets/css/font/css/font-awesome.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/font/css/font-awesome.min.css">

    <link rel="shortcut icon" type="image/ICO" href="../assets/images/favicon.ICO">
   <link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/style-complete.css" />
    <link rel="stylesheet" type="text/css" href="style.css">
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
                            <li><a href="posts.php"><i class="fa fa-photo" aria-hidden="true"></i>Posts</a></li>
                            <li><a href="#issues"><i class="fa fa-bug" aria-hidden="true"></i>Issues</a></li>
                            <li><a href="#feedback"><i class="fa fa-comments-o" aria-hidden="true"></i>FeedBack</a></li>                                      
                        </ul>
                    </div><!-- nav left ends-->

                    <div class="nav-right">
                        <ul>
                         <!--    <li>
                                <input type="text" placeholder="Search" class="search" />
                                <i style="margin-left: -5px; color: black;" class="fa fa-search" aria-hidden="true"></i>
                                <div class="search-result">
                                </div>
                            </li> -->
                           <!--  <li><label class="addTweetBtn">Post</label></li>
 -->
                            <!-- <li class="hover"><label class="drop-label" for="drop-wrap1"><img
                                        src="../<?php echo $user->profileimage ?>" /></label>
                                <input type="checkbox" id="drop-wrap1">
                                <div class="drop-wrap">
                                    <div class="drop-inner">
                                    <ul>
                                        <li><a href="../<?php echo $user->username ?>"><?php echo $user->username ?></a>
                                            </li>
                                            <li><a href="settings/account">Settings</a></li>
                                            <li><a href="../includes/logout.php">Log out</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </li> -->
                        </ul>
                    </div><!-- nav right ends-->

                </div><!-- nav ends -->

            </div><!-- nav container ends -->

        </div><!-- header wrapper end -->
        <div>  

        <?php 
                $sql = "SELECT * FROM users ";
    $query = $pdo -> prepare($sql);
    $query->execute();
    $users=$query->fetchAll(PDO::FETCH_OBJ);
    $count = 0;
    $rep  = "";
    if($query->rowCount() > 0)
    {
    // echo "here";
   echo " <br><br><br><br><br><h2 align='center'>List of All Registered Users</h2><br>
            <table class='table table-condensed table-striped table-bordered table-sm'>
                <thead style='background-color:#8D1'>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Name</th>
                    <th>following</th>
                    <th>followers</th>
                    <th>Role</th>
                    <th>Option</th>
                </thead>
                <tbody>
                    {$rep}
                </tbody>
            </table>";
    foreach ($users as $user) {
            // echo "here";

        $option = "
        <button class='btn btn-primary btn-xs btn-link' title=' Update this record' onclick='updateRecord({$user->id});return false;'>Suspend</button>
        <button class='btn btn-warning btn-xs btn-link' title='Delete this record' onclick='deleteRecord({$user->id});return false;'>Delete</button>";
echo 
        "<table class='table table-condensed table-striped table-bordered table-sm'>
        <tbody>
            <tr align-text='center'><br><br>
                    <td>{$user->id}</td>
                    <td>{$user->username}</td>
                    <td>{$user->email}</td>
                    <td>{$user->screenName}</td>
                    <td>{$user->following}</td>
                    <td>{$user->followers}</td>
                    <td>{$user->country}</td>
                    <td>{$user->website}</td>
                    <td>{$user->role}</td>
                    <td>{$option}</td>                    
                </tr>
                </tbody>
        </table>";
    }

}else{
    $content = "<p class='bg-warning'>No User Record found yet!</p>";
}
         ?>
        </div>

    <script src="../assets/js/jquery-3.5.1.js"></script>
    <script src="../assets/js/popper.min.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>

</body>
</html>

