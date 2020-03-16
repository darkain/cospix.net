<article class="cpn-default">
	<h1 class="cpn-header">Qusetions</h1>
<!--
	<table class="cpn-folder"><tr>
		<td class="cpn-costume-folder-selected">Answered</td>
		<td>Asked Others</td>
		<td>Pending</td>
	</tr></table>
-->
	<div class="cpn-default larger">
		<a href="[afurl.base]/[questions.user_url;ifempty=[questions.user_id]]" style="float:left; margin-right:5px">
			<img src="[questions.url;ifempty='[afurl.static]/thumb2/profile.svg']" alt="[questions.user_name]" style="width:100px;height:100px" />
		</a>

		<a href="[afurl.base]/[questions.user_url;ifempty=[questions.user_id]]">[questions.user_name;block=div]</a>: [questions.question_text]

		<div style="background:#eee; margin:5px 0px 5px 120px; padding:5px 10px">
			[questions.answer_text]
		</div>

		<div class="clear"></div>
	</div>
</article>


<script>
$(function(){
	$('.cpn-folder td').click(function(){
		$('.cpn-folder-selected').removeClass('cpn-folder-selected');
		$(this).addClass('cpn-folder-selected');

		var page = '';
		if ($(this).text().trim() == 'Answered') page = 'answered';
		if ($(this).text().trim() == 'Asked Others') page = 'asked';
		if ($(this).text().trim() == 'Pending') page = 'pending';

		$('#cpn-profile-body').load('[afurl.base]/profile/questions/[user.user_id]?jq=1&type='+page);
	});
});
</script>
