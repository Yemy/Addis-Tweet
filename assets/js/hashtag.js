$(function(){
	var regx = /[#|@](\w+)$/ig;
	$(document).on('keyup','.status', function(){
		var content = $.trim($(this).val());
		var txt = content.match(regx);
		var max = 1000;

		if (txt != null) {
			var dataStr = 'hashtag='+txt;
			$.ajax({
				type:"POST",
				url:"http://localhost/twitter/core/ajax/getHashtag.php",
				data: dataStr,
				cache: false,
				success: function(data){
					$('.hash-box ul').html(data);
					$('.hash-box li').click(function(){
					var value = $.trim($(this).find('.getValue').text());
					var oldContent = $('.status').val();
					var newContent = oldContent.replace(regx, ""); 
					$('.status').val(newContent+value+' ');
					$('.hash-box li').hide();
					$('.status').focus();
					$('#count').text(max - content.length);
					});
				}
			});
		}else{
			$('.hash-box li').hide();
		}
		$('#count').text(max - content.length);
		if (content.length === max) {
			$('#count').css('color', '#f00');
		}else{
			$('#count').css('color', '#000');
		}
	});
});