<img src="[image.img]" style="float:left;margin-right:10px" />

<div class="largest">Add this image to the following costumes and galleries</div>
<div class="clear" style="margin-bottom:10px"></div>


<section>
	<h2>Costumes</h2>
	<ul class="cpn-map-list">
		<li class="cpn-credit-add-to [costume.class]"><a>
			<input type="hidden" name="gallery[]" value="[costume.gallery_id]" />
			<img src="[costume.img;block=li;bmagnet=section]" />
			[costume.gallery_name;ifempty='Untitled [costume.gallery_type]']
		</a></li>
	</ul>
	<div class="clear"></div>
</section>


<section>
	<h2>Galleries</h2>
	<ul class="cpn-map-list">
		<li class="cpn-credit-add-to [gallery.class]"><a>
			<input type="hidden" name="gallery[]" value="[gallery.gallery_id]" />
			<img src="[gallery.img;block=li;bmagnet=section]" />
			[gallery.gallery_name;ifempty='Untitled [gallery.gallery_type]']
		</a></li>
	</ul>
	<div class="clear"></div>
</section>


<script>
var selected = $('.cpn-credit-add-selected').length;

$('.cpn-credit-add-to').click(function(){
	$(this).toggleClass('cpn-credit-add-selected');
});

popbuttons([{
	text:'Save Changes',
	click:function() {
		$.post(
			'[afurl.base]/image/save?hash=[image.hash]',
			$('.cpn-credit-add-selected').afSerialize(),
			function(){
				var x = $("div[data-id='[image.hash]'] span").text();
				x -= selected;
				x += $('.cpn-credit-add-selected').length;
				$("div[data-id='[image.hash]'] span").text(x)
				popdown();
			}
		);
	}
}], true);
</script>
