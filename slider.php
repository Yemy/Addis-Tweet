
<head>
<style>
* {box-sizing: border-box;}
body {font-family: Verdana, sans-serif;}
.mySlides {display: none;}
img {vertical-align: middle;}

/* Slideshow container */
.slideshow-container {
  max-width: 1000px;
  position: relative;
  margin: auto;
}

/* Caption text */
.text {
  color: black;
  font-size: 15px;
  padding: 8px 12px;
  position: absolute;
  bottom: 50px;
  width: 100%;
  text-align: center;
}

/* Number text (1/3 etc) */
.numbertext {
  color: #f2f2f2;
  font-size: 12px;
  padding: 8px 12px;
  position: absolute;
  top: 0;
}

/* The dots/bullets/indicators */
.dot {
  height: 15px;
  width: 15px;
  margin: 0 2px;
  background-color: #bbb;
  border-radius: 50%;
  display: inline-block;
  transition: background-color 0.6s ease;
}

.active {
  background-color: #717171;
}

/* Fading animation */
.fade {
  -webkit-animation-name: fade;
  -webkit-animation-duration: 3.5s;
  animation-name: fade;
  animation-duration: 3.5s;
}

@-webkit-keyframes fade {
  from {opacity: .4}
  to {opacity: 1}
}

@keyframes fade {
  from {opacity: .4}
  to {opacity: 1}
}

/* On smaller screens, decrease text size */
@media only screen and (max-width: 300px) {
  .text {font-size: 11px}
}
</style>
</head>
<body>

<div class="slideshow-container" style="margin-top: 30px;">

<div class="mySlides fade">
  <div class="numbertext">1 / 5</div>
  <img src="assets/images/screenshot1.PNG" style="width:100%">
  <div class="text">    <h2>Well Come to ADDIS CAHT a place where you enjoy, communicate and have fun with your friends!</h2></div>
</div>

<div class="mySlides fade">
  <div class="numbertext">2 / 5</div>
  <img src="assets/images/screenshot2.PNG" style="width:100%">
  <div class="text"><h2>ADDIS CAHT a place where you Enjoy, Communicate and Chat with your friends!</h2></div>
</div>

<div class="mySlides fade">
  <div class="numbertext">3 / 5</div>
  <img src="assets/images/screenshot3.PNG" style="width:100%">
  <div class="text"><h2>ADDIS CAHT a place where you Share your Toughts, Like and Connect with your friends!</h2></div>
</div>

<div class="mySlides fade">
  <div class="numbertext">4 / 5</div>
  <img src="assets/images/screenshot4.PNG" style="width:100%">
  <div class="text"><h2>ADDIS CAHT a place where you search your friends and chat!</h2></div>
</div>

<div class="mySlides fade">
  <div class="numbertext">5 / 5</div>
  <img src="assets/images/screenshot5.PNG" style="width:100%">
  <div class="text"><h2>ADDIS CAHT a place where you get notice how your friends are doing!</h2></div>
</div>

</div>
<br>

<div style="text-align:center">
  <span class="dot"></span>
  <span class="dot"></span>
  <span class="dot"></span>
  <span class="dot"></span>
  <span class="dot"></span>
</div>

<script>
var slideIndex = 0;
showSlides();

function showSlides() {
  var i;
  var slides = document.getElementsByClassName("mySlides");
  var dots = document.getElementsByClassName("dot");
  for (i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";
  }
  slideIndex++;
  if (slideIndex > slides.length) {slideIndex = 1}
  for (i = 0; i < dots.length; i++) {
    dots[i].className = dots[i].className.replace(" active", "");
  }
  slides[slideIndex-1].style.display = "block";
  dots[slideIndex-1].className += " active";
  setTimeout(showSlides, 3000); // Change image every 3 seconds
}
</script>

</body>
