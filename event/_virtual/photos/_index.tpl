<article class="cpn-default">
	<h1 class="cpn-header">Photos</h1>

	<form action="[afurl.upload]" class="cpn-dropzone" method="post" enctype="multipart/form-data">
		<div style="padding:2px">
			<input type="hidden" name="event_id" value="[event.event_id;noerr;magnet=input]" />

			<a class="cpn-thumb-link" rel="nofollow" id="cpn-gallery-add-images"><figure>
				[onshow;block=a;when [user.user_id]!=0]
				[onshow;block=a; when [more.page]=0]
				<span class="cpn-thumb-add">+</span>
				<figcaption>Add photos to this event</figcaption>
			</figure></a>

			<a class="cpn-thumb-link" rel="nofollow" onclick="popup('/login?jq=1', 'Login / Register')"><figure>
				[onshow;block=a;when [user.user_id]=0]
				[onshow;block=a; when [more.page]=0]
				<span class="cpn-thumb-add">+</span>
				<figcaption>Add photos to this event</figcaption>
			</figure></a>

			[onload;file=gallery/images.tpl]
			<div class="clear" id="insert-before"></div>

			<div class="cpn-feed-more">
				[onshow;block=div;when [more.more]=1]
				Load More
			</div>

			&nbsp;

		</div>
	</form>
</article>


<script>
$(function(){
	var loadmorepage = [more.page];
	$('.cpn-feed-more').click(function(){
		$(this).remove();

		$.get(
			'[afurl.all]?jq=1&page=' + (++loadmorepage),
			function(data) {
				$('#insert-before').attr('id', 'insert-before-x');
				$(data).insertBefore('#insert-before-x');
				$('article.cpn-default article.cpn-default').unwrap('article');
				$('#insert-before-x').remove();
			}
		);
	});

	if (loadmorepage != 0) return;


	if (typeof afDropzone !== 'undefined') {
		if ($('#cpn-gallery-add-images').length) {
			afDropzone(
				'form.cpn-dropzone',
				[afurl.upload;safe=json],
				'#cpn-gallery-add-images'
			);
		}
	}
});
</script>
