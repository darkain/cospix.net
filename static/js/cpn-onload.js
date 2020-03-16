'use strict';


$(function() {

	//AUTO COMPLETE
	if ($('.cpn-nav-search input').length) {
		$('.cpn-nav-search input').focus(function(){
			if ($(this).val()=='search') $(this).val('');

		}).blur(function(){
			if ($(this).val()=='') $(this).val('search');

		}).autocomplete({
			source: urlbase+'/search/q',
			minLength: 2,
			position: { my : "right top", at: "right bottom" },
			select: function(event, ui) {
				document.location = urlbase+'/'+ui.item.url+'/'+ui.item.id;
			}

		}).data('uiAutocomplete')._renderItem = function(ul, item) {
			return $('<li></li>')
				.addClass('cpn-search-item')
				.data('item.autocomplete', item)
				.append('<a><img style="width:32px;height:32px;vertical-align:top;margin-right:5px" src="' + item.img + '" />' + item.value + '</a>')
				.appendTo(ul);
		};
	}


	$('#af-logged-out a').click(function(){
		var href = $(this).attr('href');
		if (typeof(href) == "undefined") return;
		$(this).removeAttr('href');
		$('#af-logged-out').html('LOADING');
		document.location = href;
	});


	$('.accordion').accordion({
		collapsible: true
	});


	$('.comment-delete').click(function(){
		if (!confirm('Are you sure you want to delete this comment?')) return;
		var that = $(this).closest('.comment-item');
		var id = that.attr('id').replace('comment-','');
		$.post(
			urlbase+'/comment/delete',
			{ id: id },
			function(data) { that.remove(); }
		);
	});


	if (typeof(cordova) == 'undefined') {
		document.domain = 'cospix.net';
	}

});
