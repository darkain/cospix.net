<script>
[onshow;block=script;when [profile.edit]=1]
$(function(){
	$('img.cpn-tag-ungroup').click(function(e){
		e.preventDefault();
		e.stopPropagation();
		$.post(
			'[afurl.base]/tag/set/ungroup',
			{ id:$(this).data('label-id') },
			refresh
		);
	});

	$('img.cpn-tag-unlink').click(function(e){
		e.preventDefault();
		e.stopPropagation();
		$.post(
			'[afurl.base]/tag/set/unlink',
			{ id:$(this).data('label-id'), item:[group.group_id] },
			refresh
		);
	});

	$('img.cpn-tag-link').click(function(e){
		e.preventDefault();
		e.stopPropagation();
		$.post(
			'[afurl.base]/tag/set/link',
			{ id:$(this).data('label-id'), item:[group.group_id] },
			refresh
		);
	});

});
</script>
