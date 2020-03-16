$(function(){
	var percent		= 70;
	var count		= 0;
	var max			= 0;
	var log			= 0;

	$('#event-graph svg rect')
	.each(function(index, item) {
		count++;
		var val		= $(item).data('val');
		max			= (val > max) ? val : max;
		log			= Math.log(max)+1;
	})


	.each(function(index, item) {
		var width	= ((1 / count) * 100) - 1;

		var val		= $(item).data('val');

		var height	= ((val / max) * percent)
					+ (((Math.log(val)+1) / log) * (100-percent))

		if (!isFinite(height)) height = 0;

		$(item)
		.attr('x',		(index * (width + 1) + 0.5) + '%')
		.attr('y',		(100-height) + '%')
		.attr('width',	width	+ '%')
		.attr('height',	height	+ '%');
	});
})