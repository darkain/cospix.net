<div style="background:#fff;color:#00C8E6;position:absolute;left:0;right:0;top:0;height:20px; padding:12px 15px 0 15px; font-size:20px;line-height:10px" id="cpn-select-header">
	<img src="[afurl.static]/glyph/close.png" style="float:right; height:100%; cursor:pointer" />
	<a href="" style="text-decoration:none">Select a Gallery</a>
	<span></span>
	<span></span>
</div>

<div id="cpn-select-gallery" style="position:absolute;left:0;right:0;top:50px">
	<a href="/" class="cpn-thumb-link" data-id="[g.gallery_id]"><figure>
		<img src="[g.img]" />
		<figcaption>[g.gallery_name;ifempty='Untitled Gallery';block=a]</figcaption>
	</figure></a>
	<div class="clear"></div>
</div>

<div id="cpn-select-item" class="cpn-vote-select-body"></div>
<div id="cpn-select-image" class="cpn-vote-select-body"></div>

<script>
$('#cpn-select-gallery a').click(function(e){
	e.preventDefault();
	e.stopPropagation();
	$('#cpn-select-gallery').hide('slide', {direction:'left'}, 750);
	$('#cpn-select-item').show('slide', {direction:'right'}, 750);

	var txt = '<a href="" style="text-decoration:none">&raquo; ' + $(this).find('figcaption').text() + '</a>';
	$('#cpn-select-header span:first').html(
		$(txt).click(function(e){
			e.preventDefault();
			e.stopPropagation();
			$('#cpn-select-item').show('slide', {direction:'left'}, 750);
			$('#cpn-select-image').hide('slide', {direction:'right'}, 750);
			$('#cpn-select-header span:last').html('');
		})
	);

	var id = $(this).data('id');
	$('#cpn-select-item').load('[afurl.base]/image/select/gallery?id='+id, function(){
		$('#cpn-select-item a').click(function(e){
			e.preventDefault();
			e.stopPropagation();
			$('#cpn-select-item').hide('slide', {direction:'left'}, 750);
			$('#cpn-select-image').show('slide', {direction:'right'}, 750);

			var id = $(this).data('id');
			$('#cpn-select-image').load('[afurl.base]/image/select/image?id='+id);
		});
	});
});


$('#cpn-select-header a').click(function(e){
	e.preventDefault();
	e.stopPropagation();
	$('#cpn-select-gallery').show('slide', {direction:'left'}, 750);
	$('#cpn-select-item').hide('slide', {direction:'right'}, 750);
	$('#cpn-select-image').hide('slide', {direction:'right'}, 750);
	$('#cpn-select-header span').html('');
})

$('#cpn-select-header img').click(function(){
	$(this).closest('.ui-dialog-content').dialog('close');
});
</script>
