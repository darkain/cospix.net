<script>
var block_scrolling_hax = 0;

var block_scrolling = function(event) {
	event.preventDefault();
	event.returnValue = false;
	return false;
};


var unblock_scrolling = function() {
	window.removeEventListener('touchmove',	block_scrolling, {passive:false});
	window.removeEventListener('scroll',	block_scrolling, {passive:false});
};


$(function(){
	$(body).on('contextmenu', '#cpn-profile-body .cpn-prometheus', function(event){
		return !event.buttons;
	});


	$('#cpn-profile-body .cpn-prometheus').sortable({
		placeholder:			'cpn-prometheus-item cpn-prometheus-holder',
		forcePlaceholderSize:	true,
		tolerance:				'pointer',
		delay:					$.support.touch ? 300 : 150,
		distance:				20,
		items:					'> figure',
		cancel:					'.cpn-no-drag',
		opacity:				0.7,
		scroll:					false,

		start: function(event, ui) {
			if (block_scrolling_hax !== 0) return;
			block_scrolling_hax = 1;
			unblock_scrolling();
			window.addEventListener('scroll',		block_scrolling, {passive: false});
			window.addEventListener('touchmove',	block_scrolling, {passive: false});
			$(ui.placeholder).width( $(ui.item).width() );
		},

		stop: function(event, ui) {
			block_scrolling_hax = 0;
			unblock_scrolling();

			$.post($(this).data('sort'), $(this).sortable('serialize'));
		},


		//http://stackoverflow.com/questions/24970789/sortable-behaves-wrong-when-css3-scale-is-applied
		sort: function(event, ui) {
			var zoom	= parseFloat($('#body').css('zoom')) || 1;

			ui.helper.css({
				top:	ui.position.top		+ ((1 - zoom) * $(window).scrollTop()	/ zoom),
				left:	ui.position.left	+ ((1 - zoom) * $(window).scrollLeft()	/ zoom),
			});
		},
	});


	window.addEventListener('scroll', function(event){
		if (block_scrolling_hax !== 0) return;
		block_scrolling_hax = 2;
		var item = $('#cpn-profile-body .cpn-prometheus');
		if (item.hasClass('ui-sortable')) item.sortable('disable');
	}, {passive: false});

	$(window).scrollEnd(function() {
		if (block_scrolling_hax !== 2) return;
		block_scrolling_hax = 0;
		var item = $('#cpn-profile-body .cpn-prometheus');
		if (item.hasClass('ui-sortable')) item.sortable('enable');
	}, 500);

});
</script>
