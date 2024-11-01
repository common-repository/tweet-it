(function($) {
	$(document).ready(function() {
		$('.custom-addthis-custom').click(function() {
			try{event.preventDefault()} catch(e) {}
			window.dynamicAddThis.openShareWindow($(this).attr('href'),$(this).parent().hasClass('email') || $(this).parent().hasClass('addthis'));
			return false;
		});
	});

	window.dynamicAddThis = {
		openShareWindow: function(shareLink,isAddThis) {
			var width = 675;
			var height = 300;
			if (isAddThis) {
				width = 476;
				height = 702;
			}
			window.open(shareLink,"_blank","location=0,status=1,scrollbars=1,width="+width+",height="+height);
		}
	}
})(jQuery);