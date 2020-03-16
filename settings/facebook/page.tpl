<div class="af-prefs-list" id="cpn-select-facebook-page">
	<h3>Post to the following Facebook page</h3>
	<ul class="settings-list">
		<li><label data-id="[fbuser.fb_user_id]" class="pointer">
			[fbuser.fb_full_name]
		</label></li>
		<li><label data-id="[fbpage.id]" class="pointer">
			[fbpage.name;block=li]
		</label></li>
	</ul>
</div>

<script>
$('#cpn-select-facebook-page label').click(function(){
	$.post(
		'[afurl.base]/settings/set/fbpage',
		{id:$(this).data('id')},
		refresh
	)
});
</script>
