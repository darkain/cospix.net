<ul class="cpn-map-list" id="select-tutorial">
	<li data-id="[tutorial.article_id]"><a>
		<img src="[tutorial.img;noerr;ifempty='[afurl.static]/thumb2/tutorial.svg']" alt="[tutorial.article_title]" />
		<strong>[tutorial.article_title;block=li]</strong>
	</a></li>
</ul>

<div class="clear"></div>


<style>
#select-tutorial li {
	width:370px;
	float:left;
	margin-right:5px;
}
</style>


<script>
$('#select-tutorial li').click(function(){
	$.post(
		'[afurl.base]/gallery/tutorial/insert',
		{id:[gallery.gallery_id], item:$(this).data('id')},
		refresh
	);
});
</script>
