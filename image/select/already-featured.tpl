<div style="background:#fff;color:#00C8E6;position:absolute;left:0;right:0;top:0;height:20px; padding:12px 15px 0 15px; font-size:20px;line-height:10px" id="cpn-select-header">
	<img src="[afurl.static]/glyph/close.png" style="float:right; height:100%; cursor:pointer" />
</div>

<div class="center largest cpn-vote-select-body">
	WAT, F00, YOU IS ALREADY GOT TEH FEATURE THIS WEEK!
	<br/><br/><br/>
	<button class="cpn-button" style="padding:20px 30px">CLOSE</button>
</div>

<script>
$('#cpn-select-header img').click(function(){
	$(this).closest('.ui-dialog-content').dialog('close');
});

$('.cpn-vote-select-body button').click(function(){
	$(this).closest('.ui-dialog-content').dialog('close');
});
</script>
