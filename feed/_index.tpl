<main class="cpn-default cpn-activity-feed-list" style="font-size:16px">
	<h1 class="cpn-header">Activity Feed</h1>
	<div>
		[onload;file=post.tpl]
	</div>
</main>


[onload;file=feed.tpl]

<div class="cpn-feed-more">Load More</div>
&nbsp;

<script>
$('.cpn-feed-more').click(function(){
	var time = $('.cpn-feed-item').last().data('time');
	$.get(
		'[afurl.base]/feed?from='+time,
		function(data) { $(data).insertBefore('.cpn-feed-more'); }
	)
});
</script>
