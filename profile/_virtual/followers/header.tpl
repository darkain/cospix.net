<div class="prometheus-tabs">
	<table class="cpn-folder">
		<tr>
			<td class="cpn-folder-selected">Friends</td>
			<td>Followers</td>
			<td>Following</td>
		</tr>
	</table>
</div>

<script>
$('.cpn-folder td').click(function(){
	$(this).closest('tr').find('.cpn-folder-selected').removeClass('cpn-folder-selected');
	$(this).addClass('cpn-folder-selected');

	var url = $(this).text().trim().toLowerCase();
	$.get('[afurl.base]/[profile.user_url;f=url]/followers/'+url, function(data) {
		var item = $('#cpn-profile-body div.cpn-discover');
		item.before(data);
		item.remove();
	});
});
</script>
