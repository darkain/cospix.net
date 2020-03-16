New Tag:
<input type="text" style="width:75%" id="cpn-group-tag-auto" />

<button id="cpn-group-tag-add">Add</button>

<script>
$(function(){
	$('#cpn-group-tag-auto').autocomplete({
		source: ('[afurl.base]/tag/autocomplete'),
		minLength: 1,
	});
});
</script>

<script>
[onshow;block=script;when [user.user_id]+-0]
$(function(){
	$('#cpn-group-tag-add').click(function(){
		$.post(
			'[afurl.base]/event/gatherings/tag/insert',
			{id:[gathering.gathering_id], text:$('#cpn-group-tag-auto').val()},
			refresh
		);
	});
});
</script>
