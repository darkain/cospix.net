		</div>
	</div>
</main>


<div class="clear"></div>


<script>
[onshow;block=script;when [profile.edit]=1]
$(function(){
	$('#icon-upload').fileupload({
		dataType: 'json'
	}).bind('fileuploadstart', function(event, data) {
		$('.cpn-profile-pic-[profile.id]').attr('src', '[afurl.static]/img/loading.gif');
	}).bind('fileuploadalways', function(event, data) {
		if (data.result === undefined) return;
		if (data.result['200'] !== undefined  &&  data.result['200'].url !== undefined) {
			$('.cpn-profile-pic-[profile.id]').attr('src', data.result['200'].url)
		} else if (data.result.url !== undefined) {
			$('.cpn-profile-pic-[profile.id]').attr('src', data.result.url)
		}
	});

	$('#cover-upload').fileupload({
		dataType: 'json'
	}).bind('fileuploadstart', function(event, data) {
		$('#cpn-profile-top').css('background-image', 'url([afurl.static]/img/loading.gif)')
	}).bind('fileuploadalways', function(event, data) {
		if (data.result === undefined) return;
		if (data.result['800'] !== undefined  &&  data.result['800'].url !== undefined) {
			$('#cpn-profile-top').css('background-image', 'url('+data.result['800'].url+')')
		} else if (data.result.url !== undefined) {
			$('#cpn-profile-top').css('background-image', 'url('+data.result.url+')')
		}
	});

	$('#cpn-profile-icon span').click(function(event){
		if (!$(event.target).is('span')) return;
		event.preventDefault();
		$('#cpn-profile-icon input').show().focus().click().hide();
	});

	$('#cpn-cover-upload').click(function(event){
		console.log(event);
		if (!$(event.target).is('span')) return;
		event.preventDefault();
		$('#cpn-cover-upload input').show().focus().click().hide();
	});


	$('#cpn-profile-name span').afClickEdit(
		'[afurl.base]/[profile.type]/set/name', [profile.id]
	);

	$('.cpn-profile-tagline').afClickEdit(
		'[afurl.base]/[profile.type]/set/tagline', [profile.id]
	);
});
</script>


<script>
[onshow;block=script;when [user.user_id]+-0]
$(function(){
	$('#cpn-profile-name button').click(function(){
		var txt = $(this).text().replace(/[\+\-]/,'').trim().toLowerCase();
		$.post(
			'[afurl.base]/[profile.url]/'+txt,
			{id:[profile.id]},
			function(data){ $('#cpn-profile-name button').text(data); }
		);
	});
});
</script>
