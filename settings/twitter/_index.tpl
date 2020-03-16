<div>
	<a href="[afurl.base]/login/twitter?add=1" class="btn-login">
		[onshow;block=a;when [twitter.pudl_user_id]=0]
		Link this account to Twitter
	</a>
</div>


<div class="af-prefs-list">
	[onshow;block=div;when [twitter.pudl_user_id]+-0]
	<h3>Twitter Preferences</h3>
	Linked Account: <a target="_blank" href="https://twitter.com/[twitter.tw_username]">@[twitter.tw_username]</a>
	<ul class="settings-list">
		<!--<li><label class="pointer"><input id="twitter_post_attending" type="checkbox" />
			[prefs.twitter_post_attending;att=checked;atttrue=1;noerr]
			Post on Twitter when I attend a new event
		</label></li>
		<li><label class="pointer"><input id="facebook_post_coverage" type="checkbox" />
			[prefs.facebook_post_coverage;att=checked;atttrue=1;noerr]
			Post on Facebook when I add an event report or gallery link
		</label></li>-->
	</ul>
</div>
