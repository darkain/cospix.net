<article class="cpn-default">
	<h1 class="cpn-header">Admin</h1>


	<section class="cpn-default">
		Cospix Access:
		<table>
			<tr><td>[access.user_access;block=tr]</td></tr>
		</table>
	</section>



	<section class="cpn-default">
		Cospix Variables:
		<table>
			<tr><th class="right" style="padding-right:1em">user_id</th><td>[account.user_id;noerr;magnet=tr]</td></tr>
			<tr><th class="right" style="padding-right:1em">user_email</th><td>[account.user_email;noerr;magnet=tr]</td></tr>
			<tr><th class="right" style="padding-right:1em">user_url</th><td>[account.user_url;noerr;magnet=tr]</td></tr>
			<tr><th class="right" style="padding-right:1em">user_location</th><td>[account.user_location;noerr;magnet=tr]</td></tr>
			<tr><th class="right" style="padding-right:1em">user_geo</th><td>[account.user_lat;noerr;magnet=tr] - [account.user_lon;noerr;magnet=tr]</td></tr>
			<tr><th class="right" style="padding-right:1em">user_permission</th><td>[account.user_permission;noerr;magnet=tr]</td></tr>
		</table>
	</section>



	<section class="cpn-default">
		Authentication Variables:
		<table>
			<tr><th class="right" style="padding-right:1em">auth_account</th><td>[auth.auth_account;noerr;magnet=tr]</td></tr>
			<tr><th class="right" style="padding-right:1em">auth_verified</th><td>[auth.auth_verified;noerr;magnet=tr]</td></tr>
		</table>
	</section>


	<section class="cpn-default">
		Facebook Variables:
		<table>
			<tr><th class="right" style="padding-right:1em">fb_username</th><td>[facebook.fb_username;noerr;magnet=tr]</td></tr>
			<tr><th class="right" style="padding-right:1em">fb_email</th><td>[facebook.fb_email;noerr;magnet=tr]</td></tr>
			<tr><th class="right" style="padding-right:1em">fb_user_id</th><td>[facebook.fb_user_id;noerr;magnet=section]</td></tr>
			<tr><th class="right" style="padding-right:1em">fb_full_name</th><td>[facebook.fb_full_name;noerr;magnet=tr]</td></tr>
			<tr><th class="right" style="padding-right:1em">fb_url</th><td><a href="[facebook.fb_url;noerr]" target="_blank">[facebook.fb_url;noerr;magnet=tr]</a></td></tr>
			<tr><th class="right" style="padding-right:1em">fb_location</th><td>[facebook.fb_location;noerr;magnet=tr]</td></tr>
			<tr><th class="right" style="padding-right:1em">fb_gender</th><td>[facebook.fb_gender;noerr;magnet=tr]</td></tr>
			<tr><th class="right" style="padding-right:1em">fb_verified</th><td>[facebook.fb_verified;noerr;magnet=tr]</td></tr>
			<tr><th class="right" style="padding-right:1em">fb_timestamp</th><td>[facebook.fb_timestamp;noerr;magnet=tr] - [facebook.fb_timestamp;noerr;date='Y-m-d G:i:s']</td></tr>
			<tr><th class="right" style="padding-right:1em">fb_page_name</th><td>[facebook.fb_page_name;noerr;magnet=tr]</td></tr>
		</table>
	</section>


	<section class="cpn-default">
		Twitter Variables:
		<table>
			<tr><th class="right" style="padding-right:1em">tw_user_id</th><td>[twitter.tw_user_id;noerr;magnet=section]</td></tr>
			<tr><th class="right" style="padding-right:1em">tw_username</th><td><a target="_blank" href="https://twitter.com/[twitter.tw_username;noerr]">@[twitter.tw_username;noerr]</a></td></tr>
			<tr><th class="right" style="padding-right:1em">tw_full_name</th><td>[twitter.tw_full_name;noerr;magnet=tr]</td></tr>
			<tr><th class="right" style="padding-right:1em">tw_location</th><td>[twitter.tw_location;noerr;magnet=tr]</td></tr>
			<tr><th class="right" style="padding-right:1em">tw_timezone</th><td>[twitter.tw_timezone;noerr;magnet=tr]</td></tr>
			<tr><th class="right" style="padding-right:1em">tw_verified</th><td>[twitter.tw_verified;noerr;magnet=tr]</td></tr>
			<tr><th class="right" style="padding-right:1em">tw_language</th><td>[twitter.tw_language;noerr;magnet=tr]</td></tr>
			<tr><th class="right" style="padding-right:1em">tw_created</th><td>[twitter.tw_created;noerr;magnet=tr] - [twitter.tw_created;noerr;date='Y-m-d G:i:s']</td></tr>
		</table>
	</section>

	<section class="cpn-default">
		Google Variables:
		<table>
			<tr><th class="right" style="padding-right:1em">go_user_id</th><td><a href=""><a target="_blank" href="https://plus.google.com/[google.go_user_id;noerr]/posts">[google.go_user_id;noerr;magnet=section]</a></td></tr>
			<tr><th class="right" style="padding-right:1em">go_email</th><td>[google.go_email;noerr;magnet=tr]</td></tr>
			<tr><th class="right" style="padding-right:1em">go_full_name</th><td>[google.go_full_name;noerr;magnet=tr]</td></tr>
			<tr><th class="right" style="padding-right:1em">go_verified</th><td>[google.go_verified;noerr;magnet=tr]</td></tr>
			<tr><th class="right" style="padding-right:1em">go_locale</th><td>[google.go_locale;noerr;magnet=tr]</td></tr>
		</table>
	</section>


</article>
