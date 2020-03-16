<article class="cpn-default">
	<h1 class="cpn-header">Photos</h1>

	<div class="cpn-default" style="padding:2px">
		[onload;file=photos/list.tpl]
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

<script>
[onshow;block=script;when [user.user_id]=[user.user_id]]
$(function(){
	cpn_credit_delete = function(e,that) {
		e.preventDefault();
		e.stopPropagation();
		var x = $(that).closest('a').data('id');
		popup('[afurl.base]/image/remove?hash='+x, 'Untag Image');
	}

	cpn_credit_addgallery = function(e,that) {
		e.preventDefault();
		e.stopPropagation();
		var x = $(that).closest('a').data('id');
		popup('[afurl.base]/image/add?hash='+x, 'Untag Image');
	}
});
</script>
