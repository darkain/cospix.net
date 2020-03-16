<div data-id="[users.user_id]">
	[onshow;att=class;attadd;if [users.user_time]+-0;then 'cpn-user-credit-disabled';else 'cpn-user-credit']
	[onshow;att=class;attadd;if [users.selected]=1;then 'cpn-user-credit-active']
	<input type="hidden" name="userid[]" value="[users.user_id]" />
	<img src="[users.img;ifempty='[afurl.static]/thumb2/profile.svg']" alt="[users.user_name;block=div]" />
	[users.user_name]
</div>
<div class="clear"></div>

<script>
$(function(){
	$('.cpn-user-credit').click(function(){
		$(this).toggleClass('cpn-user-credit-active');
		var val	= $('#cpn-add-credits').val();
		var id	= $(this).data('id');
		if ($(this).hasClass('cpn-user-credit-active')) {
			$('#cpn-add-credits').val(val+','+id);
		} else {
			$('#cpn-add-credits').val(val.replace(','+id, ''));
		}
	});
});
</script>
