<article class="cpn-default">
	<h1 class="cpn-header">Answer This Question</h1>
	<div class="cpn-default larger">
		<div style="width:49%;float:left">
			<b><a href="[afurl.base]/[sender.user_url;ifempty='[sender.user_id]']">[sender.user_name]</a> asked:</b><br />
			[ask.question_text]
		</div>

		<div style="width:49%;float:right" id="cpn-answer">
			<textarea style="width:100%;min-height:5em"></textarea>
			<button class="cpn-btn-default" style="float:right;margin-top:5px">Answer</button>
			<div class="clear"></div>
		</div>

		<div class="clear"></div>
	</div>
</article>

<script>
$('#cpn-answer button').click(function(){
	var text = $('#cpn-answer textarea').val().trim();
	if (text == '') return;

	$.post(
		'[afurl.base]/ask/answer?id=[ask.ask_id]',
		{ text: text },
		function(data) { $('#cpn-answer').html(data); }
	);
});
</script>
