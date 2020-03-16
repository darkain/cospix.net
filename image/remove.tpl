<img src="[image.img]" style="float:left;margin-right:10px" />

<div class="largest justify">
	Remove this image from all of YOUR costumes and YOUR galleries,
	and uncredit you from other's costumes and galleries in this image?
</div>
<div class="clear" style="margin-bottom:10px"></div>

<div class="center">
	<button style="font-size:2em;padding:1em 2em" onclick="popdown()">Cancel</button>
	<br /><br />
	<button id="btn-image-delete">Delete</button>
</div>

<script>
$('#btn-image-delete').click(function(){
	$.post('[afurl.base]/image/delete?hash=[image.hash]', function(){
		$("div[data-id='[image.hash]']").remove();
		popdown();
	});
});
</script>
