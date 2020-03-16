<div id="new-gallery-info">
	<input type="text" style="height:0;line-height:0;opacity:0;margin:0; position:absolute" />
	<input type="text" name="name" value="Untitled Gallery" id="new-gallery-title" class="dimmed" />
</div>

<div class="center" style="margin:2em 0">
	<button id="btn-create-gallery">CREATE GALLERY</button>
</div>

<script>
$(function() {
	$('#new-gallery-title').focus(function(){
		$(this).removeClass('dimmed');
		if ($(this).val().trim()=='Untitled Gallery') $(this).val('');
	}).blur(function(){
		if ($(this).val().trim()=='') {
			$(this).addClass('dimmed').val('Untitled Gallery');
		}
	})

	$('#btn-create-gallery').click(function(){
		if ($('#new-gallery-title').val().trim()=='Untitled Gallery') return;
		$.post(
			'[afurl.base]/tag/[tag.group_type_name]/[tag.group_label;f=urlname]/references/insert',
			$('#new-gallery-info').afSerialize(),
			function(data) { document.location=data }
		);
	});
});
</script>
