<div class="af-prefs-list">
	<div class="large">
		[onload;block=div;when '[user.user_urlx]'='']
		<h3>Custom URL Preferences</h3><br />
		https://cospix.net/<input id="in-save-url" type="text" /> <button id="btn-save-url">Save</button>
		<div style="margin:1em 2em;color:red" id="out-save-url">&nbsp;</div>
	</div>
	<div class="large">
		[onload;block=div;when '[user.user_urlx]'!='']
		<h3>Custom URL Preferences</h3><br />
		https://cospix.net/<input type="text" value="[user.user_url]" disabled />
	</div>
	<em style="margin:0.5em 0;text-align:justify;display:block">
		NOTE: Use this to set a custom URL for your Cospix.net account. Please note
		that once this is set, the URL can <i>NOT</i> be changed. Choose the
		URL wisely. They must be at least 2 characters long. Only letters and
		numbers are allowed, no special characters. URLs must start with a
		letter, not a number.
	</em>
</div>


<div class="af-prefs-list">
	<div class="large">
		<h3 style="margin:2em 0 0 0">Homepage Style</h3>
		<ul class="settings-list">
			<li><label class="pointer">
				<input name="af-pref-homepage" type="radio" [user.user_home;checked=homepage] />
				Classic
			</label></li>
			<li><label class="pointer">
				<input name="af-pref-homepage" type="radio" [user.user_home;checked=discover] />
				Discover
			</label></li>
		</ul>
	</div>
</div>


<div class="af-prefs-list">
	<div class="large">
		<h3 style="margin:2em 0 0 0">Location</h3><br />
		<input type="text" value="[user.location]" style="width:30em" data-id="[user.user_city;noerr]" disabled /><br/>
		<button class="cpn-button large" style="padding:0.5em 3em; margin:10px 0" onclick="popup('[afurl.base]/settings/cospix/location', 'Change Location')">Change</button>
	</div>
	<em style="margin:0.5em 0;text-align:justify;display:block">
		NOTE: Your Location setting is publicly visible and searchable!
		By adding this information, you will appear on the User World Map
		on <a href="https://cospix.net">Cospix.net</a>. If at any time you
		want to remove yourself from the World Map and public search, simply
		set your Location back to an empty value.
	</em>
</div>


<div class="af-prefs-list">
	<div class="large">
		<h3 style="margin:2em 0 0 0">Sign Out of Cospix.net</h3><br />
		<a class="cpn-button" style="padding:0.5em 3em" href="[afurl.base]/login/out">Sign Out</a>
	</div>
</div>

<script>
$(function(){
	$('#btn-save-url').click(function(){
		$.post(
			'[afurl.base]/settings/cospix/set/url',
			{name:$('#in-save-url').val()},
			function(data){$('#out-save-url').html(data);}
		).fail(function(xhr){$('#out-save-url').html(xhr.responseText);});
	});

/*
	$('#in-location').autocomplete({
		position: { my:'left bottom', at:'left top' },
		source: '[afurl.base]/search/city',
		minLength: 1,
		select: function(event,ui){
			$('#in-location').data('id', ui.item.city_id).blur();
		}
	}).blur(function(){
		$.post(
			'[afurl.base]/settings/cospix/set/location',
			{location:$('#in-location').data('id')},
			function(data){$('#in-location').val(data); console.log('xx'+data); }
		);
	});
*/
});
</script>

[onload;file=settings/js.tpl]
