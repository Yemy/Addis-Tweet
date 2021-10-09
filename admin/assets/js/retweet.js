$(function(){
    $(document).on('click', '.retweet', function(){
      $tweet_id = $(this).data('tweet');
      $id = $(this).data('user');
      $counter = $(this).find('.retweetsCount');
      $count = $counter.text();
      $button = $(this);
      $.post('http://localhost/twitter/core/ajax/retweet.php', {showPopup:$tweet_id, id:$id}, function(data){
        $('.popupTweet').html(data);
        $('.close-retweet-popup').click(function(){
          $('.retweet-popup').hide();
        });
      });
    });

    $(document).on('click', '.retweet-it', function(){
      var comment = $('.retweetMsg').val();
      $.post('http://localhost/twitter/core/ajax/retweet.php', {retweet:$tweet_id, id:$id, comment:comment}, function(){
        $('.retweet-popup').hide();
        $count++;
        $counter.text($count);
        $button.removeClass('retweet').addClass('retweeted');
      });
    });
});
