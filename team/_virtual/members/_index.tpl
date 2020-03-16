<article class="cpn-default">
	<h1 class="cpn-header">
		<span class="button team-new-member" style="margin:0" onclick="popup('[afurl.base]/team/members/add?id=[team.user_id]')">
			[onshow;block=span;when [profile.edit]=1]
			Add Members
		</span>
		Team [user.team_member_type;block=article;parentgrp=team_member_type;f=ucfirst]s
	</h1>

	<div class="cpn-default">

		<ul class="cpn-account-list">
			<li>
				<a class="cpn-account-name" href="[afurl.base]/[user.user_url;ifempty='[user.user_id]';block=li]" data-id="[user.user_id]">
					<img src="[user.img;ifempty='[afurl.static]/thumb2/profile.svg']" alt="[user.user_name]" />
					[user.user_name]
					<span class="cpn-account-subtext">[user.user_tagline]</span>
				</a>
			</li>
		</ul>

	</div>
</article>
