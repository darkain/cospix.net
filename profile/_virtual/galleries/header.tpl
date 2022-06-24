<div class="prometheus-tabs">
	<table class="cpn-folder">
		<tr>
			<td class="cpn-folder-selected">Galleries</td>
			<td>Uploaded</td>
			<td>Tagged</td>
			<td>Featured</td>
			<td>Favorites</td>
		</tr>
	</table>
</div>

<script>
$('.cpn-folder td').click(function(){
	$(this).closest('tr').find('.cpn-folder-selected').removeClass('cpn-folder-selected');
	$(this).addClass('cpn-folder-selected');

	var url = $(this).text().trim().toLowerCase();
	$.get('[afurl.base]/[profile.user_url;f=url]/galleries/'+url, {
		jq: 1,
	}, function(data) {
		var item = $('#cpn-profile-body div.cpn-discover');
		item.before(data);
		item.remove();
	});
});
</script>

<!--<style>#prometheus-filter{display:none;}</style>-->
