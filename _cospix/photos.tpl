<article class="cpn-default" style="padding:0 2px">
	<h1 class="cpn-header" style="margin:0 -2px 2px -2px">Photos</h1>
	<div>
		[onload;block=div;when '[group.istag;noerr]'!='1']
		[onload;file=gallery/thumbs.tpl]
	</div>

	<div>
		[onload;block=div;when '[group.istag;noerr]'='1']
		[onload;file=gallery/images.tpl]
	</div>

	<div class="clear" id="insert-before"></div>

	<div class="cpn-feed-more">
		[onshow;block=div;when [more.more]=1]
		Load More
	</div>
	&nbsp;
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
