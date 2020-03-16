<img src="[image.img]" style="float:left;margin-right:10px" />

<div class="largest">Credit people in this image</div>

<div style="margin-top:30px">
	Filter:
	<input type="text" id="cpn-user-credit-filter" style="width:200px" />
	<input type="hidden" id="cpn-add-credits"/>
</div>

<div class="clear" style="margin-bottom:10px"></div>

<div id="add-credit-list"></div>

<div class="clear"></div>

<script>
popbuttons([{
	text:'Credit Users',
	click:function() {
		$.post(
			'[afurl.base]/image/credits', {
				hash:'[image.hash]',
				selected:$('#cpn-add-credits').val(),
			}, popupdate
		);
	}
}], true);


//TODO: MOVE THIS INTO A STANDARDIZED LIBRARY!
var last_search = false;
</script>

[onload;file=search/credit-filter.tpl]
