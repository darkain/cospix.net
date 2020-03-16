<div id="cospix-user">
	[onshow;block=div;when [user.user_id]!=0]
	<a href="[afurl.base]/[user.user_url]">
		<img src="[user.img;ifempty='[afurl.static]/thumb2/profile.svg';noerr]"
			class="cpn-profile-pic-[user.user_id]"
			alt="[user.user_name]" title="[user.user_name]" />
		<span>[user.user_name]</span>
	</a>
	<div id="cospix-user-menu">
		<a href="[afurl.base]/settings">
			[onshow;svg=static/svg/settings.svg]
			<span>Settings</span>
		</a>
		<a href="[afurl.base]/location">
			[onshow;svg=static/svg/map.svg]
			<span>My Location</span>
		</a>
		<a href="[afurl.base]/messages" id="cospix-user-messages">
			[onshow;svg=static/svg/messages.svg]
			[user.messages;ifempty=0]
			<span>Messages</span>
		</a>
	</div>
</div>
<div id="cospix-anonymous">
	[onshow;block=div;when [user.user_id]=0]
	<a href="[afurl.base]/login">
		[onshow;svg=static/svg/profile.svg]
		<span>Login / Sign up</span>
	</a>
</div>
