<article class="cpn-default">
	<h1 class="cpn-header">
		<span style="float:right" class="smaller">[profile.count;noerr;magnet=span] Users</span>
		Attendees
	</h1>
	<div class="cpn-default">
		<table class="cpn-folder"><tr>
			<td [onshow;block=td;when '[profile.filter;noerr]'=''] class="cpn-folder-selected">All</td>
			<td [onshow;block=td;when '[profile.filter;noerr]'!='']>All</td>

			<td [onshow;block=td;when '[profile.filter;noerr]'='cosplayers'] class="cpn-folder-selected">Cosplayers</td>
			<td [onshow;block=td;when '[profile.filter;noerr]'!='cosplayers']>Cosplayers</td>

			<td [onshow;block=td;when '[profile.filter;noerr]'='photographers'] class="cpn-folder-selected">Photographers</td>
			<td [onshow;block=td;when '[profile.filter;noerr]'!='photographers']>Photographers</td>

			<td [onshow;block=td;when '[profile.filter;noerr]'='videographers'] class="cpn-folder-selected">Videographers</td>
			<td [onshow;block=td;when '[profile.filter;noerr]'!='videographers']>Videographers</td>

			<td [onshow;block=td;when '[profile.filter;noerr]'='commissioners'] class="cpn-folder-selected">Commissioners</td>
			<td [onshow;block=td;when '[profile.filter;noerr]'!='commissioners']>Commissioners</td>
		</tr></table>

		<ul class="cpn-account-list">
			<li>
				<a class="cpn-account-name" href="[afurl.base]/[users.user_url;ifempty='[users.user_id]';block=li]">
					<img src="[users.img;ifempty='[afurl.static]/thumb2/profile.svg']" alt="[users.user_name]" />
					[users.user_name]
					<span class="cpn-account-subtext">[users.user_tagline]</span>
					<span class="cpn-account-type">[users.types;noerr;magnet=span]</span>
				</a>
			</li>
		</ul>

	</div>
</article>


<script>
$(function(){
	$('.cpn-folder td').click(function(){
		$('.cpn-folder-selected').removeClass('cpn-folder-selected');
		$(this).addClass('cpn-folder-selected');

		var page = $(this).text().replace(/\d/g,'').trim().toLowerCase();
		$('#cpn-profile-body').load('[afurl.base]/event/[event.event_name;f=urlname]/attendees?jq=1&filter='+page);
	});
});
</script>
