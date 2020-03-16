<div>
	<a href="[afurl.base]/login/google?add=1" class="btn-login">
		[onshow;block=a;when [google.pudl_user_id]=0]
		Link this account to Google
	</a>
</div>


<div class="af-prefs-list">
	[onshow;block=div;when [google.pudl_user_id]+-0]
	<h3>Google Preferences</h3>
	Linked Account: <a target="_blank" href="https://plus.google.com/[google.go_user_id]">[google.go_user_id]</a>
	<ul class="settings-list">
		<!--<li><label class="pointer"><input id="google_post_attending" type="checkbox" />
			[prefs.google_post_attending;att=checked;atttrue=1;noerr]
			Post on Google when I attend a new event
		</label></li>
		<li><label class="pointer"><input id="facebook_post_coverage" type="checkbox" />
			[prefs.facebook_post_coverage;att=checked;atttrue=1;noerr]
			Post on Facebook when I add an event report or gallery link
		</label></li>-->
	</ul>
</div>
