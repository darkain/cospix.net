<article class="cpn-default">
	<h1 class="cpn-header">[af.title]</h1>
	<div class="cpn-default cpn-gallery-sortable" style="padding:2px">
		[onload;file=gallery/thumbs.tpl]
		<div class="clear"></div>
	</div>
</article>

<script>
$(function(){
	if (typeof afDropzone !== 'undefined') {
		afDropzone(
			'form.cpn-dropzone',
			[afurl.upload;safe=json],
			'#cpn-gallery-add-images'
		);
	}

	$('.cpn-gallery-sortable').sortable({
		placeholder: 'cpn-thumb-item',
		items: 'a:not(#cpn-gallery-add-images)',
		handle: '.cpn-gallery-move',
		forcePlaceholderSize: true,
		stop: function(event, ui) {
			$.post(
				'[afurl.base]/gallery/sort/[gallery.gallery_id]',
				$(this).sortable('serialize')
			);
		}
	}).disableSelection();

	$('.cpn-gallery-move').click(function(event){
		event.preventDefault();
		event.stopPropagation();
	});
});
</script>
