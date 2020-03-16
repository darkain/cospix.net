<style>
.cpn-discover>div {
	display:flex;
	flex-wrap:wrap;
	color:#fff;
}

.cpn-discover>div section {
	margin:1em;
	width:20em;
	flex-grow:1;
	flex-shrink:0;
	background:#fff;
	border-radius:10px;
	padding:1em;
	box-shadow:inset 0 0 5px #000;
	color:#456;
}

.cpn-discover>div section h3 {
	color:#456;
	border-bottom:4px solid #456;
	padding-bottom:0.2em;
	margin-bottom:0.5em;
}

.cpn-discover>div input,
.cpn-discover>div button,
.cpn-discover>div a.cpn-button {
	line-height:1em;
	display:block;
	width:100%;
	font-size:1.2em;
	padding:0.5em;
}

input:disabled {
	background:#e0e0e0;
	border:none;
}

.prometheus-insert {
	width:800px;
}
</style>


<div id="af-prefs-saved">SAVED</div>


<main class="cpn-discover">
	<h1 class="cpn-header cpn-discover-header">Account Settings</h1>

	<div>



		<section>
			<h3>Identity</h3>

			<h4>User Name</h4>
			<input type="text" id="settings-username" value="[user.user_name]" placeholder="User Name" />

			<h4 style="margin-top:1em">Tag Line</h4>
			<input type="text" id="settings-tagline" value="[user.user_tagline]" placeholder="Tag Line" />

			<p style="margin-top:1em">
			</p>
		</section>



		<section>
			<h3>Custom URL Preferences</h3>

			<div>
				[onload;block=div;when '[user.url]'='']
				https://cospix.net/
				<input id="in-save-url" type="text" />
				<button id="btn-save-url" class="cpn-button" style="margin-top:0.5em">Save</button>
				<div style="margin:1em 2em;color:red" id="out-save-url">&nbsp;</div>
			</div>

			<div>
				[onload;block=div;when '[user.url]'!='']
				https://cospix.net/<input type="text" value="[user.user_url]" disabled />
			</div>

			<p style="margin-top:1em">
				Use this to set a custom URL for your Cospix.net account. Please note
				that once this is set, the URL can <b>NOT</b> be changed. Choose the
				URL wisely. The URL must be at least 2 characters long. Only letters and
				numbers are allowed, no special characters. URLs must start with a
				letter, not a number.
			</p>
		</section>


		<section>
			<h3>Location</h3>

			<button class="cpn-button" style="padding:0.5em 3em; margin-bottom:10px"
				data-featherlight="[afurl.base]/settings/cospix/location?jq=1">
				[user.location;ifempty='Change Location']
			</button>

			<p style="margin-top:1em">
				Your Location setting is publicly visible and searchable!
				By adding this information, you will appear on the User World Map
				on <a href="https://cospix.net">Cospix.net</a>. If at any time you
				want to remove yourself from the World Map and public search, simply
				set your Location back to an empty value.
			</p>
		</section>


		<section>
			<div>
				<h3>Sign Out of Cospix.net</h3>
				<a class="cpn-button" style="padding:0.5em 3em" href="[afurl.base]/login/out">
					Sign Out
				</a>
			</div>
		</section>

		<section class="prometheus-insert"></section>
		<section class="prometheus-insert"></section>
		<section class="prometheus-insert"></section>
		<section class="prometheus-insert"></section>
		<section class="prometheus-insert"></section>

	</div>
</main>


[onload;file=settings/js.tpl]


<script>
afsave = function() {
	$('#af-prefs-saved')
		.stop(true)
		.clearQueue()
		.css('opacity', 1.0)
		.show()
		.fadeOut(2000);
}


$(function(){
	$('#btn-save-url').click(function(){
		$.post(
			'[afurl.base]/settings/cospix/set/url',
			{name:$('#in-save-url').val()},
			function(data){$('#out-save-url').html(data);}
		).fail(function(xhr){$('#out-save-url').html(xhr.responseText);});
	});

	$('#settings-username').change(function(){
		var that = this;
		$.post(
			'[afurl.base]/profile/set/name',
			{text: $(that).val()},
			function(data) {
				$(that).val(data.trim());
			}
		);
	});

	$('#settings-tagline').change(function(){
		var that = this;
		$.post(
			'[afurl.base]/profile/set/tagline',
			{text: $(that).val()},
			function(data) {
				$(that).val(data.trim());
			}
		);
	});
});
</script>
