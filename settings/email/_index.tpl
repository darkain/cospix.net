<div class="af-prefs-list af-prefs-email">
	<h3>My Email Address</h3>
	<div style="font-size:1.5em;color:#00C8E6">[profile.user_email]</div>
</div>

<div class="af-prefs-list">
	<h3>Email Me When</h3>
	<ul class="settings-list">
		<li><label class="pointer"><input name="af-pref-commentphoto" type="checkbox" />
			[prefs.email_commentphoto;att=checked;atttrue=1;noerr]
			Someone comments on my photos
		</label></li>

		<li><label class="pointer"><input name="af-pref-commentfeed" type="checkbox" />
			[prefs.email_commentfeed;att=checked;atttrue=1;noerr]
			Someone comments on my feed items
		</label></li>

		<li><label class="pointer"><input name="af-pref-commentreply" type="checkbox" />
			[prefs.email_commentreply;att=checked;atttrue=1;noerr]
			Someone else comments on something I've commented on
		</label></li>

		<li><label class="pointer"><input name="af-pref-follow" type="checkbox" />
			[prefs.email_follow;att=checked;atttrue=1;noerr]
			Someone follows me
		</label></li>

		<li><label class="pointer"><input name="af-pref-questionask" type="checkbox" />
			[prefs.email_questionask;att=checked;atttrue=1;noerr]
			Someone asks me a question
		</label></li>

		<li><label class="pointer"><input name="af-pref-questionanswer" type="checkbox" />
			[prefs.email_questionanswer;att=checked;atttrue=1;noerr]
			Someone answers a question I asked
		</label></li>
	</ul>
</div>

<script>
$('.af-prefs-email div').afClickEdit(
	'[afurl.base]/settings/email/set/address',
	[profile.user_id],
	function(item, input) {
		console.log(item);
		console.log(input);
	}
);
</script>

[onload;file=settings/js.tpl]
