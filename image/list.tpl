<div class="cpn-image-edit" data-id="[photo.hash]" data-time="[photo.user_time]">
	<a href="[afurl.base]/image/[photo.hash]"><img src="[photo.img;block=div]" /></a>
	<button class="btn-add-gallery">Add To Gallery</button>
	<button class="btn-del-image">Remove Image</button>
	Used in <span>[photo.count]</span> place(s)
</div>
<div class="clear" id="image-clear"></div>

<script>
$('.btn-add-gallery').each(function(idx, item){
	$(item).removeClass('btn-add-gallery');
	$(item).click(function(){
		var id = $(this).closest('.cpn-image-edit').data('id');
		popup('[afurl.base]/image/add?hash='+id, $(this).text());
	});
});

$('.btn-del-image').each(function(idx, item){
	$(item).removeClass('btn-del-image');
	$(item).click(function(){
		var id = $(this).closest('.cpn-image-edit').data('id');
		popup('[afurl.base]/image/remove?hash='+id, 'Add Image to Gallery');
	});
});
</script>
