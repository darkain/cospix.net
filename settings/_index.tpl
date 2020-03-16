<style>
.af-prefs-list {
	font-size:1.2em;
}

.af-prefs-list input {
	font-size:1em;
}
</style>

<article class="cpn-default">
	<h1 class="cpn-header">Account Settings</h1>

	<section class="cpn-default">

		<div id="profile-menu" class="cpn-profile-sidebar" style="float:left; width:150px">
			<a class="cpn-profile-sidebar-item cpn-profile-sidebar-selected">Cospix</a>
			<a class="cpn-profile-sidebar-item">Notifications</a>
			<a class="cpn-profile-sidebar-item">Email</a>
			<a class="cpn-profile-sidebar-item">Facebook</a>
			<a class="cpn-profile-sidebar-item">Twitter</a>
			<a class="cpn-profile-sidebar-item">Google</a>
		</div>


		<div style="float:right; width:800px">
			<div id="af-prefs-saved">SAVED</div>
			<div id="cpn-settings-body">
				[onload;file=cospix/_index.tpl]
			</div>
		</div>

		<div class="clear"></div>

	</section>
</article>


<script>
afsave = function() {
	$('#af-prefs-saved')
		.stop(true)
		.clearQueue()
		.css('opacity', 1.0)
		.show()
		.fadeOut(2000);
}

$('.cpn-profile-sidebar-item').click(function(){
	$('.cpn-profile-sidebar-selected').removeClass('cpn-profile-sidebar-selected');
	$(this).addClass('cpn-profile-sidebar-selected');
	var txt = $(this).text().trim().toLowerCase();
	$('#cpn-settings-body').load('[afurl.base]/settings/'+txt+'?jq=1');
});
</script>
