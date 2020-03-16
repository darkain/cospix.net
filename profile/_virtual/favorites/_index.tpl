<article class="cpn-default">
	<h1 class="cpn-header">Favorites</h1>

	<div class="cpn-default" style="padding:2px">
		[onload;file=favorites/list.tpl]
		<div class="cpn-feed-more">Load More[onshow;block=div;when [more.more]='1']</div>
	</div>
</article>

<script>
$(function(){
	$('.cpn-feed-more').click(function(){
		var time = $('.cpn-thumb-link').last().data('time');
		$.get(
			'[router.parts.path]?jq=1&from='+time,
			function(data) {
				$('#image-clear').remove();
				$(data).insertBefore('.cpn-feed-more');
			}
		);
	});
});
</script>
