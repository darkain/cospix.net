<script>
$('.af-prefs-list input:checked').parent().addClass('enabled');

$('.af-prefs-list input:checkbox').change(function(){
	$(this).parent().toggleClass('enabled', $(this).prop('checked'));

	var name = $(this).attr('name');
	if (typeof name == 'undefined') return;
	name = name.replace('af-pref-', '');

	$.post(
		'[afurl.base]/settings/[router.part.2]/set/'+name,
		{ value: $(this).prop('checked') },
		afsave
	);
});


$('.af-prefs-list input:radio').change(function(){
	$(this).closest('ul').find('.enabled').removeClass('enabled');
	$(this).parent().toggleClass('enabled', $(this).prop('checked'));

	var name = $(this).attr('name');
	if (typeof name == 'undefined') return;
	name = name.replace('af-pref-', '');

	$.post(
		'[afurl.base]/settings/cospix/set/'+name,
		{ value: $(this).parent().text().trim().toLowerCase() },
		afsave
	);
});
</script>
