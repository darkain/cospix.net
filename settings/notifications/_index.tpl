<div class="af-prefs-list">
	<h3>Notify Me When</h3>
	<ul class="settings-list">
		<li><label class="pointer"><input name="af-pref-commentphoto" type="checkbox" />
			[prefs.cospix_commentphoto;att=checked;atttrue=1;noerr]
			Someone comments on my photos
		</label></li>

		<li><label class="pointer"><input name="af-pref-commentfeed" type="checkbox" />
			[prefs.cospix_commentfeed;att=checked;atttrue=1;noerr]
			Someone comments on my feed items
		</label></li>

		<li><label class="pointer"><input name="af-pref-commentreply" type="checkbox" />
			[prefs.cospix_commentreply;att=checked;atttrue=1;noerr]
			Someone else comments on something I've commented on
		</label></li>

		<li><label class="pointer"><input name="af-pref-follow" type="checkbox" />
			[prefs.cospix_follow;att=checked;atttrue=1;noerr]
			Someone follows me
		</label></li>

		<li><label class="pointer"><input name="af-pref-questionask" type="checkbox" />
			[prefs.cospix_questionask;att=checked;atttrue=1;noerr]
			Someone asks me a question
		</label></li>

		<li><label class="pointer"><input name="af-pref-questionanswer" type="checkbox" />
			[prefs.cospix_questionanswer;att=checked;atttrue=1;noerr]
			Someone answers a question I asked
		</label></li>
	</ul>
</div>

<div class="af-prefs-list">
	[onshow;block=div;when [user.badge.alpha]+-0]
	<h3 style="margin:2em 0 0 0">Alpha Tester Preferences</h3>
	<ul class="settings-list">
		<li><label class="pointer"><input name="af-pref-adfree" type="checkbox" />
			[user.adfree;att=checked;atttrue=1;noerr]
			Hide All Advertising
		</label></li>
	</ul>
</div>

[onload;file=settings/js.tpl]
