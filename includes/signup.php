<?php

	include('../core/init.php');

	 if (isset($_POST['signup'])){
	 	$email = $_POST['email'];
	 	$password = $_POST['password'];
	 	$screenName = $_POST['screenName'];
	 	$error = "";
	 	if(empty($screenName) or empty($email) or empty($password) ){
	 		$error = "Please fill out all the fields";
	 	}else{
	 		$email = $getFromU->checkInput($email);
	 		$password = $getFromU->checkInput($password);
	 		$screenName = $getFromU->checkInput($screenName);
	 		if(!filter_var($email)){
	 			$error = 'Invalid Email';
	 		}elseif (strlen($password) < 6) {
	 			$error = 'Password is too Short';
	 		}elseif (strlen($screenName) > 25) {
	 			$error = "Your Name is too Long";
	 		}else{
	 			if($getFromU->checkEmail($email) === true){
	 				$error = 'Email is already Taken';
	 			}else{
	 				// $id = $getFromU->create('users', array('email' => $email, 'password' => $password, 'screenName' => $screenName, 'profileimage' => 'assets/images/defaultprofileimage.PNG', 'profilecover' => 'assets/images/defaultCoverImage.png'));
	 				// $_SESSION['id'] = $id;
	 				// header("Location: includes/signup1.php?step=1");

	 				$getFromU->register($email, $screenName, $password);
	 				header('Location: ../home.php');
	 				// header("Location: includes/signup1.php?step=1");
	 			}
	 		}
	 	}

	 }
 ?>

<html>
<head>
<title>AddisChat Signup Page </title>  
	<link rel="stylesheet" type="text/css" href="../assets/css/font/css/font-awesome.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/font/css/font-awesome.min.css">
   <link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.min.css">    
	<link rel="stylesheet" href="../assets/css/style-complete.css"/> 
    <link rel="stylesheet" type="text/css" href="../assets/css/signup-style.css">
    <link rel="shortcut icon" type="image/ICO" href="../assets/images/favicon.ICO">
</head>

<!-- header wrapper -->
<div class="header-wrapper navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    
    <div class="nav-container">
        <!-- Nav -->
<div class="nav">
              <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggle" aria-controls="navbarToggle" aria-expanded="false" aria-label="Toggle navigation">
       <span class="navbar-toggler-icon"></span>
        </button>
                 <div class="collapse navbar-collapse" id="navbarToggle">
          <div class="navbar-nav mr-auto">
            </div>
    <div class="nav-left">
    <ul>                         
     <!-- <li class="navbar-brand mr-4" href="index.php"><img style="background: transparent; width: 100px; height: 60px;" src="assets/images/logo.jpg">  </li> -->
        <li class="logo" style="background: transparent;"><img src="../assets/images/logo.png"></li>
         <!-- <li class="navbar-brand mr-4">ADDIS CHAT </li> -->
        <li><a href="../home.php"><i class="fa fa-home" aria-hidden="true"></i>Home</a></li>
        <li class="nav-item nav-link"> <a href="login.php"><i class="fa fa-sign-in" aria-hidden="true"></i> Login</a></li>
        <li class="nav-item nav-link"><a href="signup.php"><i class="fa fa-user-plus" aria-hidden="true"></i> Register</a></li>        
                </ul>
            </div><!-- nav left ends-->

    <div class="nav-right">
    <ul>
        <li class="nav-item nav-link"> <a href="#about"><i class="fa fa-info-circle" style="margin-right: -18px; color: gray;"></i> About</a></li>
                </ul>
            </div><!-- nav right ends-->

        </div><!-- nav ends -->
    </div>
    </div><!-- nav container ends -->

</div><!-- header wrapper end -->

<body style="background: url(../assets/images/pic1.jpg)">
	<br><br>
    <div id="login-box">
      <div class="left-box">
        <h1> Sign Up</h1>
          <form method="post">
          <input type="text" name="screenName" placeholder="Username"/>
          <input type="text" name="email" placeholder="Email"/>
          <input type="password" name="password" placeholder="Password"/>
          <!-- <input type="password" name="password2" placeholder="Retype password"/> -->
        
          <input id="signup"  type="submit" name="signup" value="Sign Up" style="background: green;" />
          <!-- <input id="signin" type="submit" name="signin" value="Sign In"/> -->
		<?php
			if(isset($error)){
				echo '<li class="error-li">
					  <div class="span-fp-error">'.$error.'</div>
					 </li>';
			}
		 ?>
        </form>
        </div>
        <div class="right-box">
          <span class="signinwith">Sign in with<br/>Social Network     </span>
        
        <button class="social facebook"><i class="fa fa-facebook" aria-hidden="true"></i>  Log in with Facebook</button>    
        <button class="social twitter"><i class="fa fa-twitter" aria-hidden="true"></i>  Log in with Twitter</button> 
        <button class="social google"><i class="fa fa-google" aria-hidden="true"></i>  Log in with Google+</button> 
            
        
        </div>
        <div class="or">OR</div>
    </div>
    
<!-- footer -->
  <div id="footer" class="footer footer-expand-md footer-dark bg-dark text-white ">
    <br>
     <div class="container">
       <small>
         <a href="https://yemybold.herokuapp.com/help" target="_blank"> <img src="../assets/images/help.ICO" alt="need"> Help</a>
         <a href="#feedback" target="_blank"> <img src="../assets/images/feedback.png" alt="need">FeedBack</a>
         <a href="#issues" target="_blank"> <img src="../assets/images/Problem.png" alt="need">Report a bug/Problem</a>

       <strong class="container"> Copyright &copy; <script>document.write(new Date().getFullYear());</script> | Developed @<a href="https://www.dec.edu.et" target="_blank">Defence University, College of Engineering</a> Developed By <a href="www.yemybold.herokuapp.com">Yemi_Bold</a> </strong>
     </small>
      <br><br>

      <div class="popover-x-marker" style="display: none;"></div>    <div class="pull-right hidden-xs">
            Developers: 
               <!--  <img src="#" alt="image" id="ppww" class="img img-circle profilePopover" style="cursor: pointer;" width="30px" height="35px"> -->
                <strong>Yemane Birhane, Sam and Samri</strong><hr>
            </div>

    </div>
<!-- include font awesome for this section  Yemi -->
   <div style="background-color: black;">
     <div id="contact-us"><hr>
        Contact Us Via:
        <a href="https://www/facebook.com/yemi bold"><i class="fa fa-facebook" aria-hidden="true"></i> FaceBook  </a>
        <a href="https://www/instagram.com/yemi bold" style="color: #dd4b39;"><i class="fa fa-instagram" aria-hidden="true"></i> Instagram  </a>
        <a href="https://www/twitter.com/yemi bold"  style="color: #55acee;"><i class="fa fa-twitter" aria-hidden="true"></i> Twitter  </a>
        <a href="https://www/whatsup.com/yemi bold" style="color: green;"><i class="fa fa-whatsapp" aria-hidden="true"></i> WhatsUp</a><hr><hr>
    </div>
  </div>
</div>
<!-- footer end -->


</body>    
</html>
