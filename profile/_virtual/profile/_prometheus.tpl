<div class="profile-flex">
	<div class="cpn-profile-about">
		[onload;file=profile/about.tpl]
	</div>

	<div>
		[onload;file=profile/things.tpl]
	</div>
</div>


<script>
[onshow;block=script;when [profile.id]=[user.user_id]]
$(function(){
	$('.cpn-profile-about p').click(function() {
		$(this).hide();
		$('.cpn-profile-about textarea').show().focus();
	});

	$('.cpn-profile-about textarea').blur(function() {
		$.post(
			'[afurl.base]/profile/set/bio',
			{ id:[profile.id], value:$(this).val() },
			function(data) {
				$('.cpn-profile-about textarea').hide();
				$('.cpn-profile-about p').html(data).show();
			}
		);
	});
});
</script>
