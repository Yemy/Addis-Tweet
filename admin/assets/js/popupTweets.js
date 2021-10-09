
$(function(){
  $(document).on('click', '.t-show-popup', function(){
    var tweet_id = $(this).data('tweet');
    $.post('http://localhost/twitter/core/ajax/popupTweets.php', {showpopup:tweet_id}, function(data){
      $('.popupTweet').html(data);
      $('.tweet-show-popup-box-cut').click(function(){
        $('.tweet-show-popup-wrap').hide();
      });
    });
  });

  $(document).on('click', '.imagePopup', function(e){
    e.stopPropagation();
    var tweet_id = $(this).data('tweet');
        $.post('http://localhost/twitter/core/ajax/imagePopup.php', {showImage:tweet_id}, function(data){
            $('.popupTweet').html(data);
            $('.close-imagePopup').click(function(){
              $('.img-popup').hide();
            });
        });
  });
});
