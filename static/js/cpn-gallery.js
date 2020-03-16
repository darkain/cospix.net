'use strict';


//Gallery
/*
gallery_open = function(url) {
	if (history_block) return;
	history_block = true;

	if (History.getState().cleanUrl != url) {
		History.pushState(null, null, url);
	}

	url += (url.indexOf('?') == -1) ? '?jq=1' : '&jq=1';

	$('html,body').css('overflow', 'hidden');
	$('#cpn-gallery-popup').show().load(url);
}

gallery_close = function(goback) {
	if (!history_block) return;
	$('html,body').css('overflow', 'visible');
	$('#cpn-gallery-popup').hide().html('');
	if (goback) History.back();
	history_block = false;
}
*/
