
<main class="cpn-default">
	<h1 class="cpn-header">
		<span class="cpn-all-read">Mark All As Read</span>
		Messages
	</h1>

	<div class="cpn-default cpn-messages">
		[onload;file=message.tpl]

		<div class="cpn-feed-more">Load More</div>
		&nbsp;
	</div>
</main>

<script>
$('.cpn-feed-more').click(function(){
	var time = $('.cpn-messages a').last().data('time');
	$.get(
		'[afurl.base]/messages?from='+time,
		function(data) { $(data).insertBefore('.cpn-feed-more'); }
	)
});

$('.cpn-all-read').click(function(){
	$.post(
		'[afurl.base]/messages/readall',
		function() { $('.cpn-message-new').removeClass('cpn-message-new'); }
	);
})
</script>
