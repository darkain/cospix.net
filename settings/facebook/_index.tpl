<div>
	<a href="[afurl.base]/login/facebook?add=1" class="btn-login">
		[onshow;block=a;when [facebook.pudl_user_id]=0]
		Link this account to Facebook
	</a>
</div>

<div class="af-prefs-list">
	[onshow;block=div;when [facebook.pudl_user_id]+-0]
	<h3>Facebook Preferences</h3>
	Linked Account: <a target="_blank" href="[facebook.fb_url]">[facebook.fb_url]</a>
	<!--<br />
	Posting To: [facebook.fb_page_name;ifempty=[facebook.fb_full_name]]
	<span id="cpn-fb-change">CHANGE</span>
	<ul class="settings-list">
		<li><label class="pointer"><input name="af-pref-attend" type="checkbox" />
			[prefs.facebook_post_attending;att=checked;atttrue=1;noerr]
			Post on Facebook when I attend a new event
		</label></li>
		<li><label class="pointer"><input name="af-pref-gallery" type="checkbox" />
			[prefs.facebook_post_gallery;att=checked;atttrue=1;noerr]
			Post on Facebook when I update a costume or gallery
		</label></li>
		< !- -
		<li><label class="pointer"><input id="facebook_post_coverage" type="checkbox" />
			[prefs.facebook_post_coverage;att=checked;atttrue=1;noerr]
			Post on Facebook when I add an event report or gallery link
		</label></li> - - >
	</ul>-->
</div>

<script>
$('#cpn-fb-change').click(function(){
	popup('[afurl.base]/settings/facebook/page', 'Select Facebook Page');
});
</script>

[onload;file=settings/js.tpl]
