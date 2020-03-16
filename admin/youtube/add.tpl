<main class="cpn-default">
	<h1 class="cpn-header">[af.title]</h1>

	<div class="cpn-default larger" id="cpn-yt-submit">
		Paste in YouTube URLs for cosplay or photography related tutorials.
		The Cospix web site will pull all needed information automatically
		and build the tutorial pages for you. The system actively tests for
		double-posts, so there is no need to worry if we already have a
		particular video tutorial or not! You may paste in multiple URLs at
		once, too.<br /><br />
		<textarea style="width:100%;height:200px"></textarea>
		<button class="cpn-button" style="width:100%;height:2em;font-size:1.5em">Add YouTube URLs to Cospix</button>
	</div>
</main>

<script>
$('#cpn-yt-submit button').click(function(){
	$.post('[afurl.base]/admin/youtube/insert', {
		links: $('#cpn-yt-submit textarea').val(),
	}, function(data){
		alert(data);
	});
});
</script>
