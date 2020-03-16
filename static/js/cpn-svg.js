/*  Replace all SVG images with inline SVG */
/*
(function($) {
	$.fixsvg = function() {
		$('object.svg').each(function(){
			//var img = $(this).removeClass('svg');
			//$.get(img.attr('data'), function(data) {

console.log( $(this).get() );
return;
			img.replaceWith(
				$(img.contentDocument)
				.find('svg')
				.attr('class', img.attr('class'))
				.attr('id', img.attr('id'))
				.removeAttr('xmlns:a')
			);
			//});
		});
	};
})(jQuery);


$(function(){
	setTimeout(function(){
		$.fixsvg();
	}, 1000);
});
*/
