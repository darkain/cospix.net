'use strict';


var cpn_message_click = function(event, that){
	if (event.which != 1  &&  event.which != 2) return;
	event.preventDefault();

	$(that).data('btn', event.which);

	$.postSync(
		urlbase+'/messages/read',
		{id: $(that).closest('[data-id]').data('id')},
		function(){
			$(that).removeClass('cpn-message-new');
			if ($(that).data('btn') == 2) {
				window.open( $(that).attr('href'), '_blank' );
			} else {
				location = $(that).attr('href');
			}
		}
	);
};

var cpn_message_action = function(event, that){
	if (event.which != 1) return;
	event.preventDefault();
	event.stopPropagation();
	eval( $(that).data('click') );
};




var cpn_message_read = function(item) {
	$.post(
		urlbase+'/messages/read',
		{ id: $(item).closest('[data-id]').data('id') }
	);

	$(item).closest('[data-id]').removeClass('cpn-message-new');
};



var cpn_follow = function(item) {
	$.post(
		urlbase+'/follow/add',
		{ id: $(item).closest('[data-from]').data('from') },
		function(){ $(item).remove(); }
	)

	cpn_message_read(item);
};



var cpn_gallery_add = function(item, hash) {
	popup(urlbase+'/image/add?hash='+hash, 'Add Image to Gallery');
	cpn_message_read(item);
};
