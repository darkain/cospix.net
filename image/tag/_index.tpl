<div style="font-size:20px; padding-bottom:5px">
	<input type="text" id="pop-tag-search" style="width:400px; font-size:20px; padding:0 5px; float:right" />
	<strong style="padding-top:3px; display:inline-block">Search for a tag to add to this image</strong><br/>
	<div class="clear"></div>
	<span class="small">Note: Tags on Costumes and Galleries will show up automatically on this image</span>
</div>

<script>
var tagsearch=false;
$(function(){
	$('#pop-tag-search').keyup(function(){
		if (tagsearch) clearTimeout(tagsearch);
		tagsearch = setTimeout(function(){
			$.post('[afurl.base]/image/tag/body',{
				hash: '[image.hash]',
				search: $('#pop-tag-search').val(),
			}, function(data){$('#pop-tag-out').html(data);});
		}, 250);
	}).keyup();
});
</script>

<div id="pop-tag-out"></div>
