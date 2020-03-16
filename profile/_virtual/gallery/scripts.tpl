<script>
$(function(){
	$('.cpn-gallery-notes').readmore({
		beforeToggle: function() { $('.readmore-js-toggle').remove(); },
		maxHeight: 320,
	});

	$('#cpn-gallery-folder td').click(function(){
		$('#cpn-gallery-folder td.cpn-folder-selected').removeClass('cpn-folder-selected');
		$(this).addClass('cpn-folder-selected');

		var url = '[afurl.base]/gallery';
		url += $(this).text().trim().toLowerCase() + '?id=[gallery.gallery_id]';
		$('#gallery-body').load(url);
	});

	$('.cpn-gallery-notes').readmore({
		beforeToggle: function() { $('.readmore-js-toggle').remove(); },
		maxHeight: 200,
	});


	var tagsokay = false;

	['series', 'characters'].forEach(function(item, index){
		$('#tags-'+item).tagit({
			animate:			false,
			caseSensitive:		false,
			allowDuplicates:	false,
			allowSpaces:		true,
			readOnly:			[user.user_id] !== [gallery.user_id],
			tagLimit:			20,
			singleField:		true,
			parentSelector:		'div',
			childSelector:		'a',
			fieldName:			'tags-'+item,

			autocomplete:		{
				delay:			250,
				minLength:		1,
				source:			'[afurl.base]/search/'+item,
			},

			afterTagAdded:		function(event, ui) {
				if (!tagsokay) return;
				$.post('[afurl.base]/gallery/set/'+item, {
					id:		[gallery.gallery_id;safe=json],
					text:	$('input[name="tags-'+item+'"]').val(),
				});
			},

			afterTagRemoved:	function(event, ui) {
				if (!tagsokay) return;
				$.post('[afurl.base]/gallery/set/'+item, {
					id:		[gallery.gallery_id;safe=json],
					text:	$('input[name="tags-'+item+'"]').val(),
				});
			},
		});
	});

	tagsokay = true;
});
</script>



<script>
[onshow;block=script;when [user.user_id]=[gallery.user_id]]
$(function(){

	$('.cpn-gallery-sortable').sortable({
		placeholder: 'cpn-thumb-link',
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



	$('.cpn-gallery-role-list').droplist().change(function(){
		$.post(
			'[afurl.base]/gallery/set/role',
			{id:[gallery.gallery_id], text:$(this).val()}
		);
	});


	$('#cpn-delete-gallery').click(function(){
		popup('[afurl.base]/gallery/remove?id=[gallery.gallery_id]', 'Delete Gallery?');
	});


	$('#file-gallery').fileupload({
		dataType: 'json'
	}).bind('fileuploadstart', function(e, data) {
		$('.cpn-gallery-image').attr('src', '[afurl.static]/img/loading.gif');
	}).bind('fileuploadalways', function(e, data) {
		if (data.result['200'] !== undefined  &&  data.result['200'].url !== undefined) {
			$('.cpn-gallery-image').attr('src', data.result['200'].url)
		}
	});

	$('.gallery-pic-upload').click(function(){
		$('#file-gallery').show().focus().click().hide();
	});


	$('.cpn-gallery-title h3').afClickEdit(
		'[afurl.base]/gallery/set/title', 'gallery-id'
	);


	$('.cpn-gallery-event').afClickEdit(
		'[afurl.base]/gallery/set/event', 'gallery-id'
	).next('input').autocomplete({
		source: '[afurl.base]/event/auto/attending',
		minLength: 1,
		select: function() { var that=this; setTimeout(function(){$(that).blur();}, 1); },
	});


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


	if (typeof afDropzone !== 'undefined') {
		afDropzone(
			'form.cpn-dropzone',
			[afurl.upload;safe=json],
			'#cpn-gallery-add-images'
		);
	}
});
</script>
