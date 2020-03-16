<div class="cpn-gallery-notes">
	<p title="Click to edit" class="af-edit-field" style="min-height:3em">[gallery.text;safe=no]</p>
	<textarea>[gallery.gallery_notes;safe=nobr][onshow;block=textarea;when [user.user_id]=[gallery.user_id]]</textarea>
</div>


<script>
[onshow;block=script;when [user.user_id]=[gallery.user_id]]
$(function(){
	$('.cpn-gallery-notes p').click(function() {
		$(this).hide();
		$('.cpn-gallery-notes textarea').show().focus();
	});

	$('.cpn-gallery-notes textarea').blur(function() {
		$.post(
			'[afurl.base]/gallery/set/notes',
			{ id:[gallery.gallery_id], text:$(this).val() },
			function(data) {
				$('.cpn-gallery-notes textarea').hide();
				$('.cpn-gallery-notes p').html(data).show();
			}
		);
	});
});
</script>
