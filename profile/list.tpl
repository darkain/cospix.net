<article class="cpn-default">
	<h1 class="cpn-header">
		<span style="float:right" class="small">[profile.count;noerr;magnet=span] Users</span>
		[af.title;ifempty='User Profiles']
	</h1>
	<div class="cpn-default">

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
