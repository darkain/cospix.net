Set a YouTube URL<br />
<input id="txt-set-event-youtube" type="text" value="https://www.youtube.com/watch?v=[youtube.youtube_id;magnet=#;noerr]" style="width:35em" />
<br /><br />
<button class="cpn-button" id="btn-set-event-youtube">Save URL</button>

<div id="out-set-event-youtube"></div>



<script>
$('#btn-set-event-youtube').click(function(){
	$.post('[afurl.base]/profile/set/youtube', {
		youtube: $('#txt-set-event-youtube').val(),
	}, function(data) {
		$('#out-set-event-youtube').html(data)
	});
});
</script>
