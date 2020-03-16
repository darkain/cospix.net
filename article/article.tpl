<article class="cpn-article" itemscope itemtype="http://schema.org/Article">
	<div class="cpn-header" style="height:40px">
		<div class="cpn-more">
			[onshow;block=div;when [user.user_id]=[article.user_id]]
			<div class="cpn-more-content">
				<a href="[afurl.base]/article/edit?id=[article.article_id]">Edit Article</a>
				<a onclick="popup('[afurl.base]/article/type?id=[article.article_id]', 'Change Article Type')">Change Article Type</a>
				<a onclick="popup('[afurl.base]/article/remove?id=[article.article_id]', 'Edit Article')">Delete Article</a>
			</div>
		</div>

		<a href="[afurl.base]/[article.user_url;ifempty=[article.user_id]]"><img src="[article.img]" title="[article.user_name]" alt="[article.user_name]" /></a>
		<span>
			<i><a href="[afurl.base]/[article.user_url;ifempty=[article.user_id]]">[article.user_name]</a></i>
			<i>[article.article_timestamp;date='F jS, Y \a\t g:i A']</i>
		</span>
		<h3 itemprop="name"><a itemprop="url" href="[afurl.base]/article/[article.article_id;block=article]">[article.article_title;ifempty='[article.youtube_title;noerr]']</a></h3>
	</div>
	<div class="cpn-article-text" itemprop="articleBody">
		<iframe width="820" height="461" src="//www.youtube.com/embed/[article.youtube_id;magnet=iframe;noerr]?rel=0" style="border:0; position:relative;margin:-10px 0 0 -10px" allowfullscreen></iframe>
		<div>[article.article_text;safe=no]</div>
		<div>[article.youtube_description;noerr]</div>
	</div>
</article>
