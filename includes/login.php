<?php
	
	include('../core/init.php');
	
	if (isset($_POST['login']) && !empty($_POST['login'])){
		$email = $_POST['email'];
		$password = $_POST['password'];

		if (!empty($email) or !empty($password)) {
			$email = $getFromU->checkInput($email);
			$password = $getFromU->checkInput($password);
			if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
				$error = "Invalid Email";
			}else{
				if($getFromU->login($email, $password) == false){
					$error = "Incorrect Email or Password.";
				}
			}
		}else{
			$error = "Please fill out Email and Password.";
		}
	}
 ?>

<html>
<head>
<title>AddisChat Login Page</title>
			<link rel="stylesheet" type="text/css" href="../assets/css/font/css/font-awesome.css">
    <link rel="shortcut icon" type="image/ICO" href="../assets/images/favicon.ICO">            
    <link rel="stylesheet" type="text/css" href="../assets/css/font/css/font-awesome.min.css">
       <link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.min.css">
		<link rel="stylesheet" href="../assets/css/style-complete.css"/>
<style>
body{
    margin: 0;
    padding: 0;
    background: url(../assets/images/pic1.jpg);
    background-size: cover;
    background-position: center;
    font-family: sans-serif;
}

.loginbox{
    width: 320px;
    height: 420px;
    background: #000;
    color: #fff;
    top: 50%;
    left: 50%;
    position: absolute;
    transform: translate(-50%,-50%);
    box-sizing: border-box;
    padding: 70px 30px;
}

.avatar{
    width: 100px;
    height: 100px;
    border-radius: 50%;
    position: absolute;
    top: -50px;
    left: calc(50% - 50px);
}

h1{
    margin: 0;
    padding: 0 0 20px;
    text-align: center;
    font-size: 22px;
}

.loginbox p{
    margin: 0;
    padding: 0;
    font-weight: bold;
}

.loginbox input{
    width: 100%;
    margin-bottom: 20px;
}

.loginbox input[type="text"], input[type="password"]
{
    border: none;
    border-bottom: 1px solid #fff;
    background: transparent;
    outline: none;
    height: 40px;
    color: #fff;
    font-size: 16px;
}
.loginbox input[type="submit"]
{
    border: none;
    outline: none;
    height: 40px;
    background: #fb2525;
    color: #fff;
    font-size: 18px;
    border-radius: 20px;
}
.loginbox input[type="submit"]:hover
{
    cursor: pointer;
    background: green;
    color: #000;
}
.loginbox a{
    text-decoration: none;
    font-size: 12px;
    line-height: 20px;
    color: darkgrey;
}

.loginbox a:hover
{
    color: #ffc107;
}

    </style>
    </head>
    <body>
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
	

	<br><br>
    <div class="loginbox" style="margin-top: 35px;">
    <img src="../assets/images/avatar.png" class="avatar">
        <h1>Login Here</h1>
        <form method="post">
            <p>Email</p>
            <input type="text" name="email" placeholder="Enter Email">
            <p>Password</p>
            <input type="password" name="password" placeholder="Enter Password">
            <input type="submit" name="login" value="Login" ><br>
            <a href="forgetpass.html">Lost your password?</a><br>
            <a href="signup.php">Don't have an account?</a>

        </form>        
    </div>
    
    <!-- footer -->
  <div id="footer" class="footer footer-expand-md footer-dark bg-dark text-white " style="top: 100%; width: 100%; position: absolute;">
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

