<article class="cpn-default">
	<h1 class="cpn-header">Discussion</h1>
</article>

<div class="cpn-discussion" id="cpn-new-discussion">
	[onshow;block=div;when [user.user_id]+-0]
	<input type="hidden" name="id" value="[event.event_group]" />
	<input type="hidden" name="type" value="event" />
	<input type="hidden" name="data" class="cpn-new-data" />
	<textarea name="text" placeholder="Start a new discussion..."></textarea>
	<div class="cpn-discussion-post-test">
		<button class="cpn-button">Post</button>
		<div class="clear"></div>
	</div>
</div>


[onload;file=discussion/_virtual.tpl]


<div class="cpn-discussion" style="padding:1em">
	[posts;block=div;nodata]
	There are currently no discussion topics on this page
</div>


<script>[onshow;block=script;when [user.user_id]+-0]
$(function(){
	var ajax_request = false;
	$('.cpn-discussion textarea').textntags({
		triggers: {'@': {
			minChars: 1,
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


	$('.cpn-discussion-post-test button').click(function(){
		$('#cpn-new-discussion .cpn-new-data').val(
			$('.cpn-discussion textarea').textntags('value')
		);

		$.post(
			'[afurl.base]/discussion/post',
			$('#cpn-new-discussion').afSerialize(),
			refresh
		);
	});


	cpnDiscussReply = function(item) {
		var that = $(item).closest('div');
		$.post('[afurl.base]/comment', {
			id: $(item).closest('.cpn-discussion').data('id'),
			type: 'discussion',
			text: $(that).find('textarea').val(),
		}, function(data) {
			$(that).find('textarea').val('').keyup();
			$(data).insertBefore(that);
		});
	}


	$('.cpn-lfs-reply-post').click(function(){
		cpnDiscussReply(this);
	});

	$('.cpn-reply').keypress(function(event){
		console.log(event);
		if (event.keyCode === 13  ||  event.keyCode === 10) {
			if (event.altKey  ||  event.ctrlKey  ||  event.shiftKey) {
				if (event.keyCode === 10) {
					var txt = $(this).val();
					var pos = $(this).prop('selectionStart');
					$(this).val(txt.substring(0,pos) + "\n" + txt.substring(pos));
					$(this).prop('selectionStart', pos+1);
					$(this).prop('selectionEnd', pos+1);
				}
				return;
			}
			cpnDiscussReply(this);
		}
	});
});
</script>
