<?php
  include '../init.php';
  	$getFromU->preventAccess($_SERVER['REQUEST_METHOD'], realPath(__FILE__), realPath($_SERVER['SCRIPT_FILENAME']));
  if (isset($_POST['deleteTweet']) && !empty($_POST['deleteTweet'])) {
    $id = $_SESSION['id'];
    $tweet_id = $_POST['deleteTweet'];
    $getFromT->delete('tweets', array('tweetID' => $tweet_id, 'tweetBy' => $id));

  }
  if (isset($_POST['showPopup']) && !empty($_POST['showPopup'])) {
    $id = $_SESSION['id'];
    $tweet_id = $_POST['showPopup'];
    $tweet = $getFromT->getPopupTweet($tweet_id);
    ?>
    <div class="retweet-popup">
  <div class="wrap5">
    <div class="retweet-popup-body-wrap">
      <div class="retweet-popup-heading">
        <h3>Are you sure you want to delete this Tweet?</h3>
        <span><button class="close-retweet-popup"><i class="fa fa-times" aria-hidden="true"></i></button></span>
      </div>
       <div class="retweet-popup-inner-body">
        <div class="retweet-popup-inner-body-inner">
          <div class="retweet-popup-comment-wrap">
             <div class="retweet-popup-comment-head">
              <img src="<?php echo BASE_URL.$tweet->profileimage;?>"/>
             </div>
             <div class="retweet-popup-comment-right-wrap">
               <div class="retweet-popup-comment-headline">
                <a><?php echo $tweet->screenName;?> </a><span>‏@<?php echo $tweet->username.' '.$tweet->postedOn;?></br></span>
               </div>
              <br>  <div class="retweet-popup-comment-body">
                <?php echo $tweet->status.' '.$tweet->tweetImage;?>
               </div>
             </div>
          </div>
         </div>
      </div>
      <div class="retweet-popup-footer">
        <div class="retweet-popup-footer-right">
          <button class="cancel-it f-btn">Cancel</button><button class="delete-it" type="submit">Delete</button>
        </div>
      </div>
    </div>
  </div>
</div>


  <?php } ?>
