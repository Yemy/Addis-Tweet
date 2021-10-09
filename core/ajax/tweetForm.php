<?php
	include '../init.php';
	$getFromU->preventAccess($_SERVER['REQUEST_METHOD'], realPath(__FILE__), realPath($_SERVER['SCRIPT_FILENAME']));
 ?>
 <!-- POPUP TWEET-FORM WRAP -->
<div class="popup-tweet-wrap">
		<div class="wrap">

		<div class="popwrap-inner">
			<div class="popwrap-header">
				<div class="popwrap-h-left">
					<h4>Post your feeling</h4>
				</div>
				<span class="popwrap-h-right">
					<label class="closeTweetPopup" for="pop-up-tweet" ><i class="fa fa-times" aria-hidden="true"></i></label>
				</span>
			</div>
			<div class="popwrap-full">
			 <form id="popupForm" method="POST" enctype="multipart/form-data">
				<div class="popwrap-body">
				 <textarea class="status" name="status" maxlength="141" placeholder="Type Something here!" rows="4" cols="50"></textarea>
				 	<div class="hash-box">
				 		<ul>
				 		</ul>
				 	</div>
				</div>
				<div class="popwrap-footer">
				 	<div class="t-fo-left">
				 		<ul>
				 			<input type="file" name="file" id="file">
		 					<li><label for="file"><i class="fa fa-camera" aria-hidden="true"></i></label></li>
 				 		</ul>
				 	</div>
				 	<div class="t-fo-right">
			 			<span id="count">1000</span>
	 					<input type="submit"  id="post" name="addTweet" value="Post"/>
				 	</div>
			 	</form>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- POPUP TWEET-FORM END -->
