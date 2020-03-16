<style>
.cpn-image-edit {
	float:left;
	height:100px;
	width:232px;
	margin:5px;
	vertical-align:top;
	overflow:hidden;
}

.cpn-image-edit:hover {
	box-shadow:0 0 4px #00C8E6;
}

.cpn-image-edit a {
	text-decoration:none;
}

.cpn-image-edit img {
	width:100px;
	height:100px;
	float:left;
	margin-right:5px;
}

.cpn-image-edit button {
	text-align:center;
	width:120px;
}
</style>

<article class="cpn-default">
	<h1 class="cpn-header">My Photos</h1>
	<section class="cpn-default">
		[onload;file=list.tpl]
		<div class="cpn-feed-more">Load More[onshow;block=div;when [more.more]='1']</div>
	</section>
</article>

<script>
$('.cpn-feed-more').click(function(){
	var time = $('.cpn-image-edit').last().data('time');
	$.get(
		'[afurl.base]/image?jq=1&from='+time,
		function(data) {
			$('#image-clear').remove();
			$(data).insertBefore('.cpn-feed-more');
		}
	);
});
</script>
