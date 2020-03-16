<div style="background:#fff">
	<div class="cpn-default">
		<button class="cpn-button" id="btn-new-article">Create New Checklist</button>
	</div>
</div>

<div id="checklist-body">[data;safe=no]</div>

<script>$(function(){
checksubmit = function(that) {
	$.post(
		'[afurl.base]/checklist/set',
		$(that).closest('.checklist-parent').afSerialize(),
		function(data){
			console.log(data);
		}
	);
}


$('#btn-new-article').click(function(){
	$.post(
		'[afurl.base]/checklist/insert', {
			id:		'[object.id]',
			type:	'[object.type]',
		}, refresh
	);
});

$('.checklist-text').afClickEdit(function(){checksubmit(this);});
$('#checklist-body h1').afClickEdit(function(){checksubmit(this);});
$('#checklist-body :checkbox').change(function(){checksubmit(this);});

$('.checklist-add button').click(function(){
	$.post(
		'[afurl.base]/checklist/append', {
			id: $(this).closest('.checklist-parent').data('id'),
		}, refresh
	);
});

$('.checklist-delete').click(function(){
	$.post(
		'[afurl.base]/checklist/remove', {
			id:		$(this).closest('.checklist-parent').data('id'),
			item:	$(this).data('item'),
		}, refresh
	);
});

$('.checklist-remove').click(function(){
	if (!confirm('Are you SURE you want to remove this entire checklist?')) return;
	$.post(
		'[afurl.base]/checklist/delete', {
			id:		$(this).closest('.checklist-parent').data('id'),
			item:	$(this).data('item'),
		}, refresh
	);
});

});</script>
