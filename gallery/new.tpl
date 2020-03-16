<div id="new-gallery-info">
	<input
		type="text"
		name="name"
		id="new-gallery-title"
		placeholder="Gallery Title"
		autocomplete="off" />

	<div style="padding:1em 0" class="largest">
		[onshow;block=div;when [af.config.root]='_prometheus']
		<div style="padding-left:0.7em">My Role</div>
		<label><input name="role" type="radio" value="create"/>Creation</label>
		<label><input name="role" type="radio" value="cosplay"/>Cosplayer</label>
		<label><input name="role" type="radio" value="photo"/>Photography</label>
	</div>

	<div class="center" style="padding:1em 0">
		<button id="btn-create-gallery">CREATE GALLERY</button>
	</div>
</div>


<script>
$(function() {
	$('#new-gallery-info input').first().focus();

	$('#btn-create-gallery').click(function(){
		if ($('#new-gallery-title').val().trim()=='') return;
		$.post(
			'[afurl.base]/gallery/insert',
			$('#new-gallery-info').afSerialize(),
			function(data) { document.location=data; }
		);
	});

	$('#new-gallery-info input[type=radio]').change(function(){
		console.log('stuff');
		$('#new-gallery-info label').removeClass('selected');
		$(this).closest('label').addClass('selected');
	});
});
</script>
