<div class="largest center">
Are you sure you want to delete this article?
<br /><br />
<b>THERE IS NO UNDO!</b>

<br /><br />
<button id="btn-delete-article" style="padding:0.5em 2em">Delete</button>
<br /><br />
<button onclick="popdown()" style="font-size:2em;padding:0.5em 2em">Cancel</button>
</div>



<script>
$('#btn-delete-article').click(function(){
	$.post(
		'[afurl.base]/article/delete?id=[article.article_id]',
		refresh
	);
});
</script>