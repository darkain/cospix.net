'use strict';


(function($) {

	$.fn.afNewComment = function() {
		$(this).each(function(index, item) {

			if ($(item).hasClass('af-new-comment')) return;
			$(item).addClass('af-new-comment');

			$(item).keypress(function(e){
				if (e.which != 13) return;
				var that = this;

				$.post(
					urlbase + '/comment',
					$(this).closest('.cpn-comment-new').afSerialize(),
					function(data){
						$(data).insertBefore( $(that).closest('.cpn-comment-new') );
						$(that).val('').prop('disabled', false);
					}
				);

				$(this).prop('disabled', true);
			});

		});
	};

})(jQuery);


$(function(){$('.cpn-comment-new input').afNewComment();});