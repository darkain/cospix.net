<div id="cpn-post-feed">
	<input type="hidden" name="data" />
	<textarea name="text" placeholder="Post a new status..."></textarea>
	<div class="cpn-post-button">
		<button class="cpn-button">Post</button>
		<div class="clear"></div>
	</div>
</div>


<script>
$(function(){
	var ajax_request = false;
	$('#cpn-post-feed textarea').textntags({
		triggers: {'@': {
			minChars: 1999,
			showImageOrIcon: true,
			syntax: _.template('#[<%= id %>:<%= type %>:<%= title %>]'),
			parser: /(#)\[(\d+):([\w\s\.\-]+):([\w\s@\.,-\/#!$%\^&\*;:{}=\-_`~()]+)\]/gi,
			parserGroups: {id: 2, type: 3, title: 4},
		}},

		onDataRequest: function(mode, query, triggerChar, callback) {
			if (ajax_request) ajax_request.abort();
			ajax_request = $.getJSON('[afurl.base]/search/username?term='+query, function(data) {
				query	= query.toLowerCase();

				data	= _.filter(data, function(item) {
					return item.name.toLowerCase().indexOf(query) > -1;
				});

				callback.call(this, data);
				ajax_request = false;
			});
		}
	});

	$('#cpn-post-feed button').click(function(){
		$('#cpn-post-feed input').val(
			$('#cpn-post-feed textarea').textntags('value').trim()
		);

		if ($('#cpn-post-feed input').val()=='') return;

		$.post(
			'[afurl.base]/feed/post',
			$('#cpn-post-feed').afSerialize(),
			refresh
		);

		$('#cpn-post-feed').find('textarea,button').prop('disabled', true);
	});
});
</script>
