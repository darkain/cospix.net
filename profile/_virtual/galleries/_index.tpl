<article class="cpn-default">
	<h1 class="cpn-header">Galleries</h1>
	<div style="padding:2px">
		<div>
			[onshow;block=div;when [user.user_id]=[profile.id]]
			<a class="cpn-thumb-link" onclick="popup('[afurl.base]/gallery/new','Create New Gallery')"><figure>
				<span class="cpn-thumb-add">+</span>
				<figcaption>Create Gallery</figcaption>
			</figure></a>
		</div>

		<div class="cpn-gallery cpn-gallery-sortable">
			<a id="gallery-item-[g.gallery_id]" href="[afurl.base]/[profile.url]/gallery/[g.gallery_id;block=a]" class="cpn-thumb-link" data-gallery-id="[g.gallery_id]"><figure>
				<img src="[g.img;ifempty='[afurl.static]/thumb2/gallery.svg']" />
				<span class="cpn-gallery-move">[onshow;block=span;when [user.user_id]=[profile.id]]</span>
				<figcaption>[g.gallery_name;ifempty='Untitled Gallery']</figcaption>
			</figure></a>
		</div>

		<div class="clear"></div>
	</div>
</article>


<script>
$(function(){
	$('.cpn-gallery a').click(function(event){
		if (event.which != 1) return;
		event.preventDefault();

		if (!hasHistory()) {
			document.location = $(this).attr('href');
			return;
		}

		if (!$(this).data('gallery-id')) return;
		history_ready = true;

		History.pushState(
			null,
			$(this).find('span').text() + " - [profile.name;safe=js] - [og.title;safe=js]",
			$(this).attr('href')
		);
	});
});
</script>


<script>
[onshow;block=script;when [user.user_id]=[profile.id]]
$(function(){
	$('.cpn-gallery-sortable').sortable({
		placeholder: 'cpn-thumb-link',
		handle: '.cpn-gallery-move',
		forcePlaceholderSize: true,
		stop: function(event, ui) {
			$.post(
				'[afurl.base]/gallery/sortall',
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
