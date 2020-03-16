<div class="largest">Add members to your team</div>

<div style="margin-top:30px">
	Filter:
	<input type="text" id="cpn-user-credit-filter" style="width:200px" />
	<input type="hidden" id="cpn-add-credits"/>
</div>

<div class="clear" style="margin-bottom:10px"></div>

<div id="add-credit-list"></div>

<div class="clear"></div>

<script>
poptitle('Add members to your team');

popbuttons([{
	text:'Add Users',
	click:function() {
		$.post(
			'[afurl.base]/team/members/insert', {
				id:'[team.user_id]',
				selected:$('#cpn-add-credits').val(),
			}, refresh
		);
	}
}], true);

//TODO: MOVE THIS INTO A STANDARDIZED LIBRARY!
var last_search = false;
</script>

[onload;file=search/credit-filter.tpl]
