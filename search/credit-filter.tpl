<script>
user_credit_filter = function() {
	var search = $('#cpn-user-credit-filter').val();
	if (last_search === search) return;
	last_search = search;
	$.post(
		'[afurl.base]/search/credit', {
			term:search,
			id:'[team.user_id]',
			selected:$('#cpn-add-credits').val(),
		}, function(data){ $('#add-credit-list').html(data); }
	);
}

$('#cpn-user-credit-filter').keyup(user_credit_filter).change(user_credit_filter);

$(user_credit_filter);
</script>
