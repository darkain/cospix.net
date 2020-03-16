'use strict';


(function($) {
	$.fn.hasScrollBar = function() {
		var item = this.get(0);
		return item.scrollHeight > item.clientHeight;
	}
})(jQuery);


////////////////////////////////////////////////////////////////////////////////
//UPDATE SIDEBAR HIGHLIGHTED ITEM
////////////////////////////////////////////////////////////////////////////////
function update_sidebar() {
	var path = document.location.pathname;

	$('.prometheus-sidebar-selected')
		.removeClass('prometheus-sidebar-selected');

	var link	= $('#prometheus-sidebar a[href$="'+path+'"]');
	var limit	= 0;
	while (!link.length) {
		if (limit++ > 10) break;
		path	= path.substr(0, path.lastIndexOf('/'));
		link	= $('#prometheus-sidebar a[href$="'+path+'"]');
	}

	link.addClass('prometheus-sidebar-selected');
}
update_sidebar();




$(function(){
	update_sidebar();

	////////////////////////////////////////////////////////////////////////////
	//SCROLL SIDEBAR AUTOMATICALLY ON PAGE SCROLL
	////////////////////////////////////////////////////////////////////////////
	var scroll_pos = $(window).scrollTop();
	$(window).scroll(function(){
		var pos = $(window).scrollTop();
		if (pos - scroll_pos == 0) return;

		var div = $('#prometheus-sidebar');
		div.scrollTop( div.scrollTop() + (pos - scroll_pos) );
		scroll_pos = pos;
	});



	$(window).on('wheel', function(event) {
		if ($('#body').hasClass('disabled')) {
			if (!$.contains($('#cospix-message-list').get(0), event.target)) {
				event.preventDefault();
				return false;
			}
		}
		return true;
	});


	$('#cospix-user-messages').click(function(event){
		event.preventDefault();

		if ($('#cospix-message-list').is(':visible')) {
			$('#cospix-message-list').fadeOut('fast');
			$('#body').removeClass('disabled');

		} else {
			$('#cospix-message-list').load(
				urlbase+'/messages?jq=1',
				function() {
					$('#body').addClass('disabled');

					$('#cospix-message-list')
						.fadeIn('fast')
						.afSpreadsheet({row:'DIV', column:true, enter:false})
						.find('a').first().focus();
				}
			);
		}
	});
});
