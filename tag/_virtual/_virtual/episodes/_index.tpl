<article class="cpn-default">
	<h1 class="cpn-header">[video.gallery_name;block=article;parentgrp=gallery_name]</h1>
	<div class="cpn-default cpn-youtube" data-id="[video.gallery_id]">
		<a id="gallery-item=[video.youtube_id]" href="[afurl.full][video.youtube_id;block=a]"><figure>
			<img src="//img.youtube.com/vi/[video.youtube_id]/mqdefault.jpg" />
			<span class="cpn-gallery-move">[onshow;block=span;when [user.permission.admin]=1]</span>
			<figcaption>[video.youtube_title]</figcaption>
		</figure></a>
		<div class="clear"></div>
	</div>
</article>


<script>
[onshow;block=script;when [user.permission.admin]=1]
$(function(){
	$('.cpn-youtube').sortable({
		placeholder: 'cpn-youtube',
		handle: '.cpn-gallery-move',
		forcePlaceholderSize: true,
		stop: function(event, ui) {
			$.post(
				'[afurl.base]/gallery/sort/' + $(this).data('id'),
				$(this).sortable('serialize', {expression:/(.+)[=](.+)/})
			);
		}
	}).disableSelection();

	$('.cpn-gallery-move').click(function(event){
		event.preventDefault();
		event.stopPropagation();
	});

});
</script>
