<ul class="cpn-map-list">
	<li style="float:left; width:49%" data-id="[tag.group_label_id;block=li]"><a>
		<img src="[tag.img;noerr;ifempty='[afurl.static]/thumb2/[tag.group_type_name;ifempty=blank].svg']" alt="[tag.group_label]" />
		<strong>[tag.group_label]</strong>
		<em>[tag.group_type_name]</em>
	</a></li>
</ul>

<script>
$(function(){
	$('#pop-tag-out a').click(function(){
		$.post('[afurl.base]/image/tag/insert',{
			hash:	'[image.hash]',
			id:		$(this).closest('li').data('id'),
		},refresh);
	});
});
</script>
