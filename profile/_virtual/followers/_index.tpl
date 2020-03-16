<article class="cpn-default">
	<h1 class="cpn-header">
		<span class="smaller" style="float:right">Total: [follow.#]</span>
		Followers
	</h1>

	<div class="cpn-default">

		<ul class="cpn-account-list">
			<li>
				<a class="cpn-account-name" href="[afurl.base]/[follow.user_url;ifempty='[follow.user_id]';block=li]" data-id="[follow.user_id]">
					<img src="[follow.img;ifempty='[afurl.static]/thumb2/profile.svg']" alt="[follow.user_name]" />
					[follow.user_name]
					<span class="cpn-account-subtext">[follow.user_tagline]</span>
					<span class="cpn-account-follow">+ Follow[onshow;block=span;when '[follow.following]'=''][onload;block=span;when [user.user_id]+-0]</span>
				</a>
			</li>
		</ul>

	</div>
</article>

<script>
[onshow;block=script;when [user.user_id]+-0]
$(function(){
	$('.cpn-account-follow').click(function(event){
		if (event.which != 1  &&  event.which != 2) return;
		event.preventDefault();
		var id = $(this).closest('[data-id]').data('id');
		$.post('[afurl.base]/follow/add', {id:id});
		$(this).remove();
	});
});
</script>
