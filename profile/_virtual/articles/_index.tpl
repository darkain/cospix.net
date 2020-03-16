<div style="background:#fff">
	<div class="cpn-default">
		<a href="[afurl.base]/article/new" id="btn-new-article">
			[onshow;block=a;when [user.user_id]=[user.user_id]]
			Write A New Article
		</a>
		<table class="cpn-folder" style="margin:0"><tr>
			<td [onshow;block=td;when '[user.article_type;noerr]'=''] class="cpn-folder-selected">All</td>
			<td [onshow;block=td;when '[user.article_type;noerr]'!='']>All</td>
			<td [onshow;block=td;when '[user.article_type;noerr]'='article'] class="cpn-folder-selected">Blog</td>
			<td [onshow;block=td;when '[user.article_type;noerr]'!='article']>Blog</td>
			<td [onshow;block=td;when '[user.article_type;noerr]'='tutorial'] class="cpn-folder-selected">Tutorials</td>
			<td [onshow;block=td;when '[user.article_type;noerr]'!='tutorial']>Tutorials</td>
			<td [onshow;block=td;when '[user.article_type;noerr]'='conreport'] class="cpn-folder-selected">Con Reports</td>
			<td [onshow;block=td;when '[user.article_type;noerr]'!='conreport']>Con Reports</td>
			<td [onshow;block=td;when '[user.article_type;noerr]'='productreview'] class="cpn-folder-selected">Product Reviews</td>
			<td [onshow;block=td;when '[user.article_type;noerr]'!='productreview']>Product Reviews</td>
		</tr></table>
	</div>
</div>


<script>
$(function(){
	$('.cpn-folder td').click(function(){
		$('.cpn-folder-selected').removeClass('cpn-folder-selected');
		$(this).addClass('cpn-folder-selected');

		var page = '';
		if ($(this).text().trim() == 'Blog') page = 'article';
		if ($(this).text().trim() == 'Tutorials') page = 'tutorial';
		if ($(this).text().trim() == 'Con Reports') page = 'conreport';
		if ($(this).text().trim() == 'Product Reviews') page = 'productreview';

		$('#cpn-profile-body').load('[afurl.base]/profile/articles/[user.user_id]?jq=1&type='+page);
	});
});
</script>


[onload;file=article/article.tpl]
