<div class="cpn-comment cpn-comment-new">
	[onshow;block=div;when [user.user_id]+-0]
	<img class="cpn-comment-img" src="[user.img;ifempty='[afurl.static]/thumb2/profile.svg';noerr]" alt="[user.user_name]" />

	<div class="cpn-comment-text">
		<input type="hidden" name="id" value="[newcomm.id]" />
		<input type="hidden" name="type" value="[newcomm.type]" />
		<input name="text" type="text" placeholder="Write a new comment..." />
	</div>

	<div class="clear">&nbsp;</div>
</div>


<div class="cpn-comment cpn-comment-new button" style="font-size:2em;padding:1em;margin:1em" onclick="popup('/login?jq=1', 'Login / Register')">
	[onshow;block=div;when [user.user_id]=0]
	[onshow;block=div;when '[newcomm.login;noerr]'='']
	Login to leave a comment
</div>
