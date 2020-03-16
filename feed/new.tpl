<div class="cpn-ad-banner">[onshow;block=div;when [user.permission.adfree]=0]<ins class="adsbygoogle" data-ad-client="ca-pub-0556075448585716" data-ad-slot="5493739931"></ins></div>

<style>
article.cpn-default{vertical-align:top; font-size:20px;}
article.cpn-default *{vertical-align:top;}
</style>

<div style="width:990px; margin:auto">


	<aside style="float:right; width:300px">


		<div class="cpn-ad-block">
			[onshow;block=div;when [user.permission.adfree]=0]
			<ins class="adsbygoogle" data-ad-client="ca-pub-0556075448585716" data-ad-slot="4979146330"></ins>
		</div>


		<h1 class="cpn-header">Gallery Updates</h1>
		<section class="cpn-home-auto" style="margin-bottom:10px; background:#fff; padding:5px 5px 0 5px">
			[onload;file=costume/cosplay-feed.tpl]
			<div class="clear-left"></div>
		</section>


		<h1 class="cpn-header">Upcoming Conventions</h1>
		<div style="background:#fff; padding-top:5px">
			<div class="button" style="margin:0 15px 5px 15px" onclick="popup('[afurl.base]/event/suggest', $(this).text())">[onshow;block=div;when [user.user_id]+-0]Suggest A New Convention</div>
			<div style="padding:5px 5px 2px 5px">[onload;file=map/list.tpl]</div>
		</div>


		<h1 class="cpn-header" style="margin-top:10px">Facebook</h1>
		<div style="background:#fff" class="fb-like-box center" data-href="https://www.facebook.com/cospixnet" data-width="292" data-show-faces="true" data-header="false" data-stream="false" data-show-border="false"></div>


	</aside>


	<div class="cpn-activity-feed-list" style="width:670px; margin:0; float:left">
		<h1 class="cpn-header">Recent Updates</h1>

		<article class="cpn-default" style="width:100%">
			[onload;file=feed.tpl]

			<div class="cpn-feed-more">Load More</div>
			&nbsp;
		</article>
	</div>

</div>

<script>
$('.cpn-feed-more').click(function(){
	var time = $('.cpn-feed-item').last().data('time');
	$.get(
		'[afurl.base]/feed?from='+time,
		function(data) { $(data).insertBefore('.cpn-feed-more'); }
	)
});
</script>
