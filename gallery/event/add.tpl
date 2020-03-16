<div style="padding:10px">
	Search: <input type="text" name="query" style="width:500px" id="cpn-costume-search" />
	<div class="clear"></div>
</div>

<script>
var event_search = false;
var event_last = '';
$('#cpn-costume-search').change(function(){
	if (event_last == $('#cpn-costume-search').val()) return;
	event_last = $('#cpn-costume-search').val();

	$('#cpn-costume-events').html('<div class="cpn-loading"></div>');
	if (event_search) clearTimeout(event_search);
	event_search = setTimeout(function(){
		$('#cpn-costume-events').load(
			'[afurl.base]/gallery/event/search?query=' +
			encodeURIComponent(event_last)
		);
	}, 1000);
}).keyup(function(){$(this).change()});


search_post = function() {
	$.post(
		'[afurl.base]/gallery/event/insert',
		{galleryid:[gallery.gallery_id], eventid:$(this).data('id')},
		refresh
		/*function() {
			popdown();
			$('#cpn-gallery-details').load(
				'[afurl.base]/profile/costume/tabs?id=[gallery.gallery_id]&status=events'
			);
		}*/
	);
};
</script>


<div id="cpn-costume-events">
[onload;file=event.tpl]
</div>
