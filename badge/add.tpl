<style scoped>
img.cpn-badge-add {
	margin:0 10px;
}

img.cpn-badge-add:hover {
	cursor:pointer;
	opacity:0.8;
}
</style>

<div class="large profile-box" style="padding:15px; font-size:2em">
	<div class="center" style="margin-top:0.5em">
		[onshow;block=div;when [profile.user_id]=[user.user_id]]
		Badge Code:<br />
		<input type="text" style="font-size:1em" name="code" id="cpn-activation-code" /><br >
		<input type="button" value="Activate" id="cpn-activation-button" style="font-size:1em; padding:0.5em 1em; margin:1em" />
	</div>
	<div class="profile-box-body">
		[onshow;block=div;when [user.permission.admin]=1]
		<img class="cpn-badge-add" src="[afurl.static]/badge/[badge.badge_image]" alt="[badge.badge_name;block=img]" data-id="[badge.badge_id]" style="width:100px;height:100px" />
	</div>
	<div class="center large" style="padding:20px;" id="cpn-activate-out">&nbsp;</div>
</div>


<script>
$('#cpn-activation-button').click(function(){
	$.post(
		'[afurl.base]/badge/insert',
		$('#cpn-activation-code').serialize(),
		function(data){ $('#cpn-activate-out').html(data); }
	);
});

$('img.cpn-badge-add').click(function(){
	$.post(
		'[afurl.base]/badge/insert',
		{id:[profile.user_id], badge:$(this).data('id')},
		function(data){ $('#cpn-activate-out').html(data); }
	);
});
</script>
